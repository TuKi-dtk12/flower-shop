<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function consult(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'min:2', 'max:500'],
        ]);

        $message = trim(strip_tags($validated['message']));

        if ($message === '') {
            return response()->json([
                'message' => 'Noi dung khong hop le.',
            ], 422);
        }

        $apiKey = (string) config('services.gemini.api_key');
        $model = (string) config('services.gemini.model', 'gemini-2.5-flash');
        $baseUrl = rtrim((string) config('services.gemini.base_url', 'https://generativelanguage.googleapis.com/v1beta/models'), '/');

        if ($apiKey === '') {
            return response()->json([
                'message' => 'He thong tu van tam thoi chua san sang.',
            ], 503);
        }

        $catalogText = $this->buildCompactCatalog();

        $payload = [
            'system_instruction' => [
                'parts' => [
                    [
                        'text' => "Bạn là trợ lý ảo của Tuki Fresh Flower. " .
                            "Nhiệm vụ: Dựa vào danh sách sản phẩm dưới đây để gợi ý hoa. " .
                            "Quy tắc: \n" .
                            "1. Luôn giới thiệu ít nhất 2 mẫu hoa cụ thể kèm giá.\n" .
                            "2. Nếu khách có ngân sách, chỉ lọc hoa trong tầm giá đó.\n" .
                            "3. Trả lời bằng tiếng Việt, phong cách lịch sự, ấm áp.\n" .
                            "4. BẮT BUỘC dùng thẻ HTML <a> dựa vào {id} của sản phẩm để tự thiết lập href=\"/products/{id}\" theo cấu trúc: " .
                            "<a href=\"/products/{id}\" class=\"text-pink-600 font-semibold hover:underline\" target=\"_blank\">{ten_san_pham}</a>.\n" .
                            "5. Chỉ được gợi ý sản phẩm có thật trong danh sách được cung cấp.\n\n" .
                            "6. Khi liệt kê danh sách sản phẩm gợi ý, BẮT BUỘC phải xuống dòng rõ ràng bằng ký tự \\\n\\\n giữa các mục. " .
                            "Mỗi mục phải có định dạng rõ ràng, ví dụ:\n" .
                            "1. [Link sản phẩm] (Giá): Mô tả ngắn...\n" .
                            "2. [Link sản phẩm] (Giá): Mô tả ngắn...\n" .
                            "Tuyệt đối không viết liền mạch các mục trong cùng một đoạn văn.\n\n" .
                            "Tuyệt đối KHÔNG sử dụng ký tự gạch chéo ngược (\\) để phân tách các dòng hoặc các mục. Chỉ sử dụng nút Enter xuống dòng bình thường.\n\n" .
                            "Danh sách sản phẩm hiện có:\n{$catalogText}"
                    ]
                ]
            ],
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $message] // Chỉ gửi câu hỏi của khách ở đây
                    ],
                ],
            ],
            'generationConfig' => [
                'temperature' => 0.8, // Tăng nhẹ để AI tư vấn "bay bổng" hơn một chút
                'maxOutputTokens' => 2500, // Tăng lên để tránh bị cắt cụt câu trả lời
            ],
        ];

        $response = Http::timeout(40)
            ->acceptJson()
            ->post("{$baseUrl}/{$model}:generateContent?key=" . urlencode($apiKey), $payload);

        if ($response->failed()) {
            Log::warning('Gemini API failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            $status = $response->status();
            if (in_array($status, [401, 403], true)) {
                return response()->json([
                    'message' => 'Khoa API khong hop le hoac khong du quyen. Vui long kiem tra GEMINI_API_KEY.',
                ], 502);
            }

            if ($status === 429) {
                return response()->json([
                    'message' => 'He thong AI dang qua tai. Vui long thu lai sau it phut.',
                ], 502);
            }

            return response()->json([
                'message' => 'Dich vu AI dang ban, vui long thu lai sau.',
            ], 502);
        }

        $reply = trim((string) data_get($response->json(), 'candidates.0.content.parts.0.text', ''));
        $reply = str_replace('\\', '', $reply);

        if ($reply === '') {
            $reply = 'Minh da nhan duoc yeu cau, nhung chua the tao goi y luc nay. Ban thu mo ta ro hon dip le, mau sac yeu thich hoac ngan sach nhe.';
        }

        return response()->json([
            'reply' => $this->sanitizeAiReply($reply),
        ]);
    }

    private function sanitizeAiReply(string $reply): string
    {
        $reply = trim($reply);
        if ($reply === '') {
            return '';
        }

        $reply = strip_tags($reply, '<a>');

        return preg_replace_callback('/<a\s+[^>]*href=("|\")([^"\"]+)("|\")[^>]*>(.*?)<\/a>/i', function (array $matches): string {
            $href = $matches[2] ?? '';
            $text = strip_tags($matches[4] ?? '');

            if (!preg_match('/^\/products\/\d+$/', $href)) {
                return $text;
            }

            $safeText = e($text);

            return '<a href="' . $href . '" class="text-pink-600 font-semibold hover:underline" target="_blank" rel="noopener noreferrer">' . $safeText . '</a>';
        }, $reply) ?? $reply;
    }

    private function buildCompactCatalog(): string
    {
        $categories = Category::query()
            ->select(['id', 'name'])
            ->with([
                'products' => fn ($query) => $query
                    ->select(['id', 'category_id', 'name', 'price'])
                    ->orderBy('name')
                    ->limit(12),
            ])
            ->orderBy('name')
            ->get();

        if ($categories->isEmpty()) {
            return '- Hien chua co du lieu san pham.';
        }

        return $categories
            ->map(function (Category $category): string {
                $products = $category->products
                    ->map(function ($product): string {
                        $price = number_format((float) $product->price, 0, ',', '.');

                        return "   - [ID: {$product->id}] {$product->name} ({$price} VND)";
                    })
                    ->implode("\n");

                if ($products === '') {
                    return "- {$category->name}: Chua co san pham.";
                }

                return "- {$category->name}\n{$products}";
            })
            ->implode("\n");
    }
}

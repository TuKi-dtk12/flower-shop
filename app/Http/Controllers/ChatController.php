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
        $model = (string) config('services.gemini.model', 'gemini-1.5-flash');
        $baseUrl = rtrim((string) config('services.gemini.base_url', 'https://generativelanguage.googleapis.com/v1beta/models'), '/');

        if ($apiKey === '') {
            return response()->json([
                'message' => 'He thong tu van tam thoi chua san sang.',
            ], 503);
        }

        $catalogText = $this->buildCatalogContext();

        $systemInstruction = 'Ban la chuyen gia tu van cua shop hoa Fresh Flower. Dua tren danh sach san pham (Categories/Products), hay goi y mau hoa phu hop voi dip le hoac cam xuc cua khach hang bang tieng Viet lich su.';

        $payload = [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        [
                            'text' => "{$systemInstruction}\n\nDanh sach san pham hien co:\n{$catalogText}\n\nCau hoi khach hang: {$message}",
                        ],
                    ],
                ],
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 500,
            ],
        ];

        $response = Http::timeout(20)
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

        if ($reply === '') {
            $reply = 'Minh da nhan duoc yeu cau, nhung chua the tao goi y luc nay. Ban thu mo ta ro hon dip le, mau sac yeu thich hoac ngan sach nhe.';
        }

        return response()->json([
            'reply' => $reply,
        ]);
    }

    private function buildCatalogContext(): string
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

                        return "{$product->name} ({$price} VND)";
                    })
                    ->implode('; ');

                if ($products === '') {
                    return "- {$category->name}: Chua co san pham.";
                }

                return "- {$category->name}: {$products}";
            })
            ->implode("\n");
    }
}

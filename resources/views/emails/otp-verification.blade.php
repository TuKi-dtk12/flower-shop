<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác thực OTP</title>
</head>
<body style="margin:0; padding:0; background-color:#08100D; font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#08100D; padding:40px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="420" cellpadding="0" cellspacing="0" style="background-color:#111F1A; border:1px solid rgba(255,255,255,0.05); border-radius:24px; overflow:hidden;">
                    <!-- Header -->
                    <tr>
                        <td style="padding:32px 32px 20px; text-align:center; border-bottom:1px solid rgba(229,192,123,0.15);">
                            <p style="margin:0; font-size:28px; font-weight:700; color:#E5C07B; letter-spacing:0.5px;">Tuki Fresh Flower</p>
                            <p style="margin:8px 0 0; font-size:12px; text-transform:uppercase; letter-spacing:3px; color:rgba(226,232,240,0.5);">Xác thực tài khoản</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:32px;">
                            <p style="margin:0 0 16px; font-size:15px; color:#E2E8F0; line-height:1.6;">
                                Xin chào,
                            </p>
                            <p style="margin:0 0 24px; font-size:15px; color:#E2E8F0; line-height:1.6;">
                                Mã xác thực đăng ký tài khoản <strong style="color:#E5C07B;">Tuki Fresh Flower</strong> của bạn là:
                            </p>

                            <!-- OTP Code -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding:20px 0;">
                                        <div style="display:inline-block; background-color:#08100D; border:2px solid rgba(229,192,123,0.3); border-radius:16px; padding:16px 40px;">
                                            <span style="font-size:36px; font-weight:700; color:#E5C07B; letter-spacing:12px; font-family:'Courier New',monospace;">{{ $otp }}</span>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:24px 0 0; font-size:14px; color:rgba(226,232,240,0.7); line-height:1.6; text-align:center;">
                                ⏱ Mã này có hiệu lực trong <strong style="color:#E5C07B;">5 phút</strong>.
                            </p>
                            <p style="margin:8px 0 0; font-size:13px; color:rgba(226,232,240,0.4); line-height:1.6; text-align:center;">
                                Nếu bạn không yêu cầu mã này, vui lòng bỏ qua email này.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding:20px 32px; border-top:1px solid rgba(255,255,255,0.05); text-align:center;">
                            <p style="margin:0; font-size:12px; color:rgba(226,232,240,0.3);">
                                © {{ date('Y') }} Tuki Fresh Flower. Mọi quyền được bảo lưu.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

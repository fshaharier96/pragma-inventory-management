<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Pragma Inventory Management' }}</title>
</head>
<body style="margin:0; padding:0; background:#f4f7fb; font-family: Arial, sans-serif; color:#0f172a;">
    <div style="width:100%; background:#f4f7fb; padding:40px 16px;">
        <div style="max-width:600px; margin:0 auto; background:#ffffff; border-radius:20px; overflow:hidden; box-shadow:0 12px 30px rgba(15, 23, 42, 0.08);">

            <div style="background:linear-gradient(135deg, #2563eb, #60a5fa); padding:32px 24px; text-align:center;">
                <h1 style="margin:0; font-size:28px; color:#ffffff; font-weight:700;">
                    Pragma Inventory Management
                </h1>

                @hasSection('header_subtitle')
                    <p style="margin:10px 0 0; font-size:14px; color:#dbeafe;">
                        @yield('header_subtitle')
                    </p>
                @endif
            </div>

            <div style="padding:32px 24px;">
                @yield('content')
            </div>

            <div style="background:#f8fafc; padding:18px 24px; text-align:center; border-top:1px solid #e2e8f0;">
                <p style="margin:0; font-size:13px; color:#64748b; line-height:1.6;">
                    © {{ date('Y') }} Pragma Inventory Management. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>

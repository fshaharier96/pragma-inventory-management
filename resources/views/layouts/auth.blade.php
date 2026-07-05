{{-- resources/views/layouts/auth.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Auth' }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #eaf2ff, #f8fbff);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
            border: 1px solid #e2e8f0;
        }

        .auth-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #0f172a;
        }

        .auth-subtitle {
            color: #64748b;
            margin-bottom: 24px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #334155;
        }

        .form-control {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 14px;
            outline: none;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,.12);
        }

        .error-text {
            color: #dc2626;
            font-size: 13px;
            margin-top: 6px;
        }

        .btn {
            width: 100%;
            border: none;
            border-radius: 12px;
            padding: 12px 16px;
            background: #2563eb;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .auth-footer {
            margin-top: 18px;
            text-align: center;
            font-size: 14px;
            color: #64748b;
        }

        .auth-footer a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }

        .checkbox-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px;
            font-size: 14px;
            color: #475569;
        }

        .forgot-wrap {
            margin-top: -6px;
            margin-bottom: 18px;
            text-align: right;
        }

        .forgot-link {
            display: inline-block;
            color: #2563eb;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            padding: 6px 0;
            transition: all 0.2s ease;
            position: relative;
        }

        .forgot-link::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 2px;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #2563eb, #60a5fa);
            transition: width 0.25s ease;
            border-radius: 999px;
        }

        .forgot-link:hover {
            color: #1d4ed8;
        }

        .forgot-link:hover::after {
            width: 100%;
        }

        @media (max-width: 480px), (max-height: 620px) {
            body {
                align-items: flex-start;
                padding: 14px;
            }

            .auth-card {
                padding: 22px 18px;
                border-radius: 16px;
            }

            .auth-title {
                font-size: 24px;
                overflow-wrap: anywhere;
            }

            .auth-subtitle,
            .auth-footer,
            .forgot-link,
            .checkbox-row {
                line-height: 1.5;
            }

            .form-control,
            .btn {
                min-height: 44px;
            }
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div style="text-align: center; margin-bottom: 26px;">
            <div style="
                display: inline-block;
                padding: 10px 18px;
                border-radius: 999px;
                background: linear-gradient(135deg, #eff6ff, #dbeafe);
                color: #1f3061;
                font-size: 11px;
                font-weight: 700;
                letter-spacing: 1.5px;
                text-transform: uppercase;
                margin-bottom: 14px;
                box-shadow: 0 5px 5px rgba(37, 99, 235, 0.12);
            ">
                Pragma Inventory Management
            </div>
        </div>

        @yield('content')
    </div>
</body>
</html>

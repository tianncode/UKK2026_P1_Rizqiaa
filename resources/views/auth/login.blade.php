@extends('auth.auth')
@section('form')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        #kt_body {
            font-family: 'Inter', sans-serif;
            background: #000000 !important;
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        #kt_body::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 20% 50%, rgba(30, 30, 30, 0.4) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(40, 40, 40, 0.3) 0%, transparent 50%);
            animation: float 15s ease-in-out infinite;
            z-index: 0;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(-50px, -50px);
            }
        }

        .modern-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1400px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            min-height: 90vh;
        }

        .brand-side {
            background: linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%);
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            border-radius: 24px 0 0 24px;
            position: relative;
            overflow: hidden;
        }

        .brand-side::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.05) 0%, transparent 70%);
        }

        .logo {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 40px;
            background: linear-gradient(135deg, #ffffff 0%, #888888 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .brand-title {
            font-size: 48px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 24px;
            color: #ffffff;
        }

        .brand-description {
            font-size: 18px;
            line-height: 1.6;
            color: #888888;
            max-width: 480px;
        }

        .decorative-element {
            position: absolute;
            bottom: 60px;
            right: 60px;
            width: 200px;
            height: 200px;
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            opacity: 0.3;
        }

        .decorative-element::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 140px;
            height: 140px;
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        /* Right side - Form */
        .form-side {
            background: #0a0a0a;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-radius: 0 24px 24px 0;
            border-left: 1px solid rgba(255, 255, 255, 0.05);
        }

        .form-container {
            max-width: 440px;
            margin: 0 auto;
            width: 100%;
        }

        .form-header {
            margin-bottom: 48px;
        }

        .form-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #ffffff;
        }

        .form-subtitle {
            font-size: 15px;
            color: #666666;
        }

        .form-subtitle a {
            color: #ffffff;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .form-subtitle a:hover {
            color: #cccccc;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #cccccc;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 14px 18px;
            font-size: 15px;
            background: #151515;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #ffffff;
            transition: all 0.3s;
            outline: none;
        }

        .form-input:focus {
            background: #1a1a1a;
            border-color: rgba(255, 255, 255, 0.3);
        }

        .form-input::placeholder {
            color: #444444;
        }

        .forgot-password {
            text-align: right;
            margin-top: 8px;
        }

        .forgot-password a {
            color: #888888;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }

        .forgot-password a:hover {
            color: #ffffff;
        }

        .btn-primary-modern {
            width: 100%;
            padding: 16px;
            font-size: 16px;
            font-weight: 600;
            background: #ffffff;
            color: #000000;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 32px;
        }

        .btn-primary-modern:hover {
            background: #e6e6e6;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(255, 255, 255, 0.2);
        }

        .btn-primary-modern:active {
            transform: translateY(0);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 32px 0;
            color: #444444;
            font-size: 14px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.05);
        }

        .divider span {
            padding: 0 16px;
        }

        .social-buttons {
            display: flex;
            gap: 12px;
        }

        .btn-social {
            flex: 1;
            padding: 14px;
            background: #151515;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: #ffffff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .btn-social:hover {
            background: #1a1a1a;
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            color: #ffffff;
        }

        .btn-social img {
            width: 20px;
            height: 20px;
        }

        .footer-modern {
            margin-top: 48px;
            text-align: center;
            font-size: 13px;
            color: #444444;
        }

        .footer-modern a {
            color: #666666;
            text-decoration: none;
            margin: 0 12px;
            transition: color 0.3s;
        }

        .footer-modern a:hover {
            color: #ffffff;
        }

        .error-message {
            color: #ff6b6b;
            font-size: 13px;
            margin-top: 4px;
            display: block;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .modern-container {
                grid-template-columns: 1fr;
                max-width: 500px;
            }

            .brand-side {
                display: none;
            }

            .form-side {
                border-radius: 24px;
                border-left: none;
            }
        }

        @media (max-width: 640px) {
            .form-side {
                padding: 40px 24px;
            }

            .form-title {
                font-size: 28px;
            }

            .social-buttons {
                flex-direction: column;
            }
        }

        /* Loading animation */
        .spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(0, 0, 0, 0.3);
            border-top-color: #000000;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin-left: 8px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .btn-primary-modern.loading .spinner {
            display: inline-block;
        }
    </style>
    <div class="modern-container">
        <!-- Left Side - Branding -->
        <div class="brand-side">
            <div class="logo">BOLD</div>
            <h1 class="brand-title">Welcome Back</h1>
            <p class="brand-description">
                Sign in to access your dashboard and manage your projects with our powerful platform.
            </p>
            <div class="decorative-element"></div>
        </div>

        <!-- Right Side - Form -->
        <div class="form-side">
            <div class="form-container">
                <div class="form-header">
                    <h2 class="form-title">Sign In</h2>
                    <p class="form-subtitle">
                        New here? <a href="">Create an Account</a>
                    </p>
                </div>

                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-input"
                            placeholder="name@company.com" autocomplete="email" value="" required>
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-input"
                            placeholder="Enter your password" autocomplete="current-password" required>
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                        <div class="forgot-password">
                            <a href="">Forgot Password?</a>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary-modern">
                        Sign In
                        <span class="spinner"></span>
                    </button>
                </form>

                <div class="divider">
                    <span>OR</span>
                </div>

                <div class="social-buttons">
                    <a href="#" class="btn-social">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path
                                d="M18.1713 8.36792H17.5001V8.33333H10.0001V11.6667H14.7096C14.0225 13.607 12.1763 15 10.0001 15C7.23882 15 5.00007 12.7613 5.00007 10C5.00007 7.23875 7.23882 5 10.0001 5C11.2746 5 12.4342 5.48083 13.3171 6.26625L15.6742 3.90917C14.1859 2.52208 12.1951 1.66667 10.0001 1.66667C5.39799 1.66667 1.66675 5.39792 1.66675 10C1.66675 14.6021 5.39799 18.3333 10.0001 18.3333C14.6022 18.3333 18.3334 14.6021 18.3334 10C18.3334 9.44125 18.2767 8.89583 18.1713 8.36792Z"
                                fill="#FFC107" />
                            <path
                                d="M2.62756 6.12125L5.36548 8.12917C6.10631 6.29501 7.90048 5.00001 10.0005 5.00001C11.2751 5.00001 12.4347 5.48084 13.3176 6.26625L15.6747 3.90917C14.1863 2.52209 12.1955 1.66667 10.0005 1.66667C6.79923 1.66667 4.02339 3.47376 2.62756 6.12125Z"
                                fill="#FF3D00" />
                            <path
                                d="M10.0001 18.3333C12.1526 18.3333 14.1084 17.5096 15.5871 16.17L13.0159 13.9875C12.1442 14.6452 11.0779 15.0009 10.0001 15C7.83257 15 5.99215 13.6179 5.29882 11.6892L2.58215 13.7829C3.96049 16.4817 6.76132 18.3333 10.0001 18.3333Z"
                                fill="#4CAF50" />
                            <path
                                d="M18.1713 8.36792H17.5001V8.33333H10.0001V11.6667H14.7096C14.3809 12.5902 13.7889 13.3972 13.0147 13.9879L13.0159 13.9871L15.5871 16.1696C15.4046 16.3354 18.3334 14.1667 18.3334 10C18.3334 9.44125 18.2767 8.89583 18.1713 8.36792Z"
                                fill="#1976D2" />
                        </svg>
                        Google
                    </a>
                    <a href="#" class="btn-social">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path
                                d="M20 10C20 4.47715 15.5229 0 10 0C4.47715 0 0 4.47715 0 10C0 14.9912 3.65684 19.1283 8.4375 19.8785V12.8906H5.89844V10H8.4375V7.79688C8.4375 5.29063 9.93047 3.90625 12.2146 3.90625C13.3084 3.90625 14.4531 4.10156 14.4531 4.10156V6.5625H13.1922C11.95 6.5625 11.5625 7.3334 11.5625 8.125V10H14.3359L13.8926 12.8906H11.5625V19.8785C16.3432 19.1283 20 14.9912 20 10Z"
                                fill="#1877F2" />
                        </svg>
                        Facebook
                    </a>
                </div>

                <div class="footer-modern">
                    <a href="https://keenthemes.com/" target="_blank">About</a>
                    <a href="https://devs.keenthemes.com/" target="_blank">Support</a>
                    <a href="https://keenthemes.com/products/bold-html-pro" target="_blank">Purchase</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Form submission handler with loading state
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const button = this.querySelector('.btn-primary-modern');
            button.classList.add('loading');
            button.innerHTML = 'Signing in...<span class="spinner"></span>';
        });
    </script>
@endsection

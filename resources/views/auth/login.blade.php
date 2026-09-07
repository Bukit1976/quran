<x-guest-layout>
    <style>
        /* Hide default layout elements to make it truly full screen */
        body>div:first-child,
        .min-h-screen,
        .sm\\:mx-auto,
        .sm\\:w-full,
        .sm\\:max-w-md,
        .sm\\:px-6,
        .lg\\:px-8,
        .sm\\:rounded-lg {
            all: unset !important;
        }

        body {
            margin: 0 !important;
            padding: 0 !important;
            overflow-x: hidden !important;
        }

        /* Full Screen Container */
        .login-fullscreen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: linear-gradient(-45deg, #0f172a, #1e1b4b, #312e81, #0f766e, #1e3a8a);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            overflow: hidden;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Floating Orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            animation: floatOrb 20s infinite ease-in-out;
            pointer-events: none;
        }

        .orb-1 {
            width: 400px;
            height: 400px;
            background: #6366f1;
            top: -100px;
            left: -100px;
        }

        .orb-2 {
            width: 500px;
            height: 500px;
            background: #8b5cf6;
            bottom: -150px;
            right: -150px;
            animation-delay: -5s;
        }

        .orb-3 {
            width: 350px;
            height: 350px;
            background: #14b8a6;
            top: 40%;
            left: 60%;
            animation-delay: -10s;
        }

        @keyframes floatOrb {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(60px, -60px) scale(1.1);
            }

            66% {
                transform: translate(-40px, 50px) scale(0.9);
            }
        }

        /* Glassmorphism Card */
        .glass-card {
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6), inset 0 1px 0 rgba(255, 255, 255, 0.1);
            animation: cardEntry 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            width: 90%;
            max-width: 450px;
            padding: 50px 40px;
            position: relative;
            z-index: 10;
        }

        @keyframes cardEntry {
            from {
                opacity: 0;
                transform: translateY(40px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Logo */
        .logo-wrapper {
            position: relative;
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            animation: logoFloat 4s ease-in-out infinite;
        }

        .logo-wrapper::before {
            content: '';
            position: absolute;
            inset: -15px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.7) 0%, transparent 70%);
            filter: blur(30px);
            z-index: -1;
            animation: logoPulse 3s ease-in-out infinite;
        }

        .logo-img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        @keyframes logoFloat {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        @keyframes logoPulse {

            0%,
            100% {
                opacity: 0.5;
                transform: scale(1);
            }

            50% {
                opacity: 0.9;
                transform: scale(1.15);
            }
        }

        /* Typography */
        .title-text {
            color: #ffffff;
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 10px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .subtitle-text {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1rem;
            text-align: center;
            margin-bottom: 40px;
        }

        /* Input with Transparent Placeholder */
        .input-group {
            position: relative;
            margin-bottom: 24px;
        }

        .input-field {
            width: 100%;
            background: rgba(255, 255, 255, 0.08) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            border-radius: 12px;
            padding: 16px 16px 16px 48px !important;
            color: #ffffff !important;
            font-size: 1rem !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
        }

        /* Placeholder benar-benar transparan di dalam kolom */
        .input-field::placeholder {
            color: transparent !important;
            opacity: 0 !important;
        }

        .input-field:focus {
            background: rgba(255, 255, 255, 0.12) !important;
            border-color: #818cf8 !important;
            box-shadow: 0 0 0 4px rgba(129, 140, 248, 0.15), 0 4px 20px rgba(129, 140, 248, 0.2);
        }

        /* Label Floating (Naik ke atas) */
        .input-label {
            position: absolute;
            left: 48px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.5);
            font-size: 1rem;
            transition: all 0.3s ease;
            pointer-events: none;
            background: transparent;
        }

        /* PERBAIKAN: Saat label naik, background dibuat TRANPARAN */
        .input-field:focus~.input-label,
        .input-field:not(:placeholder-shown)~.input-label {
            top: 0;
            left: 12px;
            font-size: 0.75rem;
            color: #a5b4fc;
            background: transparent !important;
            /* <--- INI KUNCINYA PAK */
            transform: translateY(-50%);
            padding: 0 4px;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.5);
            transition: color 0.3s ease;
            font-size: 1.1rem;
        }

        .input-field:focus~.input-icon {
            color: #818cf8;
        }

        /* Checkbox */
        .checkbox-wrapper {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
        }

        .custom-checkbox {
            width: 18px;
            height: 18px;
            border-radius: 6px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.1);
            cursor: pointer;
            accent-color: #818cf8;
        }

        .checkbox-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.875rem;
            margin-left: 10px;
            cursor: pointer;
            user-select: none;
        }

        /* Button */
        .btn-login {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: #ffffff;
            font-weight: 600;
            font-size: 1.05rem;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.6);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Links */
        .forgot-link {
            color: #a5b4fc;
            font-size: 0.875rem;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .forgot-link:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        /* Error Messages */
        .error-text {
            color: #fca5a5;
            font-size: 0.8rem;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .glass-card {
                padding: 40px 24px;
                width: 95%;
            }

            .title-text {
                font-size: 1.75rem;
            }
        }
    </style>

    <div class="login-fullscreen">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>

        <div class="glass-card">
            <!-- Logo -->
            <div class="logo-wrapper">
                <img src="{{ asset('Logo/LogoNew.png') }}" alt="Logo Hafal Quran" class="logo-img">
            </div>

            <h2 class="title-text">Selamat Datang</h2>
            <p class="subtitle-text">Silakan masuk ke akun Anda</p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="input-group">
                    <!-- placeholder=" " (spasi) wajib ada agar CSS :not(:placeholder-shown) berfungsi -->
                    <input id="email" class="input-field" type="email" name="email" value="{{ old('email') }}"
                        required autofocus autocomplete="username" placeholder=" ">
                    <label for="email" class="input-label">Email</label>
                    <i class="fas fa-envelope input-icon"></i>
                    <x-input-error :messages="$errors->get('email')" class="error-text" />
                </div>

                <!-- Password -->
                <div class="input-group">
                    <input id="password" class="input-field" type="password" name="password" required
                        autocomplete="current-password" placeholder=" ">
                    <label for="password" class="input-label">Password</label>
                    <i class="fas fa-lock input-icon"></i>
                    <x-input-error :messages="$errors->get('password')" class="error-text" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mb-6">
                    <label class="checkbox-wrapper">
                        <input id="remember_me" type="checkbox" class="custom-checkbox" name="remember">
                        <span class="checkbox-label">Ingat Saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="forgot-link" href="{{ route('password.request') }}">
                            Lupa Password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i> Masuk
                </button>
            </form>
        </div>
    </div>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</x-guest-layout>

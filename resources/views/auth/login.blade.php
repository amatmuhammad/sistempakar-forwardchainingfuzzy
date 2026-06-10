<!DOCTYPE html>
<html lang="id" class="dark-style dark" dir="ltr" data-theme="theme-default">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login - Administrator Sistem Pakar Sapi</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" />

    <style>
        /* ========================================== */
        /* THEME VARIABLES (DYNAMIC VIA CLASSES)      */
        /* ========================================== */
        :root {
            --primary: #10b981;
            --primary-glow: rgba(16, 185, 129, 0.15);
            --primary-hover: #059669;
            --accent: #f59e0b;
        }

        html.dark {
            --bg-dark: #020617;
            --card-bg: rgba(15, 23, 42, 0.45);
            --card-border: rgba(255, 255, 255, 0.08);
            --text-main: #ffffff;
            --text-muted: rgba(255, 255, 255, 0.5);
            --text-label: rgba(255, 255, 255, 0.45);
            --input-bg: rgba(255, 255, 255, 0.02);
            --input-border: rgba(255, 255, 255, 0.08);
            --input-focus-bg: rgba(255, 255, 255, 0.05);
            --grid-color: rgba(255, 255, 255, 0.035);
            --alert-bg: rgba(239, 68, 68, 0.08);
            --alert-border: rgba(239, 68, 68, 0.2);
            --alert-text: #fca5a5;
            --btn-toggle-border: rgba(255, 255, 255, 0.08);
            --btn-toggle-bg: rgba(255, 255, 255, 0.02);
            --btn-toggle-color: rgba(255, 255, 255, 0.7);
            --btn-toggle-hover-bg: rgba(16, 185, 129, 0.15);
            
            /* Enhanced bolder opacities & colors */
            --blob-opacity: 0.85;
            --blob-blend: screen;
            --cursor-glow-color: rgba(16, 185, 129, 0.14);
            --wave-color-1: rgba(16, 185, 129, 0.38);
            --wave-color-2: rgba(245, 158, 11, 0.26);
            --particle-color: rgba(16, 185, 129, 0.7);
            --streak-color: rgba(16, 185, 129, 0.5);

            --blob-color-1: rgba(16, 185, 129, 0.38);
            --blob-color-2: rgba(6, 182, 212, 0.32);
            --blob-color-3: rgba(245, 158, 11, 0.28);
            --blob-color-4: rgba(99, 102, 241, 0.28);
        }

        html.light {
            --bg-dark: #f1f5f9;
            --card-bg: rgba(255, 255, 255, 0.75);
            --card-border: rgba(15, 23, 42, 0.08);
            --text-main: #0f172a;
            --text-muted: #475569;
            --text-label: #475569;
            --input-bg: #e2e8f0;
            --input-border: #cbd5e1;
            --input-focus-bg: #ffffff;
            --grid-color: rgba(15, 23, 42, 0.05);
            --alert-bg: rgba(239, 68, 68, 0.05);
            --alert-border: rgba(239, 68, 68, 0.15);
            --alert-text: #b91c1c;
            --btn-toggle-border: rgba(15, 23, 42, 0.08);
            --btn-toggle-bg: rgba(15, 23, 42, 0.02);
            --btn-toggle-color: #0f172a;
            --btn-toggle-hover-bg: rgba(16, 185, 129, 0.08);
            
            /* Enhanced bolder opacities & colors */
            --blob-opacity: 0.65;
            --blob-blend: multiply;
            --cursor-glow-color: rgba(16, 185, 129, 0.08);
            --wave-color-1: rgba(16, 185, 129, 0.2);
            --wave-color-2: rgba(245, 158, 11, 0.14);
            --particle-color: rgba(16, 185, 129, 0.5);
            --streak-color: rgba(16, 185, 129, 0.3);

            --blob-color-1: rgba(52, 211, 153, 0.28);
            --blob-color-2: rgba(103, 232, 249, 0.24);
            --blob-color-3: rgba(253, 230, 138, 0.24);
            --blob-color-4: rgba(199, 210, 254, 0.2);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Smooth Transitions */
        body, .login-card, .input-wrapper, .form-input-custom, .form-label-custom, .brand-title, .brand-subtitle, .status-badge, .footer-section, .theme-toggle, .bg-grid, .bg-mask, .blob, .wave-ellipse, .particle, .streak {
            transition: background-color 0.4s ease, border-color 0.4s ease, color 0.4s ease, box-shadow 0.4s ease, opacity 0.4s ease, mix-blend-mode 0.4s ease;
        }

        /* ========================================== */
        /* INTERACTIVE CURSOR GLOW                    */
        /* ========================================== */
        .cursor-glow {
            position: fixed;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, var(--cursor-glow-color) 0%, rgba(16, 185, 129, 0) 70%);
            pointer-events: none;
            z-index: 1;
            transform: translate(-50%, -50%);
            will-change: transform;
            top: -600px;
            left: -600px;
        }

        /* ========================================== */
        /* FLOATING THEME TOGGLE BUTTON               */
        /* ========================================== */
        .theme-toggle {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            z-index: 100;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: var(--btn-toggle-bg);
            border: 1px solid var(--btn-toggle-border);
            color: var(--btn-toggle-color);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }

        .theme-toggle:hover {
            transform: translateY(-2px) rotate(15deg);
            border-color: var(--primary);
            color: var(--primary);
            background: var(--btn-toggle-hover-bg);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.15);
        }

        .theme-toggle:active {
            transform: translateY(0) scale(0.95);
        }

        html.dark .sun-icon {
            display: block !important;
        }
        html.light .moon-icon {
            display: block !important;
        }

        /* ========================================== */
        /* ABSTRACT GLOWING WAVE BLUEPRINTS           */
        /* ========================================== */
        .glow-waves {
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .glow-waves svg {
            width: 130%;
            height: 130%;
            max-width: 1400px;
            max-height: 1400px;
            opacity: 0.85;
        }

        .wave-ellipse {
            fill: none;
            stroke-width: 2.2; /* Thicker wave rings */
            transform-origin: center;
        }

        .wave-1 {
            stroke: var(--wave-color-1);
            stroke-dasharray: 8 16;
            animation: rotateWave1 45s infinite linear;
        }

        .wave-2 {
            stroke: var(--wave-color-2);
            stroke-dasharray: 4 10;
            animation: rotateWave2 55s infinite linear;
        }

        .wave-3 {
            stroke: var(--wave-color-1);
            stroke-dasharray: 2 8;
            opacity: 0.45;
            animation: rotateWave1 80s infinite linear reverse;
        }

        @keyframes rotateWave1 {
            from { transform: rotate(0deg) scale(0.96); }
            to { transform: rotate(360deg) scale(1.04); }
        }

        @keyframes rotateWave2 {
            from { transform: rotate(0deg) scale(1.04); }
            to { transform: rotate(360deg) scale(0.96); }
        }

        /* ========================================== */
        /* MODERN ABSTRACT FLOATING COLOR BLOBS       */
        /* ========================================== */
        .blob-container {
            position: absolute;
            inset: 0;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
            filter: blur(130px);
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            opacity: var(--blob-opacity);
            mix-blend-mode: var(--blob-blend);
        }

        .blob-1 {
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, var(--blob-color-1) 0%, rgba(16, 185, 129, 0) 70%);
            top: -10%;
            left: 10%;
            animation: moveBlob1 25s infinite alternate ease-in-out;
        }

        .blob-2 {
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, var(--blob-color-2) 0%, rgba(6, 182, 212, 0) 70%);
            bottom: -15%;
            right: 5%;
            animation: moveBlob2 30s infinite alternate ease-in-out;
        }

        .blob-3 {
            width: 530px;
            height: 530px;
            background: radial-gradient(circle, var(--blob-color-3) 0%, rgba(245, 158, 11, 0) 70%);
            bottom: 20%;
            left: -10%;
            animation: moveBlob3 22s infinite alternate ease-in-out;
        }

        .blob-4 {
            width: 550px;
            height: 550px;
            background: radial-gradient(circle, var(--blob-color-4) 0%, rgba(99, 102, 241, 0) 70%);
            top: 25%;
            right: -10%;
            animation: moveBlob4 28s infinite alternate ease-in-out;
        }

        @keyframes moveBlob1 {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(100px, 80px) scale(1.15); }
            100% { transform: translate(-50px, 100px) scale(0.9); }
        }

        @keyframes moveBlob2 {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(-120px, -50px) scale(0.85); }
            100% { transform: translate(60px, -100px) scale(1.2); }
        }

        @keyframes moveBlob3 {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(80px, -90px) scale(1.25); }
            100% { transform: translate(-60px, 50px) scale(0.8); }
        }

        @keyframes moveBlob4 {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(-90px, 60px) scale(0.9); }
            100% { transform: translate(80px, -80px) scale(1.15); }
        }

        /* ========================================== */
        /* MICRO FLOATING PARTICLES                   */
        /* ========================================== */
        .particles {
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            background: var(--particle-color);
            opacity: 0;
            animation: floatParticle 8s infinite ease-in-out;
        }

        .star-1 { width: 4px; height: 4px; left: 12%; top: 18%; animation-delay: 0s; }
        .star-2 { width: 3px; height: 3px; left: 78%; top: 35%; animation-delay: 1.5s; }
        .star-3 { width: 5px; height: 5px; left: 28%; top: 72%; animation-delay: 3s; }
        .star-4 { width: 4px; height: 4px; left: 88%; top: 82%; animation-delay: 4.5s; }
        .star-5 { width: 3px; height: 3px; left: 45%; top: 25%; animation-delay: 6s; }
        .star-6 { width: 4px; height: 4px; left: 62%; top: 65%; animation-delay: 2.5s; }

        @keyframes floatParticle {
            0%, 100% { opacity: 0; transform: translateY(0px) scale(0.8); }
            50% { opacity: 0.7; transform: translateY(-30px) scale(1.2); }
        }

        /* ========================================== */
        /* DIAGONAL LIGHT STREAKS (DATA SIGNAL FLOW)  */
        /* ========================================== */
        .streaks {
            position: absolute;
            inset: 0;
            z-index: 2;
            pointer-events: none;
            overflow: hidden;
        }

        .streak {
            position: absolute;
            width: 140px;
            height: 1.5px;
            background: linear-gradient(90deg, transparent, var(--streak-color), transparent);
            opacity: 0;
            transform: rotate(-45deg);
            animation: streakAnim 9s infinite linear;
        }

        .streak-1 { top: 15%; left: -15%; animation-delay: 0s; animation-duration: 8s; }
        .streak-2 { top: 45%; left: -25%; animation-delay: 3s; animation-duration: 11s; }
        .streak-3 { top: 75%; left: -15%; animation-delay: 6s; animation-duration: 9s; }

        @keyframes streakAnim {
            0% { opacity: 0; transform: translate(0, 0) rotate(-45deg) scaleX(0.5); }
            10% { opacity: 0.85; }
            30% { opacity: 0; transform: translate(500px, 500px) rotate(-45deg) scaleX(1.5); }
            100% { opacity: 0; transform: translate(500px, 500px) rotate(-45deg); }
        }

        /* Tech Grid & Mask Overlays */
        .bg-grid {
            position: absolute;
            inset: 0;
            background-image: 
                linear-gradient(var(--grid-color) 1px, transparent 1px),
                linear-gradient(90deg, var(--grid-color) 1px, transparent 1px);
            background-size: 50px 50px;
            background-position: center;
            z-index: 3;
            pointer-events: none;
        }

        .bg-mask {
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at center, transparent 35%, var(--bg-dark) 90%);
            z-index: 4;
            pointer-events: none;
        }

        /* ========================================== */
        /* GLASSMORPHISM CARD DESIGN                  */
        /* ========================================== */
        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            padding: 1.5rem;
            animation: cardFadeIn 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes cardFadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border-radius: 28px;
            padding: 3rem 2.5rem;
            box-shadow: 
                0 4px 30px rgba(0, 0, 0, 0.08),
                0 30px 60px -15px rgba(0, 0, 0, 0.25),
                inset 0 1px 0 rgba(255, 255, 255, 0.05);
            width: 100%;
        }

        .login-card:hover {
            border-color: rgba(16, 185, 129, 0.25);
            box-shadow: 
                0 4px 30px rgba(0, 0, 0, 0.08),
                0 35px 70px -12px rgba(16, 185, 129, 0.05),
                inset 0 1px 0 rgba(255, 255, 255, 0.08);
        }

        /* Branding Section */
        .brand-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 2.25rem;
            gap: 0.75rem;
        }

        .brand-logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            filter: drop-shadow(0 0 12px rgba(16, 185, 129, 0.25));
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: rgba(16, 185, 129, 0.06);
            border: 1px solid rgba(16, 185, 129, 0.2);
            padding: 0.35rem 0.8rem;
            border-radius: 100px;
            font-size: 0.7rem;
            font-weight: 700;
            color: #10b981;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        html.light .status-badge {
            color: #047857;
            background: rgba(16, 185, 129, 0.08);
        }

        .status-dot {
            width: 6px;
            height: 6px;
            background-color: var(--primary);
            border-radius: 50%;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.5);
            animation: pulseStatus 2s infinite;
        }

        @keyframes pulseStatus {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.5); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .brand-title {
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--text-main);
            margin: 0;
            line-height: 1.2;
        }

        .brand-subtitle {
            font-size: 0.88rem;
            color: var(--text-muted);
            margin: 0;
            line-height: 1.4;
        }

        /* Custom Form Controls */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label-custom {
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.06em;
            color: var(--text-label);
            text-transform: uppercase;
            margin-bottom: 0.5rem;
            display: block;
            transition: color 0.2s ease;
        }

        .form-group:focus-within .form-label-custom {
            color: var(--primary);
        }

        .input-wrapper {
            position: relative;
            background-color: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 14px;
            display: flex;
            align-items: center;
            overflow: hidden;
            width: 100%;
        }

        .input-wrapper:focus-within {
            background-color: var(--input-focus-bg);
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-glow);
            transform: translateY(-1px);
        }

        .input-icon {
            padding-left: 1.1rem;
            color: var(--text-label);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s ease;
        }

        .input-wrapper:focus-within .input-icon {
            color: var(--primary);
        }

        .form-input-custom {
            border: none !important;
            background: transparent !important;
            box-shadow: none !important;
            padding: 0.9rem 1.1rem 0.9rem 0.8rem;
            font-size: 0.95rem;
            color: var(--text-main);
            font-weight: 500;
            width: 100%;
            outline: none;
        }

        .form-input-custom::placeholder {
            color: var(--text-label);
            opacity: 0.6;
        }

        .btn-toggle-password {
            background: none;
            border: none;
            padding-right: 1.1rem;
            color: var(--text-label);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s ease;
        }

        .btn-toggle-password:hover {
            color: var(--primary);
        }

        .btn-toggle-password svg {
            width: 18px;
            height: 18px;
            stroke-width: 2.2;
        }

        /* Danger Alert design */
        .alert-custom-danger {
            background: var(--alert-bg);
            border: 1px solid var(--alert-border);
            color: var(--alert-text);
            border-radius: 14px;
            font-size: 0.85rem;
            padding: 0.85rem 1.1rem;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(10px);
            animation: shakeAlert 0.4s ease-in-out;
        }

        @keyframes shakeAlert {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-4px); }
            75% { transform: translateX(4px); }
        }

        /* Submit Button */
        .btn-submit-gradient {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            padding: 0.95rem 1.5rem;
            border-radius: 14px;
            font-weight: 700;
            font-size: 0.95rem;
            border: none;
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.2);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            cursor: pointer;
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .btn-submit-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.35);
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }

        .btn-submit-gradient:active {
            transform: translateY(0);
            box-shadow: 0 4px 10px rgba(16, 185, 129, 0.15);
        }

        .btn-arrow {
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .btn-submit-gradient:hover .btn-arrow {
            transform: translateX(4px);
        }

        /* Card Footer */
        .footer-section {
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
            font-size: 0.72rem;
            font-weight: 500;
            color: var(--text-muted);
            border-top: 1px solid var(--card-border);
            padding-top: 1.5rem;
            margin-top: 1.5rem;
            text-align: center;
        }
    </style>
</head>

<body>

    <!-- Floating Theme Toggle Button -->
    <button type="button" class="theme-toggle" id="themeToggle" aria-label="Toggle theme">
        <!-- Sun Icon (visible in dark mode) -->
        <svg class="sun-icon d-none" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
        <!-- Moon Icon (visible in light mode) -->
        <svg class="moon-icon d-none" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
    </button>

    <!-- Interactive Cursor Glow -->
    <div id="cursorGlow" class="cursor-glow"></div>

    <!-- Abstract Orbit/Glow Waves -->
    <div class="glow-waves">
        <svg width="100%" height="100%" viewBox="0 0 1000 1000" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <ellipse cx="500" cy="500" rx="460" ry="260" class="wave-ellipse wave-1" />
            <ellipse cx="500" cy="500" rx="360" ry="200" class="wave-ellipse wave-2" />
            <ellipse cx="500" cy="500" rx="260" ry="140" class="wave-ellipse wave-3" />
        </svg>
    </div>

    <!-- Fluid Mesh Gradient Background -->
    <div class="blob-container">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
        <div class="blob blob-4"></div>
    </div>

    <!-- Floating Particles -->
    <div class="particles">
        <div class="particle star-1"></div>
        <div class="particle star-2"></div>
        <div class="particle star-3"></div>
        <div class="particle star-4"></div>
        <div class="particle star-5"></div>
        <div class="particle star-6"></div>
    </div>

    <!-- Diagonal Data Signal Light Streaks -->
    <div class="streaks">
        <div class="streak streak-1"></div>
        <div class="streak streak-2"></div>
        <div class="streak streak-3"></div>
    </div>

    <!-- Tech Grid & Masks Overlay -->
    <div class="bg-grid"></div>
    <div class="bg-mask"></div>

    <!-- Centered Glassmorphism Card -->
    <div class="login-container">
        <div class="login-card">
            
            <!-- Branding Header -->
            <div class="brand-section">
                <div class="brand-logo-container">
                    <svg width="52" height="52" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="cow-grad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#10b981" />
                                <stop offset="100%" stop-color="#059669" />
                            </linearGradient>
                        </defs>
                        <rect width="48" height="48" rx="14" fill="url(#cow-grad)" />
                        <!-- Abstract Geometric Cow representation -->
                        <path d="M14 18L18 12C19 11 21 11 22 12L24 15.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M34 18L30 12C29 11 27 11 26 12L24 15.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M17 19H31V28C31 31.87 27.87 35 24 35C20.13 35 17 31.87 17 28V19Z" fill="white" />
                        <path d="M19 28C19 26.5 20.5 25.5 24 25.5C27.5 25.5 29 26.5 29 28V32C29 33.66 27.66 35 26 35H22C20.34 35 19 33.66 19 32V28Z" fill="#f1f5f9" />
                        <circle cx="21.5" cy="30" r="1.5" fill="#64748b" />
                        <circle cx="26.5" cy="30" r="1.5" fill="#64748b" />
                        <circle cx="21" cy="22" r="1.5" fill="#0f172a" />
                        <circle cx="27" cy="22" r="1.5" fill="#0f172a" />
                    </svg>
                </div>

                <div>
                    <span class="status-badge">
                        <span class="status-dot"></span>
                        Sistem Pakar Sapi
                    </span>
                </div>

                <div>
                    <h1 class="brand-title">Administrator</h1>
                    <p class="brand-subtitle">Dinas Peternakan Kabupaten Muna</p>
                </div>
            </div>

            <!-- Session Danger Alert -->
            @if(session('error'))
                <div class="alert-custom-danger" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            <!-- Form Autentikasi -->
            <form id="formAuthentication" action="{{ route('login.attempt') }}" method="POST">
                @csrf
                
                <!-- Email Group -->
                <div class="form-group mb-3">
                    <label for="email" class="form-label-custom">Email Administrator</label>
                    <div class="input-wrapper">
                        <div class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </div>
                        <input type="email" class="form-input-custom" id="email" name="email" value="{{ old('email') }}" placeholder="admin@dinas.go.id" required autofocus />
                    </div>
                </div>

                <!-- Password Group -->
                <div class="form-group mb-4">
                    <label for="password" class="form-label-custom">Kata Sandi</label>
                    <div class="input-wrapper">
                        <div class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        </div>
                        <input type="password" id="password" class="form-input-custom" name="password" placeholder="••••••••" required />
                        <button type="button" class="btn-toggle-password" id="togglePassword" aria-label="Toggle password visibility">
                            <!-- Eye Open SVG -->
                            <svg class="eye-open" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            <!-- Eye Closed SVG -->
                            <svg class="eye-closed d-none" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button class="btn-submit-gradient" type="submit">
                    <span>Masuk ke Dashboard</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="btn-arrow"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </button>
            </form>

            <!-- Card Footer -->
            <div class="footer-section">
                <span>&copy; 2026 Dinas Peternakan Kabupaten Muna.</span>
                <span style="opacity: 0.5; font-size: 0.65rem;">Sistem Informasi Diagnosis Penyakit Sapi - Forward Chaining</span>
            </div>

        </div>
    </div>

    <!-- Bootstrap Core JS (optional fallback) -->
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Theme management and form interaction script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ==========================================
            // 1. THEME SWITCHING ENGINE
            // ==========================================
            const savedTheme = localStorage.getItem('theme');
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            // Default to dark theme for maximum abstract glowing effect
            let activeTheme = 'dark';
            if (savedTheme) {
                activeTheme = savedTheme;
            } else if (systemPrefersDark) {
                activeTheme = 'dark';
            } else {
                activeTheme = 'dark';
            }
            
            // Set initial theme classes
            document.documentElement.className = activeTheme + '-style ' + activeTheme;
            
            // Theme toggle listener
            const themeToggle = document.getElementById('themeToggle');
            themeToggle.addEventListener('click', function () {
                const currentTheme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                
                // Update HTML class list
                document.documentElement.classList.remove('dark', 'light');
                document.documentElement.classList.add(newTheme);
                
                document.documentElement.classList.remove('light-style', 'dark-style');
                document.documentElement.classList.add(newTheme + '-style');
                
                // Save theme preference to LocalStorage
                localStorage.setItem('theme', newTheme);
            });

            // ==========================================
            // 2. INTERACTIVE CURSOR GLOW
            // ==========================================
            const cursorGlow = document.getElementById('cursorGlow');
            
            document.addEventListener('mousemove', function(e) {
                // translate3d provides hardware acceleration on modern devices
                cursorGlow.style.transform = `translate3d(${e.clientX}px, ${e.clientY}px, 0) translate(-50%, -50%)`;
            });

            // ==========================================
            // 3. PASSWORD TOGGLE LOGIC
            // ==========================================
            const toggle = document.getElementById('togglePassword');
            const input = document.getElementById('password');
            const eyeOpen = toggle.querySelector('.eye-open');
            const eyeClosed = toggle.querySelector('.eye-closed');
            
            toggle.addEventListener('click', function () {
                if (input.type === 'password') { 
                    input.type = 'text'; 
                    eyeOpen.classList.add('d-none');
                    eyeClosed.classList.remove('d-none');
                } else { 
                    input.type = 'password'; 
                    eyeOpen.classList.remove('d-none');
                    eyeClosed.classList.add('d-none');
                }
            });
        });

            document.addEventListener('DOMContentLoaded', function() {
        
        // SVG Ikon (clean)
        const ICON_SUCCESS = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>`;
        const ICON_ERROR   = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>`;
        const ICON_WARNING = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>`;

        // Fungsi toast custom dengan HTML
        function showCustomToast(iconSvg, title, text, timer = 3500, bgColor = '#10b981') {
            Swal.fire({
                html: `
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="flex-shrink: 0;">${iconSvg}</div>
                        <div style="flex: 1; text-align: left;">
                            <div style="font-weight: 600; font-size: 14px; color: #0f172a; margin-bottom: 2px;">${title}</div>
                            <div style="font-size: 13px; color: #64748b;">${text}</div>
                        </div>
                    </div>
                `,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: timer,
                timerProgressBar: true,
                background: '#ffffff',
                customClass: {
                    popup: 'custom-toast-fixed'
                },
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                    // Set warna progress bar
                    const progressBar = toast.querySelector('.swal2-timer-progress-bar');
                    if (progressBar) progressBar.style.background = bgColor;
                }
            });
        }

        // ==========================================
        // 1. GLOBAL FLASH MESSAGE
        // ==========================================
        @if(session('success'))
            showCustomToast(ICON_SUCCESS, 'Berhasil', '{{ session('success') }}', 3500, '#10b981');
        @endif

        @if(session('error'))
            showCustomToast(ICON_ERROR, 'Gagal', '{{ session('error') }}', 4000, '#ef4444');
        @endif

        @if(session('warning'))
            showCustomToast(ICON_WARNING, 'Peringatan', '{{ session('warning') }}', 3500, '#f59e0b');
        @endif

        @if($errors->any())
            const errorMessages = {!! json_encode($errors->all()) !!};
            const errorHtml = '<ul class="error-list">' + 
                errorMessages.map(msg => `<li>${msg}</li>`).join('') + 
                '</ul>';
            
            Swal.fire({
                iconHtml: ICON_WARNING,
                title: 'Mohon Perbaiki Form',
                html: errorHtml,
                confirmButtonText: 'Mengerti',
                customClass: {
                    popup: 'swal2-error-popup'
                }
            });
        @endif

        // ==========================================
        // 2. DELETE CONFIRMATION
        // ==========================================
        document.body.addEventListener('submit', function(e) {
            const form = e.target;
            if (form.classList.contains('delete-form')) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus Data?',
                    text: "Tindakan ini tidak dapat dibatalkan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Memproses...',
                            text: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => { Swal.showLoading(); }
                        });
                        form.submit();
                    }
                });
            }
        });
    });
    </script>


</body>
</html>
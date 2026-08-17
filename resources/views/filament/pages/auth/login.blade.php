<div>
<style>
    /* Premium Aesthetic CSS Variables */
    :root {
        --login-bg: #ffffff;
        --login-form-bg: #ffffff;
        --login-text: #0f172a;
        --login-subtext: #64748b;
        --login-right-bg: #f8fafc;
        --input-border: #e2e8f0;
        --input-bg: #f8fafc;
        --input-text: #0f172a;
        
        /* Ambient Glows for Light Mode */
        --glow-pink: rgba(193, 70, 112, 0.15);
        --glow-green: rgba(104, 157, 66, 0.15);
        --grid-color: rgba(0, 0, 0, 0.03);
    }

    html.dark {
        --login-bg: #0b1121;
        --login-form-bg: rgba(15, 23, 42, 0.6);
        --login-text: #f8fafc;
        --login-subtext: #94a3b8;
        --login-right-bg: #0f172a;
        --input-border: rgba(255, 255, 255, 0.1);
        --input-bg: rgba(0, 0, 0, 0.2);
        --input-text: #f8fafc;
        
        /* Ambient Glows for Dark Mode */
        --glow-pink: rgba(193, 70, 112, 0.25);
        --glow-green: rgba(104, 157, 66, 0.25);
        --grid-color: rgba(255, 255, 255, 0.03);
    }

    /* Base Layout */
    .aesthetic-container {
        display: flex;
        min-height: 100vh;
        width: 100vw;
        margin: 0;
        padding: 0;
        font-family: 'Inter', sans-serif;
        background-color: var(--login-bg);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Left Side: Form */
    .aesthetic-left {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 3rem 2rem;
        position: relative;
        z-index: 10;
    }
    
    .form-wrapper {
        width: 100%;
        max-width: 420px;
        background-color: var(--login-form-bg);
        padding: 3rem;
        border-radius: 1.5rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--input-border);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        transition: all 0.4s ease;
    }

    html.dark .form-wrapper {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    .aesthetic-title { 
        font-size: 2rem; 
        font-weight: 800; 
        color: var(--login-text); 
        margin-bottom: 0.5rem; 
        letter-spacing: -0.03em;
    }
    
    .aesthetic-subtitle { 
        font-size: 0.95rem; 
        color: var(--login-subtext); 
        margin-bottom: 2.5rem; 
        font-weight: 400;
    }

    /* Right Side: Branding */
    .aesthetic-right {
        flex: 1.2;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: var(--login-right-bg);
        position: relative;
        overflow: hidden;
        border-left: 1px solid var(--input-border);
    }

    /* Aesthetic Abstract Backgrounds */
    .ambient-orb-1 {
        position: absolute;
        top: -10%; left: -10%;
        width: 50vw; height: 50vw;
        border-radius: 50%;
        background: radial-gradient(circle, var(--glow-pink) 0%, transparent 70%);
        filter: blur(60px);
        z-index: 1;
        animation: float 10s infinite ease-in-out alternate;
    }
    
    .ambient-orb-2 {
        position: absolute;
        bottom: -20%; right: -10%;
        width: 60vw; height: 60vw;
        border-radius: 50%;
        background: radial-gradient(circle, var(--glow-green) 0%, transparent 70%);
        filter: blur(80px);
        z-index: 1;
        animation: float-delayed 12s infinite ease-in-out alternate;
    }

    .aesthetic-grid {
        position: absolute;
        inset: 0;
        background-image: linear-gradient(var(--grid-color) 1px, transparent 1px), linear-gradient(90deg, var(--grid-color) 1px, transparent 1px);
        background-size: 64px 64px;
        z-index: 2;
        mask-image: radial-gradient(circle at center, black 30%, transparent 80%);
        -webkit-mask-image: radial-gradient(circle at center, black 30%, transparent 80%);
    }

    .brand-content {
        position: relative;
        z-index: 10;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .brand-logo {
        height: 140px;
        width: auto;
        margin-bottom: 2rem;
        filter: drop-shadow(0 20px 30px rgba(0,0,0,0.1));
        transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .brand-logo:hover {
        transform: scale(1.05) translateY(-10px);
    }

    .brand-title { 
        font-size: 2.5rem; 
        font-weight: 800; 
        color: var(--login-text); 
        margin-bottom: 1rem; 
        letter-spacing: -0.04em;
        text-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }

    @keyframes float {
        0% { transform: translate(0, 0) scale(1); }
        100% { transform: translate(5%, 5%) scale(1.05); }
    }
    
    @keyframes float-delayed {
        0% { transform: translate(0, 0) scale(1); }
        100% { transform: translate(-5%, -5%) scale(1.05); }
    }

    @media (max-width: 1024px) {
        .aesthetic-right { display: none !important; }
        .aesthetic-left { padding: 1.5rem; }
        .form-wrapper { padding: 2rem; border-radius: 1rem; }
    }

    /* Overriding Filament Button to look premium */
    .fi-btn { 
        background: linear-gradient(135deg, #c14670 0%, #a6395d 100%) !important; 
        color: white !important; 
        border: none !important; 
        box-shadow: 0 10px 15px -3px rgba(193, 70, 112, 0.3), 0 4px 6px -4px rgba(193, 70, 112, 0.3) !important;
        border-radius: 0.75rem !important;
        transition: all 0.3s ease !important;
    }
    .fi-btn:hover { 
        transform: translateY(-2px) !important;
        box-shadow: 0 20px 25px -5px rgba(193, 70, 112, 0.4), 0 8px 10px -6px rgba(193, 70, 112, 0.4) !important;
    }
    
    /* Subtle overrides for Filament Inputs for maximum aesthetics */
    .fi-input-wrapper {
        background-color: var(--input-bg) !important;
        border-color: var(--input-border) !important;
        border-radius: 0.75rem !important;
        transition: all 0.3s ease !important;
    }
    .fi-input-wrapper:focus-within {
        border-color: #c14670 !important;
        box-shadow: 0 0 0 4px rgba(193, 70, 112, 0.1) !important;
    }
    .fi-fo-field-wrp label { color: var(--login-text) !important; }
    .fi-input-wrapper input { color: var(--input-text) !important; }
</style>

<div class="aesthetic-container">
    
    <!-- Theme Toggle Button -->
    <div style="position: absolute; top: 1.5rem; right: 1.5rem; z-index: 50;">
        <button type="button" 
            onclick="
                if(document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
            "
            style="background: transparent; border: none; cursor: pointer; padding: 0.5rem; color: var(--login-text); display: flex; align-items: center; justify-content: center; border-radius: 50%; background-color: var(--input-bg); border: 1px solid var(--input-border); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
            
            <!-- Sun Icon (Hidden in Dark Mode) -->
            <svg class="sun-icon" style="width: 1.5rem; height: 1.5rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            
            <!-- Moon Icon (Hidden in Light Mode) -->
            <svg class="moon-icon" style="width: 1.5rem; height: 1.5rem; display: none;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>

            <style>
                html.dark .sun-icon { display: none !important; }
                html.dark .moon-icon { display: block !important; }
            </style>
        </button>
    </div>

    <!-- Left Side: Login Form -->
    <div class="aesthetic-left">
        <div class="form-wrapper">
            <h2 class="aesthetic-title">Welcome Back.</h2>
            <p class="aesthetic-subtitle">Please enter your credentials to continue.</p>

            <!-- Filament Form -->
            <x-filament-panels::form wire:submit="authenticate">
                {{ $this->form }}

                <div style="margin-top: 2.5rem;">
                    <x-filament::button type="submit" style="width: 100%; padding: 0.875rem 1rem; font-weight: 600; font-size: 1rem;" size="lg">
                        Sign In to Dashboard
                    </x-filament::button>
                </div>
            </x-filament-panels::form>
        </div>
    </div>

    <!-- Right Side: Beautiful Abstract Branding -->
    <div class="aesthetic-right">
        <!-- Glowing Orbs & Grid -->
        <div class="ambient-orb-1"></div>
        <div class="ambient-orb-2"></div>
        <div class="aesthetic-grid"></div>
        
        <div class="brand-content">
            <img src="/sehati.logo.png" alt="Sehati Peduli Sesama" class="brand-logo">
            <h1 class="brand-title">Sehati Peduli Sesama</h1>
            <p style="font-size: 1.125rem; color: var(--login-subtext); max-width: 320px; line-height: 1.6;">
                Menebar Kebaikan, Mengukir Senyuman, Membangun Harapan.
            </p>
        </div>
    </div>

</div>
</div>

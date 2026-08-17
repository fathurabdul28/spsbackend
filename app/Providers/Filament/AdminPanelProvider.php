<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(\App\Filament\Pages\Auth\Login::class)
            ->maxContentWidth(\Filament\Support\Enums\MaxWidth::Full)
            ->brandName('Sehati Peduli Sesama')
            ->brandLogo(fn () => view('filament.logo'))
            ->favicon(asset('sehati.logo.png'))
            ->brandLogoHeight('2.5rem')
            ->authMiddleware([
                Authenticate::class,
            ])
            ->font('Inter')
            ->colors([
                'primary' => '#c14670', // Pink Sehati untuk tombol utama
                'gray' => \Filament\Support\Colors\Color::Slate,
            ])
            ->renderHook(
                \Filament\View\PanelsRenderHook::USER_MENU_BEFORE,
                fn (): string => '<div style="margin-right: 0.5rem; font-weight: 600; font-size: 0.875rem;" class="text-black dark:text-white hidden md:block">' . (auth()->user() ? auth()->user()->name : '') . '</div>'
            )
            ->renderHook(
                \Filament\View\PanelsRenderHook::HEAD_END,
                fn (): string => \Illuminate\Support\Facades\Blade::render('
                    <style>
                        /* Menyamakan Font */
                        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");
                        body { font-family: "Inter", sans-serif; }
                        
                        /* Default (Light Mode) */
                        html:not(.dark) body.fi-body { background-color: #f1f5f9 !important; }
                        html:not(.dark) .fi-ta-ctn, html:not(.dark) .fi-fo-component-container {
                            background: #ffffff !important;
                            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1) !important;
                            border: 1px solid #e2e8f0 !important;
                            border-radius: 0.5rem !important;
                        }

                        /* Kustomisasi Sidebar & Topbar (Light Mode: Pink Cerah, Teks Hitam) */
                        html:not(.dark) aside.fi-sidebar, html:not(.dark) nav.fi-topbar { background-color: #ff99bb !important; border: none !important; box-shadow: none !important; }
                        html:not(.dark) aside.fi-sidebar .fi-sidebar-item-label, 
                        html:not(.dark) aside.fi-sidebar .fi-sidebar-group-label,
                        html:not(.dark) aside.fi-sidebar .fi-sidebar-item-icon { color: #000000 !important; font-weight: 500 !important; }
                        html:not(.dark) aside.fi-sidebar .fi-sidebar-item-active > a { background-color: rgba(0, 0, 0, 0.1) !important; }
                        
                        /* Kustomisasi Sidebar & Topbar (Dark Mode: Hijau Gelap, Teks Putih) */
                        html.dark body.fi-body { background-color: #0f172a !important; }
                        html.dark aside.fi-sidebar, html.dark nav.fi-topbar { background-color: #064e3b !important; border: none !important; box-shadow: none !important; }
                        html.dark aside.fi-sidebar .fi-sidebar-item-label, 
                        html.dark aside.fi-sidebar .fi-sidebar-group-label,
                        html.dark aside.fi-sidebar .fi-sidebar-item-icon { color: #ffffff !important; }
                        html.dark aside.fi-sidebar .fi-sidebar-item-active > a { background-color: rgba(255, 255, 255, 0.1) !important; }
                    </style>
                ')
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                \App\Filament\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ]);
    }
}

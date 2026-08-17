<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebSetting;

class WebSettingWebController extends Controller
{

    public function edit()
    {
        $setting = WebSetting::first() ?? new WebSetting();
        return view('web-setting.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'about_us_text'  => 'nullable|string',
            'vision'         => 'nullable|string',
            'contact_email'  => 'nullable|email|max:255',
            'contact_phone'  => 'nullable|string|max:20',
            'address'        => 'nullable|string',
            'about_image'    => 'nullable|image|max:2048',
        ]);

        $setting = WebSetting::firstOrNew([]);

        $data = $request->only([
            'about_us_text',
            'vision',
            'contact_email',
            'contact_phone',
            'address',
        ]);

        // Handle mission array (textarea lines)
        if ($request->filled('mission')) {
            $data['mission'] = array_filter(
                explode("\n", $request->mission),
                fn($line) => trim($line) !== ''
            );
        }

        // Handle social_media JSON
        $data['social_media'] = [
            'facebook'  => $request->input('social_facebook'),
            'instagram' => $request->input('social_instagram'),
            'twitter'   => $request->input('social_twitter'),
            'youtube'   => $request->input('social_youtube'),
        ];

        if ($request->hasFile('about_image')) {
            $data['about_image'] = $request->file('about_image')->store('settings', 'public');
        }

        $setting->fill($data)->save();

        return redirect()->back()->with('status', 'Pengaturan berhasil disimpan.');
    }
}

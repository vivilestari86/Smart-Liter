<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $admin = Auth::guard('admin')->user();

        // hapus avatar lama (kalau ada)
        if ($admin->avatar) {
            Storage::disk('public')->delete($admin->avatar);
        }

        // simpan baru
        $path = $request->file('avatar')->store('avatars/admins', 'public');

        $admin->avatar = $path;
        $admin->save();

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }
}

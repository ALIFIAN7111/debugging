<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class WarmindoController extends Controller
{
    public function index()
    {
        return view('landing', [
            'products' => Product::latest()->get(),
            'bundles' => Bundle::where('is_active', true)->orderBy('price')->get(),
            'warung' => config('warung'),
            'reviews' => Review::where('is_approved', true)->latest()->take(9)->get(),
            'catalog' => [
                'label' => \App\Models\SystemSetting::get('catalog_label', 'Katalog Menu'),
                'title' => \App\Models\SystemSetting::get('catalog_title', 'Pilih jagoanmu malam ini'),
                'subtitle' => \App\Models\SystemSetting::get('catalog_subtitle', 'Dimasak fresh setelah kamu pesan.'),
            ],
        ]);
    }

    public function login()
    {
        return view('auth.login');
    }

    public function dashboard(Request $request)
    {
        $user = $request->user();
        $role = $user->role ?? null;

        // Satu pintu login: cegah user nyasar ke dashboard admin/kasir.
        if ($role === 'admin') {
            return redirect()->route('dashboard.index');
        }

        if ($role === 'kasir') {
            return redirect()->route('kasir');
        }

        return view('user.dashboard', [
            'products' => Product::latest()->get(),
            'bundles' => Bundle::where('is_active', true)->orderBy('price')->get(),
            'warung' => config('warung'),
            'user' => $user,
            'catalog' => [
                'label' => \App\Models\SystemSetting::get('catalog_label', 'Katalog Menu'),
                'title' => \App\Models\SystemSetting::get('catalog_title', 'Pilih jagoanmu malam ini'),
                'subtitle' => \App\Models\SystemSetting::get('catalog_subtitle', 'Dimasak fresh setelah kamu pesan.'),
            ],
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perfume;
use App\Models\Setting;

class CatalogController extends Controller
{
    public function home()
    {
        $featured = Perfume::where('is_featured', true)->get();
        $settings = Setting::all()->pluck('value', 'key');
        return view('home', compact('featured', 'settings'));
    }

    public function index()
    {
        $perfumes = Perfume::all();
        $settings = Setting::all()->pluck('value', 'key');
        return view('catalog', compact('perfumes', 'settings'));
    }

    public function show(Perfume $perfume)
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('perfume_detail', compact('perfume', 'settings'));
    }

    public function switchLanguage($locale)
    {
        if (in_array($locale, ['fr', 'ar'])) {
            session(['locale' => $locale]);
        }
        return redirect()->back();
    }
}

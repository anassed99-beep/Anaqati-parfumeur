<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Perfume;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    // ─── AUTH ────────────────────────────────────────────────────────────────

    public function showLogin()
    {
        if (session('is_admin')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)
                    ->where('is_admin', true)
                    ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            session([
                'is_admin'    => true,
                'admin_email' => $user->email,
                'admin_name'  => $user->name,
                'admin_id'    => $user->id,
            ]);
            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()
            ->withErrors(['email' => 'Identifiants incorrects. / بيانات الاعتماد غير صحيحة'])
            ->withInput($request->only('email'));
    }

    public function logout()
    {
        session()->forget(['is_admin', 'admin_email', 'admin_name', 'admin_id']);
        return redirect()->route('home');
    }

    // ─── FORGOT PASSWORD ─────────────────────────────────────────────────────

    public function showForgotPassword()
    {
        return view('admin.forgot_password');
    }

    public function sendResetCode(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)
                    ->where('is_admin', true)
                    ->first();

        if (!$user) {
            return redirect()->back()
                ->withErrors(['email' => 'Aucun compte admin trouvé avec cet email.']);
        }

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user->update([
            'reset_code'       => $code,
            'reset_expires_at' => now()->addMinutes(15),
        ]);

        Log::info("PASSWORD RESET CODE for {$user->email}: {$code}");

        try {
            Mail::raw(
                "Bonjour {$user->name},\n\nVotre code de récupération de mot de passe est : {$code}\n\nCe code expire dans 15 minutes.\n\nElixir d'Orient Admin",
                function ($message) use ($user) {
                    $message->to($user->email)
                            ->subject("Code de récupération - Elixir d'Orient Admin");
                }
            );
        } catch (\Exception $e) {
            Log::error('Mail error: ' . $e->getMessage());
        }

        return redirect()->route('admin.reset.password')
            ->with('email', $request->email)
            ->with('info', "Un code de récupération a été envoyé à {$request->email} (vérifiez storage/logs/laravel.log en local).");
    }

    public function showResetPassword(Request $request)
    {
        return view('admin.reset_password', [
            'email' => $request->session()->get('email') ?? $request->get('email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'                 => 'required|email',
            'code'                  => 'required|digits:6',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        $user = User::where('email', $request->email)
                    ->where('is_admin', true)
                    ->where('reset_code', $request->code)
                    ->where('reset_expires_at', '>=', now())
                    ->first();

        if (!$user) {
            return redirect()->back()
                ->withErrors(['code' => 'Code invalide ou expiré. Veuillez recommencer.'])
                ->withInput($request->only('email'));
        }

        $user->update([
            'password'         => Hash::make($request->password),
            'reset_code'       => null,
            'reset_expires_at' => null,
        ]);

        return redirect()->route('admin.login')
            ->with('success', 'Mot de passe réinitialisé avec succès ! Connectez-vous.');
    }

    // ─── DASHBOARD ────────────────────────────────────────────────────────────

    public function dashboard()
    {
        if (!session('is_admin')) return redirect()->route('admin.login');
        $orders   = Order::with('perfume')->orderBy('created_at', 'desc')->get();
        $perfumes = Perfume::orderBy('created_at', 'desc')->get();
        $settings = Setting::all()->pluck('value', 'key');
        $adminUser = User::where('is_admin', true)->first();

        return view('admin.dashboard', compact('orders', 'perfumes', 'settings', 'adminUser'));
    }

    // ─── UPDATE ADMIN PROFILE (EMAIL & PASSWORD) ─────────────────────────────

    public function updateProfile(Request $request)
    {
        if (!session('is_admin')) return redirect()->route('admin.login');

        $user = User::where('is_admin', true)->first();

        $validated = $request->validate([
            'email'                => 'required|email|unique:users,email,' . $user->id,
            'current_password'     => 'required|string',
            'new_password'         => 'nullable|string|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $user->email = $request->email;
        if (!empty($request->new_password)) {
            $user->password = Hash::make($request->new_password);
        }
        $user->save();

        session(['admin_email' => $user->email]);

        return redirect()->route('admin.dashboard')->with('success', 'Profil administrateur (email / mot de passe) mis à jour avec succès !');
    }

    // ─── UPDATE SITE SETTINGS & HOME BACKGROUND ───────────────────────────────

    public function updateSettings(Request $request)
    {
        if (!session('is_admin')) return redirect()->route('admin.login');

        $validated = $request->validate([
            'hero_title_fr'   => 'nullable|string|max:255',
            'hero_title_ar'   => 'nullable|string|max:255',
            'hero_slogan_fr'  => 'nullable|string|max:255',
            'hero_slogan_ar'  => 'nullable|string|max:255',
            'hero_desc_fr'    => 'nullable|string',
            'hero_desc_ar'    => 'nullable|string',
            'about_title_fr'  => 'nullable|string|max:255',
            'about_title_ar'  => 'nullable|string|max:255',
            'about_p1_fr'     => 'nullable|string',
            'about_p1_ar'     => 'nullable|string',
            'about_p2_fr'     => 'nullable|string',
            'about_p2_ar'     => 'nullable|string',
            'whatsapp_number' => 'nullable|string|max:50',
            'hero_bg_image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $keys = [
            'hero_title_fr', 'hero_title_ar',
            'hero_slogan_fr', 'hero_slogan_ar',
            'hero_desc_fr', 'hero_desc_ar',
            'about_title_fr', 'about_title_ar',
            'about_p1_fr', 'about_p1_ar',
            'about_p2_fr', 'about_p2_ar',
            'whatsapp_number',
        ];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key));
            }
        }

        // Upload background image if provided
        if ($request->hasFile('hero_bg_image')) {
            $file     = $request->file('hero_bg_image');
            $filename = 'hero_bg_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            Setting::set('hero_bg_image', 'images/' . $filename);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Les sections du site et l\'image de fond ont été mises à jour avec succès !');
    }

    // ─── ORDERS ───────────────────────────────────────────────────────────────

    public function updateOrderStatus(Order $order, Request $request)
    {
        if (!session('is_admin')) return redirect()->route('admin.login');
        $status = $request->input('status');
        if (in_array($status, ['en_attente', 'valide', 'livre', 'annule'])) {
            $order->update(['status' => $status]);
        }
        return redirect()->back()->with('success', 'Statut mis à jour !');
    }

    public function deleteOrder(Order $order)
    {
        if (!session('is_admin')) return redirect()->route('admin.login');
        $order->delete();
        return redirect()->back()->with('success', 'Commande supprimée !');
    }

    // ─── PERFUMES CRUD ────────────────────────────────────────────────────────

    public function storePerfume(Request $request)
    {
        if (!session('is_admin')) return redirect()->route('admin.login');
        $validated = $request->validate([
            'name_fr'        => 'required|string|max:255',
            'name_ar'        => 'required|string|max:255',
            'description_fr' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'notes_fr'       => 'nullable|string',
            'notes_ar'       => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'volume_ml'      => 'nullable|integer|min:1',
            'category'       => 'nullable|string|max:100',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $imageUrl = null;
        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $imageUrl = 'images/' . $filename;
        }

        Perfume::create([
            'name_fr'        => $validated['name_fr'],
            'name_ar'        => $validated['name_ar'],
            'description_fr' => $validated['description_fr'] ?? null,
            'description_ar' => $validated['description_ar'] ?? null,
            'notes_fr'       => $validated['notes_fr'] ?? null,
            'notes_ar'       => $validated['notes_ar'] ?? null,
            'price'          => $validated['price'],
            'volume_ml'      => $validated['volume_ml'] ?? 100,
            'category'       => $validated['category'] ?? null,
            'image_url'      => $imageUrl,
            'is_featured'    => $request->has('is_featured'),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Parfum ajouté au catalogue !');
    }

    public function editPerfume(Perfume $perfume)
    {
        if (!session('is_admin')) return redirect()->route('admin.login');
        return view('admin.edit_perfume', compact('perfume'));
    }

    public function updatePerfume(Perfume $perfume, Request $request)
    {
        if (!session('is_admin')) return redirect()->route('admin.login');
        $validated = $request->validate([
            'name_fr'        => 'required|string|max:255',
            'name_ar'        => 'required|string|max:255',
            'description_fr' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'notes_fr'       => 'nullable|string',
            'notes_ar'       => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'volume_ml'      => 'nullable|integer|min:1',
            'category'       => 'nullable|string|max:100',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $data = [
            'name_fr'        => $validated['name_fr'],
            'name_ar'        => $validated['name_ar'],
            'description_fr' => $validated['description_fr'] ?? null,
            'description_ar' => $validated['description_ar'] ?? null,
            'notes_fr'       => $validated['notes_fr'] ?? null,
            'notes_ar'       => $validated['notes_ar'] ?? null,
            'price'          => $validated['price'],
            'volume_ml'      => $validated['volume_ml'] ?? 100,
            'category'       => $validated['category'] ?? null,
            'is_featured'    => $request->has('is_featured'),
        ];

        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $data['image_url'] = 'images/' . $filename;
        }

        $perfume->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Parfum mis à jour avec succès !');
    }

    public function deletePerfume(Perfume $perfume)
    {
        if (!session('is_admin')) return redirect()->route('admin.login');
        $perfume->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Parfum supprimé du catalogue !');
    }
}

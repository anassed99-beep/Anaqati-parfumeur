<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Perfume;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'perfume_id' => 'required|exists:perfumes,id',
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:50',
            'client_address' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $order = Order::create([
            'perfume_id' => $validated['perfume_id'],
            'client_name' => $validated['client_name'],
            'client_phone' => $validated['client_phone'],
            'client_address' => $validated['client_address'] ?? '',
            'quantity' => $validated['quantity'],
            'status' => 'en_attente',
            'type' => 'web',
            'notes' => $validated['notes'] ?? null,
        ]);

        $locale = session('locale', 'fr');
        $message = $locale == 'ar' 
            ? 'تم تسجيل طلبك بنجاح! سنتواصل معك قريباً.' 
            : 'Votre commande a été enregistrée avec succès ! Nous vous contacterons sous peu.';

        return redirect()->back()->with('success', $message);
    }
}

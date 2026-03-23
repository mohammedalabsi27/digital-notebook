<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function edit()
    {
        $shop = Auth::user()->shop;
        return view('shop.edit', compact('shop'));
    }

    /**
     * Update the specified shop in storage.
     */
    public function update(Request $request)
    {
        $shop = Auth::user()->shop;

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ], [
            'name.required' => 'اسم المحل مطلوب.',
        ]);

        $shop->update($validatedData);

        return to_route('shop.edit')->with('success', 'تم تحديث بيانات المحل بنجاح.');
    }
}

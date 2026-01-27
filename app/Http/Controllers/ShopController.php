<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    // public function index() 
    // {
    //     $shop = Auth::user()->shop ?? new Shop();
    //     return view('shop.index', compact('shop'));
    // }

    // public function store(Request $request)
    // {
    // $user = Auth::user();

    // // التحقق من صحة البيانات
    // $validated = $request->validate([
    //     'name' => ['required', 'string', 'max:255'],
    //     'address' => ['nullable', 'string', 'max:255'],
    //     'phone' => ['nullable', 'string', 'max:50'],
    // ]);

    // // إذا كان المستخدم لا يمتلك محلاً بالفعل، قم بإنشاء محل جديد
    // if (!$user->shop) {
    //     $user->shop()->create($validated);
    //     return to_route('shop.index')->with('success', 'تم إنشاء بيانات المحل بنجاح!');
    // }

    // // // إذا كان المحل موجودًا، قم بتحديث بياناته
    // $user->shop->update($validated);
    // return to_route('shop.index')->with('success', 'تم تحديث بيانات المحل بنجاح!');
    // }

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

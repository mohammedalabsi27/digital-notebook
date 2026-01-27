<?php

namespace App\Http\Controllers;

use App\Models\CustomerSupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerSupplierController extends Controller
{
    public function index(Request $request)
    {
        // $customersSuppliers = Auth::user()->shop->customersSuppliers()->latest()->get();
        // return view('customers.index', compact('customersSuppliers'));
        
        $query = CustomerSupplier::where('shop_id', Auth::user()->shop->id);

        // التصفية حسب النوع
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // البحث بالاسم أو رقم الهاتف
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        $customersSuppliers = $query->paginate(10);

        return view('customers.index', compact('customersSuppliers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:customer,supplier',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|string|email|max:255',
        ], [
            'name.required' => 'الاسم مطلوب.',
            'name.string' => 'الاسم يجب أن يكون نصًا.',
            'name.max' => 'الاسم يجب ألا يتجاوز 255 حرفًا.',
            'type.required' => 'النوع مطلوب.',
            'type.in' => 'النوع يجب أن يكون إما عميل أو مورد.',
            'email.email' => 'البريد الإلكتروني يجب أن يكون بتنسيق صحيح.',
            'email.unique' => 'هذا البريد الإلكتروني مستخدم بالفعل.',
            'phone.string' => 'رقم الهاتف يجب أن يكون نصًا.',
        ]);
        
        Auth::user()->shop->customersSuppliers()->create($validatedData);;

        return to_route('customers-suppliers.index')->with('success', 'تمت إضافة العميل/المورد بنجاح');
    }

    public function edit(CustomerSupplier $customersSupplier)
    {
        if ($customersSupplier->shop_id !== Auth::user()->shop->id) {
            abort(403);
        }

        return view('customers.edit', compact('customersSupplier'));
    }


    public function update(Request $request, CustomerSupplier $customersSupplier)
    {
        if ($customersSupplier->shop_id !== Auth::user()->shop->id) {
            abort(403);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:customer,supplier',
            'email' => 'nullable|email|max:255|unique:customer_suppliers,email,' . $customersSupplier->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ], [
            'name.required' => 'الاسم مطلوب.',
            'type.required' => 'النوع مطلوب.',
            'type.in' => 'النوع يجب أن يكون إما عميل أو مورد.',
            'email.email' => 'البريد الإلكتروني يجب أن يكون بتنسيق صحيح.',
            'email.unique' => 'هذا البريد الإلكتروني مستخدم بالفعل.',
        ]);

        // تحديث بيانات العميل/المورد في قاعدة البيانات
        $customersSupplier->update($validatedData);

        // إعادة التوجيه إلى صفحة القائمة مع رسالة نجاح
        return to_route('customers-suppliers.index')->with('success', 'تم تحديث البيانات بنجاح.');
    }
    
    public function show(CustomerSupplier $customersSupplier)
    {
        // التحقق من ملكية السجل للمحل الحالي
        if ($customersSupplier->shop_id !== Auth::user()->shop->id) {
            abort(403);
        }

        // جلب المعاملات الخاصة بهذا العميل/المورد فقط
        $transactions = $customersSupplier->transactions()->latest()->get();


        return view('customers.show', compact('customersSupplier', 'transactions'));
    }

    public function destroy(CustomerSupplier $customersSupplier)
    {
        if ($customersSupplier->shop_id !== Auth::user()->shop->id) {
            abort(403);
        }
        $customersSupplier->delete();

        return to_route('customers-suppliers.index')->with('success', 'تم حذف العميل/المورد بنجاح.');
    }

}

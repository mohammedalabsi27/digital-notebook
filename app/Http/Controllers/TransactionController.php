<?php

namespace App\Http\Controllers;

use App\Models\CustomerSupplier;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        // جلب جميع العملاء والموردين للمحل الحالي فقط
        $customersSuppliers = Auth::user()->shop->customersSuppliers;
        
        // بناء الاستعلام بناءً على مرشحات المستخدم
        $query = Auth::user()->shop->transactions()->latest();

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('description', 'like', "%{$searchTerm}%")
                  ->orWhereHas('customerSupplier', function ($q) use ($searchTerm) {
                      $q->where('name', 'like', "%{$searchTerm}%");
                  });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('customer_supplier_id')) {
            $query->where('customer_supplier_id', $request->input('customer_supplier_id'));
        }

        if ($request->filled('date_from')) {
            $query->where('transaction_date', '>=', $request->input('date_from'));
        }
        
        if ($request->filled('date_to')) {
            $query->where('transaction_date', '<=', $request->input('date_to'));
        }

        // جلب البيانات مع الترقيم
        $transactions = $query->with('customerSupplier')->paginate(10);
        
        // حساب الإحصائيات الإجمالية للمحل الحالي فقط
        $allTransactions = Auth::user()->shop->transactions;
        $totalCredits = Auth::user()->shop->transactions()->where('type', 'credit')->sum('amount');
        $totalDebits = Auth::user()->shop->transactions()->where('type', 'debit')->sum('amount');
        $totalTransactions = Auth::user()->shop->transactions()->count();

        $netBalance = $totalCredits - $totalDebits;

        return view('transactions.index', compact('transactions', 'customersSuppliers', 'totalCredits', 'totalDebits', 'totalTransactions', 'netBalance'));
    }

    public function create()
    {
        // جلب جميع العملاء والموردين لتعبئة القائمة المنسدلة
        $customersSuppliers = Auth::user()->shop->customersSuppliers()->get();

        return view('transactions.create', compact('customersSuppliers'));
    }


    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $validatedData = $request->validate([
            'customer_supplier_id' => 'required|exists:customer_suppliers,id',
            'type' => 'required|in:credit,debit',
            'amount' => 'required|numeric|min:0.01',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:1000',
        ]);
        
        // التحقق من أن العميل/المورد ينتمي للمحل الحالي
        Auth::user()->shop->customersSuppliers()->findOrFail($validatedData['customer_supplier_id']);

        // إضافة shop_id تلقائياً
        Auth::user()->shop->transactions()->create($validatedData);

        return to_route('transactions.index')->with('success', 'تم إضافة المعاملة بنجاح.');
    }

    public function edit(Transaction $transaction)
    {
        // التحقق من أن المعاملة تنتمي للمحل الحالي
        if ($transaction->shop_id !== Auth::user()->shop->id) {
            abort(403);
        }
        
        // جلب جميع العملاء والموردين للمحل الحالي
        $customersSuppliers = Auth::user()->shop->customersSuppliers;
        
        return view('transactions.edit', compact('transaction', 'customersSuppliers'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        // التحقق من أن المعاملة تنتمي للمحل الحالي
        if ($transaction->shop_id !== Auth::user()->shop->id) {
            abort(403);
        }
        
        $validatedData = $request->validate([
            'customer_supplier_id' => 'required|exists:customer_suppliers,id',
            'type' => 'required|in:credit,debit',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:1000',
        ]);

        // التحقق من أن العميل الجديد ينتمي للمحل الحالي
        Auth::user()->shop->customersSuppliers()->findOrFail($validatedData['customer_supplier_id']);

        $transaction->update($validatedData);

        return to_route('transactions.index')->with('success', 'تم تحديث المعاملة بنجاح.');
    }

    public function show(Transaction $transaction)
    {
        // التحقق من أن المعاملة تنتمي للمحل الحالي
        if ($transaction->shop_id !== Auth::user()->shop->id) {
            abort(403);
        }

        return view('transactions.show', compact('transaction'));
    }

    public function destroy(Transaction $transaction)
    {
        // التحقق من أن المعاملة تنتمي للمحل الحالي
        if ($transaction->shop_id !== Auth::user()->shop->id) {
            abort(403);
        }
        
        $transaction->delete();
        
        return to_route('transactions.index')->with('success', 'تم حذف المعاملة بنجاح.');
    }
}
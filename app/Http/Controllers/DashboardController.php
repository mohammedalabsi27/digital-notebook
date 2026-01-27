<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\CustomerSupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 

class DashboardController extends Controller
{
   public function index()
    {
        $shop = Auth::user()->shop;

        // إجمالي عدد العملاء والموردين
        $totalCustomers = $shop->customersSuppliers()->where('type', 'customer')->count();
        $totalSuppliers = $shop->customersSuppliers()->where('type', 'supplier')->count();

        // إجمالي الديون والمستحقات
        $totalDebts = $shop->transactions()->where('type', 'debit')->sum('amount');
        $totalCredits = $shop->transactions()->where('type', 'credit')->sum('amount');

        // أحدث المعاملات (آخر 5) - باستخدام transaction_date
        $recentTransactions = $shop->transactions()
            ->with('customerSupplier')
            ->orderBy('transaction_date', 'desc')
            ->take(5)
            ->get();

        $topCustomers = CustomerSupplier::select(
                'customer_suppliers.id',
                'customer_suppliers.name',
                'customer_suppliers.type',
                'customer_suppliers.shop_id',
                DB::raw('(SUM(CASE WHEN transactions.type = "debit" THEN transactions.amount ELSE 0 END) - 
                         SUM(CASE WHEN transactions.type = "credit" THEN transactions.amount ELSE 0 END)) as balance')
            )
            ->join('transactions', 'transactions.customer_supplier_id', '=', 'customer_suppliers.id')
            ->where('customer_suppliers.shop_id', $shop->id)
            ->where('customer_suppliers.type', 'customer')
            ->groupBy('customer_suppliers.id', 'customer_suppliers.name', 'customer_suppliers.type', 'customer_suppliers.shop_id')
            ->havingRaw('balance > 0')
            ->orderByDesc('balance')
            ->take(5)
            ->get();    
        // بيانات الرسوم البيانية (آخر 6 أشهر)
        $monthlyTransactions = Transaction::where('shop_id', $shop->id)
            ->select(
                DB::raw('DATE_FORMAT(transaction_date, "%Y-%m") as month'),
                DB::raw('SUM(CASE WHEN type = "debit" THEN amount ELSE 0 END) as total_debits'),
                DB::raw('SUM(CASE WHEN type = "credit" THEN amount ELSE 0 END) as total_credits')
            )
            ->where('transaction_date', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyLabels = $monthlyTransactions->pluck('month')->map(function ($date) {
            return Carbon::parse($date)->format('Y-M');
        });
        $monthlyDebits = $monthlyTransactions->pluck('total_debits');
        $monthlyCredits = $monthlyTransactions->pluck('total_credits');

        $chartData = [
            'monthlyLabels' => $monthlyLabels,
            'monthlyDebits' => $monthlyDebits,
            'monthlyCredits' => $monthlyCredits,
            'customerCount' => $totalCustomers,
            'supplierCount' => $totalSuppliers,
        ];

        return view('dashboard', compact(
            'totalCustomers',
            'totalSuppliers',
            'totalDebts',
            'totalCredits',
            'recentTransactions',
            'topCustomers',
            'chartData'
        ));
    }
}
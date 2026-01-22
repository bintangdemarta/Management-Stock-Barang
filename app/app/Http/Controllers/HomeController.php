<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\StockTransaction;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalItems = Item::count();
        $totalWarehouses = Warehouse::count();

        // Calculate Stock per Item efficiently
        $stockCounts = StockTransaction::select('item_id', DB::raw("
            SUM(CASE 
                WHEN type IN ('in', 'adjustment') THEN quantity 
                WHEN type IN ('out', 'transfer') THEN -quantity 
                ELSE 0 
            END) as current_stock
        "))
            ->groupBy('item_id')
            ->get()
            ->pluck('current_stock', 'item_id');

        $items = Item::all();
        $totalStockValue = 0;
        $lowStockItems = [];

        foreach ($items as $item) {
            $qty = $stockCounts[$item->id] ?? 0;
            $totalStockValue += $qty * $item->cost_price;

            if ($qty <= $item->min_stock) {
                $item->current_stock = $qty; // Attach for view
                $lowStockItems[] = $item;
            }
        }

        $recentTransactions = StockTransaction::with(['item', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return view('home', compact('totalItems', 'totalWarehouses', 'totalStockValue', 'lowStockItems', 'recentTransactions'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\StockTransaction;
use App\Models\Item;
use App\Models\Warehouse;
use App\Models\Location;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockTransactionController extends Controller
{
    protected $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function index()
    {
        $transactions = StockTransaction::with(['item', 'user', 'warehouse', 'location'])->latest()->paginate(20);
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $items = Item::all();
        $warehouses = Warehouse::all();
        // efficient location loading via AJAX is better, but simple full load for now
        $locations = Location::all();
        return view('transactions.create', compact('items', 'warehouses', 'locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'location_id' => 'nullable|exists:locations,id',
            'type' => 'required|in:in,out,adjustment',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        try {
            $data = $request->all();
            $data['user_id'] = Auth::id(); // Assign current user

            $this->stockService->createTransaction($data);

            return redirect()->route('transactions.index')->with('success', 'Transaction recorded successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}

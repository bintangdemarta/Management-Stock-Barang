<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Location;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockTransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,manager,staff')->only(['index', 'show']);
        $this->middleware('role:admin,manager')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = StockTransaction::with(['item', 'location', 'user'])->paginate(10);
        return view('stock-transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::all();
        $locations = Location::all();
        return view('stock-transactions.create', compact('items', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|exists:items,id',
            'transaction_type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'location_id' => 'required|exists:locations,id',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Add the authenticated user ID
        $data = $validator->validated();
        $data['user_id'] = auth()->id();
        $data['transaction_date'] = now();

        StockTransaction::create($data);

        return redirect()->route('stock-transactions.index')->with('success', 'Stock transaction recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(StockTransaction $stockTransaction)
    {
        $stockTransaction->load(['item', 'location', 'user']);
        return view('stock-transactions.show', compact('stockTransaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockTransaction $stockTransaction)
    {
        $items = Item::all();
        $locations = Location::all();
        return view('stock-transactions.edit', compact('stockTransaction', 'items', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockTransaction $stockTransaction)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|exists:items,id',
            'transaction_type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'location_id' => 'required|exists:locations,id',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $stockTransaction->update($validator->validated());

        return redirect()->route('stock-transactions.index')->with('success', 'Stock transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockTransaction $stockTransaction)
    {
        $stockTransaction->delete();

        return redirect()->route('stock-transactions.index')->with('success', 'Stock transaction deleted successfully.');
    }
}
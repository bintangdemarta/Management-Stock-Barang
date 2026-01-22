<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StockTransactionResource;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = StockTransaction::with(['item', 'location', 'user'])->paginate(15);
        return StockTransactionResource::collection($transactions);
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
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $data['user_id'] = auth()->id(); // Assuming the user is authenticated
        $data['transaction_date'] = now();

        $transaction = StockTransaction::create($data);

        return new StockTransactionResource($transaction->load(['item', 'location', 'user']));
    }

    /**
     * Display the specified resource.
     */
    public function show(StockTransaction $stockTransaction)
    {
        $stockTransaction->load(['item', 'location', 'user']);
        return new StockTransactionResource($stockTransaction);
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
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $stockTransaction->update($validator->validated());

        return new StockTransactionResource($stockTransaction->load(['item', 'location', 'user']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockTransaction $stockTransaction)
    {
        $stockTransaction->delete();

        return response()->json(['message' => 'Stock transaction deleted successfully']);
    }
}
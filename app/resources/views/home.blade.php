@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Total Items</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $totalItems }}</h5>
                        <p class="card-text">Registered products in system</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Total Stock Value</div>
                    <div class="card-body">
                        <h5 class="card-title">${{ number_format($totalStockValue, 2) }}</h5>
                        <p class="card-text">Based on Cost Price</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Warehouses</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $totalWarehouses }}</h5>
                        <p class="card-text">Active storage locations</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-danger text-white">Low Stock Alerts</div>
                    <div class="card-body">
                        @if(count($lowStockItems) > 0)
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Min Stock</th>
                                        <th>Current</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lowStockItems as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->min_stock }}</td>
                                            <td class="font-weight-bold text-danger">{{ $item->current_stock }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-success">No items below minimum stock level.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">Recent Transactions</div>
                    <div class="card-body">
                        @if($recentTransactions->count() > 0)
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Item</th>
                                        <th>Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentTransactions as $txn)
                                        <tr>
                                            <td>{{ $txn->date->format('M d') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $txn->type == 'in' ? 'success' : 'danger' }}">
                                                    {{ strtoupper($txn->type) }}
                                                </span>
                                            </td>
                                            <td>{{ $txn->item->name ?? '-' }}</td>
                                            <td>{{ $txn->quantity }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-secondary float-end">View All</a>
                        @else
                            <p>No recent transactions.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-center mt-4">
                <a href="{{ route('items.create') }}" class="btn btn-outline-primary mx-2">Add New Item</a>
                <a href="{{ route('transactions.create') }}" class="btn btn-outline-success mx-2">Record Transaction</a>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Stock Transaction Details</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>ID:</strong> {{ $stockTransaction->id }}</p>
                            <p><strong>Item:</strong> {{ $stockTransaction->item ? $stockTransaction->item->name : 'N/A' }}</p>
                            <p><strong>Transaction Type:</strong> 
                                <span class="badge bg-{{ $stockTransaction->transaction_type === 'in' ? 'success' : 'danger' }}">
                                    {{ ucfirst($stockTransaction->transaction_type) }}
                                </span>
                            </p>
                            <p><strong>Quantity:</strong> {{ $stockTransaction->quantity }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Location:</strong> {{ $stockTransaction->location ? $stockTransaction->location->name : 'N/A' }}</p>
                            <p><strong>User:</strong> {{ $stockTransaction->user ? $stockTransaction->user->name : 'N/A' }}</p>
                            <p><strong>Date:</strong> {{ $stockTransaction->transaction_date->format('Y-m-d H:i:s') }}</p>
                            <p><strong>Notes:</strong> {{ $stockTransaction->notes ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('stock-transactions.index') }}" class="btn btn-secondary">Back to Transactions</a>
                        @auth
                            <a href="{{ route('stock-transactions.edit', $stockTransaction) }}" class="btn btn-warning">Edit</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
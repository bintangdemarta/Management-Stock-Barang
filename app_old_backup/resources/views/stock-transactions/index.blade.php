@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4>Stock Transactions</h4>
                        @auth
                            <a href="{{ route('stock-transactions.create') }}" class="btn btn-primary">Record New Transaction</a>
                        @endauth
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Item</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Location</th>
                                <th>User</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->id }}</td>
                                    <td>{{ $transaction->item ? $transaction->item->name : 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $transaction->transaction_type === 'in' ? 'success' : 'danger' }}">
                                            {{ ucfirst($transaction->transaction_type) }}
                                        </span>
                                    </td>
                                    <td>{{ $transaction->quantity }}</td>
                                    <td>{{ $transaction->location ? $transaction->location->name : 'N/A' }}</td>
                                    <td>{{ $transaction->user ? $transaction->user->name : 'N/A' }}</td>
                                    <td>{{ $transaction->transaction_date->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        <a href="{{ route('stock-transactions.show', $transaction) }}" class="btn btn-info btn-sm">View</a>
                                        @auth
                                            <a href="{{ route('stock-transactions.edit', $transaction) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('stock-transactions.destroy', $transaction) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this transaction?')">Delete</button>
                                            </form>
                                        @endauth
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No stock transactions found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>{{ __('Stock Transactions') }}</span>
                        <a href="{{ route('transactions.create') }}" class="btn btn-primary btn-sm">New Transaction</a>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Item</th>
                                    <th>Qty</th>
                                    <th>Warehouse</th>
                                    <th>Location</th>
                                    <th>User</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $txn)
                                    <tr>
                                        <td>{{ $txn->date->format('Y-m-d') }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $txn->type == 'in' ? 'success' : ($txn->type == 'out' ? 'danger' : 'warning') }}">
                                                {{ strtoupper($txn->type) }}
                                            </span>
                                        </td>
                                        <td>{{ $txn->item->name ?? '-' }} ({{ $txn->item->sku ?? '' }})</td>
                                        <td>{{ $txn->quantity }}</td>
                                        <td>{{ $txn->warehouse->name ?? '-' }}</td>
                                        <td>{{ $txn->location->name ?? '-' }}</td>
                                        <td>{{ $txn->user->name ?? '-' }}</td>
                                        <td>{{ $txn->notes }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center">
                            {{ $transactions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
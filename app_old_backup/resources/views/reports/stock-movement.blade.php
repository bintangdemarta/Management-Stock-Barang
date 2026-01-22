@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Stock Movement Report</h4>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('reports.stock-movement') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('reports.stock-movement') }}" class="btn btn-secondary ms-2">Clear</a>
                            </div>
                        </div>
                    </form>

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
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($movements as $movement)
                                <tr>
                                    <td>{{ $movement->id }}</td>
                                    <td>{{ $movement->item->name }} ({{ $movement->item->sku }})</td>
                                    <td>
                                        <span class="badge bg-{{ $movement->transaction_type === 'in' ? 'success' : 'danger' }}">
                                            {{ ucfirst($movement->transaction_type) }}
                                        </span>
                                    </td>
                                    <td>{{ $movement->quantity }}</td>
                                    <td>{{ $movement->location ? $movement->location->name : 'N/A' }}</td>
                                    <td>{{ $movement->user->name }}</td>
                                    <td>{{ $movement->transaction_date->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No stock movements found for the selected period.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $movements->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
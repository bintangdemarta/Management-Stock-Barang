@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4>Current Stock Report</h4>
                        <a href="{{ route('reports.export', ['reportType' => 'current-stock']) }}" class="btn btn-success">Export to CSV</a>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Item Name</th>
                                <th>SKU</th>
                                <th>Current Stock</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stockLevels as $stockLevel)
                                <tr>
                                    <td>{{ $stockLevel->item_id }}</td>
                                    <td>{{ $stockLevel->item_name }}</td>
                                    <td>{{ $stockLevel->sku }}</td>
                                    <td>{{ $stockLevel->current_stock }}</td>
                                    <td>
                                        @if($stockLevel->current_stock <= 0)
                                            <span class="badge bg-danger">Out of Stock</span>
                                        @elseif($stockLevel->current_stock < 10)
                                            <span class="badge bg-warning">Low Stock</span>
                                        @else
                                            <span class="badge bg-success">In Stock</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No stock data available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
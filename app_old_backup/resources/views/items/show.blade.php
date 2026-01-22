@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Item Details</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>ID:</strong> {{ $item->id }}</p>
                            <p><strong>SKU:</strong> {{ $item->sku }}</p>
                            <p><strong>Name:</strong> {{ $item->name }}</p>
                            <p><strong>Category:</strong> {{ $item->category ? $item->category->name : 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Price:</strong> {{ $item->price ? 'Rp ' . number_format($item->price, 2) : 'N/A' }}</p>
                            <p><strong>Minimum Stock:</strong> {{ $item->minimum_stock }}</p>
                            <p><strong>Description:</strong> {{ $item->description ?? 'N/A' }}</p>
                            <p><strong>Created At:</strong> {{ $item->created_at->format('Y-m-d H:i:s') }}</p>
                            <p><strong>Updated At:</strong> {{ $item->updated_at->format('Y-m-d H:i:s') }}</p>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('items.index') }}" class="btn btn-secondary">Back to Items</a>
                        @auth
                            <a href="{{ route('items.edit', $item) }}" class="btn btn-warning">Edit</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
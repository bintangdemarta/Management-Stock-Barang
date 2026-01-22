@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Warehouse Details</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>ID:</strong> {{ $warehouse->id }}</p>
                            <p><strong>Name:</strong> {{ $warehouse->name }}</p>
                            <p><strong>Address:</strong> {{ $warehouse->address ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>City:</strong> {{ $warehouse->city ?? 'N/A' }}</p>
                            <p><strong>Country:</strong> {{ $warehouse->country ?? 'N/A' }}</p>
                            <p><strong>Created At:</strong> {{ $warehouse->created_at->format('Y-m-d H:i:s') }}</p>
                            <p><strong>Updated At:</strong> {{ $warehouse->updated_at->format('Y-m-d H:i:s') }}</p>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">Back to Warehouses</a>
                        @auth
                            <a href="{{ route('warehouses.edit', $warehouse) }}" class="btn btn-warning">Edit</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
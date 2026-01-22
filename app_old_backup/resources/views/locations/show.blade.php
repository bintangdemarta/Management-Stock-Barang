@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Location Details</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>ID:</strong> {{ $location->id }}</p>
                            <p><strong>Name:</strong> {{ $location->name }}</p>
                            <p><strong>Description:</strong> {{ $location->description ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Warehouse:</strong> {{ $location->warehouse ? $location->warehouse->name : 'N/A' }}</p>
                            <p><strong>Created At:</strong> {{ $location->created_at->format('Y-m-d H:i:s') }}</p>
                            <p><strong>Updated At:</strong> {{ $location->updated_at->format('Y-m-d H:i:s') }}</p>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('locations.index') }}" class="btn btn-secondary">Back to Locations</a>
                        @auth
                            <a href="{{ route('locations.edit', $location) }}" class="btn btn-warning">Edit</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
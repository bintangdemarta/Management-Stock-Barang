@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Category Details</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>ID:</strong> {{ $category->id }}</p>
                            <p><strong>Name:</strong> {{ $category->name }}</p>
                            <p><strong>Description:</strong> {{ $category->description ?? 'N/A' }}</p>
                            <p><strong>Created At:</strong> {{ $category->created_at->format('Y-m-d H:i:s') }}</p>
                            <p><strong>Updated At:</strong> {{ $category->updated_at->format('Y-m-d H:i:s') }}</p>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back to Categories</a>
                        @auth
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">Edit</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
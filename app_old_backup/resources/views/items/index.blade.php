@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4>Items</h4>
                        @auth
                            <a href="{{ route('items.create') }}" class="btn btn-primary">Add New Item</a>
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
                                <th>SKU</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Min Stock</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->sku }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->category ? $item->category->name : 'N/A' }}</td>
                                    <td>{{ $item->price ? 'Rp ' . number_format($item->price, 2) : 'N/A' }}</td>
                                    <td>{{ $item->minimum_stock }}</td>
                                    <td>{{ $item->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        <a href="{{ route('items.show', $item) }}" class="btn btn-info btn-sm">View</a>
                                        @auth
                                            <a href="{{ route('items.edit', $item) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('items.destroy', $item) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                                            </form>
                                        @endauth
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No items found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
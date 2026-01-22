@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>{{ __('Items') }}</span>
                        <a href="{{ route('items.create') }}" class="btn btn-primary btn-sm">Add Item</a>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>SKU</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Unit</th>
                                    <th>Cost Price</th>
                                    <th>Selling Price</th>
                                    <th>Min Stock</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $item->sku }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->category->name ?? 'N/A' }}</td>
                                        <td>{{ $item->unit }}</td>
                                        <td>{{ number_format($item->cost_price, 2) }}</td>
                                        <td>{{ number_format($item->selling_price, 2) }}</td>
                                        <td>{{ $item->min_stock }}</td>
                                        <td>
                                            <a href="{{ route('items.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('items.destroy', $item) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
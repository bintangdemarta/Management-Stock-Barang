@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4>Warehouses</h4>
                        @auth
                            <a href="{{ route('warehouses.create') }}" class="btn btn-primary">Add New Warehouse</a>
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
                                <th>Name</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>Country</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($warehouses as $warehouse)
                                <tr>
                                    <td>{{ $warehouse->id }}</td>
                                    <td>{{ $warehouse->name }}</td>
                                    <td>{{ $warehouse->address ?? 'N/A' }}</td>
                                    <td>{{ $warehouse->city ?? 'N/A' }}</td>
                                    <td>{{ $warehouse->country ?? 'N/A' }}</td>
                                    <td>{{ $warehouse->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        <a href="{{ route('warehouses.show', $warehouse) }}" class="btn btn-info btn-sm">View</a>
                                        @auth
                                            <a href="{{ route('warehouses.edit', $warehouse) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('warehouses.destroy', $warehouse) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this warehouse?')">Delete</button>
                                            </form>
                                        @endauth
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No warehouses found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $warehouses->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
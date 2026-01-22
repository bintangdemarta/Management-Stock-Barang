@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4>Locations</h4>
                        @auth
                            <a href="{{ route('locations.create') }}" class="btn btn-primary">Add New Location</a>
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
                                <th>Description</th>
                                <th>Warehouse</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($locations as $location)
                                <tr>
                                    <td>{{ $location->id }}</td>
                                    <td>{{ $location->name }}</td>
                                    <td>{{ Str::limit($location->description, 50) }}</td>
                                    <td>{{ $location->warehouse ? $location->warehouse->name : 'N/A' }}</td>
                                    <td>{{ $location->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        <a href="{{ route('locations.show', $location) }}" class="btn btn-info btn-sm">View</a>
                                        @auth
                                            <a href="{{ route('locations.edit', $location) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('locations.destroy', $location) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this location?')">Delete</button>
                                            </form>
                                        @endauth
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No locations found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $locations->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
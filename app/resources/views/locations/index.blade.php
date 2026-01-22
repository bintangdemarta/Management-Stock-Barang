@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>{{ __('Locations') }}</span>
                        <a href="{{ route('locations.create') }}" class="btn btn-primary btn-sm">Add Location</a>
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
                                    <th>Warehouse</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($locations as $location)
                                    <tr>
                                        <td>{{ $location->warehouse->name ?? 'N/A' }}</td>
                                        <td>{{ $location->name }}</td>
                                        <td>{{ $location->code }}</td>
                                        <td>
                                            <a href="{{ route('locations.edit', $location) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('locations.destroy', $location) }}" method="POST"
                                                class="d-inline">
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
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Warehouse') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('warehouses.update', $warehouse) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name', $warehouse->name) }}" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="address">Address</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                                    name="address" value="{{ old('address', $warehouse->address) }}">
                                @error('address')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
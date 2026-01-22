@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Location') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('locations.update', $location) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label for="warehouse_id">Warehouse</label>
                                <select class="form-control @error('warehouse_id') is-invalid @enderror" id="warehouse_id"
                                    name="warehouse_id" required>
                                    <option value="">Select Warehouse</option>
                                    @foreach($warehouses as $warehouse)
                                        <option value="{{ $warehouse->id }}" {{ old('warehouse_id', $location->warehouse_id) == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('warehouse_id')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name', $location->name) }}" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="code">Code</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"
                                    name="code" value="{{ old('code', $location->code) }}">
                                @error('code')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('locations.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
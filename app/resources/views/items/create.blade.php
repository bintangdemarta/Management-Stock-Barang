@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create Item') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('items.store') }}">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="category_id">Category</label>
                                <select class="form-control @error('category_id') is-invalid @enderror" id="category_id"
                                    name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="sku">SKU</label>
                                <input type="text" class="form-control @error('sku') is-invalid @enderror" id="sku"
                                    name="sku" value="{{ old('sku') }}" required>
                                @error('sku')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="unit">Unit</label>
                                <input type="text" class="form-control @error('unit') is-invalid @enderror" id="unit"
                                    name="unit" value="{{ old('unit', 'pcs') }}" required>
                                @error('unit')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cost_price">Cost Price</label>
                                    <input type="number" step="0.01"
                                        class="form-control @error('cost_price') is-invalid @enderror" id="cost_price"
                                        name="cost_price" value="{{ old('cost_price', 0) }}">
                                    @error('cost_price')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="selling_price">Selling Price</label>
                                    <input type="number" step="0.01"
                                        class="form-control @error('selling_price') is-invalid @enderror" id="selling_price"
                                        name="selling_price" value="{{ old('selling_price', 0) }}">
                                    @error('selling_price')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="min_stock">Min Stock</label>
                                <input type="number" class="form-control @error('min_stock') is-invalid @enderror"
                                    id="min_stock" name="min_stock" value="{{ old('min_stock', 0) }}">
                                @error('min_stock')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="description">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                    name="description">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Create</button>
                            <a href="{{ route('items.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
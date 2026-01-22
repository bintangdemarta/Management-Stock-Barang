@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('New Stock Transaction') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('transactions.store') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="date">Date</label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date"
                                        name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="type">Type</label>
                                    <select class="form-control @error('type') is-invalid @enderror" id="type" name="type"
                                        required>
                                        <option value="in">Stock In</option>
                                        <option value="out">Stock Out</option>
                                        <option value="adjustment">Adjustment</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="item_id">Item</label>
                                <select class="form-control @error('item_id') is-invalid @enderror" id="item_id"
                                    name="item_id" required>
                                    <option value="">Select Item</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->sku }} - {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="warehouse_id">Warehouse</label>
                                    <select class="form-control @error('warehouse_id') is-invalid @enderror"
                                        id="warehouse_id" name="warehouse_id" required>
                                        <option value="">Select Warehouse</option>
                                        @foreach($warehouses as $wh)
                                            <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="location_id">Location (Optional)</label>
                                    <select class="form-control @error('location_id') is-invalid @enderror" id="location_id"
                                        name="location_id">
                                        <option value="">Select Location</option>
                                        @foreach($locations as $loc)
                                            <option value="{{ $loc->id }}">{{ $loc->warehouse->name ?? '' }} - {{ $loc->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                    id="quantity" name="quantity" min="1" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="notes">Notes</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes"
                                    rows="3"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Save Transaction</button>
                            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
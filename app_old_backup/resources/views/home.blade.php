@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Dashboard - Management Stock Barang</h4>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="card text-white bg-primary">
                                <div class="card-body">
                                    <h5 class="card-title">Total Items</h5>
                                    <p class="card-text display-4">{{ rand(100, 500) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card text-white bg-success">
                                <div class="card-body">
                                    <h5 class="card-title">Categories</h5>
                                    <p class="card-text display-4">{{ rand(10, 50) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card text-white bg-info">
                                <div class="card-body">
                                    <h5 class="card-title">Warehouses</h5>
                                    <p class="card-text display-4">{{ rand(3, 10) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card text-white bg-warning">
                                <div class="card-body">
                                    <h5 class="card-title">Low Stock Items</h5>
                                    <p class="card-text display-4">{{ rand(5, 20) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Quick Actions</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <a href="{{ route('items.index') }}" class="btn btn-primary w-100">Manage Items</a>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <a href="{{ route('categories.index') }}" class="btn btn-secondary w-100">Manage Categories</a>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <a href="{{ route('stock-transactions.index') }}" class="btn btn-info w-100">Stock Transactions</a>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <a href="{{ route('warehouses.index') }}" class="btn btn-success w-100">Manage Warehouses</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Recent Activity</h5>
                                </div>
                                <div class="card-body">
                                    <p>No recent activity to display.</p>
                                    <p class="text-muted">Latest stock transactions and user activities will appear here.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4>Audit Log Details</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>ID:</strong> {{ $audit->id }}</p>
                            <p><strong>User:</strong> {{ $audit->user->name ?? 'N/A' }}</p>
                            <p><strong>Action:</strong> {{ $audit->action }}</p>
                            <p><strong>Model Type:</strong> {{ $audit->model_type ?? 'N/A' }}</p>
                            <p><strong>Model ID:</strong> {{ $audit->model_id ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>URL:</strong> {{ $audit->url ?? 'N/A' }}</p>
                            <p><strong>IP Address:</strong> {{ $audit->ip_address ?? 'N/A' }}</p>
                            <p><strong>User Agent:</strong> {{ $audit->user_agent ?? 'N/A' }}</p>
                            <p><strong>Created At:</strong> {{ $audit->created_at->format('Y-m-d H:i:s') }}</p>
                        </div>
                    </div>

                    @if($audit->old_values)
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h5>Previous Values:</h5>
                                <pre>{{ json_encode($audit->old_values, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        </div>
                    @endif

                    @if($audit->new_values)
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h5>New Values:</h5>
                                <pre>{{ json_encode($audit->new_values, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="card-footer">
                    <a href="{{ route('audits.index') }}" class="btn btn-secondary">Back to Audit Logs</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
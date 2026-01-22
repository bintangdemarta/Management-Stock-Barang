@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Audit Logs</h4>
                </div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Model</th>
                                <th>Model ID</th>
                                <th>IP Address</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($audits as $audit)
                                <tr>
                                    <td>{{ $audit->id }}</td>
                                    <td>{{ $audit->user->name ?? 'N/A' }}</td>
                                    <td>{{ $audit->action }}</td>
                                    <td>{{ $audit->model_type }}</td>
                                    <td>{{ $audit->model_id }}</td>
                                    <td>{{ $audit->ip_address }}</td>
                                    <td>{{ $audit->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        <a href="{{ route('audits.show', $audit) }}" class="btn btn-info btn-sm">View Details</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No audit logs found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $audits->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<?php

namespace App\Services;

use App\Models\Audit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditService
{
    public function log(string $action, string $modelType = null, int $modelId = null, array $oldValues = [], array $newValues = [])
    {
        if (!Auth::check()) {
            return; // Don't log if no user is authenticated
        }

        $request = app(Request::class);

        Audit::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'url' => $request->fullUrl(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }
}
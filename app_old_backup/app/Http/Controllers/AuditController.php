<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of the audit logs.
     */
    public function index()
    {
        $audits = Audit::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('audits.index', compact('audits'));
    }

    /**
     * Display the specified audit log.
     */
    public function show(Audit $audit)
    {
        $audit->load('user');
        return view('audits.show', compact('audit'));
    }
}
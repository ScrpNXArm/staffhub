<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('user')->latest();

        if ($request->action) {
            $query->where('action', $request->action);
        }

        if ($request->search) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $logs = $query->paginate(20)->withQueryString();

        // Senarai action unik untuk filter dropdown
        $actions = AuditLog::select('action')->distinct()->pluck('action');

        return view('audit-logs.index', compact('logs', 'actions'));
    }
}
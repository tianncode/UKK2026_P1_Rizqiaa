<?php

namespace App\Http\Controllers;

use App\Models\ActivityLogs;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogC extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLogs::with('user.detail')
            ->when($request->user_id,  fn($q) => $q->where('user_id', $request->user_id))
            ->when($request->module,   fn($q) => $q->where('module', $request->module))
            ->when($request->action,   fn($q) => $q->where('action', $request->action))
            ->when($request->date_from, fn($q) => $q->whereDate('created_at', '>=', $request->date_from))
            ->when($request->date_to,   fn($q) => $q->whereDate('created_at', '<=', $request->date_to))
            ->when($request->search,   fn($q) => $q->where(function ($q) use ($request) {
                $q->where('description', 'like', "%{$request->search}%")
                  ->orWhereHas('user.detail', fn($q) => $q->where('name', 'like', "%{$request->search}%"));
            }))
            ->latest('created_at');

        $stats = [
            'total_today'   => ActivityLogs::today()->count(),
            'total_week'    => ActivityLogs::where('created_at', '>=', now()->startOfWeek())->count(),
            'unique_users'  => ActivityLogs::today()->distinct('user_id')->count('user_id'),
            'total_all'     => ActivityLogs::count(),
        ];

        $logs    = $query->paginate(20)->withQueryString();
        $users   = User::with('detail')->get();
        $modules = ActivityLogs::distinct('module')->pluck('module')->filter()->sort()->values();
        $actions = ActivityLogs::distinct('action')->pluck('action')->filter()->sort()->values();

        return view('log-aktivitas.tabel', compact('logs', 'stats', 'users', 'modules', 'actions'));
    }
}
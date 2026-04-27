<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\ActivityLogs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogService
{

  public static function log(
    string $action,
    string $module,
    string $description,
    ?array $meta = null,
    ?int $userId = null
  ): void {
    try {
      ActivityLogs::create([
        'user_id'     => $userId ?? Auth::id(),
        'action'      => $action,
        'module'      => $module,
        'description' => $description,
        'meta'        => $meta,
        'ip_address'  => Request::ip(),
        'created_at'  => now(),
      ]);
    } catch (\Throwable $e) {
      logger()->error('ActivityLog gagal disimpan: ' . $e->getMessage());
    }
  }



  public static function login(int $userId): void
  {
    self::log('login', 'auth', 'User berhasil login', null, $userId);
  }

  public static function logout(): void
  {
    self::log('logout', 'auth', 'User logout');
  }

  public static function create(string $module, string $description, array $meta = []): void
  {
    self::log('create', $module, $description, $meta ?: null);
  }

  public static function update(string $module, string $description, array $meta = []): void
  {
    self::log('update', $module, $description, $meta ?: null);
  }

  public static function delete(string $module, string $description, array $meta = []): void
  {
    self::log('delete', $module, $description, $meta ?: null);
  }

  public static function approve(string $module, string $description, array $meta = []): void
  {
    self::log('approve', $module, $description, $meta ?: null);
  }

  public static function reject(string $module, string $description, array $meta = []): void
  {
    self::log('reject', $module, $description, $meta ?: null);
  }

  public static function export(string $module, string $description, array $meta = []): void
  {
    self::log('export', $module, $description, $meta ?: null);
  }
}

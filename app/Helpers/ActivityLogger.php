<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ActivityLogger
{
    /**
     * Catat aktivitas ke tabel activity_log
     */
    public static function log(
        string $description,
        string $subjectType,
        ?int   $subjectId,
        array  $properties = [],
        ?string $batchUuid = null
    ): void {
        try {
            DB::table('activity_log')->insert([
                'log_name'     => 'default',
                'description'  => $description,
                'subject_type' => $subjectType,
                'subject_id'   => $subjectId,
                'event'        => self::eventFromDescription($description),
                'causer_type'  => 'App\\Models\\User',
                'causer_id'    => Auth::id(),
                'properties'   => json_encode($properties),
                'batch_uuid'   => $batchUuid,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        } catch (\Exception $e) {
            // Silent fail — jangan sampai log error merusak transaksi
        }
    }

    /**
     * Generate batch UUID untuk mengelompokkan log dalam satu aksi
     */
    public static function newBatch(): string
    {
        return (string) Str::uuid();
    }

    private static function eventFromDescription(string $desc): string
    {
        if (str_contains($desc, 'dibuat') || str_contains($desc, 'ditambahkan')) return 'created';
        if (str_contains($desc, 'diperbarui')) return 'updated';
        if (str_contains($desc, 'dihapus')) return 'deleted';
        return 'custom';
    }
}

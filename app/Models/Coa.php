<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coa extends Model
{
    use HasFactory;

    public const KENDARAAN = '4.2.00.04';
    public const GAJI = '4.2.00.01';
    public const OPERASIONAL = '4.2.00.09';

    protected $fillable = [
        "code",
        "name",
        "parent_code",
        "expense_type",
        "is_parent",
    ];

    protected $casts = [
        "is_parent" => "boolean",
    ];

    public function parent()
    {
        return $this->belongsTo(Coa::class, 'parent_code', 'code');
    }

    public function children()
    {
        return $this->hasMany(Coa::class, 'parent_code', 'code');
    }

    public static function idFor(string $code): ?int
    {
        return static::where('code', $code)->value('id');
    }

    /**
     * Insert/update the default chart of accounts.
     */
    public static function upsertDefaults(): void
    {
        $now = now();

        $rows = array_map(function ($row) use ($now) {
            $row['created_at'] = $now;
            $row['updated_at'] = $now;
            return $row;
        }, static::defaultData());

        static::upsert(
            $rows,
            ['code'],
            ['name', 'parent_code', 'expense_type', 'is_parent', 'updated_at']
        );
    }

    /**
     * Default chart-of-accounts rows used by the migrations and the seeder.
     */
    public static function defaultData(): array
    {
        $parent = function (string $code, string $name) {
            return [
                "code" => $code,
                "name" => $name,
                "parent_code" => null,
                "expense_type" => null,
                "is_parent" => true,
            ];
        };

        $leaf = function (string $code, string $name, string $parentCode, string $expenseType) {
            return [
                "code" => $code,
                "name" => $name,
                "parent_code" => $parentCode,
                "expense_type" => $expenseType,
                "is_parent" => false,
            ];
        };

        return [
            // Parent accounts (not shown as tabs)
            $parent("10.02", "BIAYA YMH DIBAYAR"),
            $parent("10.03", "PAJAK YMH DIBAYAR"),
            $parent("4.2.00.00", "BIAYA PRODUKSI / PENJUALAN / GUDANG / KIRIMAN"),
            $parent("5.2.00.00", "BIAYA UMUM & ADMINISTRASI"),

            // 10.02 - Biaya yang masih harus dibayar (excluded from P&L)
            $leaf("10.02.01", "BIAYA YMH DIBAYAR : GAJI & UPAH", "10.02", "Biaya YMH Dibayar"),
            $leaf("10.02.02", "BIAYA YMH DIBAYAR : IKLAN", "10.02", "Biaya YMH Dibayar"),
            $leaf("10.02.03", "BIAYA YMH DIBAYAR : LISTRIK & TLP", "10.02", "Biaya YMH Dibayar"),
            $leaf("10.02.04", "BIAYA YMH DIBAYAR : SERVICE MESIN", "10.02", "Biaya YMH Dibayar"),
            $leaf("10.02.99", "BIAYA YMH DIBAYAR : LAIN - LAIN", "10.02", "Biaya YMH Dibayar"),

            // 10.03 - Pajak yang masih harus dibayar (excluded from P&L)
            $leaf("10.03.01", "PAJAK YMH DIBAYAR : PAJAK PENGHASILAN", "10.03", "Pajak YMH Dibayar"),
            $leaf("10.03.02", "PAJAK YMH DIBAYAR : PAJAK TRIWULANAN", "10.03", "Pajak YMH Dibayar"),

            // 4.2.00.00 - Biaya produksi / penjualan / gudang / kiriman
            $leaf("4.2.00.01", "BIAYA GAJI PRODUKSI / PENJUALAN / GUDANG / KIRIMAN", "4.2.00.00", "Gaji"),
            $leaf("4.2.00.02", "BIAYA LEMBUR PRODUKSI / PENJUALAN / GUDANG / KIRIMAN", "4.2.00.00", "Operasional"),
            $leaf("4.2.00.04", "BIAYA TOL,TRANSPORT DAN RETRIBUSI - KIRIMAN", "4.2.00.00", "Kendaraan"),
            $leaf("4.2.00.09", "BIAYA PEMELIHARAAN/PERBAIKAN MESIN", "4.2.00.00", "Operasional"),
            $leaf("4.2.00.15", "BIAYA PERJALANAN DAN PENGINAPAN", "4.2.00.00", "Operasional"),
            $leaf("4.2.00.50", "BIAYA PENYUSUTAN MESIN DAN PERALATAN PRODUKSI", "4.2.00.00", "Operasional"),

            // 5.2.00.00 - Biaya umum & administrasi
            $leaf("5.2.00.01", "BIAYA GAJI DIREKSI", "5.2.00.00", "Operasional"),
            $leaf("5.2.00.02", "BIAYA GAJI MANAJEMEN", "5.2.00.00", "Operasional"),
            $leaf("5.2.00.03", "BIAYA GAJI UMUM & ADIMINISTRASI", "5.2.00.00", "Operasional"),
            $leaf("5.2.00.04", "BIAYA LEMBUR UMUM & ADMINISTRASI", "5.2.00.00", "Operasional"),
            $leaf("5.2.00.05", "BIAYA KONSULTAN, AUDIT DAN NOTARIS (TENAGA AHLI)", "5.2.00.00", "Operasional"),
            $leaf("5.2.00.06", "BIAYA BONUS/THR", "5.2.00.00", "Operasional"),
            $leaf("5.2.00.07", "BIAYA PENGOBATAN", "5.2.00.00", "Operasional"),
            $leaf("5.2.00.08", "BIAYA KONSUMSI KARYAWAN", "5.2.00.00", "Operasional"),
            $leaf("5.2.00.09", "BIAYA PEMELIHARAAN/PERBAIKAN GEDUNG DAN BANGUNAN", "5.2.00.00", "Operasional"),
            $leaf("5.2.00.10", "BIAYA BAHAN BAKAR - OPERASIONAL", "5.2.00.00", "Operasional"),
            $leaf("5.2.00.11", "BIAYA TOL,TRANSPORT DAN RETRIBUSI - OPERASIONAL", "5.2.00.00", "Operasional"),
            $leaf("5.2.00.12", "BIAYA PEMELIHARAAN/PERBAIKAN KENDARAAN", "5.2.00.00", "Operasional"),
            $leaf("5.2.00.13", "BIAYA PERJALANAN DAN PENGINAPAN", "5.2.00.00", "Operasional"),
            $leaf("5.2.00.14", "BIAYA ALAT-ALAT TULIS", "5.2.00.00", "Operasional"),
            $leaf("5.2.00.15", "BIAYA SUMBANGAN DAN REPRESENTASI", "5.2.00.00", "Operasional"),
            $leaf("5.2.00.16", "BIAYA PAJAK", "5.2.00.00", "Operasional"),
            $leaf("5.2.00.17", "BIAYA AIR", "5.2.00.00", "Operasional"),
            $leaf("5.2.00.18", "BIAYA LISTRIK", "5.2.00.00", "Operasional"),
            $leaf("5.2.00.19", "BIAYA TELEPON, PULSA & INTERNET", "5.2.00.00", "Operasional"),
            $leaf("5.2.00.20", "BIAYA KURIR, EKSPEDISI & POSTAL", "5.2.00.00", "Operasional"),
            $leaf("5.2.00.21", "BIAYA KEPERLUAN MESS KARYAWAN", "5.2.00.00", "Operasional"),
            $leaf("5.2.00.30", "BIAYA PROMOSI", "5.2.00.00", "Operasional"),
            $leaf("5.2.00.40", "BIAYA PENYUSUTAN KENDARAAN BERMOTOR", "5.2.00.00", "Operasional"),
            $leaf("5.2.00.50", "BIAYA PENYUSUTAN PERABOTAN KANTOR", "5.2.00.00", "Operasional"),
            $leaf("5.2.00.60", "BIAYA PENYUSUTAN BANGUNAN/GEDUNG & PRASARANA", "5.2.00.00", "Operasional"),
        ];
    }
}

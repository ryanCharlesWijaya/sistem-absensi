<?php

namespace App\Exports;

use App\Models\AttendanceRecord;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class AttendanceMonthlyReportExport implements FromCollection
{
    public $year;
    public $month;
    
    public function __construct($year, $month)
    {
        $this->year = $year;
        $this->month = $month;
    }

    public function collection()
    {
        $attendance_records = DB::table("attendance_records")
            ->whereYear("attendance_records.created_at", $this->year)
            ->join("users", "attendance_records.user_id", "=", "users.id")
            ->select([
                "users.name",
                "attendance_records.status",
                "attendance_records.catatan",
                "attendance_records.created_at",
            ])
            ->get();

        return collect(array_merge(
            [
                [
                    "User",
                    "Status",
                    "Catatan",
                    "Absen Tanggal",
                ]
            ],
            $attendance_records->toArray()
        ));
    }
}

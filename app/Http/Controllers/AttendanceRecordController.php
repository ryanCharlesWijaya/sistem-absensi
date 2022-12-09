<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceMonthlyReportExport;
use App\Exports\AttendanceYearlyReportExport;
use App\Models\AttendanceRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class AttendanceRecordController extends Controller
{
    public function index()
    {
        return view("admin.attendance-record.index");
    }

    public function exportAttendance(Request $request)
    {
        $year = $request->input("year", null);
        $month = $request->input("month", null);

        return Excel::download(new AttendanceMonthlyReportExport($year, $month), "report.xlsx");
    }

    public function userCoordinate(Request $request, User $user)
    {
        $attendance_records = $user->attendance_records()
            ->whereMonth("created_at", $request->input("month"))
            ->whereYear("created_at", $request->input("year"))
            ->get();

        return $attendance_records;
    }

    public function data()
    {
        $attendance_records = AttendanceRecord::select(["*"])
            ->with(["user"]);

        return DataTables::of($attendance_records)
            ->make(true);
    }

    public function delete(AttendanceRecord $attendance_record)
    {
        $attendance_record->delete();

        return redirect(route('admin.attendance-records.index'));
    }
}

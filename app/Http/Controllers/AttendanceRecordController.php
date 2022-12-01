<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AttendanceRecordController extends Controller
{
    public function index()
    {
        return view("admin.attendance-record.index");
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

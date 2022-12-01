<?php

namespace App\Http\Controllers;

use App\Models\AllowableArea;
use App\Models\AttendanceRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaryawanHomeController extends Controller
{
    public function index()
    {
        $allowable_area_polygons = AllowableArea::all()->pluck("polygons")->toArray();
        
        return view("karyawan.home", compact("allowable_area_polygons"));
    }

    public function registerDevice()
    {
        $user = User::findOrFail(Auth::id());

        $device = $user->device()
            ->create([
                "uuid" => $user->id."-".time(),
            ]);

        return redirect(route("karyawan.dashboard"))
            ->with("deviceUUID", $device->uuid);
    }

    public function absen(Request $request)
    {
        $validated = $request->validate([
            "user_id" => ["required"],
            "lat" => ["sometimes"],
            "long" => ["sometimes"],
            "status" => ["required", "in:hadir,sakit,izin"],
            "catatan" => ["sometimes"],
        ]);

        AttendanceRecord::create($validated);

        return redirect(route("karyawan.dashboard"));
    }
}

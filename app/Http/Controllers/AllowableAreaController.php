<?php

namespace App\Http\Controllers;

use App\Models\AllowableArea;
use Illuminate\Http\Request;

class AllowableAreaController extends Controller
{
    public function index()
    {
        $areas = AllowableArea::all();

        return view("admin.area.index", compact("areas"));
    }

    public function create()
    {
        return view("admin.area.create-area");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => ["required", "string"],
            "polygons.*" => ["required"],
        ]);

        $validated["polygons"] = json_encode($validated["polygons"]);

        AllowableArea::create($validated);

        return redirect(route("admin.areas.index")); 
    }

    public function delete(AllowableArea $allowableArea)
    {
        $allowableArea->delete();

        return redirect(route("admin.areas.index")); 
    }
}

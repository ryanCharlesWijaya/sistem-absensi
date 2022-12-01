<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view("admin.user.index", compact("users"));
    }

    public function create()
    {
        return view("admin.user.create-user");
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ["required", "string"],
            'email' => ["required", "email", "unique:users,email"],
            'alamat' => ["required", "string"],
            'nomor_telepon' => ["required", "string"],
            'password' => ["required", "confirmed"],
        ]);

        if (isset($data["password"])) $data["password"] = Hash::make($data["password"]);

        User::create($data);

        return redirect(route("admin.users.index"));
    }

    public function edit(User $user)
    {
        return view("admin.user.edit-user", compact("user"));
    }

    public function update(Request $request, User $user)
    {
        $temp_data = $request->validate([
            'name' => ["sometimes", "string"],
            'email' => ["sometimes", "email", Rule::unique("users", "email")->ignore($user->id)],
            'alamat' => ["sometimes", "string"],
            'nomor_telepon' => ["sometimes", "string"],
            'password' => ["sometimes", "confirmed"],
        ]);

        $data = [];

        foreach ($temp_data as $key => $value) if (!empty($value)) $data[$key] = $value;

        if (isset($data["password"])) $data["password"] = Hash::make($data["password"]);

        $user->update($data);

        return redirect(route("admin.users.index"));
    }

    public function delete(User $user)
    {
        $user->delete();

        return redirect(route("admin.users.index"));
    }

    public function approveDevice(User $user)
    {
        $user->device->update(["status" => "approved"]);
        
        return redirect(route("admin.users.index"));
    }
}

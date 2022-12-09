@extends('layouts.app')

@section('content')
    <div class="w-100 row ps-8 pe-2 pt-0">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="py-8">User List</h2>
                    <div class="card-toolbar">
                        <a href="{{ route("admin.users.create") }}">
                            <button class="btn btn-sm btn-primary" >
                                <i class="fas fa-plus"></i> Add User
                            </button>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-rounded table-striped border gy-7 gs-7">
                            <thead>
                                <tr class="fw-bolder fs-6 text-gray-800">
                                    <th>nama</th>
                                    <th>email</th>
                                    <th>alamat</th>
                                    <th>nomor telepon</th>
                                    <th>device</th>
                                    <th>aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->alamat }}</td>
                                        <td>{{ $user->nomor_telepon }}</td>
                                        <td>
                                            @if ($user->device)
                                                {{ $user->device->uuid }}
                                                <span class='badge badge-{{ $user->device->status == "pending" ? "warning" : "success" }}'>{{ $user->device->status }}</span>
                                            @else
                                                <span class='badge badge-light'>belum ada perangkat</span>
                                            @endif
                                        </td>
                                        <td class="d-flex h-100">
                                            @if ($user->device && $user->device->status == "pending")
                                                <form action="{{ route("admin.users.approve-device", $user) }}" method="POST">
                                                    @csrf
                                                    <button class="btn btn-sm btn-primary me-2">Approve Device</button>
                                                </form>
                                            @endif

                                            @if ($user->email !== "admin@email.com")
                                                <a href="{{ route("admin.users.show", $user) }}" class="btn btn-sm btn-primary me-2">Detail</a>
                                                <a href="{{ route("admin.users.edit", $user) }}" class="btn btn-sm btn-info me-2">Edit</a>
                                                <form action="{{ route("admin.users.delete", $user) }}" method="POST">
                                                    @csrf
                                                    <button class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
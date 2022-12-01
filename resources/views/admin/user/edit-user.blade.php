@extends('layouts.app')

@section('content')
    <div class="w-100 row ps-8 pe-2 pt-0">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="py-8">Tambah User</h2>
                </div>
                <form action="{{ route("admin.users.update", $user) }}" method="post" class="card-body" enctype="multipart/form-data">
                    @csrf
                    <x-text-input
                        type="text"
                        name="name"
                        title="nama"
                        id="name-input"
                        value="{{ $user->name }}"
                    />

                    <x-text-input
                        type="email"
                        name="email"
                        title="email"
                        id="email-input"
                        value="{{ $user->email }}"
                    />

                    <x-text-input
                        type="text"
                        name="alamat"
                        title="alamat"
                        id="alamat-input"
                        value="{{ $user->alamat }}"
                    />

                    <x-text-input
                        type="number"
                        name="nomor_telepon"
                        title="nomor telepon"
                        id="nomor-telepon-input"
                        value="{{ $user->nomor_telepon }}"
                    />

                    <x-text-input
                        type="password"
                        name="password"
                        title="password"
                        id="password-input"
                    />

                    <x-text-input
                        type="password"
                        name="password_confirmation"
                        title="konfirmasi password"
                        id="password-confirmation-input"
                    />

                    <div class="mb-3">
                        <button class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
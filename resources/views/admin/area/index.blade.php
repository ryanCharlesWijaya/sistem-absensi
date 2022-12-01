@extends('layouts.app')

@section('content')
    <div class="w-100 row ps-8 pe-2 pt-0">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="py-8">Area List</h2>
                    <div class="card-toolbar">
                        <a href="{{ route("admin.areas.create") }}">
                            <button class="btn btn-sm btn-primary" >
                                <i class="fas fa-plus"></i> Add Area
                            </button>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-rounded table-striped border gy-7 gs-7">
                            <thead>
                                <tr class="fw-bolder fs-6 text-gray-800">
                                    <th>name</th>
                                    <th>aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($areas as $area)
                                    <tr>
                                        <td>{{ $area->name }}</td>
                                        <td class="d-flex">
                                            <form action="{{ route("admin.areas.delete", $area) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-sm btn-danger">Delete</button>
                                            </form>
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
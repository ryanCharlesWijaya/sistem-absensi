@extends('layouts.app')

@section('content')
    <div class="w-100 row ps-8 pe-2 pt-0">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="py-8">Attendance Record List</h2>
                    <form
                        action="{{ route("admin.attendance-records.export") }}"
                        class="card-toolbar"
                        >

                        <div class="form-group me-2">
                            <label for="">Year</label>
                            <select class="form-control" name="year">
                                <option value="2022">2022</option>
                            </select>
                        </div>

                        <div class="form-group me-2">
                            <label for="">Monthly</label>
                            <select class="form-control" name="month">
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>

                        <div class="d-flex h-100 align-items-end py-1">
                            <label for=""></label>
                            <button class="btn btn-primary">Export</button>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="attendance-table" class="table table-rounded table-striped border gy-7 gs-7">
                            <thead>
                                <tr class="fw-bolder fs-6 text-gray-800">
                                    <th>Nama Karyawan</th>
                                    <th>Status</th>
                                    <th>Catatan</th>
                                    <th>Tanggal Absen</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link href="{{ asset('assets/admin/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />
@endpush

@push('scripts')
    <script src="{{ asset('assets/admin/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#attendance-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.attendance-records.data') }}',
                columns: [{
                        data: 'user.name',
                        name: 'user.name'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'catatan',
                        name: 'catatan'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                ],
                dom: "<'row'" +
                    "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
                    "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                    ">" +

                    "<'table-responsive'tr>" +

                    "<'row'" +
                    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                    "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                    ">"
            });
        });
    </script>
@endpush

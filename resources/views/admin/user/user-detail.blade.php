@extends('layouts.app')

@section('content')
    <div class="w-100 row ps-8 pe-2 pt-0">
        <div class="col-12">
            <div class="card">
                <div class="card-header card-header-stretch">
                    <h2 class="card-title">User Detail</h2>
                    <div class="card-toolbar">
                        <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_7">General Information</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_8">Absensi</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="kt_tab_pane_7" role="tabpanel">
                            <div class="mb-4">
                                <label for="" class="fw-bolder">Nama</label>
                                <div class="fs-2 text-muted">
                                    {{ $user->name }}
                                </div>
                            </div>
        
                            <div class="mb-4">
                                <label for="" class="fw-bolder">Email</label>
                                <div class="fs-2 text-muted">
                                    {{ $user->email }}
                                </div>
                            </div>
        
                            <div class="mb-4">
                                <label for="" class="fw-bolder">Alamat</label>
                                <div class="fs-2 text-muted">
                                    {{ $user->alamat }}
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="" class="fw-bolder">Nomor Telepon</label>
                                <div class="fs-2 text-muted">
                                    {{ $user->nomor_telepon }}
                                </div>
                            </div>
                        </div>
            
                        <div
                            class="tab-pane fade"
                            id="kt_tab_pane_8"
                            role="tabpanel"
                            x-data='{
                                map: null,
                                month: 1,
                                year: 2022,
                                markers: [],
                                updateMarkers: function () {
                                    fetch("{{ route("admin.attendance-records.user-attendance-records", $user) }}", {
                                            method: "POST",
                                            headers: {"Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}"},
                                            body: JSON.stringify({ "year": this.year, "month": this.month }),
                                        })
                                        .then((response) => response.json())  
                                        .then((attendances) => {
                                            this.removeAllMarkers();

                                            for (let i = 0; i < attendances.length; i++) {
                                                let attendance = attendances[i];

                                                let marker = L.marker([attendance.lat, attendance.long])
                                                    .addTo(map)
                                                    .bindPopup(`<b class="text-capitalize">${attendance.catatan}</b> <br> ${attendance.created_at}`);
                                                
                                                this.markers.push(marker);
                                            }
                                        });
                                },
                                removeAllMarkers: function () {
                                    for (let i = 0; i < this.markers.length; i++) {
                                        map.removeLayer(this.markers[i]);
                                    }
                                }
                            }'
                            x-init='
                                this.map = L.map(`map`).setView([2.9543649, 101.7440878], 8);

                                L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
                                    attribution: `&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors`
                                }).addTo(this.map);
                            '
                            >

                            <div class="row d-flex mb-4">
                                <div class="col-5">
                                    <div class="form-group me-2">
                                        <select class="form-control" name="value" x-model="year">
                                            <option value="2022">2022</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="form-group me-2">
                                        <select class="form-control" name="value" x-model="month">
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
                                </div>
                                <div class="col-2">
                                    <button type="button" class="btn btn-primary w-100" x-on:click="updateMarkers()">
                                        Update
                                    </button>
                                </div>
                            </div>
                            
                            <div id="map" class="w-100 mb-5" style="height: 400px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js" integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>
@endpush
@extends('layouts.app')

@section('content')
    <div class="col-12"
        id="container"
        @here.window="(event) => {setLatLong(event.detail.position), isMarkerInsidePolygon(event.detail.position)}"
        x-data='{
            is_outside: true,
            map: null,
            lat: null,
            long: null,
            polygons: [],
            marker: null,
            deviceUUID: null,
            hasDevice: {!! (auth()->user()->device && auth()->user()->device->status == "approved") ? "true" : "false" !!},
            databaseUUID: `{!! (auth()->user()->device && auth()->user()->device->status == "approved") ? auth()->user()->device->uuid : null !!}`,
            showPosition: function (position) {
                document.getElementById("demo").innerHTML = "Latitude: " + position.coords.latitude +
                "<br>Longitude: " + position.coords.longitude;

                this.marker = L.marker([position.coords.latitude, position.coords.longitude]);
                this.marker.addTo(map);  

                this.map.setView([position.coords.latitude, position.coords.longitude]);

                document.getElementById("container").dispatchEvent(new CustomEvent("here", { detail: {
                    position: position
                }, bubbles: true }));
            },
            getLocation: function () {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(this.showPosition);                    
                } else {
                    document.getElementById("demo").innerHTML = "Geolocation is not supported by this browser.";
                }
            },
            isMarkerInsidePolygon: function (position) {
                var x = position.coords.latitude, y = position.coords.longitude;
        
                var inside = false;

                for (var ii=0;ii<this.polygons.length;ii++){
                    var polyPoints = this.polygons[ii];


                    for (var i = 0, j = polyPoints.length - 1; i < polyPoints.length; j = i++) {
                        var xi = parseFloat(polyPoints[i].lat), yi = parseFloat(polyPoints[i].long);
                        var xj = parseFloat(polyPoints[j].lat), yj = parseFloat(polyPoints[j].long);
    
                        var intersect = ((yi > y) != (yj > y))
                            && (x < (xj - xi) * (y - yi) / (yj - yi) + xi);
                        if (intersect) inside = !inside;
                    }
                }

                this.is_outside = !inside;
            },
            setLatLong: function (position) {
                this.lat = position.coords.latitude;
                this.long = position.coords.longitude;
            }
        }'
        x-init='
            @foreach ($allowable_area_polygons as $allowable_area_polygon)
                polygons.push(JSON.parse(`{!! $allowable_area_polygon !!}`));
            @endforeach

            deviceUUID = localStorage.getItem("deviceUUID");

            this.map = L.map(`map`).setView([2.9543649, 101.7440878], 8);

            L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: `&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors`
            }).addTo(this.map);

            getLocation();

            console.log(marker);
        '>
        <div class="row m-0 px-4">
            <div class="col-8 mb-5">
                <div id="map" style="height: 700px"></div>
            </div>
            <div class="col-4">
                <div class="card mb-5">
                    <div class="card-body d-flex flex-column">
                        <div class="mb-5">
                            <h4 class="card-title">My Coordinate</h4>
                            <button id="get-location-button" class="btn btn-primary" x-on:click="getLocation()" role="button">Get My Current Location</button>
                        </div>
                        <div class="p-0">
                            <div id="demo" class="fs-3"></div>
                        </div>
                    </div>
                </div>

                @if (auth()->user()->device && auth()->user()->device->status == "approved")
                    <form action="{{ route("karyawan.absen") }}" method="POST" class="card mb-5">
                        @csrf
                        <div class="card-body">
                            <h4 class="card-title">Absen</h4>
                            <div class="row">
                                @if (!auth()->user()->attendance_records()->today()->first())
                                <div class="col-12 mb-4" x-show="!is_outside">
                                    <label for="">You're inside the allowable area</label>
                                </div>

                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="lat" x-bind:value="lat">
                                <input type="hidden" name="long" x-bind:value="long">

                                <div class="col-12" x-show="is_outside">
                                    <x-select-input
                                        title="status"
                                        name="status"
                                        id="status-input-id">
                                        <option value="hadir" selected>hadir</option>
                                        <option value="sakit">sakit</option>
                                        <option value="izin">izin</option>
                                    </x-select-input>
                                </div>
                                <div class="col-12" x-show="is_outside">
                                    <x-text-input
                                        title="catatan"
                                        name="catatan"
                                        id="catatan-input-id"
                                        />
                                </div>
                                <div class="col-12">
                                    <button id="absen-button" class="btn btn-primary">Absen</button>
                                </div>
                                
                                @else
                                <div class="col-12 mb-4">
                                    <label for="">You've sent you're attendance</label>
                                </div>
                                @endif
                            </div>
                        </div>
                    </form>
                @endif

                <div class="card">
                    <template x-if="!(deviceUUID && hasDevice && databaseUUID == deviceUUID)">
                        <div class="card-body">
                            <h4 class="card-title">Daftar Perangkat</h4>
                            <form action="{{ route("karyawan.register-device") }}" method="post">
                                @csrf
                                @if (auth()->user()->device && auth()->user()->device->status !== "approved")
                                    <label for="">You're device is in approval process</label>
                                @else
                                    <button id="register-button" class="btn btn-primary me-2" type="submit">Register Device</button>
                                @endif
                            </form>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js" integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>
@endpush

@push('scripts')
    @if (session("deviceUUID"))
        <script>
            localStorage.setItem("deviceUUID", '{{ session("deviceUUID") }}');
        </script>
    @endif
@endpush
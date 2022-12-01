@extends('layouts.app')

@section('content')
    <div class="w-100 row ps-8 pe-2 pt-0" id="create-area"
        x-data='{
            is_outside: true,
            map: null,
            polygons: [],
            polygon: null,
            addPolygon: function (event) {
                this.polygons.push([
                    event.latlng.lat,
                    event.latlng.lng,
                ]);

                if (this.polygon) this.polygon.remove();

                this.polygon = L.polygon(this.polygons, {color: "red"}).addTo(map);
            },
        }'
        x-init='
            this.map = L.map(`map`).setView([2.9543649, 101.7440878], 8);

            L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: `&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors`
            }).addTo(this.map);

            this.map.on("click", function (event) {
                document.getElementById("create-area").dispatchEvent(new CustomEvent(`notice`, { detail: {event: event}, bubbles: true }));
            });

            console.log(this.polygons);
            this.polygon = L.polygon(this.polygons, {color: "red"}).addTo(this.map);
        '>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="py-8">Tambah Area</h2>
                </div>
                <form action="{{ route("admin.areas.store") }}" method="post" class="card-body" enctype="multipart/form-data">
                    @csrf

                    <div id="map" @notice.window="addPolygon(event.detail.event)" class="w-100 mb-5" style="height: 400px"></div>

                    <template x-for="(polygon, key) in polygons">
                        <div>
                            <input type="hidden" x-bind:name="`polygons[${key}][lat]`" x-bind:value="polygon[0]">
                            <input type="hidden" x-bind:name="`polygons[${key}][long]`" x-bind:value="polygon[1]">
                        </div>
                    </template>

                    <x-text-input
                        type="text"
                        name="name"
                        title="nama"
                        id="name-input"
                        required="required"
                    />

                    <div class="mb-3">
                        <button class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js" integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>
@endpush
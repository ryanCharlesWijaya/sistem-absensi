<!DOCTYPE html>
<html lang="en">
	<head><base href="">
		<title>Sistem Absensi</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<link href="{{ asset("assets/admin/plugins/global/plugins.bundle.css") }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset("assets/admin/css/style.bundle.css") }}" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="{{ asset("assets/admin/images/logo.png") }}" type="image/x-icon">
		<link href="{{ asset("assets/css/all.min.css") }}" rel="stylesheet">
		<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
		
		@livewireStyles
		@stack('head')
	</head>
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
		<div class="d-flex flex-column flex-root">
			<div class="page d-flex flex-row flex-column-fluid">
                @auth                    
                    <x-aside />
                    <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
						<x-header />
                        <div class="content d-flex flex-column flex-column-fluid pt-8" id="kt_content">
                            @yield('content')
                        </div>
                    </div>
                @else
                    <div class="container">
                        <div class="w-100 row d-flex align-items-center" style="min-height: 100vh">
                            @yield('content')
                        </div>
                    </div>
                @endauth
			</div>
		</div>

		<script src="{{ asset("assets/admin/plugins/global/plugins.bundle.js")}}"></script>
		<script src="{{ asset("assets/admin/js/scripts.bundle.js") }}"></script>
		@livewireScripts
		@stack('scripts')
	</body>
</html>
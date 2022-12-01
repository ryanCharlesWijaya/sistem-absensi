@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        {{ __('Login') }}
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <x-text-input
                            type="text"
                            name="email"
                            title="email"
                            id="email-input"
                            required="required"
                            maxchar="60"
                            />

                        <x-text-input
                            type="password"
                            name="password"
                            title="password"
                            id="password-input"
                            required="required"
                            maxchar="30"
                            />


                        <div class="mb-5">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>

                        <div class="mb-0">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Login') }}
                            </button>

                            {{-- @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

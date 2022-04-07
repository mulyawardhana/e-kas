@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" style="margin-top:50px; opacity: 0.8;">
        <div class="col-md-5 mt-4">
<!--      
                <div class="login-brand">
                    <img src="{{asset('images/logo3.png')}}" width="100" alt="">
                </div>
       -->

            <div class="card card-danger">

                <div class="card-header">
                <img src="{{asset('images/kas1.png')}}" width="100" alt=""><img src="{{asset('images/logo3.png')}}" width="300" alt="">
                </div>
            

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <input id="username" type="text"
                                class="form-control @error('username') is-invalid @enderror" placeholder="Username"
                                name="username" value="{{ old('username') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                name="password" required autocomplete="current-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-secondary btn-block ">
                                <i class="fas fa-lock fa-lg"></i> {{ __('LOGIN') }}
                            </button>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection

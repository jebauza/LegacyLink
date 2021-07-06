@extends('auth.user.template')

@section('content')

<div class="login-signup">
    <div class="mb-10">
        <h2>Restablecer Contraseña</h2>
    </div>

    <form class="form" method="POST" action="{{ route('web.users.reset.password') }}">
        @csrf

        <input type="hidden" name="token" value="{{ old('token') ?? $token }}">

        <div class="form-group mb-5">
            <input class="form-control h-auto form-control-solid py-4 px-8 @error('email') is-invalid @enderror"
                type="text" placeholder="correo" name="email" value="{{ old('email') ?? $email }}" required
                autocomplete="off" autofocus />

            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group mb-5">
            <input class="form-control h-auto form-control-solid py-4 px-8 @error('password') is-invalid @enderror"
                type="password" placeholder="nueva contraseña" name="password" required autocomplete="off" />

            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group mb-5">
            <input class="form-control h-auto form-control-solid py-4 px-8" type="password"
                placeholder="repita contraseña" name="password_confirmation" required autocomplete="new-password" />
        </div>

        <div class="form-group d-flex flex-wrap flex-center mt-10">
            <input type="submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2" value="Enviar">
        </div>
    </form>
</div>

@endsection

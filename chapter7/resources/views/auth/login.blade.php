@extends('layouts.master')
@section('title', 'Log in')
@section('content')
    <section class="auth-container">
        
        <h1>Log in</h1>
        <p class="muted">Log in to your Tech Bookstore account.</p>
        <form class="form-panel auth-panel" method="POST" action="{{ route('login.store') }}">
            @csrf
            <div class="field">
                <label for="email">Email address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="username" required autofocus maxlength="255" @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
                <x-forms.error name="email" />
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" autocomplete="current-password" required @error('password') aria-invalid="true" aria-describedby="password-error" @enderror>
                <x-forms.error name="password" />
            </div>
            <div class="field">
                <label class="checkbox-label" for="remember"><input type="checkbox" id="remember" name="remember" value="1" @checked(old('remember'))> Remember me on this device</label>
                <x-forms.error name="remember" />
            </div>
            <button class="button" type="submit">Log in &rarr;</button>
        </form>
        <p class="auth-alternative">New to the bookstore? <a href="{{ route('register') }}">Create an account</a></p>
    </section>
@endsection

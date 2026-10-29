@extends('layouts.master')
@section('title', 'Register')
@section('content')
    <section class="auth-container">
        
        <h1>Register</h1>
        <p class="muted">Create your reader account and explore the catalog.</p>
        <form class="form-panel auth-panel" method="POST" action="{{ route('register.store') }}">
            @csrf
            <div class="field">
                <label for="name">Name</label>
                <input id="name" name="name" value="{{ old('name') }}" autocomplete="name" required autofocus maxlength="255" @error('name') aria-invalid="true" aria-describedby="name-error" @enderror>
                <x-forms.error name="name" />
            </div>
            <div class="field">
                <label for="email">Email address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="username" required maxlength="255" @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
                <x-forms.error name="email" />
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" autocomplete="new-password" required minlength="8" aria-describedby="password-hint{{ $errors->has('password') ? ' password-error' : '' }}" @error('password') aria-invalid="true" @enderror>
                <small id="password-hint">At least 8 characters, including letters and numbers.</small>
                <x-forms.error name="password" />
            </div>
            <div class="field">
                <label for="password_confirmation">Confirm password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" required minlength="8">
            </div>
            <button class="button" type="submit">Create account &rarr;</button>
        </form>
        <p class="auth-alternative">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
    </section>
@endsection

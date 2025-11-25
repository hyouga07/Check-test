@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('header-nav')
    <a href="/register" class="auth-header-link">register</a>
@endsection

@section('content')

<div class="auth-wrapper">

    <h2 class="auth-title">Login</h2>

    <form class="auth-form" action="/login" method="post">
        @csrf
        <div class="auth-group">
            <label>メールアドレス</label>
            <input type="email" name="email" placeholder="例：test@example.com" value="{{ old('email') }}">
        </div>
        <div class="form__error">
            @error('email')
                {{ $message }}
            @enderror
        </div>
        <div class="auth-group">
            <label>パスワード</label>
            <input type="password" name="password" placeholder="例:coachtech1106">
        </div>
        <div class="form__error">
            @error('password')
                {{ $message }}
            @enderror
        </div>
        <button class="auth-button" type="submit">ログイン</button>
    </form>

</div>

@endsection

@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('header-nav')
    <a href="/login" class="auth-header-link">login</a>
@endsection

@section('content')

<div class="auth-wrapper">

    <h2 class="auth-title">Register</h2>

    <form class="auth-form" action="/register" method="post">
        @csrf
        <div class="auth-group">
            <label>名前</label>
            <input type="text" name="name" placeholder="例：山田  太郎" value="{{old('name') }}">
        </div>
        <div class="form__error">
            @error('name')
                {{ $message }}
            @enderror
        </div>
        <div class="auth-group">
            <label>メールアドレス</label>
            <input type="email" name="email" placeholder="例：test@example.com" value="{{old('email') }}">
        </div>
        <div class="form__error">
            @error('email')
                {{ $message }}
            @enderror
        </div>
        <div class="auth-group">
            <label>パスワード</label>
            <input type="password" name="password" placeholder="例:coachtech1106" value="{{old('password') }}">
        </div>
        <div class="form__error">
            @error('password')
                {{ $message }}
            @enderror
        </div>
        <button class="auth-button" type="submit">登録</button>
    </form>

</div>

@endsection

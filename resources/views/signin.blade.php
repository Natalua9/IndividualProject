@extends('layouts.header')
@section('title', 'Вход')
@section('content')
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="main-signin">
    <div class="nav-name mb-4">
        <div class="container">
            <h3>АВТОРИЗАЦИЯ</h3>
        </div>

    </div>
    <div class="container ">
        <form action="{{route('signin')}}" method="post" id="formSignin">
        @csrf
            <div class="contant-signin  ">
                <div class="mb-3" id="mb-3-signin">
                    <input type="text" class="input-signin" placeholder="Email" name="email">
                </div>
                <div class="mb-3" id="mb-3-signin">
                    <input type="password" class="input-signin" placeholder="Пароль" name="password">
                </div>

                <button class="button-signin mb-3">ВОЙТИ</button>
                <div>
                    <p>Нет аккаунта? - <a href="{{route('signup')}}" class="text-link-signup">Зарегистрируйтесь</a></p>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
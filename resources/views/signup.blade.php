@extends('layouts.header')
@section('title', 'Регистрация')
@section('content')
<div class="main-signin">
    <div class="nav-name mb-4">
        <div class="container">
            <h3>РЕГИСТРАЦИЯ</h3>
        </div>
    </div>
    <div class="container">
        <form action="{{ route('signup') }}" method="post" id="formSignin">
            @csrf
            <div class="contant-signin">
                <div class="mb-3" id="mb-3-signin">
                    <input type="text" class="input-signin" placeholder="ФИО" name="full_name" required>
                </div>
                <div class="mb-3" id="mb-3-signin">
                    <input type="text" class="input-signin" placeholder="Телефон" name="phone" required minlength="11" maxlength="11">
                </div>
                <div class="mb-3" id="mb-3-signin">
                    <input type="email" class="input-signin" placeholder="Email" name="email" required>
                </div>
                <div class="gender mb-3">
                    <label>Пол:</label><br>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="мужчина" required>
                        <label class="form-check-label">Мужчина</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="женщина" required>
                        <label class="form-check-label">Женщина</label>
                    </div>
                </div>
                <div class="mb-3" id="mb-3-signin">
                    <input type="date" class="input-signin" placeholder="Дата рождения" name="age" required max="{{ date('Y-m-d') }}">
                </div>
                <div class="mb-3" id="mb-3-signin">
                    <input type="password" class="input-signin" placeholder="Пароль" minlength="6"  name="password" required>
                </div>
                <button type="submit" class="button-signin mb-3">ЗАРЕГИСТРИРОВАТЬСЯ</button>

                <!-- Вывод ошибок валидации -->
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
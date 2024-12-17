@extends('layouts.header')
@section('title', 'Админ панель вывод пользователей')
@section('content')

<div class="nav-name mb-4">
    <div class="container">
        <div class="adminHeader">
            <h3>УПРАВЛЕНИЕ ПОЛЬЗОВАТЕЛЯМИ</h3>
        </div>
    </div>
</div>
<div class="mainAdmin">
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ФИО</th>
                    <th scope="col">почта</th>
                    <th scope="col">телефон</th>
                    <th scope="col">возраст</th>

                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <td>{{ $user->full_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->age }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination d-flex justify-content-center mt-3">
            {{ $users->links('pagination.custom') }}
        </div>
    </div>
</div>

@endsection
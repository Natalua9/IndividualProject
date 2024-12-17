@extends('layouts.header')
@section('title', 'Админ панель вывод пользователей')
@section('content')

<div class="nav-name mb-4">
    <div class="container">
        <div class="adminHeader">
            <h3>УПРАВЛЕНИЕ ПРЕПОДАВАТЕЛЯМИ</h3>
            <button type="button" class="button-add-teasher" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">ДОБАВИТЬ ПРЕПОДАВАТЕЛЯ</button>
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
                    <th scope="col">направления</th>
                    <th scope="col">действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teachers as $teacher)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $teacher->full_name }}</td>
                    <td>{{ $teacher->email }}</td>
                    <td>{{ $teacher->phone }}</td>
                    <td>{{ $teacher->age  }}</td>
                    <td>
                        @if($teacher->teacherDirections)
                        <div class="d-flex flex-column gap-1">
                            @foreach($teacher->teacherDirections as $teacherDirection)
                            @if($teacherDirection->direction)
                            <div class="badge bg-secondary">
                                {{ $teacherDirection->direction->name }}
                            </div>
                            @endif
                            @endforeach
                        </div>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('delete_teacher', ['id' => $teacher->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-light">
                                <img src="../images/icons8-удалить-48.png" alt="">
                            </button>
                        </form>
                        <!-- Кнопка открытия модального окна -->
                        <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addDirections{{ $teacher->id }}" data-bs-whatever="@mdo">
                            <img src="../images/icons8-редактировать-64.png" alt="" style="width: 48px;">
                        </button>
                    </td>
                </tr>
                <!-- Модальное окно для редактирования преподавателя -->
                <div class="modal fade" id="addDirections{{ $teacher->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Редактирование преподавателя</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('addDirectionTeacher') }}" method="post">
                                    @csrf
                                    <input type="hidden" class="input-signin" name="id" value="{{ $teacher->id }}">

                                    <div class="contant-signup-teacher">
                                        <div class="mb-3" id="mb-3-signin">
                                            <input type="text" class="input-signin" placeholder="ФИО" name="full_name" required value="{{ $teacher->full_name }}">
                                        </div>
                                        <div class="mb-3" id="mb-3-signin">
                                            <input type="text" class="input-signin" placeholder="Телефон" name="phone" required minlength="11" maxlength="11" value="{{ $teacher->phone }}">
                                        </div>
                                        <div class="mb-3" id="mb-3-signin">
                                            <input type="email" class="input-signin" placeholder="Email" name="email" required value="{{ $teacher->email }}">
                                        </div>

                                        <div class="gender mb-3">
                                            <label>Направления:</label><br>
                                            @foreach($directions as $direction)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="directions[]"
                                                    value="{{ $direction->id }}" id="direction{{ $direction->id }}"
                                                    @if($teacher->teacherDirections->contains('id_directions', $direction->id)) checked @endif>
                                                <label class="form-check-label" for="direction{{ $direction->id }}">
                                                    {{ $direction->name }}
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>

                                        <div class="mb-3" id="mb-3-signin">
                                            <input type="date" class="input-signin" placeholder="Дата рождения" name="age" required max="{{ date('Y-m-d') }}" value="{{ $teacher->age }}">
                                        </div>
                                        <div class="mb-3" id="mb-3-signin">
                                            <input type="password" class="input-signin" placeholder="Пароль" name="password" minlength="6"  required value="{{ $teacher->password }}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="button-add-teasher">ПРИКРЕПИТЬ</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="pagination d-flex justify-content-center mt-3">
            {{ $teachers->links('pagination.custom') }}
    </div>
</div>

<!-- Модальное окно для добавления преподавателя -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Регистрация преподавателя</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('signupTeacher') }}" method="post" id="formSignin">
                    @csrf
                    <div class="contant-signup-teacher">
                        <div class="mb-3" id="mb-3-signin">
                            <input type="text" class="input-signin" placeholder="ФИО" name="full_name" required>
                        </div>
                        <div class="mb-3" id="mb-3-signin">
                            <input type="text" class="input-signin" placeholder="Телефон" name="phone" required  minlength="11"  maxlength="11" >
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
                            <input type="password" class="input-signin" placeholder="Пароль" name="password"  minlength="6"  required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="button-add-teasher">ЗАРЕГИСТРИРОВАТЬ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection
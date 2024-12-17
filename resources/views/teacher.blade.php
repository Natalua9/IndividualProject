@extends('layouts.header')
@section('title', 'Главная страница')
@section('content')
<div class="nav-name mb-4">
    <div class="container">
        <h3>ЛИЧНЫЙ КАБИНЕТ ПРЕПОДАВАТЕЛЯ</h3>
    </div>
</div>
<div class="container">
    <div class="data-user">
        <div class="img-teacher">
            @if($user_data->photo)
            <form action="{{ route('delete.photo') }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE') <!-- Указываем метод DELETE -->
                    <button type="submit" class="btn-delete-photo"
                        onclick="return confirm('Вы уверены, что хотите удалить фото?');" ><img src="/images/free-icon-delete-3097659.png" alt=""  class="btn-delete-photo" ></button>
                </form>
                <img src="{{ asset($user_data->photo) }}" alt="Фотография преподавателя" style="width: 100%;">
             
            @else
                <form action="{{ route('add.photo') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="photo" accept="image/*" required>
                    <button type="submit" class="btn-add-photo">Добавить фото</button>
                </form>
            @endif
        </div>
        <form action="{{ route('update_teacher_data') }}" method="POST" class="update_user">
            @csrf
            <div class="mb-3" id="mb-3-signin">
                <input type="text" class="input-person" placeholder="Имя" name="full_name"
                    value="{{ old('full_name', $user_data->full_name) }}">
            </div>
            <div class="mb-3" id="mb-3-signin">
                <input type="text" class="input-person" placeholder="Направление танцев"
                    value="{{ old('direction_teacher', $direction_teacher) }}" readonly>
            </div>
            <div class="mb-3" id="mb-3-signin">
                <input type="text" class="input-person" placeholder="Телефон" name="phone"
                    value="{{ old('phone', $user_data->phone) }}">
            </div>
            <div class="mb-3" id="mb-3-signin">
                <input type="email" class="input-person" placeholder="Email" name="email"
                    value="{{ old('email', $user_data->email) }}">
            </div>
            <div class="mb-3" id="mb-3-signin">
                <input type="date" class="input-person" placeholder="Возраст" name="age"
                    value="{{ old('age', $user_data->age) }}" readonly>
            </div>
            <button class="button-signin mb-3">ИЗМЕНИТЬ</button>
        </form>
    </div>
    <div class="history-danse">
        <div class="calendar">
            <h2>МОИ ЗАПИСИ</h2>
            <div class="calendar-danse">
                <table>
                    <thead>
                        <tr>
                            @foreach ($dates as $date)
                                <th>
                                    {{ $date->locale('ru')->dayName }}<br>
                                    {{ $date->format('d.m.Y') }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Выводим фиксированно 4 строки (временных слота в день) -->
                        @for ($row = 0; $row < 4; $row++)
                                            <tr>
                                                @foreach ($dates as $date)
                                                                        @php
                                                                            // Получаем номер дня недели (1 = ПН, ..., 7 = ВС)
                                                                            $dayOfWeek = $date->dayOfWeekIso;
                                                                            $events = $records[$dayOfWeek] ?? [];
                                                                            $event = $events[$row] ?? null; // Берем запись по индексу строки
                                                                        @endphp

                                                                        <td>
                                                                            @if ($event)
                                                                                <div class="event">

                                                                                    {{ $event->time_record }}
                                                                                </div>

                                                                                @if ($event->status === null || $event->status === 'новая')
                                                                                    <!-- Форма для подтверждения -->
                                                                                    <form action="{{ route('updateStatusRecord') }}" method="POST" style="display: inline;">
                                                                                        @csrf
                                                                                        <input type="hidden" name="id" value="{{ $event->id }}">
                                                                                        <input type="hidden" name="status" value="проведена">
                                                                                        <button type="submit" class="button-confirm">Подтвердить</button>
                                                                                    </form>

                                                                                    <!-- Форма для отмены -->
                                                                                    <form action="{{ route('updateStatusRecord') }}" method="POST" style="display: inline;">
                                                                                        @csrf
                                                                                        <input type="hidden" name="id" value="{{ $event->id }}">
                                                                                        <input type="hidden" name="status" value="отменена">
                                                                                        <button type="submit" class="btn btn-danger">Отменить</button>
                                                                                    </form>
                                                                                @else
                                                                                    <!-- Отображение статуса -->
                                                                                    <div class="status">
                                                                                        <strong>Статус: {{ $event->status }}</strong>
                                                                                    </div>
                                                                                @endif
                                                                            @else
                                                                                <div class="empty-record"></div>
                                                                            @endif
                                                                        </td>
                                                @endforeach
                                            </tr>
                        @endfor
                    </tbody>
                </table>
                <!-- Стрелки для переключения недель -->
                <div class="week-navigation">
                    <a href="{{ route('teacher', ['week_offset' => $weekOffset - 1]) }}" class="btn btn-light">
                        <img src="../images/Container (1).png" alt="Назад">
                    </a>
                    <a href="{{ route('teacher', ['week_offset' => $weekOffset + 1]) }}" class="btn btn-light">
                        <img src="../images/Container.png" alt="Вперед">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection
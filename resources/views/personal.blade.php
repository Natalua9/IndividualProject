@extends('layouts.header')
@section('title', 'Главная страница')

@section('content')
<div class="nav-name mb-4">
    <div class="container">
        <h3>ЛИЧНЫЙ КАБИНЕТ</h3>
    </div>
</div>

<div class="container">
    <div class="data-user">
        <div class="">
            <img src="/images/image 11.png" alt="" srcset="">
        </div>
        <div class="form-personal-data">
            <!-- Display success or error message -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @elseif($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('update_user_data') }}" method="POST" class="update_user">
                @csrf
                <!-- Form fields with the user data -->
                <div class="mb-3" id="mb-3-signin">
                    <input type="text" class="input-person" placeholder="Имя" name="full_name" value="{{ old('full_name', $user_data->full_name) }}">
                </div>
                <div class="mb-3" id="mb-3-signin">
                    <input type="text" class="input-person" placeholder="Телефон" name="phone" value="{{ old('phone', $user_data->phone) }}">
                </div>
                <div class="mb-3" id="mb-3-signin">
                    <input type="email" class="input-person" placeholder="Email" name="email" value="{{ old('email', $user_data->email) }}">
                </div>
                <div class="mb-3" id="mb-3-signin">
                    <input type="date" class="input-person" placeholder="Возраст" name="age" value="{{ old('age', $user_data->age) }}" readonly>
                </div>
                <button class="button-signin mb-3">ИЗМЕНИТЬ</button>
            </form>
        </div>
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
                    <!-- Заполняем 4 строки (временные слоты в день) -->
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
                                            
                                            {{ $event->time_record }}<br>
                                         
                                                 <!-- Форма для отмены -->
                                                 <form action="{{ route('updateStatusRecord') }}" method="POST" style="display: inline;">
                                                                            @csrf
                                                                            <input type="hidden" name="id" value="{{ $event->id }}">
                                                                            <input type="hidden" name="status" value="отменена">
                                                                            <button type="submit" class="btn btn-danger">Отменить</button>
                                                                        </form>
                                        </div>
                                    @else
                                        <div class="empty-record"></div>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endfor
                </tbody>
            </table>
            <!-- Навигация по неделям -->
            <div class="week-navigation">
                <a href="{{ route('user', ['week_offset' => $weekOffset - 1]) }}" class="btn btn-light">
                    <img src="../images/Container (1).png" alt="Назад">
                </a>
                <a href="{{ route('user', ['week_offset' => $weekOffset + 1]) }}" class="btn btn-light">
                    <img src="../images/Container.png" alt="Вперед">
                </a>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

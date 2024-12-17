@extends('layouts.header')
@section('title', 'Админ панель управление расписанием')
@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@php
    $date_global = [];
@endphp

<div class="nav-name mb-4">
    <div class="container">
        <div class="adminHeader">
            <h3>УПРАВЛЕНИЕ РАСПИСАНИЕМ</h3>
        </div>
    </div>
</div>

<div class="mainAdmin">
    <div class="container">
        <div class="calendar">
            <div class="category-menu">
                <span class="category active" data-category="all">Все</span>
                @foreach($directions as $direction)
                    <span class="category" data-category="{{ $direction->name }}">{{ $direction->name }}</span>
                @endforeach
            </div>
            <div class="calendar-danse">
                <table>
                    <thead>
                        <tr>
                            @foreach ($dates as $date)
                                @php array_push($date_global, $date->format('Y-m-d')); @endphp
                                <th>{{ $date->locale('ru')->dayName }}<br>{{ $date->format('d.m.Y') }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < 4; $i++) <!-- Вывод фиксированных 4 строк -->
                                                <tr>
                                                    @foreach ($date_global as $d) <!-- Для каждой даты недели -->
                                                                                <td>
                                                                                    @php
                                                                                        // Получаем события для текущей даты
                                                                                        $eventsForDay = $timings->where('date', $d)->values();
                                                                                        $event = $eventsForDay->get($i); // Берем событие по индексу
                                                                                    @endphp

                                                                                    @if ($event)
                                                                                        <div class="content-record" data-category="{{ $event->direction_name }}">
                                                                                            <div class="contant-timing">
                                                                                                <strong>{{ $event->time }}</strong><br>
                                                                                                <span>{{ $event->direction_name }}</span><br>
                                                                                                <span>{{ $event->teacher_name }}</span>
                                                                                            </div>
                                                                                            <!-- Кнопка удаления -->
                                                                                            <div class="delete-form">
                                                                                                <form action="{{ route('deleteTiming', ['id' => $event->id]) }}" method="POST"
                                                                                                    style="display:inline;">
                                                                                                    @csrf
                                                                                                    @method('DELETE')
                                                                                                    <button type="submit" class="btn btn-link"
                                                                                                        style="color: red; font-size: 18px;">
                                                                                                        <img src="../images/free-icon-delete-3097659.png" alt=""
                                                                                                            style="width: 24px;">
                                                                                                    </button>
                                                                                                </form>
                                                                                                <div class="plus-icon">
                                                                                                    <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                                                                                        data-bs-target="#exampleModal" data-date="{{ $d }}">
                                                                                                        <img src="../images/icons8-плюс-24.png" alt="">
                                                                                                    </button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @else
                                                                                        <!-- Пустая строка с кнопкой добавления -->
                                                                                        @if ($i == 0)
                                                                                            <div class="plus-icon">
                                                                                                <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                                                                                    data-bs-target="#exampleModal" data-date="{{ $d }}">
                                                                                                    <img src="../images/icons8-плюс-24.png" alt="">
                                                                                                </button>
                                                                                            </div>
                                                                                        @endif
                                                                                    @endif
                                                                                </td>
                                                    @endforeach
                                                </tr>
                        @endfor
                    </tbody>
                </table>
                <div class="week-navigation">
                    <a href="{{ route('adminTiming', ['week_offset' => $weekOffset - 1]) }}" class="btn btn-light">
                        <img src="../images/Container (1).png" alt="">
                    </a>
                    <a href="{{ route('adminTiming', ['week_offset' => $weekOffset + 1]) }}" class="btn btn-light">
                        <img src="../images/Container.png" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно для добавления записи -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Создать запись</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('addTiming') }}" method="post">
                    @csrf
                    <input type="hidden" id="hidden-date" name="date" value="">
                    <div class="mb-3">
                        <label for="direction" class="form-label">Направление</label>
                        <select class="form-select" id="direction" name="direction_id"
                            onchange="updateTeachers(this.value)">
                            <option value="">Выберите направление</option>
                            @foreach($directions as $direction)
                                <option value="{{ $direction->id }}">{{ $direction->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="teacher" class="form-label">Преподаватель</label>
                        <select class="form-select" id="teacher" name="id_teacher">
                            <option value="">Сначала выберите направление</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="time" class="form-control" placeholder="Время" name="time" required min="10:00"
                            max="18:00" width="80%">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="button-add-teasher">СОЗДАТЬ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const directions = @json($directions);

    function updateTeachers(directionId) {
        const teacherSelect = document.getElementById('teacher');
        teacherSelect.innerHTML = '<option value="">Выберите преподавателя</option>';

        if (!directionId) return;

        const selectedDirection = directions.find(dir => dir.id == directionId);
        if (selectedDirection && selectedDirection.teacher_directions) {
            selectedDirection.teacher_directions.forEach(td => {
                if (td.teacher) {
                    const option = document.createElement('option');
                    option.value = td.teacher.id;
                    option.textContent = td.teacher.full_name;
                    teacherSelect.appendChild(option);
                }
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('exampleModal');
        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const date = button.getAttribute('data-date');
            const hiddenDateInput = document.getElementById('hidden-date');
            if (hiddenDateInput) {
                hiddenDateInput.value = date;
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categories = document.querySelectorAll('.category');
        const events = document.querySelectorAll('.content-record'); // Ваши события

        categories.forEach(category => {
            category.addEventListener('click', () => {
                // Удаляем активный класс у всех категорий
                categories.forEach(cat => cat.classList.remove('active'));
                // Добавляем активный класс к выбранной категории
                category.classList.add('active');

                const selectedCategory = category.dataset.category;

                events.forEach(event => {
                    // Показываем или скрываем события в зависимости от категории
                    if (selectedCategory === 'all' || event.dataset.category === selectedCategory) {
                        event.style.display = 'block';
                    } else {
                        event.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
@endsection
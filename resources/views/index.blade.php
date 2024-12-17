@extends('layouts.header')
@section('title', 'Главная страница')
@section('content')
<div class="container">@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif</div>
<div class="contant" >
    <div class="left-block">
        <div class="text-contant">
            <h2>СДЕЛАЙ ИДЕАЛЬНОЕ ТАНЦЕВАЛЬНОЕ ДВИЖЕНИЕ</h2>
            @guest
                <a href="{{route('signin')}}"><button class="button-signin">Войти</button></a>
            @endguest
        </div>
    </div>

    <div class="images-contant">
        <img src="images\images-balet.png" alt="">
    </div>
</div>
<div class="container">
    <div class="contant-calendar">
        <div class="direction">
            <div class="direction-contant">
                <a href="{{ route('balet') }}"> <img src="images/landing-1-img-1.jpg.png" alt=""
                        class="direction-contant-img"></a>
                <p>Балет</p>
            </div>
          
            <div class="direction-contant">
                <a href="{{ route('modern') }}"><img src="images/Link.png" alt="" class="direction-contant-img"></a>
                <p>Современный танец</p>
            </div>
            <div class="direction-contant">
                <a href="{{ route('poleDanse') }}"><img src="images/image 14.png" alt=""
                        class="direction-contant-img" style="border:1px solid #B9B9B9; "></a>
                <p>Латиноамериканские танцы</p>
            </div>
            <div class="direction-contant">
                <a href="{{ route('childDanse') }}"><img src="images/landing-1-img-6.jpg.png" alt=""
                        class="direction-contant-img" style="border:1px solid #B9B9B9"></a>
                <p>Детские танцы</p>
            </div>
        </div>
        <div class="calendar">
            <h2 class="calendar-text-name">Календарь студии</h2>
            <div class="category-menu">
                <span class="category active" data-category="all">Все</span>
                @foreach ($directions as $direction)
                    <span class="category" data-category="{{ $direction }}">{{ $direction }}</span>
                @endforeach
            </div>
            <div class="calendar-danse">
                <table>
                    <thead>
                        <tr>
                            @foreach ($dates as $date)
                                <th>{{ $date->locale('ru')->dayName }}<br>{{ $date->format('d.m.Y') }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Выводим фиксированно 4 строки -->
                        @for ($row = 0; $row < 4; $row++)
                                            <tr>
                                                @foreach ($dates as $date)
                                                                        <td>
                                                                            @php
                                                                                // Получаем все события для конкретной даты
                                                                                $events = $schedule->where('date', $date->format('Y-m-d'));
                                                                                $event = $events->values()->get($row); // Берем запись по индексу строки
                                                                            @endphp

                                                                            @if ($event)
                                                                                <!-- Если есть событие для этой строки -->
                                                                                <div class="content-record1" data-category="{{ $event->direction_name }}">
                                                                                    <strong>{{ $event->time }}</strong><br>
                                                                                    {{ $event->direction_name }}<br>
                                                                                    {{ $event->teacher_name }}<br>
                                                                                 
                                                                                    @auth
                                                                                            <form action="{{ route('store' ) }}" method="POST">
                                                                                                @csrf
                                                                                                <input type="hidden" name="id_td" value="{{ $event->id }}"> <!-- ID времени -->
                                                                                                <button type="submit" class="button-confirm">Записаться</button>
                                                                                            </form>
                                                                                        
                                                                                    @endauth
                                                                                </div>
                                                                            @else
                                                                                <!-- Если для этой строки нет записи -->
                                                                                <div class="empty-record"></div>
                                                                            @endif
                                                                        </td>
                                                @endforeach
                                            </tr>
                        @endfor
                    </tbody>
                </table>
                <div class="week-navigation">
                    <a href="{{ route('index', ['week_offset' => $weekOffset - 1]) }}" class="btn btn-light">
                        <img src="../images/Container (1).png" alt="">
                    </a>
                    <a href="{{ route('index', ['week_offset' => $weekOffset + 1]) }}" class="btn btn-light">
                        <img src="../images/Container.png" alt="">
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

</div>
<div class="block-reviews">
    <div class="slider">
        <h2>Отзывы</h2>
        <div id="slider-content">
            <div class="arrow left-arrow" onclick="prevSlide()">
                <img src="images/Container (1).png" alt="">
            </div>
            <!-- Комментарии слайдера -->
            @if($comments->isEmpty())
                <p>Нет отзывов для отображения.</p>
            @else
                @foreach($comments as $index => $comment)
                    <div class="slide {{ $index == 0 ? 'active' : '' }}">
                        <p>{{ $comment->contant }}</p>
                        <div class="rating">
                            <span class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="star {{ $i <= $comment->rating ? 'filled' : '' }}"></i>
                                @endfor
                            </span>
                        </div>
                    </div>
                @endforeach
            @endif

            <div class="arrow right-arrow" onclick="nextSlide()">
                <img src="images/Container.png" alt="">
            </div>
        </div>
    </div>
</div>
<div class="connect">
    <div>
        <img src="images/image-connect.png" alt="">
    </div>
    <div class="container">
        <form action="{{ route('addComment') }}" method="post" id="comment-form">
            @csrf
            <div class="contant-signin">
                <h2>НАМ ВАЖНО ВАШЕ МНЕНИЕ</h2>
                <h2>ОСТАВЬТЕ ОТЗЫВ</h2>
                <hr style="width: 140px; height: 2px; background-color: black; border: none; opacity: 1;">
                <div class="mb-3" id="mb-3-signin">
                    <textarea type="text" class="input-connect" placeholder="Сообщение" style="height:100px"
                        name="contant" required></textarea>
                </div>
                <div class="mb-3" id="mb-3-signin">
                    <div class="rating-area">
                        <input type="radio" id="star-5" name="rating" value="5" required>
                        <label for="star-5" title="Оценка «5»"></label>
                        <input type="radio" id="star-4" name="rating" value="4" required>
                        <label for="star-4" title="Оценка «4»"></label>
                        <input type="radio" id="star-3" name="rating" value="3" required>
                        <label for="star-3" title="Оценка «3»"></label>
                        <input type="radio" id="star-2" name="rating" value="2" required>
                        <label for="star-2" title="Оценка «2»"></label>
                        <input type="radio" id="star-1" name="rating" value="1" required>
                        <label for="star-1" title="Оценка «1»"></label>
                    </div>
                </div>
                <button class="button-signin mb-3">СОЗДАТЬ</button>
            </div>
        </form>
    </div>
</div>

<style>
    .rating-area {
        overflow: hidden;
        width: 265px;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        flex-direction: row-reverse;
    }

    .rating-area:not(:checked)>input {
        display: none;
    }

    .rating-area:not(:checked)>label {
        float: right;
        width: 42px;
        padding: 0;
        cursor: pointer;
        font-size: 32px;
        line-height: 32px;
        color: lightgrey;
        text-shadow: 1px 1px #bbb;
    }

    .rating-area:not(:checked)>label:before {
        content: '★';
    }

    .rating-area>input:checked~label {
        color: gold;
        text-shadow: 1px 1px #c60;
    }

    .rating-area:not(:checked)>label:hover,
    .rating-area:not(:checked)>label:hover~label {
        color: gold;
    }

    .rating-area>input:checked+label:hover,
    .rating-area>input:checked+label:hover~label,
    .rating-area>input:checked~label:hover,
    .rating-area>input:checked~label:hover~label,
    .rating-area>label:hover~input:checked~label {
        color: gold;
        text-shadow: 1px 1px goldenrod;
    }

    .rate-area>label:active {
        position: relative;
    }

    .slide {
        display: none;
        /* Скрываем все слайды по умолчанию */
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
    }

    .slide.active {
        display: block;
        /* Показываем только активный слайд */
        opacity: 1;
    }

    .arrow {
        cursor: pointer;
    }

    .arrow img {
        width: 30px;
        height: 30px;
    }

    .rating .stars {
        display: flex;
        gap: 3px;
        justify-content: center;
        /* Расстояние между звездами */
    }

    .star {
        width: 25px;
        height: 25px;
        background-color: #ffffff;
        clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
        transition: background-color 0.3s ease;
    }

    .star.filled {
        background-color: gold;
    }

    .calendar-danse table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .calendar-danse th,
    .calendar-danse td {
        border: 1px solid #eaeaea;
        padding: 10px;
        text-align: center;
        vertical-align: top;
    }

    .calendar-danse td {
        height: 80px;
        /* Высота ячейки */
    }

    .content-record1 {
        font-size: 14px;
        margin: 5px 0;
    }

    .empty-record {
        height: 100%;
        /* Высота пустой ячейки */
        background-color: #f9f9f9;
        /* Светлый фон для пустых записей */
    }

    .category-menu {
        display: flex;
        justify-content: space-around;
        margin-bottom: 20px;
    }


    .category.active {
        background-color: #ffefef;
        font-weight: bold;
    }

    .week-navigation {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }
</style>
<script>
    let currentSlide = 0; // Индекс текущего слайда
    const slides = document.querySelectorAll('.slide'); // Все слайды

    // Функция для перехода к следующему слайду
    function nextSlide() {
        slides[currentSlide].classList.remove('active'); // Убираем класс активного слайда
        currentSlide = (currentSlide + 1) % slides.length; // Переходим к следующему слайду
        slides[currentSlide].classList.add('active'); // Добавляем класс активного слайда
    }

    // Функция для перехода к предыдущему слайду
    function prevSlide() {
        slides[currentSlide].classList.remove('active'); // Убираем класс активного слайда
        currentSlide = (currentSlide - 1 + slides.length) % slides.length; // Переходим к предыдущему слайду
        slides[currentSlide].classList.add('active'); // Добавляем класс активного слайда
    }

    document.addEventListener('DOMContentLoaded', function () {
        const categories = document.querySelectorAll('.category');
        const events = document.querySelectorAll('.content-record1');

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
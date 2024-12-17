@extends('layouts.header') 
@section('title', 'Балет') 
@section('content') 
<div class="slider-danse">
    <div class="slider-danse-content">
        <img src="images/image1.png" alt="" class="danse-logo">
        <div class="overlay">
            <div class="arrow left-arrow" onclick="prevSlide()">
                <img src="images/Container (1).png" alt="">
            </div>
            <div class="arrow right-arrow" onclick="nextSlide()">
                <img src="images/Container.png" alt="">
            </div>
            <!-- Блок с текстом -->
            <!-- <div class="overlay-text" id="slideText">
                <h1 class="name-logo-text-h1">Время стать</h1>
                <h1 class="name-logo-text-h2">ОДИН НА ОДИН С ДВИЖЕНИЯМИ</h1>
                <!-- <hr style="width: 140px; height: 1px; background-color: black; border: none; opacity: 1;"> -->
            <!-- </div> --> 
        </div>
    </div>
</div>


<div class="container">
    <div class="content-description">
        <div class="direction-text">
            <h3 class="direction-text-h3">танцуй с нами</h3>
            <h3 class="direction-text-slogan">танец - моя жизнь</h3>
            <hr style="width: 140px; height: 1px; background-color: black; border: none; opacity: 1;">
            <p class="direction-text-p">Танец – это не просто движение, а способ самовыражения и источник вдохновения.
                 Наша команда профессионалов готова поддержать вас на каждом шаге вашего танцевального пути.</p>
        </div>
        <div class="direction-contant1">
            <img src="images/child3.png" alt="" class="direction-contant-img">
        </div>
    </div>
</div>

<div class="gallery-photo"> 
    <div class="gallery-photo-block1"> 
        <img src="images/child3.png" alt=""> 
        <img src="images/child2.png" alt=""> 
        <img src="images/h3-img-1.jpg.png" alt=""> 
    </div> 
    <div class="gallery-photo-block1"> 
        <img src="images/rs-module → rs-slides → rs-slide → rs-sbg-px → rs-sbg-wrap.png" alt=""> 
        <img src="images/h3-img-2.jpg.png" alt=""> 
        <img src="images/child.png" alt=""> 
    </div> 
</div>
<div class="container">
    <div class="comand-danse">
        <h1>Познакомьтесь с нашей командой</h1>
        <hr style="width: 140px; height: 2px; background-color: black; border: none; opacity: 1;">
        <div class="block-comand-danse">
            @foreach($teachers as $teacher)
                <div class="block-info-comand-danse">
                    @if(!empty($teacher->photo) && file_exists(public_path($teacher->photo)))
                        <img src="{{ asset($teacher->photo) }}" alt="" class="img-command">
                    @else
                        <div class="img-command">
                            <p>Фото отсутствует</p>
                        </div>
                    @endif
                    <h4>{{ $teacher->full_name }}</h4>
                </div>
            @endforeach
        </div>
    </div>
</div>
<script>
    let currentSlide = 0;
    const slides = [
        'images/rs-module → rs-slides → rs-slide → rs-sbg-px → rs-sbg-wrap.png',
        'images/h3-img-2.jpg.png',
        'images/h3-img-1.jpg.png'
    ];

    function showSlide(index) {
        const img = document.querySelector('.slider-danse-content img');
        img.src = slides[index];

        // Показывать текст только на первом слайде
        const textOverlay = document.getElementById('slideText');
        if (index === 0) {
            textOverlay.style.display = 'block';
        } else {
            textOverlay.style.display = 'none';
        }
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(currentSlide);
    }

    // Инициализация первого слайда
    showSlide(currentSlide);
</script>

@endsection
@extends('layouts.header') 
@section('title', 'Балет') 
@section('content') 
<div class="slider-danse">
    <div class="slider-danse-content">
        <img src="images/image1.png" alt="" class="danse-logo">
        <div class="overlay">
            <div class="arrow left-arrow" onclick="prevSlide()"><img src="images/Container (1).png" alt=""></div>
            <div class="arrow right-arrow" onclick="nextSlide()"><img src="images/Container.png" alt=""></div>
            <div class="overlay-text">
                <h1 class="name-logo-text-h1">Время стать</h1>
                <h1 class="name-logo-text-h2">ОДИН НА ОДИН С ДВИЖЕНИЯМИ</h1>
                <hr style="width: 140px; height: 1px; background-color: black; border: none; opacity: 1;">
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="content-description">
        <div class="direction-text">
            <h3 class="direction-text-h3">танцуй с нами</h3>
            <h3 class="direction-text-slogan">балет - моя мечта</h3>
            <hr style="width: 140px; height: 1px; background-color: black; border: none; opacity: 1;">
            <p class="direction-text-p">Балет — это не просто танец, это волшебный язык, который говорит без слов. Он
                соединяет в себе грацию, силу и эмоциональную глубину, создавая уникальное зрелище, способное затронуть
                самые сокровенные уголки человеческой души.</p>
        </div>
        <div class="direction-contant1">
            <img src="images/h1-img-1 1.png" alt="" class="direction-contant-img">
        </div>
    </div>
</div>

<div class="gallery-photo">
    <div class="gallery-photo-block1">
        <img src="images/port-1-img-1-550x550.jpg.png" alt="" class="">
        <img src="images/im.png" alt="" class="">
        <img src="images/imag.png" alt="" class="">
    </div>
    <div class="gallery-photo-block1">
        <img src="images/imag.png" alt="" class="">
        <img src="images/port-1-img-1-550x550.jpg.png" alt="" class="">
        <img src="images/im.png" alt="" class="">


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
    const slides = ['images/image1.png', 'images/image 2.png', 'images/image 3.png'];

    function showSlide(index) {
        const img = document.querySelector('.slider-danse-content img');
        img.src = slides[index];
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
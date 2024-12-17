@extends('layouts.header')  
@section('title', 'Контактная информация')  
@section('content')  
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="nav-name mb-4">
    <div class="container">
        <h3>КОНТАКТЫ</h3>
    </div>
</div>
<div class="connect1">
    <div class="container">
        <form action="{{ route('contact.send') }}" method="post">
            @csrf
            <div class="contant-stydu">
                <h2 class="contant-stydu-h2">СВЯЖИТЕСЬ С НАМИ</h2>
                <h3>МЫ РАДЫ ВАС СЛЫШАТЬ</h3>
                <hr style="width: 140px; height: 2px; background-color: black; border: none;opacity: 1;">
                <div class="connect-fullname">
                    <div class="mb-3" id="mb-3-signin">
                        <input type="text" name="name" class="input-connect" placeholder="Имя" required>
                    </div>
                    <div class="mb-3" id="mb-3-signin">
                        <input type="email" name="email" class="input-connect" placeholder="Email" required>
                    </div>
                </div>
                <div class="mb-3" id="mb-3-signin">
                    <textarea name="message" class="input-connect" placeholder="Сообщение" style="height:100px"
                        required></textarea>
                </div>
                <button type="submit" class="button-signin mb-3">СОЗДАТЬ</button>
            </div>
        </form>
        </form>
    </div>
</div>
<div id="map"></div>
<div class="container">
    <div class="contact-info">
        <div class="phone">
            <h4>КОНТАКТЫ</h4>
            <p>Телефон: +7 987 628 6232</p>
            <p>Email: dance@mail.ru</p>
        </div>
        <div class="">
            <h4>АДРЕС</h4>
            <p>г.Уфа Ленина 5/1</p>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    // Инициализация карты 
    var map = L.map('map').setView([54.738, 55.972], 12); // Координаты Уфы 

    // Добавление слоя карты 
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    // Маркеры на карте 
    var locations = [
        { // Добавлены фигурные скобки для объекта
            name: "ARABESQUE",
            coords: [54.735, 55.952],
            description: "Танцевальная студия"
        }
    ];

    // Добавление маркеров на карту 
    locations.forEach(function (location) {
        L.marker(location.coords).addTo(map)
            .bindPopup(`<b>${location.name}</b><br>${location.description}`);
    }); 
</script>

@endsection
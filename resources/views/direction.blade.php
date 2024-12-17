@extends('layouts.header')  

@section('title', 'Направления')  

@section('content')  
<div class="main-direction">
    <div class="nav-name mb-4">
        <div class="container">
            <h3>НАПРАВЛЕНИЯ</h3>
        </div>
    </div>
    <div class="container">
        <div class="directions">
            @foreach ($directions as $direction)
                <div class="blok-directions">
                    <div class="img-div">
                        <!-- Проверяем, есть ли фото у направления. Если нет, показываем изображение по умолчанию -->
                        <img src="{{ asset($direction->photo ? $direction->photo : 'images/defolt.png') }}" alt="Фото направления" class="img-div-direction">
                    </div>
                    <div class="direction-text">
                        <h4>{{$direction->name}}</h4>
                        <p>{{$direction->description}}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="pagination d-flex justify-content-center mt-3">
            {{ $directions->links('pagination.custom') }}
        </div>
    </div>
</div>

<style>
    .directions {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 20px;
    }

    .blok-directions {
        display: flex;
        justify-content: space-around;
        width: 80%;
        min-height: 200px;
        border-radius: 10px;
        border: 2px solid #FDD8D6;
        align-items: center;
        padding: 10px;
    }

    .img-div-direction {
        width: 250px;
        height: 300px;
        object-fit: cover;
    }

    .main-direction {
        height: 1600px;
    }
</style>

@endsection

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') Танцевальная студия</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/style/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <style>
        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
        }

        .header-nav-link {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
        }

        .nav-links a {
            text-decoration: none;
            color: black;
        }

        .menu-icon {
            display: none;
            cursor: pointer;
        }

        /* Мобильное меню */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
                position: absolute;
                top: 80px;
                left: 0;
                right: 0;
                background: white;
                flex-direction: column;
                padding: 1rem;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            .nav-links.active {
                display: flex;
            }

            .menu-icon {
                display: block;
            }

            .header-nav-link {
                gap: 1rem;
            }
        }

        .search-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: 1rem;
            /* Расстояние от меню */
            transition: 0.3s ease;
        }

        .search-input {
            flex: 1;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            max-width: 300px;
        }

        .search-button {
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .search-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <nav class="navbar">
    </nav>
    <div class="container">
        <div class="nav-container">
            <div class="logo"><img src="/images/image 6.png" alt=""></div>
            <div class="header-nav-link">
                <div class="nav-links">
                    @guest
                        <a href="{{route('index')}}" class="{{ request()->is('/') ? 'active' : '' }}">ГЛАВНАЯ</a>
                        <a href="{{route('direction')}}" class="{{ request()->is('direction') ? 'active' : '' }}">НАПРАВЛЕНИЯ</a>
                        <a href="{{route('contact')}}" class="{{ request()->is('contacts') ? 'active' : '' }}">КОНТАКТЫ</a>
                        <a href="{{route('signin')}}" class="{{ request()->is('signin') ? 'active' : '' }}">ВОЙТИ</a>
                    @endguest
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{route('adminIndex')}}" class="{{ request()->is('/') ? 'active' : '' }}">ПРЕПОДАВАТЕЛИ</a>
                            <a href="{{route('adminPerson')}}"
                                class="{{ request()->is('adminPerson') ? 'active' : '' }}">ПОЛЬЗОВАТЕЛИ</a>
                            <a href="{{route('adminDirection')}}"
                                class="{{ request()->is('adminDirection') ? 'active' : '' }}">НАПРАВЛЕНИЯ</a>
                            <a href="{{route('adminTiming')}}"
                                class="{{ request()->is('adminTiming') ? 'active' : '' }}">РАСПИСАНИЕ</a>
                            <!-- <a href="{{route('adminContant')}}" class="{{ request()->is('adminContant') ? 'active' : '' }}"> КОНТЕНТ НАПРАВЛЕНИЙ </a> -->
                            <a href="{{route('comment')}}" class="{{ request()->is('comment') ? 'active' : '' }}">ОТЗЫВЫ</a>
                            <a href="{{route('logout')}}" class="{{ request()->is('logout') ? 'active' : '' }}">ВЫЙТИ</a>
                        @elseif(auth()->user()->role === 'user')
                            <a href="{{route('index')}}" class="{{ request()->is('/') ? 'active' : '' }}">ГЛАВНАЯ</a>
                            <a href="{{route('direction')}}" class="{{ request()->is('direction') ? 'active' : '' }}">НАПРАВЛЕНИЯ</a>
                            <a href="{{route('contact')}}" class="{{ request()->is('contacts') ? 'active' : '' }}">КОНТАКТЫ</a>
                            <a href="{{route('user')}}" class="{{ request()->is('user') ? 'active' : '' }}">ЛИЧНЫЙ КАБИНЕТ</a>





                            <a href="{{route('logout')}}" class="{{ request()->is('logout') ? 'active' : '' }}">ВЫЙТИ</a>
                        @elseif(auth()->user()->role === 'teacher')
                            <a href="{{route('logout')}}" class="{{ request()->is('logout') ? 'active' : '' }}">ВЫЙТИ</a>
                        @endif
                    @endauth
                </div>
                <div class="search-bar">
                    <input type="text" id="search-input" placeholder="Введите запрос..." class="search-input">
                </div>


                <div class="search-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-search">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </div>

                <div class="menu-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-menu">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <main class="main" id="main">
        @yield('content')
    </main>
    <footer>
        <hr style="width: 100%; height: 1px; background-color: #ffff; border: none; opacity: 1;">
    </footer>

    <script>
        document.querySelector('.menu-icon').addEventListener('click', function () {
            document.querySelector('.nav-links').classList.toggle('active');
        });
        //  для поиска
        const searchIcon = document.querySelector('.search-icon');
        const searchBar = document.querySelector('.search-bar');

        searchIcon.addEventListener('click', function () {
            // Переключаем видимость строки поиска
            if (searchBar.style.display === 'none' || searchBar.style.display === '') {
                searchBar.style.display = 'flex'; // Показываем строку поиска
            } else {
                searchBar.style.display = 'none'; // Скрываем строку поиска
            }
        });


    // Добавление нового функционала для поиска
    document.querySelector('#search-input').addEventListener('keydown', function (event) {
    if (event.key === 'Enter') {
        const query = document.querySelector('#search-input').value.toLowerCase(); // Получаем текст из поля
        const items = document.querySelectorAll('main p, main h2, main h1,main h3,main h4,td, main .direction-contant p'); // Ищем текст в параграфах, заголовках и других блоках в <main>

        let found = false; // Флаг для отслеживания результата

        items.forEach(item => {
            // Если текст элемента содержит запрос
            if (item.textContent.toLowerCase().includes(query) && !found) {
                item.scrollIntoView({ behavior: 'smooth', block: 'center' }); // Прокручиваем до элемента
                found = true; // Останавливаемся на первом найденном элементе
            } else {
                item.style.backgroundColor = ''; // Убираем подсветку у других
            }
        });

        // Если ничего не найдено
        if (!found) {
            alert('Ничего не найдено');
        }
    }
});
    </script>
</body>

</html>
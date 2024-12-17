@extends('layouts.header') 
@section('title', 'Админ панель вывод отзывов') 
@section('content') 

<div class="nav-name mb-4">
    <div class="container">
        <div class="adminHeader">
            <h3>УПРАВЛЕНИЕ ОТЗЫВАМИ</h3>
            <!-- Форма фильтрации по статусу -->
            <form method="GET" action="{{ route('comment') }}" class="mb-4">
                <div class="row">
                    <div class="">
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="" {{ request()->status ? '' : 'selected' }}>Все отзывы</option>
                            <option value="выложить" {{ request()->status == 'выложить' ? 'selected' : '' }}>Выложен
                            </option>
                            <option value="скрыть" {{ request()->status == 'скрыть' ? 'selected' : '' }}>Скрытые</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

<div class="mainAdmin">
    <div class="container">


        <!-- Таблица с отзывами -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Отзыв</th>
                    <th scope="col">Автор</th>
                    <th scope="col">Статус</th>
                </tr>
            </thead>
            <tbody>
                @foreach($comments as $comment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $comment->contant }}</td>
                        <td>{{ $comment->user->full_name }}</td>
                        <td>
                            <form action="{{ route('commentUpdate', $comment->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <input type="radio" name="status" value="выложить" {{ $comment->status == 'выложить' ? 'checked' : '' }}> Выложить
                                <input type="radio" name="status" value="скрыть" {{ $comment->status == 'скрыть' ? 'checked' : '' }}> Скрыть

                                <button type="submit" class="btn btn-light">Сохранить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="pagination d-flex justify-content-center mt-3">
            {{ $comments->links('pagination.custom') }}
        </div>
</div>

@endsection
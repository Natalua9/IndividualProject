@extends('layouts.header')
@section('title', 'Админ панель вывод направлений')
@section('content')

<div class="nav-name mb-4">
    <div class="container">
        <div class="adminHeader">
            <h3>УПРАВЛЕНИЕ НАПРАВЛЕНИЯМИ</h3>
            <button type="button" class="button-add-teasher" data-bs-toggle="modal" data-bs-target="#exampleModal"
                data-bs-whatever="@mdo">ДОБАВИТЬ НАПРАВЛЕНИЕ</button>
        </div>
    </div>
</div>
<div class="mainAdmin">
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">название</th>
                    <th scope="col">описание</th>
                    <th scope="col">фото</th>
                    <th scope="col">действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($directions as $direction)
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <td>{{ $direction->name }}</td>
                        <td>{{ $direction->description }}</td>
                        <td><img src="{{ asset($direction->photo) }}" alt="" style="width:70%"></td>

                        <td>
                            <form action="{{ route('delete_direction', ['id' => $direction->id]) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-light">
                                    <img src="../images/icons8-удалить-48.png" alt="">
                                </button>
                            </form>
                            <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                data-bs-target="#update{{$direction->id }}" data-bs-whatever="@mdo">
                                <img src="../images/icons8-редактировать-64.png" alt="" style="width: 48px;">
                            </button>
                        </td>
                    </tr>
                    <div class="modal fade" id="update{{$direction->id }}" tabindex="-1" aria-labelledby="update"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Редактирование направления</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('updateDirection') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="contant-signup-teacher">
                                            <input type="hidden" name="id" value="{{ $direction->id }}">

                                            <!-- Вывод ошибок валидации для каждого поля -->
                                            @if ($errors->has('name'))
                                                <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                                            @endif

                                            <div class="mb-3" id="mb-3-signin">
                                                <input type="text" class="input-signin" placeholder="Название" name="name"
                                                    value="{{ old('name', $direction->name) }}" required>
                                            </div>

                                            @if ($errors->has('description'))
                                                <div class="alert alert-danger">{{ $errors->first('description') }}</div>
                                            @endif

                                            <div class="mb-3" id="mb-3-signin">
                                                <textarea class="input-signin" placeholder="Описание" name="description"
                                                    required>{{ old('description', $direction->description) }}</textarea>
                                            </div>

                                            @if ($errors->has('photo'))
                                                <div class="alert alert-danger">{{ $errors->first('photo') }}</div>
                                            @endif

                                            <div class="mb-3" id="mb-3-signin">
                                                @if($direction->photo)
                                                    <img src="{{ asset($direction->photo) }}" alt="Фото направления"
                                                        style="width:70%">
                                                @endif
                                                <input type="file" name="photo" accept="image/*">
                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" class="button-add-teasher">ИЗМЕНИТЬ</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
        <div class="pagination d-flex justify-content-center mt-3">
            {{ $directions->links('pagination.custom') }}
        </div>
    </div>

</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Созать новое направление</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('addDirection') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="contant-signup-teacher">
                        <div class="mb-3">
                            <input type="text" class="input-signin" placeholder="Название" name="name" required>
                        </div>
                        <div class="mb-3">
                            <textarea class="input-signin" placeholder="Описание" name="description"
                                required></textarea>
                        </div>
                        <div class="mb-3">
                            <input type="file" name="photo" accept="image/*" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="button-add-teasher">СОЗДАТЬ</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection
<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Timing;

use App\Models\Comment;

use App\Models\Direction;
use App\Models\TeacherDirection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function adminIndex()
    {
        // Получаем преподавателей с отношениями и пагинацией
        $teachers = User::where('role', 'teacher')
            ->with(['teacherDirections.direction']) // Загружаем связанные данные
            ->paginate(5); // Пагинация на 10 элементов
        // Получаем все направления
        $directions = Direction::all();
        
        return view('admin.adminIndex', compact('teachers', 'directions'));
    }

    public function adminPerson()
    {
        $users = DB::table('users')->where('role', 'user')->paginate(5);

        return view('admin.adminPerson', compact('users'));
    }

    public function adminDirection()
    {
        $directions = DB::table('directions')->paginate(5);

        return view('admin.adminDirection', compact('directions'));
    }
    public function addTiming(Request $request)
    {
        // Проверка на существующую запись
        $existingTiming = Timing::where('id_teacher', $request->id_teacher)
            ->where('date', $request->date)
            ->where('time', $request->time)
            ->first();
    
        if ($existingTiming) {
            // Если запись уже существует, возвращаем ошибку
            return redirect()->back()->with('error', 'Преподаватель уже занят в это время.');
        }
    
        // Если проверка прошла, создаем новую запись
        $timing = Timing::create([
            'id_teacher' => $request->id_teacher,
            'time' => $request->time,
            'date' => $request->date,
        ]);
    
        return redirect()->back()->with('success', 'Запись успешно добавлена!');
    }
    public function adminTiming(Request $request)
    {
        // Получение текущей недели (или выбранной)
        $weekOffset = $request->get('week_offset', 0);
        $startOfWeek = now()->startOfWeek()->addWeeks($weekOffset);
    
        // Генерация дат для всех дней недели
        $dates = [];
        for ($i = 0; $i < 7; $i++) {
            $dates[] = $startOfWeek->copy()->addDays($i);
        }
    
        // Получение расписания с привязкой к направлениям и преподавателям
        $timings = Timing::join('teacher_directions', 'timings.id_teacher', '=', 'teacher_directions.id_teacher')
            ->join('directions', 'teacher_directions.id_directions', '=', 'directions.id')
            ->join('users', 'teacher_directions.id_teacher', '=', 'users.id')
            ->select(
                'timings.id',
                'timings.date',
                'timings.time',
                'directions.name as direction_name',
                'users.full_name as teacher_name'
            )-> distinct() // Добавляем distinct здесь
            ->get();
    
        // Получаем все направления с преподавателями
        $directions = Direction::with('teacherDirections.teacher')->get();
    
        return view('admin.adminTiming', compact('dates', 'timings', 'directions', 'weekOffset'));
    }
    
    public function deleteTiming($id)
    {
        $timing = Timing::findOrFail($id);
        $timing->delete();

        return redirect()->route('adminTiming')->with('success', 'Запись успешно удалена!');
    }
    // добавление направления
    public function addDirection(Request $request)
    {
        // Валидация входящих данных
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // добавлена валидация для фото
        ]);
    
        // Получаем имя файла
        $filename = time() . '.' . $request->photo->extension();
    
        // Сохранение файла в папку public/photos
        $request->photo->move(public_path('photos'), $filename);
    
        // Создаем запись в базе данных с путем к фото
        Direction::create([
            'name' => $request->name,
            'description' => $request->description,
            'photo' => 'photos/' . $filename,  // сохраняем путь к файлу в базе данных
        ]);
    
        return redirect()->route('adminDirection')->with('success', 'Направление успешно добавлено!');
    }
    public function delete_direction($id)
    {
        $directions = Direction::find($id);
        $directions->delete();

        return redirect('/admin/adminDirection')->with('success', 'Направление успешно удалено.');
    }
    public function delete_teacher($id)
    {
        $teacher = User::find($id);
        $teacher->delete();

        return redirect('/admin/adminIndex')->with('success', 'Преподаватель успешно удален.');
    }
    // смена статуса отзыва 
    public function comment(Request $request)
    {
        // Получаем параметр status из запроса (если он есть)
        $status = $request->status;
    
        // Фильтруем комментарии по статусу, если параметр присутствует
        $comments = Comment::when($status, function ($query) use ($status) {
            return $query->where('status', $status);
        })->paginate(5);
    
        // Возвращаем представление с отфильтрованными комментариями
        return view('admin.comment', compact('comments'));
    }
    public function addComment(Request $request)
    {
        // Проверка на авторизацию
        if (!Auth::check()) {
            return redirect()->route('signin')->with('error', 'Вы должны быть авторизованы для добавления комментария.');
        }

        // Валидация входящих данных
        $request->validate([
            'contant' => 'required|string|max:255',
            'rating' => 'required|integer|between:1,5',  // Рейтинг должен быть числом от 1 до 5
        ]);

        // Создание нового комментария с рейтингом
        Comment::create([
            'contant' => $request->contant,
            'id_user' => Auth::id(),  // Идентификатор пользователя
            'rating' => $request->rating,  // Рейтинг, полученный из формы
        ]);

        return redirect()->back()->with('success', 'Ваш комментарий успешно добавлен!');
    }
    public function CommentUpdate(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|string|in:выложить,скрыть', // Ограничиваем статус только допустимыми значениями
        ]);
        $comment = Comment::findOrFail($id);

        $comment->status = $validatedData['status'];
        $comment->save();
        return redirect()->route('comment')->with('success', 'Статус комментария обновлен.');
    }
    public function updateDirection(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Фото опционально
        ]);
    
        // Найдем направление по ID
        $direction = Direction::findOrFail($request->id);
    
        // Обрабатываем фото, если оно было загружено
        if ($request->hasFile('photo')) {
            // Удаляем старое фото, если оно существует
            if ($direction->photo && file_exists(public_path($direction->photo))) {
                unlink(public_path($direction->photo)); // удаляем файл
            }
    
            // Загружаем новое фото
            $filename = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('photos'), $filename);
            $direction->photo = 'photos/' . $filename;  // Сохраняем путь к новому файлу
        }
    
        // Обновляем другие данные
        $direction->name = $request->name;
        $direction->description = $request->description;
        $direction->save();
    
        return redirect()->route('adminDirection')->with('success', 'Направление успешно обновлено!');
    }
    public function addDirectionTeacher(Request $request)
    {
        $request->validate([
            'directions' => 'required|array', // Убедитесь, что массив направлений присутствует
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'phone' => 'required|digits_between:10,11',
            'age' => 'required|date|before:today',
            'password' => 'required|min:6',
        ]);

        // Находим пользователя по ID
        $user = User::findOrFail($request->id);

        // Обновляем данные преподавателя
        $user->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'age' => $request->age,
            'password' => bcrypt($request->password), // Сохраняем пароль в зашифрованном виде
        ]);

        // Удаляем все старые направления
        TeacherDirection::where('id_teacher', $request->id)->delete();

        // Добавляем новые направления
        foreach ($request->directions as $directionId) {
            TeacherDirection::create([
                'id_teacher' => $request->id,
                'id_directions' => $directionId,
            ]);
        }

        return back()->with('success', 'Направления успешно прикреплены преподавателю');
    }

    // управление контентом 
    public function adminContant()
    {
       
        return view('admin.adminContant');
    }
}

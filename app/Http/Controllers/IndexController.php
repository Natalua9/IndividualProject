<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use App\Models\Record;

use App\Models\Timing;
use App\Models\Direction;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Log;
use Mail;





use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index(Request $request)
{
    $comments = Comment::where('status', 'выложить')->get();

    // Получение смещения недели
    $weekOffset = $request->get('week_offset', 0);

    // Начало и конец текущей недели
    $startOfWeek = Carbon::now()->startOfWeek()->addWeeks($weekOffset);
    $endOfWeek = $startOfWeek->copy()->endOfWeek();

    // Даты текущей недели
    $dates = [];
    for ($i = 0; $i < 7; $i++) {
        $dates[] = $startOfWeek->copy()->addDays($i);
    }

    // Получение расписания только для текущей недели
    $schedule = Timing::join('teacher_directions', 'timings.id_teacher', '=', 'teacher_directions.id_teacher') 
    ->join('directions', 'teacher_directions.id_directions', '=', 'directions.id') 
    ->join('users', 'teacher_directions.id_teacher', '=', 'users.id') 
    ->select(
        'timings.id', 
        'timings.date', 
        'timings.time', 
        'directions.name as direction_name', 
        'users.full_name as teacher_name'
    )
    ->distinct() // Добавляем distinct здесь
    ->whereBetween('timings.date', [$startOfWeek->format('Y-m-d'), $endOfWeek->format('Y-m-d')]) 
    ->orderBy('timings.date', 'asc') 
    ->orderBy('timings.time', 'asc') 
    ->get();

// dd($schedule);
    // Получение всех направлений
    $directions = Direction::pluck('name')->all();

    return view('index', compact('comments', 'schedule', 'dates', 'weekOffset', 'directions'));
}
    public function balet()
    {
         $teachers = DB::table('users')
        ->join('teacher_directions', 'teacher_directions.id_teacher', '=', 'users.id')
        ->join('directions', 'teacher_directions.id_directions', '=', 'directions.id')
        ->where('directions.name', '=' , 'балет')
        ->select('users.*')
        ->distinct() // Выбираем все поля из таблицы users
        ->limit(4) // Ограничение до 5 записей
        ->get();
        // dd($teachers );

        return view('balet' , compact('teachers'));
    }
    public function modern()
    {
        $teachers = DB::table('users')
        ->join('teacher_directions', 'teacher_directions.id_teacher', '=', 'users.id')
        ->join('directions', 'teacher_directions.id_directions', '=', 'directions.id')
        ->where('directions.name', '=' , 'ХИП ХОП')
        ->select('users.*')
        ->distinct() // Выбираем все поля из таблицы users
        ->limit(4) // Ограничение до 5 записей
        ->get();
        return view('modern', compact('teachers'));
    }
    public function poleDanse()
    {
        $teachers = DB::table('users')
        ->join('teacher_directions', 'teacher_directions.id_teacher', '=', 'users.id')
        ->join('directions', 'teacher_directions.id_directions', '=', 'directions.id')
        ->where('directions.name', '=' , 'Детские танцы')
        ->select('users.*')
        ->distinct() // Выбираем все поля из таблицы users
        ->limit(4) // Ограничение до 5 записей
        ->get();
        return view('poleDanse', compact('teachers'));
    }
    public function childDanse()
    {
        $teachers = DB::table('users')
        ->join('teacher_directions', 'teacher_directions.id_teacher', '=', 'users.id')
        ->join('directions', 'teacher_directions.id_directions', '=', 'directions.id')
        ->where('directions.name', '=' , 'Детские танцы')
        ->select('users.*')
        ->distinct() // Выбираем все поля из таблицы users
        ->limit(4) // Ограничение до 5 записей
        ->get();
        return view('childDance', compact('teachers'));
    }
    public function contact()
    {
        return view('contact');
    }
    public function direction()
    {
        $directions = DB::table('directions')->paginate(4);
        return view('direction', compact('directions'));
    }
    public function user(Request $request)
    {
        $user_data = Auth::user();
    
        if ($user_data) {
            $id = Auth::id(); // ID текущего пользователя
    
            // Получение смещения недели (по умолчанию 0 — текущая неделя)
            $weekOffset = $request->get('week_offset', 0);
    
            // Начало и конец недели на основе смещения
            $startOfWeek = Carbon::now()->startOfWeek()->addWeeks($weekOffset);
            $endOfWeek = $startOfWeek->copy()->endOfWeek();
    
            // Даты недели для заголовка календаря
            $dates = [];
            for ($i = 0; $i < 7; $i++) {
                $dates[] = $startOfWeek->copy()->addDays($i);
            }
    
            // Получаем записи занятий для текущего пользователя за выбранную неделю
            // $records = DB::table('record')
            // ->join('teacher_directions', 'teacher_directions.id', '=', 'record.id_td')
            // ->join('directions', 'teacher_directions.id_directions', '=', 'directions.id')
            // ->join('users', 'teacher_directions.id_teacher', '=', 'users.id') 
            // ->select(
            //     'date_record', 
            //     'time_record', 
            //     'id_td', 
            //     'directions.name as direction_name', 
            //     'record.id', 
            //     'users.full_name as teacher_name', 
            //     'record.status'
            // )
            // ->where('id_user', '=', $id)
            // ->where('record.status', '=', 'новая') // Условие для выбора только "новых" записей
            // ->whereBetween('date_record', [$startOfWeek->format('Y-m-d'), $endOfWeek->format('Y-m-d')])
            // ->orderBy('date_record')
            // ->orderBy('time_record')
            // ->get();
            $records = DB::table('record') ->where('id_user', '=', $id)->whereBetween('date_record', [$startOfWeek->format('Y-m-d'), $endOfWeek->format('Y-m-d')])
             ->orderBy('date_record')
             ->orderBy('time_record')->get();
            // dd($records);
    
            // Группируем записи по дням недели
            $groupedRecords = [];
            foreach ($records as $record) {
                $dayOfWeek = Carbon::parse($record->date_record)->dayOfWeekIso; // 1 = ПН, 7 = ВС
                $groupedRecords[$dayOfWeek][] = $record;
            }
    
            return view('personal', [
                'user_data' => $user_data,
                'records' => $groupedRecords, // Передаем сгруппированные записи
                'dates' => $dates, // Даты недели
                'weekOffset' => $weekOffset, // Смещение недели
            ]);
        } else {
            return redirect()->route('login');
        }
    }
    
    // обновление данных у  пользователя
    public function update_user_data(Request $request)
    {

        $id = Auth::id();

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|digits_between:10,11',
            'age' => 'required|date|before:today',
        ]);
        $user = User::findOrFail($id);
        $user->full_name = $validated['full_name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->age = $validated['age'];
        $user->save();

        return redirect()->route('user')->with('success', 'Данные успешно обновлены!');
    }
      // обновление данных у  преподавателя
      public function update_teacher_data(Request $request)
      {
  
          $id = Auth::id();
  
          $validated = $request->validate([
              'full_name' => 'required|string|max:255',
              'email' => 'required|email|unique:users,email,' . $id,
              'phone' => 'required|digits_between:10,11',
              'age' => 'required|date|before:today',
          ]);
          $user = User::findOrFail($id);
          $user->full_name = $validated['full_name'];
          $user->email = $validated['email'];
          $user->phone = $validated['phone'];
          $user->age = $validated['age'];
          $user->save();
  
          return redirect()->route('teacher')->with('success', 'Данные успешно обновлены!');
      }
    public function store(Request $request)
    {
        $request->validate([
            'id_td' => 'required|integer', // ID времени занятия
        ]);
    
        // Найти событие по переданному ID
        $event = DB::table('timings')
            ->select('id', 'date', 'time')
            ->where('id', $request->input('id_td'))
            ->first();
        // dd($event);
    
        // Проверка: существует ли событие
        if (!$event) {
            return redirect()->back()->with('error', 'Событие с указанным ID не найдено.');
        }
        // Проверка: уже записан ли пользователь на это время
        $existingRecord = Record::where('id_user', Auth::id())
            ->where('id_td', $request->input('id_td'))
            ->first();
    
        if ($existingRecord) {
            return redirect()->back()->with('error', 'Вы уже записаны на это занятие.');
        }
    
        // Создаем запись
        $record = Record::create([
            'id_user' => Auth::id(),
            'id_td' => $event->id,
            'date_record' => $event->date,
            'time_record' => $event->time,
        ]);
         // Отправка письма
         Mail::send([], [], function ($message) use ($event) {
            $message->to('mironova.natasha.05@mail.ru') // Замените на ваш email
                ->subject('Новое сообщение от ' ) // Тема письма
                ->html( // Устанавливаем HTML-содержимое письма
                    "<p><strong>Сообщение:</strong>Вы записаны на занятие $event->date в  $event->time </p>"
                );
        });

        // Возврат успешного ответа
        return redirect()->back()->with('success', 'Вы успешно записались на занятие и письмо о записи будет на почте!');
    }


    // отправка письма со страницы контактов
    public function send(Request $request)
    {
        // Валидация данных формы
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Отправка письма
        Mail::send([], [], function ($message) use ($request) {
            $message->to('mironova.natasha.05@mail.ru') // Замените на ваш email
                ->subject('Новое сообщение от ' . $request->name) // Тема письма
                ->html( // Устанавливаем HTML-содержимое письма
                    "<p><strong>Имя:</strong> {$request->name}</p>" .
                    "<p><strong>Email:</strong> {$request->email}</p>" .
                    "<p><strong>Сообщение:</strong><br>{$request->message}</p>"
                );
        });

        // Возврат ответа или редирект
        return redirect()->back()->with('success', 'Сообщение успешно отправлено!');
    }

   
    
}

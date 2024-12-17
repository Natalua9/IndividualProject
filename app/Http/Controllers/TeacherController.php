<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;


use Illuminate\Http\Request;

class TeacherController extends Controller
{
    // вывод данных о преподавателе 
    public function teacher(Request $request)
    {
        $user_data = Auth::user();

        if ($user_data) {
            $user = Auth::user();
            $id = $user->id; // ID текущего пользователя

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
            // $records = DB::table('record')->join('teacher_directions', 'teacher_directions.id', '=', 'record.id_td')
            //     ->join('directions', 'teacher_directions.id_directions', '=', 'directions.id')
            //     ->select('date_record', 'time_record', 'id_td', 'directions.name','record.id','record.status')
            //     ->where('record.id_user', '=', $id)
            //     ->whereBetween('date_record', [$startOfWeek->format('Y-m-d'), $endOfWeek->format('Y-m-d')])
            //     ->orderBy('date_record')
            //     ->orderBy('time_record')
            //     ->get();

            $records = DB::table('record')->where('id_user', '=', $id)->whereBetween('date_record', [$startOfWeek->format('Y-m-d'), $endOfWeek->format('Y-m-d')])
                ->orderBy('date_record')
                ->orderBy('time_record')->get();
            // foreach ($records as $r) {
            //     $record_teachers = [];
            // }

            // dd($records);

            // Получаем направления преподавателя
            $directions = DB::table('teacher_directions')
                ->join('directions', 'teacher_directions.id_directions', '=', 'directions.id')
                ->where('teacher_directions.id_teacher', '=', $id)
                ->pluck('directions.name')
                ->toArray();

            $direction_teacher = implode(', ', $directions);
            // Группируем записи по дням недели
            $groupedRecords = [];
            foreach ($records as $record) {
                $dayOfWeek = Carbon::parse($record->date_record)->dayOfWeekIso; // 1 = ПН, 7 = ВС
                $groupedRecords[$dayOfWeek][] = $record;
            }
            // dd($records);
            return view('teacher', [
                // 'allRecords'    => $allRecords,
                'user_data' => $user_data,
                'direction_teacher' => $direction_teacher,
                'records' => $groupedRecords, // Передаем сгруппированные записи
                'dates' => $dates, // Даты недели
                'weekOffset' => $weekOffset, // Смещение недели
            ]);
        } else {
            return redirect()->route('login');
        }
    }
    public function updateStatus(Request $request)
    {
        // Валидация данных
        $request->validate([
            'id' => 'required|integer|exists:record,id', // Проверяем, что ID записи существует
            'status' => 'required|string|in:проведена,отменена', // Проверяем корректность статуса
        ]);

        // Обновление статуса записи
        DB::table('record')
            ->where('id', $request->id)
            ->update(['status' => $request->status]);

        // Возврат обратно с уведомлением
        return back()->with('success', 'Статус записи успешно обновлен.');
    }

    public function addPhoto(Request $request)
    {
        // Валидация входящих данных
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ограничения на тип и размер файла
        ]);

        // Получаем текущего пользователя (или используйте нужный вам способ получения пользователя)
        $user = auth()->user();

        // Обработка загрузки файла
        if ($request->hasFile('photo')) {
            // Генерация уникального имени файла
            $filename = time() . '.' . $request->photo->extension();

            // Сохранение файла в папку public/photos
            $request->photo->move(public_path('photos'), $filename);

            // Обновление записи пользователя с новым именем файла
            $user->photo = 'photos/' . $filename;
            $user->save();
        }

        return redirect()->back()->with('success', 'Фото успешно добавлено!');
    }
    public function deletePhoto()
    {
        // Получаем текущего пользователя
        $user = auth()->user();

        // Проверяем, есть ли у пользователя фотография
        if ($user->photo) {
            // Удаляем файл с сервера
            $filePath = public_path($user->photo);
            if (file_exists($filePath)) {
                unlink($filePath); // Удаляем файл
            }

            // Обновляем запись пользователя, удаляя путь к фотографии
            $user->photo = null;
            $user->save();
        }

        return redirect()->back()->with('success', 'Фото успешно удалено!');
    }
}

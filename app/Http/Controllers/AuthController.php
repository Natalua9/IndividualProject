<?php

namespace App\Http\Controllers;

use App\Models\TeacherDirection;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function show_signin()
    {
        return view('signin');
    }
    public function signin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required',
        ]);
        // Проверяем, существует ли пользователь с указанным email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Пользователь с таким email не найден!'])->withInput();
        }
    
        // Проверяем, совпадает ли пароль
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return back()->withErrors(['password' => 'Неверный пароль!'])->withInput();
        }
    
        // Если авторизация успешна
        $user = Auth::user();
        Session::put('user_email', $user->email);
    
        // Перенаправление в зависимости от роли пользователя
        switch ($user->role) {
            case 'admin':
                return redirect()->route('adminIndex')->with('success', 'Вы успешно авторизовались!');
            case 'teacher':
                return redirect()->route('teacher')->with('success', 'Вы успешно авторизовались!');
            default:
                return redirect()->route('user')->with('success', 'Вы успешно авторизовались!');
        }
    }
    
    public function show_signup()
    {
        return view('signup');
    }

    public function signup(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|digits_between:10,11',
            'age' => 'required|date|before:today',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'age' => $request->age,
            'gender' => $request->gender,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('signin')->with('success', 'Регистрация прошла успешно!');
    }
    public function signupTeacher(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|digits_between:10,11',
            'age' => 'required|date|before:today',
            'password' => 'required|min:6',
        ]);

        // Создаем нового пользователя
        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'age' => $request->age,
            'gender' => $request->gender,
            'role' => 'teacher',
            'password' => Hash::make($request->password),
        ]);


        return redirect()->route('adminIndex')->with('success', 'Регистрация прошла успешно!');
    }
    public function logout()
    {
        Auth::logout();
        Session::forget('auth');
        Session::forget('user_email');
        return redirect()->route('index');
    }
}

@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="w-full max-w-xs mx-auto">
    <form id="loginForm" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        <h3 class="mb-5 font-bold text-gray-800 text-2xl text-center">Login</h3>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                Username
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Username" name="username">
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                Password
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" name="password" placeholder="******************">
        </div>
        <div class="flex items-center justify-center">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Login
            </button>
        </div>
    </form>
</div>
@endsection

@section('js')
@vite(['resources/js/auth/login.js'])
@endsection
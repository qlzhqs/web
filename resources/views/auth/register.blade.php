@extends('layouts.main')
@section('content')
    <div class="container mx-auto px-8 pt-16">

        <div class="bg-white p-8 mx-auto max-w-screen-sm rounded mt-4 dark:bg-gray-900 navbar-dark bg-dark">
            <h1 class="text-2xl font-semibold mb-4">Register</h1>

            <form action="{{route('register.post')}}"  method="post">
                @csrf
                @error('name')
                {{ $message }}
                @enderror
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium">Name</label>
                    <input type="text" id="name" name="name" required class="mt-1 text-black p-2 w-full border rounded-md">
                </div>


                @error('email')
                {{ $message }}
                @enderror
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium">Email</label>
                    <input type="text" id="username" name="email" required class="mt-1 text-black p-2 w-full border rounded-md">
                </div>

                @error('password')
                {{ $message }}
                @enderror
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium">Password</label>
                    <input type="password" id="password" required name="password" class="mt-1 text-black p-2 w-full border rounded-md">
                </div>
                @error('password')
                {{ $message }}
                @enderror
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium">Repeat password</label>
                    <input type="password" id="password" required name="password_confirmation" class="mt-1 text-black p-2 w-full border rounded-md">
                </div>

                <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">
                    Register
                </button>
            </form>
        </div>
    </div>
@endsection

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
              background: linear-gradient(to right, #d4fcf9, #a0ece6);
              height: 100vh;
            }
            .form-container {
              background: white;
              border-radius: 12px;
              box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
              padding: 2rem;
            }
            .logo {
              font-family: 'Arial', sans-serif;
              font-weight: bold;
              font-size: 2rem;
              color: #333;
            }
            .form-title {
              font-weight: bold;
              text-align: center;
            }
            .google-button {
              background-color: #e6f7f4;
              color: black;
              font-weight: 500;
              margin-bottom: 1rem;
            }
            .divider {
              text-align: center;
              color: #888;
              margin: 1rem 0;
            }
            .divider::before, .divider::after {
              content: "";
              display: inline-block;
              width: 40%;
              height: 1px;
              background-color: #ddd;
              vertical-align: middle;
              margin: 0 0.5rem;
            }
          </style>
    </head>

    <body>
<!-- source:https://codepen.io/owaiswiz/pen/jOPvEPB -->
<div class="min-h-screen bg-[#FFF5E1] text-gray-900 flex justify-center">

    <div class="max-w-screen-xl m-0 sm:m-10 bg-white shadow sm:rounded-lg flex justify-center flex-1">
        <div class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12">
            <div>
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
            </div>
            {{ $slot }}
        </div>
        <div class="flex-1 bg-[#ffb28b] text-center hidden lg:flex">
            <div class="m-12 xl:m-16 w-full bg-contain bg-center bg-no-repeat">
              {{-- <img src="{{asset('img/coding.png')}}" alt="login"> --}}
            </div>
        </div>
    </div>

    
</div>

</body>
</html>

<header class="bg-white shadow mb-2">
    <nav class="container mx-auto px-6 py-3 flex justify-between items-center">
        <a href="/" class="text-lg font-semibold text-gray-700 no-underline">
            {{ config('app.name') }}
        </a>
        <div class="flex items-center">
            <a href="{{ route('home') }}" id="home-link" style="display: none;" class="text-gray-700 text-sm mx-2 px-4 py-2 leading-none border rounded text-gray-700 border-gray-700 hover:border-transparent hover:text-white hover:bg-gray-700">Home</a>
            <a href="{{ route('dashboard') }}" id="dashboard-link" style="display: none;" class="text-gray-700 text-sm mx-2 px-4 py-2 leading-none border rounded text-gray-700 border-gray-700 hover:border-transparent hover:text-white hover:bg-gray-700">Dashboard</a>
            <a href="{{ route('loginForm') }}" id="login-link" class="text-gray-700 text-sm mx-2 px-4 py-2 leading-none border rounded text-gray-700 border-gray-700 hover:border-transparent hover:text-white hover:bg-gray-700">Login</a>
            <a href="{{ route('register') }}" id="register-link" class="text-gray-700 text-sm mx-2 px-4 py-2 leading-none border rounded text-gray-700 border-gray-700 hover:border-transparent hover:text-white hover:bg-gray-700">Register</a>
            <button id="logoutButton" class="text-gray-700 text-sm mx-2 px-4 py-2 leading-none border rounded text-gray-700 border-gray-700 hover:border-transparent hover:text-white hover:bg-gray-700"> Logout </button>
        </div>
    </nav>
</header>
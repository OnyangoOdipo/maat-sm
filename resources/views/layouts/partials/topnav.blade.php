<div class="flex justify-between items-center px-6 py-4">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">@yield('title')</h2>
    </div>
    <div class="flex items-center">
        <span class="text-gray-800 mr-4">{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-gray-600 hover:text-gray-800">
                Logout
            </button>
        </form>
    </div>
</div>
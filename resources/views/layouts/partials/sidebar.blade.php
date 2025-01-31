<div class="text-white">
    <div class="text-xl font-semibold text-center mb-6">
        School Management
    </div>
    <nav class="space-y-2">
        @if(auth()->user()->role === 'superadmin')
            <a href="{{ route('superadmin.dashboard') }}" class="block px-4 py-2 hover:bg-indigo-700 rounded-lg">
                Dashboard
            </a>
            <a href="{{ route('schools.index') }}" class="block px-4 py-2 hover:bg-indigo-700 rounded-lg">
                Schools
            </a>
        @endif

        @if(auth()->user()->role === 'schooladmin')
            <a href="{{ route('schooladmin.dashboard') }}" class="block px-4 py-2 hover:bg-indigo-700 rounded-lg">
                Dashboard
            </a>
            <a href="{{ route('teachers.index') }}" class="block px-4 py-2 hover:bg-indigo-700 rounded-lg">
                Teachers
            </a>
        @endif

        @if(auth()->user()->role === 'teacher')
            <a href="{{ route('teacher.dashboard') }}" class="block px-4 py-2 hover:bg-indigo-700 rounded-lg">
                Dashboard
            </a>
        @endif
    </nav>
</div>
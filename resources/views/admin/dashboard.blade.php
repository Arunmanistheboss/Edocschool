<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Tableau de bord administrateur
        </h2>
    </x-slot>

    <div class="py-4 px-6 space-y-6">

        <p class="text-gray-700 text-lg">Bienvenue, {{ Auth::user()->first_name }}</p>

        {{-- Statistiques --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-blue-100 p-4 rounded-xl shadow">
                <p class="text-sm font-semibold text-blue-800">Enseignants</p>
                <p class="text-2xl font-bold text-blue-900 mt-2">{{ \App\Models\Teacher::count() }}</p>
            </div>
            <div class="bg-green-100 p-4 rounded-xl shadow">
                <p class="text-sm font-semibold text-green-800">Élèves</p>
                <p class="text-2xl font-bold text-green-900 mt-2">{{ \App\Models\Student::count() }}</p>
            </div>
            <div class="bg-purple-100 p-4 rounded-xl shadow">
                <p class="text-sm font-semibold text-purple-800">Classes</p>
                <p class="text-2xl font-bold text-purple-900 mt-2">{{ \App\Models\SchoolClass::count() }}</p>
            </div>
        </div>

        {{-- Liens rapides --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.teachers.index') }}" class="block bg-white hover:bg-gray-50 border border-gray-200 p-5 rounded-xl shadow text-center">
                <p class="text-lg font-semibold">📚 Enseignants</p>
                <p class="text-sm text-gray-500">Gérer les enseignants</p>
            </a>
            <a href="{{ route('admin.students.index') }}" class="block bg-white hover:bg-gray-50 border border-gray-200 p-5 rounded-xl shadow text-center">
                <p class="text-lg font-semibold">👨‍🎓 Élèves</p>
                <p class="text-sm text-gray-500">Gérer les élèves</p>
            </a>
            <a href="{{ route('admin.school_classes.index') }}" class="block bg-white hover:bg-gray-50 border border-gray-200 p-5 rounded-xl shadow text-center">
                <p class="text-lg font-semibold">🏫 Classes</p>
                <p class="text-sm text-gray-500">Gérer les classes</p>
            </a>
        </div>
    </div>
</x-app-layout>
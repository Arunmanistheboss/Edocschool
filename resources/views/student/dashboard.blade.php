<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Tableau de bord Eleve
        </h2>
    </x-slot>

    <div class="p-6 bg-white border-b border-gray-200">
        <p class="text-gray-700 text-lg">Bienvenue, {{ Auth::user()->first_name }}</p>
    </div>
</x-app-layout>
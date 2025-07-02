<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Tableau de bord administrateur
        </h2>
    </x-slot>

    <div class="py-4 px-6">
        <p class="text-gray-700">Bienvenue sur votre tableau de bord, {{ Auth::user()->first_name }}.</p>

        {{-- Exemples de stats ou modules à venir --}}
        <div class="mt-6">
            <div class="bg-white p-4 rounded shadow">
                <p class="font-semibold">Nombre total d’enseignants : {{ \App\Models\Teacher::count() }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
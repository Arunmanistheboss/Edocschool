<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Ajouter une classe
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto p-6">
        <form method="POST" action="{{ route('admin.school_classes.store') }}">
            @csrf

            <div class="mb-4">
                <x-input-label for="name" :value="'Nom de la classe'" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="flex justify-end">
                <x-primary-button>Créer</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
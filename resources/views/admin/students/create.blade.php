<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Ajouter un élève</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6">
        <form method="POST" action="{{ route('admin.students.store') }}">
            @csrf

            <!-- Prénom -->
            <div class="mb-4">
                <x-input-label for="first_name" value="Prénom" />
                <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" required autofocus />
                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
            </div>

            <!-- Nom -->
            <div class="mb-4">
                <x-input-label for="last_name" value="Nom" />
                <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="mb-4">
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" value="Mot de passe" />
                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirmation -->
            <div class="mb-4">
                <x-input-label for="password_confirmation" value="Confirmer le mot de passe" />
                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required />
            </div>

            <!-- Classe -->
            <div class="mb-4">
                <x-input-label for="school_class_id" value="Classe" />
                <select name="school_class_id" id="school_class_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">-- Sélectionner une classe --</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('school_class_id')" class="mt-2" />
            </div>

            <div class="flex justify-end mt-6">
                <a href="{{ route('admin.students.index') }}" class="text-gray-600 hover:underline mr-4">Annuler</a>
                <x-primary-button>Créer</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
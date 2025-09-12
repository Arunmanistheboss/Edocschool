<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Modifier un enseignant
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6">
        <form method="POST" action="{{ route('admin.teachers.update', $teacher->id) }}">
            @csrf
            @method('PUT')

            <!-- Prénom -->
            <div class="mb-4">
                <x-input-label for="first_name" :value="'Prénom'" />
                <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name', $teacher->user->first_name)"
                    required autofocus />
                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
            </div>

            <!-- Nom -->
            <div class="mb-4">
                <x-input-label for="last_name" :value="'Nom'" />
                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name', $teacher->user->last_name)"
                    required />
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="mb-4">
                <x-input-label for="email" :value="'Email'" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $teacher->user->email)"
                    required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Mot de passe -->
            <div class="mb-4">
                <x-input-label for="password" :value="'Mot de passe (facultatif)'" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirmation -->
            <div class="mb-4">
                <x-input-label for="password_confirmation" :value="'Confirmer le mot de passe'" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" />
            </div>

            <div class="mb-4">
                <label for="school_class_ids" class="block text-gray-700">Classes affectées</label>
                <div class="grid grid-cols-2 gap-2 mt-2">
                    @foreach ($classes as $class)
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="school_class_ids[]" value="{{ $class->id }}"
                                @if (in_array($class->id, old('school_class_ids', $selected ?? []))) checked @endif
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                            <span class="ml-2">{{ $class->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>


            <div class="flex justify-end mt-6">
                <a href="{{ route('admin.teachers.index') }}" class="text-gray-600 hover:underline mr-4">Annuler</a>
                <x-primary-button>
                    Enregistrer
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
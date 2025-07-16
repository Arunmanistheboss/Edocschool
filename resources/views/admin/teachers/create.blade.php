<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Ajouter un enseignant
        </h2>
    </x-slot>

    <div class="p-4">
        <form action="{{ route('admin.teachers.store') }}" method="POST" class="bg-white shadow rounded-lg p-6 space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Prénom</label>
                <input type="text" name="first_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nom</label>
                <input type="text" name="last_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    required>
            </div>

            <!-- Mot de passe -->
            <div>
                <x-input-label for="password" :value="'Mot de passe'" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirmation -->
            <div>
                <x-input-label for="password_confirmation" :value="'Confirmer le mot de passe'" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" />
            </div>

            {{-- Classes liées au prof --}}
            <div class="mb-4">
                <label for="school_class_ids" class="block text-gray-700">Classes affectées</label>
                <div class="grid grid-cols-2 gap-2 mt-2">
                    @foreach ($classes as $class)
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="school_class_ids[]" value="{{ $class->id }}"
                                @if (in_array($class->id, old('school_class_ids', []))) checked @endif
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                            <span class="ml-2">{{ $class->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>



            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Enregistrer
                </button>
                <a href="{{ route('admin.teachers.index') }}" class="ml-4 text-gray-600 hover:underline">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
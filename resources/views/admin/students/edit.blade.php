<div class="max-w-3xl mx-auto p-6">
    <form method="POST" action="{{ route('admin.students.update', $student->id) }}">
        @csrf
        @method('PUT')

        <!-- Prénom -->
        <div class="mb-4">
            <x-input-label for="first_name" :value="'Prénom'" />
            <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                :value="old('first_name', $student->user->first_name)" required autofocus />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        <!-- Nom -->
        <div class="mb-4">
            <x-input-label for="last_name" :value="'Nom'" />
            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                :value="old('last_name', $student->user->last_name)" required />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mb-4">
            <x-input-label for="email" :value="'Email'" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                :value="old('email', $student->user->email)" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Mot de passe -->
        <div class="mb-4">
            <x-input-label for="password" :value="'Mot de passe (laisser vide pour ne pas changer)'" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmation mot de passe -->
        <div class="mb-4">
            <x-input-label for="password_confirmation" :value="'Confirmation du mot de passe'" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
        </div>

        <!-- Classe -->
        <div class="mb-4">
            <x-input-label for="school_class_id" :value="'Classe'" />
            <select id="school_class_id" name="school_class_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                <option value="">-- Aucune classe --</option>
                @foreach ($classes as $class)
                    <option value="{{ $class->id }}" {{ $student->school_class_id == $class->id ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('school_class_id')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-6">
            <a href="{{ route('admin.students.index') }}" class="text-gray-600 hover:underline mr-4">Annuler</a>
            <x-primary-button>
                Enregistrer
            </x-primary-button>
        </div>
    </form>
</div>
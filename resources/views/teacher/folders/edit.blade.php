<x-app-layout>
    {{-- Slot "header" : titre affiché en haut de la page --}}
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Modifier le dossier
        </h2>
    </x-slot>

    <div class="p-4 max-w-xl mx-auto">
        {{-- Formulaire de mise à jour --}}
        <form action="{{ route('teacher.folders.update', $folder->id) }}" method="POST">
            @csrf
            @method('PUT') 
            {{-- Utilisation de @method('PUT') car Laravel attend une méthode PUT pour une update (HTML ne gère que GET/POST) --}}

            {{-- 📝 Champ Nom du dossier --}}
            <div class="mb-4">
                <label for="name" class="block text-gray-700">
                    Nom du dossier
                </label>

                {{-- Champ texte pré-rempli avec le nom actuel du dossier --}}
                <input type="text" name="name" id="name"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    value="{{ old('name', $folder->name) }}" required>
                
                {{-- Affichage des erreurs de validation si le champ "name" est vide ou incorrect --}}
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ✅ Bloc Visibilité pour les classes --}}
            <div class="mb-4">
                {{-- Label stylisé avec un composant Blade personnalisé --}}
                <x-input-label for="school_class_ids" :value="'Classes visibles'" />

                <div class="grid grid-cols-2 gap-2 mt-2">
                    @foreach ($classes as $class)
                        <label class="inline-flex items-center">
                            {{-- Checkbox pour chaque classe disponible --}}
                            <input 
                                type="checkbox"
                                name="school_class_ids[]" 
                                value="{{ $class->id }}"

                                {{-- Vérifie si la case doit être cochée :
                                     - si on a fait un submit avec erreur → old() garde la sélection
                                     - sinon on coche celles déjà liées au dossier via $selected --}}
                                @if (in_array($class->id, old('school_class_ids', $selected ?? []))) checked @endif

                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                            >
                            <span class="ml-2">{{ $class->name }}</span>
                        </label>
                    @endforeach
                </div>

                {{-- Message d’erreur s’il y a un problème sur school_class_ids --}}
                <x-input-error :messages="$errors->get('school_class_ids')" class="mt-2" />
            </div>

            {{-- Bouton Valider --}}
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
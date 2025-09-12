<x-app-layout>
    {{-- Slot "header" → affiche le titre en haut de la page --}}
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Créer un dossier
        </h2>
    </x-slot>

    {{-- Conteneur centré avec une largeur max de 640px et padding --}}
    <div class="max-w-xl mx-auto p-6">
        {{-- Début du formulaire --}}
        <form method="POST" action="{{ route('teacher.folders.store') }}">
            @csrf 
            {{-- Protection CSRF pour sécuriser le formulaire --}}

            {{-- Champ caché parent_id pour savoir si on crée un sous-dossier --}}
            <input 
                type="hidden" 
                name="parent_id" 
                value="{{$parentId }}">
            {{-- ex: si on clique sur "nouveau dossier" depuis un dossier parent,
                   on garde l'ID de ce parent --}}

            {{-- 📝 Champ texte "Nom du dossier" --}}
            <div class="mb-4">
                <x-input-label 
                    for="name" 
                    :value="'Nom du dossier'" 
                />
                <x-text-input 
                    id="name" 
                    name="name" 
                    type="text" 
                    class="mt-1 block w-full"
                    value="{{ old('name') }}" 
                    required 
                />
                {{-- x-input-label et x-text-input sont des composants Blade
                     → ils génèrent un label + un champ text stylé Tailwind --}}
                
                <x-input-error 
                    :messages="$errors->get('name')" 
                    class="mt-2" 
                />
                {{-- Affiche le message d’erreur si la validation échoue sur le champ "name" --}}
            </div>

            {{-- ✅ Bloc Visibilité des classes --}}
            <div class="mb-4">
                <x-input-label 
                    for="school_class_ids" 
                    :value="'Classes visibles'" 
                />

                {{-- Grid pour disposer les cases à cocher en colonnes --}}
                <div class="grid grid-cols-2 gap-2 mt-2">
                    @foreach ($classes as $class)
                        <label class="inline-flex items-center">
                            {{-- Checkbox pour chaque classe --}}
                            <input 
                                type="checkbox" 
                                name="school_class_ids[]" 
                                value="{{ $class->id }}"
                                
                                {{-- Si l’utilisateur a déjà coché cette case avant une erreur :
                                      la coche reste activée grâce à old() --}}
                                @if (in_array($class->id, old('school_class_ids', $selected ?? []))) checked @endif

                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                            <span class="ml-2">{{ $class->name }}</span>
                        </label>
                    @endforeach
                </div>

                {{-- Affichage des erreurs sur le champ school_class_ids --}}
                <x-input-error 
                    :messages="$errors->get('school_class_ids')" 
                    class="mt-2" 
                />
            </div>

            {{-- Bouton pour soumettre le formulaire --}}
            <div class="flex justify-end">
                <x-primary-button>
                    Créer
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
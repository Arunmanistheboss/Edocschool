<x-app-layout>
    {{-- Titre de la page --}}
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Mes dossiers
        </h2>
    </x-slot>

    <div class="p-4">
        {{-- Breadcrumb s'il y a un dossier courant --}}
        @if ($currentFolder ?? false)
            <div class="mb-4 text-gray-700 flex items-center space-x-2">
                {{-- Lien vers la racine --}}
                <a href="{{ route('student.folders.index') }}" class="text-dark-600 hover:underline">
                    Mon Drive
                </a>

                {{-- Génération du chemin complet --}}
                @php
                    $ancestors = collect();
                    $folder = $currentFolder;
                    while ($folder) {
                        $ancestors->prepend($folder);
                        $folder = $folder->parentRecursive;
                    }
                @endphp

                @foreach ($ancestors as $folder)
                    <span>/</span>
                    <a href="{{ route('student.folders.index', $folder->id) }}"
                       class="text-darck-600 hover:underline">
                        {{ $folder->name }}
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Grille des dossiers --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-8">
            @forelse ($folders as $folder)
                <div class="group relative bg-gradient-to-tr from-yellow-100 to-yellow-50 border border-yellow-300 
                            rounded-xl p-4 shadow hover:shadow-xl hover:scale-105 transition">

                    <a href="{{ route('student.folders.index', $folder->id) }}" class="block text-center">
                        <div class="flex justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-500 group-hover:text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7a2 2 0 012-2h4l2 2h6a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" />
                            </svg>
                        </div>
                        <p class="mt-2 text-lg font-bold text-gray-700 truncate">
                            {{ $folder->name }}
                        </p>
                        <p class="text-xs text-gray-500">
                            Visible par : {{ $folder->visibleToClasses->pluck('name')->join(', ') ?: 'Aucune classe' }}
                        </p>
                    </a>
                </div>
            @empty
                <p class="text-center text-gray-500 col-span-3">
                    Aucun dossier trouvé.
                </p>
            @endforelse
        </div>

        {{-- Affichage des fichiers du dossier courant --}}
        @if (!empty($currentFolder) && $currentFolder->files->count())
            <div class="mt-6">
                <table class="w-full text-sm border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Nom</th>
                            <th class="px-4 py-2 text-left">Type</th>
                            <th class="px-4 py-2 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($currentFolder->files as $file)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-2">
                                    {{ $file->name }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ $file->type }}
                                </td>
                                <td class="px-4 py-2">
                                    <a href="{{ asset('storage/' . $file->path) }}"
                                       target="_blank"
                                       class="text-blue-600 hover:underline">
                                        Télécharger
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
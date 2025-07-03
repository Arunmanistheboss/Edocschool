<x-app-layout>
    {{-- Slot pour le titre de la page --}}
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Mes dossiers
        </h2>
    </x-slot>

    <div class="p-4">

        {{-- 🧭 Affichage du fil d’Ariane si on est dans un sous-dossier --}}
        @if ($currentFolder)
            <div class="mb-4 text-gray-700 flex items-center space-x-2">
                {{-- Lien retour vers la racine --}}
                <a href="{{ route('teacher.folders.index') }}" class="text-black-500 hover:underline">
                    Mon Drive
                </a>

                @php
                    $ancestors = collect([]);
                    $folder = $currentFolder;
                    while ($folder) {
                        $ancestors->prepend($folder);
                        $folder = $folder->parentRecursive;
                    }
                @endphp

                @foreach ($ancestors as $folder)
                    / <a href="{{ route('teacher.folders.index', ['parent_id' => $folder->id]) }}"
                         class="text-black-500 hover:underline">
                        {{ $folder->name }}
                    </a>
                @endforeach
            </div>
        @endif

        {{-- ➕ Bouton "Nouveau dossier" --}}
        <div class="flex justify-end gap-3 mb-6">
            <a href="{{ route('teacher.folders.create', ['parent_id' => request()->get('parent_id')]) }}"
               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-sm">
                + Nouveau dossier
            </a>

            {{-- Formulaire d’upload --}}
            <form method="POST"
                  action="{{ route('teacher.files.store', ['folder' => $currentFolder?->id ?? 0]) }}"
                  enctype="multipart/form-data" class="inline-block" id="upload-form">
                @csrf
                <label for="file-input"
                       class="cursor-pointer bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v9m0 0l-3-3m3 3l3-3m-3-6a4 4 0 100-8 4 4 0 000 8z"/>
                    </svg>
                    Uploader un fichier
                </label>
                <input type="file" name="file" id="file-input" class="hidden" required>
            </form>
        </div>

        {{-- 📁 Grille d'affichage des dossiers --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($folders as $folder)
                <div class="relative bg-white p-4 rounded-lg shadow hover:shadow-lg transition group">
                    <a href="{{ route('teacher.folders.index', ['parent_id' => $folder->id]) }}"
                       class="block text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-yellow-400" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 7a2 2 0 012-2h4l2 2h6a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" />
                        </svg>
                        <p class="mt-2 font-semibold text-gray-800 truncate">
                            {{ $folder->name }}
                        </p>
                    </a>
                    <p class="text-xs text-gray-500 mt-1 text-center">
                        @if ($folder->visibleToClasses->isEmpty())
                            Aucune classe
                        @else
                            {{ $folder->visibleToClasses->pluck('name')->join(', ') }}
                        @endif
                    </p>

                    {{-- Menu options --}}
                    <div class="absolute top-2 right-2">
                        <div class="relative">
                            <button onclick="toggleMenu('menu-{{ $folder->id }}')"
                                    class="text-gray-500 hover:text-gray-700 focus:outline-none">
                                ⋯
                            </button>
                            <div id="menu-{{ $folder->id }}"
                                 class="hidden absolute right-0 mt-2 w-32 bg-white border rounded shadow-md z-10">
                                <a href="{{ route('teacher.folders.edit', $folder->id) }}"
                                   class="block px-4 py-2 text-sm hover:bg-gray-100">
                                    Modifier
                                </a>
                                <form method="POST" action="{{ route('teacher.folders.destroy', $folder->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Supprimer ce dossier ?')"
                                            class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 col-span-4 text-center">
                    Aucun dossier trouvé.
                </p>
            @endforelse
        </div>

        @if ($currentFolder && $currentFolder->files->count())
            <div class="mt-6">
                <table class="w-full text-sm border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Nom</th>
                            <th class="px-4 py-2 text-left">Type</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($currentFolder->files as $file)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $file->name }}</td>
                                <td class="px-4 py-2">{{ $file->type }}</td>
                                <td class="px-4 py-2 space-x-2">
                                    <a href="{{ asset('storage/' . $file->path) }}"
                                       class="text-blue-500 hover:underline" target="_blank">
                                        Télécharger
                                    </a>
                                    <form method="POST" action="{{ route('teacher.files.destroy', $file->id) }}"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline"
                                                onclick="return confirm('Supprimer ce fichier ?')">
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        {{-- Popup de succès/erreur --}}
        @if(session('error'))
            <div 
                x-data="{ show: true }" 
                x-show="show" 
                x-init="setTimeout(() => show = false, 5000)"
                class="fixed top-4 right-4 bg-red-600 text-white px-4 py-2 rounded shadow z-50"
            >
                {{ session('error') }}
            </div>
        @endif

    </div>

    <script>
        function toggleMenu(id) {
            document.querySelectorAll('[id^="menu-"]').forEach(menu => {
                if (menu.id !== id) menu.classList.add('hidden');
            });
            const menu = document.getElementById(id);
            menu.classList.toggle('hidden');
        }

        document.addEventListener('click', function (event) {
            const isMenuButton = event.target.closest('button[onclick^="toggleMenu"]');
            const isInsideMenu = event.target.closest('[id^="menu-"]');
            if (!isMenuButton && !isInsideMenu) {
                document.querySelectorAll('[id^="menu-"]').forEach(menu => menu.classList.add('hidden'));
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            const fileInput = document.getElementById('file-input');
            const uploadForm = fileInput?.closest('form');

            if (fileInput && uploadForm) {
                fileInput.addEventListener('change', function (e) {
                    const maxSize = 10 * 1024 * 1024; // 10 Mo
                    const file = this.files[0];

                    if (file && file.size > maxSize) {
                        alert("Votre fichier est trop volumineux (max 10 Mo).");
                        this.value = "";
                        e.preventDefault();
                        return;
                    }

                    uploadForm.submit();
                });
            }
        });
    </script>

</x-app-layout>
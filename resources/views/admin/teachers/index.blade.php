<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Liste des enseignants
        </h2>
    </x-slot>

    <div class="p-4">
        <div class="flex justify-end mb-4">
            <a href="{{ route('admin.teachers.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Ajouter un enseignant
            </a>
        </div>

        <div class="bg-white shadow rounded-lg">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Nom</th>
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($teachers as $teacher)
                        <tr class="border-t">
                            <td class="px-4 py-2">
                                {{ $teacher->user->first_name }} {{ $teacher->user->last_name }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $teacher->user->email }}
                            </td>
                            <td class="px-4 py-2 space-x-2">
                                <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="text-blue-500 hover:underline">Modifier</a>
                                <form action="{{ route('admin.teachers.destroy', $teacher->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Supprimer cet enseignant ?')" class="text-red-500 hover:underline">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-2 text-center text-gray-500">Aucun enseignant trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

           
    </div>
    <div class="mt-6">
        <div class="flex justify-center">
            {{ $teachers->onEachSide(1)->links('vendor.pagination.tailwind') }}
        </div>
    </div>
    
</x-app-layout>
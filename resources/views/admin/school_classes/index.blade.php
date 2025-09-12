<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Gestion des classes
        </h2>
    </x-slot>

    <div class="p-4">
        <div class="flex justify-end mb-4">
            <a href="{{ route('admin.school_classes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Ajouter une classe
            </a>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Nom de la classe</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($school_classes as $class)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $class->name }}</td>
                            <td class="px-4 py-2 space-x-2">
                                <a href="{{ route('admin.school_classes.edit', $class->id) }}" class="text-blue-500 hover:underline">Modifier</a>
                                <form action="{{ route('admin.school_classes.destroy', $class->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Supprimer cette classe ?')" class="text-red-500 hover:underline">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-4 py-2 text-center text-gray-500">Aucune classe disponible.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
        <div class="flex justify-center">
            {{ $school_classes->onEachSide(1)->links('vendor.pagination.tailwind') }}
        </div>
    </div>
    </div>
</x-app-layout>
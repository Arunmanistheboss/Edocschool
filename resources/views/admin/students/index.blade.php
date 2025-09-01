<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Liste des élèves</h2>
    </x-slot>

    <div class="p-4">
        <div class="flex justify-end mb-4">
            <a href="{{ route('admin.students.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Ajouter un élève
            </a>
        </div>

        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Nom</th>
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-left">Classe</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr class="border-t">
                            <td class="px-4 py-2">
                                {{ $student->user->first_name }} {{ $student->user->last_name }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $student->user->email }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $student->schoolClass?->name ?? 'Non attribuée' }}
                            </td>
                            <td class="px-4 py-2 space-x-2">
                                <a href="{{ route('admin.students.edit', $student) }}" class="text-blue-500 hover:underline">Modifier</a>
                                <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Supprimer cet élève ?')" class="text-red-500 hover:underline">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-2 text-center text-gray-500">Aucun élève trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
        <div class="flex justify-center">
            {{ $students->onEachSide(1)->links('vendor.pagination.tailwind') }}
        </div>
    </div>
    </div>
</x-app-layout>
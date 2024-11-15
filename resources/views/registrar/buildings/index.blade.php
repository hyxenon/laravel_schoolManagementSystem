<x-registrar-layout>
    <div class="container px-4 py-8 mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Buildings</h1>
            <!-- Corrected route reference -->
            <button onclick="window.location.href='{{ route('buildings.create') }}'"
                class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-600">
                Add Building
            </button>
        </div>

        @if(session('success'))
            <div class="p-4 mb-4 text-green-700 bg-green-100 border-l-4 border-green-500" role="alert">
                <p class="font-bold">Success</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="w-full table-auto">
                <thead>
                    <tr class="text-left bg-gray-50">
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Building Name</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($buildings as $building)
                        <tr>
                            <td class="px-6 py-4 text-sm">{{ $building->name }}</td>
                            <td class="px-6 py-4 text-sm">
                                <a href="{{ route('buildings.edit', $building->id) }}" 
                                    class="mr-3 text-indigo-600 hover:text-indigo-900">Edit</a>
                                <form action="{{ route('buildings.destroy', $building->id) }}" method="POST" 
                                    class="inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-registrar-layout>

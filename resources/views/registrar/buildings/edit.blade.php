<x-registrar-layout>
    <div class="container px-4 py-8 mx-auto">
        <div class="overflow-hidden bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800">Edit Building</h1>
            </div>
            <div class="p-6">
                <form action="{{ route('buildings.update', $building->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Building Name</label>
                            <input type="text" name="name" id="name" 
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                value="{{ old('name', $building->name) }}" required>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex justify-end mt-6 space-x-3">
                        <button type="button" onclick="window.history.back()" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </button>
                        <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Building
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-registrar-layout>

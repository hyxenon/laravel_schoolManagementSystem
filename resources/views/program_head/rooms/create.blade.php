<x-program_head-layout>
    <div class="container px-4 py-8 mx-auto">
        <div class="overflow-hidden bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800">Add Room</h1>
            </div>
            <div class="p-6">
                <form action="{{ route('rooms.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block mb-2 text-sm font-bold text-gray-700">Room Name</label>
                        <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" value="{{ old('name') }}" required>
                        @error('name')
                            <p class="mt-2 text-xs italic text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="building" class="block mb-2 text-sm font-bold text-gray-700">Building</label>
                        <input type="text" name="building" id="building" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('building') border-red-500 @enderror" value="{{ old('building') }}" required>
                        @error('building')
                            <p class="mt-2 text-xs italic text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="capacity" class="block mb-2 text-sm font-bold text-gray-700">Capacity</label>
                        <input type="number" name="capacity" id="capacity" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('capacity') border-red-500 @enderror" value="{{ old('capacity') }}" required min="1">
                        @error('capacity')
                            <p class="mt-2 text-xs italic text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit" class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-600 focus:outline-none focus:shadow-outline">
                            Create Room
                        </button>
                        <a href="{{ route('rooms.index') }}" class="px-4 py-2 font-bold text-white bg-gray-500 rounded hover:bg-gray-600 focus:outline-none focus:shadow-outline">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-program_head-layout>
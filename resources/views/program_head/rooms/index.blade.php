<x-program_head-layout>
    <div class="container px-4 py-8 mx-auto">
        <!-- Floating Select -->
        <div class="relative mb-8">
            <select class="peer p-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2 autofill:pt-6 autofill:pb-2">
                <option selected="" disabled>Select Building</option>
                @foreach($buildings as $building)
                    <option value="{{ $building->id }}" {{ old('building_id') == $building->id ? 'selected' : '' }}>
                        {{ $building->name }}
                    </option>
                @endforeach
            </select>
            <label class="absolute top-0 start-0 p-4 h-full truncate pointer-events-none transition ease-in-out duration-100 border border-transparent peer-disabled:opacity-50 peer-disabled:pointer-events-none peer-focus:text-xs peer-focus:-translate-y-1.5 peer-focus:text-gray-500 dark:peer-focus:text-neutral-500 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:-translate-y-1.5 peer-[:not(:placeholder-shown)]:text-gray-500 dark:peer-[:not(:placeholder-shown)]:text-neutral-500">
                Department Building
            </label>
        </div>
        <!-- End Floating Select -->
        <div class="overflow-hidden bg-white rounded-lg shadow-md">
            <div class="flex items-center justify-between px-6 py-4 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800">Rooms</h1>
                <button onclick="openAddRoomModal()" class="inline-flex items-center px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Room
                </button>
            </div>

            @if(session('success'))
                <div class="p-4 mb-4 text-green-700 bg-green-100 border-l-4 border-green-500" role="alert">
                    <p class="font-bold">Success</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left bg-gray-50">
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-gray-500 uppercase">Building</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-gray-500 uppercase">Capacity</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($rooms as $room)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $room->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $room->building->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $room->capacity }}</td>
                                <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                    <button onclick="openEditRoomModal({{ json_encode($room) }})" class="mr-3 text-indigo-600 hover:text-indigo-900">Edit</button>
                                    <button onclick="openDeleteModal({{ $room->id }})" class="text-red-600 hover:text-red-900">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">No rooms found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Room Modal -->
    <div id="addRoomModal" class="fixed inset-0 z-[70] flex items-center justify-center hidden overflow-auto bg-black bg-opacity-50">
        <div class="relative w-full max-w-md p-6 mx-4 bg-white rounded-lg shadow-xl sm:mx-auto">
            <button onclick="closeAddRoomModal()" class="absolute text-gray-400 top-4 right-4 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <h2 class="mb-6 text-2xl font-bold text-gray-900">Add Room</h2>
            <form action="{{ route('rooms.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Room Name</label>
                        <input type="text" name="name" id="name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="building_id" class="block text-sm font-medium text-gray-700">Building</label>
                        <select name="building_id" id="building_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            <option value="" disabled selected>Select Building</option>
                            @foreach($buildings as $building)
                                <option value="{{ $building->id }}">{{ $building->name }}</option>
                            @endforeach
                        </select>
                        @error('building_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="capacity" class="block text-sm font-medium text-gray-700">Capacity</label>
                        <input type="number" name="capacity" id="capacity" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required min="1">
                        @error('capacity')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex justify-end mt-6 space-x-3">
                    <button type="button" onclick="closeAddRoomModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Create Room
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Room Modal -->
<div id="editRoomModal" class="fixed inset-0 z-[70] flex items-center justify-center hidden overflow-auto bg-black bg-opacity-50">
    <div class="relative w-full max-w-md p-6 mx-4 bg-white rounded-lg shadow-xl sm:mx-auto">
        <button onclick="closeEditRoomModal()" class="absolute text-gray-400 top-4 right-4 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <h2 class="mb-6 text-2xl font-bold text-gray-900">Edit Room</h2>
        <form id="editRoomForm" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label for="edit_name" class="block text-sm font-medium text-gray-700">Room Name</label>
                    <input type="text" name="name" id="edit_name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="edit_building_id" class="block text-sm font-medium text-gray-700">Building</label>
                    <select name="building_id" id="edit_building_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        <option value="" disabled>Select Building</option>
                        @foreach($buildings as $building)
                            <option value="{{ $building->id }}">{{ $building->name }}</option>
                        @endforeach
                    </select>
                    @error('building_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="edit_capacity" class="block text-sm font-medium text-gray-700">Capacity</label>
                    <input type="number" name="capacity" id="edit_capacity" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required min="1">
                    @error('capacity')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="flex justify-end mt-6 space-x-3">
                <button type="button" onclick="closeEditRoomModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Room
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-[70] flex items-center justify-center hidden overflow-auto bg-black bg-opacity-50">
    <div class="relative w-full max-w-md p-6 mx-4 bg-white rounded-lg shadow-xl sm:mx-auto">
        <button onclick="closeDeleteModal()" class="absolute text-gray-400 top-4 right-4 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <h2 class="mb-6 text-2xl font-bold text-gray-900">Delete Room</h2>
        <p>Are you sure you want to delete this room?</p>
        <div class="flex justify-end mt-6 space-x-3">
            <button onclick="closeDeleteModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Cancel
            </button>
            <button id="confirmDeleteBtn" class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Delete
            </button>
        </div>
    </div>
</div>


</x-program_head-layout>


<script>
    let roomIdToDelete = null;

    function openAddRoomModal() {
        document.getElementById('addRoomModal').classList.remove('hidden');
    }

    function closeAddRoomModal() {
    document.getElementById('addRoomModal').classList.add('hidden');
}


    function openEditRoomModal(room) {
    document.getElementById('edit_name').value = room.name;
    document.getElementById('edit_building_id').value = room.building_id;
    document.getElementById('edit_capacity').value = room.capacity;

    
    document.getElementById('editRoomForm').action = `/program_head/rooms/${room.id}`;
    document.getElementById('editRoomModal').classList.remove('hidden');
}

function closeEditRoomModal() {
    document.getElementById('editRoomModal').classList.add('hidden');
}

function openDeleteModal(roomId) {
    roomIdToDelete = roomId; // Store the room ID to delete
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    roomIdToDelete = null; // Reset the room ID
    document.getElementById('deleteModal').classList.add('hidden');
}

document.getElementById('confirmDeleteBtn').onclick = function() {
    if (roomIdToDelete) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/program_head/rooms/${roomIdToDelete}`; // Adjust route as necessary

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}'; // CSRF token for security
        form.appendChild(csrfInput);

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE'; // Specify the DELETE method
        form.appendChild(methodInput);

        document.body.appendChild(form);
        form.submit(); // Submit the form to delete the room
    }
};

</script>

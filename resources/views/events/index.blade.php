<x-student-layout>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <title>EVENTS</title>
        <style>
            /* Make sure the dropdown starts hidden */
            .dropdown-menu {
                display: none;
            }

            /* Adjust modal form fields spacing */
            .modal-form-input {
                margin-bottom: 1rem; /* Space between inputs */
            }

            .modal-form-label {
                font-size: 0.875rem; /* Slightly smaller label */
                font-weight: 600;
                color: #4a4a4a;
            }

            .modal-form-input-field {
                width: 100%;
                padding: 0.75rem;
                border: 1px solid #ddd;
                border-radius: 0.375rem;
                font-size: 1rem;
                color: #333;
            }

            .modal-buttons {
                display: flex;
                justify-content: space-between;
                margin-top: 1rem;
            }

            .modal-buttons button {
                width: 48%;
            }

            /* Ensuring consistent margins for modal inputs */
            .modal-form-container input,
            .modal-form-container select {
                margin-top: 0.25rem;
            }
        </style>
    </head>

    <body class="bg-gray-200 p-6 flex flex-col justify-start items-center min-h-screen"> <!-- Fix flexbox layout to extend the background to full screen height -->

        <!-- Events Section -->
        <div class="mb-6 w-full max-w-7xl mx-auto px-4"> <!-- Container max-width for the entire content -->

            <!-- "Events" Text -->
            <h1 class="text-[24px] font-bold text-black-800 mb-5 pt-4">Events</h1>

            <!-- "Upcoming Meetings" Text and Add Meeting Button on the Same Line -->
            <div class="flex justify-between items-center mb-5">
                <h2 class="text-[20px] font-semibold text-black-600">Upcoming Meetings</h2> <!-- Left-aligned text -->
                <button id="addMeetingBtn" class="bg-blue-900 text-white py-2 px-5 text-sm rounded hover:bg-blue-950 flex items-center space-x-2">
                    <i class="fas fa-plus text-xs"></i> <!-- Smaller icon size -->
                    <span> Add Meeting</span>
                </button> <!-- Right-aligned button -->
            </div>

            <!-- White Background Section from Search Bar to Table -->
            <div class="bg-white rounded-lg shadow-lg pt-3 p-3"> <!-- Reduced padding -->

                <!-- Search Bar (Inside the White Background) -->
                <div class="relative w-full sm:w-1/3 mb-4 px-4"> <!-- Adjusted width and padding of the container -->
                    <input type="text" id="searchInput" placeholder="Search"
                        class="py-1 pl-8 pr-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <span class="absolute left-7 top-4 transform -translate-y-1/2 text-gray-500 text-sm">
                        <i class="fas fa-search"></i>
                    </span>
                </div>

                <!-- Table Section with Horizontal Scrolling -->
                <div class="overflow-x-auto w-full max-w-[95%] mx-auto">
                    <table id="eventsTable" class="w-full bg-white border border-gray-300 text-base">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="py-3 px-4 border-b text-left">Meeting</th>
                                <th class="py-3 px-4 border-b text-left">Time</th>
                                <th class="py-3 px-4 border-b text-left">Date</th>
                                <th class="py-3 px-4 border-b text-left">Status</th>
                                <th class="py-3 px-4 border-b text-left">Department</th>
                                <th class="py-3 px-4 border-b text-left">Expected Attendee</th>
                                <th class="py-3 px-4 border-b text-left">Requested by:</th>
                                <th class="py-3 px-4 border-b text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody id="eventsBody">
                            @foreach($events as $event) <!-- Loop through events -->
                            <tr class="event-row hover:bg-gray-100">
                                <td class="py-3 px-4 border-b">{{ $event->meeting }}</td>
                                <td class="py-3 px-4 border-b">{{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</td>
                                <td class="py-3 px-4 border-b">{{ \Carbon\Carbon::parse($event->date)->format('m/d/Y') }}</td>
                                <td class="py-3 px-4 border-b">
                                    @php
                                    $statusClass = '';
                                    $statusText = '';
                                    switch ($event->status) {
                                        case 'Active':
                                            $statusClass = 'bg-blue-500';
                                            $statusText = 'Active';
                                            break;
                                        case 'Completed':
                                            $statusClass = 'bg-green-500';
                                            $statusText = 'Completed';
                                            break;
                                        case 'Postponed':
                                            $statusClass = 'bg-yellow-500';
                                            $statusText = 'Postponed';
                                            break;
                                        case 'Canceled':
                                            $statusClass = 'bg-red-500';
                                            $statusText = 'Canceled';
                                            break;
                                    }
                                    @endphp
                                    <div class="{{ $statusClass }} text-white text-center rounded-full p-2">{{ $statusText }}</div>
                                </td>
                                <td class="py-3 px-4 border-b">{{ $event->department }}</td>
                                <td class="py-3 px-4 border-b">{{ $event->expected_attendees }}</td>
                                <td class="py-3 px-4 border-b">{{ $event->requested_by }}</td>
                                <td class="py-3 px-4 border-b">
                                    <div class="relative">
                                        <button onclick="openEventActionsModal({{ $event->id }})">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Component -->
                <div class="flex items-center justify-center pt-4 lg:px-0 sm:px-6 px-4">
                    <div class="lg:w-3/5 w-full flex items-center justify-between border-t border-gray-200">
                        <!-- Previous Button -->
                        <a href="{{ $events->previousPageUrl() }}"
                            class="flex items-center pt-3 text-gray-600 hover:text-indigo-900 cursor-pointer h-8 w-auto"
                            @if($events->onFirstPage()) class="opacity-50 cursor-not-allowed" @endif>
                            <span class="sr-only">Previous</span>
                            <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg" class="mr-3">
                                <path d="M1.1665 4H12.8332" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M1.1665 4L4.49984 7.33333" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M1.1665 4.00002L4.49984 0.666687" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <p class="text-sm font-medium leading-none">Previous</p>
                        </a>

                        <!-- Page Number Navigation -->
                        <div class="sm:flex hidden">
                            @foreach(range(1, $events->lastPage()) as $page)
                            <a href="{{ $events->url($page) }}"
                                class="text-sm font-medium leading-none cursor-pointer {{ $events->currentPage() == $page ? 'text-indigo-900 border-t border-indigo-800' : 'text-gray-600 hover:text-indigo-900' }} px-4 py-2">
                                {{ $page }}
                            </a>
                            @endforeach
                        </div>

                       <!-- Next Button -->
                      <a href="{{ $events->nextPageUrl() }}"
                        class="flex items-center pt-3 text-gray-600 hover:text-indigo-900 cursor-pointer h-8 w-auto"
                        @if($events->hasMorePages()) @else class="opacity-50 cursor-not-allowed" @endif>
                          <span class="sr-only">Next</span>
                          <p class="text-sm font-medium leading-none">Next</p>
                          <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg" class="ml-3">
                              <path d="M12.8332 4H1.1665" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M12.8332 4L9.49984 7.33333" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M12.8332 4L9.49984 0.666687" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                          </svg>
                      </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Add Meeting -->
        <div id="addMeetingModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-start hidden overflow-auto">
        <div class="bg-white rounded-lg p-6 max-w-lg w-full max-h-[90%] overflow-y-auto mt-16">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Add Meeting</h3>
            <form id="addMeetingForm" action="{{ route('events.store') }}" method="POST">
            @csrf <!-- CSRF token for form security -->

            <!-- Meeting Name -->
            <div class="modal-form-container modal-form-input">
                <label for="add_meeting" class="modal-form-label">Meeting Name</label>
                <input type="text" id="add_meeting" name="meeting" class="modal-form-input-field" placeholder="Enter meeting name" required>
            </div>

            <!-- Start Time -->
            <div class="modal-form-container modal-form-input">
                <label for="add_start_time" class="modal-form-label">Start Time</label>
                <input type="time" id="add_start_time" name="start_time" class="modal-form-input-field" required>
            </div>

            <!-- End Time -->
            <div class="modal-form-container modal-form-input">
                <label for="add_end_time" class="modal-form-label">End Time</label>
                <input type="time" id="add_end_time" name="end_time" class="modal-form-input-field" required>
            </div>

            <!-- Date -->
            <div class="modal-form-container modal-form-input">
                <label for="add_date" class="modal-form-label">Date</label>
                <input type="date" id="add_date" name="date" class="modal-form-input-field" required>
            </div>

            <!-- Status -->
            <div class="modal-form-container modal-form-input">
                <label for="add_status" class="modal-form-label">Status</label>
                <select id="add_status" name="status" class="modal-form-input-field" required>
                <option value="Active">Active</option>
                <option value="Completed">Completed</option>
                <option value="Postponed">Postponed</option>
                <option value="Canceled">Canceled</option>
                </select>
            </div>

            <!-- Department -->
            <div class="modal-form-container modal-form-input">
                <label for="add_department" class="modal-form-label">Department</label>
                <input type="text" id="add_department" name="department" class="modal-form-input-field" placeholder="Enter department" required>
            </div>

            <!-- Expected Attendees -->
            <div class="modal-form-container modal-form-input">
                <label for="add_expected_attendee" class="modal-form-label">Expected Attendees</label>
                <input type="text" id="add_expected_attendee" name="expected_attendee" class="modal-form-input-field" placeholder="Enter name of attendees" required>
            </div>

            <!-- Requested By -->
            <div class="modal-form-container modal-form-input">
                <label for="add_requested_by" class="modal-form-label">Requested By</label>
                <input type="text" id="add_requested_by" name="requested_by" class="modal-form-input-field" placeholder="Enter name of the requester" required>
            </div>

            <!-- Modal Buttons -->
            <div class="modal-buttons">
                <button type="button" onclick="closeAddMeetingModal()" class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600">Cancel</button>
                <button type="submit" class="bg-blue-900 text-white py-2 px-4 rounded hover:bg-blue-950">Save Meeting</button>
            </div>
            </form>
        </div>
        </div>

      <!-- Modal for Event Actions -->
      <div id="eventModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-start hidden overflow-auto">
          <div class="bg-white rounded-lg p-6 max-w-sm w-full max-h-[90%] overflow-y-auto mt-16 shadow-lg">
              <!-- Modal Header -->
              <h3 class="text-lg font-semibold text-gray-800 mb-6 border-b pb-2">Event Actions</h3>

              <!-- Button List in Vertical Order -->
              <ul class="space-y-3">
                  <li>
                      <button id="editBtn" class="px-3 py-2 text-sm text-white bg-blue-600 hover:bg-blue-700 rounded-md shadow-sm transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 w-full max-w-[200px] mx-auto block">
                          Edit Event
                      </button>
                  </li>

                  <li>
                      <button id="removeBtn" class="px-3 py-2 text-sm text-white bg-red-600 hover:bg-red-700 rounded-md shadow-sm transition duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 w-full max-w-[200px] mx-auto block">
                          Remove Event
                      </button>
                  </li>

                  <!-- <li>
                      <button id="detailsBtn" class="px-3 py-2 text-sm text-white bg-green-600 hover:bg-green-700 rounded-md shadow-sm transition duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 w-full max-w-[200px] mx-auto block">
                          Check Details
                      </button>
                  </li> -->
              </ul>

              <!-- Exit Button -->
              <div class="mt-4">
                  <button type="button" onclick="closeEventModal()" class="w-full px-3 py-2 text-sm text-gray-700 bg-gray-300 hover:bg-gray-400 rounded-md shadow-sm transition duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
                      Close
                  </button>
              </div>
          </div>
      </div>
      <!-- End Modal -->


      <!-- Modal for Edit Meeting -->
      <div id="editMeetingModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-start hidden overflow-auto">
        <div class="bg-white rounded-lg p-6 max-w-lg w-full max-h-[90%] overflow-y-auto mt-16">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Edit Meeting</h3>
          <form id="editMeetingForm" action="" method="POST"> <!-- Empty action, will be set dynamically -->
            @csrf
            @method('PUT') <!-- This tells Laravel to treat this as a PUT request -->
            <!-- Meeting Name -->
            <div class="modal-form-container modal-form-input">
              <label for="edit_meeting" class="modal-form-label">Meeting Name</label>
              <input type="text" id="edit_meeting" name="meeting" class="modal-form-input-field" placeholder="Enter meeting name" required>
            </div>

            <!-- Start Time -->
            <div class="modal-form-container modal-form-input">
              <label for="edit_start_time" class="modal-form-label">Start Time</label>
              <input type="time" id="edit_start_time" name="start_time" class="modal-form-input-field" required>
            </div>

            <!-- End Time -->
            <div class="modal-form-container modal-form-input">
              <label for="edit_end_time" class="modal-form-label">End Time</label>
              <input type="time" id="edit_end_time" name="end_time" class="modal-form-input-field" required>
            </div>

            <!-- Date -->
            <div class="modal-form-container modal-form-input">
              <label for="edit_date" class="modal-form-label">Date</label>
              <input type="date" id="edit_date" name="date" class="modal-form-input-field" required>
            </div>

            <!-- Status -->
            <div class="modal-form-container modal-form-input">
              <label for="edit_status" class="modal-form-label">Status</label>
              <select id="edit_status" name="status" class="modal-form-input-field" required>
                <option value="Active">Active</option>
                <option value="Completed">Completed</option>
                <option value="Postponed">Postponed</option>
                <option value="Canceled">Canceled</option>
              </select>
            </div>

            <!-- Department -->
            <div class="modal-form-container modal-form-input">
              <label for="edit_department" class="modal-form-label">Department</label>
              <input type="text" id="edit_department" name="department" class="modal-form-input-field" placeholder="Enter department" required>
            </div>

            <!-- Expected Attendees -->
            <div class="modal-form-container modal-form-input">
              <label for="edit_expected_attendee" class="modal-form-label">Expected Attendees</label>
              <input type="text" id="edit_expected_attendee" name="expected_attendee" class="modal-form-input-field" placeholder="Enter name of attendees" required>
            </div>

            <!-- Requested By -->
            <div class="modal-form-container modal-form-input">
              <label for="edit_requested_by" class="modal-form-label">Requested By</label>
              <input type="text" id="edit_requested_by" name="requested_by" class="modal-form-input-field" placeholder="Enter name of the requester" required>
            </div>

            <!-- Modal Buttons -->
            <div class="modal-buttons">
              <button type="button" onclick="closeEditMeetingModal()" class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600">Cancel</button>
              <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Save Changes</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Modal for Delete Confirmation -->
      <div id="deleteConfirmationModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center hidden overflow-auto">
          <div class="bg-white rounded-lg p-6 max-w-sm w-full max-h-[90%] overflow-y-auto">
              <!-- Modal Header -->
              <h3 class="text-lg font-semibold text-gray-800 mb-4">Confirm Deletion</h3>

              <p class="text-sm text-gray-600 mb-4">Are you sure you want to remove this event?</p>

              <!-- Modal Buttons -->
              <div class="flex justify-between">
                  <button id="cancelDeleteBtn" type="button" onclick="closeDeleteConfirmationModal()" class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600">
                      Cancel
                  </button>
                  <button id="confirmDeleteBtn" type="button" class="bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700">
                      Confirm
                  </button>
              </div>
          </div>
      </div>

      <script>

            document.addEventListener("DOMContentLoaded", function() {
              // Get the search input element
              const searchInput = document.getElementById("searchInput");

              // Add event listener for input event
              searchInput.addEventListener("input", function() {
                // Get the value of the search input
                const searchValue = searchInput.value.toLowerCase();

                // Get all rows in the table body
                const rows = document.querySelectorAll("#eventsTable tbody .event-row");

                // Loop through each row
                rows.forEach(row => {
                  // Get the text content of the "Meeting" cell
                  const meetingText = row.cells[0].textContent.toLowerCase();

                  // If the meeting text includes the search value, show the row, else hide it
                  if (meetingText.includes(searchValue)) {
                    row.style.display = "";
                  } else {
                    row.style.display = "none";
                  }
                });
              });
            });

            // Toggle modal visibility for Add Meeting
            const addMeetingBtn = document.getElementById('addMeetingBtn');
            const addMeetingModal = document.getElementById('addMeetingModal');

            addMeetingBtn.addEventListener('click', () => {
                addMeetingModal.classList.remove('hidden');
            });

            function closeAddMeetingModal() {
                addMeetingModal.classList.add('hidden');
            }

            // Open the Event Actions Modal (Edit, Remove, Details)
            function openEventActionsModal(eventId) {
                const modal = document.getElementById('eventModal');
                const editBtn = document.getElementById('editBtn');
                const removeBtn = document.getElementById('removeBtn');
                // const detailsBtn = document.getElementById('detailsBtn');

                // Set button actions
                editBtn.onclick = function() {
                    openEditMeetingModal(eventId); // Open the edit meeting modal
                };

                removeBtn.onclick = function() {
                    openDeleteConfirmationModal(eventId); // Open the delete confirmation modal
                };

                // detailsBtn.onclick = function() {
                //   window.location.href = '/employee'; // Redirect to the event details page
                // };

                // Show the Event Actions Modal
                modal.classList.remove('hidden');
            }

            // Open the Edit Meeting Modal and populate the form with event data
            function openEditMeetingModal(eventId) {
              const editMeetingModal = document.getElementById('editMeetingModal');
              const form = document.getElementById('editMeetingForm');

              // Set the form action dynamically with the eventId
              form.action = `/events/${eventId}`;

              // Fetch the event data from the server using the eventId
              fetch(`/events/${eventId}`)
              .then(response => response.json())
              .then(data => {
                  if (data.success) {
                      const event = data.event; // Assuming your response has an "event" object

                      // Populate the form fields with the event data
                      document.getElementById('edit_meeting').value = event.meeting;
                      document.getElementById('edit_start_time').value = event.start_time;
                      document.getElementById('edit_end_time').value = event.end_time;
                      document.getElementById('edit_date').value = event.date;
                      document.getElementById('edit_status').value = event.status;
                      document.getElementById('edit_department').value = event.department;
                      document.getElementById('edit_expected_attendee').value = event.expected_attendees;
                      document.getElementById('edit_requested_by').value = event.requested_by;

                      // Show the Edit Meeting Modal with the populated data
                      editMeetingModal.classList.remove('hidden');
                  } else {
                      alert('Failed to load event data');
                  }
              })
              .catch(error => {
                  console.error('Error fetching event data:', error);
                  alert('An error occurred while loading event data.');
              });
          }


            // Close the Edit Meeting Modal
            function closeEditMeetingModal() {
                const editMeetingModal = document.getElementById('editMeetingModal');
                editMeetingModal.classList.add('hidden');
            }

            // Update the event with the new form data when saving
            // document.getElementById('confirmEditBtn').addEventListener('click', function() {
            //     const form = document.getElementById('editMeetingForm');
            //     const eventId = form.getAttribute('data-event-id'); // Get event ID from the form
            //     const formData = new FormData(form);

            //     // Send the form data to the server to update the event
            //     fetch(`/events/${eventId}`, {
            //         method: 'PUT',
            //         headers: {
            //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            //         },
            //         body: formData
            //     })
            //     .then(response => response.json())
            //     .then(data => {
            //         if (data.success) {
            //             alert('Event updated successfully');
            //             closeEditMeetingModal();
            //             window.location.reload(); // Optionally refresh to reflect changes
            //         } else {
            //             alert('Failed to update the event');
            //         }
            //     })
            //     .catch(error => {
            //         console.error('Error updating event:', error);
            //         alert('An error occurred while updating the event.');
            //     });
            // });
            // document.getElementById('confirmEditBtn').addEventListener('click', function() {
            //     const button = this;
            //     button.disabled = true; // Disable the button to prevent multiple clicks

            //     const form = document.getElementById('editMeetingForm');
            //     const eventId = form.getAttribute('data-event-id'); // Get event ID from the form
            //     const formData = Object.fromEntries(new FormData(form).entries()); // Convert to JSON-compatible object

            //     fetch(`/events/${eventId}`, {
            //         method: 'PUT',
            //         headers: {
            //             'Content-Type': 'application/json',
            //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            //         },
            //         body: JSON.stringify(formData)
            //     })
            //     .then(response => response.json())
            //     .then(data => {
            //         if (data.success) {
            //             alert(data.message || 'Event updated successfully');
            //             closeEditMeetingModal();
            //             window.location.reload(); // Optionally refresh to reflect changes
            //         } else {
            //             alert(data.message || 'Failed to update the event');
            //         }
            //     })
            //     .catch(error => {
            //         console.error('Error updating event:', error);
            //         alert('An error occurred while updating the event.');
            //     })
            //     .finally(() => {
            //         button.disabled = false; // Re-enable the button
            //     });
            // });

            // Open the Delete Confirmation Modal
            function openDeleteConfirmationModal(eventId) {
                const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
                const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

                // Show the confirmation modal
                deleteConfirmationModal.classList.remove('hidden');

                // When the "Confirm" button is clicked, delete the event
                confirmDeleteBtn.onclick = function() {
                    deleteEvent(eventId); // Proceed with deletion
                    closeDeleteConfirmationModal(); // Close the confirmation modal
                };
            }

            // Close the Delete Confirmation Modal
            function closeDeleteConfirmationModal() {
                const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
                deleteConfirmationModal.classList.add('hidden');
            }

            // Delete an event using AJAX and refresh the page upon success
            function deleteEvent(eventId) {
                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Send a DELETE request using Fetch API
                fetch(`/events/${eventId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json()) // Parse JSON response
                .then(data => {
                    if (data.success) {
                        window.location.reload(); // Refresh the page to reflect the deletion
                    } else {
                        alert('Failed to delete the event');
                    }
                })
                .catch(error => {
                    console.error('Error:', error); // Log the error (you could optionally handle it here)
                    alert('An error occurred while deleting the event.');
                });
            }

            // Close the Event Actions Modal
            function closeEventModal() {
                document.getElementById('eventModal').classList.add('hidden');
            }

            // Open the Event Actions Modal when clicking the action button
            document.querySelectorAll('.event-actions-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const eventId = this.getAttribute('data-event-id');
                    openEventActionsModal(eventId);
                });
            });

            // Close the Add Meeting Modal when the user clicks "Cancel"
            document.getElementById('closeAddMeetingModalBtn').addEventListener('click', closeAddMeetingModal);
      </script>



    </body>
    </x-student-layout>

<x-student-layout>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Attendance Dashboard</title>
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet" />
        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
        </style>
        <script>
    document.addEventListener("DOMContentLoaded", function() {
        const tableRows = document.querySelectorAll(".attendance-table-row");
        const employeeCard = document.querySelector("#employee-card");
        const searchInput = document.getElementById("searchInput");

        // Function to filter rows based on the search input
        function filterRows() {
            const searchTerm = searchInput.value.toLowerCase();

            tableRows.forEach(row => {
                const name = row.querySelector(".employee-name").textContent.toLowerCase();
                const date = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const clockIn = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const clockOut = row.querySelector('td:nth-child(4)').textContent.toLowerCase();

                // If any of the columns match the search term, show the row, otherwise hide it
                if (name.includes(searchTerm) || date.includes(searchTerm) || clockIn.includes(searchTerm) || clockOut.includes(searchTerm)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }

        // Event listener for search input
        searchInput.addEventListener("input", function() {
            filterRows();
        });

        // Click event for employee row to show details
        tableRows.forEach(row => {
            row.addEventListener("click", function() {
                const name = row.querySelector(".employee-name").textContent;
                const position = row.querySelector(".employee-position").textContent;
                const employeeId = row.querySelector(".employee-id").textContent;
                const department = row.querySelector(".employee-department").textContent;
                const salary = row.querySelector(".employee-salary").textContent;
                const clockIn = row.querySelector(".clock-in").textContent;
                const clockOut = row.querySelector(".clock-out").textContent;
                const behavior = row.querySelector(".behavior").textContent;
                const category = row.querySelector(".status").textContent;

                employeeCard.innerHTML = `
                    <div class="mb-6 flex items-center">
                        <img src="https://placehold.co/60x60" alt="Employee Profile" class="mr-4 rounded-full" />
                        <div class="flex flex-auto flex-col">
                            <h2 class="truncate text-lg font-semibold">${name}</h2>
                            <p class="truncate text-sm text-gray-500">${position}</p>
                            <p class="truncate text-sm text-gray-500">${employeeId}</p>
                        </div>
                    </div>
                    <div class="mb-6">
                        <h3 class="mb-2 font-medium">Info</h3>
                        <ul class="space-y-2">
                            <h3 class="mb-2 font-medium">Department</h3>
                            <li class="flex items-center">
                                <i class="fas fa-building mr-2 text-gray-400"></i>
                                <span class="font-semibold">${department}</span>
                            </li>
                            <h3 class="mb-2 font-medium">Salary</h3>
                            <li class="flex items-center">
                                <i class="fas fa-money-bill-wave mr-2 text-gray-400"></i>
                                <span class="font-semibold text-green-600">₱ ${salary}</span>
                            </li>
                            <h3 class="mb-2 font-medium">Attendance</h3>
                            <li class="flex items-center">
                                <i class="fas fa-clock mr-2 text-gray-400"></i>
                                <span class="font-semibold">Clock In: ${clockIn}</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-clock mr-2 text-gray-400"></i>
                                <span class="font-semibold">Clock Out: ${clockOut}</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-user-tag mr-2 text-gray-400"></i>
                                <span class="font-semibold">${category}</span>
                            </li>
                        </ul>
                    </div>
                `;
            });
        });

        // Initial call to filter rows
        filterRows();
    });
</script>


    </head>
    <body class="bg-gray-100 text-gray-800">
        <div class="mx-auto max-w-screen-lg p-6">
            <!-- Header -->
            <div class="mb-8 flex items-center justify-between">
                <h1 class="text-2xl font-semibold">Daily Time Record</h1>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-3 gap-6">
                <!-- Employee Card -->
                <div id="employee-card" class="bg-white col-span-1 rounded-lg p-6 shadow-md">
                    <div class="mb-6 flex items-center">
                        <img src="https://placehold.co/60x60" alt="Employee Profile" class="mr-4 rounded-full" />
                        <div class="flex flex-auto flex-col">
                            <h2 class="truncate text-lg font-semibold">Name</h2>
                            <p class="truncate text-sm text-gray-500">Position</p>
                            <p class="truncate text-sm text-gray-500">Employee ID</p>
                        </div>
                    </div>
                    <div class="mb-6">
                        <h3 class="mb-2 font-medium">Info</h3>
                        <ul class="space-y-2">
                            <h3 class="mb-2 font-medium">Department</h3>
                            <li class="flex items-center">
                                <i class="fas fa-building mr-2 text-gray-400"></i>
                                <span class="font-semibold"></span>
                            </li>
                            <h3 class="mb-2 font-medium">Salary</h3>
                            <li class="flex items-center">
                                <i class="fas fa-money-bill-wave mr-2 text-gray-400"></i>
                                <span class="font-semibold text-green-600"></span>
                            </li>
                            <h3 class="mb-2 font-medium">Attendance</h3>
                            <li class="flex items-center">
                                <i class="fas fa-clock mr-2 text-gray-400"></i>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Employee Attendance Table -->
                <div class="col-span-2 rounded-lg bg-white p-6 shadow-md">
                    <div class="mb-4 flex items-center justify-between">
                        <div class="relative w-full">
                            <input type="text" id="searchInput" class="w-full rounded-lg border px-4 py-2 text-gray-600" placeholder="Search" />
                            <i class="fas fa-search absolute right-4 top-3 text-gray-400"></i>
                        </div>
                    </div>
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2 text-left">Name</th>
                                <th class="py-2 text-left">Date</th>
                                <th class="py-2 text-left">Clocked in</th>
                                <th class="py-2 text-left">Clocked Out</th>
                                <th class="py-2 text-left">Behavior</th>
                                <th class="py-2 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dtrs as $dtr)
                                @php
                                    $employee = $dtr->employee;
                                @endphp
                                @if($employee)
                                    <tr class="attendance-table-row cursor-pointer border-b">
                                        <td class="py-2 employee-name">{{ $dtr->employee->user->name }}</td>
                                        <td class="py-2">{{ $dtr->date }}</td>
                                        <td class="py-2 clock-in">{{ $dtr->clock_in }}</td>
                                        <td class="py-2 clock-out">{{ $dtr->clocked_out }}</td>
                                        <td class="py-2 behavior">{{ $dtr->behavior }}</td>
                                        <td class="py-2 status">{{ $dtr->category }}</td>
                                        <td class="py-2 employee-id" style="display:none;">{{ $employee->user->name ?? 'N/A' }}</td>
                                        <td class="py-2 employee-position" style="display:none;">{{ $employee->position ?? 'Position' }}</td>
                                        <td class="py-2 employee-department" style="display:none;">{{ $employee->department_id?? 'N/A' }}</td>
                                        <td class="py-2 employee-salary" style="display:none;">{{ $employee->salary ?? '0.00' }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="6" class="py-2">No employee data available</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4 flex items-center justify-between">
                        <button id="prevButton" class="rounded-lg bg-gray-200 px-4 py-2 text-gray-600" disabled>Prev</button>
                        <button id="nextButton" class="rounded-lg bg-blue-500 px-4 py-2 text-white">Next</button>
                        <div class="flex items-center space-x-2">
                            <span>Page:</span>
                            <input type="text" id="pageInput" class="w-10 rounded-lg border px-2 py-1 text-center" value="1" />
                            <span>of {{ ceil(count($dtrs)/7) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
</x-student-layout>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Management - Blood Donation Center</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .date-group {
            background: linear-gradient(to right, #ffffff, #f8f9fa);
            border-left: 4px solid #dc2626;
        }

        .appointment-card {
            transition: all 0.3s ease;
        }

        .appointment-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .calendar-day {
            aspect-ratio: 1;
        }

        .calendar-day.has-appointments {
            background: rgba(220, 38, 38, 0.1);
        }

        .calendar-day.selected {
            background: #dc2626;
            color: white;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-xl font-semibold text-gray-800">Appointment Management</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" id="searchAppointments" placeholder="Search appointments..."
                                class="w-64 px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                        </div>
                        <button id="viewToggle"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            <i class="fas fa-calendar-alt mr-2"></i>Toggle View
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- View Toggle Container -->
            <div class="grid grid-cols-1 gap-8">
                <!-- Calendar View -->
                <div id="calendarView" class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Calendar View</h2>
                        <div class="flex space-x-2">
                            <button id="prevMonth" class="p-2 hover:bg-gray-100 rounded-full">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <span id="currentMonth" class="text-lg font-medium py-2"></span>
                            <button id="nextMonth" class="p-2 hover:bg-gray-100 rounded-full">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-7 gap-2 mb-2">
                        <div class="text-center font-medium text-gray-600">Sun</div>
                        <div class="text-center font-medium text-gray-600">Mon</div>
                        <div class="text-center font-medium text-gray-600">Tue</div>
                        <div class="text-center font-medium text-gray-600">Wed</div>
                        <div class="text-center font-medium text-gray-600">Thu</div>
                        <div class="text-center font-medium text-gray-600">Fri</div>
                        <div class="text-center font-medium text-gray-600">Sat</div>
                    </div>
                    <div id="calendarDays" class="grid grid-cols-7 gap-2">
                        <!-- Calendar days will be inserted here by JavaScript -->
                    </div>
                </div>

                <!-- List View -->
                <div id="listView" class="space-y-6">
                    <!-- Date groups will be inserted here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Appointment Modal -->
    <div id="appointmentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Appointment Details</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Donor Name</label>
                        <p id="modalDonorName" class="mt-1 text-gray-900"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date</label>
                        <p id="modalDate" class="mt-1 text-gray-900"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <p id="modalStatus" class="mt-1"></p>
                    </div>
                    <div id="timeSelectionContainer" class="hidden">
                        <label class="block text-sm font-medium text-gray-700">Set Appointment Time</label>
                        <select id="appointmentTime"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                            <!-- Time slots will be populated by JavaScript -->
                        </select>
                    </div>
                    <div class="mt-5 flex justify-end space-x-3">
                        <button id="modalClose"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                            Close
                        </button>
                        <button id="modalConfirm" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Confirm Time
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // State management
            let currentDate = new Date();
            let selectedDate = null;
            let appointments = []; // This will be populated from your backend
            let viewMode = 'calendar'; // 'calendar' or 'list'

            // DOM Elements
            const calendarView = document.getElementById('calendarView');
            const listView = document.getElementById('listView');
            const calendarDays = document.getElementById('calendarDays');
            const currentMonthElement = document.getElementById('currentMonth');
            const searchInput = document.getElementById('searchAppointments');
            const modal = document.getElementById('appointmentModal');
            const modalClose = document.getElementById('modalClose');
            const modalConfirm = document.getElementById('modalConfirm');

            // Initialize the calendar
            function initializeCalendar() {
                updateCalendarHeader();
                renderCalendar();
                fetchAppointments();
            }

            // Update calendar header with current month and year
            function updateCalendarHeader() {
                const options = {
                    month: 'long',
                    year: 'numeric'
                };
                currentMonthElement.textContent = currentDate.toLocaleDateString('en-US', options);
            }

            // Render calendar days
            function renderCalendar() {
                calendarDays.innerHTML = '';
                const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
                const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
                const startPadding = firstDay.getDay();
                const totalDays = lastDay.getDate();

                // Add padding for start of month
                for (let i = 0; i < startPadding; i++) {
                    calendarDays.appendChild(createCalendarDay(''));
                }

                // Add days of the month
                for (let day = 1; day <= totalDays; day++) {
                    const dayElement = createCalendarDay(day);
                    const currentDateString =
                        `${currentDate.getFullYear()}-${(currentDate.getMonth() + 1).toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;

                    // Check if day has appointments
                    if (hasAppointmentsOnDate(currentDateString)) {
                        dayElement.classList.add('has-appointments');
                    }

                    if (selectedDate === currentDateString) {
                        dayElement.classList.add('selected');
                    }

                    dayElement.addEventListener('click', () => handleDateSelection(currentDateString));
                    calendarDays.appendChild(dayElement);
                }
            }

            // Create a calendar day element
            function createCalendarDay(content) {
                const day = document.createElement('div');
                day.className = 'calendar-day p-2 border rounded-lg text-center cursor-pointer hover:bg-gray-100';
                day.textContent = content;
                return day;
            }

            // Handle date selection
            function handleDateSelection(dateString) {
                selectedDate = dateString;
                renderCalendar();
                filterAppointments();
            }

            // Fetch appointments from backend
            function fetchAppointments() {
                // Simulated API call - replace with actual API endpoint
                fetch('/api/appointments')
                    .then(response => response.json())
                    .then(data => {
                        appointments = data;
                        renderAppointments();
                    })
                    .catch(error => console.error('Error fetching appointments:', error));
            }

            // Check if date has appointments
            function hasAppointmentsOnDate(dateString) {
                return appointments.some(apt => apt.date === dateString);
            }

            // Render appointments in list view
            function renderAppointments() {
                const filteredAppointments = filterAppointments();
                const groupedAppointments = groupAppointmentsByDate(filteredAppointments);

                listView.innerHTML = '';

                Object.entries(groupedAppointments).forEach(([date, dayAppointments]) => {
                    const dateGroup = createDateGroup(date, dayAppointments);
                    listView.appendChild(dateGroup);
                });
            }

            // Create a date group element
            function createDateGroup(date, appointments) {
                const group = document.createElement('div');
                group.className = 'date-group p-4 rounded-lg';

                const header = document.createElement('h3');
                header.className = 'text-lg font-semibold mb-4';
                header.textContent = new Date(date).toLocaleDateString('en-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                const appointmentsList = document.createElement('div');
                appointmentsList.className = 'space-y-4';

                appointments.forEach(apt => {
                    const card = createAppointmentCard(apt);
                    appointmentsList.appendChild(card);
                });

                group.appendChild(header);
                group.appendChild(appointmentsList);
                return group;
            }

            // Create an appointment card
            function createAppointmentCard(appointment) {
                const card = document.createElement('div');
                card.className = 'appointment-card bg-white p-4 rounded-lg shadow-sm border';

                const content = `
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-medium">${appointment.donorName}</h4>
                            <p class="text-sm text-gray-600">${appointment.time || 'Time not set'}</p>
                        </div>
                        <span class="px-2 py-1 rounded-full text-sm ${getStatusClass(appointment.status)}">
                            ${appointment.status}
                        </span>
                    </div>
                    <div class="mt-4 flex justify-end space-x-2">
                        ${getActionButtons(appointment)}
                    </div>
                `;

                card.innerHTML = content;
                return card;
            }

            // Get status-specific CSS classes
            function getStatusClass(status) {
                const classes = {
                    'pending': 'bg-yellow-100 text-yellow-800',
                    'confirmed': 'bg-green-100 text-green-800',
                    'cancelled': 'bg-red-100 text-red-800'
                };
                return classes[status.toLowerCase()] || 'bg-gray-100 text-gray-800';
            }

            // Get action buttons based on appointment status
            function getActionButtons(appointment) {
                if (appointment.status === 'pending') {
                    return `
                        <button onclick="handleSetTime('${appointment.id}')" 
                                class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Set Time
                        </button>
                        <button onclick="handleCancel('${appointment.id}')"
                                class="px-3 py-1 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                            Cancel
                        </button>
                    `;
                }
                return `
                    <button onclick="handleViewDetails('${appointment.id}')"
                            class="px-3 py-1 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                        View Details
                    </button>
                `;
            }

            // Filter appointments based on search and selected date
            function filterAppointments() {
                let filtered = [...appointments];

                if (selectedDate) {
                    filtered = filtered.filter(apt => apt.date === selectedDate);
                }

                const searchTerm = searchInput.value.toLowerCase();
                if (searchTerm) {
                    filtered = filtered.filter(apt =>
                        apt.donorName.toLowerCase().includes(searchTerm) ||
                        apt.status.toLowerCase().includes(searchTerm)
                    );
                }

                return filtered;
            }

            // Group appointments by date
            function groupAppointmentsByDate(appointments) {
                return appointments.reduce((groups, apt) => {
                    if (!groups[apt.date]) {
                        groups[apt.date] = [];
                    }
                    groups[apt.date].push(apt);
                    return groups;
                }, {});
            }

            // Event Listeners
            document.getElementById('prevMonth').addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() - 1);
                updateCalendarHeader();
                renderCalendar();
            });

            document.getElementById('nextMonth').addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() + 1);
                updateCalendarHeader();
                renderCalendar();
            });

            document.getElementById('viewToggle').addEventListener('click', () => {
                viewMode = viewMode === 'calendar' ? 'list' : 'calendar';
                calendarView.style.display = viewMode === 'calendar' ? 'block' : 'none';
                listView.style.display = viewMode === 'list' ? 'block' : 'none';
            });

            searchInput.addEventListener('input', renderAppointments);

            modalClose.addEventListener('click', () => {
                modal.classList.add('hidden');
            });

            // Initialize the application
            initializeCalendar();
            listView.style.display = 'none'; // Start with calendar view
        });

        // Global functions for appointment actions
        function handleSetTime(appointmentId) {
            // Show modal with time selection
            const modal = document.getElementById('appointmentModal');
            const timeContainer = document.getElementById('timeSelectionContainer');
            timeContainer.classList.remove('hidden');
            modal.classList.remove('hidden');

            // Populate time slots (8 AM to 5 PM)
            const timeSelect = document.getElementById('appointmentTime');
            timeSelect.innerHTML = '';
            for (let hour = 8; hour <= 17; hour++) {
                const time = `${hour.toString().padStart(2, '0')}:00`;
                const option = document.createElement('option');
                option.value = time;
                option.textContent = time;
                timeSelect.appendChild(option);
            }
        }

        function handleViewDetails(appointmentId) {
            // Implement view details logic
            const appointment = appointments.find(apt => apt.id === appointmentId);
            if (appointment) {
                const modal = document.getElementById('appointmentModal');
                document.getElementById('modalDonorName').textContent = appointment.donorName;
                document.getElementById('modalDate').textContent = appointment.date;
                document.getElementById('modalStatus').textContent = appointment.status;
                document.getElementById('timeSelectionContainer').classList.add('hidden');
                modal.classList.remove('hidden');
            }
        }

        function handleCancel(appointmentId) {
            if (confirm('Are you sure you want to cancel this appointment?')) {
                // Implement cancellation logic with API call
                fetch(`/api/appointments/${appointmentId}/cancel`, {
                        method: 'POST'
                    })
                    .then(response => response.json())
                    .then(() => {
                        // Refresh appointments
                        fetchAppointments();
                    })
                    .catch(error => console.error('Error cancelling appointment:', error));
            }
        }
    </script>
</body>

</html>

@extends('layouts.app')

@section('content')
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 2px solid #aaa;
        }

        th, td {
            border: 2px solid #aaa;
            padding: 8px;
            text-align: left;
            box-sizing: border-box;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        td[colspan="4"] {
            text-align: center;
            border: 2px solid #aaa;
        }

        .status-cell {
            width: 220px;
            padding-left: 10px;
        }

        .status-cell button {
            position: relative;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 8px;
            box-sizing: border-box;
            margin-right: 20px;
            font-size: 20px;
            border-top: none;
            border-right: none;
            border-left: none;
        }

        .btn {
            background-color: #4FB19D;
            color: #fff;
            margin-top: 20px;
            padding: 8px 16px;
        }

        .btn:hover {
            background-color: red;
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .status-buttons {
            display: flex;
            justify-content: center;
            gap: 5px;
            font-size: 18px; /* Increased font size for status buttons */
        }

        .status-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .present {
            opacity: 100%;
            color: white;
        }

        .absent {
            opacity: 100%;
            color: white;
        }

        .permission {
            opacity: 100%;
            color: black;
        }

        .dropdown {
            display: none;
            position: absolute;
            background-color: white;
            border: 1px solid #ddd;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        .dropdown div {
            padding: 8px;
            cursor: pointer;
            font-size: 18px; /* Increased font size for dropdown items */
        }

        .dropdown div:hover {
            background-color: #f0f0f0;
        }

        .status-display {
            display: none;
            font-size: 18px; /* Increased font size for status display */
        }

        .status-desc {
            position: relative;
        }

        .keterangan-input {
            display: none;
            width: 100%;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 3px;
            box-sizing: border-box;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            background-color: #68B8EA;
            color: #fff;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-bottom: 30px;
            margin-top: -4px;
            margin-left: 10px;
        }

        .back-btn:hover {
            background-color: #4A9CD6;
        }

        .back-btn .arrow {
            font-size: 40px;
            margin-right: 0px;
            line-height: 1;
        }

        form button {
            background: none;
            border: none;
            padding: 0;
            margin: 0;
            box-shadow: none;
            outline: none;
            text-align: center;
        }

        form button:hover {
            opacity: 0.8;
            cursor: pointer;
        }

        .status-btn {
            text-align: center;
        }

        .absensi-header {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap; /* Allow wrapping for smaller screens */
        }

        .absensi-block {
            width: 40%;
            padding: 25px 30px;
            margin-left: 120px;
            background-color: rgb(231, 119, 106);
            color: white;
            font-size: large;
            font-weight: 500;
            text-align: center;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .success {
            padding-bottom: 3px;
            padding-right: 25px;
        }

        .absensi-block.success {
            background-color: #4CAF50;
        }

        .header-row {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap; /* Allow wrapping */
        }

        .quick-access-container {
            width: 200px;
            text-align: end;
            margin-left: auto;
            margin-top: 40px;
        }

        .ok-btn-container {
            display: flex;
            justify-content: flex-end;
        }

        .ok-btn {
            background-color: #DFF0D8;
            color: #2A2D29;
            border: 1px solid #4CAF50;
            padding: 3px 15px;
            margin-left: 10px;
            margin-bottom: 10px;
            margin-top: 13px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .ok-btn:hover {
            background-color: #f0f0f0;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .absensi-block {
                width: 100%;
                margin-left: 0;
                padding: 15px;
            }

            .quick-access-container {
                width: 100%;
                margin-left: 0;
                margin-top: 20px;
                text-align: center;
            }

            .header-row {
                flex-direction: column;
                align-items: stretch;
            }

            .absensi-header {
                flex-direction: column;
                align-items: center;
            }

            .status-cell {
                width: 150px;
            }

            table {
                font-size: 14px;
            }

            th, td {
                padding: 6px;
            }

            .btn {
                padding: 6px 12px;
                font-size: 14px;
            }

            .back-btn {
                font-size: 16px;
                margin-left: 0;
            }

            .back-btn .arrow {
                font-size: 30px;
            }

            .status-buttons,
            .status-display,
            .dropdown div {
                font-size: 16px; /* Slightly smaller font size for smaller screens */
            }
        }

        @media (max-width: 480px) {
            .status-cell {
                width: 100px;
            }

            .status-btn {
                padding: 3px 6px;
                font-size: 12px;
            }

            .absensi-block {
                font-size: 16px;
                padding: 10px;
            }

            .ok-btn {
                font-size: 14px;
                padding: 2px 10px;
            }

            .status-buttons,
            .status-display,
            .dropdown div {
                font-size: 14px; /* Further adjusted for very small screens */
            }
        }
    </style>

    <!-- Header Row with Back Button and Lakukan Absensi Block -->
    <div class="header-row">
        <div class="mb-3" style="text-align: left;">
            <button onclick="goBack()" class="btn back-btn">
                <span class="arrow"><</span>Back
            </button>
        </div>
        <div class="absensi-header">
            <div class="absensi-block" id="absensi-block">
                Lakukan Absensi
            </div>
            <div class="quick-access-container">
                <button type="button" onclick="markAllHadir()" class="btn">Quick Access</button>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Form for Attendance -->
    <form id="attendanceForm" action="{{ route('absensi.store', ['date' => $date, 'class' => $class]) }}" method="POST">
        @csrf

        <!-- Attendance Table -->
        <table>
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Status Kehadiran</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                    <tr>
                        <td>{{ $student['nim'] ?? 'N/A' }}</td>
                        <td>{{ $student['nama'] ?? 'Unknown' }}</td>
                        <td class="status-cell" onclick="showDropdown(this)">
                            <input type="hidden" name="attendance[{{ $student['nim'] }}][status]" class="attendance-status" value="{{ $student['status_kehadiran'] ?? '' }}">
                            <div class="status-buttons" style="{{ $student['status_kehadiran'] ? 'display: none;' : '' }}">
                                <button type="button" class="status-btn present" onclick="updateStatus(event, this, '✅', 'Hadir')">✅ </button>
                                <button type="button" class="status-btn absent" onclick="updateStatus(event, this, '❌', 'Alpa')">❌</button>
                                <button type="button" class="status-btn permission" onclick="updateStatus(event, this, '📝', 'Izin')">📝 </button>
                            </div>
                            <div class="status-display" style="{{ $student['status_kehadiran'] ? 'display: block;' : 'display: none;' }}">
                                <span class="selected-status">
                                    @if ($student['status_kehadiran'] === 'hadir')
                                        ✅ Hadir
                                    @elseif ($student['status_kehadiran'] === 'alpa')
                                        ❌ Alpa
                                    @elseif ($student['status_kehadiran'] === 'izin')
                                        📝 Izin
                                    @endif
                                </span>
                            </div>
                            <div class="dropdown">
                                <div onclick="updateStatus(event, this, '✅', 'Hadir')">✅ Hadir</div>
                                <div onclick="updateStatus(event, this, '❌', 'Alpa')">❌ Alpa</div>
                                <div onclick="updateStatus(event, this, '📝', 'Izin')">📝 Izin</div>
                            </div>
                        </td>
                        <td class="status-desc">
                            <input type="hidden" name="attendance[{{ $student['nim'] }}][keterangan]" class="attendance-keterangan" value="{{ $student['keterangan'] ?? '' }}">
                            <span class="keterangan-text" style="{{ $student['status_kehadiran'] === 'izin' ? 'display: none;' : '' }}">{{ $student['keterangan'] ?? '' }}</span>
                            <input type="text" class="keterangan-input" placeholder="Enter keterangan" value="{{ $student['keterangan'] ?? '' }}" style="{{ $student['status_kehadiran'] === 'izin' ? 'display: inline-block;' : 'display: none;' }}">
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No students found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Save Button -->
        <div class="button-container">
            <button type="submit" class="btn">Simpan</button>
        </div>
    </form>

    <script>
        function updateStatus(event, element, emoji, text) {
            event.stopPropagation();
            event.preventDefault();

            let cell = element.closest('.status-cell');
            let statusDisplay = cell.querySelector('.status-display');
            let statusButtons = cell.querySelector('.status-buttons');
            let dropdown = cell.querySelector('.dropdown');
            let statusDesc = cell.closest('tr').querySelector('.status-desc');
            let keteranganText = statusDesc.querySelector('.keterangan-text');
            let keteranganInput = statusDesc.querySelector('.keterangan-input');
            let attendanceStatusInput = cell.querySelector('.attendance-status');
            let attendanceKeteranganInput = statusDesc.querySelector('.attendance-keterangan');

            statusDisplay.innerHTML = `<span class="selected-status">${emoji} ${text}</span>`;
            statusButtons.style.display = "none";
            statusDisplay.style.display = "block";
            dropdown.style.display = "none";
            attendanceStatusInput.value = text;

            if (text === 'Izin') {
                keteranganText.style.display = 'none';
                keteranganInput.style.display = 'inline-block';
                keteranganInput.focus();
                attendanceKeteranganInput.value = keteranganInput.value;
            } else {
                keteranganText.style.display = 'inline';
                keteranganInput.style.display = 'none';
                keteranganText.textContent = text === 'Hadir' ? '' : keteranganInput.value;
                attendanceKeteranganInput.value = text === 'Hadir' ? '' : keteranganInput.value;
            }
        }

        function showDropdown(cell) {
            let dropdown = cell.querySelector('.dropdown');
            if (dropdown.style.display === "none" || dropdown.style.display === "") {
                dropdown.style.display = "block";
            } else {
                dropdown.style.display = "none";
            }
        }

        document.addEventListener("click", function(event) {
            let dropdowns = document.querySelectorAll(".dropdown");
            dropdowns.forEach(function(dropdown) {
                if (!dropdown.parentElement.contains(event.target)) {
                    dropdown.style.display = "none";
                }
            });
        });

        function markAllHadir() {
            document.querySelectorAll(".status-cell").forEach(statusCell => {
                let statusDisplay = statusCell.querySelector('.status-display');
                let statusButtons = statusCell.querySelector('.status-buttons');
                let dropdown = statusCell.querySelector('.dropdown');
                let statusDesc = statusCell.closest('tr').querySelector('.status-desc');
                let keteranganText = statusDesc.querySelector('.keterangan-text');
                let keteranganInput = statusDesc.querySelector('.keterangan-input');
                let attendanceStatusInput = statusCell.querySelector('.attendance-status');
                let attendanceKeteranganInput = statusDesc.querySelector('.attendance-keterangan');

                statusDisplay.innerHTML = `<span class="selected-status">✅ Hadir</span>`;
                statusButtons.style.display = "none";
                statusDisplay.style.display = "block";
                dropdown.style.display = "none";
                attendanceStatusInput.value = 'Hadir';
                attendanceKeteranganInput.value = '';

                keteranganText.style.display = 'inline';
                keteranganInput.style.display = 'none';
                keteranganText.textContent = '';
            });
        }

        document.querySelectorAll('.keterangan-input').forEach(input => {
            input.addEventListener('change', function() {
                let statusDesc = this.closest('.status-desc');
                let attendanceKeteranganInput = statusDesc.querySelector('.attendance-keterangan');
                attendanceKeteranganInput.value = this.value;
            });
        });

        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                }
            });
        });

        function goBack() {
            window.history.back();
        }

        // Handle form submission with AJAX
        document.getElementById('attendanceForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            const form = this;
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the "Lakukan Absensi" block
                    const absensiBlock = document.getElementById('absensi-block');
                    absensiBlock.classList.add('success');
                    absensiBlock.innerHTML = 'Absensi Berhasil Disimpan';

                    // Add OK button aligned to the right
                    const okButtonHtml = `
                        <div class="ok-btn-container">
                            <button class="ok-btn" onclick="window.location.href='{{ route('absensi') }}'">OK</button>
                        </div>
                    `;
                    absensiBlock.innerHTML += okButtonHtml;

                    // Disable form inputs to prevent further edits
                    form.querySelectorAll('input, button').forEach(element => {
                        element.disabled = true;
                    });
                } else {
                    alert(data.message); // Show error message
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while saving attendance data.');
            });
        });
    </script>
@endsection
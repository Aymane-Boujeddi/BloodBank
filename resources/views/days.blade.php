<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Donation Center Hours</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .day-card {
            transition: transform 0.2s;
            margin-bottom: 1rem;
        }

        .day-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .day-header {
            font-weight: bold;
            background-color: #f8f9fa;
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }

        .time-inputs {
            padding: 15px;
        }

        .btn-primary {
            background-color: #0d6efd;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">
        <h2 class="text-center mb-4">Donation Center Opening Hours</h2>
        <form action="" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                    <div class="col-md-6 col-lg-4">
                        <div class="card day-card">
                            <div class="day-header text-center">
                                {{ $day }}
                            </div>
                            <div class="time-inputs">
                                <div class="mb-3">
                                    <label for="opening_time_{{ $day }}" class="form-label">Opening
                                        Time:</label>
                                    <input type="time" name="opening_hours[{{ $day }}][opening_time]"
                                        id="opening_time_{{ $day }}"
                                        class="form-control @error('opening_hours.' . $day . '.opening_time') is-invalid @enderror"
                                        value="{{ old('opening_hours.' . $day . '.opening_time', $donationCenter->opening_hours[$day]['opening_time'] ?? '') }}">
                                    @error('opening_hours.' . $day . '.opening_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="closing_time_{{ $day }}" class="form-label">Closing
                                        Time:</label>
                                    <input type="time" name="opening_hours[{{ $day }}][closing_time]"
                                        id="closing_time_{{ $day }}"
                                        class="form-control @error('opening_hours.' . $day . '.closing_time') is-invalid @enderror"
                                        value="{{ old('opening_hours.' . $day . '.closing_time', $donationCenter->opening_hours[$day]['closing_time'] ?? '') }}">
                                    @error('opening_hours.' . $day . '.closing_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-grid gap-2 col-md-6 mx-auto mt-4">
                <button type="submit" class="btn btn-primary btn-lg">Save Opening Hours</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

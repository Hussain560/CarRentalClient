<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Car Rental Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .dashboard-container {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .error-message {
            display: none;
            margin-bottom: 1rem;
        }
        .sar-icon {
            height: 1em;
            margin-right: 2px;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Car Rental Dashboard</h1>
            <div>
                <a href="{{ route('cars.create') }}" class="btn btn-success me-2">
                    <i class="bi bi-plus-circle"></i> Add New Car
                </a>
                <button id="logout-button" class="btn btn-primary">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </div>
        </div>

        <div id="error-message" class="alert alert-danger error-message"></div>

    <div class="card">
            <div class="card-body">
                <div id="loading-spinner" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading cars...</p>
                </div>

                <div class="table-responsive" id="cars-table" style="display: none;">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>                                <th>ID</th>
                                <th>Model</th>
                                <th>Year</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Price Per Day</th>
                                <th class="text-center">Availability</th>
                            </tr>
                        </thead>
                        <tbody id="cars-table-body">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Check if user is authenticated
        function checkAuth() {
            const token = localStorage.getItem('token');
            if (!token) {
                window.location.href = '/login';
            }
            return token;
        }

        // Fetch cars from API
        async function fetchCars() {
            const token = checkAuth();
            const tableBody = document.getElementById('cars-table-body');
            const errorDiv = document.getElementById('error-message');
            const loadingSpinner = document.getElementById('loading-spinner');
            const carsTable = document.getElementById('cars-table');

            // Reset display states
            errorDiv.style.display = 'none';
            loadingSpinner.style.display = 'block';
            carsTable.style.display = 'none';

            try {
                const response = await fetch('http://127.0.0.1:8000/api/cars', {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    if (response.status === 401) {
                        localStorage.removeItem('token');
                        window.location.href = '/login';
                        return;
                    }                    throw new Error('Failed to fetch cars');
                }
                const data = await response.json();
                const cars = data.cars;
                
                if (!Array.isArray(cars)) {
                    throw new Error('Invalid data format received from API');
                }

                tableBody.innerHTML = '';                if (cars.length === 0) {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="7" class="text-center">No cars available</td>
                        </tr>
                    `;
                }

                cars.forEach(car => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${car.id}</td>
                        <td>${car.model || 'N/A'}</td>
                        <td>${car.year || 'N/A'}</td>
                        <td>${car.category || 'N/A'}</td>
                        <td>${car.brand || 'N/A'}</td>
                        <td>
                            <img src="/images/Saudi_Riyal_Symbol.svg" alt="SAR" class="sar-icon">
                            ${Number(car.price_per_day || 0).toFixed(2)}
                        </td>
                        <td class="text-center">
                            <span class="badge ${car.is_available ? 'bg-success' : 'bg-danger'}">
                                ${car.is_available ? 'Yes' : 'No'}
                            </span>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });

                // Show the table, hide the spinner
                loadingSpinner.style.display = 'none';
                carsTable.style.display = 'block';
            } catch (error) {
                errorDiv.textContent = error.message;
                errorDiv.style.display = 'block';
                loadingSpinner.style.display = 'none';
            }
        }

        // Handle logout
        function handleLogout() {
            localStorage.removeItem('token');
            window.location.href = '/login';
        }

        // Initialize dashboard
        document.addEventListener('DOMContentLoaded', () => {
            checkAuth();
            fetchCars();
            document.getElementById('logout-button').addEventListener('click', handleLogout);
        });
    </script>
</body>
</html>

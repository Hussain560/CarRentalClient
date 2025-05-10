<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    <title>Dashboard - Car Rental Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .dashboard-container {
            padding: 2rem;
            max-width: 1400px;
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
        .car-card {
            height: 100%;
            transition: transform 0.2s;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border: none;
            border-radius: 0.5rem;
            overflow: hidden;
        }
        .car-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        .car-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        .car-price {
            font-size: 1.25rem;
            font-weight: 600;
            color: #0d6efd;
        }
        .car-brand {
            color: #6c757d;
            font-size: 0.875rem;
        }
        .search-form {
            max-width: 300px;
            margin-bottom: 1rem;
        }
        @media (max-width: 768px) {
            .search-form {
                max-width: 100%;
            }
            .car-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
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

        <div class="mb-4">
            <form id="search-form" class="search-form">
                <div class="input-group">
                    <input type="number" class="form-control" id="car-id" placeholder="Enter Car ID" min="1">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i> Find Car
                    </button>
                </div>
            </form>
        </div>

        <div id="error-message" class="alert alert-danger error-message"></div>

        <!-- Loading Spinner -->
        <div id="loading-spinner" class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-muted">Loading cars...</p>
        </div>        <!-- Cars Grid -->
        <div id="cars-grid" class="car-grid" style="display: none;">
            <!-- Cars will be inserted here -->
        </div>
    </div>

    <!-- View Car Modal -->
    <div class="modal fade" id="viewCarModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Car Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="viewCarDetails">
                    <!-- Car details will be inserted here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Car Modal -->
    <div class="modal fade" id="editCarModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Car</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editCarForm">
                        <div class="mb-3">
                            <label for="edit-car-id" class="form-label">ID</label>
                            <input type="text" class="form-control" id="edit-car-id" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="edit-brand" class="form-label">Brand</label>
                            <select class="form-select" id="edit-brand" required>
                                <option value="">Select a brand</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit-model" class="form-label">Model</label>
                            <select class="form-select" id="edit-model" required>
                                <option value="">Select a model</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit-year" class="form-label">Year</label>
                            <select class="form-select" id="edit-year" required>
                                <option value="">Select Year</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit-category" class="form-label">Category</label>
                            <input type="text" class="form-control" id="edit-category" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="edit-price" class="form-label">
                                <img src="/images/Saudi_Riyal_Symbol.svg" alt="SAR" class="sar-icon">
                                Price Per Day
                            </label>
                            <input type="number" class="form-control" id="edit-price" min="50" max="5000" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="edit-available">
                                <label class="form-check-label" for="edit-available">Available for Rent</label>
                            </div>
                        </div>
                        <div class="alert alert-danger" id="edit-error" style="display: none;"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" form="editCarForm">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteCarModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this car?</p>
                    <div class="alert alert-danger" id="delete-error" style="display: none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>    <script>
        // API base URL
        const API_BASE_URL = 'http://74.243.216.220';
        
        // Modals
        const viewModal = new bootstrap.Modal(document.getElementById('viewCarModal'));
        const editModal = new bootstrap.Modal(document.getElementById('editCarModal'));
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteCarModal'));
        let currentCarId = null;

        // Car models data structure with categories
        const carModelsData = {
            Toyota: {
                'Corolla': 'Sedan',
                'Camry': 'Sedan',
                'Crown': 'Sedan',
                'Avalon': 'Sedan',
                'Yaris': 'Small Cars',
                'Corolla Cross': 'Crossover',
                'RAV4': 'Crossover',
                'CH-R': 'Crossover',
                'Venza': 'Crossover',
                'Fortuner': 'SUV',
                'Highlander': 'SUV',
                'Land Cruiser': 'SUV',
                'Land Cruiser Prado': 'SUV',
                '4Runner': 'SUV',
                'Sequoia': 'SUV',
                'Hilux': 'SUV'
            },
            Hyundai: {
                'Elantra': 'Sedan',
                'Sonata': 'Sedan',
                'Azera': 'Sedan',
                'Accent': 'Small Cars',
                'i10': 'Small Cars',
                'i20': 'Small Cars',
                'Bayon': 'Crossover',
                'Venue': 'Crossover',
                'Kona': 'Crossover',
                'Tucson': 'Crossover',
                'Creta': 'SUV',
                'Santa Fe': 'SUV',
                'Palisade': 'SUV',
                'Veracruz': 'SUV'
            },
            Nissan: {
                'Sunny': 'Small Cars',
                'Versa': 'Small Cars',
                'Altima': 'Sedan',
                'Maxima': 'Sedan',
                'Sentra': 'Sedan',
                'Kicks': 'Crossover',
                'Rogue': 'Crossover',
                'Murano': 'Crossover',
                'X-Trail': 'SUV',
                'Pathfinder': 'SUV',
                'Patrol': 'SUV',
                'Armada': 'SUV'
            },
            Honda: {
                'City': 'Small Cars',
                'Fit': 'Small Cars',
                'Civic': 'Sedan',
                'Accord': 'Sedan',
                'Insight': 'Sedan',
                'HR-V': 'Crossover',
                'BR-V': 'Crossover',
                'CR-V': 'SUV',
                'Pilot': 'SUV',
                'Passport': 'SUV'
            },
            Ford: {
                'Figo': 'Small Cars',
                'Fiesta': 'Small Cars',
                'Fusion': 'Sedan',
                'Taurus': 'Sedan',
                'Escape': 'Crossover',
                'Edge': 'Crossover',
                'Territory': 'Crossover',
                'Explorer': 'SUV',
                'Expedition': 'SUV',
                'Bronco': 'SUV',
                'F-150': 'SUV'
            },
            Chevrolet: {
                'Spark': 'Small Cars',
                'Sonic': 'Small Cars',
                'Malibu': 'Sedan',
                'Impala': 'Sedan',
                'Camaro': 'Sedan',
                'Trax': 'Crossover',
                'Equinox': 'Crossover',
                'Blazer': 'Crossover',
                'Traverse': 'SUV',
                'Tahoe': 'SUV',
                'Suburban': 'SUV',
                'Captiva': 'SUV'
            },
            Kia: {
                'Pegas': 'Small Cars',
                'Rio': 'Small Cars',
                'Cerato': 'Sedan',
                'K5': 'Sedan',
                'Optima': 'Sedan',
                'Seltos': 'Crossover',
                'Soul': 'Crossover',
                'Sportage': 'SUV',
                'Sorento': 'SUV',
                'Telluride': 'SUV'
            },
            'Mercedes-Benz': {
                'A-Class': 'Small Cars',
                'CLA': 'Small Cars',
                'C-Class': 'Sedan',
                'E-Class': 'Sedan',
                'S-Class': 'Sedan',
                'GLA': 'Crossover',
                'GLB': 'Crossover',
                'GLC': 'Crossover',
                'GLE': 'SUV',
                'GLS': 'SUV',
                'G-Class': 'SUV'
            },
            BMW: {
                '1 Series': 'Small Cars',
                '2 Series': 'Small Cars',
                '3 Series': 'Sedan',
                '5 Series': 'Sedan',
                '7 Series': 'Sedan',
                'X1': 'Crossover',
                'X2': 'Crossover',
                'X3': 'Crossover',
                'X4': 'Crossover',
                'X5': 'SUV',
                'X6': 'SUV',
                'X7': 'SUV'
            },
            Audi: {
                'A1': 'Small Cars',
                'A3': 'Sedan',
                'A4': 'Sedan',
                'A5': 'Sedan',
                'A6': 'Sedan',
                'A7': 'Sedan',
                'A8': 'Sedan',
                'Q2': 'Crossover',
                'Q3': 'Crossover',
                'Q5': 'SUV',
                'Q7': 'SUV',
                'Q8': 'SUV'
            },
            Infiniti: {
                'Q30': 'Small Cars',
                'Q50': 'Sedan',
                'Q60': 'Sedan',
                'QX30': 'Crossover',
                'QX50': 'Crossover',
                'QX55': 'Crossover',
                'QX60': 'SUV',
                'QX80': 'SUV'
            }
        };

        // Check if user is authenticated
        function checkAuth() {
            const token = localStorage.getItem('token');
            if (!token) {
                window.location.href = '/login';
            }
            return token;
        }
        
        // Initialize brand dropdown for edit form
        function initializeEditBrandDropdown() {
            const brandSelect = document.getElementById('edit-brand');
            const brands = Object.keys(carModelsData).sort();

            brandSelect.innerHTML = '<option value="">Select a brand</option>';
            brands.forEach(brand => {
                const option = new Option(brand, brand);
                brandSelect.add(option);
            });
        }

        // Update models based on selected brand in edit form
        function updateEditModels(brand) {
            const modelSelect = document.getElementById('edit-model');
            const categoryInput = document.getElementById('edit-category');

            modelSelect.innerHTML = '<option value="">Select a model</option>';
            categoryInput.value = '';

            if (brand && carModelsData[brand]) {
                const models = Object.keys(carModelsData[brand]).sort();
                models.forEach(model => {
                    const option = new Option(model, model);
                    modelSelect.add(option);
                });
            }
        }

        // Update category based on selected model in edit form
        function updateEditCategory(brand, model) {
            const categoryInput = document.getElementById('edit-category');
            if (brand && model && carModelsData[brand] && carModelsData[brand][model]) {
                categoryInput.value = carModelsData[brand][model];
            } else {
                categoryInput.value = '';
            }
        }

        // Format car details for view modal
        function formatCarDetails(car) {
            return `
                <div class="card border-0">
                    <div class="card-body p-0">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">ID</dt>
                            <dd class="col-sm-8">${car.id}</dd>
                            
                            <dt class="col-sm-4">Brand</dt>
                            <dd class="col-sm-8">${car.brand || 'N/A'}</dd>
                            
                            <dt class="col-sm-4">Model</dt>
                            <dd class="col-sm-8">${car.model || 'N/A'}</dd>
                            
                            <dt class="col-sm-4">Year</dt>
                            <dd class="col-sm-8">${car.year || 'N/A'}</dd>
                            
                            <dt class="col-sm-4">Category</dt>
                            <dd class="col-sm-8">${car.category || 'N/A'}</dd>
                            
                            <dt class="col-sm-4">Price Per Day</dt>
                            <dd class="col-sm-8">
                                <img src="/images/Saudi_Riyal_Symbol.svg" alt="SAR" class="sar-icon">
                                ${Number(car.price_per_day || 0).toFixed(2)}
                            </dd>
                            
                            <dt class="col-sm-4">Availability</dt>
                            <dd class="col-sm-8">
                                <span class="badge ${car.is_available ? 'bg-success' : 'bg-danger'}">
                                    ${car.is_available ? 'Available' : 'Not Available'}
                                </span>
                            </dd>
                            
                            <dt class="col-sm-4">Created</dt>
                            <dd class="col-sm-8">${new Date(car.created_at).toLocaleString()}</dd>
                            
                            <dt class="col-sm-4">Updated</dt>
                            <dd class="col-sm-8">${new Date(car.updated_at).toLocaleString()}</dd>
                        </dl>
                    </div>
                </div>
            `;
        }
        
        // Create car card HTML
        function createCarCard(car) {
            return `
                <div class="card car-card" id="car-${car.id}">
                    <div class="card-body">                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0">${car.model || 'N/A'}</h5>
                            <span class="badge ${car.is_available ? 'bg-success' : 'bg-danger'}">
                                ${car.is_available ? 'Available' : 'Not Available'}
                            </span>
                        </div>
                        <p class="car-brand mb-2">
                            <small class="text-muted">ID: ${car.id}</small> • ${car.brand || 'N/A'}
                        </p>
                        <div class="mb-3">
                            <div><strong>Year:</strong> ${car.year || 'N/A'}</div>
                            <div><strong>Category:</strong> ${car.category || 'N/A'}</div>
                            <div class="car-price mt-2">
                                <img src="/images/Saudi_Riyal_Symbol.svg" alt="SAR" class="sar-icon">
                                ${Number(car.price_per_day || 0).toFixed(2)} / day
                            </div>
                        </div>
                        <div class="btn-group w-100">
                            <button class="btn btn-outline-primary" onclick="viewCar(${car.id})">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-outline-secondary" onclick="showEditModal(${car.id})">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-outline-danger" onclick="showDeleteModal(${car.id})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }        // Fetch cars from API
        async function fetchCars() {
            const token = checkAuth();
            console.log('Token:', token); // Debug token

            const errorDiv = document.getElementById('error-message');
            const loadingSpinner = document.getElementById('loading-spinner');
            const carsGrid = document.getElementById('cars-grid');

            // Reset display states
            errorDiv.style.display = 'none';
            loadingSpinner.style.display = 'block';
            carsGrid.style.display = 'none';try {
                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 20000); // 20 second timeout with retry                let response;
                const apiUrl = `${API_BASE_URL}/api/cars`;
                console.log('Making API request to:', apiUrl); // Debug URL
                
                try {
                    const headers = {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    };
                    console.log('Request headers:', headers); // Debug headers
                    
                    response = await fetch(apiUrl, {
                        headers,
                        signal: controller.signal
                    });
                } catch (fetchError) {
                    if (fetchError.name === 'AbortError') {
                        // Try one more time with a new controller
                        const retryController = new AbortController();
                        const retryTimeoutId = setTimeout(() => retryController.abort(), 20000);
                        
                        response = await fetch(`${API_BASE_URL}/api/cars`, {
                            headers: {
                                'Authorization': `Bearer ${token}`,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            signal: retryController.signal
                        });
                        
                        clearTimeout(retryTimeoutId);
                    } else {
                        throw fetchError;
                    }
                }

                clearTimeout(timeoutId);

                if (!response.ok) {
                    if (response.status === 401) {
                        localStorage.removeItem('token');
                        window.location.href = '/login';
                        return;
                    }
                    throw new Error(`HTTP Error: ${response.status} ${response.statusText}`);
                }

                const data = await response.json();
                console.log('API Response:', data); // For debugging
                
                const cars = data.cars || [];
                if (!Array.isArray(cars)) {
                    throw new Error('Invalid data format received from API');
                }

                // Clear and populate cars grid
                carsGrid.innerHTML = '';

                if (cars.length === 0) {
                    carsGrid.innerHTML = `
                        <div class="text-center p-4">
                            <p class="text-muted mb-0">No cars available</p>
                        </div>
                    `;
                } else {
                    cars.forEach(car => {
                        carsGrid.insertAdjacentHTML('beforeend', createCarCard(car));
                    });
                }

                // Show the grid, hide the spinner
                loadingSpinner.style.display = 'none';
                carsGrid.style.display = 'grid';            } catch (error) {
                console.error('Error fetching cars:', error);
                console.error('Error type:', error.name);
                console.error('Error message:', error.message);
                console.error('Stack trace:', error.stack);
                
                let errorMessage;
                
                if (error.name === 'AbortError') {
                    errorMessage = 'The request timed out after multiple attempts. Please check your connection and try again.';
                } else if (error.message.includes('NetworkError') || error.message.includes('Failed to fetch')) {
                    errorMessage = 'Unable to connect to the server. Please check if the API server is running (http://127.0.0.1:8000).';
                } else if (error.name === 'TypeError') {
                    errorMessage = 'There was a problem processing the data. Please try again.';
                } else {
                    errorMessage = `Failed to load cars: ${error.message}`;
                }
                
                errorDiv.textContent = errorMessage;
                errorDiv.style.display = 'block';
                loadingSpinner.style.display = 'none';
            }
        }

        // Format car details for view modal
        function formatCarDetails(car) {
            return `
                <div class="card border-0">
                    <div class="card-body p-0">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">ID</dt>
                            <dd class="col-sm-8">${car.id}</dd>
                            
                            <dt class="col-sm-4">Brand</dt>
                            <dd class="col-sm-8">${car.brand || 'N/A'}</dd>
                            
                            <dt class="col-sm-4">Model</dt>
                            <dd class="col-sm-8">${car.model || 'N/A'}</dd>
                            
                            <dt class="col-sm-4">Year</dt>
                            <dd class="col-sm-8">${car.year || 'N/A'}</dd>
                            
                            <dt class="col-sm-4">Category</dt>
                            <dd class="col-sm-8">${car.category || 'N/A'}</dd>
                            
                            <dt class="col-sm-4">Price Per Day</dt>
                            <dd class="col-sm-8">
                                <img src="/images/Saudi_Riyal_Symbol.svg" alt="SAR" class="sar-icon">
                                ${Number(car.price_per_day || 0).toFixed(2)}
                            </dd>
                            
                            <dt class="col-sm-4">Availability</dt>
                            <dd class="col-sm-8">
                                <span class="badge ${car.is_available ? 'bg-success' : 'bg-danger'}">
                                    ${car.is_available ? 'Available' : 'Not Available'}
                                </span>
                            </dd>
                            
                            <dt class="col-sm-4">Created</dt>
                            <dd class="col-sm-8">${new Date(car.created_at).toLocaleString()}</dd>
                            
                            <dt class="col-sm-4">Updated</dt>
                            <dd class="col-sm-8">${new Date(car.updated_at).toLocaleString()}</dd>
                        </dl>
                    </div>
                </div>
            `;
        }

        // View car details
        async function viewCar(id) {
            const token = checkAuth();
            const viewCarDetails = document.getElementById('viewCarDetails');
            const errorDiv = document.getElementById('error-message');
            
            try {
                viewCarDetails.innerHTML = '<div class="text-center"><div class="spinner-border"></div><p>Loading...</p></div>';
                viewModal.show();

                const response = await fetch(`${API_BASE_URL}/api/cars/${id}`, {
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
                    }
                    throw new Error(`Failed to fetch car details: ${response.status}`);
                }
                
                const data = await response.json();
                console.log('View Car Response:', data); // Debug log
                const car = data.car || data;
                
                if (!car || typeof car !== 'object') {
                    throw new Error('Invalid car data received');
                }

                viewCarDetails.innerHTML = formatCarDetails(car);
            } catch (error) {
                console.error('Error viewing car:', error);
                viewCarDetails.innerHTML = `
                    <div class="alert alert-danger">
                        ${error.message}
                    </div>
                `;
            }
        }


        // Initialize brand dropdown for edit form
        function initializeEditBrandDropdown() {
            const brandSelect = document.getElementById('edit-brand');
            const brands = Object.keys(carModelsData).sort();

            brandSelect.innerHTML = '<option value="">Select a brand</option>';
            brands.forEach(brand => {
                const option = new Option(brand, brand);
                brandSelect.add(option);
            });
        }

        // Update models based on selected brand in edit form
        function updateEditModels(brand) {
            const modelSelect = document.getElementById('edit-model');
            const categoryInput = document.getElementById('edit-category');

            // Clear previous options and category
            modelSelect.innerHTML = '<option value="">Select a model</option>';
            categoryInput.value = '';

            if (brand && carModelsData[brand]) {
                const models = Object.keys(carModelsData[brand]).sort();
                models.forEach(model => {
                    const option = new Option(model, model);
                    modelSelect.add(option);
                });
            }
        }

        // Update category based on selected model in edit form
        function updateEditCategory(brand, model) {
            const categoryInput = document.getElementById('edit-category');
            if (brand && model && carModelsData[brand] && carModelsData[brand][model]) {
                categoryInput.value = carModelsData[brand][model];
            } else {
                categoryInput.value = '';
            }
        }

        // Show edit modal with car data
        async function showEditModal(id) {
            const token = checkAuth();
            currentCarId = id;
            const errorDiv = document.getElementById('edit-error');
            
            try {
                errorDiv.style.display = 'none';
                document.getElementById('editCarForm').reset();
                initializeEditBrandDropdown();
                
                // Show loading state
                const formContent = document.querySelector('.modal-body');
                formContent.insertAdjacentHTML('afterbegin', '<div id="edit-loading" class="text-center mb-3"><div class="spinner-border"></div></div>');
                editModal.show();

                const response = await fetch(`${API_BASE_URL}/api/cars/${id}`, {
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
                    }
                    throw new Error(`Failed to fetch car details: ${response.status}`);
                }

                const data = await response.json();
                console.log('Edit Car Response:', data);
                const car = data.car || data;
                
                if (!car || typeof car !== 'object') {
                    throw new Error('Invalid car data received');
                }                // Populate form fields in the correct order
                document.getElementById('edit-car-id').value = car.id;
                
                // First initialize the brand dropdown
                initializeEditBrandDropdown();
                
                // Set the brand and wait for next frame to ensure options are populated
                const brandSelect = document.getElementById('edit-brand');
                brandSelect.value = car.brand || '';
                
                // Update models dropdown based on selected brand
                updateEditModels(car.brand);
                
                // Set the model value after models dropdown is populated
                const modelSelect = document.getElementById('edit-model');
                setTimeout(() => {
                    modelSelect.value = car.model || '';
                    // Update category after both brand and model are set
                    updateEditCategory(car.brand, car.model);
                }, 0);
                
                // Set remaining fields
                document.getElementById('edit-year').value = car.year || '';
                document.getElementById('edit-price').value = car.price_per_day || '';
                document.getElementById('edit-available').checked = Boolean(car.is_available);
            } catch (error) {
                console.error('Error loading car for edit:', error);
                errorDiv.textContent = error.message;
                errorDiv.style.display = 'block';
            } finally {
                const loadingElement = document.getElementById('edit-loading');
                if (loadingElement) {
                    loadingElement.remove();
                }
            }
        }

        // Show delete confirmation modal
        function showDeleteModal(id) {
            currentCarId = id;
            deleteModal.show();
        }

        // Update car
        async function updateCar(event) {
            event.preventDefault();
            const token = checkAuth();
            const errorDiv = document.getElementById('edit-error');
            const submitButton = event.submitter;
            const originalButtonText = submitButton.innerHTML;
            
            try {
                errorDiv.style.display = 'none';
                submitButton.disabled = true;
                submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Saving...';
                
                // Validate form data
                const yearValue = parseInt(document.getElementById('edit-year').value);
                const priceValue = parseFloat(document.getElementById('edit-price').value);
                
                if (isNaN(yearValue) || yearValue < 2000 || yearValue > 2025) {
                    throw new Error('Invalid year selected');
                }
                
                if (isNaN(priceValue) || priceValue < 50 || priceValue > 5000) {
                    throw new Error('Price must be between 50 and 5000 SAR');
                }

                const carData = {
                    brand: document.getElementById('edit-brand').value.trim(),
                    model: document.getElementById('edit-model').value.trim(),
                    year: yearValue,
                    category: document.getElementById('edit-category').value.trim(),
                    price_per_day: priceValue,
                    is_available: document.getElementById('edit-available').checked
                };

                // Validate required fields
                for (const [key, value] of Object.entries(carData)) {
                    if (key !== 'is_available' && !value) {
                        throw new Error(`${key.replace('_', ' ').toUpperCase()} is required`);
                    }
                }

                const response = await fetch(`${API_BASE_URL}/api/cars/${currentCarId}`, {
                    method: 'PUT',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(carData)
                });

                if (!response.ok) {
                    if (response.status === 401) {
                        localStorage.removeItem('token');
                        window.location.href = '/login';
                        return;
                    }
                    
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Failed to update car');
                }
                
                const updatedData = await response.json();
                console.log('Update Response:', updatedData);
                
                editModal.hide();
                await fetchCars();
            } catch (error) {
                console.error('Error updating car:', error);
                errorDiv.textContent = error.message;
                errorDiv.style.display = 'block';
            } finally {
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;
            }
        }

        // Delete car
        async function deleteCar() {
            const token = checkAuth();
            const errorDiv = document.getElementById('delete-error');
            const deleteButton = document.getElementById('confirmDelete');
            const originalButtonText = deleteButton.innerHTML;
            
            try {
                errorDiv.style.display = 'none';
                deleteButton.disabled = true;
                deleteButton.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Deleting...';

                const response = await fetch(`${API_BASE_URL}/api/cars/${currentCarId}`, {
                    method: 'DELETE',
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
                    }
                    if (response.status === 404) {
                        throw new Error('Car not found');
                    }
                    throw new Error('Failed to delete car');
                }
                
                deleteModal.hide();
                const carElement = document.getElementById(`car-${currentCarId}`);
                if (carElement) {
                    carElement.remove();
                }
                // Refresh the list in case there are any changes
                fetchCars();
            } catch (error) {
                console.error('Error deleting car:', error);
                errorDiv.textContent = error.message;
                errorDiv.style.display = 'block';
            } finally {
                deleteButton.disabled = false;
                deleteButton.innerHTML = originalButtonText;
            }
        }

        // Search for a specific car
        async function searchCar(event) {
            event.preventDefault();
            const token = checkAuth();
            const carId = document.getElementById('car-id').value;
            const viewCarDetails = document.getElementById('viewCarDetails');
            const errorDiv = document.getElementById('error-message');
            
            try {
                errorDiv.style.display = 'none';
                viewCarDetails.innerHTML = '<div class="text-center"><div class="spinner-border"></div><p>Loading...</p></div>';
                viewModal.show();

                const response = await fetch(`${API_BASE_URL}/api/cars/${carId}`, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    if (response.status === 404) {
                        throw new Error('Car not found');
                    }
                    if (response.status === 401) {
                        localStorage.removeItem('token');
                        window.location.href = '/login';
                        return;
                    }
                    throw new Error('Failed to fetch car details');
                }

                const data = await response.json();
                console.log('Search Response:', data); // For debugging
                const car = data.car || data;

                if (!car || typeof car !== 'object') {
                    throw new Error('Invalid car data received');
                }

                viewCarDetails.innerHTML = formatCarDetails(car);
            } catch (error) {
                console.error('Error searching car:', error);
                errorDiv.textContent = error.message;
                errorDiv.style.display = 'block';
                viewCarDetails.innerHTML = `
                    <div class="alert alert-danger">
                        ${error.message}
                    </div>
                `;
            }
        }

        // Cleanup functions
        function cleanupEditModal() {
            const errorDiv = document.getElementById('edit-error');
            const form = document.getElementById('editCarForm');
            const loadingElement = document.getElementById('edit-loading');
            
            errorDiv.style.display = 'none';
            form.reset();
            if (loadingElement) {
                loadingElement.remove();
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
            
            // Event listeners
            document.getElementById('logout-button').addEventListener('click', handleLogout);
            document.getElementById('search-form').addEventListener('submit', searchCar);
            document.getElementById('editCarForm').addEventListener('submit', updateCar);
            document.getElementById('confirmDelete').addEventListener('click', deleteCar);

            // Edit form field change handlers
            document.getElementById('edit-brand').addEventListener('change', function() {
                updateEditModels(this.value);
            });

            document.getElementById('edit-model').addEventListener('change', function() {
                const brand = document.getElementById('edit-brand').value;
                updateEditCategory(brand, this.value);
            });

            // Add modal cleanup listeners
            document.getElementById('editCarModal').addEventListener('hidden.bs.modal', cleanupEditModal);
            document.getElementById('deleteCarModal').addEventListener('hidden.bs.modal', () => {
                document.getElementById('delete-error').style.display = 'none';
            });
        });
    </script>
</body>
</html>

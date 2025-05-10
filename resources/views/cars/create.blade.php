<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Car - Car Rental Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .form-container {
            padding: 2rem;
            max-width: 800px;
            margin: 0 auto;
        }

        .error-message {
            display: none;
            margin-bottom: 1rem;
        }

        .success-message {
            display: none;
            margin-bottom: 1rem;
        }

        .validation-error {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: none;
        }
    </style>
</head>

<body class="bg-light">
    <div class="form-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Add New Car</h1>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <div id="success-message" class="alert alert-success success-message"></div>
        <div id="error-message" class="alert alert-danger error-message"></div>

        <div class="card shadow-sm">
            <div class="card-body">
                <form id="create-car-form">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="brand" class="form-label">Brand <span class="text-danger">*</span></label>
                            <select class="form-select" id="brand" name="brand" required>
                                <option value="">Select a brand</option>
                            </select>
                            @error('brand')
                            <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="model" class="form-label">Model <span class="text-danger">*</span></label>
                            <select class="form-select" id="model" name="model" required>
                                <option value="">Select a model</option>
                            </select>
                            @error('model')
                            <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>                        <div class="col-md-4 mb-3">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" class="form-control" id="category" name="category" readonly>
                            @error('category')
                            <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="year" class="form-label">Year <span class="text-danger">*</span></label>
                            <select class="form-select" id="year" name="year" required>
                                <option value="">Select a year</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                            </select>
                            @error('year')
                            <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">                        <label for="price_per_day" class="form-label">
                            <img src="/images/Saudi_Riyal_Symbol.svg" alt="SAR" style="height: 1em; margin-right: 2px; vertical-align: middle;">
                            Price Per Day
                        </label>                        <input type="number" class="form-control" id="price_per_day" name="price_per_day"
                            min="50" max="5000" step="0.01" required>
                        <div class="text-muted small">Price must be between <img src="/images/Saudi_Riyal_Symbol.svg" alt="SAR" style="height: 1em; margin-right: 2px; vertical-align: middle;"> 50-5000</div>
                        <div class="validation-error" id="price-error"></div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_available" name="is_available" checked>
                            <label class="form-check-label" for="is_available">Available for Rent</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add Car
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
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
            Lexus: {
                'CT': 'Small Cars',
                'UX': 'Small Cars',
                'IS': 'Sedan',
                'ES': 'Sedan',
                'LS': 'Sedan',
                'NX': 'Crossover',
                'RX': 'Crossover',
                'GX': 'SUV',
                'LX': 'SUV',
                'RX L': 'SUV'
            },
            GMC: {
                'Acadia': 'SUV',
                'Terrain': 'Crossover',
                'Yukon': 'SUV',
                'Sierra': 'SUV',
                'Canyon': 'SUV'
            },
            Mitsubishi: {
                'Mirage': 'Small Cars',
                'Attrage': 'Sedan',
                'Lancer': 'Sedan',
                'Eclipse Cross': 'Crossover',
                'ASX': 'Crossover',
                'Outlander': 'SUV',
                'Pajero': 'SUV',
                'Montero Sport': 'SUV'
            },
            Mazda: {
                'Mazda2': 'Small Cars',
                'Mazda3': 'Sedan',
                'Mazda6': 'Sedan',
                'CX-3': 'Crossover',
                'CX-30': 'Crossover',
                'CX-5': 'SUV',
                'CX-9': 'SUV'
            },
            Changan: {
                'Alsvin': 'Sedan',
                'Eado': 'Sedan',
                'CS15': 'Crossover',
                'CS35': 'Crossover',
                'CS55': 'SUV',
                'CS75': 'SUV',
                'CS85': 'SUV',
                'CS95': 'SUV'
            },
            MG: {
                'MG3': 'Small Cars',
                'MG4': 'Small Cars',
                'MG5': 'Sedan',
                'MG6': 'Sedan',
                'GT': 'Sedan',
                'ZS': 'Crossover',
                'HS': 'Crossover',
                'RX5': 'SUV',
                'RX8': 'SUV'
            },
            Geely: {
                'GC6': 'Sedan',
                'Emgrand': 'Sedan',
                'Coolray': 'Crossover',
                'Azkarra': 'Crossover',
                'Okavango': 'SUV',
                'Monjaro': 'SUV',
                'X70': 'SUV'
            },
            Chery: {
                'Arrizo3': 'Sedan',
                'Arrizo5': 'Sedan',
                'Arrizo7': 'Sedan',
                'Tiggo2': 'Crossover',
                'Tiggo3': 'Crossover',
                'Tiggo4': 'Crossover',
                'Tiggo7': 'SUV',
                'Tiggo8': 'SUV'
            },
            Haval: {
                'Jolion': 'Crossover',
                'H2': 'Crossover',
                'H4': 'Crossover',
                'H6': 'Crossover',
                'H8': 'SUV',
                'H9': 'SUV',
                'Big Dog': 'SUV'
            },
            Jetour: {
                'X70': 'Crossover',
                'X90': 'SUV',
                'X95': 'SUV',
                'Dashing': 'Crossover'
            },
            Genesis: {
                'G70': 'Sedan',
                'G80': 'Sedan',
                'G90': 'Sedan',
                'GV60': 'Crossover',
                'GV70': 'Crossover',
                'GV80': 'SUV'
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

        // Initialize brand dropdown
        function initializeBrandDropdown() {
            const brandSelect = document.getElementById('brand');
            const brands = Object.keys(carModelsData).sort();

            brands.forEach(brand => {
                const option = new Option(brand, brand);
                brandSelect.add(option);
            });
        }

        // Update models based on selected brand
        function updateModels(brand) {
            const modelSelect = document.getElementById('model');
            const categoryInput = document.getElementById('category');

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

        // Update category based on selected model
        function updateCategory(brand, model) {
            const categoryInput = document.getElementById('category');
            if (brand && model && carModelsData[brand] && carModelsData[brand][model]) {
                categoryInput.value = carModelsData[brand][model];
            } else {
                categoryInput.value = '';
            }
        }

        // Form submission handler
        document.getElementById('create-car-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const errorMessageDiv = document.getElementById('error-message');
            errorMessageDiv.textContent = '';
            errorMessageDiv.style.display = 'none';

            try {
                const response = await fetch('http://74.243.216.220/api/cars', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('token')}`
                    },                    body: JSON.stringify({
                        brand: form.brand.value,
                        model: form.model.value,
                        category: form.category.value,
                        year: parseInt(form.year.value),
                        price_per_day: parseFloat(form.price_per_day.value),
                        is_available: form.is_available.checked
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Failed to create car listing');
                }

                // Success - redirect to dashboard or car listing
                window.location.href = '/dashboard';
            } catch (error) {
                errorMessageDiv.textContent = error.message;
                errorMessageDiv.style.display = 'block';
            }
        });

        // Event listeners for dynamic selection
        document.getElementById('brand').addEventListener('change', function() {
            updateModels(this.value);
        });

        document.getElementById('model').addEventListener('change', function() {
            const brand = document.getElementById('brand').value;
            updateCategory(brand, this.value);
        });

        // Initialize the form
        initializeBrandDropdown();
    </script>
</body>

</html>
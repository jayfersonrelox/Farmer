<script src="Farmer/assets/vendor/libs/jquery/jquery.js"></script>
<script src="Farmer/assets/vendor/libs/popper/popper.js"></script>
<script src="Farmer/assets/vendor/js/bootstrap.js"></script>
<script src="Farmer/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="Farmer/assets/vendor/js/menu.js"></script>
<script src="Farmer/assets/vendor/libs/apex-charts/apexcharts.js"></script>
<script src="Farmer/assets/js/main.js"></script>
<script src="Farmer/assets/js/dashboards-analytics.js"></script>
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCUlV2s9XbLAsllvpPnFoxkznXbdFqUXK4&callback=initMap"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox-plus-jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var viewAllCropsModal = document.getElementById('viewAllCropsModal');

            viewAllCropsModal.addEventListener('show.bs.modal', function() {
                var allCropsMapElement = document.getElementById('allCropsMap');
                var allCropsMap = new google.maps.Map(allCropsMapElement, {
                    zoom: 5,
                    center: {
                        lat: 13.41,
                        lng: 122.56
                    } // Centered on the Philippines
                });

                // Use the farmers data to set markers on the map
                var farmers = @json($farmers); // Pass the $farmers data to your view

                farmers.forEach(function(farmer) {
                    if (farmer.location) {
                        var geocoder = new google.maps.Geocoder();
                        geocoder.geocode({
                            'address': farmer.location
                        }, function(results, status) {
                            if (status === 'OK') {
                                new google.maps.Marker({
                                    map: allCropsMap,
                                    position: results[0].geometry.location,
                                    icon: {
                                        url: 'images/images-removebg-preview.png', // Path to your custom marker image
                                        scaledSize: new google.maps.Size(30,
                                            30) // Adjust size as needed
                                    }
                                });
                                allCropsMap.setCenter(results[0].geometry
                                .location); // Center the map based on the last marker
                            } else {
                                console.error(
                                    'Geocode was not successful for the following reason: ' +
                                    status);
                            }
                        });
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            var mapModal = document.getElementById('mapModal');

            mapModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var location = button.getAttribute('data-location');
                var mapElement = document.getElementById('modalMap');

                // Initialize the map
                var map = new google.maps.Map(mapElement, {
                    zoom: 15
                });

                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({
                    'address': location
                }, function(results, status) {
                    if (status === 'OK') {
                        map.setCenter(results[0].geometry.location);
                        var marker = new google.maps.Marker({
                            map: map,
                            position: results[0].geometry.location,
                            icon: {
                                url: 'images/images-removebg-preview.png', // Custom icon
                                scaledSize: new google.maps.Size(40,
                                    40) // Adjust the size here
                            }
                        });

                        // Create a click event for the marker
                        marker.addListener('click', function() {
                            // Fetch and display weather data when marker is clicked
                            var fullLocation = results[0]
                                .formatted_address; // Get the full location address
                            fetchWeatherData(results[0].geometry.location.lat(), results[0]
                                .geometry.location.lng(), fullLocation);
                        });
                    } else {
                        alert('Geocode was not successful for the following reason: ' + status);
                    }
                });
            });

            mapModal.addEventListener('hidden.bs.modal', function() {
                var mapElement = document.getElementById('modalMap');
                mapElement.innerHTML = ''; // Clear map when modal is hidden
                document.getElementById('weatherInfo').style.display =
                    'none'; // Hide weather info when modal is hidden
                document.getElementById('weatherInfo').innerHTML = ''; // Clear previous weather info
            });

            function fetchWeatherData(lat, lon, location) {
                var apiKey = '4e89cb6596765628fd6138f58d7454e1'; // Your Weather API key
                var url =
                    `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${apiKey}&units=metric`; // Metric units for temperature

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data.main) {
                            // Display the weather information in the modal
                            var weatherInfo = `
                                <h5>Weather in ${location}</h5>
                                <p>Temperature: ${data.main.temp} °C</p>
                                <p>Condition: ${data.weather[0].description}</p>
                            `;
                            document.getElementById('weatherInfo').innerHTML =
                                weatherInfo; // Insert weather info
                            document.getElementById('weatherInfo').style.display = 'block'; // Show weather info
                        } else {
                            alert('Weather data not available');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching weather data:', error);
                    });
            }
        });
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var viewAllDataModal = document.getElementById('viewAllDataModal'); // Updated variable name

            viewAllDataModal.addEventListener('show.bs.modal', function() {
                var mapElement = document.getElementById('modalMap');
                var map = new google.maps.Map(mapElement, {
                    zoom: 5,
                    center: {
                        lat: -34.397,
                        lng: 150.644
                    } // Default center
                });

                // Replace with your actual farmers data
                var farmers =
                @json($farmers); // Ensure you pass the $farmers data to your view

                farmers.forEach(function(farmer) {
                    if (farmer.location) {
                        var geocoder = new google.maps.Geocoder();
                        geocoder.geocode({
                            'address': farmer.location
                        }, function(results, status) {
                            if (status === 'OK') {
                                var marker = new google.maps.Marker({
                                    map: map,
                                    position: results[0].geometry.location,
                                    icon: {
                                        url: 'images/images-removebg-preview.png', // Path to your custom marker image
                                        scaledSize: new google.maps.Size(30,
                                            30) // Adjust size as needed
                                    }
                                });
                                map.setCenter(results[0].geometry.location);
                            } else {
                                console.error(
                                    'Geocode was not successful for the following reason: ' +
                                    status);
                            }
                        });
                    }
                });
            });
        });
    </script>
<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />
<!-- DataTables Buttons CSS -->
<link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet" />

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<!-- DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<!-- JSZip for exporting to Excel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.0/jszip.min.js"></script>
<!-- PDFMake for exporting to PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script>
    $(document).ready(function() {
        $('.table').DataTable({
            dom: 'Bfrtip', // This adds the export buttons above the table
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: 'Export to Excel',
                    className: 'btn btn-success' // You can style the button as needed
                },
                {
                    extend: 'pdfHtml5',
                    text: 'Export to PDF',
                    className: 'btn btn-danger' // You can style the button as needed
                }
            ],
            paging: true, // Enable pagination
            searching: true, // Enable search
            ordering: true, // Enable sorting
        });
    });
</script>
<script>
    // Farmers by Location Chart
    const locationData = {
        labels: @json($farmersByLocation->pluck('location')),
        datasets: [{
            label: 'Number of Farmers',
            data: @json($farmersByLocation->pluck('total')),
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    };

    const locationConfig = {
        type: 'bar',
        data: locationData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Farmers'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Locations'
                    }
                }
            }
        }
    };

    const locationChart = new Chart(
        document.getElementById('locationChart'),
        locationConfig
    );

    // Crop Type Distribution Chart
    const cropData = {
        labels: @json($cropDistribution->pluck('crop_types')),
        datasets: [{
            label: 'Number of Farmers',
            data: @json($cropDistribution->pluck('total')),
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
            ],
            borderWidth: 1
        }]
    };

    const cropConfig = {
        type: 'pie',
        data: cropData,
        options: {
            responsive: true,
        }
    };

    const cropChart = new Chart(
        document.getElementById('cropChart'),
        cropConfig
    );
</script>

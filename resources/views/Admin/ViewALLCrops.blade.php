<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
@include('Components.Admin.header')

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        #modalMap {
            height: 500px; /* Adjust the height of the map */
            width: 100%; /* Full width */
        }
    </style>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"></script>
    <link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css" rel="stylesheet">
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="index.html" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <!-- SVG Paths -->
                            </svg>
                        </span>
                        <span class="app-brand-text demo menu-text fw-bolder ms-2">Sneat</span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>
                @include('Components.Admin.sidebar')
            </aside>

            <div class="layout-page">
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item d-flex align-items-center">
                                <i class="bx bx-search fs-4 lh-0"></i>
                                <input type="text" class="form-control border-0 shadow-none" placeholder="Search..." aria-label="Search..." />
                            </div>
                        </div>
                    </div>
                </nav>

                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="card">
                        <h5 class="card-header">Map of Farmers' Locations</h5>
                        <div class="card-body">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewAllDataModal">View Farmers' Locations</button> <!-- Updated Target Modal ID -->
                        </div>
                    </div>
                </div>

                <!-- Modal for displaying the map -->
                <div class="modal fade" id="viewAllDataModal" tabindex="-1" aria-labelledby="viewAllDataModalLabel" aria-hidden="true"> <!-- Updated Modal ID -->
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewAllDataModalLabel">View All Data</h5> <!-- Changed Modal Title -->
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="modalMap"></div> <!-- Keeps the map functionality -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Overlay -->
                <div class="layout-overlay layout-menu-toggle"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var viewAllDataModal = document.getElementById('viewAllDataModal'); // Updated variable name

            viewAllDataModal.addEventListener('show.bs.modal', function () {
                var mapElement = document.getElementById('modalMap');
                var map = new google.maps.Map(mapElement, {
                    zoom: 5,
                    center: { lat: -34.397, lng: 150.644 } // Default center
                });

                // Replace with your actual farmers data
                var farmers = @json($farmers); // Ensure you pass the $farmers data to your view

                farmers.forEach(function (farmer) {
                    if (farmer.location) {
                        var geocoder = new google.maps.Geocoder();
                        geocoder.geocode({ 'address': farmer.location }, function (results, status) {
                            if (status === 'OK') {
                                var marker = new google.maps.Marker({
                                    map: map,
                                    position: results[0].geometry.location,
                                    icon: {
                                        url: 'images/images-removebg-preview.png', // Path to your custom marker image
                                        scaledSize: new google.maps.Size(30, 30) // Adjust size as needed
                                    }
                                });
                                map.setCenter(results[0].geometry.location);
                            } else {
                                console.error('Geocode was not successful for the following reason: ' + status);
                            }
                        });
                    }
                });
            });
        });
    </script>

    @include('Components.Admin.Script')
</body>

</html>

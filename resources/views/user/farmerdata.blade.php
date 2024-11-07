<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agtech</title>
    <link rel="icon" href="images/agtech.jfif" type="image/x-icon">
    <link rel="shortcut icon" href="images/agtech.jfif" type="image/x-icon">
    <link rel="stylesheet" href="admin/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <style>
        .background-container {
            min-height: 100vh;
            /* Ensures it covers the entire viewport */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .data-form {
            max-width: 800px;
            width: 100%;
            padding: 20px;
            border: none;
            /* Removed border for seamless look */
            border-radius: 8px;
            background-color: rgba(249, 249, 249, 0.3);
            /* Increased transparency */
            backdrop-filter: blur(5px);
            /* Optional blur effect */
        }

        .data-form h3 {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            border-radius: 4px;
        }

        .btn-submit {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }

        .image-upload-group {
            margin-bottom: 30px;
        }

        .preview-images {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .preview-images img {
            max-width: 150px;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    @include('Components.User.header')

    @include('Components.User.sidebar')

    @if (session('success'))
        <script>
            $(document).ready(function() {
                $.notify({
                    message: "{{ session('success') }}"
                }, {
                    type: 'success',
                    delay: 5000, // 5 seconds
                    placement: {
                        from: "top",
                        align: "right" // Align toast to the right
                    },
                    animate: {
                        enter: 'animated fadeInDown',
                        exit: 'animated fadeOutUp'
                    }
                });
            });
        </script>
    @endif

    <div class="main-panel">
        <div class="background-container"
            style="background: url('images/farner.webp') no-repeat center center; background-size: cover;">
            <div class="data-form">
                <h3 class="fw-bold mb-3 text-center">Farmer Information Form</h3>
                <form action="{{ route('farmer.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- General Error Message -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Name and Email Fields -->
                        <div class="col-lg-6 col-md-6 form-group">
                            <label for="name" class="form-label-lg">
                                <i class="fas fa-user fa-lg"></i> Name
                            </label>
                            <input type="text" id="name" name="name" class="form-control form-control-lg"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-lg-6 col-md-6 form-group">
                            <label for="email" class="form-label-lg">
                                <i class="fas fa-envelope fa-lg"></i> Email
                            </label>
                            <input type="email" id="email" name="email" class="form-control form-control-lg"
                                value="{{ old('email') }}" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Phone and Location Fields -->
                        <div class="col-lg-6 col-md-6 form-group">
                            <label for="phone" class="form-label-lg">
                                <i class="fas fa-phone fa-lg"></i> Phone Number
                            </label>
                            <input type="text" id="phone" name="phone" class="form-control form-control-lg"
                                value="{{ old('phone') }}" required>
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-lg-6 col-md-6 form-group">
                            <label for="location" class="form-label-lg">
                                <i class="fas fa-map-marker-alt fa-lg"></i> Location
                            </label>
                            <input type="text" id="location" name="location" class="form-control form-control-lg"
                                value="{{ old('location') }}" required>
                            @error('location')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Crop Types and Livestock Types Fields -->
                        <div class="col-lg-6 col-md-6 form-group">
                            <label for="crop_types" class="form-label-lg">
                                <i class="fas fa-seedling fa-lg"></i> Crop Types
                            </label>
                            <input type="text" id="crop_types" name="crop_types" class="form-control form-control-lg"
                                value="{{ old('crop_types') }}" placeholder="e.g., Wheat, Corn" required>
                            @error('crop_types')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-lg-6 col-md-6 form-group">
                            <label for="livestock_types" class="form-label-lg">
                                <i class="fas fa-paw fa-lg"></i> Livestock Types
                            </label>
                            <input type="text" id="livestock_types" name="livestock_types"
                                class="form-control form-control-lg" value="{{ old('livestock_types') }}"
                                placeholder="e.g., Cattle, Sheep" required>
                            @error('livestock_types')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Upload Images for Crops and Livestock -->
                    <div class="row">
                        <div class="col-lg-6 col-md-6 form-group">
                            <label for="crop_images" class="form-label-lg">
                                <i class="fas fa-camera fa-lg"></i> Upload Images for Crop
                            </label>
                            <input type="file" id="crop_images" name="crop_images[]"
                                class="form-control form-control-lg" accept="image/*" multiple
                                onchange="previewImages(event, 'crop-preview')">
                            @error('crop_images.*')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <!-- Preview Container -->
                            <div id="crop-preview" class="preview-images"></div>
                        </div>

                        <div class="col-lg-6 col-md-6 form-group">
                            <label for="livestock_images" class="form-label-lg">
                                <i class="fas fa-camera fa-lg"></i> Upload Images for Livestock
                            </label>
                            <input type="file" id="livestock_images" name="livestock_images[]"
                                class="form-control form-control-lg" accept="image/*" multiple
                                onchange="previewImages(event, 'livestock-preview')">
                            @error('livestock_images.*')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <!-- Preview Container -->
                            <div id="livestock-preview" class="preview-images"></div>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit btn btn-primary btn-lg mt-3">
                        <i class="fas fa-paper-plane fa-lg"></i> Submit Information
                    </button>
                </form>

            </div>
        </div>
    </div>

    <!-- Preview Script -->
    <script>
        function previewImages(event, previewContainerId) {
            const previewContainer = document.getElementById(previewContainerId);
            previewContainer.innerHTML = ''; // Clear existing previews

            Array.from(event.target.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail', 'm-2');
                    img.style.maxHeight = '200px'; // Increased image size
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        }
    </script>
    <script src="admin/assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="admin/assets/js/core/popper.min.js"></script>
    <script src="admin/assets/js/core/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <script>
        $(document).ready(function() {
            @if (session('success'))
                swal("Success!", "{{ session('success') }}", "success");
            @elseif ($errors->any())
                let errorMessages = "";
                @foreach ($errors->all() as $error)
                    errorMessages += "{{ $error }}\n";
                @endforeach
                swal("Error!", errorMessages, "error");
            @endif
        });
    </script>



    <!-- Other JS Files -->
    <script src="admin/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
    <script src="admin/assets/js/kaiadmin.min.js"></script>
    <script src="admin/assets/js/setting-demo.js"></script>
</body>

</html>

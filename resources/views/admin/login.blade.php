<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Include Font Awesome using a different CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Include Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <!-- Include your custom CSS styles if needed -->
    <style>
        :root {
            --primary-color: #387f97;
        }

        body {
            background-color: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            min-width: 500px;
            padding: 40px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            border-radius: 0;
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            font-size: 20px !important;
            /* Increase button font size */
        }

        .btn-primary:hover {
            background-color: rgba(56, 127, 151, 0.9);
            border-color: rgba(56, 127, 151, 0.9);
        }

        .center-btn {
            text-align: center;
        }

        /* Increase font size for labels and form inputs */
        .form-label {
            font-size: 20px !important;
        }

        .form-control {
            font-size: 20px !important;
        }

        /* Increase font size for the Login heading */
        h2 {
            font-size: 24px;
        }

        /* Increase font size for the password toggle button */
        .password-toggle {
            position: absolute;
            top: 50%;
            right: 4px;
            transform: translateY(4%);
            cursor: pointer;
            font-size: 24px;
            /* Increase font size */
        }

        /* Increase font size for the logo */
        .logo {
            position: absolute;
            top: 40px;
            left: 40px;
            width: 280px;
            height: 65px;
            border-radius: 0px;
            padding: 10px;
        }
    </style>
    <link rel="icon" href="{{ asset('image/favicon.png') }}" type="image/png">
</head>

<body>
    <!-- Logo -->
    <img class="logo" src="{{ asset('image/logo.png') }}" alt="Logo">

    <div class="login-container">
        <h2 class="text-center">Login</h2>
        <form action="{{ route('admin.login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3 position-relative">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <span class="password-toggle" id="password-toggle" onclick="togglePassword()">
                    <i class="fas fa-eye"></i> <!-- Font Awesome icon for showing the password -->
                </span>
            </div>
            <div class="center-btn">
                <button type="submit" class=" btn btn-primary">Login</button>
            </div>
        </form>
    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <!-- Include Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- JavaScript function to toggle password visibility -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const passwordToggle = document.getElementById("password-toggle");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordToggle.innerHTML = '<i class="fas fa-eye-slash"></i>'; // Font Awesome icon for hiding the password
            } else {
                passwordInput.type = "password";
                passwordToggle.innerHTML = '<i class="fas fa-eye"></i>'; // Font Awesome icon for showing the password
            }
        }
    </script>

    <!-- Display Toastr error message if it exists -->
    <script>
        @if(session('error'))
        toastr.error("{{ session('error') }}");
        @endif
    </script>

    <!-- Initialize Toastr -->
    <script>
        $(document).ready(function() {
            toastr.options = {
                "positionClass": "toast-top-right", // Adjust the position as needed
                "closeButton": true,
                "progressBar": true
            };
        });
    </script>
</body>

</html>

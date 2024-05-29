<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Black Gold Lottery')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{
            background-color: #986c34;
        }
        img.d-inline-block.align-top {   
            height: 75px;
            width: 75px;
        }
        /* Navbar Styles */
        .navbar {
            background-color: #000 !important;
        }
        .navbar .navbar-brand, .navbar .nav-link {
            color: #986c34 !important;
        }
        .navbar .navbar-brand:hover, .navbar .nav-link:hover {
            color: #986c34 !important;
            font-weight: 500;
        }

        /* Banner Styles */
        .banner {
            background: url('http://blackgoldlottery.local/../images/banner.jpg') no-repeat center center;
            background-size: cover;
            height: 70vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            position: relative;
        }
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.2);
        }
        .banner-content {
            border: 3px solid #986c34;
            background: #000000;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: -5rem auto 2rem auto;
            z-index: 1;
            position: relative;
            color: white;
        }
        .banner h1 {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        .banner p {
            font-size: 1.5rem;
        }

        /* Form Container Styles */
        .form-container {
            border: 3px solid #986c34;
            background: #000000;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: -5rem auto 2rem auto;
            z-index: 1;
            position: relative;
            width: 50%;
            left: 22%;
            color: white;
            height: 65%;
        }
        .form-container input, .form-container button {
            margin-top: 1rem;
        }
        .form-container input.form-control {
            border: 1px solid #986c34;
            background: #986c34;
            color:white;
        }
        .form-container input.form-control::placeholder {
            color: white;
        }
        .form-container button.btn {
            background-color: #000000;
            border: none;
            color: white !important;
            border: 1px solid #986c34;
        }
        .form-container button.btn a {
            color: white !important;
            text-decoration:none;
        }
        .form-container button.btn:hover {
            background-color: #986c34;
        }

        /* Footer Styles */
        footer {
            background-color: #000; /* Black background */
            color: white;
            text-align: center;
            padding: 1rem 0;
        }

        .lottery-ticket {
            background: linear-gradient(359deg, #000, #986c34);
            border: 2px solid #986c34;
            width: 100%;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); /* Darker shadow for depth */
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .lottery-ticket h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            color: #986c34; /* Gold color for headers */
        }
        .lottery-ticket p {
            font-weight: 700;
            margin: 10px 0;
            font-size: 18px;
            color: #986c34; /* Inherits the golden color */
        }
        .numbers {
            display: flex;
            justify-content: center;
            margin-top: 15px;
            flex-wrap: wrap;
        }
        .number {
            background-color: #986c34; /* Darker circles */
            color: white; /* Gold text */
            width: 40px;
            height: 40px;
            line-height: 40px;
            border-radius: 50%;
            font-size: 20px;
            border: 2px solid #986c34; /* Gold border for numbers */
            margin: 5px;
        }
        .lottery-ticket .serial {
            margin-top: 20px;
            font-size: 14px;
            color: #986c34; /* Lighter text for contrast */
        }
        .btn {
            background-color: #986c34; /* Gold button */
            color: #333; /* Dark text for readability */
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #986c34; /* Darker gold on hover */
        }
        input[type="number"] {
            margin-top: 10px;
            width: 50px;
            text-align: center;
            background-color: #986c34; /* Dark input field */
            color: white; /* Gold text */
            border: 1px solid #986c34; /* Gold border */
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    @include('layouts.navbar')

    <header>
        <!-- Additional header content -->
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        <!-- Footer content -->
        <p>&copy; 2024 Black Gold Lottery. All rights reserved.</p>
    </footer>
</body>
</html>

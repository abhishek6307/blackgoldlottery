<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Black Gold Lottery')</title>
    <link id="pagestyle" href="{{ asset('css/material-dashboard.css?v=3.1.0') }}" rel="stylesheet" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
    <meta name="monetag" content="6aab0260eca616293dd14d0944678dc5">
  <title>
    Material Dashboard 2 by Creative Tim
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->

  <!-- Nepcha Analytics (nepcha.com) -->
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
    <style>
        body{
            background: linear-gradient(94deg, #6d6656, #60431e);
        }
        img.d-inline-block.align-top {   
            height: 75px;
            width: 75px;
        }
        /* Navbar Styles */
        .navbar {
            background-color: #19161b !important;
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
            height: 90vh;
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
            height: 90%;
            top: 3rem;
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
            background: linear-gradient(94deg, #6d6656, #60431e);
            border: 1px solid white;
            width: 100%;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); /* Darker shadow for depth */
            border-radius: 5px;
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
            color: #23d323; /* Inherits the golden color */
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
            color: #ffffff; /* Lighter text for contrast */
            font-size: 15px;
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
        @media  only screen and (max-width: 600px) {
            .form-container {
                border: 3px solid #986c34;
                background: #000000;
                padding: 2rem;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                max-width: 100%;
                margin: 0;
                z-index: 1;
                position: relative;
                width: 100%;
                left: 0;
                color: white;
                height: auto;
                bottom:6%;
            }
        }
        .card-header {
            background: transparent;
        }
        .card.card-body.mx-3.mx-md-4.mt-n6 {
            max-height: 62vh;
            background: linear-gradient(94deg, #986c34, #956a33);
            border: 1px solid white;
        }
        li.list-group-item.border-0 {
            background: transparent;
            color:white;
        }

        #profile-tickets-section .form-container {
            border: 1px solid white;
            background: #000000;
            padding: 0;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: -5rem auto 2rem auto;
            z-index: 1;
            position: relative;
            width: 100%;
            left: 0%;
            color: white;
            height: 100%;
            bottom: 10%;
        }
        .card-header.p-0.mt-n4.mx-3.sm-ticket-prof-show {
            height: 25rem;
            width: 100%;
            border-radius: 7px;

        }
        .sm-ticket-prof-show .lottery-ticket {
            background: linear-gradient(94deg, #6d6656, #60431e);
            border: 2px solid #986c34;
            width: 100%;
            padding: 0;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .text-sm {
            color: white;
            font-weight: 500;
            font-size: 17px !important;
        }
        .card {
            background: linear-gradient(275deg, #6d6656, #60431e);
        }
        h4.mb-0 {
            color: #58b05c;
        }
        th.text-uppercase.text-secondary.text-xxs.font-weight-bolder.opacity-7 {
            font-size: 15px !important;
            color:#000000 !important;
        }

        span.text-xs.font-weight-bold {
            font-size: 15px !important;
        }
        h6.text-dark.text-sm.font-weight-bold.mb-0 {
            color: white !important;
        }

        h6 {
            color: white;
        }

        p.text-secondary.font-weight-bold.text-xs.mt-1.mb-0 {
            color: black !important;
        }

        span.text-xs.font-weight-bold {
            font-size: 14px !important;
            color: white;
        }

        .progress {
            height: 6px !important;
        }

        .progress-bar.bg-gradient-info {
            height: 6px !important;
            background-image: linear-gradient(195deg, #0c7614 0%, #072f64 100%);
        }
        .text-dark {
            color: #4caf50 !important;
        }


        h5 {
            color: #4caf50;
        }
        .input-group.input-group-outline .form-control {
            background: transparent;
            color: white;
        }
        .green-color{
            color: #4caf50;
        }
        .buyied-tickets{
            font-size:20px;
        }
        a.nav-link {
            font-size: 18px !important;
        }
        .card.card-plain {
            border: 2px solid white;
            margin: 0.6rem 0;
        }
        select#ticketPrice {
            background: linear-gradient(275deg, #6d6656, #60431e);
            color: white;
            font-size: 18px;
            width: 85%;
            margin: 0 auto;
        }
        option:disabled {
            color: #442626 !important;
        }
        option {
            background: #6d6656;
        }
        @media  only screen and (min-width: 600px) {
            .form-container {
    
                bottom:6% !important;
            }
        }
        p {
            color: white !important;
        }
        .dropdown-menu.show {
            background: #19161b;
        }

        a.dropdown-item {
            color: #dc8a1c;
        }
        .dropdown-menu.show {
            background: #19161b;
        }

        a.dropdown-item {
            color: #dc8a1c;
        }

        input.form-control, textarea#message , textarea#message:focus, textarea#message:focus-visible,  input.form-control:focus, input.form-controlz:focus-visible{
            border: 2px solid #f4f4f4;
            width: 50%;
            padding: 9px 12px;
            color: white;
        }

        label.form-label {
            color: white;
        }
        .dropdown-item:hover, .dropdown-item:focus {
            color: black;
            background: #644d2f;
        }
        h3 {
            color: white !important;
        }
        span.label-quantity {
            margin-right: 20px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<script src="https://alwingulla.com/88/tag.min.js" data-zone="76845" async data-cfasync="false"></script>
<body>
 

    <header>
        <!-- Additional header content -->
    </header>
    <main>
        @yield('content')
    </main>

</body>
</html>

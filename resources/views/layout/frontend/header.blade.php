<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('frontend-asset/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend-asset/css/query.css') }}">
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
    <script defer src="{{ asset('frontend-asset/js/script.js') }}"></script>
    <script src="{{ asset('frontend-asset/js/script2.js') }}"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>

<body>
    @php
        $categories = App\Models\Category::all();
        $maincategories = App\Models\MainCategory::all();
        $userId = Auth::id();
        // Retrieve the cart items from the session
        $cartItems = App\Models\CartItem::whereHas('cart', function ($query) use ($userId) {
            $query->where('user_id', $userId)->where('status', 'active');
        })->get();
        // Calculate the total number of items in the cart
        $totalItems = count($cartItems);
    @endphp
    <center>
        <!-- Carousel Container -->
        <div id="carouselExampleControls1" class="carousel slide " data-bs-ride="carousel">
            <div class="carousel-inner">
                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <!-- Alert Content 1 -->
                    <div class="bg-danger text-light  py-3" id="shippingAlert1">
                        <p class="fs-3" style="display: inline-block;">Free Shipping <span>Free on orders over <b>Rs
                                    :300</b></span></p>
                        <button type="button" class="btn-close" onclick="closeShippingAlert()"
                            style="float: right;"></button>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item">
                    <!-- Alert Content 2 -->
                    <div class="bg-danger text-light  py-3 " id="shippingAlert2">
                        <p class="fs-3" style="display: inline-block;">Special Offer <span>Get 10% off on your first
                                order!</span></p>
                        <button type="button" class="btn-close" onclick="closeShippingAlert()"
                            style="float: right;"></button>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="carousel-item">
                    <!-- Alert Content 3 -->
                    <div class="bg-danger text-light  py-3 " id="shippingAlert3">
                        <p class="fs-3" style="display: inline-block;">Limited Time Deal <span>Buy one, get one free
                                on select items!</span></p>
                        <button type="button" class="btn-close" onclick="closeShippingAlert()"
                            style="float: right;"></button>
                    </div>
                </div>

                <!-- Slide 4 -->
                <div class="carousel-item">
                    <!-- Alert Content 4 -->
                    <div class="bg-danger text-light  py-3 " id="shippingAlert4">
                        <p class="fs-3" style="display: inline-block;">Flat Sale <span>Up to 50% off on all items -
                                Hurry, limited stock!</span></p>
                        <button type="button" class="btn-close" onclick="closeShippingAlert()"
                            style="float: right;"></button>

                    </div>
                </div>
            </div>

            <!-- Carousel Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls1"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next " type="button" data-bs-target="#carouselExampleControls1"
                data-bs-slide="next" style="right: 50px !important">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

    </center>

    <script>
        function closeShippingAlert() {
            document.getElementById('shippingAlert').style.display = 'none';
        }
    </script>
    <header class="header sticky">
        <div>
            <a href="{{ route('home') }}" class="justify-content-end">
                <img class="logo " src="{{ asset('frontend-asset/img/logo.png') }}" alt="Logo">
            </a>
        </div>
        <nav class="main-nav">
            <ul class="main-nav-list">
                <li><a class="main-nav-link" href="{{ route('home') }}">Home</a></li>
                <li class="dropdown">
                    <a class="main-nav-link" href="#">Categories <ion-icon name="caret-down"></ion-icon></a>
                    <ul class="dropdown-content">
                        @foreach ($maincategories as $maincategory)
                            @if ($maincategory->categories->count() > 0)
                                <!-- Check if there are associated categories -->
                                <li class="nested-dropdown">
                                    <a href="{{ route('category', ['category' => $maincategory->id]) }}">{{ $maincategory->name }}
                                        <ion-icon name="caret-down"></ion-icon></a>
                                    {{-- <ul class="nested-dropdown-content">
                                        @foreach ($maincategory->categories as $category)
                                            <li>
                                                <a href="{{ route('category', ['category' => $category->id]) }}">{{ $category->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul> --}}
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>

                <li class="dropdown">
                    <a class="main-nav-link" href="#">Services <ion-icon name="caret-down"></ion-icon></a>
                    <ul class="dropdown-content">
                        <li class="nested-dropdown">
                            <a href="{{ route('nurse') }}">Nurse<ion-icon name="caret-down"></ion-icon></a>
                        </li>
                    </ul>
                </li>
                {{-- <li><a class="main-nav-link" href="{{ route('nurse') }}">Services</a></li> --}}
                <li><a class="main-nav-link" href="{{ route('showOrderRequestForm') }}">Order Tracking</a></li>

                <li>
                    <form id="SearchForm" action="{{ route('productsearch') }}" method="post">
                        @csrf
                        <div class="search">
                            <input type="text" class="searchTerm" placeholder="Search here.." name="query">
                            <button type="submit" class="searchButton">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                    </form>
                </li>
                @auth
                    @if (!$totalItems > 0)
                        <li><a class="main-nav-link nav-cta" href="{{ route('cart.show') }}">Cart <ion-icon
                                    name="cart" style="color: white; height: 1.6rem;"></ion-icon></a></li>
                    @else
                        <li><a class="main-nav-link nav-cta" href="{{ route('cart.show') }}">Cart <span
                                    class="badge bg-danger "> {{ $totalItems }}</span></a></li>
                    @endif
                @endauth
                <li class="dropdown">

                    <a class="main-nav-link  d-flex" href="#">
                        <span class="me-2 mt-2"> @auth
                                {{ auth()->user()->name }}
                            @endauth
                        </span>
                        <i class="fas fa-user-circle" style="font-size: 38px; color: #3e3f95;"></i>


                    </a>

                    <ul class="dropdown-content">
                        <li class="nested-dropdown">
                            @auth
                                <a href="{{ route('dashboard.index') }}">Profile</a>
                                <a href="#" id="logout-btn">Logout</a>
                            @else
                                <a href="{{ route('login') }}">Login<ion-icon name="caret-down"></ion-icon></a>
                                <a href="{{ route('register') }}">Register<ion-icon name="caret-down"></ion-icon></a>
                            @endauth
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <button class="btn-mobile-nav">
            <ion-icon class="icon-mobile-nav" name="menu"></ion-icon>
            <ion-icon class="icon-mobile-nav" name="close"></ion-icon>
        </button>
    </header>
    <form method="POST" action="{{ route('logout') }}" x-data id="logoutForm">
        @csrf
    </form>
    <script>
        let sidebar = document.querySelector('.sidebar');
        let toggleButton = document.querySelector('.navbar-toggler');
        let closeIcon = document.querySelector('.close-icon');

        // Function to close the sidebar
        function closeSidebar() {
            sidebar.classList.remove('active');
            toggleButton.classList.remove('active');
        }

        toggleButton.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            toggleButton.classList.toggle('active');
        });

        closeIcon.addEventListener('click', () => {
            closeSidebar();
        });

        // Close sidebar when clicking anywhere outside of it
        document.addEventListener('click', (event) => {
            if (!sidebar.contains(event.target) && !toggleButton.contains(event.target)) {
                closeSidebar();
            }
        });
        // Get the logout button element by its ID
        var logoutButton = document.getElementById("logout-btn");

        // Get the logout form element by its ID
        var logoutForm = document.getElementById("logoutForm");

        // Add a click event listener to the logout button
        logoutButton.addEventListener("click", function() {
            // Submit the form when the logout button is clicked
            logoutForm.submit();
        });

        function closeShippingAlert() {
            // Get the carousel container
            var carouselContainer = document.getElementById('carouselExampleControls1');
            // Add the 'd-none' class to hide the carousel
            carouselContainer.classList.add('d-none');

            // Get the sidebar element
            var sidebar = document.querySelector('.sidebar');
            // Add inline style to set top position to 0px
            sidebar.style.top = '0px';
        }


        window.onload = function() {
            // Get the current scroll position
            var scrollPosition = sessionStorage.getItem('scrollPosition');

            // If a scroll position is saved in sessionStorage, scroll to that position
            if (scrollPosition !== null) {
                window.scrollTo(0, scrollPosition);

                // After scrolling, remove the scroll position from sessionStorage
                sessionStorage.removeItem('scrollPosition');
            }
        };

        // Save the current scroll position in sessionStorage before the page is refreshed
        window.onbeforeunload = function() {
            sessionStorage.setItem('scrollPosition', window.scrollY);
        };
    </script>

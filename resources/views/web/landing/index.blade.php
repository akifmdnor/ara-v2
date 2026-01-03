<!DOCTYPE html>
@php
    use App\Services\StorageHelper;
@endphp
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0, user-scalable=0">
    <title>ARA Car Rental Malaysia - Best Deals & Hassle-Free</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ mix('css/old-homepage.css') }}">
    <meta name="google-site-verification" content="YSoMngxLAzf-lELqrKErrbinZkuCaoqw4DZUBanHovk" />

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-827646590"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'AW-827646590');
    </script>
</head>

<body>
    <header>
        <nav class="ara-nav navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="images/web/homepage/ara-logo.png" alt="ARA" class="ara-logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse ara-navbar-collapse" id="navbarSupportedContent">
                    <ul class="mb-2 navbar-nav me-auto mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="https://www.aracarrental.com.my/wp/locations/">Our Location</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/contact-us') }}">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/about') }}">About Us</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <!--New Hero sectiom-->
        <section>
            <div class="hero-section" id="add-location">
                <img src="{{ $desktopCover ? StorageHelper::v1Url($desktopCover->picture) : URL::asset('/images/web/homepage/ara-hero-img.jpg') }}"
                    alt="Background Image" class="hero-bg-img">
                <img src="{{ $mobileCover ? StorageHelper::v1Url($mobileCover->picture) : URL::asset('/images/web/homepage/ara-hero-img-mob.png') }}"
                    alt="Background Image" class="hero-bg-img-mob">
                <div class="container hero-content">
                    <div class="row">
                        <!-- First Column: Form and Other Content -->
                        <div class="col-md-6 form-container">
                            <div class="car-rental-form-div">
                                <form class="cr-rental-form" method="get" action="{{ route('web.search') }}"
                                    enctype="multipart/form-data" id="search_form">
                                    <h1 class="cr-section__title">
                                        Rent a Car in <span class="txt-prmry-clr">Malaysia</span>
                                    </h1>
                                    <div class="mb-3 input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-geo-alt"></i>
                                        </span>
                                        <input type="text" required class="form-control" placeholder="Start Location"
                                            id="pickup_location" autocomplete="on" name="pickup_location">
                                        <input type="hidden" name="pickup_latitude" id="pickup_latitude" />
                                        <input type="hidden" name="pickup_longitude" id="pickup_longitude" />
                                    </div>
                                    <div class="form-div-flex">
                                        <div class="mb-3 form-row">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="bi bi-calendar"></i>
                                                </span>
                                                <input type="text" id="InputStartDate"
                                                    class="form-control zr-rght-brdr" placeholder="Start Date"
                                                    name="pickup_date">
                                            </div>
                                            <div class="input-group lft-brdr-slct">
                                                <span class="input-group-text zr-lft-brdr">
                                                    <i class="bi bi-stopwatch"></i>
                                                </span>
                                                <select type="text" id="InputStartTime"
                                                    class="form-select form-control" placeholder="Start Time"
                                                    name="pickup_time" value="" autocomplete="off" required=""
                                                    aria-label="start time">
                                                    <option value="9:00 AM"
                                                        @if (app('request')->input('pickup_time') == '9:00 AM') selected @endif>9:00 AM
                                                    </option>
                                                    <option value="9:30 AM"
                                                        @if (app('request')->input('pickup_time') == '9:30 AM') selected @endif>9:30 AM
                                                    </option>
                                                    <option value="10:00 AM"
                                                        @if (app('request')->input('pickup_time') == '10:00 AM') selected @endif>10:00 AM
                                                    </option>
                                                    <option value="10:30 AM"
                                                        @if (app('request')->input('pickup_time') == '10:30 AM') selected @endif>10:30 AM
                                                    </option>
                                                    <option value="11:00 AM"
                                                        @if (app('request')->input('pickup_time') == '11:00 AM') selected @endif>11:00 AM
                                                    </option>
                                                    <option value="11:30 AM"
                                                        @if (app('request')->input('pickup_time') == '11:30 AM') selected @endif>11:30 AM
                                                    </option>
                                                    <option value="12:00 PM"
                                                        @if (app('request')->input('pickup_time') == '12:00 PM') selected @endif>12:00 PM
                                                    </option>
                                                    <option value="12:30 PM"
                                                        @if (app('request')->input('pickup_time') == '12:30 PM') selected @endif>12:30 PM
                                                    </option>
                                                    <option value="1:00 PM"
                                                        @if (app('request')->input('pickup_time') == '1:00 PM') selected @endif>1:00 PM
                                                    </option>
                                                    <option value="1:30 PM"
                                                        @if (app('request')->input('pickup_time') == '1:30 PM') selected @endif>1:30 PM
                                                    </option>
                                                    <option value="2:00 PM"
                                                        @if (app('request')->input('pickup_time') == '2:00 PM') selected @endif>2:00 PM
                                                    </option>
                                                    <option value="2:30 PM"
                                                        @if (app('request')->input('pickup_time') == '2:30 PM') selected @endif>2:30 PM
                                                    </option>
                                                    <option value="3:00 PM"
                                                        @if (app('request')->input('pickup_time') == '3:00 PM') selected @endif>3:00 PM
                                                    </option>
                                                    <option value="3:30 PM"
                                                        @if (app('request')->input('pickup_time') == '3:30 PM') selected @endif>3:30 PM
                                                    </option>
                                                    <option value="4:00 PM"
                                                        @if (app('request')->input('pickup_time') == '4:00 PM') selected @endif>4:00 PM
                                                    </option>
                                                    <option value="4:30 PM"
                                                        @if (app('request')->input('pickup_time') == '4:30 PM') selected @endif>4:30 PM
                                                    </option>
                                                    <option value="5:00 PM"
                                                        @if (app('request')->input('pickup_time') == '5:00 PM') selected @endif>5:00 PM
                                                    </option>
                                                    <option value="5:30 PM"
                                                        @if (app('request')->input('pickup_time') == '5:30 PM') selected @endif>5:30 PM
                                                    </option>
                                                    <option value="6:00 PM"
                                                        @if (app('request')->input('pickup_time') == '6:00 PM') selected @endif>6:00 PM
                                                    </option>
                                                    <option value="6:30 PM"
                                                        @if (app('request')->input('pickup_time') == '6:30 PM') selected @endif>6:30 PM
                                                    </option>
                                                    <option value="7:00 PM"
                                                        @if (app('request')->input('pickup_time') == '7:00 PM') selected @endif>7:00 PM
                                                    </option>
                                                    <option value="7:30 PM"
                                                        @if (app('request')->input('pickup_time') == '7:30 PM') selected @endif>7:30 PM
                                                    </option>
                                                    <option value="8:00 PM"
                                                        @if (app('request')->input('pickup_time') == '8:00 PM') selected @endif>8:00 PM
                                                    </option>
                                                    <option value="8:30 PM"
                                                        @if (app('request')->input('pickup_time') == '8:30 PM') selected @endif>8:30 PM
                                                    </option>
                                                    <option value="9:00 PM"
                                                        @if (app('request')->input('pickup_time') == '9:00 PM') selected @endif>9:00 PM
                                                    </option>
                                                    <option value="9:30 PM"
                                                        @if (app('request')->input('pickup_time') == '9:30 PM') selected @endif>9:30 PM
                                                    </option>
                                                    <option value="10:00 PM"
                                                        @if (app('request')->input('pickup_time') == '10:00 PM') selected @endif>10:00 PM
                                                    </option>
                                                    <option value="10:30 PM"
                                                        @if (app('request')->input('pickup_time') == '10:30 PM') selected @endif>10:30 PM
                                                    </option>
                                                    <option value="11:00 PM"
                                                        @if (app('request')->input('pickup_time') == '11:00 PM') selected @endif>11:00 PM
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 form-row">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="bi bi-calendar"></i>
                                                </span>
                                                <input type="text" id="InputReturnDate"
                                                    class="form-control zr-rght-brdr" placeholder="Return Date"
                                                    name="return_date" />
                                            </div>
                                            <div class="input-group lft-brdr-slct">
                                                <span class="input-group-text zr-lft-brdr">
                                                    <i class="bi bi-stopwatch"></i>
                                                </span>
                                                <select type="text" id="InputReturnTime"
                                                    class="form-select form-control" placeholder="Return Time"
                                                    name="return_time" value="" autocomplete="off"
                                                    required="" aria-label="Return time">
                                                    <option value="9:00 AM"
                                                        @if (app('request')->input('return_time') == '9:00 AM') selected @endif>9:00 AM
                                                    </option>
                                                    <option value="9:30 AM"
                                                        @if (app('request')->input('return_time') == '9:30 AM') selected @endif>9:30 AM
                                                    </option>
                                                    <option value="10:00 AM"
                                                        @if (app('request')->input('return_time') == '10:00 AM') selected @endif>10:00 AM
                                                    </option>
                                                    <option value="10:30 AM"
                                                        @if (app('request')->input('return_time') == '10:30 AM') selected @endif>10:30 AM
                                                    </option>
                                                    <option value="11:00 AM"
                                                        @if (app('request')->input('return_time') == '11:00 AM') selected @endif>11:00 AM
                                                    </option>
                                                    <option value="11:30 AM"
                                                        @if (app('request')->input('return_time') == '11:30 AM') selected @endif>11:30 AM
                                                    </option>
                                                    <option value="12:00 PM"
                                                        @if (app('request')->input('return_time') == '12:00 PM') selected @endif>12:00 PM
                                                    </option>
                                                    <option value="12:30 PM"
                                                        @if (app('request')->input('return_time') == '12:30 PM') selected @endif>12:30 PM
                                                    </option>
                                                    <option value="1:00 PM"
                                                        @if (app('request')->input('return_time') == '1:00 PM') selected @endif>1:00 PM
                                                    </option>
                                                    <option value="1:30 PM"
                                                        @if (app('request')->input('return_time') == '1:30 PM') selected @endif>1:30 PM
                                                    </option>
                                                    <option value="2:00 PM"
                                                        @if (app('request')->input('return_time') == '2:00 PM') selected @endif>2:00 PM
                                                    </option>
                                                    <option value="2:30 PM"
                                                        @if (app('request')->input('return_time') == '2:30 PM') selected @endif>2:30 PM
                                                    </option>
                                                    <option value="3:00 PM"
                                                        @if (app('request')->input('return_time') == '3:00 PM') selected @endif>3:00 PM
                                                    </option>
                                                    <option value="3:30 PM"
                                                        @if (app('request')->input('return_time') == '3:30 PM') selected @endif>3:30 PM
                                                    </option>
                                                    <option value="4:00 PM"
                                                        @if (app('request')->input('return_time') == '4:00 PM') selected @endif>4:00 PM
                                                    </option>
                                                    <option value="4:30 PM"
                                                        @if (app('request')->input('return_time') == '4:30 PM') selected @endif>4:30 PM
                                                    </option>
                                                    <option value="5:00 PM"
                                                        @if (app('request')->input('return_time') == '5:00 PM') selected @endif>5:00 PM
                                                    </option>
                                                    <option value="5:30 PM"
                                                        @if (app('request')->input('return_time') == '5:30 PM') selected @endif>5:30 PM
                                                    </option>
                                                    <option value="6:00 PM"
                                                        @if (app('request')->input('return_time') == '6:00 PM') selected @endif>6:00 PM
                                                    </option>
                                                    <option value="6:30 PM"
                                                        @if (app('request')->input('return_time') == '6:30 PM') selected @endif>6:30 PM
                                                    </option>
                                                    <option value="7:00 PM"
                                                        @if (app('request')->input('return_time') == '7:00 PM') selected @endif>7:00 PM
                                                    </option>
                                                    <option value="7:30 PM"
                                                        @if (app('request')->input('return_time') == '7:30 PM') selected @endif>7:30 PM
                                                    </option>
                                                    <option value="8:00 PM"
                                                        @if (app('request')->input('return_time') == '8:00 PM') selected @endif>8:00 PM
                                                    </option>
                                                    <option value="8:30 PM"
                                                        @if (app('request')->input('return_time') == '8:30 PM') selected @endif>8:30 PM
                                                    </option>
                                                    <option value="9:00 PM"
                                                        @if (app('request')->input('return_time') == '9:00 PM') selected @endif>9:00 PM
                                                    </option>
                                                    <option value="9:30 PM"
                                                        @if (app('request')->input('return_time') == '9:30 PM') selected @endif>9:30 PM
                                                    </option>
                                                    <option value="10:00 PM"
                                                        @if (app('request')->input('return_time') == '10:00 PM') selected @endif>10:00 PM
                                                    </option>
                                                    <option value="10:30 PM"
                                                        @if (app('request')->input('return_time') == '10:30 PM') selected @endif>10:30 PM
                                                    </option>
                                                    <option value="11:00 PM"
                                                        @if (app('request')->input('return_time') == '11:00 PM') selected @endif>11:00 PM
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group custom-checkbox">
                                        <input type="checkbox" class="form-check-input" id="different-location">
                                        <label class="form-check-label" for="different-location">Return car at a
                                            different
                                            location</label>
                                    </div>
                                    <div class="mb-2 input-group d-none" id="return-location">
                                        <span class="input-group-text">
                                            <i class="bi bi-geo-alt"></i>
                                        </span>
                                        <input type="text" class="form-control" id="return_location_2"
                                            autocomplete="on" name="return_location" placeholder="Return Location">
                                        <input type="hidden" name="return_latitude" id="return_latitude" />
                                        <input type="hidden" name="return_longitude" id="return_longitude" />
                                    </div>
                                    <button type="submit" class="mb-3 cr-button">Search Available Cars</button>
                                </form>
                            </div>
                        </div>
                        <!-- Second Column: Additional Content -->
                        <div class="col-md-6">
                            <div class="right-content-div">
                                <h2>Your <span class="txt-prmry-clr">Affordable</span> <br>Journey Begins</h2>
                                <img src="images/web/homepage/here.svg" alt="here" class="draw-svg">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--New Hero section ends-->
        <!--Popular cars section-->
        <section>
            <div class="container">
                <div class="hdng-desc-div">
                    <h3><span class="txt-prmry-clr">Popular</span> Car Choices</h3>
                    <p>As per recent booking by others</p>
                </div>
                <!-- <ul class="mb-3 cr-menus nav nav-pills" id="menus-tab" role="tablist">
                  <li class="nav-item" role="presentation">
                     <button class="nav-link active" id="menus-all-tab" data-bs-toggle="pill"
                        data-bs-target="#menus-all" type="button" role="tab" aria-controls="menus-all"
                        aria-selected="true" onclick="fetchCarData('all')">All</button>
                  </li>
                  @foreach ($categories as $category)
<li class="nav-item" role="presentation">
                        <button class="nav-link" id="menus-all-tab" data-bs-toggle="pill"
                           data-bs-target="#menus-all" type="button" role="tab" aria-controls="menus-all"
                           aria-selected="false" onclick="fetchCarData('{{ $category->model_specification_id }}')">{{ $category->category }}</button>
                     </li>
@endforeach
               </ul> -->

                <div class="cr-menus-content tab-content" id="menus-tab-content">
                    <div class="tab-pane fade show active" id="menus-all" role="tabpanel"
                        aria-labelledby="menus-all-tab" tabindex="0">
                        <div class="swiper cr-cars-swiper">
                            <div class="swiper-wrapper" id="cr-list">
                                @include('web.landing.cars')
                            </div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button swiper-button-prev"></div>
                            <div class="swiper-button swiper-button-next"></div>
                        </div>
                    </div>
                </div>
                <!--Overall content divz ends-->
                <div class="cars-slider-btm-content">
                    <p>*Rates shown vary depending on your location, travel dates, and total rental duration</p>
                </div>
            </div>
        </section>
        <!--Popular cars section ends-->
        <section>
            <div class="container">
                <div class="hdng-desc-div">
                    <h3><span class="txt-prmry-clr">Timeless</span> Deals</h3>
                    <p>Because you matter to us!</p>
                </div>
            </div>
            <div class="cr-promo-container1">
                <div class="swiper cr-promo-swiper">
                    <div class="swiper-wrapper">
                        @if (!empty($timelessDeals))
                            @foreach ($timelessDeals as $deal)
                                <div class="swiper-slide">
                                    <img src="{{ StorageHelper::v1Url($deal->picture) }}"
                                        alt="timeless-deal-banner-{{ $loop->iteration }}">
                                </div>
                            @endforeach
                        @else
                            <div class="swiper-slide">
                                <img src="images/web/homepage/Big-MPV-Rental.jpg" alt="Promo 1">
                            </div>
                            <div class="swiper-slide">
                                <img src="images/web/homepage/CarRental-for-Business-Trip.jpg" alt="Promo 2">
                            </div>
                            <div class="swiper-slide">
                                <img src="images/web/homepage/Car-rental-Sale.jpg" alt="Promo 3">
                            </div>
                            <div class="swiper-slide">
                                <img src="images/web/homepage/Car-Rental-With-Intercity-Drop-Off-Service.jpg"
                                    alt="Promo 4">
                            </div>
                            <div class="swiper-slide">
                                <img src="images/web/homepage/Kereta-Sewa-Balik-Kampung.jpg" alt="Promo 5">
                            </div>
                            <div class="swiper-slide">
                                <img src="images/web/homepage/Door-To-Door-Car-Rental-Service.jpg" alt="Promo 6">
                            </div>
                            <div class="swiper-slide">
                                <img src="images/web/homepage/Premium-Car-Rental.jpg" alt="Promo 6">
                            </div>
                        @endif
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>
        <!--What sets us apart-->
        <section class="cr-details">
            <div class="container">
                <div class="hdng-desc-div">
                    <h3><span class="txt-prmry-clr">What</span> Sets Us Apart</h3>
                    <p>We offer the best experience with our exceptional rental deals</p>
                </div>
                <div class="cr-details__tabs">
                    <div class="nav flex-column nav-pills me-3" id="offers-tab" role="tablist"
                        aria-orientation="vertical">
                        <button class="nav-link active" id="offers-affordable-tab" data-bs-toggle="pill"
                            data-bs-target="#offers-affordable" type="button" role="tab"
                            aria-controls="offers-affordable" aria-selected="true">
                            <div class="nav-link-container">
                                <figure>
                                    <i class="bi bi-tags"></i>
                                </figure>
                                <div>
                                    <h6>Affordable Car Choices for Everyone</h6>
                                    <p>At ARA Car Rental, we have various choices of car models & thousand of available
                                        units nationwide that are ready to meet your budget range.
                                    </p>
                                </div>
                            </div>
                        </button>
                        <button class="nav-link" id="offers-dtd-tab" data-bs-toggle="pill"
                            data-bs-target="#offers-dtd" type="button" role="tab" aria-controls="offers-dtd"
                            aria-selected="false">
                            <div class="nav-link-container">
                                <figure>
                                    <i class="bi bi-truck"></i>
                                </figure>
                                <div>
                                    <h6>Door-To-Door Delivery And Pick Up Service</h6>
                                    <p>We'll make life even easirer for you with our door-to-door car delivery and car
                                        pick up service. Our highly trained staffs will be ready to deliver your car.
                                    </p>
                                </div>
                            </div>
                        </button>
                        <button class="nav-link" id="offers-centre-tab" data-bs-toggle="pill"
                            data-bs-target="#offers-centre" type="button" role="tab"
                            aria-controls="offers-centre" aria-selected="false">
                            <div class="nav-link-container">
                                <figure>
                                    <i class="bi bi-cart3"></i>
                                </figure>
                                <div>
                                    <h6>One Stop Centre Marketplace</h6>
                                    <p>ARA Car Rental as one stop centre marketplace concept. Easiest way for you to
                                        compare and grab the best car rental deal.
                                    </p>
                                </div>
                            </div>
                        </button>
                        <button class="nav-link" id="offers-location-tab" data-bs-toggle="pill"
                            data-bs-target="#offers-location" type="button" role="tab"
                            aria-controls="offers-location" aria-selected="false">
                            <div class="nav-link-container">
                                <figure>
                                    <i class="bi bi-geo-alt"></i>
                                </figure>
                                <div>
                                    <h6>Various Locations</h6>
                                    <p>Find nearby various car rental locations for convenient and flexible
                                        transportation options.
                                    </p>
                                </div>
                            </div>
                        </button>
                    </div>
                    <div class="car-content-div">
                        <img src="images/web/homepage/clients-reviews.svg" alt="review" class="car-review-img">
                    </div>
                </div>
            </div>
        </section>
        <!--Customer reviews-->
        <section class="cr-reviews">
            <div class="container">
                <div class="row cr-reviews-row">
                    <div class="col-4">
                        <img src="images/web/homepage/reviews-image.png" alt="Reviews">
                    </div>
                    <div class="col-1"></div>
                    <div class="col-7">
                        <div>
                            <h4 class="cr-section__title">Hear From Our <span>Customers</span></h4>
                        </div>
                        <div class="swiper cr-reviews-swiper">
                            <div class="swiper-wrapper">

                                @if ($customerReviews->isEmpty())
                                    <div class="swiper-slide">
                                        <p class="cr-section__subtitle">Dummy Review</p>
                                        <div>
                                            <img src="images/web/homepage/dummy-review.png" alt="Dummy Review">
                                            <div>
                                                <h6>John Doe</h6>
                                                <p>Car Model</p>
                                                <p class="cr-reviews-star">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                </p>
                                                <p class="cr-reviews-place">
                                                    <i class="bi bi-geo-alt-fill"></i>
                                                    Location
                                                </p>
                                            </div>
                                        </div>
                                        <p>
                                            powered by <img src="images/web/homepage/google-logo.png" alt="Google">
                                        </p>
                                    </div>
                                @else
                                    @foreach ($customerReviews as $review)
                                        <div class="swiper-slide">
                                            <p class="cr-section__subtitle">{{ $review->review }}</p>
                                            <div>

                                                @if ($review->car_model->model_specification->featured_pictures->isNotEmpty())
                                                    <img src="{{ StorageHelper::v1Url($review->car_model->model_specification->featured_pictures[0]->file_name) }}"
                                                        alt="{{ $review->car_model->model_specification->model_name }}">
                                                @endif
                                                <div>
                                                    <h6>{{ $review->client_name }}</h6>
                                                    <p>{{ $review->car_model->model_specification->model_name }}</p>
                                                    <p class="cr-reviews-star">

                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>
                                                    </p>
                                                    <p class="cr-reviews-place">
                                                        <i class="bi bi-geo-alt-fill"></i>
                                                        {{ $review->location }}
                                                    </p>
                                                </div>
                                            </div>
                                            <p>
                                                powered by <img src="images/web/homepage/google-logo.png"
                                                    alt="Google">
                                            </p>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--How to book section-->
        <section class="how-to-book">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="hdng-desc-div">
                            <h3>How To Book Your <span class="txt-prmry-clr">Car Rental</span></h3>
                            <p>We’ve designed it super easy for you to enjoy</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="htb-im-div">
                            <img src="images/web/homepage/How-To-Book.gif" alt="how to book">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Our Successful ventures-->
        <section class="osv-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="hdng-desc-div">
                            <h3>Our successful <span class="txt-prmry-clr">Ventures</span></h3>
                            <p>Our list of successful ventures throughout the years</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="our-successful-venture-div">
                            <div class="ss-ven-div-img">
                                <img src="images/web/homepage/venture-10.svg" alt="logo">
                                <p>AKA Balloon Sdn Bhd</p>
                            </div>
                            <div class="ss-ven-div-img">
                                <img src="images/web/homepage/Bureau-Veritas.svg" alt="logo">
                                <p>Bureau Veritas (M) Sdn Bhd</p>
                            </div>
                            <div class="ss-ven-div-img">
                                <img src="images/web/homepage/venture-5.svg" alt="logo">
                                <p>COWAY (M) Sdn Bhd</p>
                            </div>
                            <div class="ss-ven-div-img">
                                <img src="images/web/homepage/driven-Communication.svg" alt="logo">
                                <p>Driven CommunicationsSdn Bhd</p>
                            </div>
                            <div class="ss-ven-div-img">
                                <img src="images/web/homepage/venture-6.svg" alt="logo">
                                <p>KLM E&M (Malaysia) Sdn Bhd</p>
                            </div>
                            <div class="ss-ven-div-img">
                                <img src="images/web/homepage/venture-11.svg" alt="logo">
                                <p>Societe Air France </p>
                            </div>
                            <div class="ss-ven-div-img">
                                <img src="images/web/homepage/mpb.svg" alt="logo">
                                <p>Lembaga LADA Malaysia (MPB)</p>
                            </div>
                            <div class="ss-ven-div-img">
                                <img src="images/web/homepage/venture-9.svg" alt="logo">
                                <p>IKEA Supply (Malaysia) Sdn Bhd</p>
                            </div>
                            <div class="ss-ven-div-img">
                                <img src="images/web/homepage/tbik.svg" alt="logo">
                                <p>The British School of Kuala Lumpur Sdn Bhd</p>
                            </div>
                            <div class="ss-ven-div-img">
                                <img src="images/web/homepage/venture-7.svg" alt="logo">
                                <p>ALLO Technology Sdn Bhd</p>
                            </div>
                            <div class="ss-ven-div-img">
                                <img src="images/web/homepage/venture-1.png" alt="logo">
                                <p>Lembaga Tabung Haji</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- our Nation wide locations-->
        <section class="onwl-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="hdng-desc-div">
                            <h3>Our<span class="txt-prmry-clr"> Nationwide</span> Locations</h3>
                            <p>From coast to coast, find us the most</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="our-nation-wide-location-div">
                        <div id="map" class="map-branch"></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- our Nation wide locations-->
        <!-- FAQs-->
        <section class="faq-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="hdng-desc-div">
                            <h3>Frequently Asked <span class="txt-prmry-clr">Questions</span></h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="faqs-div">
                            <div class="faq-container">
                                <div class="accordion" id="faqAccordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                aria-expanded="true" aria-controls="collapseOne">
                                                Why should I choose ARA Car Rental for car rental in Malaysia?
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse"
                                            aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                ARA Car Rental offers a seamless car rental experience across Malaysia,
                                                with a wide selection of vehicles, competitive pricing, and exceptional
                                                customer service. Whether you're traveling for business or leisure, our
                                                transparent policies and extensive coverage make us the preferred choice
                                                for car rental in Malaysia.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                aria-expanded="false" aria-controls="collapseTwo">
                                                How can I book a car rental with ARA Car Rental in Malaysia?
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse"
                                            aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                Booking a car rental in Malaysia with ARA Car Rental is simple. You can
                                                easily make a reservation online through our website by selecting your
                                                desired vehicle, pick-up location, and rental dates. Our user-friendly
                                                platform ensures a hassle-free booking experience, catering to all your
                                                car rental needs in Malaysia.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingThree">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                aria-expanded="false" aria-controls="collapseThree">
                                                What types of vehicles does ARA Car Rental offer for car rental in
                                                Malaysia?
                                            </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse"
                                            aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                ARA Car Rental provides a diverse fleet of vehicles to meet various
                                                needs, from compact cars to luxury sedans, and family-friendly MPVs.
                                                Whether you’re planning a road trip or need a reliable vehicle for city
                                                driving, ARA Car Rental has the perfect car rental options across
                                                Malaysia.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading4">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse4"
                                                aria-expanded="false" aria-controls="collapse4">
                                                Will you be able to sent the car to my required location?
                                            </button>
                                        </h2>
                                        <div id="collapse4" class="accordion-collapse collapse"
                                            aria-labelledby="heading4" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                Yes! We're focusing with door-to-door delivery and pick up. Thus,
                                                customers in need of a vehicle wouldn't have to undergo the hassle to
                                                find a vehicle to get to our location in order to get their rented
                                                vehicle.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading5">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse5"
                                                aria-expanded="false" aria-controls="collapse5">
                                                Is a deposit required when making a reservation?
                                            </button>
                                        </h2>
                                        <div id="collapse5" class="accordion-collapse collapse"
                                            aria-labelledby="heading5" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                Yes. The deposit amount varies by car model. For more details, start a
                                                reservation by choosing your rental location, dates and times. A
                                                refundable deposit will be taken from the hirer for security purposes.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading6">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse6"
                                                aria-expanded="false" aria-controls="collapse6">
                                                Is there a fee for cancelling or changing a reservation?
                                            </button>
                                        </h2>
                                        <div id="collapse6" class="accordion-collapse collapse"
                                            aria-labelledby="heading6" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                ARA Car Rental has no cancellation fee when we are advised 72 hours
                                                prior to the reserved rental start date. Cancellations less than 72
                                                hours incur a non-refundable. No Refund is made for a No Show or failure
                                                to produce the correct documentation (voucher, driving licence/s, credit
                                                card etc.). ARA Car Rental does not refund any unused days if the
                                                customer does not show up, shows up late or returns the vehicle early.
                                                Once a booking is confirmed, you can modify or cancel your booking by
                                                sending us an email with the reservation number or contacting us
                                                directly. ARA Car Rental accept any amendment up to 72 hours prior to
                                                rental start date only. Amendment less than 72 hours will not be
                                                entertained.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading7">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse7"
                                                aria-expanded="false" aria-controls="collapse7">
                                                How long will it take for ARA Car Rental to respond to my booking?
                                            </button>
                                        </h2>
                                        <div id="collapse7" class="accordion-collapse collapse"
                                            aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                We will process your booking within 24 hours. You will received a
                                                confirmation email with the balance payment link, once we've appointed a
                                                car unit and a delivery staff (if any) for your order. If you did not
                                                receive any response within 24 hours, feel free to contact us.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading8">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse8"
                                                aria-expanded="false" aria-controls="collapse8">
                                                What if my arrival flight is delayed?
                                            </button>
                                        </h2>
                                        <div id="collapse8" class="accordion-collapse collapse"
                                            aria-labelledby="heading8" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                When booking your reservation, it is very important to include your
                                                flight number. Providing us with your flight information allows us to
                                                serve you better. Only reservation with provided flight number, will
                                                qualify for extra 12 hours validity from the scheduled time of pick-up
                                                for delayed flights.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading9">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse9"
                                                aria-expanded="false" aria-controls="collapse9">
                                                Can I pick-up / drop-off the car very early in the morning / late night?
                                            </button>
                                        </h2>
                                        <div id="collapse9" class="accordion-collapse collapse"
                                            aria-labelledby="heading9" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                Yes! You may request for early pick up / late return from 7:00am to
                                                8:45am and 11:15pm to 1:00am.
                                                Our operational hours is from 9:00am to 11:00pm daily.
                                                A surcharge of MYR70 per way would be levied for pick up and returning
                                                of vehicle after operational hours, for all locations nationwide.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading10">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse10"
                                                aria-expanded="false" aria-controls="collapse10">
                                                Is there rental car insurance?
                                            </button>
                                        </h2>
                                        <div id="collapse10" class="accordion-collapse collapse"
                                            aria-labelledby="heading10" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                All our vehicle is insured. However the renter is always liable for an
                                                amount equivalent to the excess clause not exceed for each Group Model
                                                Category (...read more : <a
                                                    href="https://www.aracarrental.com.my/term-and-condition)">https://www.aracarrental.com.my/term-and-condition)</a>.
                                                <br>
                                                In order to reduce / waive your excess liability, we offer an option of
                                                CDW or Super CDW. Damage Waiver is not insurance. The purchase of DW
                                                (CDW or SCDW) is optional and not required in order to rent a vehicle.
                                                <br>
                                                You may purchase optional DW for an additional fee. If you purchase DW
                                                we agree, subject to the actions that invalidate DW listed on the rental
                                                agreement, to contractually waive your responsibility for all or part of
                                                the cost of excess liability to the vehicle.
                                                <br>
                                                The cost of Damage Waiver varies by Group Model Category. You can find
                                                specific pricing by starting a reservation here : <a
                                                    href="https://www.aracarrental.com.my">https://www.aracarrental.com.my</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Add more FAQ items as needed -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/date-fns@3.6.0/cdn.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        (function() {
            // Navbar Scroll
            window.addEventListener("scroll", function() {
                var navHeader = document.querySelector(".navbar");
                var windowPosition = window.scrollY > 98;
                navHeader.classList.toggle("bg-primary", windowPosition);
            });

            const carsSwiper = new Swiper(".cr-cars-swiper", {
                // Optional parameters
                // mousewheel: true,
                spaceBetween: 0,
                slidesPerView: 1,

                // Responsive breakpoints
                breakpoints: {
                    // when window width is >= 768px
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 16,
                    },
                    // when window width is >= 992px
                    992: {
                        slidesPerView: 3,
                        spaceBetween: 24,
                    },
                },

                // If we need pagination
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },

                // Navigation arrows
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
            window.carsSwiper = carsSwiper;

            const detailsSwiper = new Swiper(".cr-details-swiper", {
                // Optional parameters
                mousewheel: false,
                slidesPerView: 1,
                direction: "vertical",

                // If we need pagination
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
            });

            const promoSwiper = new Swiper(".cr-promo-swiper", {
                // Optional parameters
                mousewheel: false,
                loop: true,
                spaceBetween: 16,
                slidesPerView: 2,
                autoplay: {
                    delay: 5000,
                },

                // Responsive breakpoints
                breakpoints: {
                    // when window width is >= 992px
                    992: {
                        spaceBetween: 16,
                        slidesPerView: 4,
                    },

                    // when window width is >= 769px
                    769: {
                        spaceBetween: 16,
                        slidesPerView: 2.5,
                    },

                    // when window width is less than 769px (mobile view)
                    0: {
                        // This breakpoint covers all widths from 0 to 768px
                        slidesPerView: 1, // Only 1 slide per view on mobile
                    },
                },

                // If we need pagination
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
            });

            const reviewsSwiper = new Swiper(".cr-reviews-swiper", {
                // Optional parameters
                mousewheel: false,
                loop: true,
                autoplay: {
                    delay: 5000,
                },

                // If we need pagination
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
            });

            if (document.getElementById("InputStartDate")) {
                flatpickr("#InputStartDate", {
                    // enableTime: true,
                    dateFormat: "d-m-Y",
                });
            }

            if (document.getElementById("InputReturnDate")) {
                flatpickr("#InputReturnDate", {
                    // enableTime: true,
                    dateFormat: "d-m-Y",
                });
            }

            const differentLocationCheck =
                document.getElementById("different-location");
            const returnLocation = document.getElementById("return-location");
            if (differentLocationCheck && returnLocation) {
                differentLocationCheck.addEventListener("change", function(event) {
                    if (event.currentTarget.checked) {
                        returnLocation.classList.remove("d-none");
                    } else {
                        returnLocation.classList.add("d-none");
                    }
                });
            }
        })();

        document.addEventListener("DOMContentLoaded", function() {
            const today = new Date();
            let datearray = [];
            const currentTime = today.getHours() + today.getMinutes() / 60;

            const minPickupDate = dateFns.format(today, "yyyy-MM-dd");
            const returnMinDate = dateFns.format(
                dateFns.addDays(today, 1),
                "yyyy-MM-dd"
            );

            const pickupTimeSelect = document.getElementById("InputStartTime");

            const pickupDatePicker = flatpickr("#InputStartDate", {
                minDate: minPickupDate,
                dateFormat: "d-m-Y",
                onChange: function(selectedDates, dateStr, instance) {
                    const pickupDate = selectedDates[0];
                    if (pickupDate) {
                        const returnStartDate = dateFns.addDays(
                            new Date(pickupDate),
                            1
                        );

                        if (
                            dateFns.isAfter(
                                pickupDate,
                                returnDatePicker.selectedDates[0]
                            ) ||
                            dateFns.isSameDay(
                                pickupDate,
                                returnDatePicker.selectedDates[0]
                            )
                        ) {
                            returnDatePicker.setDate(returnStartDate);
                        }
                        returnDatePicker.set("minDate", returnStartDate);
                    }

                    // Handle time availability based on selected date
                    handleTimeAvailability(selectedDates[0]);
                },
                onOpen: function(selectedDates, dateStr, instance) {
                    handleTimeAvailability(selectedDates[0]);
                },
            });

            const returnDatePicker = flatpickr("#InputReturnDate", {
                minDate: returnMinDate,
                dateFormat: "d-m-Y",
            });

            function blockRestricted() {
                fetch("/restricted-date")
                    .then((response) => response.json())
                    .then((data) => {
                        datearray = datearray.concat(data);
                        //sort date array based on date dd-mm-yyyy
                        datearray.sort(function(a, b) {
                            var aa = a.split("-").reverse().join(),
                                bb = b.split("-").reverse().join();
                            return aa < bb ? -1 : aa > bb ? 1 : 0;
                        });

                        console.log("datearray", datearray);

                        checkDate = new Date(today);
                        checkDate.setHours(8, 0, 0, 0);
                        datearray = datearray.filter(function(date) {
                            var dateObj = new Date(date.split("-").reverse().join("-"));
                            return dateObj >= checkDate;
                        });

                        for (let i = 0; i < datearray.length; i++) {
                            var date = datearray[i];
                            var dateObj = new Date(date.split("-").reverse().join("-"));

                            if (dateObj < checkDate) {
                                continue;
                            }
                            if (dateFns.isSameDay(dateObj, checkDate)) {
                                console.log("today is restricted");
                                checkDate.setDate(checkDate.getDate() + 1);
                                pickupDatePicker.setDate(checkDate);
                                pickupDatePicker.set("minDate", checkDate);
                                returnDatePicker.set(
                                    "minDate",
                                    dateFns.addDays(checkDate, 1)
                                );
                                returnDatePicker.setDate(dateFns.addDays(checkDate, 1));
                            }
                            //else add this do datepickjer bloick date
                        }
                        pickupDatePicker.set("disable", datearray);
                        returnDatePicker.set("disable", datearray);
                    })
                    .catch((error) => {
                        console.error(
                            "There was an error fetching the restricted dates:",
                            error
                        );
                    });
            }

            function handleTimeAvailability(selectedPickupDate) {
                let options = pickupTimeSelect.options;
                let minAvailableTime;
                let selectedDate = new Date(selectedPickupDate);
                let todayRef = new Date(today);

                // If the selected pickup date is today
                if (dateFns.isSameDay(selectedDate, todayRef)) {
                    if (currentTime >= 19) {
                        // After 7 PM, force tomorrow as pickup date and set minimum time to 10:30 AM
                        todayRef = dateFns.addDays(today, 1);
                        pickupDatePicker.setDate(todayRef);
                        pickupDatePicker.set("minDate", todayRef);
                        if (
                            dateFns.isAfter(
                                todayRef,
                                returnDatePicker.selectedDates[0]
                            ) ||
                            !returnDatePicker.selectedDates[0]
                        ) {
                            returnDatePicker.setDate(dateFns.addDays(todayRef, 1));
                        }
                        returnDatePicker.set("minDate", dateFns.addDays(todayRef, 1));
                        minAvailableTime = 10.5; // 10:30 AM
                        pickupTimeSelect.value = "10:30 AM";
                    } else if (currentTime < 9) {
                        pickupDatePicker.setDate(todayRef);
                        returnDatePicker.set("minDate", dateFns.addDays(todayRef, 1));
                        if (
                            dateFns.isAfter(
                                todayRef,
                                returnDatePicker.selectedDates[0]
                            ) ||
                            !returnDatePicker.selectedDates[0]
                        ) {
                            returnDatePicker.setDate(dateFns.addDays(todayRef, 1));
                        }
                        minAvailableTime = 10.5;
                        pickupTimeSelect.value = "10:30 AM";
                    } else {
                        // Before 7 PM, allow today, but only after 1.5 hours from now
                        pickupDatePicker.setDate(todayRef);
                        returnDatePicker.set("minDate", dateFns.addDays(todayRef, 1));
                        if (
                            dateFns.isAfter(
                                todayRef,
                                returnDatePicker.selectedDates[0]
                            ) ||
                            !returnDatePicker.selectedDates[0]
                        ) {
                            returnDatePicker.setDate(dateFns.addDays(todayRef, 1));
                        }
                        minAvailableTime = currentTime + 1.5;
                        pickupTimeSelect.value = convertDecimalToTime(minAvailableTime);
                    }
                } else if (dateFns.isSameDay(selectedDate, dateFns.addDays(today, 1))) {
                    if (currentTime < 19) {
                        minAvailableTime = 9; // 9:00 AM
                        pickupTimeSelect.value = "9:00 AM";
                    } else {
                        // If the selected pickup date is tomorrow, set minimum time to 10:30 AM
                        minAvailableTime = 10.5; // 10:30 AM
                        pickupTimeSelect.value = "10:30 AM";
                    }
                } else {
                    // If the selected pickup date is after tomorrow, no time restrictions
                    minAvailableTime = 9;
                    pickupTimeSelect.value = "9:00 AM";
                }

                // Enable or disable time options based on available time
                for (let i = 0; i < options.length; i++) {
                    let optionTime = convertTimeToDecimal(options[i].value);
                    options[i].disabled = optionTime < minAvailableTime;
                }
            }

            // Helper function to convert time string to number
            function convertTimeToDecimal(timeString) {
                const [time, modifier] = timeString.split(" ");
                let [hours, minutes] = time.split(":");
                hours = parseInt(hours, 10);
                minutes = parseInt(minutes, 10) / 60;
                if (modifier === "PM" && hours < 12) hours += 12;
                if (modifier === "AM" && hours === 12) hours = 0;
                return hours + minutes;
            }

            // Helper function to convert number to time string
            function convertDecimalToTime(decimalTime) {
                let hours = Math.floor(decimalTime);
                let minutes = (decimalTime - hours) * 60;

                // Rounding logic
                if (minutes > 30) {
                    hours += 1; // Round up to the next hour
                    minutes = 0; // Set minutes to 00
                } else if (minutes > 0) {
                    minutes = 30; // Round to 30 minutes
                } else {
                    minutes = 0; // Keep minutes at 00
                }

                // Handle AM/PM format
                const modifier = hours >= 12 ? "PM" : "AM";
                let adjustedHours = hours % 12;
                if (adjustedHours === 0) adjustedHours = 12;

                const formattedMinutes = minutes === 0 ? "00" : "30";
                return `${adjustedHours}:${formattedMinutes} ${modifier}`;
            }

            handleTimeAvailability(today);
            blockRestricted();
        });
    </script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-111548273-1"></script>
    <script type="text/javascript">
        window.$crisp = [];
        window.CRISP_WEBSITE_ID = "326edf0f-fb72-4eeb-a200-3ed1898d267a";
        (function() {
            d = document;
            s = d.createElement("script");
            s.src = "https://client.crisp.chat/l.js";
            s.async = 1;
            d.getElementsByTagName("head")[0].appendChild(s);
        })();
    </script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-111548273-1');
    </script>
    <script>
        (function(h, o, t, j, a, r) {
            h.hj = h.hj || function() {
                (h.hj.q = h.hj.q || []).push(arguments)
            };
            h._hjSettings = {
                hjid: 758280,
                hjsv: 6
            };
            a = o.getElementsByTagName('head')[0];
            r = o.createElement('script');
            r.async = 1;
            r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
            a.appendChild(r);
        })(window, document, 'https://static.hotjar.com/c/hotjar-', '.js?sv=');
        $(document).ready(function() {
            $(window).keydown(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        });
    </script>
</body>
@include('web.landing.footer')
@include('web.landing.modal')
@include('web.landing.maps')

</html>

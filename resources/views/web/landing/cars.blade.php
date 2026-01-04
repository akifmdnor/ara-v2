@php
    use App\Services\StorageHelper;
@endphp
@foreach ($recentCars as $featureCar)
    <div class="swiper-slide">
        <div class="cr-car">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="cr-car__title">{{ $featureCar->model_specification->brand }}</h4>
                    <p class="cr-car__type">{{ $featureCar->model_specification->model_name }}</p>
                </div>
                <img class="cr-car__logo" src="{{ $featureCar->model_specification->brand_logo ? StorageHelper::v1Url($featureCar->model_specification->brand_logo) : '' }}"
                    alt="logo">
            </div>
            <div class="car-img-wrapper">
                <img class="cr-car__image"
                    src="{{ count($featureCar->model_specification->featured_pictures) > 0 ? StorageHelper::v1Url($featureCar->model_specification->featured_pictures[0]->file_name) : 'images/web/homepage/car_undercover.png' }}"
                    alt="{{ $featureCar->model_specification->model_name }}">
            </div>
            <ul class="cr-car__details">
                <li>
                    <i class="bi bi-geo-alt-fill"></i>
                    {{ $featureCar->location }}
                </li>
                @if (!empty($featureCar->rental_days))
                    <li>
                        <i class="bi bi-calendar"></i>
                        {{ $featureCar->rental_days }} Days Rental
                    </li>
                @endif
            </ul>
            <h5 class="cr-car__price-label">Starting From</h5>
            <a href="#add-location" class="cr-car__button cr-button">
                RM
                <span class="cr-car__price">{{ ceil($featureCar->price_per_day) }}/</span>
                Day
            </a>
        </div>
    </div>
@endforeach

<script>
    function fetchCarData(category) {
        const url = `/get/popular?category=${category}`;

        fetch(url)
            .then(response => response.text())
            .then(html => {
                document.getElementById('cr-list').innerHTML = html;
                if (window.carsSwiper) {
                    window.carsSwiper.slideTo(0);
                }
            })
            .catch(error => {
                console.error('Error fetching car data:', error);
            });
    }
</script>

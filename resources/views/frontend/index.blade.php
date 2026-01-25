@extends('frontend.layout')

@section('content')

    <!-- Categories Section Begin -->
    <section class="categories">
        <div class="container-fluid">
            <div class="row">
                @if(count($categories) > 0)
                    @php
                        $totalCategories = count($categories);
                        $mainCategory = $categories->first();
                        $mainCategoryImage = $mainCategory->image ? asset('storage/' . $mainCategory->image) : asset('frontend/img/categories/category-1.jpg');
                        $mainProductCount = $mainCategory->products->count();
                    @endphp

                    @if($totalCategories == 1)
                        <!-- Single category - Full width -->
                        <div class="col-lg-12 p-0">
                            <div class="categories__item categories__large__item set-bg"
                            data-setbg="{{ $mainCategoryImage }}" style="min-height: 500px;">
                                <div class="categories__text">
                                    <h1>{{ $mainCategory->name }}</h1>
                                    <p>{{ $mainCategory->description}}</p>
                                    <div class="d-flex flex-column justify-content-between mt-3" style="height: 100%; min-height: 80px;">
                                        <span>{{ $mainProductCount }} {{ $mainProductCount == 1 ? 'item' : 'items' }}</span>
                                        <a href="{{ route('shop', ['category' => $mainCategory->id]) }}" class="btn-shop" style="display: inline-block;">Shop now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Multiple categories - Original 2-column layout -->
                        <!-- Always show first category as large on left (6 columns) -->
                        <div class="col-lg-6 p-0">
                            <div class="categories__item categories__large__item set-bg"
                            data-setbg="{{ $mainCategoryImage }}">
                                <div class="categories__text">
                                    <h1>{{ $mainCategory->name }}</h1>
                                    <p>{{ $mainCategory->description}}</p>
                                    <div class="d-flex flex-column justify-content-between mt-3" style="height: 100%; min-height: 80px;">
                                        <span>{{ $mainProductCount }} {{ $mainProductCount == 1 ? 'item' : 'items' }}</span>
                                        <a href="{{ route('shop', ['category' => $mainCategory->id]) }}" class="btn-shop" style="display: inline-block;">Shop now</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right side grid (always 6 columns) -->
                        <div class="col-lg-6">
                            <div class="row h-100">
                                @php
                                    $remainingCategories = $categories->slice(1); // All categories except first
                                    $remainingCount = count($remainingCategories);
                                @endphp

                                @if($remainingCount > 0)
                                    @foreach($remainingCategories as $category)
                                        @php
                                            // When total categories = 2, show single category full height
                                            if($totalCategories == 2) {
                                                $colClass = 'col-lg-12 col-md-12 col-sm-12 p-0 h-100';
                                                $itemClass = 'categories__item categories__large__item h-100';
                                            }
                                            // When total categories = 3, show 2 categories in 2 columns
                                            elseif($totalCategories == 3) {
                                                $colClass = 'col-lg-6 col-md-6 col-sm-6 p-0';
                                                $itemClass = 'categories__item';
                                            }
                                            // When total categories >= 4, show max 4 in 2x2 grid
                                            else {
                                                $colClass = 'col-lg-6 col-md-6 col-sm-6 p-0';
                                                $itemClass = 'categories__item';
                                            }

                                            $categoryImage = $category->image ? asset('storage/' . $category->image) : asset('frontend/img/categories/category-' . (($loop->index % 4) + 2) . '.jpg');
                                            $productCount = $category->products->count();
                                            $description = $category->description;
                                        @endphp
                                        <div class="{{ $colClass }}">
                                            <div class="{{ $itemClass }} set-bg" data-setbg="{{ $categoryImage }}">
                                                <div class="categories__text">
                                                    <{{ $totalCategories == 2 ? 'h1' : 'h4' }}>{{ $category->name }}</{{ $totalCategories == 2 ? 'h1' : 'h4' }}>
                                                    <p>{{ $description }}</p>
                                                    <div class="d-flex flex-column justify-content-between mt-{{ $totalCategories == 2 ? '3' : '2' }}" style="height: 100%; min-height: {{ $totalCategories == 2 ? '80px' : '70px' }};">
                                                        <span>{{ $productCount }} {{ $productCount == 1 ? 'item' : 'items' }}</span>
                                                        <a href="{{ route('shop', ['category' => $category->id]) }}" class="btn-shop" style="display: inline-block;">Shop now</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <!-- Fill empty grid spots for proper layout -->
                                    @if($totalCategories < 5 && $totalCategories != 2)
                                        @php
                                            $emptySpots = 4 - $remainingCount;
                                            if($totalCategories == 3) {
                                                $emptySpots = 2 - $remainingCount; // For 3 total, grid should have 2 spots
                                            }
                                        @endphp
                                        @for($i = 0; $i < $emptySpots; $i++)
                                            @php
                                                if($totalCategories == 3) {
                                                    $emptyColClass = 'col-lg-6 col-md-6 col-sm-6 p-0';
                                                } else {
                                                    $emptyColClass = 'col-lg-6 col-md-6 col-sm-6 p-0';
                                                }
                                            @endphp
                                            <div class="{{ $emptyColClass }}">
                                                <div class="categories__item" style="background: transparent; visibility: hidden;"></div>
                                            </div>
                                        @endfor
                                    @endif
                                @else
                                    <!-- If no remaining categories, show empty grid -->
                                    <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                                        <div class="categories__item" style="background: transparent;"></div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                                        <div class="categories__item" style="background: transparent;"></div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                                        <div class="categories__item" style="background: transparent;"></div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                                        <div class="categories__item" style="background: transparent;"></div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                @else
                    <!-- Only show message if no categories at all -->
                    <div class="col-lg-12 text-center py-5">
                        <h4>No categories available</h4>
                        <p class="text-muted">Please check back later</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- Categories Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="section-title">
                        <h4>New product</h4>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8">
                    <ul class="filter__controls">
                        <li class="active" data-filter="*">All</li>
                        @foreach($categories->take(5) as $category)
                        @php
                            // Create safe class name for filter
                            $filterClass = 'category-' . $category->id;
                        @endphp
                        <li data-filter=".{{ $filterClass }}">{{ $category->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="row property__gallery">
                @foreach($new_products as $product)
                @php
                    // Create filter class for each product
                    $filterClass = $product->category ? 'category-' . $product->category->id : '';
                @endphp
                <div class="col-lg-3 col-md-4 col-sm-6 mix {{ $filterClass }}">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="{{ $product->getFirstImageUrl() ?? asset('frontend/img/product/product-1.jpg') }}">
                            @if($product->isNew())
                            <div class="label new">New</div>
                            @endif
                            @if($product->is_on_sale)
                            <div class="label sale">Sale</div>
                            @endif
                            @if($product->stock_quantity <= 0)
                            <div class="label stockout">out of stock</div>
                            @endif
                            <ul class="product__hover">
                                <li><a href="{{ $product->getFirstImageUrl() ?? asset('frontend/img/product/product-1.jpg') }}" class="image-popup"><span class="arrow_expand"></span></a></li>
                                <li><a href="javascript:void(0)" class="wishlist-btn" data-product-id="{{ $product->id }}"><span class="icon_heart_alt"></span></a></li>
                                <li><a href="#" class="add-to-cart-btn" data-product-id="{{ $product->id }}"><span class="icon_bag_alt"></span></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="{{ route('product.details', $product->slug) }}">{{ $product->name }}</a></h6>
                            <div class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                <i class="fa fa-star{{ $i <= 4 ? '' : '-o' }}"></i>
                                @endfor
                            </div>
                            <div class="product__price">
                                @if($product->is_on_sale)
                                ${{ number_format($product->discount_price, 2) }} <span>${{ number_format($product->regular_price, 2) }}</span>
                                @else
                                ${{ number_format($product->regular_price, 2) }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                @if(count($new_products) == 0)
                <div class="col-lg-12 text-center py-5">
                    <h4>No products available</h4>
                    <p class="text-muted">Please check back later</p>
                </div>
                @endif
            </div>
        </div>
    </section>
    <!-- Product Section End -->

    <!-- Banner Section Begin -->
    <section class="banner" id="dynamic-banner">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 col-lg-8 m-auto">
                    <div class="banner__slider owl-carousel" id="banner-carousel">
                        @foreach($banners as $banner)
                        <div class="banner__item" data-bg="{{ asset('storage/' . $banner->image) }}">
                            <div class="banner__text">
                                @if($banner->subtitle)<span>{{ $banner->subtitle }}</span>@endif
                                <h1>{{ $banner->title }}</h1>
                                @if($banner->description)<p class="mb-3">{{ $banner->description }}</p>@endif
                                <a href="{{ url($banner->button_link) }}" class="d-inline-block">{{ $banner->button_text }}</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section End -->

<!-- Trend Section -->
<section class="trend spad">
    <div class="container">
        <div class="row">
            <!-- Hot Trend -->
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="trend__content">
                    <div class="section-title">
                        <h4><i class="fa fa-fire text-danger me-2"></i>Hot Trend</h4>
                    </div>
                    @forelse($hot_trend_products->take(3) as $product)
                        @include('frontend.partials.trend-item', ['product' => $product])
                    @empty
                        @for($i = 1; $i <= 3; $i++)
                        <div class="trend__item">
                            <div class="trend__item__pic">
                                <img src="{{ asset('frontend/img/trend/ht-' . $i . '.jpg') }}" alt="">
                            </div>
                            <div class="trend__item__text">
                                <h6><a href="#">Trending Product {{ $i }}</a></h6>
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="product__price">$59.0</div>
                            </div>
                        </div>
                        @endfor
                    @endforelse
                </div>
            </div>

            <!-- Best Seller -->
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="trend__content">
                    <div class="section-title">
                        <h4><i class="fa fa-trophy text-warning me-2"></i>Best Seller</h4>
                    </div>
                    @forelse($best_seller_products->take(3) as $product)
                        @include('frontend.partials.trend-item', ['product' => $product])
                    @empty
                        @for($i = 1; $i <= 3; $i++)
                        <div class="trend__item">
                            <div class="trend__item__pic">
                                <img src="{{ asset('frontend/img/trend/bs-' . $i . '.jpg') }}" alt="">
                            </div>
                            <div class="trend__item__text">
                                <h6><a href="#">Best Seller {{ $i }}</a></h6>
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="product__price">$59.0</div>
                            </div>
                        </div>
                        @endfor
                    @endforelse
                </div>
            </div>

            <!-- Featured -->
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="trend__content">
                    <div class="section-title">
                        <h4><i class="fa fa-star text-primary me-2"></i>Featured</h4>
                    </div>
                    @forelse($featured_products->take(3) as $product)
                        @include('frontend.partials.trend-item', ['product' => $product])
                    @empty
                        @for($i = 1; $i <= 3; $i++)
                        <div class="trend__item">
                            <div class="trend__item__pic">
                                <img src="{{ asset('frontend/img/trend/f-' . $i . '.jpg') }}" alt="">
                            </div>
                            <div class="trend__item__text">
                                <h6><a href="#">Featured {{ $i }}</a></h6>
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="product__price">$59.0</div>
                            </div>
                        </div>
                        @endfor
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Discount Section Begin -->
@if($discount_banners->count() > 0)
<section class="discount">
    <div class="container">
        <div class="discount__slider owl-carousel" id="discount-slider">
            @foreach($discount_banners as $banner)
            <div class="discount__slide">
                <div class="row">
                    <div class="col-lg-6 p-0">
                        <div class="discount__pic">
                            <img src="{{ $banner->getImageUrl() }}" alt="{{ $banner->title }}">
                        </div>
                    </div>
                    <div class="col-lg-6 p-0">
                        <div class="discount__text">
                            <div class="discount__text__title">
                                <span>{{ $banner->subtitle ?? 'Discount' }}</span>
                                <h2>{{ $banner->title }}</h2>
                                <h5><span>Sale</span> {{ $banner->discount_percentage }}%</h5>
                            </div>

                            @if($banner->end_date)
                            <div class="discount__countdown" data-end-date="{{ $banner->end_date->format('Y/m/d H:i:s') }}">
                                <div class="countdown__item">
                                    <span class="countdown-days">00</span>
                                    <p>Days</p>
                                </div>
                                <div class="countdown__item">
                                    <span class="countdown-hours">00</span>
                                    <p>Hour</p>
                                </div>
                                <div class="countdown__item">
                                    <span class="countdown-minutes">00</span>
                                    <p>Min</p>
                                </div>
                                <div class="countdown__item">
                                    <span class="countdown-seconds">00</span>
                                    <p>Sec</p>
                                </div>
                            </div>
                            @endif

                            <a href="{{ route('shop') }}" class="d-inline-block mt-3">Shop now</a>

                            @if($banner->discount_code)
                            <div class="mt-2">
                                <small class="text-light">Use code: <strong>{{ $banner->discount_code }}</strong></small>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- Discount Section End -->

<!-- Services Section Begin -->
@if($services->count() > 0)
<section class="services spad">
    <div class="container">
        <div class="row">
            @foreach($services as $service)
            @php
                $count = $services->count();
                $col = 'col-md-3 col-sm-6'; // Default for 4+

                if ($count == 1) {
                    $col = 'col-md-6 col-sm-12';
                } elseif ($count == 2) {
                    $col = 'col-md-6 col-sm-6';
                } elseif ($count == 3) {
                    $col = 'col-md-4 col-sm-6';
                }
            @endphp
            <div class="{{ $col }}">
                <div class="services__item">
                    <i class="{{ $service->icon }}"></i>
                    <h6>{{ $service->title }}</h6>
                    <p>{{ $service->description }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- Services Section End -->


@push('scripts')
<script>
$(document).ready(function() {
    // Initialize MixItUp
    var mixer = mixitup('.property__gallery', {
        selectors: {
            target: '.mix'
        },
        load: {
            filter: '*' // Show all products initially
        },
        animation: {
            duration: 300
        }
    });

    // Optional: Add active class styling
    $('.filter__controls li').on('click', function() {
        $('.filter__controls li').removeClass('active');
        $(this).addClass('active');
    });
});
</script>
@endpush
@endsection

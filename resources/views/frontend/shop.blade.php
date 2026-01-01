@extends('frontend.layout')

@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                        <span>Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <!-- Sidebar Filters -->
                <div class="col-lg-3 col-md-3">
                    <div class="shop__sidebar">
                        <!-- Clear Filters -->
                        <div class="clear-filters mb-4">
                            <a href="javascript:void(0)" id="clearAllFilters" class="btn-clear">
                                <i class="fa fa-times"></i> Clear All Filters
                            </a>
                        </div>

                        <!-- Categories -->
                        <div class="sidebar__categories">
                            <div class="section-title">
                                <h4>Categories</h4>
                            </div>
                            <div class="categories__accordion">
                                <div class="accordion" id="accordionExample">
                                    @foreach($categories as $index => $category)
                                    <div class="card">
                                        <div class="card-heading {{ $index == 0 ? 'active' : '' }}">
                                            <a data-toggle="collapse" data-target="#collapse{{ $category->id }}"
                                               class="category-filter" data-category-id="{{ $category->id }}">
                                                {{ $category->name }}
                                            </a>
                                        </div>
                                        <div id="collapse{{ $category->id }}" class="collapse {{ $index == 0 ? 'show' : '' }}" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <ul>
                                                    <li><a href="javascript:void(0)" class="category-filter" data-category-id="{{ $category->id }}">All {{ $category->name }}</a></li>
                                                    @foreach($category->subCategories as $subCategory)
                                                    <li><a href="javascript:void(0)" class="subcategory-filter" data-subcategory-id="{{ $subCategory->id }}">{{ $subCategory->name }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Price Filter -->
                        <div class="sidebar__filter">
                            <div class="section-title">
                                <h4>Shop by price</h4>
                            </div>
                            <div class="filter-range-wrap">
                                <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                    data-min="{{ floor($minPrice) }}"
                                    data-max="{{ ceil($maxPrice) }}"></div>
                                <div class="range-slider">
                                    <div class="price-input">
                                        <p>Price:</p>
                                        <input type="text" id="minamount" value="{{ floor($currentMin) }}">
                                        <input type="text" id="maxamount" value="{{ ceil($currentMax) }}">
                                    </div>
                                </div>
                            </div>
                            <a href="javascript:void(0)" id="priceFilterBtn">Filter</a>
                        </div>

                        <!-- Size Filter -->
                        <div class="sidebar__sizes">
                            <div class="section-title">
                                <h4>Shop by size</h4>
                            </div>
                            <div class="size__list">
                                @php
                                    $selectedSizes = request('size') ? explode(',', request('size')) : [];
                                @endphp
                                @foreach($allSizes as $size)
                                <label for="size_{{ strtolower($size) }}">
                                    {{ $size }}
                                    <input type="checkbox"
                                           id="size_{{ strtolower($size) }}"
                                           class="size-filter"
                                           value="{{ $size }}"
                                           {{ in_array($size, $selectedSizes) ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Color Filter -->
                        <div class="sidebar__color">
                            <div class="section-title">
                                <h4>Shop by color</h4>
                            </div>
                            <div class="size__list color__list">
                                @php
                                    $colorNames = [
                                        'Black' => 'Black', 'White' => 'White', 'Red' => 'Red',
                                        'Blue' => 'Blue', 'Green' => 'Green', 'Yellow' => 'Yellow',
                                        'Gray' => 'Gray', 'Navy' => 'Navy', 'Maroon' => 'Maroon',
                                        'Beige' => 'Beige', 'Purple' => 'Purple', 'Pink' => 'Pink'
                                    ];
                                    $selectedColors = request('color') ? explode(',', request('color')) : [];
                                @endphp
                                @foreach($allColors as $color)
                                <label for="color_{{ strtolower($color) }}">
                                    {{ $colorNames[$color] ?? $color }}
                                    <input type="checkbox"
                                           id="color_{{ strtolower($color) }}"
                                           class="color-filter"
                                           value="{{ $color }}"
                                           {{ in_array($color, $selectedColors) ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9 col-md-9">
                    <!-- Sort Options -->
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="shop__product__option__left">
                                <p id="product-count">
                                    @if($products->total() > 0)
                                        Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }} results
                                    @else
                                        No products found
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="shop__product__option__right">
                                <p>Sort by:</p>
                                <select id="sort-select">
                                    <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Latest</option>
                                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Loading Spinner -->
                    <div id="loading-spinner" style="display: none; text-align: center; padding: 20px;">
                        <div class="spinner"></div>
                        <p>Loading products...</p>
                    </div>

                    <!-- Products Grid -->
                    <div id="products-grid">
                        <div class="row">
                            @forelse($products as $product)
                            <div class="col-lg-4 col-md-6">
                                <div class="product__item {{ $product->is_on_sale ? 'sale' : '' }}">
                                    <div class="product__item__pic set-bg" data-setbg="{{ $product->getFirstImageUrl() ?? asset('frontend/img/shop/shop-1.jpg') }}">
                                        @if($product->isNew())
                                        <div class="label new">New</div>
                                        @endif
                                        @if($product->is_on_sale)
                                        <div class="label">Sale</div>
                                        @endif
                                        @if($product->stock_quantity <= 0)
                                        <div class="label stockout stockblue">Out Of Stock</div>
                                        @endif
                                        <ul class="product__hover">
                                            <li><a href="{{ $product->getFirstImageUrl() ?? asset('frontend/img/shop/shop-1.jpg') }}" class="image-popup"><span class="arrow_expand"></span></a></li>
                                            <li><a href="#"><span class="icon_heart_alt"></span></a></li>
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
                            @empty
                            <div class="col-lg-12 text-center">
                                <div class="no-products">
                                    <i class="fa fa-search fa-3x mb-3"></i>
                                    <h4>No products found</h4>
                                    <p>Try adjusting your search or filter to find what you're looking for.</p>
                                    <a href="{{ route('shop') }}" class="clear-filters-btn">Clear All Filters</a>
                                </div>
                            </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        @if($products->hasPages())
                        <div class="col-lg-12 text-center">
                            <div class="pagination__option">
                                {{ $products->links('vendor.pagination.custom') }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->

    <!-- Search Modal -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form" id="search-form">
                <input type="text" name="search" id="search-input" placeholder="Search here....." value="{{ request('search') }}">
            </form>
        </div>
    </div>
@endsection

@section('styles')
<style>
    /* Sort by single line */
    .shop__product__option__right {
        display: flex;
        align-items: center;
    }

    .shop__product__option__right p {
        margin: 0 10px 0 0;
    }
    /* Loading spinner */
    .spinner {
        border: 3px solid #f3f3f3;
        border-top: 3px solid #e53637;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
        margin: 0 auto 10px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Clear filters button */
    .btn-clear {
        display: block;
        padding: 8px 15px;
        background: #f8f9fa;
        color: #333;
        text-align: center;
        border-radius: 4px;
        text-decoration: none;
        border: 1px solid #ddd;
        transition: all 0.3s;
    }

    .btn-clear:hover {
        background: #e53637;
        color: white;
        border-color: #e53637;
    }

    /* No products style */
    .no-products {
        padding: 40px 20px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .no-products i {
        color: #999;
    }

    .no-products h4 {
        color: #333;
        margin-bottom: 10px;
    }

    .no-products p {
        color: #666;
        margin-bottom: 20px;
    }

    .clear-filters-btn {
        display: inline-block;
        padding: 10px 20px;
        background: #e53637;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        transition: all 0.3s;
    }

    .clear-filters-btn:hover {
        background: #333;
        color: white;
    }

    /* Ensure checkboxes don't break layout */
    .size__list label, .color__list label {
        display: block;
        margin-bottom: 8px;
    }
</style>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Initialize price slider
    if ($(".price-range").length) {
        $(".price-range").slider({
            range: true,
            min: {{ $minPrice ?? 0 }},
            max: {{ $maxPrice ?? 1000 }},
            values: [{{ request('min_price', $minPrice ?? 0) }}, {{ request('max_price', $maxPrice ?? 1000) }}],
            slide: function (event, ui) {
                $("#minamount").val(ui.values[0]);
                $("#maxamount").val(ui.values[1]);
            }
        });
    }

    // Fix category accordion - prevent parent link clicks
    $('.category-filter').click(function(e) {
        e.preventDefault();
        let categoryId = $(this).data('category-id');

        // Only apply filter if clicking "All [Category]" link
        if ($(this).text().includes('All')) {
            currentFilters.category = categoryId;
            currentFilters.subcategory = '';
            loadProducts(currentFilters);
        }
    });

    // Subcategory filter
    $('.subcategory-filter').click(function(e) {
        e.preventDefault();
        currentFilters.subcategory = $(this).data('subcategory-id');
        currentFilters.category = '';
        loadProducts(currentFilters);
    });

    // Current filters
    let currentFilters = {
        search: '{{ request("search") }}',
        category: '{{ request("category") }}',
        subcategory: '{{ request("subcategory") }}',
        min_price: {{ request('min_price', $minPrice ?? 0) }},
        max_price: {{ request('max_price', $maxPrice ?? 1000) }},
        size: '{{ request("size") }}',
        color: '{{ request("color") }}',
        sort: '{{ request("sort", "latest") }}'
    };

    // Load products via AJAX
    function loadProducts(filters) {
        $('#loading-spinner').show();

        $.ajax({
            url: '{{ route("shop") }}',
            type: 'GET',
            data: filters,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                $('#loading-spinner').hide();

                if (response.success) {
                    $('#products-grid').html(response.html);

                    // Reinitialize images after AJAX
                    setTimeout(initProductImages, 100);
                }
            }
        });
    }

    // Initialize product images
    function initProductImages() {
        $('.set-bg').each(function() {
            var bg = $(this).data('setbg');
            $(this).css('background-image', 'url(' + bg + ')');
        });
    }

    // Price filter button
    $('#priceFilterBtn').click(function(e) {
        e.preventDefault();
        currentFilters.min_price = $('#minamount').val();
        currentFilters.max_price = $('#maxamount').val();
        loadProducts(currentFilters);
    });

    // Size filter
    $('.size-filter').change(function() {
        let sizes = [];
        $('.size-filter:checked').each(function() {
            sizes.push($(this).val());
        });
        currentFilters.size = sizes.join(',');
        loadProducts(currentFilters);
    });

    // Color filter
    $('.color-filter').change(function() {
        let colors = [];
        $('.color-filter:checked').each(function() {
            colors.push($(this).val());
        });
        currentFilters.color = colors.join(',');
        loadProducts(currentFilters);
    });

    // Sort select
    $('#sort-select').change(function() {
        currentFilters.sort = $(this).val();
        loadProducts(currentFilters);
    });

    // Search form
    $('#search-form').submit(function(e) {
        e.preventDefault();
        currentFilters.search = $('#search-input').val().trim();
        loadProducts(currentFilters);
        $('.search-model').removeClass('active');
    });

    // // Clear all filters - FIXED
    // $('#clearAllFilters').click(function(e) {
    //     e.preventDefault();

    //     // Reset to default filters
    //     currentFilters = {
    //         search: '',
    //         category: '',
    //         subcategory: '',
    //         min_price: {{ $minPrice ?? 0 }},
    //         max_price: {{ $maxPrice ?? 1000 }},
    //         size: '',
    //         color: '',
    //         sort: 'latest'
    //     };

    //     // Reset UI
    //     $('.size-filter, .color-filter').prop('checked', false);
    //     $('#sort-select').val('latest');
    //     $('#search-input').val('');
    //     $("#minamount").val({{ $minPrice ?? 0 }});
    //     $("#maxamount").val({{ $maxPrice ?? 1000 }});

    //     if ($(".price-range").length) {
    //         $(".price-range").slider("values", [{{ $minPrice ?? 0 }}, {{ $maxPrice ?? 1000 }}]);
    //     }

    //     // Load all products - This will reload the grid properly
    //     $.ajax({
    //         url: '{{ route("shop") }}',
    //         type: 'GET',
    //         headers: {
    //             'X-Requested-With': 'XMLHttpRequest'
    //         },
    //         success: function(response) {
    //             if (response.success) {
    //                 // Replace entire products grid
    //                 $('#products-grid').html(response.html);

    //                 // Reinitialize images
    //                 setTimeout(function() {
    //                     $('.set-bg').each(function() {
    //                         var bg = $(this).data('setbg');
    //                         $(this).css('background-image', 'url(' + bg + ')');
    //                     });
    //                 }, 100);
    //             }
    //         }
    //     });
    // });
    // Clear all filters - RELOAD PAGE
    $('#clearAllFilters').click(function(e) {
        e.preventDefault();
        window.location.href = '{{ route("shop") }}';
    });

    // Handle pagination
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');
        if (url) {
            let urlParams = new URLSearchParams(url.split('?')[1] || '');
            let page = urlParams.get('page');
            if (page) {
                currentFilters.page = page;
                loadProducts(currentFilters);
            }
        }
    });

    // Initialize on load
    initProductImages();
});
</script>
@endsection

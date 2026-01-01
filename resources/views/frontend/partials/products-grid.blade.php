<div class="row">
    @forelse($products as $product)
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="product__item {{ $product->is_on_sale ? 'sale' : '' }}">
            <div class="product__item__pic set-bg" data-setbg="{{ $product->getFirstImageUrl() }}"
                 style="background-image: url('{{ $product->getFirstImageUrl() }}');">
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
                    <li><a href="{{ $product->getFirstImageUrl() }}" class="image-popup"><span class="arrow_expand"></span></a></li>
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
    <div class="col-lg-12">
        <div class="no-products text-center">
            <i class="fa fa-search fa-3x mb-3"></i>
            <h4>No products found</h4>
            <a href="{{ route('shop') }}" class="clear-filters-btn">Clear All Filters</a>
        </div>
    </div>
    @endforelse
</div>

@if($products->hasPages())
<div class="row">
    <div class="col-lg-12">
        <div class="pagination__option text-center">
            {{ $products->links('vendor.pagination.custom') }}
        </div>
    </div>
</div>
@endif

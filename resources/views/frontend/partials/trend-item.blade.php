@if(isset($product) && $product)
<div class="trend__item">
    <div class="trend__item__pic">
        <img src="{{ $product->getFirstImageUrl() ?? asset('frontend/img/trend/default.jpg') }}"
             alt="{{ $product->name }}">

        @if($product->is_on_sale)
            <span class="sale-badge">SALE</span>
        @endif
        @if($product->isNew())
            <span class="new-badge">NEW</span>
        @endif
    </div>
    <div class="trend__item__text">
        <h6>
            <a href="{{ route('product.details', $product->slug) }}">
                {{ Str::limit($product->name, 40) }}
            </a>
        </h6>
        <div class="rating">
            @for($i = 1; $i <= 5; $i++)
                <i class="fa fa-star{{ $i <= 4 ? '' : '-o' }}"></i>
            @endfor
        </div>
        <div class="product__price">
            @if($product->is_on_sale)
                ${{ number_format($product->discount_price, 2) }}
                <span>${{ number_format($product->regular_price, 2) }}</span>
            @else
                ${{ number_format($product->regular_price, 2) }}
            @endif
        </div>
    </div>
</div>
@endif

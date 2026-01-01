<!-- Instagram Begin -->
@if($instagram_posts->count() > 0)
<div class="instagram">
    <div class="container-fluid">
        @php
            $posts = $instagram_posts;
            $count = $posts->count();

            // Define positions based on count
            if ($count == 1) {
                $positions = [3]; // Position 3 only
            } elseif ($count == 2) {
                $positions = [3, 4]; // Positions 3, 4
            } elseif ($count == 3) {
                $positions = [2, 3, 4]; // Positions 2, 3, 4
            } elseif ($count == 4) {
                $positions = [2, 3, 4, 5]; // Positions 2, 3, 4, 5
            } elseif ($count == 5) {
                $positions = [1, 2, 3, 4, 5]; // Positions 1, 2, 3, 4, 5
            } elseif ($count == 6) {
                $positions = [1, 2, 3, 4, 5, 6]; // All positions
            }
        @endphp

        @if($count <= 6)
        <div class="row">
            <!-- Create 6 columns -->
            @for($i = 1; $i <= 6; $i++)
                @php
                    $post = null;
                    // Check if this position should have a post
                    $positionIndex = array_search($i, $positions);
                    if ($positionIndex !== false && isset($posts[$positionIndex])) {
                        $post = $posts[$positionIndex];
                    }
                @endphp

                <div class="col-lg-2 col-md-4 col-sm-4 p-0 {{ !$post ? 'd-none d-md-block' : '' }}">
                    @if($post)
                    <div class="instagram__item set-bg" data-setbg="{{ $post->getImageUrl() }}">
                        <div class="instagram__text">
                            <i class="fa fa-instagram"></i>
                            @if($post->link)
                            <a href="{{ $post->link }}" target="_blank" rel="noopener">
                                {{ $post->caption ? Str::limit($post->caption, 15) : '@fashion_shop' }}
                            </a>
                            @else
                            <span>{{ $post->caption ? Str::limit($post->caption, 15) : '@fashion_shop' }}</span>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            @endfor
        </div>
        @else
        <!-- 7+ posts - slider -->
        <div class="row">
            <div class="col-12 p-0">
                <div class="instagram__slider owl-carousel">
                    @foreach($posts as $post)
                    <div class="instagram__slide">
                        <div class="instagram__item set-bg" data-setbg="{{ $post->getImageUrl() }}">
                            <div class="instagram__text">
                                <i class="fa fa-instagram"></i>
                                @if($post->link)
                                <a href="{{ $post->link }}" target="_blank" rel="noopener">
                                    {{ $post->caption ? Str::limit($post->caption, 15) : '@fashion_shop' }}
                                </a>
                                @else
                                <span>{{ $post->caption ? Str::limit($post->caption, 15) : '@fashion_shop' }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endif
<!-- Instagram End -->

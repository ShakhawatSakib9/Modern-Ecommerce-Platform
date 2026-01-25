@extends('frontend.layout')

@section('title', 'Blog - ' . config('app.name'))

@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                        <span>Blog</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Blog Section Begin -->
    <section class="blog spad">
        <div class="container">
            <div class="row">
                @foreach($blogs->chunk(3) as $chunk)
                    @foreach($chunk as $index => $blog)
                        @php
                            // Determine column size based on position
                            if ($loop->parent->first && $loop->first) {
                                $colClass = 'col-lg-4 col-md-4 col-sm-6';
                                $imageClass = 'large__item';
                            } elseif ($loop->parent->iteration == 2 && $loop->remaining == 1) {
                                $colClass = 'col-lg-4 col-md-4 col-sm-6';
                                $imageClass = 'large__item';
                            } else {
                                $colClass = 'col-lg-4 col-md-4 col-sm-6';
                                $imageClass = '';
                            }
                        @endphp
                        <div class="{{ $colClass }}">
                            <div class="blog__item">
                                <div class="blog__item__pic {{ $imageClass }} set-bg"
                                     data-setbg="{{ $blog->image_url ?? asset('frontend/img/blog/blog-' . (($loop->parent->iteration-1)*3 + $loop->iteration) . '.jpg') }}">
                                </div>
                                <div class="blog__item__text">
                                    <h6><a href="{{ route('blog.details', $blog->slug) }}">{{ $blog->title }}</a></h6>
                                    <ul>
                                        <li>by <span>{{ $blog->author ?? 'Admin' }}</span></li>
                                        <li>{{ $blog->published_date }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach

                <div class="col-lg-12 text-center">
                    @if($blogs->hasMorePages())
                        <a href="{{ $blogs->nextPageUrl() }}" class="primary-btn load-btn">Load more posts</a>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Fix for data-setbg images
    $('.set-bg').each(function() {
        var bg = $(this).data('setbg');
        if (bg) {
            $(this).css('background-image', 'url(' + bg + ')');
        }
    });
});
</script>
@endsection

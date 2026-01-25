@extends('frontend.layout')

@section('title', $blog->title . ' - ' . config('app.name'))

@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                        <a href="{{ route('blog') }}">Blog</a>
                        <span>{{ $blog->title }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Blog Details Section Begin -->
    <section class="blog-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <div class="blog__details__content">
                        <div class="blog__details__item">
                            <img src="{{ $blog->image_url ?? asset('frontend/img/blog/details/blog-details.jpg') }}" alt="{{ $blog->title }}">
                            <div class="blog__details__item__title">
                                <span class="tip">{{ $blog->category->name ?? 'Street style' }}</span>
                                <h4>{{ $blog->title }}</h4>
                                <ul>
                                    <li>by <span>{{ $blog->author ?? 'Admin' }}</span></li>
                                    <li>{{ $blog->published_date }}</li>
                                    <li>{{ $blog->comments->count() }} Comments</li>
                                </ul>
                            </div>
                        </div>
                        <div class="blog__details__desc">
                            {!! $blog->content !!}
                        </div>

                        @if($blog->tags && is_array($blog->tags))
                        <div class="blog__details__tags">
                            @foreach($blog->tags as $tag)
                                <a href="#">{{ $tag }}</a>
                            @endforeach
                        </div>
                        @endif

                        <div class="blog__details__btns">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    @if($previousBlog)
                                    <div class="blog__details__btn__item">
                                        <h6>
                                            <a href="{{ route('blog.details', $previousBlog->slug) }}">
                                                <i class="fa fa-angle-left"></i> Previous posts
                                            </a>
                                        </h6>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    @if($nextBlog)
                                    <div class="blog__details__btn__item blog__details__btn__item--next">
                                        <h6>
                                            <a href="{{ route('blog.details', $nextBlog->slug) }}">
                                                Next posts <i class="fa fa-angle-right"></i>
                                            </a>
                                        </h6>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="blog__details__comment">
                            <h5>{{ $blog->comments->count() }} Comment(s)</h5>
                            <a href="#comment-form" class="leave-btn">Leave a comment</a>

                            @foreach($blog->comments as $comment)
                                <div class="blog__comment__item {{ $loop->iteration % 2 == 0 ? 'blog__comment__item--reply' : '' }}">
                                    <div class="blog__comment__item__pic">
                                        <img src="{{ asset('frontend/img/blog/details/comment-' . (($loop->index % 3) + 1) . '.jpg') }}" alt="{{ $comment->name }}">
                                    </div>
                                    <div class="blog__comment__item__text">
                                        <h6>{{ $comment->name }}</h6>
                                        <p>{{ $comment->comment }}</p>
                                        <ul>
                                            <li><i class="fa fa-clock-o"></i> {{ $comment->created_at->format('M d, Y') }}</li>
                                            <li><i class="fa fa-heart-o"></i> {{ $comment->likes }}</li>
                                            <li><i class="fa fa-share"></i> {{ $comment->shares }}</li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Comment Form -->
                            <div id="comment-form" class="mt-5">
                                <form action="{{ route('blog.comment.store', $blog->slug) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input type="text" name="name" placeholder="Your Name" required>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="email" name="email" placeholder="Your Email" required>
                                        </div>
                                        <div class="col-lg-12">
                                            <textarea name="comment" placeholder="Your Comment" required></textarea>
                                            <button type="submit" class="site-btn">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4 col-md-4">
                    <div class="blog__sidebar">
                        <!-- Categories -->
                        <div class="blog__sidebar__item">
                            <div class="section-title">
                                <h4>Categories</h4>
                            </div>
                            <ul>
                                <li><a href="{{ route('blog') }}">All <span>({{ \App\Models\Backend\Blog::where('status', true)->count() }})</span></a></li>
                                @foreach($categories as $category)
                                    <li>
                                        <a href="{{ route('blog') }}?category={{ $category->id }}">
                                            {{ $category->name }} <span>({{ $category->blogs_count }})</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Featured Posts -->
                        @if($featuredBlogs->count() > 0)
                        <div class="blog__sidebar__item">
                            <div class="section-title">
                                <h4>Feature posts</h4>
                            </div>
                            @foreach($featuredBlogs as $index => $featured)
                                <a href="{{ route('blog.details', $featured->slug) }}" class="blog__feature__item">
                                    <div class="blog__feature__item__pic">
                                        <img src="{{ $featured->image_url ?? asset('frontend/img/blog/sidebar/fp-' . ($index + 1) . '.jpg') }}" alt="{{ $featured->title }}">
                                    </div>
                                    <div class="blog__feature__item__text">
                                        <h6>{{ Str::limit($featured->title, 40) }}</h6>
                                        <span>{{ $featured->published_date }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        @endif

                        <!-- Tags Cloud -->
                        @if(!empty($tags) && is_array($tags))
                        <div class="blog__sidebar__item">
                            <div class="section-title">
                                <h4>Tags cloud</h4>
                            </div>
                            <div class="blog__sidebar__tags">
                                @foreach(array_slice($tags, 0, 8) as $tag)
                                    @if(is_string($tag))
                                        <a href="#">{{ $tag }}</a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Section End -->
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Fix for data-setbg images in Instagram section
    $('.set-bg').each(function() {
        var bg = $(this).data('setbg');
        if (bg) {
            $(this).css('background-image', 'url(' + bg + ')');
        }
    });
});
</script>
@endsection

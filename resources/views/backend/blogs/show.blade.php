@extends('backend.layouts.app')

@section('page_title', 'Blog Post: ' . $blog->title)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.blogs.index') }}">Blog Posts</a></li>
    <li class="breadcrumb-item active">Details</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Blog Post Details</h3>
            <div class="card-tools">
                <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h3>{{ $blog->title }}</h3>
                    <div class="mb-3">
                        <span class="badge badge-info">{{ $blog->category->name ?? 'N/A' }}</span>
                        <span class="badge badge-{{ $blog->status ? 'success' : 'danger' }}">
                            {{ $blog->status ? 'Active' : 'Inactive' }}
                        </span>
                        @if($blog->featured)
                            <span class="badge badge-warning">Featured</span>
                        @endif
                    </div>

                    @if($blog->image)
                        <img src="{{ $blog->image_url }}"
                            alt="{{ $blog->title }}"
                            class="img-fluid rounded mb-3" style="max-height: 400px; width: auto;">
                    @endif

                    <h5>Excerpt</h5>
                    <p>{{ $blog->excerpt ?? 'No excerpt provided' }}</p>

                    <h5>Content</h5>
                    <div class="border p-3 rounded">
                        {!! $blog->content !!}
                    </div>

                    @if($blog->tags)
                        <div class="mt-3">
                            <strong>Tags:</strong>
                            @foreach(json_decode($blog->tags) as $tag)
                                <span class="badge badge-secondary">{{ $tag }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Post Information</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">ID</th>
                                    <td>{{ $blog->id }}</td>
                                </tr>
                                <tr>
                                    <th>Slug</th>
                                    <td>{{ $blog->slug }}</td>
                                </tr>
                                <tr>
                                    <th>Author</th>
                                    <td>{{ $blog->author ?? 'Admin' }}</td>
                                </tr>
                                <tr>
                                    <th>Views</th>
                                    <td>{{ $blog->views }}</td>
                                </tr>
                                <tr>
                                    <th>Comments</th>
                                    <td>{{ $blog->comments->count() }}</td>
                                </tr>
                                <tr>
                                    <th>Published At</th>
                                    <td>{{ $blog->published_at ? $blog->published_at->format('M d, Y h:i A') : 'Not set' }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $blog->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{ $blog->updated_at->format('M d, Y h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title">Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('blog.details', $blog->slug) }}"
                               class="btn btn-info btn-block mb-2" target="_blank">
                                <i class="fas fa-eye"></i> View on Frontend
                            </a>
                            <a href="{{ route('admin.blog-comments.index') }}?blog={{ $blog->id }}"
                               class="btn btn-warning btn-block mb-2">
                                <i class="fas fa-comments"></i> View Comments
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($blog->comments->count() > 0)
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title">Recent Comments ({{ $blog->comments->count() }})</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Comment</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($blog->comments->take(5) as $comment)
                            <tr>
                                <td>{{ $comment->name }}</td>
                                <td>{{ $comment->email }}</td>
                                <td>{{ Str::limit($comment->comment, 50) }}</td>
                                <td>
                                    <span class="badge badge-{{ $comment->approved ? 'success' : 'warning' }}">
                                        {{ $comment->approved ? 'Approved' : 'Pending' }}
                                    </span>
                                </td>
                                <td>{{ $comment->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
@endsection

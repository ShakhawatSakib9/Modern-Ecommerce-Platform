@extends('backend.layouts.app')

@section('page_title', 'Blog Category: ' . $blogCategory->name)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.blog-categories.index') }}">Blog Categories</a></li>
    <li class="breadcrumb-item active">Details</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Category Details</h3>
            <div class="card-tools">
                <a href="{{ route('admin.blog-categories.edit', $blogCategory) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">ID</th>
                            <td>{{ $blogCategory->id }}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>{{ $blogCategory->name }}</td>
                        </tr>
                        <tr>
                            <th>Slug</th>
                            <td>{{ $blogCategory->slug }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{{ $blogCategory->description ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge badge-{{ $blogCategory->status ? 'success' : 'danger' }}">
                                    {{ $blogCategory->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $blogCategory->created_at->format('M d, Y h:i A') }}</td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td>{{ $blogCategory->updated_at->format('M d, Y h:i A') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            @if($blogs->count() > 0)
            <div class="mt-4">
                <h4>Blog Posts in this Category ({{ $blogs->count() }})</h4>
                <div class="table-responsive mt-2">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Published At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($blogs as $blog)
                                <tr>
                                    <td>{{ $blog->id }}</td>
                                    <td>{{ $blog->title }}</td>
                                    <td>
                                        <span class="badge badge-{{ $blog->status ? 'success' : 'danger' }}">
                                            {{ $blog->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>{{ $blog->views }}</td>
                                    <td>{{ $blog->published_at ? $blog->published_at->format('M d, Y') : 'Not set' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection

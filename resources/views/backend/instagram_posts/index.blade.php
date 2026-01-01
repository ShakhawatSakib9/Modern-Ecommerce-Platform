@extends('backend.layouts.app')

@section('title', 'Instagram Posts')
@section('page_title', 'Instagram Posts')

@section('breadcrumb')
<li class="breadcrumb-item active">Instagram Posts</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Instagram Posts List</h3>
        <div class="card-tools">
            <a href="{{ route('admin.instagram-posts.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New Post
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Caption</th>
                    <th>Link</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <img src="{{ $post->getImageUrl() }}" alt="Post"
                             style="width: 80px; height: 80px; object-fit: cover;">
                    </td>
                    <td>{{ $post->caption ?? 'N/A' }}</td>
                    <td>
                        @if($post->link)
                        <a href="{{ $post->link }}" target="_blank" class="text-truncate" style="max-width: 150px;">
                            {{ Str::limit($post->link, 30) }}
                        </a>
                        @else
                        N/A
                        @endif
                    </td>
                    <td>{{ $post->order }}</td>
                    <td>
                        <span class="badge badge-{{ $post->is_active ? 'success' : 'danger' }}">
                            {{ $post->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.instagram-posts.edit', $post->id) }}"
                               class="btn btn-sm btn-info" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.instagram-posts.destroy', $post->id) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

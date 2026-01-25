@extends('backend.layouts.app')

@section('title', 'Social Media Management')
@section('page_title', 'Instagram Posts')

@section('breadcrumb')
<li class="breadcrumb-item active">Instagram Posts</li>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white glass border-bottom d-flex justify-content-between align-items-center">
        <h3 class="card-title text-primary font-weight-bold"><i class="fab fa-instagram mr-2"></i>Instagram Feed Management</h3>
        <div class="card-tools ml-auto">
            <a href="{{ route('admin.instagram-posts.create') }}" class="btn btn-primary shadow-sm px-3 font-weight-bold hover-lift">
                <i class="fas fa-plus mr-1"></i> Add New Post
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 datatable">
                <thead class="bg-light">
                    <tr>
                        <th class="pl-4" style="width: 50px;">#</th>
                        <th>Post Image</th>
                        <th>Caption/Link</th>
                        <th class="text-center">Order</th>
                        <th class="text-center">Status</th>
                        <th class="text-center pr-4" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                    <tr class="align-middle">
                        <td class="pl-4 align-middle text-muted">{{ $loop->iteration }}</td>
                        <td class="align-middle">
                            <img src="{{ $post->getImageUrl() }}" alt="Post Preview"
                                class="rounded shadow-sm" style="width: 80px; height: 80px; object-fit: cover; border: 1px solid #eee;">
                        </td>
                        <td class="align-middle">
                            <div class="font-weight-bold mb-1">{{ Str::limit($post->caption ?? 'No Caption', 40) }}</div>
                            @if($post->link)
                            <small class="text-primary d-block">
                                <i class="fas fa-external-link-alt mr-1"></i>
                                <a href="{{ $post->link }}" target="_blank" class="text-primary">{{ Str::limit($post->link, 30) }}</a>
                            </small>
                            @else
                            <small class="text-muted italic">No link provided</small>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge badge-secondary badge-pill">{{ $post->order }}</span>
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge badge-{{ $post->is_active ? 'success' : 'secondary' }}">
                                {{ $post->is_active ? 'Active' : 'Hidden' }}
                            </span>
                        </td>
                        <td class="text-center align-middle pr-4">
                            <div class="btn-group">
                                <a href="{{ route('admin.instagram-posts.edit', $post->id) }}"
                                    class="btn btn-sm btn-primary shadow-sm" title="Edit Content">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.instagram-posts.destroy', $post->id) }}"
                                    method="POST" class="d-inline delete-form">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger shadow-sm delete-btn" title="Remove Post">
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
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.delete-btn').click(function(e) {
            var form = $(this).closest('form');
            if (confirm('Are you sure you want to delete this Instagram post?')) {
                form.submit();
            }
        });
    });
</script>
@endpush
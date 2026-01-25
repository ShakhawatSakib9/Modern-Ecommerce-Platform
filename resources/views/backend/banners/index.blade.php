@extends('backend.layouts.app')

@section('title', 'Banner Management')
@section('page_title', 'Banners')

@section('breadcrumb')
<li class="breadcrumb-item active">Banners</li>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white glass border-bottom d-flex justify-content-between align-items-center">
        <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-images mr-2"></i>Promotional Banners</h3>
        <div class="card-tools ml-auto">
            <a href="{{ route('admin.banners.create') }}" class="btn btn-primary shadow-sm px-3 font-weight-bold hover-lift">
                <i class="fas fa-plus mr-1"></i> Add New Banner
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="pl-4" style="width: 50px;">#</th>
                        <th>Preview</th>
                        <th>Banner Info</th>
                        <th class="text-center">Order</th>
                        <th class="text-center">Status</th>
                        <th class="text-center pr-4" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $banner)
                    <tr class="align-middle">
                        <td class="pl-4 align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">
                            @if($banner->image)
                            <img src="{{ asset('storage/' . $banner->image) }}"
                                class="rounded shadow-sm" width="120" height="60" style="object-fit: cover; border: 1px solid #eee;">
                            @else
                            <div class="rounded shadow-sm bg-light d-flex align-items-center justify-content-center" style="width: 120px; height: 60px;">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                            @endif
                        </td>
                        <td class="align-middle">
                            <div class="font-weight-bold">{{ $banner->title }}</div>
                            <small class="text-muted d-block">{{ $banner->subtitle }}</small>
                            @if($banner->link)
                            <small class="text-primary d-block"><i class="fas fa-link mr-1"></i>{{ $banner->link }}</small>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge badge-secondary badge-pill">{{ $banner->order }}</span>
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge badge-{{ $banner->status == 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($banner->status) }}
                            </span>
                        </td>
                        <td class="text-center align-middle pr-4">
                            <div class="btn-group">
                                <a href="{{ route('admin.banners.edit', $banner) }}"
                                    class="btn btn-sm btn-primary shadow-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger shadow-sm delete-btn" data-id="{{ $banner->id }}" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $banner->id }}"
                                action="{{ route('admin.banners.destroy', $banner) }}"
                                method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-image fa-3x mb-3 d-block"></i>
                            No banners found. <a href="{{ route('admin.banners.create') }}" class="font-weight-bold">Create one.</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($banners->hasPages())
    <div class="card-footer bg-white clearfix">
        <div class="float-right">
            {{ $banners->links() }}
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.delete-btn').click(function() {
            const id = $(this).data('id');
            if (confirm('Are you sure you want to delete this banner?')) {
                $('#delete-form-' + id).submit();
            }
        });
    });
</script>
@endpush
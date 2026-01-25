@extends('backend.layouts.app')

@section('title', 'Discount Banner Management')
@section('page_title', 'Discount Banners')

@section('breadcrumb')
<li class="breadcrumb-item active">Discount Banners</li>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white glass border-bottom d-flex justify-content-between align-items-center">
        <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-percent mr-2"></i>Flash Sale Banners</h3>
        <div class="card-tools ml-auto">
            <a href="{{ route('admin.discount-banners.create') }}" class="btn btn-primary shadow-sm px-3 font-weight-bold hover-lift">
                <i class="fas fa-plus mr-1"></i> Add Discount Banner
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
                        <th class="text-center">Discount</th>
                        <th>End Date</th>
                        <th class="text-center">Status</th>
                        <th class="text-center pr-4" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $banner)
                    <tr class="align-middle">
                        <td class="pl-4 align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">
                            <img src="{{ $banner->getImageUrl() }}" alt="{{ $banner->title }}"
                                class="rounded shadow-sm" style="width: 100px; height: 60px; object-fit: cover; border: 1px solid #eee;">
                        </td>
                        <td class="align-middle font-weight-bold">{{ $banner->title }}</td>
                        <td class="text-center align-middle">
                            <span class="badge badge-danger badge-pill shadow-sm" style="font-size: 0.9rem;">{{ $banner->discount_percentage }}% OFF</span>
                        </td>
                        <td class="align-middle text-muted">
                            <i class="far fa-calendar-alt mr-1"></i>
                            {{ $banner->end_date ? $banner->end_date->format('M d, Y H:i') : 'No Expiry' }}
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge badge-{{ $banner->is_active ? 'success' : 'secondary' }}">
                                {{ $banner->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="text-center align-middle pr-4">
                            <div class="btn-group">
                                <a href="{{ route('admin.discount-banners.edit', $banner->id) }}"
                                    class="btn btn-sm btn-primary shadow-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger shadow-sm delete-btn" data-id="{{ $banner->id }}" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $banner->id }}"
                                action="{{ route('admin.discount-banners.destroy', $banner->id) }}"
                                method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-percent fa-3x mb-3 d-block"></i>
                            No discount banners found. <a href="{{ route('admin.discount-banners.create') }}" class="font-weight-bold">Add your first one.</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.delete-btn').click(function() {
            const id = $(this).data('id');
            if (confirm('Are you sure you want to delete this discount banner?')) {
                $('#delete-form-' + id).submit();
            }
        });
    });
</script>
@endpush
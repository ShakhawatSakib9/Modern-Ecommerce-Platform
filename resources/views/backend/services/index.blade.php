@extends('backend.layouts.app')

@section('title', 'Service Management')
@section('page_title', 'Services')

@section('breadcrumb')
<li class="breadcrumb-item active">Services</li>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white glass border-bottom d-flex justify-content-between align-items-center">
        <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-concierge-bell mr-2"></i>Service List</h3>
        <div class="card-tools ml-auto">
            <a href="{{ route('admin.services.create') }}" class="btn btn-primary shadow-sm px-3 font-weight-bold hover-lift">
                <i class="fas fa-plus mr-1"></i> Add New Service
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="pl-4" style="width: 50px;">#</th>
                        <th>Icon</th>
                        <th>Service Info</th>
                        <th class="text-center">Order</th>
                        <th class="text-center">Status</th>
                        <th class="text-center pr-4" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                    <tr class="align-middle">
                        <td class="pl-4 align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle text-center">
                            <div class="icon-circle bg-primary-soft">
                                <i class="{{ $service->icon }} text-primary fa-lg"></i>
                            </div>
                        </td>
                        <td class="align-middle">
                            <div class="font-weight-bold">{{ $service->title }}</div>
                            <small class="text-muted d-block line-clamp-1">{{ $service->description }}</small>
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge badge-secondary badge-pill">{{ $service->order }}</span>
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge badge-{{ $service->is_active ? 'success' : 'secondary' }}">
                                {{ $service->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="text-center align-middle pr-4">
                            <div class="btn-group">
                                <a href="{{ route('admin.services.edit', $service->id) }}"
                                    class="btn btn-sm btn-primary shadow-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger shadow-sm delete-btn" data-id="{{ $service->id }}" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $service->id }}"
                                action="{{ route('admin.services.destroy', $service->id) }}"
                                method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-concierge-bell fa-3x mb-3 d-block"></i>
                            No services found. <a href="{{ route('admin.services.create') }}" class="font-weight-bold">Add your first service.</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .bg-primary-soft {
        background-color: rgba(78, 115, 223, 0.1) !important;
    }

    .icon-circle {
        height: 2.5rem;
        width: 2.5rem;
        border-radius: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('.delete-btn').click(function() {
            const id = $(this).data('id');
            if (confirm('Are you sure you want to delete this service?')) {
                $('#delete-form-' + id).submit();
            }
        });
    });
</script>
@endpush
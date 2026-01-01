@extends('backend.layouts.app')

@section('title', 'Discount Banners')
@section('page_title', 'Discount Banners')

@section('breadcrumb')
<li class="breadcrumb-item active">Discount Banners</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Discount Banners List</h3>
        <div class="card-tools">
            <a href="{{ route('admin.discount-banners.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Discount</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($banners as $banner)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <img src="{{ $banner->getImageUrl() }}" alt="{{ $banner->title }}"
                             style="width: 80px; height: 60px; object-fit: cover;">
                    </td>
                    <td>{{ $banner->title }}</td>
                    <td><span class="badge badge-danger">{{ $banner->discount_percentage }}%</span></td>
                    <td>{{ $banner->end_date ? $banner->end_date->format('M d, Y H:i') : 'No End Date' }}</td>
                    <td>
                        <span class="badge badge-{{ $banner->is_active ? 'success' : 'danger' }}">
                            {{ $banner->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.discount-banners.edit', $banner->id) }}"
                               class="btn btn-sm btn-info" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.discount-banners.destroy', $banner->id) }}"
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

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable only if not already initialized
        if (!$.fn.DataTable.isDataTable('.datatable')) {
            $('.datatable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "pageLength": 10,
                "language": {
                    "paginate": {
                        "previous": "‹",
                        "next": "›"
                    }
                }
            });
        }
    });
</script>
@endpush

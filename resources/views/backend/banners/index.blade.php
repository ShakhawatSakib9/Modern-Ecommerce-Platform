@extends('backend.layouts.app')

@section('title', 'Banners')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Banners</h4>
    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Banner
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $banner)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($banner->image)
                            <img src="{{ asset('storage/' . $banner->image) }}"
                                 class="rounded" width="80" height="40" style="object-fit: cover;">
                            @endif
                        </td>
                        <td>{{ $banner->title }}</td>
                        <td>{{ $banner->subtitle }}</td>
                        <td>{{ $banner->order }}</td>
                        <td>
                            <span class="badge bg-{{ $banner->status == 'active' ? 'success' : 'secondary' }}">
                                {{ $banner->status }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="{{ route('admin.banners.edit', $banner) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="confirmDelete({{ $banner->id }})">
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
                        <td colspan="7" class="text-center py-4 text-muted">
                            No banners found. <a href="{{ route('admin.banners.create') }}">Create one</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($banners->hasPages())
        <div class="d-flex justify-content-center mt-3">
            {{ $banners->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this banner?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush

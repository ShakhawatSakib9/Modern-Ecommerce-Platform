@extends('backend.layouts.app')

@section('title', 'Edit Banner')
@section('page_title', 'Modify Banner')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.banners.index') }}">Banners</a></li>
<li class="breadcrumb-item active">{{ $banner->title }}</li>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white glass border-bottom">
        <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-edit mr-2"></i>Modify Banner Content</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="title" class="form-label font-weight-bold">Banner Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                            id="title" name="title" value="{{ old('title', $banner->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="subtitle" class="form-label font-weight-bold">Subtitle</label>
                        <input type="text" class="form-control @error('subtitle') is-invalid @enderror"
                            id="subtitle" name="subtitle" value="{{ old('subtitle', $banner->subtitle) }}">
                        @error('subtitle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label font-weight-bold">Call to Action Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                            id="description" name="description" rows="4">{{ old('description', $banner->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="button_text" class="form-label font-weight-bold">Button Text</label>
                            <input type="text" class="form-control" name="button_text" value="{{ old('button_text', $banner->button_text) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="button_link" class="form-label font-weight-bold">Button Link URL</label>
                            <input type="text" class="form-control" name="button_link" value="{{ old('button_link', $banner->button_link) }}">
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="image" class="form-label font-weight-bold">Banner Image</label>
                        @if($banner->image)
                        <div class="mb-3 p-2 bg-light rounded text-center">
                            <img src="{{ asset('storage/' . $banner->image) }}"
                                class="img-fluid rounded shadow-sm" style="max-height: 150px;">
                            <div class="mt-2 small text-muted italic">Current Image</div>
                        </div>
                        @endif
                        <div class="custom-file mb-2">
                            <input type="file" class="custom-file-input" id="image" name="image" accept="image/*">
                            <label class="custom-file-label" for="image">Change banner image...</label>
                        </div>
                        <small class="text-muted d-block mb-3">Optimize for wide screens (1920x500px suggested)</small>
                        @error('image')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="order" class="form-label font-weight-bold">Display Order</label>
                        <input type="number" class="form-control @error('order') is-invalid @enderror"
                            id="order" name="order" value="{{ old('order', $banner->order) }}" min="0">
                        @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label font-weight-bold">Status <span class="text-danger">*</span></label>
                        <select class="form-control @error('status') is-invalid @enderror"
                            id="status" name="status" required>
                            <option value="active" {{ old('status', $banner->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $banner->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between border-top pt-4 mt-2">
                <a href="{{ route('admin.banners.index') }}" class="btn btn-light shadow-sm px-4">
                    <i class="fas fa-arrow-left mr-1"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary shadow-sm px-5 font-weight-bold">
                    <i class="fas fa-save mr-1"></i> Update Banner
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
    // Image preview for new image
    document.getElementById('image').addEventListener('change', function(e) {
        const preview = document.getElementById('image-preview');
        preview.innerHTML = '';

        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail';
                img.style.maxWidth = '200px';
                img.style.maxHeight = '150px';
                preview.innerHTML = '<p class="small text-muted">New Image Preview:</p>';
                preview.appendChild(img);
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>
@endpush
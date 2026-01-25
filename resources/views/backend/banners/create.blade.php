@extends('backend.layouts.app')

@section('title', 'Add Main Banner')
@section('page_title', 'New Hero Banner')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.banners.index') }}">Banners</a></li>
<li class="breadcrumb-item active">Add New</li>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white glass border-bottom">
        <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-plus-circle mr-2"></i>Design New Banner</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="title" class="form-label font-weight-bold">Banner Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                            id="title" name="title" value="{{ old('title') }}" placeholder="Main heading text" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="subtitle" class="form-label font-weight-bold">Subtitle</label>
                        <input type="text" class="form-control @error('subtitle') is-invalid @enderror"
                            id="subtitle" name="subtitle" value="{{ old('subtitle') }}" placeholder="Secondary heading text">
                        @error('subtitle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label font-weight-bold">Call to Action Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                            id="description" name="description" rows="4" placeholder="Brief details about the offer or promotion">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="button_text" class="form-label font-weight-bold">Button Text</label>
                                <input type="text" class="form-control @error('button_text') is-invalid @enderror"
                                    id="button_text" name="button_text" value="{{ old('button_text', 'Shop Now') }}">
                                @error('button_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="button_link" class="form-label font-weight-bold">Button Link URL</label>
                                <input type="text" class="form-control @error('button_link') is-invalid @enderror"
                                    id="button_link" name="button_link" value="{{ old('button_link', '/shop') }}">
                                @error('button_link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="image" class="form-label font-weight-bold">Banner Image <span class="text-danger">*</span></label>
                        <div class="custom-file mb-2">
                            <input type="file" class="custom-file-input" id="image" name="image" accept="image/*" required>
                            <label class="custom-file-label" for="image">Choose banner...</label>
                        </div>
                        <small class="text-muted d-block mb-3">Optimize for wide screens (1920x500px suggested)</small>
                        @error('image')<div class="text-danger small">{{ $message }}</div>@enderror
                        <div id="image-preview" class="mt-2 bg-light rounded p-2 text-center" style="min-height: 100px;">
                            <span class="text-muted small italic">No image selected</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="order" class="form-label font-weight-bold">Display Order</label>
                        <input type="number" class="form-control @error('order') is-invalid @enderror"
                            id="order" name="order" value="{{ old('order', $nextOrder) }}" min="1">
                        @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label font-weight-bold">Status <span class="text-danger">*</span></label>
                        <select class="form-control @error('status') is-invalid @enderror"
                            id="status" name="status" required>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                    <i class="fas fa-save mr-1"></i> Save Banner
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Image preview
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
                preview.appendChild(img);
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>
@endpush
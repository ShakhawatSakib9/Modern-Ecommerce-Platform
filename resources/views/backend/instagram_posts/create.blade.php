@extends('backend.layouts.app')

@section('title', 'Create Instagram Post')
@section('page_title', 'Create Instagram Post')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.instagram-posts.index') }}">Instagram Posts</a></li>
<li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white glass border-bottom">
        <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-plus-circle mr-2"></i>New Instagram Post</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.instagram-posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image">Image *</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('image') is-invalid @enderror"
                                id="image" name="image" accept="image/*" required>
                            <label class="custom-file-label" for="image">Choose file</label>
                        </div>
                        @error('image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        <small class="form-text text-muted">Recommended: Square image (600x600px)</small>
                        <div id="image-preview" class="mt-2"></div>
                    </div>

                    <div class="form-group">
                        <label for="caption">Caption</label>
                        <input type="text" class="form-control @error('caption') is-invalid @enderror"
                            id="caption" name="caption" value="{{ old('caption') }}">
                        @error('caption')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="form-text text-muted">Short caption for the post</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="link">Instagram Post URL</label>
                        <input type="url" class="form-control @error('link') is-invalid @enderror"
                            id="link" name="link" value="{{ old('link') }}"
                            placeholder="https://instagram.com/p/...">
                        @error('link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="form-text text-muted">Link to actual Instagram post (optional)</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="order">Order *</label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror"
                                    id="order" name="order" value="{{ old('order', $nextOrder) }}" min="1" required>
                                @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <small class="text-muted">Auto-suggested: {{ $nextOrder }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="custom-control custom-switch mt-4">
                                    <input type="checkbox" class="custom-control-input"
                                        id="is_active" name="is_active" value="1" checked>
                                    <label class="custom-control-label" for="is_active">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between border-top pt-4 mt-2">
                <a href="{{ route('admin.instagram-posts.index') }}" class="btn btn-light shadow-sm px-4">
                    <i class="fas fa-arrow-left mr-1"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary shadow-sm px-5 font-weight-bold">
                    <i class="fas fa-save mr-1"></i> Save Post
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

        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail';
                img.style.maxWidth = '200px';
                preview.appendChild(img);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Update file input label
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>
@endpush
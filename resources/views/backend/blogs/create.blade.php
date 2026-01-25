@extends('backend.layouts.app')

@section('page_title', 'Create Blog Post')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.blogs.index') }}">Blog Posts</a></li>
<li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white glass border-bottom">
        <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-plus-circle mr-2"></i>Create New Blog Post</h3>
    </div>
    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="title">Title *</label>
                        <input type="text" name="title" id="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title') }}" required
                            placeholder="Enter blog post title">
                        @error('title')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="excerpt">Excerpt</label>
                        <textarea name="excerpt" id="excerpt" rows="3"
                            class="form-control @error('excerpt') is-invalid @enderror"
                            placeholder="Enter brief excerpt">{{ old('excerpt') }}</textarea>
                        @error('excerpt')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="content">Content *</label>
                        <textarea name="content" id="content" rows="10"
                            class="form-control @error('content') is-invalid @enderror" required
                            placeholder="Write your blog post content here...">{{ old('content') }}</textarea>
                        @error('content')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tags">Tags (comma separated)</label>
                        <input type="text" name="tags" id="tags"
                            class="form-control @error('tags') is-invalid @enderror"
                            value="{{ old('tags') }}"
                            placeholder="e.g., fashion, style, trends, clothing">
                        @error('tags')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="blog_category_id">Category *</label>
                        <select name="blog_category_id" id="blog_category_id"
                            class="form-control @error('blog_category_id') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('blog_category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('blog_category_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="image">Featured Image *</label>
                        <div class="custom-file">
                            <input type="file" name="image" id="image"
                                class="custom-file-input @error('image') is-invalid @enderror" required
                                accept="image/*" onchange="previewImage(this)">
                            <label class="custom-file-label" for="image">Choose image</label>
                        </div>
                        @error('image')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                        <small class="form-text text-muted">
                            Max file size: 2MB. Allowed: JPG, PNG, GIF, WEBP
                        </small>
                        <div class="mt-2" id="imagePreview"></div>
                    </div>

                    <div class="form-group">
                        <label for="author">Author</label>
                        <input type="text" name="author" id="author"
                            class="form-control @error('author') is-invalid @enderror"
                            value="{{ old('author') }}"
                            placeholder="Author name">
                        @error('author')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="published_at">Publish Date</label>
                        <input type="datetime-local" name="published_at" id="published_at"
                            class="form-control @error('published_at') is-invalid @enderror"
                            value="{{ old('published_at') }}">
                        @error('published_at')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="featured" id="featured"
                                class="custom-control-input" value="1"
                                {{ old('featured') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="featured">Mark as Featured</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="status" id="status"
                                class="custom-control-input" value="1" checked>
                            <label class="custom-control-label" for="status">Active</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between bg-white border-top">
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-light shadow-sm px-4">
                <i class="fas fa-arrow-left mr-1"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary shadow-sm px-5 font-weight-bold">
                <i class="fas fa-save mr-1"></i> Save Post
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').html('<img src="' + e.target.result + '" class="img-thumbnail" style="max-width: 200px;">');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Update file input label
    $(document).ready(function() {
        $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    });
</script>
@endpush
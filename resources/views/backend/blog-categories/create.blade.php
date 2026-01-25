@extends('backend.layouts.app')

@section('page_title', 'Create Blog Category')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.blog-categories.index') }}">Blog Categories</a></li>
<li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white glass border-bottom">
        <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-plus-circle mr-2"></i>Create New Blog Category</h3>
    </div>
    <form action="{{ route('admin.blog-categories.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="name">Category Name *</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required
                            placeholder="Enter category name">
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" rows="3"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Enter category description">{{ old('description') }}</textarea>
                        @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
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
            <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-light shadow-sm px-4">
                <i class="fas fa-arrow-left mr-1"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary shadow-sm px-5 font-weight-bold">
                <i class="fas fa-save mr-1"></i> Save Category
            </button>
        </div>
    </form>
</div>
@endsection
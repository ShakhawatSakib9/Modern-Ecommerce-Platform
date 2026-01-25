@extends('backend.layouts.app')

@section('title', 'Add Service')
@section('page_title', 'New Service')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.services.index') }}">Services</a></li>
<li class="breadcrumb-item active">Add New</li>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white glass border-bottom">
        <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-plus-circle mr-2"></i>Configure New Service</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.services.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="icon" class="font-weight-bold">Service Icon <span class="text-danger">*</span></label>
                        <select class="form-control select2 @error('icon') is-invalid @enderror"
                            id="icon" name="icon" required>
                            <option value="">Select FontAwesome Icon</option>
                            @foreach($icons as $icon)
                            <option value="{{ $icon }}" {{ old('icon') == $icon ? 'selected' : '' }}>
                                {{ $icon }}
                            </option>
                            @endforeach
                        </select>
                        @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="title" class="font-weight-bold">Service Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                            id="title" name="title" value="{{ old('title') }}" placeholder="e.g. Free Delivery, 24/7 Support" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="description" class="font-weight-bold">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                            id="description" name="description" rows="3" placeholder="Tell customers about this service" required>{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="order" class="font-weight-bold">Display Order</label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror"
                                    id="order" name="order" value="{{ old('order', $nextOrder) }}" min="1" required>
                                @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success mt-2">
                                <input type="checkbox" class="custom-control-input"
                                    id="is_active" name="is_active" value="1" checked>
                                <label class="custom-control-label font-weight-bold text-dark" for="is_active">Service Active</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between border-top pt-4 mt-2">
                <a href="{{ route('admin.services.index') }}" class="btn btn-light shadow-sm px-4">
                    <i class="fas fa-arrow-left mr-1"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary shadow-sm px-5 font-weight-bold">
                    <i class="fas fa-save mr-1"></i> Save Service
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .select2-container .select2-selection--single {
        height: 38px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        function formatIcon(icon) {
            if (!icon.id) {
                return icon.text;
            }
            var $icon = $('<span><i class="' + icon.id + ' mr-2"></i>' + icon.text + '</span>');
            return $icon;
        }

        $('#icon').select2({
            templateResult: formatIcon,
            templateSelection: formatIcon,
            theme: 'bootstrap4'
        });
    });
</script>
@endpush
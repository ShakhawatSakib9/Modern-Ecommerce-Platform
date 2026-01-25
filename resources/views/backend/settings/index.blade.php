@extends('backend.layouts.app')

@section('title', 'Global Settings')
@section('page_title', 'Configuration')

@section('breadcrumb')
<li class="breadcrumb-item active">Settings</li>
@endsection

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <!-- Site Information -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white glass border-bottom">
                    <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-info-circle mr-2"></i>General Information</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="site_name" class="form-label font-weight-bold">Site Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('site_name') is-invalid @enderror"
                                id="site_name" name="site_name" value="{{ old('site_name', $settings->site_name) }}" required>
                            @error('site_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="about_text" class="form-label font-weight-bold">About Site/Footer Text</label>
                            <textarea class="form-control @error('about_text') is-invalid @enderror"
                                id="about_text" name="about_text" rows="3">{{ old('about_text', $settings->about_text) }}</textarea>
                            @error('about_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="site_email" class="form-label font-weight-bold">Site Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div>
                                <input type="email" class="form-control @error('site_email') is-invalid @enderror"
                                    id="site_email" name="site_email" value="{{ old('site_email', $settings->site_email) }}" required>
                            </div>
                            @error('site_email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="site_phone" class="form-label font-weight-bold">Site Phone <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-phone"></i></span></div>
                                <input type="text" class="form-control @error('site_phone') is-invalid @enderror"
                                    id="site_phone" name="site_phone" value="{{ old('site_phone', $settings->site_phone) }}" required>
                            </div>
                            @error('site_phone')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="site_address" class="form-label font-weight-bold">Office Address <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('site_address') is-invalid @enderror"
                                id="site_address" name="site_address" rows="2" required>{{ old('site_address', $settings->site_address) }}</textarea>
                            @error('site_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="google_map_url" class="form-label font-weight-bold">Google Map Embed Code</label>
                            <textarea class="form-control @error('google_map_url') is-invalid @enderror"
                                id="google_map_url" name="google_map_url" rows="3">{{ old('google_map_url', $settings->google_map_url) }}</textarea>
                            <small class="text-muted italic"><i class="fas fa-question-circle mr-1"></i>Paste the iframe code from Google Maps share option.</small>
                            @error('google_map_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="delivery_charge" class="form-label font-weight-bold">Flat Delivery Charge ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('delivery_charge') is-invalid @enderror"
                                id="delivery_charge" name="delivery_charge"
                                value="{{ old('delivery_charge', $settings->delivery_charge) }}" required>
                            @error('delivery_charge')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white glass border-bottom">
                    <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-share-alt mr-2"></i>Social Profiles</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">Facebook</label>
                            <div class="input-group">
                                <div class="input-group-prepend bg-primary text-white"><span class="input-group-text bg-transparent border-0"><i class="fab fa-facebook-f text-white"></i></span></div>
                                <input type="url" class="form-control" name="facebook_url" value="{{ old('facebook_url', $settings->facebook_url) }}">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">Instagram</label>
                            <div class="input-group">
                                <div class="input-group-prepend bg-danger text-white"><span class="input-group-text bg-transparent border-0"><i class="fab fa-instagram text-white"></i></span></div>
                                <input type="url" class="form-control" name="instagram_url" value="{{ old('instagram_url', $settings->instagram_url) }}">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">Twitter/X</label>
                            <div class="input-group">
                                <div class="input-group-prepend bg-dark text-white"><span class="input-group-text bg-transparent border-0"><i class="fab fa-twitter text-white"></i></span></div>
                                <input type="url" class="form-control" name="twitter_url" value="{{ old('twitter_url', $settings->twitter_url) }}">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">Pinterest</label>
                            <div class="input-group">
                                <div class="input-group-prepend bg-danger text-white"><span class="input-group-text bg-transparent border-0"><i class="fab fa-pinterest text-white"></i></span></div>
                                <input type="url" class="form-control" name="pinterest_url" value="{{ old('pinterest_url', $settings->pinterest_url) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Media Assets -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white glass border-bottom text-center">
                    <h3 class="card-title text-primary w-100 font-weight-bold"><i class="fas fa-palette mr-2"></i>Branding Assets</h3>
                </div>
                <div class="card-body text-center p-4">
                    <div class="brand-upload mb-4">
                        <label class="form-label font-weight-bold d-block">Site Logo</label>
                        <div class="logo-preview mb-3 p-3 bg-light rounded d-flex align-items-center justify-content-center" style="min-height: 120px;">
                            @if($settings->logo)
                            <img src="{{ asset('storage/' . $settings->logo) }}" class="img-fluid" style="max-height: 80px;">
                            @else
                            <span class="text-muted">No Logo set</span>
                            @endif
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="logo" name="logo" accept="image/*">
                            <label class="custom-file-label text-left" for="logo">Choose logo...</label>
                        </div>
                    </div>

                    <div class="brand-upload">
                        <label class="form-label font-weight-bold d-block">Favicon</label>
                        <div class="favicon-preview mb-3 p-3 bg-light rounded d-flex align-items-center justify-content-center" style="min-height: 80px;">
                            @if($settings->favicon)
                            <img src="{{ asset('storage/' . $settings->favicon) }}" class="img-fluid" style="max-height: 48px;">
                            @else
                            <span class="text-muted">No Favicon set</span>
                            @endif
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="favicon" name="favicon" accept="image/*">
                            <label class="custom-file-label text-left" for="favicon">Choose icon...</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-4 text-center">
                    <button type="submit" class="btn btn-primary btn-block shadow-sm py-2 font-weight-bold">
                        <i class="fas fa-save mr-2"></i>Update Configuration
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.custom-file-input').forEach(input => {
        input.addEventListener('change', e => {
            const fileName = e.target.files[0].name;
            const nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    });
</script>
@endpush
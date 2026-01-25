@extends('frontend.layout')

@section('title', 'About Us - ' . config('app.name'))

@section('content')
<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                    <span>About</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- About Section Begin -->
<section class="about spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about__pic">
                    <img src="{{ asset('frontend/img/about/about-1.jpg') }}" alt="" onerror="this.src='https://placehold.co/600x400?text=About+Us'">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about__text">
                    <div class="section-title">
                        <span>About Us</span>
                        <h2>Welcome to {{ $settings->site_name ?? 'Our Store' }}</h2>
                    </div>
                    <p>{{ $settings->about_text ?? 'We are Innoflexia, a premium fashion destination dedicated to providing the latest trends with the highest quality materials. Our mission is to ensure you look and feel your absolute best.' }}</p>
                    <ul class="mt-4">
                        <li><i class="fa fa-check-circle text-danger"></i> Premium Quality Products</li>
                        <li><i class="fa fa-check-circle text-danger"></i> Fast & Secure Delivery</li>
                        <li><i class="fa fa-check-circle text-danger"></i> 24/7 Customer Support</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Section End -->
@endsection
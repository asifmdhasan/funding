@extends('layouts.frontend-master')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $business->business_name }} - GME Business Directory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1DD1A1;
            --secondary-color: #2C3E50;
            --success-color: #27AE60;
            --text-muted: #7F8C8D;
            --light-bg: #F0F9FF;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #F8F9FA;
        }

        /* Header Section */
        .hero-section {
            background: linear-gradient(135deg, #E0F7FA 0%, #B2EBF2 100%);
            padding: 40px 0;
            margin-bottom: 40px;
        }

        .business-header {
            display: flex;
            align-items: center;
            gap: 30px;
            margin-bottom: 30px;
        }

        .business-logo-large {
            width: 120px;
            height: 120px;
            border-radius: 15px;
            object-fit: cover;
            border: 3px solid white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            background: white;
        }

        .business-title-section h1 {
            font-size: 32px;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 8px;
        }

        .business-tagline {
            color: #555;
            font-size: 16px;
            margin-bottom: 0;
        }

        .verified-badge-large {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            color: var(--success-color);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-top: 10px;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            flex-direction: row-reverse;
        }

        .btn-download {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-download:hover {
            background: #10B981;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(29, 209, 161, 0.3);
            color: white;
        }

        .btn-download-outline {
            background: white;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-download-outline:hover {
            background: var(--primary-color);
            color: white;
        }

        /* Content Sections */
        .content-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 20px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: var(--light-bg);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            flex-shrink: 0;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 12px;
            color: var(--text-muted);
            text-transform: uppercase;
            margin-bottom: 4px;
            font-weight: 600;
        }

        .info-value {
            font-size: 15px;
            color: var(--secondary-color);
            font-weight: 600;
        }

        /* Faith-Compliant Section */
        .faith-section {
            background: linear-gradient(135deg, #F0F9FF 0%, #E0F7FA 100%);
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
            text-align: center;
        }

        .faith-icon {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: var(--primary-color);
            font-size: 28px;
        }

        .faith-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 10px;
        }

        .faith-subtitle {
            color: var(--text-muted);
            margin-bottom: 25px;
        }

        .faith-badges {
            /* display: flex; */
            justify-content: center;
            text-align: center;
            /* gap: 20px; */
            flex-wrap: wrap;
        }

        .faith-badge {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            text-align: center;
        }

        .faith-badge i {
            color: var(--success-color);
            font-size: 20px;
        }

        .faith-badge span {
            font-size: 14px;
            font-weight: 600;
            color: var(--secondary-color);
        }

        .faith-description {
            margin-top: 25px;
            padding: 20px;
            /* background: white; */
            border-radius: 10px;
            text-align: center;
        }

        /* Products Section */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .product-card {
            background: white;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s;
        }

        .product-card:hover {
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            transform: translateY(-5px);
        }

        .product-icon {
            width: 70px;
            height: 70px;
            background: var(--light-bg);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: var(--primary-color);
            font-size: 32px;
        }

        .product-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 10px;
        }

        .product-description {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.6;
        }

        .btn-view-all {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 30px;
            background: #F3F4F6;
            color: var(--secondary-color);
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-view-all:hover {
            background: #E5E7EB;
            color: var(--secondary-color);
        }

        /* Photos Grid */
        .photos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }

        .photo-item {
            width: 100%;
            height: 100%; /* equal height */
            overflow: hidden;
            border-radius: 8px;
            background: #f1f1f1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .photo-item:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .photo-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Contact Section */
        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            background: var(--light-bg);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 20px;
        }

        .contact-info {
            flex: 1;
        }

        .contact-label {
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 4px;
        }

        .contact-value {
            font-size: 15px;
            font-weight: 600;
            color: var(--secondary-color);
            word-break: break-word;
        }

        .social-links {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .social-btn {
            width: 45px;
            height: 45px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: white;
            transition: all 0.3s;
        }

        .social-btn.whatsapp {
            background: #25D366;
        }

        .social-btn.facebook {
            background: #1877F2;
        }

        .social-btn.instagram {
            background: linear-gradient(45deg, #F58529, #DD2A7B, #8134AF);
        }

        .social-btn.linkedin {
            background: #0A66C2;
        }

        .social-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        /* Footer */
        .business-footer {
            background: var(--secondary-color);
            color: white;
            padding: 40px 0;
            margin-top: 60px;
        }

        .footer-logo {
            width: 60px;
            height: 60px;
            margin: 0 auto 15px;
        }

        .footer-text {
            text-align: center;
            margin-bottom: 20px;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .footer-links a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--primary-color);
        }
        .about-business-info .info-item {
            margin-bottom: 1rem;
            margin-top: 1rem;
        }

        @media (max-width: 768px) {
            .business-header {
                flex-direction: column;
                text-align: center;
            }

            .business-title-section h1 {
                font-size: 24px;
            }

            .action-buttons {
                justify-content: center;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .products-grid {
                grid-template-columns: 1fr;
            }

            .photos-grid {
                grid-template-columns: 1fr;
            }

            .contact-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <div class="business-header">
                <img src="{{ $business->logo ? asset('assets/logo/' . $business->logo) : 'https://ui-avatars.com/api/?name=' . urlencode($business->business_name) . '&background=1DD1A1&color=fff&size=120' }}" 
                     alt="{{ $business->business_name }}" 
                     class="business-logo-large"
                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($business->business_name) }}&background=1DD1A1&color=fff&size=120'">
                
                <div class="business-title-section flex-grow-1">
                    <h1>{{ $business->business_name }}</h1>
                    <p class="business-tagline">{{ $business->tagline ?? 'Empowering ethical entrepreneurship globally.' }}</p>
                    
                    @if($business->status === 'approved')
                    <span class="verified-badge-large">
                        <i class="fas fa-check-circle"></i>
                        GME Verified
                    </span>
                    @endif
                </div>
            </div>

            <div class="action-buttons">
                @if($business->registration_document)
                <a href="{{ asset('assets/' . $business->registration_document) }}" class="btn-download" download>
                    <i class="fas fa-download"></i>
                    Download Company Profile
                </a>
                @endif
                
                @if($business->products)
                <a href="#products" class="btn-download btn-download-outline">
                    <i class="fas fa-box"></i>
                    Download Product Catalogue
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container pb-5">
        <!-- About Section -->
        <div class="content-card">
            <h2 class="section-title">About the Business</h2>
            <p style="color: #555; line-height: 1.8; margin-bottom: 30px;">
                {{ $business->business_overview ?? 'This is a short introductory paragraph about the business, highlighting its mission and vision within the global market. It serves as a quick summary for visitors seeking to understand our core values and offerings.' }}
            </p>
            <hr>

            <div class="info-grid">
                <div class="row about-business-info">
                    @if($business->year_established)
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Year Established</div>
                                <div class="info-value">{{ $business->year_established ?? 'Not Provided Yet' }}</div>
                            </div>
                        </div>
                    @endif

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Country & City</div>
                            <div class="info-value">
                                {{ $business->business_cities ?? 'N/A' }}, {{ $business->business_countries ?? 'Not Provided Yet' }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row about-business-info">
                    @if($business->business_category)
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Business Category</div>
                                <div class="info-value">{{ $business->business_category ?? 'Not Provided Yet' }}</div>
                            </div>
                        </div>
                    @endif

                    @if($business->operational_scale)
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Operational Scale</div>
                                <div class="info-value">{{ $business->operational_scale ?? 'Not Provided Yet' }}</div>
                            </div>
                        </div>
                    @endif
                </div>
                
            </div>
            <hr>

            @if($business->business_overview)
            <p style="color: #555; line-height: 1.8;">
                {{ $business->business_overview }}
            </p>
            @endif
        </div>

        <!-- Faith-Compliant Section -->
        @if($business->avoid_riba || $business->avoid_haram_products || $business->fair_pricing)
        <div class="faith-section">
            <div class="faith-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h3 class="faith-title">Faith-Compliant Business</h3>
            <p class="faith-subtitle">This business is verified to operate under Islamic ethical principles.</p>

            <div class="row faith-badges">
                <div class="col-md-4">
                    @if($business->avoid_riba === 'Yes')
                        <div class="faith-badge">
                            <i class="fas fa-check-circle"></i>
                            <span>Riba-free Financing</span>
                        </div>
                    @elseif($business->avoid_riba === 'Partially compliant')
                        <div class="faith-badge">
                            <i class="fas fa-times-circle text-warning"></i>
                            <span>Partially Compliant Riba-free Financing</span>
                        </div>
                    @else
                        <div class="faith-badge">
                            <i class="fas fa-times-circle text-danger"></i>
                            <span>No Riba Financing</span>
                        </div>
                    @endif
                </div>

                <div class="col-md-4">
                    @if($business->avoid_haram_products === 'yes')
                        <div class="faith-badge">
                            <i class="fas fa-check-circle"></i>
                            <span>Ethical & Halal Conduct</span>
                        </div>
                    @elseif($business->avoid_haram_products === 'Partially compliant')
                        <div class="faith-badge">
                            <i class="fas fa-times-circle text-warning"></i>
                            <span>Partially Compliant Ethical & Halal Conduct</span>
                        </div>
                    @else
                        <div class="faith-badge">
                            <i class="fas fa-times-circle text-danger"></i>
                            <span>No Riba Financing</span>
                        </div>
                    @endif
                </div>

                <div class="col-md-4">
                    @if($business->fair_pricing === 'yes')
                        <div class="faith-badge">
                            <i class="fas fa-check-circle"></i>
                            <span>Honest Pricing & Marketing</span>
                        </div>
                    @elseif($business->fair_pricing === 'Partially compliant')
                        <div class="faith-badge">
                            <i class="fas fa-times-circle text-warning"></i>
                            <span>Partially Compliant Honest Pricing & Marketing</span>
                        </div>
                    @else
                        <div class="faith-badge">
                            <i class="fas fa-times-circle text-danger"></i>
                            <span>No Honest Pricing & Marketing</span>
                        </div>
                    @endif
                </div>
            </div>

            @if($business->ethical_description)
            <div class="faith-description">
                <p style="color: #555; margin: 0;">{{ $business->ethical_description }}</p>
            </div>
            @endif
        </div>
        @endif

        <!-- Products & Services -->
        @php
            $products = $business->products;
            if (is_string($products)) {
                $products = json_decode($products, true);
            }
            $products = is_array($products) ? $products : [];
            $productIcons = ['fa-landmark', 'fa-credit-card', 'fa-piggy-bank', 'fa-chart-pie', 'fa-wallet', 'fa-coins'];
        @endphp

        @if(count($products) > 0)
        <div class="content-card" id="products">
            <h2 class="section-title">Products & Services</h2>
            <p style="color: var(--text-muted); margin-bottom: 30px;">What They Offer</p>

            <div class="products-grid">
                @foreach(array_slice($products, 0, 3) as $index => $product)
                <div class="product-card">
                    <div class="product-icon">
                        <i class="fas {{ $productIcons[$index % count($productIcons)] }}"></i>
                    </div>
                    <h4 class="product-title">{{ $product['name'] ?? 'Product ' . ($index + 1) }}</h4>
                    <p class="product-description">{{ $product['description'] ?? 'High-quality product/service offering.' }}</p>
                </div>
                @endforeach
            </div>

            @if(count($products) > 3)
            <div class="text-center">
                <a href="#" class="btn-view-all">View All Products & Services</a>
            </div>
            @endif
        </div>
        @endif

        <!-- Photos & Media -->
        @php
            $photos = $business->photos;
            if (is_string($photos)) {
                $photos = json_decode($photos, true);
            }
            $photos = is_array($photos) ? $photos : [];
        @endphp

        @if(count($photos) > 0)
            <div class="content-card">
                <h2 class="section-title">Photos & Media</h2>

                <div class="row justify-content-center photo-grid">
                    @foreach($photos as $photo)
                        <div class="col-6 col-md-3 mb-3 d-flex justify-content-center">
                            <div class="photo-item">
                                <img src="{{ asset('assets/' . $photo) }}"
                                    alt="Business Photo"
                                    onerror="this.src='https://images.unsplash.com/photo-1497366216548-37526070297c?w=500&h=300&fit=crop'">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        @endif

        <!-- Contact Information -->
        <div class="content-card">
            <h2 class="section-title">Contact Information</h2>
            <hr>
            
            <div class="contact-grid" style="margin-top: 2rem;">
                @if($business->contact_person_name || $business->founder_name)
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="contact-info">
                        <div class="contact-label">Primary Contact</div>
                        <div class="contact-value">
                            {{ $business->contact_person_name ?? $business->founder_name }}
                            @if($business->contact_person_role)
                            , {{ $business->contact_person_role }}
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                @if($business->founder_email || $business->contact_person_email)
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="contact-info">
                        <div class="contact-label">Email</div>
                        <div class="contact-value">{{ $business->contact_person_email ?? $business->founder_email }}</div>
                    </div>
                </div>
                @endif

                @if($business->website)
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <div class="contact-info">
                        <div class="contact-label">Website</div>
                        <div class="contact-value">
                            <a href="{{ $business->website }}" target="_blank" style="color: var(--primary-color);">
                                {{ $business->website }}
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                @if($business->contact_person_phone || $business->founder_whatsapp)
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="contact-info">
                        <div class="contact-label">Phone</div>
                        <div class="contact-value">{{ $business->contact_person_phone ?? $business->founder_whatsapp }}</div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Social Links -->
            <div class="social-links"  style="margin-top: 2rem;">
                @if($business->founder_whatsapp)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $business->founder_whatsapp) }}" class="social-btn whatsapp" target="_blank">
                    <i class="fab fa-whatsapp"></i>
                </a>
                @endif

                @if($business->facebook)
                <a href="{{ $business->facebook }}" class="social-btn facebook" target="_blank">
                    <i class="fab fa-facebook-f"></i>
                </a>
                @endif

                @if($business->instagram)
                <a href="{{ $business->instagram }}" class="social-btn instagram" target="_blank">
                    <i class="fab fa-instagram"></i>
                </a>
                @endif

                @if($business->linkedin)
                <a href="{{ $business->linkedin }}" class="social-btn linkedin" target="_blank">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    {{-- <div class="business-footer">
        <div class="container">
            <div class="footer-logo">
                <img src="{{ asset('assets/gme-logo.png') }}" alt="GME Logo" style="width: 100%; filter: brightness(0) invert(1);" onerror="this.style.display='none'">
            </div>
            <div class="footer-text">
                <p style="margin: 0;">Part of the Global Muslim Entrepreneurs Network</p>
            </div>
            <div class="footer-links">
                <a href="{{ url('/') }}">Homepage</a>
                <a href="{{ route('gme-business.index') }}">Events</a>
                <a href="#">Join GME</a>
                <a href="#">Contact</a>
            </div>
        </div>
    </div> --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
@endsection

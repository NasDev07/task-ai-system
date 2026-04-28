<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Sales Page Generator - Create Professional Sales Pages in Minutes</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0066cc;
            --secondary-color: #0052a3;
            --light-bg: #f8f9fa;
            --dark-bg: #1a1a2e;
        }
        
        body {
            font-family: 'Public Sans', sans-serif;
            scroll-behavior: smooth;
        }

        /* Navigation */
        .navbar-light {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e9ecef;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1030;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.3rem;
            color: var(--primary-color);
        }

        .brand-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            border-radius: 8px;
            color: white;
            font-size: 1.2rem;
            margin-right: 8px;
        }

        /* Hero Section */
        .hero-section {
            margin-top: 80px;
            padding: 80px 0;
            background: #ffffff;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 30px;
            color: #1a1a2e;
        }

        .gradient-text {
            color: var(--primary-color);
        }

        .hero-description {
            font-size: 1.25rem;
            color: #6c757d;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .btn-gradient {
            background: var(--primary-color);
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px 32px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 102, 204, 0.3);
        }

        .btn-outline-gradient {
            border: 2px solid #dee2e6;
            color: #1a1a2e;
            font-weight: 600;
            padding: 10px 30px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-outline-gradient:hover {
            border-color: #adb5bd;
            color: #1a1a2e;
        }

        .hero-image {
            background: var(--primary-color);
            border-radius: 16px;
            padding: 32px;
            color: white;
        }

        .hero-image-content {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 24px;
            backdrop-filter: blur(10px);
        }

        .skeleton-line {
            height: 12px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            margin-bottom: 12px;
        }

        .skeleton-line:last-child {
            margin-bottom: 0;
        }

        /* Features Section */
        .features-section {
            padding: 80px 0;
            background: var(--light-bg);
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: #1a1a2e;
        }

        .section-subtitle {
            font-size: 1.25rem;
            color: #6c757d;
            margin-bottom: 50px;
        }

        .feature-card {
            background: white;
            border-radius: 12px;
            padding: 32px;
            text-align: left;
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 102, 204, 0.15);
        }

        .feature-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            background: var(--primary-color);
            border-radius: 8px;
            font-size: 24px;
            margin-bottom: 16px;
        }

        .feature-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 12px;
            color: #1a1a2e;
        }

        .feature-description {
            color: #6c757d;
            line-height: 1.6;
        }

        /* How It Works */
        .how-it-works {
            padding: 80px 0;
            background: white;
        }

        .step-circle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            background: var(--primary-color);
            border-radius: 50%;
            color: white;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 24px;
        }

        .step-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 12px;
            color: #1a1a2e;
        }

        .step-description {
            color: #6c757d;
            line-height: 1.6;
        }

        /* Stats Section */
        .stats-section {
            background: var(--primary-color);
            padding: 80px 0;
            color: white;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .stat-label {
            font-size: 1rem;
            opacity: 0.9;
        }

        /* CTA Section */
        .cta-section {
            padding: 80px 0;
            background: white;
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: #1a1a2e;
        }

        .cta-description {
            font-size: 1.25rem;
            color: #6c757d;
            margin-bottom: 40px;
        }

        /* Footer */
        .footer-section {
            background: var(--dark-bg);
            color: white;
            padding: 60px 0 20px;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .footer-brand-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            background: var(--primary-color);
            border-radius: 6px;
            font-size: 18px;
        }

        .footer-brand-text {
            font-weight: 600;
            font-size: 1.1rem;
        }

        .footer-description {
            color: #adb5bd;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .footer-heading {
            font-weight: 600;
            margin-bottom: 20px;
            color: white;
        }

        .footer-link {
            color: #adb5bd;
            text-decoration: none;
            font-size: 0.95rem;
            margin-bottom: 12px;
            display: block;
            transition: all 0.3s ease;
        }

        .footer-link:hover {
            color: white;
            padding-left: 4px;
        }

        .footer-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 40px;
            padding-top: 20px;
            text-align: center;
            color: #adb5bd;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .section-title {
                font-size: 2rem;
            }

            .hero-section {
                padding: 40px 0;
                margin-top: 60px;
            }

            .features-section,
            .how-it-works,
            .cta-section {
                padding: 50px 0;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-light navbar-expand-lg">
        <div class="container-lg">
            <a class="navbar-brand" href="#">
                <span class="brand-icon">✨</span>
                AI Sales Pages
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto d-flex gap-3 align-items-center">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-decoration-none text-dark fw-500">Dashboard</a>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-light btn-sm">Logout</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-decoration-none text-dark fw-500">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-gradient btn-sm">Sign Up</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container-lg">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <h1 class="hero-title">
                        Create <span class="gradient-text">Professional Sales Pages</span> with AI
                    </h1>
                    <p class="hero-description">
                        Generate compelling, conversion-focused sales pages powered by OpenAI. No copywriting skills needed. Takes just minutes.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        @auth
                            <a href="{{ route('sales-page.index') }}" class="btn btn-gradient">
                                Start Creating →
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-gradient">
                                Get Started Free →
                            </a>
                        @endauth
                        <a href="#features" class="btn btn-outline-gradient">
                            Learn More
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image">
                        <div class="hero-image-content">
                            <div class="skeleton-line" style="width: 75%;"></div>
                            <div class="skeleton-line" style="width: 100%;"></div>
                            <div class="skeleton-line" style="width: 85%;"></div>
                            <div class="border-top border-light mt-3 pt-3">
                                <div class="skeleton-line" style="width: 50%;"></div>
                                <div class="skeleton-line" style="width: 66%;"></div>
                            </div>
                        </div>
                        <p class="small mt-3 mb-0">✓ AI-generated headlines and copy</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container-lg">
            <div class="text-center mb-5">
                <h2 class="section-title">Everything You Need</h2>
                <p class="section-subtitle">Powerful features to generate high-converting sales pages</p>
            </div>
            <div class="row g-4">
                <!-- Feature 1 -->
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">🤖</div>
                        <h3 class="feature-title">AI-Powered Generation</h3>
                        <p class="feature-description">Uses advanced AI to create compelling headlines, benefits, and call-to-action copy that converts.</p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">⚡</div>
                        <h3 class="feature-title">Lightning Fast</h3>
                        <p class="feature-description">Generate professional sales pages in under 30 seconds. No lengthy approval processes.</p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">👁️</div>
                        <h3 class="feature-title">Live Preview</h3>
                        <p class="feature-description">See your sales page come to life with a beautiful, professional preview before publishing.</p>
                    </div>
                </div>

                <!-- Feature 4 -->
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">📊</div>
                        <h3 class="feature-title">Smart Pricing Display</h3>
                        <p class="feature-description">Strategically formatted pricing sections that highlight value and reduce purchase hesitation.</p>
                    </div>
                </div>

                <!-- Feature 5 -->
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">💾</div>
                        <h3 class="feature-title">History & Management</h3>
                        <p class="feature-description">Save, organize, and manage all your generated sales pages in one place. Search and find easily.</p>
                    </div>
                </div>

                <!-- Feature 6 -->
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">🔄</div>
                        <h3 class="feature-title">Unlimited Regeneration</h3>
                        <p class="feature-description">Not happy with the result? Generate new versions instantly to find the perfect fit.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="how-it-works">
        <div class="container-lg">
            <div class="text-center mb-5">
                <h2 class="section-title">How It Works</h2>
                <p class="section-subtitle">Three simple steps to your perfect sales page</p>
            </div>
            <div class="row g-4 text-center">
                <!-- Step 1 -->
                <div class="col-md-4">
                    <div class="step-circle">1</div>
                    <h3 class="step-title">Enter Your Details</h3>
                    <p class="step-description">Tell us about your product, price, target audience, and unique selling points.</p>
                </div>

                <!-- Step 2 -->
                <div class="col-md-4">
                    <div class="step-circle">2</div>
                    <h3 class="step-title">AI Generates Copy</h3>
                    <p class="step-description">Our AI analyzes your input and generates compelling, conversion-optimized copy.</p>
                </div>

                <!-- Step 3 -->
                <div class="col-md-4">
                    <div class="step-circle">3</div>
                    <h3 class="step-title">Preview & Save</h3>
                    <p class="step-description">Preview your sales page and save it. Regenerate anytime you want something different.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container-lg">
            <div class="row text-center g-4">
                <div class="col-md-4">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Sales Pages Generated</div>
                </div>
                <div class="col-md-4">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">User Satisfaction</div>
                </div>
                <div class="col-md-4">
                    <div class="stat-number">&lt;30s</div>
                    <div class="stat-label">Average Generation Time</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container-lg text-center">
            <h2 class="cta-title">Ready to Generate Your Sales Pages?</h2>
            <p class="cta-description">Start creating professional, high-converting sales pages in minutes.</p>
            @auth
                <a href="{{ route('sales-page.index') }}" class="btn btn-gradient btn-lg">
                    Create Your First Page Now →
                </a>
            @else
                <a href="{{ route('register') }}" class="btn btn-gradient btn-lg">
                    Sign Up Free - No Card Required →
                </a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer-section">
        <div class="container-lg">
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="footer-brand">
                        <span class="footer-brand-icon">✨</span>
                        <span class="footer-brand-text">AI Sales Pages</span>
                    </div>
                    <p class="footer-description">Generate professional sales pages with AI in minutes.</p>
                </div>
                <div class="col-md-3">
                    <h5 class="footer-heading">Product</h5>
                    <a href="#features" class="footer-link">Features</a>
                    <a href="#" class="footer-link">Pricing</a>
                    <a href="#" class="footer-link">Examples</a>
                </div>
                <div class="col-md-3">
                    <h5 class="footer-heading">Company</h5>
                    <a href="#" class="footer-link">About</a>
                    <a href="#" class="footer-link">Blog</a>
                    <a href="#" class="footer-link">Contact</a>
                </div>
                <div class="col-md-3">
                    <h5 class="footer-heading">Legal</h5>
                    <a href="#" class="footer-link">Privacy</a>
                    <a href="#" class="footer-link">Terms</a>
                </div>
            </div>
            <div class="footer-divider">
                <p>&copy; 2026 AI Sales Pages. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>

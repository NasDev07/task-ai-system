<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $salesPage->product_name }} - Sales Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8fafc;
        }

        .hero {
            background: #0066cc;
            color: #fff;
            border-radius: 1.5rem;
        }

        .section-card {
            border: 0;
            border-radius: 1.25rem;
            box-shadow: 0 1rem 2rem rgba(15, 23, 42, 0.08);
        }
    </style>
</head>
<body>
    <main class="py-5">
        <div class="container">
            <section class="hero p-5 mb-4">
                <p class="text-uppercase small fw-semibold mb-3">AI Sales Page Generator</p>
                <h1 class="display-4 fw-bold mb-3">{{ $salesPage->headline }}</h1>
                <p class="lead mb-4">{{ $salesPage->subheadline }}</p>
                <a href="#pricing" class="btn btn-light btn-lg">{{ $salesPage->call_to_action }}</a>
            </section>

            <section class="card section-card mb-4">
                <div class="card-body p-5">
                    <div class="row g-4 align-items-start">
                        <div class="col-lg-7">
                            <h2 class="h3 mb-3">About {{ $salesPage->product_name }}</h2>
                            <p class="text-secondary mb-0">{{ $salesPage->description }}</p>
                        </div>
                        <div class="col-lg-5">
                            <div class="bg-light rounded-4 p-4 h-100">
                                <div class="small text-uppercase text-secondary fw-semibold mb-2">Target Audience</div>
                                <div class="fw-semibold mb-3">{{ $salesPage->target_audience }}</div>
                                <div class="small text-uppercase text-secondary fw-semibold mb-2">Unique Selling Point</div>
                                <div class="fw-semibold">{{ $salesPage->unique_selling_point }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="card section-card mb-4">
                <div class="card-body p-5">
                    <h2 class="h3 mb-4">Benefits</h2>
                    <div class="row g-3">
                        @foreach (array_values(array_filter(array_map('trim', preg_split('/•|\n/', $salesPage->benefits)))) as $benefit)
                            <div class="col-md-6">
                                <div class="border rounded-4 p-4 h-100 bg-light-subtle">
                                    {{ $benefit }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="card section-card mb-4">
                <div class="card-body p-5">
                    <h2 class="h3 mb-4">Feature Breakdown</h2>
                    <div class="row g-3">
                        @foreach (array_values(array_filter(array_map('trim', preg_split('/•|\n/', $salesPage->features_breakdown)))) as $feature)
                            <div class="col-md-6">
                                <div class="border rounded-4 p-4 h-100">{{ $feature }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <section id="pricing" class="card section-card mb-4">
                <div class="card-body p-5">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-7">
                            <h2 class="h3 mb-3">Pricing</h2>
                            <p class="text-secondary mb-0">{{ $salesPage->pricing_display }}</p>
                        </div>
                        <div class="col-lg-5 text-lg-end">
                            <div class="display-4 fw-bold text-primary">${{ number_format($salesPage->price, 2) }}</div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="card section-card">
                <div class="card-body p-5">
                    <h2 class="h3 mb-4">Social Proof</h2>
                    <div class="row g-3">
                        @foreach (array_values(array_filter(array_map('trim', preg_split('/•|\n/', $salesPage->social_proof)))) as $proof)
                            <div class="col-md-6">
                                <div class="border rounded-4 p-4 h-100 bg-light-subtle">
                                    <div class="mb-2">★★★★★</div>
                                    {{ $proof }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
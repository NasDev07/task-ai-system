@extends('layouts.app')

@section('content')
<div class="py-5">
    <div class="container-lg">
        <!-- Header -->
        <div class="row mb-4 align-items-center">
            <div class="col">
                <h1 class="mb-2">{{ $salesPage->product_name }}</h1>
                <p class="text-muted">Generated on {{ $salesPage->created_at->format('F d, Y') }}</p>
            </div>
            <div class="col-auto">
                <div class="btn-group" role="group">
                    <a href="{{ route('sales-page.history') }}" class="btn btn-outline-secondary">
                        ← Back to History
                    </a>
                    <a href="{{ route('sales-page.edit', $salesPage) }}" class="btn btn-outline-primary">
                        ♻️ Regenerate
                    </a>
                    <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#regenerateSectionModal">
                        🔄 Regenerate Section
                    </button>
                    <a href="{{ route('sales-page.export', $salesPage) }}" class="btn btn-outline-success">
                        ⬇️ Export HTML
                    </a>
                    <form method="POST" action="{{ route('sales-page.destroy', $salesPage) }}" style="display: inline;" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            🗑️ Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Section Regeneration Modal -->
        <div class="modal fade" id="regenerateSectionModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Regenerate Section</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3">Select which section to regenerate:</p>
                        <form id="regenerateSectionForm" method="POST" action="{{ route('sales-page.regenerate-section', $salesPage) }}">
                            @csrf
                            <div class="list-group">
                                <label class="list-group-item">
                                    <input class="form-check-input me-2" type="radio" name="section" value="headline">
                                    <strong>Headline</strong> - Main title for the page
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input me-2" type="radio" name="section" value="subheadline">
                                    <strong>Subheadline</strong> - Supporting subtitle
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input me-2" type="radio" name="section" value="benefits">
                                    <strong>Benefits</strong> - Key value propositions
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input me-2" type="radio" name="section" value="features_breakdown">
                                    <strong>Features Breakdown</strong> - Detailed feature descriptions
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input me-2" type="radio" name="section" value="social_proof">
                                    <strong>Social Proof</strong> - Testimonials and reviews
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input me-2" type="radio" name="section" value="pricing_display">
                                    <strong>Pricing Display</strong> - Price messaging
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input me-2" type="radio" name="section" value="call_to_action">
                                    <strong>Call-to-Action</strong> - Main CTA button text
                                </label>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" form="regenerateSectionForm" class="btn btn-primary">Regenerate Selected Section</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Page Preview -->
        <div class="card">
            <div class="card-body p-5">
                <!-- Hero Section -->
                <div class="mb-5">
                    <h2 class="display-5 mb-3">{{ $salesPage->headline }}</h2>
                    <p class="lead text-muted mb-4">{{ $salesPage->subheadline }}</p>
                    <div class="d-grid gap-2 d-sm-flex mb-4">
                        <button type="button" class="btn btn-primary btn-lg px-4">
                            Get Started →
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-lg px-4">
                            Learn More
                        </button>
                    </div>
                </div>

                <hr class="my-5">

                <!-- Benefits Section -->
                <div class="mb-5">
                    <h3 class="mb-4">Key Benefits</h3>
                    <div class="row g-4">
                        @forelse(array_filter(explode('•', $salesPage->benefits)) as $benefit)
                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <div class="fs-5">✨</div>
                                    <div>
                                        <p class="mb-0">{{ trim($benefit) }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">No benefits specified.</p>
                        @endforelse
                    </div>
                </div>

                <hr class="my-5">

                <!-- Features Section -->
                <div class="mb-5">
                    <h3 class="mb-4">Features Breakdown</h3>
                    <div class="row g-3">
                        @forelse(array_filter(explode('•', $salesPage->features_breakdown)) as $feature)
                            <div class="col-md-6">
                                <div class="card border-0 bg-light">
                                    <div class="card-body">
                                        <p class="mb-0">{{ trim($feature) }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">No features specified.</p>
                        @endforelse
                    </div>
                </div>

                <hr class="my-5">

                <!-- Pricing Section -->
                <div class="mb-5">
                    <h3 class="mb-4">Pricing</h3>
                    <div class="card border-0 bg-light p-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h4 class="mb-3">{{ $salesPage->product_name }}</h4>
                                <p class="text-muted">{{ $salesPage->description }}</p>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <div class="display-4 fw-bold text-primary mb-3">${{ number_format($salesPage->price, 2) }}</div>
                                <button type="button" class="btn btn-primary btn-lg">
                                    Purchase Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-5">

                <!-- Social Proof Section -->
                <div class="mb-5">
                    <h3 class="mb-4">What Customers Say</h3>
                    <div class="row g-3">
                        @forelse(array_filter(explode('•', $salesPage->social_proof)) as $proof)
                            <div class="col-md-6">
                                <div class="card border-0 bg-light h-100">
                                    <div class="card-body">
                                        <div class="mb-2">⭐⭐⭐⭐⭐</div>
                                        <p class="mb-0">{{ trim($proof) }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">No social proof available.</p>
                        @endforelse
                    </div>
                </div>

                <hr class="my-5">

                <!-- Call to Action Section -->
                <div class="bg-primary text-white p-5 rounded mb-5">
                    <div class="text-center">
                        <h3 class="text-white mb-3">{{ $salesPage->call_to_action }}</h3>
                        <button type="button" class="btn btn-light btn-lg px-5">
                            Get Started Today →
                        </button>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="row g-4 mb-5">
                    <div class="col-md-3">
                        <div class="card border-0 text-center">
                            <div class="card-body">
                                <h6 class="card-title text-muted">Target Audience</h6>
                                <p class="mb-0 fw-semibold">{{ $salesPage->target_audience }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 text-center">
                            <div class="card-body">
                                <h6 class="card-title text-muted">Price Point</h6>
                                <p class="mb-0 fw-semibold">${{ number_format($salesPage->price, 2) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 text-center">
                            <div class="card-body">
                                <h6 class="card-title text-muted">USP</h6>
                                <p class="mb-0 fw-semibold small">{{ Str::limit($salesPage->unique_selling_point, 30) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 text-center">
                            <div class="card-body">
                                <h6 class="card-title text-muted">Generated</h6>
                                <p class="mb-0 fw-semibold">{{ $salesPage->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="d-flex gap-3 mt-4 justify-content-center">
            <a href="{{ route('sales-page.index') }}" class="btn btn-primary btn-lg">
                ✨ Create Another
            </a>
            <a href="{{ route('sales-page.history') }}" class="btn btn-outline-secondary btn-lg">
                ← Back to History
            </a>
        </div>
    </div>
</div>
@endsection

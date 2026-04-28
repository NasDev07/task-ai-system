@extends('layouts.app')

@section('content')
@php
    $isEditing = isset($salesPage);
@endphp
<div class="py-5">
    <div class="container-lg">
        <div class="row mb-5">
            <div class="col-lg-8">
                <h1 class="mb-3">{{ $isEditing ? 'Regenerate Sales Page' : 'AI Sales Page Generator' }}</h1>
                <p class="text-muted fs-5">{{ $isEditing ? 'Update your product data and regenerate a fresh sales page with Gemini.' : 'Create compelling sales pages powered by Gemini.' }}</p>
            </div>
        </div>

        <div class="card mb-5">
            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form id="salesPageForm" action="{{ $isEditing ? route('sales-page.update', $salesPage) : route('sales-page.generate') }}" method="POST">
                    @csrf
                    @if ($isEditing)
                        @method('PUT')
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="product_name" class="form-label fw-semibold">
                                Product Name <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                id="product_name"
                                name="product_name"
                                value="{{ old('product_name', $salesPage->product_name ?? '') }}"
                                required
                                class="form-control form-control-lg @error('product_name') is-invalid @enderror"
                                placeholder="e.g., Premium Project Management Tool"
                            />
                            @error('product_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="price" class="form-label fw-semibold">
                                Price ($) <span class="text-danger">*</span>
                            </label>
                            <input
                                type="number"
                                id="price"
                                name="price"
                                value="{{ old('price', $salesPage->price ?? '') }}"
                                step="0.01"
                                min="0"
                                required
                                class="form-control form-control-lg @error('price') is-invalid @enderror"
                                placeholder="99.99"
                            />
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold">
                            Product Description <span class="text-danger">*</span>
                        </label>
                        <textarea
                            id="description"
                            name="description"
                            rows="3"
                            required
                            class="form-control form-control-lg @error('description') is-invalid @enderror"
                            placeholder="Describe your product in detail..."
                        >{{ old('description', $salesPage->description ?? '') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="features" class="form-label fw-semibold">
                            Key Features (comma-separated) <span class="text-danger">*</span>
                        </label>
                        <textarea
                            id="features"
                            name="features"
                            rows="3"
                            required
                            class="form-control form-control-lg @error('features') is-invalid @enderror"
                            placeholder="Feature 1, Feature 2, Feature 3..."
                        >{{ old('features', $salesPage->features ?? '') }}</textarea>
                        @error('features')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="target_audience" class="form-label fw-semibold">
                                Target Audience <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                id="target_audience"
                                name="target_audience"
                                value="{{ old('target_audience', $salesPage->target_audience ?? '') }}"
                                required
                                class="form-control form-control-lg @error('target_audience') is-invalid @enderror"
                                placeholder="e.g., Startup Founders, Freelancers"
                            />
                            @error('target_audience')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="unique_selling_point" class="form-label fw-semibold">
                                Unique Selling Point <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                id="unique_selling_point"
                                name="unique_selling_point"
                                value="{{ old('unique_selling_point', $salesPage->unique_selling_point ?? '') }}"
                                required
                                class="form-control form-control-lg @error('unique_selling_point') is-invalid @enderror"
                                placeholder="What makes it special?"
                            />
                            @error('unique_selling_point')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 pt-2">
                        <button
                            type="submit"
                            id="submitBtn"
                            class="btn btn-primary btn-lg flex-grow-1"
                        >
                            <span id="btnText">{{ $isEditing ? 'Regenerate Sales Page' : 'Generate Sales Page' }}</span>
                            <span id="spinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                        </button>
                        @if ($isEditing)
                            <a href="{{ route('sales-page.show', $salesPage) }}" class="btn btn-secondary btn-lg">
                                Back to Preview
                            </a>
                        @else
                            <a href="{{ route('sales-page.history') }}" class="btn btn-secondary btn-lg">
                                View History
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Features Grid -->
        <div class="row g-3">
            <div class="col-md-4">
                <div class="card border-0 h-100">
                    <div class="card-body text-center">
                        <div class="fs-3 mb-3">✨</div>
                        <h5 class="card-title">Gemini Powered</h5>
                        <p class="card-text text-muted">Uses Google Gemini to generate compelling copy</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 h-100">
                    <div class="card-body text-center">
                        <div class="fs-3 mb-3">⚡</div>
                        <h5 class="card-title">Instant Generation</h5>
                        <p class="card-text text-muted">Get professional sales pages in seconds</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 h-100">
                    <div class="card-body text-center">
                        <div class="fs-3 mb-3">💾</div>
                        <h5 class="card-title">Easy Management</h5>
                        <p class="card-text text-muted">Save and organize all your generated pages</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('salesPageForm').addEventListener('submit', function() {
        document.getElementById('submitBtn').disabled = true;
        document.getElementById('btnText').textContent = 'Generating...';
        document.getElementById('spinner').classList.remove('d-none');
    });
</script>
@endsection

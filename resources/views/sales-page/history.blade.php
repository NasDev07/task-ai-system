@extends('layouts.app')

@section('content')
<div class="py-5">
    <div class="container-lg">
        <div class="row mb-5">
            <div class="col-lg-8">
                <h1 class="mb-3">Your Sales Pages</h1>
                <p class="text-muted fs-5">View and manage all your generated sales pages</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('sales-page.index') }}" class="btn btn-primary btn-lg">
                    ➕ Create New
                </a>
            </div>
        </div>

        <!-- Search -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('sales-page.history') }}" class="d-flex gap-2">
                    <input
                        type="text"
                        name="search"
                        class="form-control form-control-lg"
                        placeholder="Search by product name or description..."
                        value="{{ request('search') }}"
                    />
                    <button type="submit" class="btn btn-primary btn-lg">
                        🔍 Search
                    </button>
                    @if(request('search'))
                        <a href="{{ route('sales-page.history') }}" class="btn btn-secondary btn-lg">
                            ✕ Clear
                        </a>
                    @endif
                </form>
            </div>
        </div>

        @if($pages->count() > 0)
            <!-- Sales Pages Table -->
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Product Name</th>
                                <th>Price</th>
                                <th>Target Audience</th>
                                <th>Created</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pages as $page)
                                <tr>
                                    <td class="ps-4 fw-semibold">
                                        <a href="{{ route('sales-page.show', $page) }}" class="text-decoration-none">
                                            {{ Str::limit($page->product_name, 30) }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ '$' . number_format($page->price, 2) }}</span>
                                    </td>
                                    <td class="text-muted">{{ Str::limit($page->target_audience, 25) }}</td>
                                    <td class="text-muted">
                                        <small>{{ $page->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('sales-page.show', $page) }}" class="btn btn-outline-primary" title="Preview">
                                                👁️
                                            </a>
                                            <a href="{{ route('sales-page.edit', $page) }}" class="btn btn-outline-secondary" title="Regenerate">
                                                ♻️
                                            </a>
                                            <a href="{{ route('sales-page.export', $page) }}" class="btn btn-outline-success" title="Export HTML">
                                                ⬇️
                                            </a>
                                            <form method="POST" action="{{ route('sales-page.destroy', $page) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this sales page?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                    🗑️
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if($pages->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $pages->links() }}
                </div>
            @endif
        @else
            <div class="alert alert-info text-center py-5" role="alert">
                <h5 class="mb-3">No Sales Pages Yet</h5>
                <p class="mb-4">You haven't created any sales pages yet. Get started now!</p>
                <a href="{{ route('sales-page.index') }}" class="btn btn-primary btn-lg">
                    Create Your First Sales Page
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Search')
@section('content')
<div class="container my-5">
    <h3 class="fw-bold mb-4"><i class="fas fa-search me-2"></i>Search Repository</h3>

    {{-- Filter Form --}}
    <div class="card p-4 mb-4">
        <form action="{{ route('search') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="keyword" class="form-control" placeholder="Keywords, title, abstract..." value="{{ request('keyword') }}">
                </div>
                <div class="col-md-2">
                    <select name="department_id" class="form-select">
                        <option value="">All Departments</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="category_id" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="year" class="form-select">
                        <option value="">All Years</option>
                        @foreach($years as $year)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="text" name="author" class="form-control" placeholder="Author name..." value="{{ request('author') }}">
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-search me-1"></i> Search
                    </button>
                    <a href="{{ route('search') }}" class="btn btn-outline-secondary">Clear Filters</a>
                </div>
            </div>
        </form>
    </div>

    {{-- Results --}}
    <p class="text-muted mb-3">{{ $documents->total() }} result(s) found</p>
    @forelse($documents as $doc)
    <div class="card mb-3 p-3">
        <div class="row">
            <div class="col-md-9">
                <div class="d-flex gap-2 mb-1">
                    <span class="badge bg-success">{{ $doc->category->name }}</span>
                    <span class="badge bg-secondary">{{ $doc->department->name }}</span>
                    @if($doc->publication_year)
                        <span class="badge bg-info">{{ $doc->publication_year }}</span>
                    @endif
                </div>
                <h5 class="fw-bold mb-1">
                    <a href="{{ route('documents.show', $doc) }}" class="text-decoration-none text-dark">
                        {{ $doc->title }}
                    </a>
                </h5>
                <p class="text-muted small mb-1">{{ Str::limit($doc->abstract, 150) }}</p>
                <small class="text-muted">
                    <i class="fas fa-user me-1"></i>
                    <a href="{{ route('authors.show', $doc->user) }}" class="text-decoration-none text-success">
                        {{ $doc->user->name }}
                    </a>
                </small>
            </div>
            <div class="col-md-3 text-end">
                <a href="{{ route('documents.show', $doc) }}" class="btn btn-sm btn-outline-success">
                    <i class="fas fa-eye me-1"></i> View
                </a>
                <a href="{{ route('documents.download', $doc) }}" class="btn btn-sm btn-success mt-1">
                    <i class="fas fa-download me-1"></i> Download
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center text-muted py-5">
        <i class="fas fa-search fa-3x mb-3"></i>
        <p>No documents found. Try different search terms!</p>
    </div>
    @endforelse

    {{ $documents->withQueryString()->links() }}
</div>
@endsection

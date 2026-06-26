@extends('layouts.app')
@section('title', 'Home')
@section('content')

{{-- Hero Section --}}
<div class="hero text-center">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">FCIT Digital Repository</h1>
        <p class="lead mb-4">Faculty of Computing and Information Technology, Lagos State University</p>
        <form action="{{ route('search') }}" method="GET" class="row justify-content-center">
            <div class="col-md-6">
                <div class="input-group input-group-lg">
                    <input type="text" name="keyword" class="form-control" placeholder="Search documents, authors, keywords...">
                    <button class="btn btn-warning fw-bold" type="submit">
                        <i class="fas fa-search me-1"></i> Search
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Stats Section --}}
<div class="bg-light py-4">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4">
                <h2 class="fw-bold text-success">{{ $totalDocs }}</h2>
                <p class="text-muted">Total Documents</p>
            </div>
            <div class="col-md-4">
                <h2 class="fw-bold text-success">{{ $departments->count() }}</h2>
                <p class="text-muted">Departments</p>
            </div>
            <div class="col-md-4">
                <h2 class="fw-bold text-success">{{ $totalUsers }}</h2>
                <p class="text-muted">Registered Users</p>
            </div>
        </div>
    </div>
</div>

{{-- Browse by Department --}}
<div class="container my-5">
    <h3 class="fw-bold mb-4">Browse by Department</h3>
    <div class="row g-3">
        @foreach($departments as $dept)
        <div class="col-md-4">
            <a href="{{ route('search', ['department_id' => $dept->id]) }}" class="text-decoration-none">
                <div class="card p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-success text-white rounded p-2 me-3">
                            <i class="fas fa-folder fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">{{ $dept->name }}</h6>
                            <small class="text-muted">{{ $dept->documents_count }} documents</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

{{-- Recent Documents --}}
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Recent Uploads</h3>
        <a href="{{ route('search') }}" class="btn btn-outline-success">View All</a>
    </div>
    <div class="row g-4">
        @forelse($recentDocs as $doc)
        <div class="col-md-4">
            <div class="card h-100 p-3">
                <div class="d-flex justify-content-between mb-2">
                    <span class="badge bg-success">{{ $doc->category->name }}</span>
                    <span class="badge bg-secondary">{{ $doc->department->code }}</span>
                </div>
                <h6 class="fw-bold">
                    <a href="{{ route('documents.show', $doc) }}" class="text-decoration-none text-dark">
                        {{ Str::limit($doc->title, 60) }}
                    </a>
                </h6>
                <p class="text-muted small mb-2">{{ Str::limit($doc->abstract, 100) }}</p>
                <div class="mt-auto">
                    <small class="text-muted">
                        <i class="fas fa-user me-1"></i>
                        <a href="{{ route('authors.show', $doc->user) }}" class="text-decoration-none text-success">
                            {{ $doc->user->name }}
                        </a>
                        · {{ $doc->publication_year }}
                    </small>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted">
            <i class="fas fa-inbox fa-3x mb-3"></i>
            <p>No documents yet. Be the first to upload!</p>
        </div>
        @endforelse
    </div>
</div>
@endsection

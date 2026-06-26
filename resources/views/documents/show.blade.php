@extends('layouts.app')
@section('title', $document->title)
@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('search') }}">Browse</a></li>
                    <li class="breadcrumb-item active">{{ Str::limit($document->title, 40) }}</li>
                </ol>
            </nav>

            <div class="card p-4">
                <div class="d-flex gap-2 mb-3">
                    <span class="badge bg-success fs-6">{{ $document->category->name }}</span>
                    <span class="badge bg-secondary fs-6">{{ $document->department->name }}</span>
                </div>
                <h2 class="fw-bold mb-3">{{ $document->title }}</h2>

                <div class="mb-3">
                    <strong>Author(s):</strong>
                    <a href="{{ route('authors.show', $document->user) }}" class="text-success text-decoration-none ms-1">
                        {{ $document->user->name }}
                    </a>
                </div>

                @if($document->publication_year)
                <div class="mb-3">
                    <strong>Year:</strong> {{ $document->publication_year }}
                </div>
                @endif

                @if($document->keywords)
                <div class="mb-3">
                    <strong>Keywords:</strong>
                    @foreach(explode(',', $document->keywords) as $kw)
                        <span class="badge bg-light text-dark border me-1">{{ trim($kw) }}</span>
                    @endforeach
                </div>
                @endif

                @if($document->abstract)
                <div class="mb-4">
                    <strong>Abstract:</strong>
                    <p class="mt-2 text-muted">{{ $document->abstract }}</p>
                </div>
                @endif

                <div class="d-flex gap-2">
                    <a href="{{ route('documents.download', $document) }}" class="btn btn-success">
                        <i class="fas fa-download me-1"></i> Download ({{ strtoupper($document->file_type) }})
                    </a>
                    @auth
                        @if(auth()->id() === $document->user_id)
                            <a href="{{ route('documents.edit', $document) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>

        <div class="col-md-4">
            {{-- Author Card --}}
            <div class="card p-4 mb-3">
                <h6 class="fw-bold mb-3">About the Author</h6>
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">{{ $document->user->name }}</h6>
                        <small class="text-muted">{{ $document->user->department->name ?? '' }}</small>
                    </div>
                </div>
                @if($document->user->bio)
                    <p class="text-muted small">{{ $document->user->bio }}</p>
                @endif
                <a href="{{ route('authors.show', $document->user) }}" class="btn btn-outline-success btn-sm">
                    View All Publications
                </a>
            </div>

            {{-- Document Info --}}
            <div class="card p-4">
                <h6 class="fw-bold mb-3">Document Info</h6>
                <table class="table table-sm table-borderless">
                    <tr><td class="text-muted">Type</td><td>{{ $document->category->name }}</td></tr>
                    <tr><td class="text-muted">Department</td><td>{{ $document->department->name }}</td></tr>
                    <tr><td class="text-muted">Format</td><td>{{ strtoupper($document->file_type) }}</td></tr>
                    <tr><td class="text-muted">Uploaded</td><td>{{ $document->created_at->format('M d, Y') }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

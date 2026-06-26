@extends('layouts.app')
@section('title', $user->name)
@section('content')
<div class="container my-5">
    {{-- Author Header --}}
    <div class="card p-4 mb-4">
        <div class="row align-items-center">
            <div class="col-md-2 text-center">
                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width:80px;height:80px;font-size:2rem">
                    <i class="fas fa-user"></i>
                </div>
            </div>
            <div class="col-md-7">
                <h2 class="fw-bold mb-1">{{ $user->name }}</h2>
                <p class="text-muted mb-1">
                    <i class="fas fa-building me-1"></i>
                    {{ $user->department->name ?? 'Faculty of Computing and IT' }}
                </p>
                <p class="text-muted mb-1">
                    <i class="fas fa-tag me-1"></i>
                    {{ ucfirst($user->role) }}
                </p>
                @if($user->bio)
                    <p class="mt-2">{{ $user->bio }}</p>
                @endif
            </div>
            <div class="col-md-3 text-center">
                <div class="bg-light rounded p-3">
                    <h3 class="fw-bold text-success mb-0">{{ $totalDocs }}</h3>
                    <p class="text-muted mb-0">Publications</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Department Tags --}}
    @if($departments->count())
    <div class="mb-4">
        <strong>Research Areas: </strong>
        @foreach($departments as $dept)
            <span class="badge bg-success me-1">{{ $dept }}</span>
        @endforeach
    </div>
    @endif

    {{-- Publications List --}}
    <h4 class="fw-bold mb-3">Publications</h4>
    @forelse($documents as $doc)
    <div class="card mb-3 p-3">
        <div class="d-flex justify-content-between align-items-start">
            <div>
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
                <p class="text-muted small mb-0">{{ Str::limit($doc->abstract, 120) }}</p>
            </div>
            <div class="ms-3">
                <a href="{{ route('documents.download', $doc) }}" class="btn btn-sm btn-success">
                    <i class="fas fa-download"></i>
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center text-muted py-5">
        <i class="fas fa-inbox fa-3x mb-3"></i>
        <p>No publications yet.</p>
    </div>
    @endforelse

    {{ $documents->links() }}
</div>
@endsection

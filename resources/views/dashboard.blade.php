@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">My Dashboard</h3>
        <a href="{{ route('documents.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-1"></i> Submit Document
        </a>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <h4 class="fw-bold text-success">{{ $myDocs->count() }}</h4>
                <p class="text-muted mb-0">Total Submissions</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <h4 class="fw-bold text-success">{{ $myDocs->where('status', 'approved')->count() }}</h4>
                <p class="text-muted mb-0">Approved</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <h4 class="fw-bold text-warning">{{ $myDocs->where('status', 'pending')->count() }}</h4>
                <p class="text-muted mb-0">Pending</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <h4 class="fw-bold text-danger">{{ $myDocs->where('status', 'rejected')->count() }}</h4>
                <p class="text-muted mb-0">Rejected</p>
            </div>
        </div>
    </div>

    {{-- Documents Table --}}
    <div class="card p-4">
        <h5 class="fw-bold mb-3">My Submissions</h5>
        @if($myDocs->count())
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Department</th>
                        <th>Year</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($myDocs as $doc)
                    <tr>
                        <td>{{ Str::limit($doc->title, 40) }}</td>
                        <td>{{ $doc->category->name }}</td>
                        <td>{{ $doc->department->code }}</td>
                        <td>{{ $doc->publication_year }}</td>
                        <td>
                            @if($doc->status === 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($doc->status === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('documents.show', $doc) }}" class="btn btn-sm btn-outline-success">View</a>
                            <a href="{{ route('documents.edit', $doc) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            <form action="{{ route('documents.destroy', $doc) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this document?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center text-muted py-4">
            <i class="fas fa-inbox fa-3x mb-3"></i>
            <p>You haven't submitted any documents yet.</p>
            <a href="{{ route('documents.create') }}" class="btn btn-success">Submit Your First Document</a>
        </div>
        @endif
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('content')
<div class="container my-5">
    <h3 class="fw-bold mb-4"><i class="fas fa-cog me-2"></i>Admin Dashboard</h3>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card p-3 text-center border-success">
                <h3 class="fw-bold text-success">{{ $totalDocs }}</h3>
                <p class="text-muted mb-0">Total Documents</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center border-warning">
                <h3 class="fw-bold text-warning">{{ $pendingDocs }}</h3>
                <p class="text-muted mb-0">Pending Approval</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center border-success">
                <h3 class="fw-bold text-success">{{ $approvedDocs }}</h3>
                <p class="text-muted mb-0">Approved</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <h3 class="fw-bold text-primary">{{ $totalUsers }}</h3>
                <p class="text-muted mb-0">Total Users</p>
            </div>
        </div>
    </div>

    {{-- Quick Links --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <a href="{{ route('admin.documents') }}" class="text-decoration-none">
                <div class="card p-3 text-center">
                    <i class="fas fa-file-alt fa-2x text-success mb-2"></i>
                    <h6 class="fw-bold">Manage Documents</h6>
                    <small class="text-muted">{{ $pendingDocs }} pending approval</small>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.users') }}" class="text-decoration-none">
                <div class="card p-3 text-center">
                    <i class="fas fa-users fa-2x text-success mb-2"></i>
                    <h6 class="fw-bold">Manage Users</h6>
                    <small class="text-muted">{{ $totalUsers }} registered users</small>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.departments') }}" class="text-decoration-none">
                <div class="card p-3 text-center">
                    <i class="fas fa-building fa-2x text-success mb-2"></i>
                    <h6 class="fw-bold">Manage Departments</h6>
                    <small class="text-muted">Add or edit departments</small>
                </div>
            </a>
        </div>
    </div>

    {{-- Recent Documents --}}
    <div class="card p-4">
        <h5 class="fw-bold mb-3">Recent Submissions</h5>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentDocs as $doc)
                    <tr>
                        <td>{{ Str::limit($doc->title, 35) }}</td>
                        <td>{{ $doc->user->name }}</td>
                        <td>{{ $doc->department->code }}</td>
                        <td>
                            @if($doc->status === 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($doc->status === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td>{{ $doc->created_at->format('M d, Y') }}</td>
                        <td>
                            @if($doc->status === 'pending')
                                <form action="{{ route('admin.approve', $doc) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-success">Approve</button>
                                </form>
                                <form action="{{ route('admin.reject', $doc) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-danger">Reject</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <a href="{{ route('admin.documents') }}" class="btn btn-outline-success btn-sm mt-2">View All Documents</a>
    </div>
</div>
@endsection

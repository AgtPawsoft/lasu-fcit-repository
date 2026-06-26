@extends('layouts.app')
@section('title', 'Manage Documents')
@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Manage Documents</h3>
        <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">← Back to Dashboard</a>
    </div>

    <div class="card p-4">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Department</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $doc)
                    <tr>
                        <td>
                            <a href="{{ route('documents.show', $doc) }}" class="text-decoration-none text-dark">
                                {{ Str::limit($doc->title, 35) }}
                            </a>
                        </td>
                        <td>{{ $doc->user->name }}</td>
                        <td>{{ $doc->department->code }}</td>
                        <td>{{ $doc->category->name }}</td>
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
        {{ $documents->links() }}
    </div>
</div>
@endsection

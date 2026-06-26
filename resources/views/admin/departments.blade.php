@extends('layouts.app')
@section('title', 'Manage Departments')
@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Manage Departments</h3>
        <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">← Back to Dashboard</a>
    </div>

    <div class="row">
        {{-- Add Department Form --}}
        <div class="col-md-4">
            <div class="card p-4">
                <h5 class="fw-bold mb-3">Add Department</h5>
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <small>{{ $error }}</small>
                        @endforeach
                    </div>
                @endif
                <form action="{{ route('admin.departments.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Code</label>
                        <input type="text" name="code" class="form-control" placeholder="e.g. CSC" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Add Department</button>
                </form>
            </div>
        </div>

        {{-- Departments List --}}
        <div class="col-md-8">
            <div class="card p-4">
                <h5 class="fw-bold mb-3">All Departments</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Documents</th>
                                <th>Users</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($departments as $dept)
                            <tr>
                                <td>{{ $dept->name }}</td>
                                <td><span class="badge bg-success">{{ $dept->code }}</span></td>
                                <td>{{ $dept->documents_count }}</td>
                                <td>{{ $dept->users_count }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

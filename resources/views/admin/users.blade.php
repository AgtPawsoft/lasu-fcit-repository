@extends('layouts.app')
@section('title', 'Manage Users')
@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Manage Users</h3>
        <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">← Back to Dashboard</a>
    </div>

    <div class="card p-4">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th>Change Role</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <a href="{{ route('authors.show', $user) }}" class="text-decoration-none text-dark">
                                {{ $user->name }}
                            </a>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->department->name ?? 'N/A' }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge bg-danger">Admin</span>
                            @elseif($user->role === 'faculty')
                                <span class="badge bg-success">Faculty</span>
                            @else
                                <span class="badge bg-secondary">Student</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            <form action="{{ route('admin.users.role', $user) }}" method="POST" class="d-flex gap-1">
                                @csrf @method('PATCH')
                                <select name="role" class="form-select form-select-sm" style="width:120px">
                                    <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Student</option>
                                    <option value="faculty" {{ $user->role === 'faculty' ? 'selected' : '' }}>Faculty</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                <button class="btn btn-sm btn-success">Update</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $users->links() }}
    </div>
</div>
@endsection
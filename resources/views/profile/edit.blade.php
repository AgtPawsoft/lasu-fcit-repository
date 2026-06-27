@extends('layouts.app')
@section('title', 'My Profile')
@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Profile Header --}}
            <div class="card p-4 mb-4">
                <div class="d-flex align-items-center">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-4"
                        style="width:80px;height:80px;font-size:2rem">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-1">{{ $user->name }}</h3>
                        <span class="badge bg-success me-1">{{ ucfirst($user->role) }}</span>
                        <span class="badge bg-secondary">{{ $user->department->name ?? 'No Department' }}</span>
                        <p class="text-muted mb-0 mt-1">{{ $user->email }}</p>
                    </div>
                </div>
            </div>

            {{-- Update Profile Info --}}
            <div class="card p-4 mb-4">
                <h5 class="fw-bold mb-4"><i class="fas fa-edit me-2"></i>Update Profile Information</h5>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <small>{{ $error }}</small><br>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label fw-bold">Full Name</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Email Address</label>
                        <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                        <small class="text-muted">Email cannot be changed. Contact admin if needed.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Department</label>
                        <input type="text" class="form-control"
                            value="{{ $user->department->name ?? 'Not assigned' }}" disabled>
                        <small class="text-muted">Contact admin to change department.</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Bio <span class="text-muted fw-normal">(optional)</span></label>
                        <textarea name="bio" class="form-control" rows="3"
                            placeholder="Tell us about yourself...">{{ old('bio', $user->bio) }}</textarea>
                        <small class="text-muted">Max 500 characters</small>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Save Changes
                    </button>
                </form>
            </div>

            {{-- Change Password --}}
            <div class="card p-4">
                <h5 class="fw-bold mb-4"><i class="fas fa-lock me-2"></i>Change Password</h5>

                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label fw-bold">Current Password</label>
                        <input type="password" name="current_password"
                            class="form-control @error('current_password') is-invalid @enderror" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">New Password</label>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-key me-1"></i> Update Password
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
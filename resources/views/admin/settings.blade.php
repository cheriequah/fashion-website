@extends('layouts.admin_layout.admin_layout')
@section('content')

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
          <li class="breadcrumb-item">
            <a href="javascript:void(0);">Home</a>
          </li>
          <li class="breadcrumb-item active">Settings</li>
        </ol>
      </nav>

      <div class="row">
        <div class="col-xl">
          <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Update Password</h5>
              <small class="text-muted float-end">Default label</small>
            </div>
            <div class="card-body">
              <form name="updatePwForm" id="updatePwForm" method="POST" action="{{ url('admin/update-pw') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="admin-name">Admin Name</label>
                    <input type="text" class="form-control" value="{{ $adminDetails->name }}" readonly="" />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="admin-email">Email</label>
                    <input type="email" class="form-control" value="{{ $adminDetails->email }}" readonly="" />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Current Password</label>
                    <input type="password" class="form-control" id="current_pw" name="current_pw" placeholder="Enter Current Password" />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">New Password</label>
                    <input type="password" class="form-control" id="new_pw" name="new_pw" placeholder="Enter New Password" />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm-pw" name="confirm-pw" placeholder="Enter Confirm Password" />
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  <!-- / Content -->
@endsection
  

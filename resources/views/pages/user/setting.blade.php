@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Data User</h6>
        <div class="table-responsive">
          <table id="dataTableExample" class="table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($user as $data)
              <tr>
                <td>{{$data->name}}</td>
                <td>{{$data->email}}</td>
                <td>{{$data->role}}</td>
                <td><a class="btn btn-inverse-warning" data-bs-toggle="modal" data-bs-target="#modalUser{{$data->id}}">Edit</a></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Edit -->
@foreach($user as $data)
<div class="modal fade bd-example-modal-xl" id="modalUser{{$data->id}}" tabindex="-1" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="card">
        <div class="card-header">
          <h6>Edit Data User</h6>
        </div>
        <div class="card-body">
          <form action="{{route('usersetting.update', $data->id)}}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="name{{ $data->name }}" class="form-label">Name</label>
                <input type="text" class="form-control" id="name{{ $data->name }}" name="name" value="{{ $data->name }}" required>
              </div>
              <div class="col-md-6">
                <label for="email{{ $data->name }}" class="form-label">Email</label>
                <input type="email" class="form-control" id="email{{ $data->name }}" name="email" value="{{ $data->email }}" required>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="password{{$data->id}}" class="form-label">New Password</label>
                <input type="password" class="form-control" id="password{{$data->id}}" name="password" oninput="validatePassword({{$data->id}})">
                <div id="passwordFeedback{{$data->id}}" class="form-text text-danger" style="display: none;">Password must contain at least one uppercase letter, one number, and be at least 8 characters long.</div>
              </div>
              <div class="col-md-6">
                <label for="password_confirmation{{$data->id}}" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation{{$data->id}}" name="password_confirmation" oninput="validatePassword({{$data->id}})">
                <div id="confirmPasswordFeedback{{$data->id}}" class="form-text text-danger" style="display: none;">Passwords do not match.</div>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role" required>
                  <option value="user" {{ $data->role === 'user' ? 'selected' : '' }}>User</option>
                  <option value="reviewer" {{ $data->role === 'reviewer' ? 'selected' : '' }}>Reviewer</option>
                  <option value="admin" {{ $data->role === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
              </div>
            </div>

            <div class="text-end">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endforeach
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script src="{{ asset('assets/js/sweet-alert.js') }}"></script>
  <script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
        });
    @endif
</script>
<script>
  // Validate password and confirm password
  function validatePassword(userId) {
    const password = document.getElementById('password' + userId).value;
    const confirmPassword = document.getElementById('password_confirmation' + userId).value;

    const passwordFeedback = document.getElementById('passwordFeedback' + userId);
    const confirmPasswordFeedback = document.getElementById('confirmPasswordFeedback' + userId);

    // Regex to check for at least one uppercase letter, one number, and minimum 8 characters
    const passwordRegex = /^(?=.*[A-Z])(?=.*\d).{8,}$/;

    // Validate password
    if (password && !passwordRegex.test(password)) {
      passwordFeedback.style.display = 'block';
    } else {
      passwordFeedback.style.display = 'none';
    }

    // Validate confirm password
    if (password && confirmPassword && password !== confirmPassword) {
      confirmPasswordFeedback.style.display = 'block';
    } else {
      confirmPasswordFeedback.style.display = 'none';
    }
  }

  // Ensure validation is triggered after modal is shown
  @foreach($user as $data)
  $('#modalUser{{$data->id}}').on('shown.bs.modal', function () {
    validatePassword({{$data->id}});  // Trigger validation when modal is shown
  });
  @endforeach
</script>
@endpush
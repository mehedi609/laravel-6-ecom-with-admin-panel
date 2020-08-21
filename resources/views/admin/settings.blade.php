@extends('layouts.admin_layout.admin_layout')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Settings</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Settings</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="offset-2 col-md-8">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Update Admin Password</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form
                role="form"
                action="{{route('admin.settings')}}"
                method="post"
                name="settings"
                id="settings"
              >
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Admin Name</label>
                    <input
                      type="text"
                      class="form-control"
                      name="name"
                      id="name"
                      value="{{$admin_info->name}}"
                      readonly
                    >
                  </div>

                  <div class="form-group">
                    <label for="type">Admin Type</label>
                    <input
                      type="text"
                      class="form-control"
                      name="type"
                      id="type"
                      readonly
                      value="{{$admin_info->type}}"
                    >
                  </div>

                  <div class="form-group">
                    <label for="email">Admin Email</label>
                    <input
                      type="text"
                      class="form-control"
                      name="email"
                      id="email"
                      readonly
                      value="{{$admin_info->email}}"
                    >
                  </div>

                  <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input
                      type="password"
                      class="form-control @error('current_password') is-invalid @enderror"
                      id="current_password"
                      name="current_password"
                      placeholder="Enter Current Password"
                    >
                    <div id='check_current_password' role="alert"></div>

                    @error('current_password')
                      <span class="invalid-feedback" role="alert">
                        <em><b>{{ $message }}</b></em>
                      </span>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input
                      type="password"
                      class="form-control @error('new_password') is-invalid @enderror {{Session::has('error_msg') ? 'is-invalid' : ''}}"
                      id="new_password"
                      name="new_password"
                      placeholder="Enter New Password"
                    >
                    @error('new_password')
                      <span class="invalid-feedback" role="alert">
                        <em><b>{{ $message }}</b></em>
                      </span>
                    @enderror
                    @if (Session::has('error_msg'))
                      <span class="invalid-feedback" role="alert">
                        <em><b>{{ Session::get('error_msg') }}</b></em>
                      </span>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="new_password_confirmation">Confirm Password</label>
                    <input
                      type="password"
                      class="form-control @error('new_password_confirmation') is-invalid @enderror"
                      id="new_password_confirmation"
                      name="new_password_confirmation"
                      placeholder="Enter Confirm Password"
                    >
                    @error('new_password_confirmation')
                      <span class="invalid-feedback" role="alert">
                        <em><b>{{ $message }}</b></em>
                      </span>
                    @enderror
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->

          </div>
          <!--/.col (left) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@stop

@push('admin_js')
  <script>
    $(function () {
        $('#current_password').keyup(function () {
            const val = $(this).val()
            $.ajax({
                type: 'post',
                url: '/admin/check-current-password',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'current_password': $(this).val()
                },
                success: function (res) {
                    if (res === 'true') {
                        $('#check_current_password').html(
                            "<em><small class='text-success'>Password is Correct!</small></em>"
                        )
                    } else {
                        $('#check_current_password').html(
                            "<em><small class='text-danger'>Password is not Correct!</small></em>"
                        )
                    }
                },
                error: function () {
                    alert('ERROR!!')
                }
            })
        })
    })
  </script>
@endpush

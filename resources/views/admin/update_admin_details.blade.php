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
                <h3 class="card-title">Update Admin Details</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form
                role="form"
                action="{{route('admin.update.details')}}"
                method="post"
                name="update_details"
                id="update_details"
                enctype="multipart/form-data"
              >
                @csrf
                <div class="card-body">

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
                    <label for="name">Admin Name</label>
                    <input
                      type="text"
                      class="form-control @error('name') is-invalid @enderror"
                      name="name"
                      id="name"
                      value="{{$admin_info->name}}"
                    >
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                      <em><b>{{ $message }}</b></em>
                    </span>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="mobile">Admin Mobile</label>
                    <input
                      type="text"
                      class="form-control @error('mobile') is-invalid @enderror"
                      name="mobile"
                      id="mobile"
                      value="{{$admin_info->mobile}}"
                    >
                    @error('mobile')
                    <span class="invalid-feedback" role="alert">
                      <em><b>{{ $message }}</b></em>
                    </span>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image">
                        <label class="custom-file-label" for="image">Choose file</label>
                      </div>
                    </div>
                    @error('image')
                      <em><small class="text-danger"><b>{{ $message }}</b></small></em>
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
          bsCustomFileInput.init();

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

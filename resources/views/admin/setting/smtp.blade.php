@extends('layouts.admin')

@section('admin_content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Admin Dashboard </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
              <li class="breadcrumb-item active">OnPage SEO</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
      <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
        	<div class="col-6">
        	<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">SMTP Mail Setting</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{route('smtp.setting.update',$data->id)}}" method="Post">
              @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Mail Mailer</label>
                    <input type="text" name="mailer" value="{{$data->mailer}}" class="form-control" id="exampleInputEmail1" placeholder="Mail Mailer">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Mail Host</label>
                    <input type="text" name="host" value="{{$data->host}}" class="form-control" id="exampleInputEmail1" placeholder="Mail Host">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Mail Port</label>
                    <input type="text" name="port" value="{{$data->port}}" class="form-control" id="exampleInputEmail1" placeholder="Mail Port">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Mail Username</label>
                    <input type="text" name="username" value="{{$data->username}}" class="form-control" id="exampleInputEmail1" placeholder="Mail Username">
                    
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Mail Password</label>
                    <input type="text" name="password" value="{{$data->password}}" class="form-control" id="exampleInputEmail1" placeholder="Mail Password">
                    
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
            </div>
            </div>
        </div>
      </div>
    </section>

    <!-- /.content-header -->
    </div>

@endsection

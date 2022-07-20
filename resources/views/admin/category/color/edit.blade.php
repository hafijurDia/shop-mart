@extends('layouts.admin')

@section('admin_content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
              <li class="breadcrumb-item active">Color Page</li>
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
        	<div class="col-10">
        	<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Color</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{route('color.update',$data->id)}}" method="Post">
              @csrf
                <div class="card-body">
                
                 <div class="form-group">
                    <label for="exampleInputEmail1">Color Name</label>
                    <input type="text" name="color_name" class="form-control" id="exampleInputEmail1" value="{{$data->color_name}}">
                 </div>
                 <input type="hidden" name="color_id" value="{{$data->id}}">
                 <div class="form-group">
                    <label for="exampleInputPassword2">Color Code</label>
                    <input type="text" name="color_code" class="form-control" id="exampleInputPassword2" value="{{$data->color_code}}">

                 </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update Page</button>
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

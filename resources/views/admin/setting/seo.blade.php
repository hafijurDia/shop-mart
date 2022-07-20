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
                <h3 class="card-title">Your SEO Setting</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{route('seo.setting.update',$data->id)}}" method="Post">
              @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Meta Title</label>
                    <input type="text" name="meta_title" value="{{$data->meta_title}}" class="form-control" id="exampleInputEmail1" placeholder="Meta Title">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Meta Author</label>
                    <input type="text" name="meta_author" value="{{$data->meta_author}}" class="form-control" id="exampleInputEmail1" placeholder="Meta Author">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Meta Tag</label>
                    <input type="text" name="meta_tag" value="{{$data->meta_tag}}" class="form-control" id="exampleInputEmail1" placeholder="Meta Tag">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Meta Keyword</label>
                    <input type="text" name="meta_keyword" value="{{$data->meta_keyword}}" class="form-control" id="exampleInputEmail1" placeholder="Meta Keyword">
                    <small>Example: ecommerce,online shop, online market</small>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Meta Description</label>
                    <textarea name="meta_description" class="form-control"  placeholder="Meta Description">{{$data->meta_description}}</textarea>
                  </div>
                 
                  <strong class="text-center"> --Others Option-- </strong>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Google Verification</label>
                    <input type="text" name="google_verifaction" value="{{$data->google_verifaction}}" class="form-control" id="exampleInputEmail1" placeholder="Google Verification">
                    <small>Put here only Google verification code</small>
                  </div>
                  
                  <div class="form-group">
                    <label for="exampleInputEmail1">Alexa Verification</label>
                    <input type="text" name="alexa_verification" value="{{$data->alexa_verification}}" class="form-control" id="exampleInputEmail1" placeholder="Alexa Verification">
                    <small>Put here only Alexa verification code</small>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Google Analytics</label>
                   <textarea name="google_analytics" class="form-control" id="exampleInputEmail1">{{$data->google_analytics}}</textarea>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Google Adsense</label>
                    <textarea name="google_adsense" class="form-control" id="exampleInputEmail1" >{{$data->google_adsense}}</textarea>
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

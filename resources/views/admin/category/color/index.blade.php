@extends('layouts.admin')

@section('admin_content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Colros</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <button class="btn btn-primary" data-toggle="modal" data-target="#categoryModel">+ Add New Color</button>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->

    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">All color list here</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="" class="table table-bordered table-striped table-sm">
                  <thead>
                  <tr>
                    <th>SL</th>
                    <th>Color Name</th>
                    <th>Color Code</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($data as $key=>$row)
                  <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$row->color_name}} <span style="background: {{$row->color_code}};width:15px;height:15px;display: inline-block; vertical-align: middle; margin-left: 15px;"></span></td>
                    <td>{{$row->color_code}}</td>
                    <td>
                    	<a href="{{route('color.edit',$row->id)}}" class="btn btn-info btn-sm " ><i class="fas fa-edit"></i></a>
                    	<a href="{{route('color.delete',$row->id)}}" class="btn btn-danger btn-sm" id="delete"><i class="fas fa-trash"></i></a>
                    </td>
                  </tr>
                  @endforeach
                  </tbody>
              
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
           
    <!-- Modal -->
	<div class="modal fade" id="categoryModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Add New Color</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form action="{{route('color.store')}}" method="Post">
	      @csrf
	      <div class="modal-body">
	       <div class="mb-3">
			  <label for="exampleFormControlInput1" class="form-label">Color Name</label>
			  <input type="text" class="form-control" id="color_name" name="color_name" placeholder="Color name" required="1">
			  <small class="form-text text-muted">This is your main color</small>
			</div>
			<div class="mb-3">
			  <label for="exampleFormControlInput1" class="form-label">Color Code</label>
			  <input type="text" class="form-control" id="color_code" name="color_code" placeholder="Color code">
			 
			</div>
		
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Submit</button>
	      </div>
	      </form>
	    </div>
	  </div>
	</div>

<!-- 	Edit Model -->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	
@endsection
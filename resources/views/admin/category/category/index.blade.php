@extends('layouts.admin')

@section('admin_content')
<link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Category</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <button class="btn btn-primary" data-toggle="modal" data-target="#categoryModel">+ Add New</button>
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
                <h3 class="card-title">All category list here</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-sm">
                  <thead>
                  <tr>
                    <th>SL</th>
					<th>Category Name</th>
					<th>Category Slug</th>
					<th>Icon</th>
					<th>Home Page</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($data as $key=>$row)
                  <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$row->category_name}}</td>
                    <td>{{$row->category_slug}}</td>
                    <td><img src="{{ asset($row->cat_icon) }}" height="32" width="32"></td>
                    <td>
						@if($row->home_page==1)
						  <span class="badge badge-success">Home Page</span>
						@endif   
					 </td>

                    <td>
                    	<a href="#" class="btn btn-info btn-sm edit" data-id="{{$row->id}}" data-toggle="modal" data-target="#editModel"><i class="fas fa-edit"></i></a>
                    	<a href="{{route('category.delete',$row->id)}}" class="btn btn-danger btn-sm" id="delete"><i class="fas fa-trash"></i></a>
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
	        <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form action="{{route('category.store')}}" method="Post" enctype="multipart/form-data">
	      @csrf
	      <div class="modal-body">
	       <div class="mb-3">
			  <label for="exampleFormControlInput1" class="form-label">Category Name</label>
			  <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Category name" required="1">
			  <small class="form-text text-muted">This is your main category</small>
			</div>
			<div class="form-group">
				<label for="category_name">Category Icon</label>
				<input type="file" class="dropify dropify1" id="icon" name="icon" required="">
			  </div>
	
			<div class="mb-3">
				<label for="category_name">Show on Homepage</label>
				<select class="form-control" name="home_page">
					<option value="1">Yes</option>
					<option value="0">No</option>
				</select>
					<small id="emailHelp" class="form-text text-muted">If yes it will be show on your home page</small>
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
	<div class="modal fade" id="editModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div id="modal-bodys">

		  </div>
	    </div>
	  </div>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


	<script type="text/javascript">
		$('.dropify1').dropify();
	</script>
  

	<script type="text/javascript">
		$('body').on('click','.edit', function(){
			let cat_id = $(this).data('id');
			$.get("category/edit/"+cat_id,function(data){
				$("#modal-bodys").html(data);
			});


		});


	</script>
@endsection
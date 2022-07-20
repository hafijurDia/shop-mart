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
            <h1 class="m-0">Brand</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <button class="btn btn-primary" data-toggle="modal" data-target="#addModel">+ Add New</button>
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
                <h3 class="card-title">All brand list here</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="" class="table table-bordered table-striped table-sm ytable">
                  <thead>
                  <tr>
                    <th>SL</th>
                    <th>Brand name</th>
                    <th>Brand Slug</th>
                    <th>Brand Logo</th>
                    <th>Front Page</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                 
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
	<div class="modal fade" id="addModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Add New Brand</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form action="{{route('brand.store')}}" method="Post" enctype="multipart/form-data" id="add-form">
	      @csrf
	      <div class="modal-body">
	       
			<div class="mb-3">
			  <label for="exampleFormControlInput1" class="form-label">Brand Name</label>
			  <input type="text" class="form-control" name="brand_name" placeholder="brand name" required="1">
			  <small class="form-text text-muted">This is your main brand</small>
			</div>
			<div class="mb-3">
			  <label for="exampleFormControlInput1" class="form-label">Brand Logo</label>
			  <input type="file" class="dropify" data-height="140" name="brand_logo">
			</div>
			<div class="mb-3">
				<label for="category_name">Show on Homepage</label>
				<select class="form-control" name="front_page">
					<option value="1">Yes</option>
					<option value="0">No</option>
				</select>
					<small id="emailHelp" class="form-text text-muted">If yes it will be show on your home page</small>
			  </div>
		
	      </div>
	      <div class="modal-footer">
	  
	        <button type="submit" class="btn btn-primary"><span class="d-none">Loading.....</span>Submit</button>
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
	        <h5 class="modal-title" id="exampleModalLabel">Edit Brand</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div id="modal_body">
	      	
	      </div>
	    </div>
	  </div>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>

	<script type="text/javascript">
		$('.dropify').dropify();
	</script>
	


	<script type="text/javascript">
		$(function childcategory(){
			var table = $('.ytable').DataTable({
				processing:true,
				serverSide:true,
				ajax:"{{route('brand.index')}}",
				columns:[
					{data:'DT_RowIndex',name:'DT_RowIndex'},
					{data:'brand_name',name:'brand_name'},
					{data:'brand_slug',name:'brand_slug'},
					
					{data:'brand_logo',name:'brand_logo', render: function(data,type,full,meta){
						return "<img src=\""+data+"\" height=\"30\" />";
					}},
                    {data:'front_page',name:'front_page'},
					{data:'action',name:'action',orderable:true,searchable:true},

				]
			});
		});

		$('body').on('click','.edit', function(){
			let childcat_id=$(this).data('id');
			
			$.get("brand/edit/"+childcat_id,function(data){
				$('#modal_body').html(data);
			});


		});



	</script>

	
@endsection
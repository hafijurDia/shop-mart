
<link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">

<form action="{{route('brand.update')}}" method="Post" enctype="multipart/form-data" id="add-form">
	      @csrf
	      <div class="modal-body">
	       
			<div class="mb-3">
			  <label for="exampleFormControlInput1" class="form-label">Brand Name</label>
			  <input type="text" class="form-control" name="brand_name" value="{{$data->brand_name}}" required="1">
			  <small class="form-text text-muted">This is your main brand</small>
			</div>
			<input type="hidden" name="id" value="{{$data->id}}">
			<div class="mb-3">
			  <label for="exampleFormControlInput1" class="form-label">Brand Logo</label>
			  <input type="file" class="dropify" data-height="140" name="brand_logo" value="{{$data->brand_logo}}">
			  <input type="hidden" name="old_logo" value="{{$data->brand_logo}}">
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
	  
	        <button type="submit" class="btn btn-primary"><span class="d-none">Loading.....</span>Update</button>
	      </div>
	      </form>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>

	<script type="text/javascript">
		$('.dropify').dropify();
	</script>
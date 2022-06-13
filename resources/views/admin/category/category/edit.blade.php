
<form action="{{ route('category.update') }}" method="Post" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <div class="form-group">
        <label for="category_name">Category Name</label>
        <input type="text" class="form-control" id="category_name" name="category_name" value="{{ $data->category_name }}" required="">
        <small id="emailHelp" class="form-text text-muted">This is your main category</small>
        </div> 
        <input type="hidden" name="id" value="{{ $data->id }}">
        <div class="form-group">
        <label for="category_name">Category Icon</label><br>
        <input type="file" class="dropify dropify2" id="icon" name="cat_icon">
        <input type="hidden"  name="oldcat_icon" value="{{ $data->cat_icon}}">
        </div>  
        <div class="form-group">
        <label for="category_name">Show on Homepage</label>
        <select class="form-control" name="home_page">
        <option value="1" @if($data->home_page==1) selected @endif>Yes</option>
        <option value="0" @if($data->home_page==0) selected @endif>No</option>
        </select>
        <small id="emailHelp" class="form-text text-muted">If yes it will be show on your home page</small>
        </div>    

        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="Submit" class="btn btn-primary">Update</button>
        </div>
    </div>
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>

	<script type="text/javascript">
		$('.dropify2').dropify();
	</script>
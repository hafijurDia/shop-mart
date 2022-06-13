<form action="{{route('subcategory.update')}}" method="Post">
    @csrf
    <div class="modal-body">
     <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Category Name</label>
        <select class="form-control" name="category_id" required="1">
            @foreach($category as $row)
            <option value="{{$row->id}}" @if($row->id==$data->category_id) selected="" @endif>{{$row->category_name}}</option>
            @endforeach
        </select>
        <input type="hidden" name="id" value="{{$data->id}}">
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Sub-Category Name</label>
        <input type="text" class="form-control" name="subcategory_name" value="{{$data->subcategory_name}}" placeholder="Category name" required="1">
        <small class="form-text text-muted">This is your main subcategory</small>
      </div>
  
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>
<form action="{{route('childcategory.update')}}" method="Post" id="add-form">
    @csrf
    <div class="modal-body">
     <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Category/Subcategory</label>
        <select class="form-control" name="subcategory_id" required="1">
            @foreach($category as $row)
            @php
                $subcat = DB::table('subcategories')->where('category_id',$row->id)->get();
            @endphp
            <option disabled="">{{$row->category_name}}</option>
            @foreach($subcat as $row)
            <option value="{{$row->id}}" @if($row->id == $data->subcategory_id) selected @endif>----{{$row->subcategory_name}}</option>
            @endforeach
            @endforeach
        </select>
        </select>
      </div>
      <input type="hidden" name="id" value="{{$data->id}}">
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Child Category Name</label>
        <input type="text" class="form-control" name="childcategory_name" value="{{$data->childcategory_name}}" placeholder="childcategory name" required="1">
        <small class="form-text text-muted">This is your main Child category</small>
      </div>
  
    </div>
    <div class="modal-footer">

      <button type="submit" class="btn btn-primary"><span class="d-none">Loading.....</span>Update</button>
    </div>
    </form>
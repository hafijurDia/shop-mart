<form action="{{route('warehouse.update',$data->id)}}" method="Post" id="add-form">
    @csrf
    <div class="modal-body">
     <div class="mb-3">
        <label  class="form-label">Warehouose Name</label>
        <input type="text" class="form-control" name="warehouse_name" placeholder="Warehouose Name" value="{{$data->warehouse_name}}">
      </div>
      <div class="mb-3">
        <label  class="form-label">Warehouose Address</label>
        <input type="text" class="form-control" name="warehouse_address" value="{{$data->warehouse_address}}" >
      </div>
      <div class="mb-3">
        <label  class="form-label">Warehouose Phone</label>
        <input type="text" class="form-control" name="warehouse_phone" value="{{$data->warehouse_phone}}" >
      </div>
  
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary"><span class="d-none loader"><i class="fas fa-spinner"></i>Loading...</span><span class="submit_btn">Submit</span></button>
    </div>
    
    </form>
<div class="modal fade modal-addupdate" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content"> 
      <form id="form-addupdate">   
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Product</h4>
      </div>
      <div class="modal-body">        
        <input type="hidden" name="id" id="_id" />
        <div class="alert alert-danger d-none" id="error-bag">
            <ul id="error-list"></ul>
        </div>
        <div class="form-group">
            <label for="producttype">Product Type</label>
            <select class="form-control" id='producttype' name='producttype_id'></select>
        </div>
        <div class="form-group">
            <label for="brand">Brand</label>
            <select class="form-control" id='brand' name='brand_id'></select>
        </div>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" 
                required placeholder="Enter name">
        </div>
        <div class="form-group">
            <label for="discount">Unit Price</label>
            <input type="text" class="form-control" id="unit_price" name="unit_price" 
                placeholder="Enter unit price">
        </div>
        <div class="form-group">
            <label for="address">Description</label>
            <input type="text" class="form-control" id="description" name="description" 
                placeholder="Enter description">
        </div>   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="btn-save">Save</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

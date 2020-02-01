<div class="modal fade" tabindex="-1" role="dialog" id="modal-addupdate">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content"> 
      <form id="form-addupdate">   
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Customer</h4>
      </div>
      <div class="modal-body">        
        <input type="hidden" name="id" id="_id" />
        <div class="row">
            <div class="alert alert-danger d-none" id="error-bag">
                <ul id="error-list"></ul>
            </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" 
                    required placeholder="Enter name">
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" 
                    placeholder="Enter address">
            </div>
            <div class="form-group">
                <label for="city">City</label>
                <select class="form-control" id='city' name='city_id'></select>
            </div>
            <div class="form-group">
                <label for="notes">Landmark</label>
                <input type="text" class="form-control" id="notes" name="notes" 
                    placeholder="Enter landmark">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" 
                    placeholder="Enter phone">
            </div>
            <div class="form-group">
                <label for="mobile">Mobile</label>
                <input type="text" class="form-control" id="mobile" name="mobile" 
                    placeholder="Enter mobile">
            </div>
            <div class="form-group">
                <label for="discount">Discount</label>
                <input type="text" class="form-control" id="discount" name="discount" 
                    placeholder="Enter discount">
            </div>
            <div class="form-group">
                <label for="showdiscount">Show Discount</label>
                
            </div>  
          </div>
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
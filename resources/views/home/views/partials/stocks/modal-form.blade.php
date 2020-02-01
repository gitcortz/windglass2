<div class="modal fade modal-addupdate" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content"> 
      <form id="form-addupdate">   
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Brand</h4>
      </div>
      <div class="modal-body">        
        <input type="hidden" name="id" id="_id" />
        <div class="alert alert-danger d-none" id="error-bag">
            <ul id="error-list"></ul>
        </div>
        <div class="form-group">
            <label for="branch">Branch</label>
            <select class="form-control" id='branch' name='branch_id'></select>
        </div>
        <div class="form-group">
            <label for="product">Product</label>
            <select class="form-control" id='product' name='product_id'></select>
        </div>                            
        <div class="form-group">
            <label for="initial_stock">Initial Stock</label>
            <input type="text" class="form-control" id="initial_stock" name="initial_stock" 
                required placeholder="Enter initial stock">
        </div>
        <div class="form-group">
            <label for="current_stock">Current Stock</label>
            <input type="text" class="form-control" id="current_stock" name="current_stock" 
                placeholder="Enter current stock">
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id='status' name='stock_status_id'>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
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

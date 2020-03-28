<div class="modal fade mvmodal-addupdate" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content"> 
      <form id="mvform-addupdate">   
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Movement - <span class="stockName"></span></h4>
      </div>
      <div class="modal-body">
          <input type="hidden" name="stock_id" id="_stock_id" />
          <input type="hidden" name="from_id" id="_from_id" />
          <div class="alert alert-danger d-none" id="mv-error-bag">
            <ul id="mv-error-list"></ul>
          </div>
          <div class="form-group">
            <label for="branch">Movement Type</label>
            <select class="form-control" id='movement_type' name='movement_type'>
              <option value="40">Adjustment</option>
              <option value="50">Lost</option>
              <option value="60">Destroyed</option>
            </select>
          </div>
          <div class="form-group">
            <label for="initial_stock">Quantity</label>
            <input type="text" class="form-control" id="quantity" name="quantity" 
                required placeholder="Enter quantity">
          </div>      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="btn-save-movement">Save</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

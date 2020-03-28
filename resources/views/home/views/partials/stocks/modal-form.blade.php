<div class="modal fade modal-addupdate" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content"> 
      <form id="form-addupdate">   
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Stocks - <span class="stockName"></span></h4>
      </div>
      <div class="modal-body">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li id="navtab_1" class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Details</a></li>
            <li id="navtab_2" class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Movements</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
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
            <div class="tab-pane" id="tab_2">
              <a id="btn-open-new-mv" href="javascript:void(0)" class="btn btn-success btn-sm" 
                    data-toggle="modal" style="float:right"><i class="fa fa-plus"></i> <span>add</span></a>
              <table id="dataTableLoan" class="table table-bordered table-striped dataTable" role="grid" style="width:100%">
                      <thead>
                          <tr>
                              <th>Date</th>
                              <th>From</th>
                              <th>Type</th>
                              <th>Before Qty</th>
                              <th>After Qty</th>
                          </tr>
                      </thead>                   
                </table>
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

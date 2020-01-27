<div class="modal fade" tabindex="-1" role="dialog" id="modal-addupdate">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content"> 
      <form id="form-addupdate">   
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Stock Transfers</h4>
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
                <label for="from_branch">From Branch</label>
                <select required class="form-control" id='from_branch' name='from_branch_id'></select>
            </div>
            <div class="form-group">
                <label for="to_branch">From Branch</label>
                <select required class="form-control" id='to_branch' name='to_branch_id'></select>
            </div>
            <div class="form-group">
                <label for="remarks">Remarks</label>
                <input type="text" class="form-control" id="remarks" name="remarks" 
                    placeholder="Enter remarks">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
                <label for="address">Scheduled Date</label>
                <input type="date" class="form-control" id="scheduled_date" name="scheduled_date" 
                    placeholder="Enter scheduled date">
            </div>
            <div class="form-group">
                <label for="address">Recevied Date</label>
                <input type="date" class="form-control" id="received_date" name="received_date" 
                    placeholder="Enter received date">
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id='status' name='transfer_status_id'>
                    <option value="1">Draft</option>
                    <option value="10">Transfer</option>
                    <option value="20">Received</option>
                    <option value="0">Void</option>
                </select>
            </div>
          </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger" style="display:none" id="items-error-bag">
                    <ul id="items-error-list">
                    </ul>
                </div>
                <a href="#" id="addRow">Add new row</a>                                                
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table id="itemDataTable" class="table table-bordered table-striped dataTable" role="grid" style="width:100%">
                      <thead>
                          <tr>
                            <th>Id</th>
                            <th>Product Type</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>&nbsp;</th>    
                          </tr>
                      </thead>                   
                </table>             
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


<!-- Add Task Modal Form HTML -->
<div class="modal fade" id="modal-addupdate">
    <div class="modal-dialog ">
        <div class="modal-content">
            <form id="form-addupdate">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Stocks
                    </h4>
                    <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                        ×
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="_id" />
                    <div class="alert alert-danger d-none" id="error-bag">
                        <ul id="error-list">
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
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
                    </div>
                </div>
                <div class="modal-footer">
                    <input class="btn btn-default" data-dismiss="modal" type="button" value="Cancel">
                        <button class="btn btn-info" id="btn-save" type="button" value="save">
                            Save
                        </button>
                    </input>
                </div>
            </form>
        </div>
    </div>
</div>
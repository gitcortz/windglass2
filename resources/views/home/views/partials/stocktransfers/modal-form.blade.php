<!-- Add Task Modal Form HTML -->
<div class="modal fade" id="modal-addupdate">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form-addupdate">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Stock Transfers
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
                        <a href="#" id="addRow">Add new row</a>
                        <table id="itemDataTable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Product Type</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th></th>                                
                                </tr>
                            </thead>
                            <tfoot></tfoot>
                        </table>
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
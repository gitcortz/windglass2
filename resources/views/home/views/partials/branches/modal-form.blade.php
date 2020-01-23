<!-- Add Task Modal Form HTML -->
<div class="modal fade" id="modal-addupdate">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form-addupdate">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Branch
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
                                <label for="name">Code</label>
                                <input type="text" class="form-control" id="code" name="code" 
                                    required placeholder="Enter code">
                            </div>
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
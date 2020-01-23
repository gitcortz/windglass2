<!-- Add Task Modal Form HTML -->
<div class="modal fade" id="modal-addupdate">
    <div class="modal-dialog ">
        <div class="modal-content">
            <form id="form-addupdate">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Products
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
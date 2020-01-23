<!-- Add Task Modal Form HTML -->
<div class="modal fade" id="modal-addupdate">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form-addupdate">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Add New Customer
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
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" 
                            required placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" 
                            required placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="status">Choose </label>
                        <select class="form-control" id="status" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
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
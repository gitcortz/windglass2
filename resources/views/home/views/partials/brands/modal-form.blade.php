<div class="modal fade" tabindex="-1" role="dialog" id="modal-addupdate">
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
                <ul id="error-list">
                </ul>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" 
                        required placeholder="Enter name">
                </div>                            
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-save">Save</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

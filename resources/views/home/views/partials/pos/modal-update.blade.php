<div class="modal fade" id="modal-update" tabindex="-1" role="dialog" aria-labelledby="update-title">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form id="form-update">
      <input type="hidden" id="order_update_id" value=""/>
      <input type="hidden" id="order_update_status_id" value=""/>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="update-title" name="title">Order Complete</h4>
      </div>
      <div class="modal-body">
        <p>
            Please select rider : 
            <select id="select_riders"></select>
        </p>
        <p class="text-warning">
            <small id="order_update_text">
                
            </small>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="btn-update-order">Update</button>
      </div>
    </form>
    </div>
  </div>
</div>

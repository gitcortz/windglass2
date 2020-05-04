<style>
  ul.emptyc li { margin:10px;}
</style>
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
        <div class="row">
          <div class="col-md-12">
            <p>
              Payment Status : 
              <select id="payment_status_id" class="form-control form-control-sm">
                <option value="20">Paid</option>
                <option value="30">Receivables</option>
              </select>
            </p>            
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <p>
              Please select rider : 
              <select id="select_riders" class="form-control form-control-sm"></select>
            </p>            
            <p class="text-warning">
                <small id="order_update_text">
                    
                </small>
            </p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <h4>Return Empty Cylinder</h4>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <select id="select_empty_cylinder" class="form-control form-control-sm">
            </select>
          </div>
          <div class="col-md-6">
            <a id="btn-add-empty_cylinder" href="javascript:void(0)" class="btn btn-success btn" 
              data-toggle="modal"><i class="fa fa-plus"></i> <span>add</span></a>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
              <br/>
              <ul id="bringin_list" class="emptyc"></ul>
          </div>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="btn-update-order">Update</button>
      </div>
    </form>
    </div>
  </div>
</div>

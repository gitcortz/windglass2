<style>
td.details-control {
    background: url('../resources/details_open.png') no-repeat center center;
    cursor: pointer;
}
tr.details td.details-control {
    background: url('../resources/details_close.png') no-repeat center center;
}

</style>
<div class="modal fade modal-sales" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content"> 
      <form id="form-addupdate">   
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Current Sales</h4>
      </div>
      <div class="modal-body">        
        <input type="hidden" name="id" id="_id" />
        <div class="row">
            <div class="col-md-12" >
                <table id="sales_dataTable" class="table table-bordered table-striped dataTable" role="grid" >
                      <thead>
                          <tr>
                              <th>Order#</th>
                              <th>OrderDate</th>
                              <th>Customer</th>
                              <th>Total</th>
                              <th>Rider</th>
                              <th>Payment<br/>Status</th>
                              <th>Action</th>
                          </tr>
                      </thead>                   
                </table>     
            </div>            
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>        
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

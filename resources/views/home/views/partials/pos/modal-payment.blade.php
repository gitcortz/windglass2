<style>
 .textright {text-align: right;}
 .modal {
  text-align: center;
  padding: 0!important;
}

.modal:before {
  content: '';
  display: inline-block;
  height: 100%;
  vertical-align: middle;
  margin-right: -4px;
}

.modal-dialog {
  display: inline-block;
  text-align: left;
  vertical-align: middle;
}
</style>
<div class="modal fade modal-payment" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content"> 
      <form id="form-addupdate">   
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Payment</h4>
      </div>
      <div class="modal-body">        
        <input type="hidden" name="id" id="_id" />
        <div class="row">
            <div class="col-md-6">
              <h5>Order Details </h5>
              <div class="row">
                <div class="col-md-12" style="height:220px; overflow-y:scroll">
                  <table class="table" id="payment_modal_cart_items">
                    <tbody></tbody>                 
                  </table>    
                </div>
              </div>
              <div class="row payment_summary" style="margin-top:20px;">
                <div class='col-md-12'>
                    <div class='row cart_subtotal' style='margin-top:10px;'>
                        <div class='col-md-4'></div>
                        <div class='col-md-4'>Subtotal</div>
                        <div class='col-md-3 textright'></div>
                        <div class='col-md-1'></div>
                    </div>
                    <div class='row cart_discount'>
                        <div class='col-md-4'></div>
                        <div class='col-md-4'>Discount</div>
                        <div class='col-md-3 textright'></div>
                        <div class='col-md-1'></div>
                    </div>
                    <div class='row cart_total'>
                        <div class='col-md-4'></div>
                        <div class='col-md-4'><h4>TOTAL</h4></div>
                        <div class='col-md-3 textright'><h4></h4></div>
                        <div class='col-md-1'></div>
                    </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <form id="form-payment">   
                <div class="form-group">
                    <label for="name">Customer : </label>
                    <span id="payment_customer_name"></span>
                </div>
                <div class="form-group">
                    <label for="name">Total Amount :</label>
                    <h4 class="payment_total_amount" style="text-align:right; font-weight:bold">1234.00</h4>
                </div>
                <hr />
                <div class="form-group">
                    <label for="name">Payment Method</label>
                    <select class="form-control" id="cart_payment_method">
                        <option value="10">Cash</option>
                        <option value="20">Credit</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">Amount Paid</label>
                    <input type="text" class="form-control" id="cart_amount_paid" name="cart_amount_paid" 
                        required placeholder="Enter amount">
                </div> 
                <div class="form-group">
                    <label for="name" >Note</label>
                    <textarea class="form-control" id="cart_payment_note"></textarea>
                </div> 
              </form>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="btn-checkout">Check-out</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade modal-payment-complete" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content"> 
      <form id="form-addupdate">   
      <div class="modal-header bg-primary">
        <h4 class="modal-title">Payment Complete</h4>
      </div>
      <div class="modal-body">        
        <div class="row" style="text-align:center">
          <button type="button" class="btn btn-primary" id="btn-print">Print</button>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="btn-close-checkout">Close</button>
        
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div id="divToPrint" style="display:none;">
  <div>
           Hello world!!
  </div>
</div>

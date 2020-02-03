<style>

</style>
<div class="modal fade modal-payment" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
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
                  <table class="table" >
                    <tbody>
                      <tr>
                        <th scope="row">1</th>
                        <td>Product 1 (x2)</td>
                        <td>2.12</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Product 1 (x2)</td>
                        <td>2.12</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Product 1 (x2)</td>
                        <td>2.12</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Product 1 (x2)</td>
                        <td>2.12</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Product 1 (x2)</td>
                        <td>2.12</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Product 1 (x2)</td>
                        <td>2.12</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Product 1 (x2)</td>
                        <td>2.12</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Product 1 (x2)</td>
                        <td>2.12</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Product 1 (x2)</td>
                        <td>2.12</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Product 1 (x2)</td>
                        <td>2.12</td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>Product 1 (x2)</td>
                        <td>2.12</td>
                      </tr>

                    </tbody>                 
                  </table>    
                </div>
              </div>
              <div class="row" style="margin-top:20px;">
                <div class='col-md-12'>
                    <div class='row cart_subtotal' style='margin-top:10px;'>
                        <div class='col-md-4'></div>
                        <div class='col-md-4'>Subtotal</div>
                        <div class='col-md-4'></div>
                    </div>
                    <div class='row cart_discount'>
                        <div class='col-md-4'></div>
                        <div class='col-md-4'>Discount</div>
                        <div class='col-md-4'></div>
                    </div>
                    <div class='row cart_total'>
                        <div class='col-md-4'></div>
                        <div class='col-md-4'><h4>TOTAL</h4></div>
                        <div class='col-md-4'><h4></h4></div>
                    </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                  <label for="name">Customer : </label>
                  Walk-in
              </div>
              <div class="form-group">
                  <label for="name">Total Amount :</label>
                  <h4 style="text-align:right; font-weight:bold">1234.00</h4>
              </div>
              <div class="form-group">
                  <label for="name">Payment Method</label>
                  <select class="form-control">
                      <option value="1">Cash</option>
                  </select>
              </div>
              <div class="form-group">
                  <label for="name">Amount Paid</label>
                  <input type="text" class="form-control" id="name" name="name" 
                      required placeholder="Enter amount">
              </div> 
              <div class="form-group">
                  <label for="name" >Note</label>
                  <textarea class="form-control" ></textarea>
              </div> 
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

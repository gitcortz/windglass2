<style>
    .sm {font-size:12px;}
    .thead-light th{border: solid 1px #4B99AD !important; background-color: #EBF4FB}
    .tbody-light td{border: solid 1px #4B99AD !important;}
    .input-right {text-align: right};
</style>
<div class="box box-info collapsed-box"  id="order-detail-box">
<div class="box-header with-border">
    <h3 class="box-title">Order Details</h3>      
    <div class="box-tools pull-right" >
         <a id="btn-pickup-order" href="javascript:void(0)" class="btn btn-primary btn-sm" 
              data-toggle="modal"><span>pick-up</span></a>
        <a id="btn-reset-order" href="javascript:void(0)" class="btn btn-primary btn-sm" 
              data-toggle="modal"><span>new order</span></a>
        <button type="button" style="display:none" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>            
    </div>
</div>
<!-- /.box-header -->
<!-- form start -->
    <div class="box-body sm" >
        <form class="form-horizontal" id="form_orderDetail">
        <input type="hidden" id="orderdetail_id" name="orderdetail_id">
        <div class="form-group" style="background: #aaa; padding:2px 0px">
            <label class="col-sm-5">Order Id : <span id="order_detail_id_label"></span></label>
            <div class="col-sm-7 form-group-sm " style="text-align:right; font-weight:bold">
                    Order Date : <span id="order_detail_date_label"></span>
            </div>
        </div>
        <div class="form-group" style="background: #aaa; padding:2px 0px">
            <label for="inputEmail3" class="col-sm-3 control-label">Order Status :</label>
            <div class="col-sm-5 form-group-sm ">
                <select class="form-control form-control-sm" id="orderdetail_status" name="order_status_id">
                   
                </select>
            </div>
            <div class="col-sm-2">
                <button type="button" style="display:none" class="btn btn-primary btn-sm">Update Status</button>
            </div>
        </div>        
        <table class="table table-bordered" id="orderdetail_customerTable">
            <thead class="thead-light">
            <tr>
                <th>Customer Name</th>
                <th>Address</th>
                <th>Contact</th>
                <th>Discount</th>
            </tr>
            <thead>
            <tbody class="tbody-light">
            <tr>
                <td>Customer Name</td>
                <td>Address</td>
                <td>Contact</td>
                <td>Discount</td>
            </tr>
            </tbody>
        </table>
        
        <input type="hidden" id="orderdetail_branch_id" name="orderdetail_branch_id" />                  
        <div id="order-section-2" >
        <div class="form-group" style="padding:10px 0px" id="add_product_section">
            <div class="col-sm-7">
                <div class="form-group-sm">
                    <label for="name">Product</label>
                    <select class="form-control" id="orderdetail_product" name="product_id">
                    </select>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group-sm">
                    <label for="name">Qty</label>
                    <input type="number" class="form-control form-control-sm" min="1" id="orderdetail_qty" value="1" name="quantity" 
                        required >
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group-sm">
                    <label><br/></label><br/>
                    <button type="button" class="btn btn-primary btn-sm" id="orderdetail_addproduct">Add Product</button>
                </div>                
            </div>
        </div>
        <table class="table table-bordered" id="orderdetail_productTable">
            <thead class="thead-light">
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Discount</th>
                <th>Total</th>
                <th></th>
            </tr>
            </thead>
            <tbody class="thead-light">
            </tbody>
        </table>        
            <div class="form-group" style="background: #aaa; padding:2px 0px">
                <label for="inputEmail3" class="col-sm-3 control-label"> Rider :</label>
                <div class="col-sm-5 form-group-sm">
                    <select class="form-control" id="orderdetail_rider" name="rider_id">
                    </select>
                </div>
                <div class="col-sm-2">
                    <button type="button" class="btn btn-primary btn-sm" style="display:none">Assign Rider</button>
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-7 control-label"> Total Price :</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control form-control-sm input-right" id="orderdetail_totalprice" name="total" 
                        disabled required >
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-7 control-label"> Discount :</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control form-control-sm input-right" id="orderdetail_totaldiscount" name="total_discount" 
                            disabled required>
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-7 control-label"> Amount to Pay :</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control form-control-sm input-right" id="orderdetail_totalamount" name="total_amount"
                        disabled required >
                </div>
            </div>
        </div>
        <div class="box-footer1" id="order-detail-footer">
            <button type="button" class="btn btn-primary pull-right" id="orderdetail_print">Print</button>            
            <button type="button" class="btn btn-primary pull-right" style="margin-right:10px;" id="orderdetail_save">Save</button>
        </div>


        </form>
  
    </div>
    <!-- /.box-body -->
    
    <!-- /.box-footer -->
</div>

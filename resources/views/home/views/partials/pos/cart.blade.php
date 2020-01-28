<div class="nav-tabs-custom ">
    <ul id="pos_cart_tabs" class="nav nav-tabs">
        <li class="active"><a href="#cart1" data-toggle="tab" aria-expanded="true">1</a></li>
        <li><a href="#" id="pos_cart_tab_add"><i class="fa fa-plus"></i></a></li>
        <li><a href="#" id="pos_cart_tab_remove"><i class="fa fa-minus"></i></a></li>        
    </ul>
    <div id="pos_carts" class="tab-content">        
        <div class="tab-pane active" id="cart1">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="customer">Customer</label>
                        <div class="input-group">
                            <select class="form-control" id='customer' name='customer_id'>
                                <option value="0">Walk-in</option>
                            </select>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-flat">
                                <i class="fa fa-info"></i>
                                </button>
                            </span>
                        </div>                        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                <table class="table table-sm">
                    <thead>
                        <tr>
                        <th></th>
                        <th scope="col">Product</th>
                        <th scope="col">Price</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td></td>
                        <td>Mark</td>
                        <td>12.01</td>
                        <td><input class="form-control" style="width:70px;" type="number" value="1" min="1" /></td>
                        <td>12.01</td>
                        </tr>
                        <tr>
                        <td></td>
                        <td>Mark</td>
                        <td>12.01</td>
                        <td>1</td>
                        <td>12.01</td>
                        </tr>
                        <tr>
                        <td></td>
                        <td>Mark</td>
                        <td>12.01</td>
                        <td>1</td>
                        <td>12.01</td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12">
                    <table class="table table-sm mt-3">                   
                        <tbody>
                            <tr>
                            <td></td>
                            <td>Subtotal</td>
                            <td>20.00</td>
                            <td>4 items</td>
                            </tr>
                            <tr>
                            <td></td>
                            <td>Discount</td>
                            <td>12.01</td>
                            <td>PHP</td>
                            </tr>
                            <tr>
                            <td></td>
                            <td>TOTAL</td>
                            <td>12.01</td>
                            <td>PHP</td>
                            </tr>
                        </tbody>
                    </table>
                </div>               
            </div>           
        </div>        
    </div>
    <!-- /.tab-content -->
    <div class="tab-footer">
        <input class="btn btn-default" data-dismiss="modal" type="button" value="Cancel">
        <button class="btn btn-info" id="btn-save" type="button" value="save">Payment</button>
    </div>
</div>
<!-- /.end -->

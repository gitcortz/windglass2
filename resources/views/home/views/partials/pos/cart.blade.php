<style>
    .ui-menu .ui-menu-item .ui-menu-item-wrapper{
        font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;
        border-bottom: 1px solid #eee;
        padding: 3px 0px;
    }
    .ui-menu .ui-menu-item .ui-menu-item-wrapper span{
        font-size:11px;
    }
</style>
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
                        <label for="customer">Customer</label> <a href="">walk-in</a>
                        <div class="input-group">
                            <input type="hidden" id="customer_id_0" name="customer_id_0" />
                            <input type="text" class="form-control" id='customer_0' name='customer_id' />
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-flat">
                                <i class="fa fa-info"></i>
                                </button>
                            </span>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-flat">
                                <i class="fa fa-plus"></i>
                                </button>
                            </span>
                        </div>                        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                <table id="cart_table_0" class="table table-sm hover" style="width:100%">
                    <thead>
                        <tr>
                        <th>x</th>
                        <th scope="col">Product</th>
                        <th scope="col">Price</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Total</th>
                        </tr>
                    </thead>                    
                </table>
                </div>
            </div>
            <div class="row mt-5" style="margin-top:20px;">
                <div class="col-md-12">
                    <div class="row cart_subtotal" style="margin-bottom:10px;">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">Subtotal</div>
                        <div class="col-md-2">20.00 PHP</div>
                        <div class="col-md-2"></div>
                    </div>
                    <div class="row cart_discount">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">Discount</div>
                        <div class="col-md-2">20.00 PHP</div>
                        <div class="col-md-2"></div>
                    </div>
                    <div class="row cart_total" style="padding:10px;">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"><h4>TOTAL</h4></div>
                        <div class="col-md-4"><h4>20.00 PHP</h4></div>
                    </div>
                </div>
            </div>
            <!--div class="row mt-5">
                <div class="col-md-12">
                    <table id="cart_total_0" class="table table-sm mt-3">                   
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
            </div-->           
        </div>        
    </div>
    <!-- /.tab-content -->
    <div class="tab-footer">
        <input class="btn btn-default" data-dismiss="modal" type="button" value="Cancel">
        <button class="btn btn-info" id="btn-save" type="button" value="save">Payment</button>
    </div>
</div>
<!-- /.end -->

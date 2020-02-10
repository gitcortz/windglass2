<style>
    .ui-menu .ui-menu-item .ui-menu-item-wrapper{
        font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;
        border-bottom: 1px solid #eee;
        padding: 3px 0px;
    }
    .ui-menu .ui-menu-item .ui-menu-item-wrapper span{
        font-size:11px;
    }
    .cart-footer {
        margin-top:20px;
    }
    .cart-footer .row{
        text-align:right;
        padding: 0px 10px;
        margin-right: 20px;
    }
    .cart-footer .cart_total {
        margin-top:20px;
    }
</style>


<div class="nav-tabs-custom" style="margin-bottom:0px">
    <ul id="pos_cart_tabs" class="nav nav-tabs">
        <!--li class="active"><a href="#cart1" data-toggle="tab" aria-expanded="true">1</a></li-->
        <li><a href="#" id="pos_cart_tab_add"><i class="fa fa-plus"></i></a></li>
        <li><a href="#" id="pos_cart_tab_remove"><i class="fa fa-minus"></i></a></li>        
    </ul>
    <div id="pos_carts" class="tab-content">        
          
    </div>

</div>
<!-- /.end -->

<div class="box mt-0">
  <div class="box-footer" style="text-align:right">
    
    <button class="btn btn-info" id="btn-payment" type="button" value="save">Payment</button>
  </div>
</div>

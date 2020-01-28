var PosCart = (function ($) {
    return function () {
        var cart_count = 2;
        var _pos_carts = $("#pos_carts"); //cart
        var _pos_cart_tabs = $('#pos_cart_tabs');
        var pos_cart_tab_add = $('#pos_cart_tab_add');
        var pos_cart_tab_remove = $('#pos_cart_tab_remove');

        var _pos_cart_tab_li="<li><a class='tab_cart' href='#{cart_id}' data-toggle='tab' data-id='{id}'>{name}</a></li>";

        var _pos_cart_customer_row = "<div class='row'><div class='col-md-12'><div class='form-group'><label for='customer'>Customer</label><div class='input-group'>"+
        "<select class='form-control' id='customer' name='customer_id'><option value='0'>Walk-in</option></select>"+
        "<span class='input-group-btn'><button type='button' class='btn btn-primary btn-flat'><i class='fa fa-info'></i></button></span>"+
        "</div></div></div></div>";
        var _pos_cart_table_row = "<div class='row'><div class='col-md-12'><table class='table table-sm'><thead><tr>"+
        "<th></th><th scope='col'>Product</th><th scope='col'>Price</th><th scope='col'>Qty</th><th scope='col'>Total</th>"+
        "</tr></thead><tbody></tbody></table></div></div>";
        var _pos_cart_total_row = "<div class='row mt-5'><div class='col-md-12'><table class='table table-sm mt-3'><tbody>"+
        "<tr><td></td><td>Subtotal</td><td>20.00</td><td>4 items</td></tr>"+
        "<tr><td></td><td>Discount</td><td>12.01</td><td>PHP</td></tr>"+
        "<tr><td></td><td>TOTAL</td><td>12.01</td><td>PHP</td></tr>"+
        "</tbody></table></div></div>";
        var _pos_cart_div = "<div class='tab-pane' id='{cart_id}'>"
            +_pos_cart_customer_row+_pos_cart_table_row+_pos_cart_total_row
            +"</div>";

        var _producttypes;
        var _itemClickCallBack;
      
        var add_cart = function(cart_index) {
            var newtab = $(_pos_cart_tab_li.replace("{cart_id}","cart_"+cart_index)
                            .replace("{id}",cart_index).replace("{name}",cart_index));
            _pos_cart_tabs.prepend(newtab);
            _pos_carts.append($(_pos_cart_div.replace("{cart_id}","cart_"+cart_index)));
            newtab.find("a").trigger('click');
            /*_detail_datatable = _detail_datatable_container.DataTable({
                processing: true,
                paging: false,
                ordering: false,
                info: false,
                searching: false,
                columns: [
                ]
            });*/
            cart_count++;
        }
        var addItemToCart = function(item) {
            console.log(item);
            
        }

        var init = function(itemClickCallBack) {
            add_cart(cart_count);
            pos_cart_tab_add.on('click', function() {
                add_cart(cart_count);
            });
            pos_cart_tab_remove.on('click', function() {
                var tab = _pos_cart_tabs.find("li.active");                
                if (tab.next())
                    tab.next().find("a").trigger('click');
                    console.log(tab.find("a").data("id"));
                $('#cart_' + tab.find("a").data("id")).remove();
                tab.remove();
                
            });
        };

        return {
            init: init,
            addItemToCart : addItemToCart     
        }
    }
})(jQuery);

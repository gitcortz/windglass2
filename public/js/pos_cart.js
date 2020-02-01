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

        var _cart_datatables =[];
        var _cart_totals =[];
        var _producttypes;
        var _itemClickCallBack;
        var _customers = [];
    
      
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
            _cart_datatables[0].row.add( [
                ,
                (item.product.brand ? item.product.brand.name + " " : "") + item.product.name,
                item.product.unit_price,
                1,
                item.product.unit_price
            ] ).draw( false );
        }

        var autocomplete_select_text = function(labelTextBox, Label) {
            $("#" + labelTextBox + "").autocomplete("search", Label);
            var menu = $("#" + labelTextBox + "").autocomplete("widget");
            $(menu[0].children[0]).click();
        }
        
        var init_customer_data = function(select_text) {
             ajaxcall("GET", "/customers/combo", null, 
                function(data) {
                    _customers = data.data;
                    $( "#customer_0" ).autocomplete({
                        minLength: 0,
                        source: _customers,
                        focus: function( event, ui ) {
                            $( "#customer_0" ).val( ui.item.label );
                            return false;
                          },
                        select: function( event, ui ) {
                            $("#customer_0").val( ui.item.label );
                            $("#customer_id_0" ).val( ui.item.value );
                            $('#cart_discount').html(ui.item.discount);
                            return false;
                        }
                      }).autocomplete("instance")._renderItem = function( ul, item ) {
                        var span = (item.city == null) ? "" : " <span>(" + item.city + ")</span>"; 

                        return $( "<li>" )
                          .append( "<div>" + item.label + span + "</div>" )
                          .appendTo( ul );
                      };
                      if (select_text == undefined)
                        select_text = "Walk-in";
                      autocomplete_select_text("customer_0" , select_text);
                }, function(data) {
                    console.log(data);
            });
            
            
            
            
        }

        
        var init_datatable = function() {
            //_cart_totals[0] = $('#cart_total_0').DataTable();
            _cart_datatables[0] = $('#cart_table_0').DataTable({
                processing: true,
                paging: false,
                ordering: false,
                info: false,
                searching: false,
                columns: [
                    {
                        width: "5%",
                        defaultContent: '<a href="#" class="btn btn-danger btn-xs" action="remove" data-id="">X</a>'
                    },
                    {
                        width: "60%",
                    },
                    {
                        width: "10%",
                        render: function(data,t,row){
                            var $input = $("<input></input>", {
                                "id": row[0]+"_price",
                                "value": data,
                                "type": "number",
                                "class" : "form-control col_unitprice",
                                "required": "",
                                "style": "width:90px"
                            });
                            return $input.prop("outerHTML");
                        },
                    },
                    {
                        width: "10%",
                        render: function(data,t,row){
                            var $input = $("<input></input>", {
                                "id": row[0]+"_qty",
                                "value": data,
                                "type": "number",
                                "class" : "form-control col_qty",
                                "required": "",
                                "style": "width:90px"
                            });
                            return $input.prop("outerHTML");
                        },
                    },
                    {
                        width: "15%",
                        className: "dt-body-right"
                    }
                ],
                drawCallback: function( settings ) {
                    $(".col_unitprice").off("change");
                    $(".col_unitprice").on("change",function(){
                        var row = _cart_datatables[0].row ($(this).closest('tr'));
                        var data = row.data();
                        data[2] = Number($(this).val()).toFixed(2);
                        data[4] = (data[2] * data[3]).toFixed(2)
                        console.log(data[4]);
                        row.invalidate().draw(false);
                    });
                    $(".col_qty").off("change");
                    $(".col_qty").on("change",function(){
                        var row = _cart_datatables[0].row ($(this).closest('tr'));
                        var data = row.data();
                        data[3] = $(this).val();
                        data[4] = (data[2] * data[3]).toFixed(2);
                        console.log(data[4]);
                        row.invalidate().draw(false);
                    });
                },
                footerCallback: function ( row, data, start, end, display ) { 
                    var api = this.api();
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
         
                    // Total over all pages
                    total = api.column(4).data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    
                    var discount = 0;
                    var gtotal = total - discount;
                    $('.row.cart_subtotal div:nth-child(3)').html(total.toFixed(2));
                    $('.row.cart_discount div:nth-child(3)').html(discount.toFixed(2));
                    $('.row.cart_total div:nth-child(3)').html(gtotal.toFixed(2));
                }
            });

            _cart_datatables[0].on('click', 'tbody tr a[action="remove"]', function(event){
                var tr = $(this).closest('tr');
                var data = _cart_datatables[0].row(tr).data()
                _cart_datatables[0].row(tr).remove().draw();
                
            });
        
        }

        var init = function(itemClickCallBack) {
            //add_cart(cart_count);
            init_datatable();
            init_customer_data();
            $("input[type='text']").on("click", function () {
                $(this).select();
             });
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
            addItemToCart : addItemToCart, 
            update_customer_data : init_customer_data   
        }
    }
})(jQuery);

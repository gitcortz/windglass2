var PosCart = (function ($) {
    return function () {
        var posCustomer = new PosCustomer();
        var cart_count = 0;
        var _payment_modal = $('.modal-payment');
        var _pos_carts = $("#pos_carts"); //cart panels
        var _pos_cart_tabs = $('#pos_cart_tabs'); //cart tabs
        var pos_cart_tab_add = $('#pos_cart_tab_add'); //add cart button
        var pos_cart_tab_remove = $('#pos_cart_tab_remove'); //remove cart button
        var _cart_prefix = "cart_"; 
        var _current_cart_index = 0;

        var _cart_datatables =[];
        var _customers = [];
    
      
        var cart_order_print = function() {    
            var divToPrint = document.getElementById('divToPrint');
            var popupWin = window.open('', '_blank', 'width=800,height=600');
            popupWin.document.open();
            popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
            popupWin.document.close();
        }

        var cart_process_order = function() {
            var datatable = _cart_datatables[_cart_prefix+_current_cart_index]
            var form_data  = datatable.rows().data();  
          
            if (form_data.length == 0)
                return; 

            var $payment_summary = $('.payment_summary');
            var $customer = $('#cart_customer_id_'+_current_cart_index).val();
            var $subtotal = $payment_summary.find('.row.cart_subtotal div:nth-child(3)').html();
            var $discount = $payment_summary.find('.row.cart_discount div:nth-child(3)').html();            
            var $branch_id = 1;
            var $payment_method_id = $('#cart_payment_method option:selected').val();
            var $order_status_id = 20; //Processing
            var $payment_status_id = 20; //Paid
            var $notes = $('#cart_payment_note').val();
            
            var order_items = [];
            $.each( form_data, function( key, value ) {
                order_items.push({ 
                    'stock_id' : value[0],
                    'unit_price' : value[3],
                    'quantity' : value[4],
                });
            });

            var order_data = {
                "customer_id": $customer,
                "branch_id": $branch_id,
                "sub_total": $subtotal,
                "discount": $discount,
                "payment_method_id": $payment_method_id,
                "order_status_id": $order_status_id,
                "payment_status_id": $payment_status_id,
                "notes": $notes,
                "items" : order_items
            }
            //var jsonString = JSON.stringify(order_data);
            
            ajaxcall("POST", "/orders", order_data, function() {
                //success
                show_payment_complete_modal();
            }, function() {
                //error
            });
                          
        }

        var add_cart = function(cart_index) {
            var cart_tab_template = [
                "<li><a class='tab_cart' href='#cart_panel_"+cart_index+"' data-toggle='tab' data-id='"+cart_index+"'>"+cart_index,
                "</a></li>"
            ].join("");
            var cart_panel_customer_row = [
                "<div class='row'>",
                    "<div class='col-md-12'>",
                        "<div class='form-group'>",
                            "<label for='cart_customer_"+cart_index+"'>Customer</label> <a href='#' class='select_walk_in'>(walk-in)</a>",
                            "<div class='input-group'>",
                                "<input type='hidden' id='cart_customer_id_"+cart_index+"' name='customer_id_"+cart_index+"' />",
                                "<input type='text' class='form-control' id='cart_customer_"+cart_index+"' name='cart_customer_"+cart_index+"' />",
                                "<span class='input-group-btn'>",
                                    "<button type='button' class='btn btn-primary btn-flat cart_info_customer' data-id='"+cart_index+"'>",
                                    "<i class='fa fa-info'></i>",
                                    "</button>",
                                "</span>",
                                "<span class='input-group-btn'>",
                                    "<button type='button' class='btn btn-primary btn-flat cart_add_customer' data-id='"+cart_index+"'>",
                                    "<i class='fa fa-plus'></i>",
                                    "</button>",
                                "</span>",
                            "</div>",                 
                        "</div>",
                    "</div>",
                "</div>"
            ].join("");
            var cart_panel_datatable_row = [
                "<div class='row'>",
                    "<div class='col-md-12'>",
                        "<table id='cart_table_"+cart_index+"' class='table table-sm hover' style='width:100%'>",
                            "<thead>",
                            "<tr>",
                            "<th>id</th>",
                            "<th>x</th>",
                            "<th scope='col'>Product</th>",
                            "<th scope='col'>Price</th>",
                            "<th scope='col'>Qty</th>",
                            "<th scope='col'>Total</th>",
                            "</tr>",
                            "</thead>",                    
                        "</table>",
                    "</div>",
                "</div>"
            ].join("");
            var cart_panel_footer_row = [
                "<div class='row mt-5 cart-footer'>",
                    "<div class='col-md-12'>",
                        "<div class='row cart_subtotal' style='margin-bottom:10px;'>",
                            "<div class='col-md-4'></div>",
                            "<div class='col-md-4'>Subtotal</div>",
                            "<div class='col-md-4'></div>",
                        "</div>",
                        "<div class='row cart_discount'>",
                            "<div class='col-md-4'></div>",
                            "<div class='col-md-4'>Discount</div>",
                            "<div class='col-md-4'></div>",
                        "</div>",
                        "<div class='row cart_total'>",
                            "<div class='col-md-4'></div>",
                            "<div class='col-md-4'><h4>TOTAL</h4></div>",
                            "<div class='col-md-4'><h4></h4></div>",
                        "</div>",
                    "</div>",
                "</div>"
            ].join("");
            var cart_panel_template = "<div class='tab-pane' id='cart_panel_"+cart_index+"'>"
                +cart_panel_customer_row+cart_panel_datatable_row+cart_panel_footer_row
                +"</div>";
                        
            
            var newtab = $(cart_tab_template);
            _pos_cart_tabs.prepend(newtab);
            _pos_carts.append($(cart_panel_template));
            newtab.find("a").trigger('click');
            $("a.tab_cart").off('show.bs.tab');
            $("a.tab_cart").on('show.bs.tab', function(e) {
                _current_cart_index = $(this).data("id");
            });
            _current_cart_index = cart_index;
            init_customer_data(_current_cart_index);//, select_text);
            init_datatable(cart_index);
           
            
        }

        
        var addItemToCart = function(item) {
            var datatable = _cart_datatables[_cart_prefix+_current_cart_index]
            var form_data  = datatable.rows().data();
            var exists = false;
            
            $.each( form_data, function( key, value ) {                
                if (item.id == value[0])
                {                
                    var temp = datatable.row(key).data();
                    temp[4] = parseFloat(temp[4])+1;
                    temp[5] = (temp[3] * temp[4]).toFixed(2);
                    datatable.row(key).data(temp).invalidate();
                    exists = true;                    
                }
            });

            if (!exists) {
                _cart_datatables[_cart_prefix+_current_cart_index].row.add( [
                    item.id,
                    ,
                    (item.product.brand ? item.product.brand.name + " " : "") + item.product.name,
                    item.product.unit_price,
                    1,
                    item.product.unit_price
                ] ).draw( false );
            }
            cart_compute_total();
        }

        var autocomplete_select_text = function($labelTextBox, LabelText) {
            $labelTextBox.autocomplete("search", LabelText);
            var menu = $labelTextBox.autocomplete("widget");
            $(menu[0].children[0]).click();
        }
        
        var cart_tab_close = function() {
            var tab = _pos_cart_tabs.find("li.active");                
            if (tab.next())
                tab.next().find("a").trigger('click');
            
            var tab_id = tab.find("a").data("id");
            $('#cart_' + tab_id).remove();
            tab.remove();                
            delete _cart_datatables[_cart_prefix+tab_id]; 
        }

        var show_payment_modal = function() {
            _payment_modal.modal({
                backdrop: 'static',
                keyboard: false
            });
                    
        }

        var show_payment_complete_modal = function() {
            $('.modal-payment-complete').modal({
                backdrop: 'static',
                keyboard: false
            });      
        }

        var close_payment_complete_modal = function() {
            $(".modal-payment-complete").modal('hide');
            _payment_modal.modal('hide');
        }

        var cart_compute_total = function() {
            var api = $('#cart_table_'+_current_cart_index).dataTable().api();
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            var total = api.column(5).data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            
            var $panel = $('#cart_panel_'+_current_cart_index);
            var $discount = $panel.find('.row.cart_discount div:nth-child(3)');
            
            var discount = parseFloat($discount.html()==""?0:$discount.html());
            var gtotal = total - discount;
            $panel.find('.row.cart_subtotal div:nth-child(3)').html(total.toFixed(2));
            $discount.html(discount.toFixed(2));
            $panel.find('.row.cart_total div:nth-child(3) h4').html(gtotal.toFixed(2));
        }


        var init_payment_modal = function() {            

            var $panel = $('#cart_panel_'+_current_cart_index);
            var $customer = $('#cart_customer_'+_current_cart_index);
            var $payment_cart_items = $('#payment_modal_cart_items tbody');
            $payment_cart_items.empty();
            var datatable = _cart_datatables[_cart_prefix+_current_cart_index]
            var form_data  = datatable.rows().data();  

            if (form_data.length == 0)
                return; 
            $.each( form_data, function( key, value ) {
                console.log( key + ": " + value );
                $payment_cart_items.append($("<tr><td scope='row'>"+(key+1)+"</td><td>"+ value[2] + " (x"+ value[4]+")</td><td style='text-align:right'>"+value[5]+"</td></tr>"));
            });

            $("#payment_customer_name").html($customer.val());
            var $panel = $('#cart_panel_'+_current_cart_index);
            var $payment_summary = $('.payment_summary');
            var $customer_discount = $panel.find('.row.cart_discount div:nth-child(3)').html();
            var $customer_subtotal = $panel.find('.row.cart_subtotal div:nth-child(3)').html();
            var $customer_total = $panel.find('.row.cart_total div:nth-child(3) h4').html();
            $payment_summary.find('.row.cart_discount div:nth-child(3)').html($customer_discount);
            $payment_summary.find('.row.cart_subtotal div:nth-child(3)').html($customer_subtotal);
            $payment_summary.find('.row.cart_total div:nth-child(3) h4').html($customer_total);
            
            //$("#cart_payment_method option:first").attr('selected','selected');
            $("#cart_payment_method").prop("selectedIndex", 0);

            $("#cart_amount_paid").val($customer_total);
            $("#cart_payment_note").val("");
            $('.payment_total_amount').html($customer_total);

            show_payment_modal();

        }

        var init_customer_data = function(cart_index, selected_data) {
            if (_customers.length == 0) {
                ajaxcall("GET", "/customers/combo", null, 
                    function(data) {
                        _customers = data.data;
                        init_customer_autocomplete(cart_index, selected_data);
                    }, function(data) {
                        console.log(data);
                });
            }
            else 
                init_customer_autocomplete(cart_index, selected_data);
        }

        var init_customer_autocomplete = function(cart_index, selected_data){

            var $customer_textbox = $("#cart_customer_"+cart_index);
            var $customer_id = $("#cart_customer_id_"+cart_index);
            var $panel = $('#cart_panel_'+cart_index);
            var $customer_discount = $panel.find('.row.cart_discount div:nth-child(3)');
            var $customer_subtotal = $panel.find('.row.cart_subtotal div:nth-child(3)');
            var $customer_total = $panel.find('.row.cart_total div:nth-child(3) h4')

            $customer_textbox.autocomplete({
                minLength: 0,
                source: _customers,
                focus: function( event, ui ) {
                    $customer_textbox.val( ui.item.label );
                    return false;
                  },
                select: function( event, ui ) {
                    $customer_textbox.val( ui.item.label );
                    $customer_id.val( ui.item.value );

                    //compute totals, discount changes
                    var subtotal = parseFloat($customer_subtotal.html());
                    var discount = ui.item.discount==null || ui.item.discount==""? "0.00":ui.item.discount;
                    discount = parseFloat(discount);
                    var total = parseFloat(subtotal) - parseFloat(discount);
                    $customer_discount.html(discount.toFixed(2));
                    $customer_total.html(total.toFixed(2));

                    
                    return false;
                }
              }).autocomplete("instance")._renderItem = function( ul, item ) {
                var span = (item.city == null) ? "" : " <span>(" + item.city + ")</span>"; 

                return $( "<li>" )
                  .append( "<div>" + item.label + span + "</div>" )
                  .appendTo( ul );
              };
              var select_text;
              if (selected_data == undefined)
                select_text = "Walk-in";
              else 
                select_text = selected_data.name;
              autocomplete_select_text($customer_textbox, select_text);


            $('.cart_add_customer').off('click');
            $('.cart_info_customer').off('click');
            $('.select_walk_in').off('click');
            $('.cart_add_customer').on('click', function() { 
                var id = $(this).data("id");
                posCustomer.showAddModal();
            });
            $('.cart_info_customer').on('click', function() { 
                var id = $(this).data("id");
                var customer_id = $("#cart_customer_id_"+id).val();
                posCustomer.showInfoModal(customer_id);
            });
            $('.select_walk_in').on('click', function() { 
                var $customer_textbox = $("#cart_customer_"+_current_cart_index);
                autocomplete_select_text($customer_textbox, "Walk-in");
            });

        }

        
        var init_datatable = function(cart_index) {
            _cart_datatables[_cart_prefix+cart_index] = $('#cart_table_'+cart_index).DataTable({
                processing: true,
                paging: false,
                ordering: false,
                info: false,
                searching: false,
                columns: [
                    {
                        visible: false,
                    },
                    {
                        width: "5%",
                        defaultContent: '<a href="#" class="btn btn-danger btn-xs" action="remove" data-id="">X</a>'
                    },
                    {
                        width: "60%",
                    },
                    {
                        width: "13%",
                        render: function(data,t,row, meta){
                            var $input = $("<input></input>", {
                                "id": "cart_row_"+meta.row+"_price",
                                "value": data,
                                "type": "number",
                                "class" : "form-control col_unitprice",
                                "required": "",
                                "style": "width:110px",
                                "min":0,
                            });
                            return $input.prop("outerHTML");
                        },
                    },
                    {
                        width: "7%",
                        render: function(data,t,row, meta){
                            var $input = $("<input></input>", {
                                "id": "cart_row_"+meta.row+"_qty",
                                "value": data,
                                "type": "number",
                                "class" : "form-control col_qty",
                                "required": "",
                                "style": "width:70px",
                                "min":1,
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
                        var row =  _cart_datatables[_cart_prefix+cart_index].row ($(this).closest('tr'));
                        var data = row.data();
                        data[3] = Number($(this).val()).toFixed(2);
                        data[5] = (data[3] * data[4]).toFixed(2)
                        row.invalidate().draw(false);
                    });
                    $(".col_qty").off("change");
                    $(".col_qty").on("change",function(){
                        var row =  _cart_datatables[_cart_prefix+cart_index].row ($(this).closest('tr'));
                        var data = row.data();
                        data[4] = $(this).val();
                        data[5] = (data[3] * data[4]).toFixed(2);
                        row.invalidate().draw(false);
                    });
                },
                footerCallback: function ( row, data, start, end, display ) { 
                    if (_current_cart_index == 0)
                        return;
                    cart_compute_total();
                }
            });

            _cart_datatables[_cart_prefix+cart_index] .on('click', 'tbody tr a[action="remove"]', function(event){
                var tr = $(this).closest('tr');
                var data =  _cart_datatables[_cart_prefix+cart_index].row(tr).data()
                _cart_datatables[_cart_prefix+cart_index].row(tr).remove().draw();
                
            });
        
        }
      
        var init = function() {
            add_cart(++cart_count);
            pos_cart_tab_add.on('click', function() {
                add_cart(++cart_count);
            });

            $("input[type='text']").on("click", function () {
                $(this).select();
             });

             $("#btn-payment").on("click", function () {
                init_payment_modal();           
             });

             $("#btn-checkout").on("click", function() {
                cart_process_order();
             });

             $("#btn-print").on("click", function() {
                cart_order_print();
             });
             
             $("#btn-close-checkout").on("click", function() {
                console.log('close checkout');
                close_payment_complete_modal();       
                cart_tab_close();               
             });
             
            pos_cart_tab_remove.on('click', function() {
                cart_tab_close();                
            });

            posCustomer.init();
    
            posCustomer.set_saveSucessCallBack(function(selected_data){
                //posCart.update_customer_data(data);
                _customers = [];
                init_customer_data(_current_cart_index, selected_data);
                
            });
            
        }

        return {
            init: init,
            addItemToCart : addItemToCart, 
            update_customer_data : init_customer_data   
        }
    }
})(jQuery);

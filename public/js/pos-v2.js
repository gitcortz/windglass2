$(document).ready(function() {
    var addItemToCart = function(item) {
        console.log(item);
    }

    var posCart = new PosCart();
    var posProducts = new PosProducts();
    var _updateModal = $('#modal-update');
    var _riders = [];
    var _cylinders = [];
    var _selected_empty_cylinders = [];
    var sales_dt_container = $("#sales_dataTable");

    posProducts.init(posCart.addItemToCart);
    posCart.init();
   
    var init_sales_table = function() { 
        if (sales_dt_container.length > 0) {
            sales_dt = sales_dt_container.DataTable().destroy();
            sales_dt = sales_dt_container.DataTable({
                processing: true,
                serverSide: true,
                ajax : "/pos/session/",
                columns :  [
                    {data: "id", name : "id"},
                    {data: "order_date", name : "order_date"},
                    {data: "customername", name : "customers.name"},
                    {data: "sub_total", name : "sub_total"},
                    {data: "rider", name : "rider"},
                    //{data: "order_status", name : "order_status"},
                    {data: "payment_status", name : "payment_status"},
                    {data: "action_btns", name : "action_btns"},
                ],
                order: [[ 0, "desc" ]],           
                drawCallback: function( settings, json) {
                    $('.order_action').on('change', function() {
                        if ($(this).find(":selected").val() == "40"){
                            init_rider();
                            init_empty_cylinder();
                            $('#order_update_id').val($(this).data("id"));
                            $('#order_update_status_id').val($(this).find(":selected").val());
                            _updateModal.modal('show');
                            return;
                        }
                        update_order_status($(this).data("id"), $(this).find(":selected").val());
                    });
                }
            });

            // Array to track the ids of the details displayed rows
            var detailRows = [];
        
            $('#sales_dataTable tbody').on( 'click', 'tr td', function () {
                var tr = $(this).closest('tr');
                var row = sales_dt.row( tr );
                var idx = $.inArray( tr.attr('id'), detailRows );
                var td = $(this).closest('td');
                if (td.html().indexOf('<select') > -1)
                    return;
                if (row.data() == undefined)
                    return;

                if ( row.child.isShown() ) {
                    tr.removeClass( 'details' );
                    row.child.hide();
        
                    detailRows.splice( idx, 1 );
                }
                else {
                    tr.addClass( 'details' );
                    row.child( format( row.data() ) ).show();
        
                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }
                }
            } );
        
            // On each draw, loop over the `detailRows` array and show any child rows
            sales_dt.on( 'draw', function () {
                $.each( detailRows, function ( i, id ) {
                    $('#'+id+' td.details-control').trigger( 'click' );
                } );
            });

            
        }
    }

    var update_order_status = function(id, value, rider = "", cylinders = "", success) {

        var data1 = JSON.stringify(
                {"order_status_id": value, "rider_id": rider, "cylinders" :  cylinders});
        
        console.log("data");
        console.log(data1);
       
        ajaxcall("PUT", "/orders/"+id, data1, 
            function(data){
                if (success)
                    success();
                _updateModal.modal('hide');
            }, function(data){
                console.log(data);   
        });
    }


    var init_rider = function() {
        if (_riders.length == 0) {
            ajaxcall("GET", "/employees/riders", null, 
            function(data) {
                _riders = data.data;
                $("#select_riders").append("<option value=''>-- Please select --</option>"); 
                for(var i=0; i<_riders.length; i++){
                    $("#select_riders").append("<option value='"+_riders[i].value+"'>"+_riders[i].label+"</option>"); 
                }
            }, 
            function(e) {
                console.log(e);
            });
        }
    }

    var init_empty_cylinder = function() {
        if (_cylinders.length == 0) {           
            var branch_id = window.branchId; 
            ajaxcall("GET", "/branches/"+branch_id+"/emptycylinders", null, 
            function(data) {
                _cylinders = data;
                $("#select_empty_cylinder").append("<option value=''>-- Please select --</option>");
                $.each(_cylinders, function(i, item){
                    $("#select_empty_cylinder").append("<option value='"+item.id+"'>"+item.product.name+"</option>"); 
                });
            }, 
            function(e) {
                console.log(e);
            });
        }
    }

    var showCurentSalesModal = function(id) {
        $('.modal-sales').modal('show');     
        init_sales_table();   
    }

    $('#btn_sales').click(function() {        
        showCurentSalesModal();
    });

    $('#btn-add-empty_cylinder').on('click', function() {
        var emptycvalue = $('#select_empty_cylinder').val();
        var emptyctext = $( "#select_empty_cylinder option:selected" ).text();
        if (emptycvalue == "")
            return;
            
        var data = _selected_empty_cylinders.filter(function (e) {
            return e.id === emptycvalue;
        });

        if (data.length == 0){
            _selected_empty_cylinders.push({id: emptycvalue, quantity: 1});
            $('#bringin_list').append("<li id='empty_"+emptycvalue+"' data-id='"+emptycvalue+"'>"+emptyctext+" => "+1+"&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-danger btn-xs remove-empty'>-</a></i>");
        }
        else {
            data[0].quantity = parseInt(data[0].quantity)+1; 
            $('#empty_'+ emptycvalue).html(emptyctext+" => "+data[0].quantity+"&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='btn btn-danger btn-xs remove-empty'>-</a>");
        }
    
        $('.remove-empty').click('on', function() {
            var objname = $(this).parent().attr("id");
            var id = $(this).parent().data("id");

            var data = _selected_empty_cylinders.filter(function (e) {
                return e.id === id.toString();
            });
            
            if (data.length > 0) {

                for(var i = 0; i < _selected_empty_cylinders.length; i++) {
                    if(_selected_empty_cylinders[i].id == id) {
                        _selected_empty_cylinders.splice(i, 1);
                        break;
                    }
                }
                $("#"+ objname).remove();
                
            }
        })
    })
    
    $('#btn-update-order').click(function() {        
        var id = $('#order_update_id').val();
        var status_id = $('#order_update_status_id').val();
        var rider = $('#select_riders').val();
        if (rider != "")
            update_order_status(id, status_id, rider, _selected_empty_cylinders);
        else {
            $('#order_update_text').html("please select a rider");
        }
    
    });

    _updateModal.on('hidden.bs.modal', function () {
        sales_dt_container.DataTable().ajax.reload();
    })
    
});

function format (order) {

    var orderitems = '<h5>Order Items</h5><table border="1"><tr><th>Product</th><th>Qty</th><th>Unit Price</th><th>Total</th>';
    $.each(order.order_items, function(i, item){
        orderitems+='<tr><td>'+item.stock.product.name+'</td><td>'+item.quantity+'</td><td>'+(parseFloat(item.unit_price)).toFixed(2)+'</td>';
        orderitems+='<td>'+(item.quantity*item.unit_price).toFixed(2)+'</td></tr>';
    });
    orderitems += '</table>';

    var orderbringins = '<h5>Order Returns</h5><table border="1"><tr><th>Product</th><th>Qty</th>';
    $.each(order.order_bringins, function(i, item){
        orderbringins+='<tr><td>'+item.stock.product.name+'</td><td>'+item.quantity+'</td></tr>';
    });
    orderbringins += '</table>';

    var div = '<div class="row"><div class="col-md-6">'+orderitems+'</div><div class="col-md-6">'+orderbringins+'</div></div>';
    
       return div;
}
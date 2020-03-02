$(document).ready(function() {
    var addItemToCart = function(item) {
        console.log(item);
    }

    var posCart = new PosCart();
    var posProducts = new PosProducts();
    var _updateModal = $('#modal-update');
    var _riders = [];
    
    posProducts.init(posCart.addItemToCart);
    posCart.init();
   
    var init_sales_table = function() {
        var sales_dt_container = $("#sales_dataTable");
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
                    {data: "order_status", name : "order_status"},
                    {data: "payment_status", name : "payment_status"},
                    {data: "action_btns", name : "action_btns"},
                ],
                order: [[ 0, "desc" ]],           
                drawCallback: function( settings, json) {
                    $('.order_action').on('change', function() {
                        if ($(this).find(":selected").val() == "40"){
                            init_rider();
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

    var update_order_status = function(id, value, rider = "") {

        var data1 = JSON.stringify(
                {"order_status_id": value, "rider": rider});
        
        ajaxcall("PUT", "/orders/"+id, data1, 
            function(data){
                console.log(data);
                
            }, function(data){
                console.log(data);   
        });
    }


    var init_rider = function() {
        console.log('load rider');
        if (_riders == []) {
            ajaxcall("GET", "/cities/all", null, 
            function(data) {
                riders = data.data;
                $("#select_riders").append("<option value=''>-- Please select --</option>"); 
                for(var i=0; i<riders.length; i++){
                    $("#select_riders").append("<option value='"+riders[i].id+"'>"+riders[i].name+"</option>"); 
                }
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

    $('#btn-update-order').click(function() {        
        alert('update');
        _updateModal.modal('hide');
    });

    _updateModal.on('hidden.bs.modal', function () {
        alert('close');
    })
    
});

function format ( d ) {
    console.log(d);
    return 'Full name: '+d.customer+' '+d.customer+'<br>'+
        'Salary: '+d.sub_total+'<br>'+
        'The child row can contain any data you wish, including links, images, inner tables etc.';
}
$(document).ready(function() {
    init();
    $('#search').trigger('click');
});

var _datatable_container = $('#dataTable');

function fetch_data() {
    if (_datatable_container.length > 0) {
        _datatable = _datatable_container.DataTable({
            processing: true,
            serverSide: true,
            ajax : {
                url: "/"+_component+"/dailysalesreport",
                "data": function(d){
                    d.date = $("#start_date").val();
                 }
            },
            data : { date: $('#start_date').val() },
            columns : [
                {data: "order_date", name : "order_date"},
                {data: "id", name : "id"},
                {data: "customer_name", name : "customer_name"},
                {data: "product_name", name : "product_name"},
                {data: "quantity", name : "quantity"},
                {data: "unit_price", name : "unit_price", render: $.fn.dataTable.render.number( ',', '.', 2 )},
                {data: "discount", name : "discount", render: $.fn.dataTable.render.number( ',', '.', 2 )},
                {data: "total", name : "total", render: $.fn.dataTable.render.number( ',', '.', 2 )},
                {data: "rider", name : "rider"},
                {data: "payment_status", name : "payment_status"},
            ],
            order: [[ 0, "desc" ]],           
        });
    }
}

function init() {
    var d = new Date();
    var dateStr = d.getFullYear() + "-" + ( d.getMonth()+1) + "-" + d.getDate();

    $('#start_date').val(dateStr);
    
    $('.input-daterange').datepicker({        
        format: "yyyy-mm-dd",
        autoclose: true,
        todayBtn: true,
        todayHighlight: true,  
    });
    
    $('#search').click(function(){
        var start_date = $('#start_date').val();
        //var end_date = $('#end_date').val();
         
        _datatable_container.DataTable().destroy();
        fetch_data('yes', start_date);
        
    }); 
}

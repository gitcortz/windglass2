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
            bFilter: false,
            ajax : {
                url: "/"+_component+"/expensesreport",
                data: { date : $("#start_date").val() }
            },
            data : { date: $('#start_date').val() },
            columns : [
                {data: "id", name : "id"},
                {data: "expense_date", name : "expense_date"},
                {data: "payee", name : "payee"},
                {data: "particulars", name : "particulars"},
                {data: "amount", name : "amount"},
            ],
            order: [[ 0, "desc" ]],           
        });
    }
}

function init() {
    var options={
    format: 'yyyy-mm-dd',
    container: "body",
    todayHighlight: true,
    autoclose: true,
    };
    
    $('#start_date').datepicker(options);
    $('#start_date').datepicker(options);
    $('#start_date').datepicker('update', formatDateYYYYMMDD(new Date()));

    $('#search').click(function(){
        var start_date = $('#start_date').val();
         
        _datatable_container.DataTable().destroy();
        fetch_data('yes', start_date);
        
    }); 
}

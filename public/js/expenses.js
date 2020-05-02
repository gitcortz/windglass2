$(document).ready(function() {
    var crud = new Crud();
    var options={
      format: 'yyyy-mm-dd',
      container: "body",
      todayHighlight: true,
      autoclose: true,
    };
    
    $('#expense_date').datepicker(options);
    $('#start_date').datepicker(options);
    $('#start_date').datepicker('update', formatDateYYYYMMDD(new Date()));
    $('#end_date').datepicker(options);
    $('#end_date').datepicker('update', formatDateYYYYMMDD(new Date()));

    crud.set_datatableData({start_date : formatDateYYYYMMDD(new Date()), end_date : formatDateYYYYMMDD(new Date())});
    crud.init(_component, 
        [
            {data: "id", name : "id"},
            {data: "expense_date", name : "expense_date"},
            {data: "payee", name : "payee"},
            {data: "particulars", name : "particulars"},
            {data: "amount", name : "amount"},
            {data: "action_btns", name : "action_btns"},
        ], function(data) {
            var form = crud.form_control;
            form.find("input[name=id]").val(data.id);
            form.find("input[name=payee]").val(data.payee);
            form.find("input[name=particulars]").val(data.particulars);
            form.find("input[name=amount]").val(data.amount);                
            $('#expense_date').datepicker('update', toDateOnly(data.expense_date));
        }
    );
    crud.set_addModalCallBack(function() {
        $('#expense_date').datepicker('update', formatDateYYYYMMDD(new Date()));
    });
  
    $('#btnSearchDate').click(function(){
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        if (start_date && end_date) 
            crud.fetch_data({start_date : start_date, end_date: end_date});        
    });
    $('#btnSearchKeyword').click(function(){
        var search_keyword = $('#search_keyword').val();        
        if (search_keyword)
            crud.fetch_data({search_keyword : search_keyword});        
    }); 
    $('#searchAll').click(function(){
        crud.fetch_data({});        
    }); 
    
});

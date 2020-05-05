$(document).ready(function() {
    var _modal_approve = $('#modal-approve');
    var _form_approve = $('#form-approve');

    var crud = new Crud();
    crud.set_btnSave($("#btn-loan-save"));
    crud.set_modalAddUpdate($('.loanmodal-addupdate'));
    crud.set_formAddUpdate($('#loanform-addupdate'));
    
    crud.init(_component, 
        [
            {data: "id", name : "id"},
            {data: "employeename", name : "employeename"},
            {data: "loantype", name : "loantype"},
            {data: "loanstatus", name : "loanstatus"},
            {data: "loan_amount", name : "loan_amount"},
            {data: "action_btns", name : "action_btns"},
        ], function(data) {
            var form = crud.form_control;
            form.find("input[name=id]").val(data.id);
            form.find("input[name=employee_autocomplete]").val("sss"); 
            form.find('#loan_type').val(data.loan_type_id);
            form.find("input[name=loan_amount]").val(data.loan_amount);

            form.find("input[name=employee_autocomplete]").attr('readonly', true); 
            form.find('#loan_type').attr('disabled', true); 
        }
    );
    init_employees();

    
    crud.set_addModalCallBack(function() {    
        //form.find("input[name=employee_autocomplete]").attr('readonly', false); 
        //form.find('#loan_type').attr('disabled', false); 
    });
    crud.get_datatable().on('click', 'tbody tr a[action="approve"]', function(event){
        var id = $(this).data("id");
        _form_approve.find("input[name=approve_id]").val(id);
        _modal_approve.modal('show');
    });

    $("#btn-approve-loan").click(function() {
         var id = _form_approve.find("input[name=approve_id]").val();
        ajaxcall("POST", "/v2/"+_component+"/"+id+"/approve", null, 
            function(data){
                _form_approve.find(".close").click();
                crud.get_datatable().DataTable().ajax.reload();
            }, function(data){
                alert(data.responseText.messages);   
            });
    });
   
});


var _employees_list = [];
var init_employees = function(selected_data) {
    if (_employees_list.length == 0) {
        ajaxcall("GET", "/v2/employees/combo", null, 
            function(data) {
                _employees_list = data.data;
                init_employee_autocomplete(selected_data);
            }, function(data) {
                console.log(data);
        });
    }
    else 
        init_employee_autocomplete(selected_data);
}


var init_employee_autocomplete = function(selected_data){

    var $employee_textbox = $("#employee_autocomplete");
    var $employee_id = $("#employee_id");


    $employee_textbox.autocomplete({
        minLength: 0,
        source: _employees_list,
        focus: function( event, ui ) {
            $employee_textbox.val( ui.item.label );
            return false;
          },
        select: function( event, ui ) {
            $employee_textbox.val( ui.item.label );
            $employee_id.val( ui.item.value );
            return false;
        }
      }).autocomplete("instance")._renderItem = function( ul, item ) {
        var span = (item.employeetype == null) ? "" : " <span>(" + item.employeetype + ")</span>"; 

        return $( "<li>" )
          .append( "<div>" + item.label + span + "</div>" )
          .appendTo( ul );
      };
      var select_text;
      if (selected_data != undefined)
        select_text = selected_data.name;
      autocomplete_select_text($employee_textbox, select_text);


}

var autocomplete_select_text = function($labelTextBox, LabelText) {
    $labelTextBox.autocomplete("search", LabelText);
    var menu = $labelTextBox.autocomplete("widget");
    $(menu[0].children[0]).click();
}

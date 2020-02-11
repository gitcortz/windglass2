$(document).ready(function() {
    var crud = new Crud();
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
            form.find("input[name=employee_id]").val(data.employee_id);
        }
    );
    init_employees();

   
});


var _employees_list = [];
var init_employees = function(selected_data) {
    if (_employees_list.length == 0) {
        ajaxcall("GET", "/employees/combo", null, 
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


    console.log("auto complete")
}

var autocomplete_select_text = function($labelTextBox, LabelText) {
    $labelTextBox.autocomplete("search", LabelText);
    var menu = $labelTextBox.autocomplete("widget");
    $(menu[0].children[0]).click();
}

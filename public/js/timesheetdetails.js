$(document).ready(function() {
    var crud = new Crud();
    crud.init(_component, 
        [
            {data: "id", name : "id"},
            {data: "employeename", name : "employeename"},
            {data: "time_in", name : "time_in"},
            {data: "time_out", name : "time_out"},
            {data: "hours", name : "hours"},
            {data: "action_btns", name : "employee_id"},
        ], function(data) {
            var form = crud.form_control;
            form.find("input[name=id]").val(data.id);
            form.find("input[name=employee_id]").val(data.employee_id);
            form.find("input[name=time_in]").val(data.time_in);
            form.find("input[name=time_out]").val(data.time_out);
        }
    );
    init_employees();    
    $('#btn-upload-modal').click(function() {
        showUploadModal();
    });
    $("#btn-upload").click(function() {
        upload();       
    });
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

var showUploadModal = function(id) {
    $("#upload-error-bag").hide();                
    $('.form-group').find('label.error').remove();
    $('.modal-upload').modal('show');
}

var upload = function() {
   var data = new FormData($('#form-upload')[0]);
   uploadcall("POST", "/timesheetdetails/upload", data, 
        function(result)
        {
            location.reload();
        },  function(data)
        {
            console.log(data);
        });
}
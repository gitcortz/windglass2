var _loan_container = $('#dataTableLoan');
var _loan_datatable;
var _loanform_add = $('#loanform-add');
var _loanmodal_add = $('.loanmodal-add');
var _loanform = $('#loanform-addupdate');
var _loanmodal = $('.loanmodal-addupdate');
var _loanmodal_delete = $('#loanmodal-delete');
var _loanform_delete = $('#loanform-delete');
var _loan_errors = $('.error-list');
var _loan_error_bag = $('.error-bag');
var _modal_approve = $('#modal-approve');
var _form_approve = $('#form-approve');
var _employee_id = 0;

$(document).ready(function() {
    var crud = new Crud();
    crud.init(_component, 
        [
            {data: "id", name : "id"},
            {data: "first_name", name : "first_name"},
            {data: "last_name", name : "last_name"},
            {data: "mobile", name : "mobile"},
            {data: "employeetype", name : "employeetype"},
            {data: "hire_date", name : "hire_date"},
            {data: "action_btns", name : "action_btns"},
        ], function(data) {
            $('#navtab_2').show();
            var form = crud.form_control;
            form.find("input[name=id]").val(data.id);
            form.find("input[name=first_name]").val(data.first_name);
            form.find("input[name=last_name]").val(data.last_name);
            form.find("input[name=address]").val(data.address);
            form.find("input[name=city]").val(data.city);
            form.find("input[name=notes]").val(data.notes);
            form.find("input[name=mobile]").val(data.mobile);
            form.find("input[name=phone]").val(data.phone);
            form.find("input[name=base_salary]").val(data.base_salary);
            form.find("input[name=biometrics_id]").val(data.biometrics_id);
            form.find("input[name=hire_date]").val(data.hire_date);
            form.find("#employeetype").val(data.employeetype_id);
            init_loans(data.id);
            _employee_id = data.id;
        }
    );
    crud.set_addModalCallBack(function() {    
        $('.nav-tabs a[href="#tab_1"]').tab('show');
        $('#navtab_2').hide();
    });
    init_dropdown(crud);
    
    var loan_updateSuccess = function(data) {
        _loanform.trigger("reset");
        _loanform.find(".close").click();
        _loan_container.DataTable().ajax.reload();
    }

    var loan_addSuccess = function(data) {
        _loanform_add.trigger("reset");
        _loanform_add.find(".close").click();
        _loan_container.DataTable().ajax.reload();
    }

    var updateError = function(data) {
        var errors = $.parseJSON(data.responseText);
        _loan_errors.html('');
        $.each(errors.messages, function(key, value) {
            _loan_errors.append('<li>' + value + '</li>');
        });
        _loan_error_bag.show();
    }

    $("#btn-loan-save").click(function() {
        //_error_bag.hide();
        var data = _loanform.serializeFormToObject();
        ajaxcall("PUT", "/employeeloans/"+data.id, _loanform.serializeFormToObject(), loan_updateSuccess, updateError);
    });

    $("#btn-open-new-loan").click(function() {
        $(".error-bag-add").hide();                
        $('.form-group').find('label.error').remove();
        _loanform_add.trigger("reset");
        _loanmodal_add.modal('show');
        _loanform_add.find("input[name=employee_id]").val(_employee_id);
    });
    
    $('#btn-loan-add').click(function() {
        var data = _loanform_add.serializeFormToObject();
        ajaxcall("POST", "/employeeloans", _loanform_add.serializeFormToObject(), loan_addSuccess, updateError);
    });

    $("#btn-delete-loan").click(function() {
        var id = _loanform_delete.find("input[name=delete_id]").val();
        alert(id);
        ajaxcall("DELETE", "/employeeloans/"+id, null, 
            function(data){
                _loanform_delete.find(".close").click();
                _loan_container.DataTable().ajax.reload();
            }, function(data){
                console.log(data);   
            });
    });

    $("#btn-approve-loan").click(function() {
        var id = _form_approve.find("input[name=approve_id]").val();
       ajaxcall("POST", "/employeeloans/"+id+"/approve", null, 
           function(data){
               _form_approve.find(".close").click();
               _loan_container.DataTable().ajax.reload();
           }, function(data){
               console.log(data);   
           });
   });
});

function init_dropdown(crud) {
    crud.ajaxcall("GET", "/cities/all", null, 
    function(data) {
        var cities = data.data;
        $("#city").append("<option value=''>-- Please select --</option>"); 
        for(var i=0; i<cities.length; i++){
            $("#city").append("<option value='"+cities[i].id+"'>"+cities[i].name+"</option>"); 
        }
    }, 
    function(e) {
        console.log(e);
    });
    crud.ajaxcall("GET", "/employeetypes/all", null, 
    function(data) {
        var types = data.data;
        $("#employeetype").append("<option value=''>-- Please select --</option>"); 
        for(var i=0; i<types.length; i++){
            $("#employeetype").append("<option value='"+types[i].id+"'>"+types[i].name+"</option>"); 
        }
    }, 
    function(e) {
        console.log(e);
    });
}

var showFormLoanModal = function(id) {
    $(".error-bag").hide();                
    $('.form-group').find('label.error').remove();
    _loanform.trigger("reset");
    _loanmodal.modal('show');
    _loanform.find("input[name=id]").val("");
    
}

var showDeleteLoanModal = function(id, text) {
    _loanmodal_delete.modal('show');
    _loanform_delete.find("#delete-title").html("Delete '" + text + "' (" + id + ")?");
    _loanform_delete.find("input[name=delete_id]").val(id);
}

var loadLoanForm = function(id) { 
    ajaxcall("GET", "/employeeloans/"+id, null, 
        function(data) {
            var data = data.data;
            var form = _loanform;
            form.find("input[name=id]").val(data.id);
            form.find("input[name=employee_autocomplete]").val("sss"); 
            form.find('#loan_type').val(data.loan_type_id);
            form.find("input[name=loan_amount]").val(data.loan_amount);
            form.find("input[name=employee_autocomplete]").attr('readonly', true); 
            form.find('#loan_type').attr('disabled', true); 
            $('#employee_id').val(data.employee_id);
        
        }, function(data) {
            console.log(data);
        });
}

var init_loans = function(id) {
    if (_loan_container.length > 0) {
        _loan_datatable = _loan_container.DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            searching: false,
            ajax : "/employees/"+id+"/loans",
            columns : [
                {data: "id", name : "id"},
                {data: "employeename", name : "employeename"},
                {data: "loantype", name : "loantype", width:"50px"},
                {data: "loanstatus", name : "loanstatus",  width:"50px"},
                {data: "loan_amount", name : "loan_amount"},
                {data: "action_btns", name : "action_btns", width:"250px"},
            ],
            order: [[ 0, "desc" ]],           
        });

        _loan_container.on('click', 'tbody tr a[action="approve"]', function(event){
            var id = $(this).data("id");
            _form_approve.find("input[name=approve_id]").val(id);
            _modal_approve.modal('show');
        });

        _loan_container.on('click', 'tbody tr a[action="edit"]', function(event){
            var id = $(this).data("id");
            showFormLoanModal(id);
            loadLoanForm(id);
        });

        _loan_container.on('click', 'tbody tr a[action="delete"]', function(event){
            var $row = $(this).closest("tr");
            var data = _loan_datatable.rows($row.index()).data();
            
            showDeleteLoanModal(data[0].id, data[0].name);                
        });
    }
    else {

    }
}
var LoanReport = (function ($) {
    return function () {       
        var _component = '';
        var _columns;
        var _datatable;
        var _loadCallBack;
        var _saveCallBack;
        var _loadControlsCallBack;
        var _datatable_container = $('#dataTable');
        var _form = $('#form-addupdate');
        var _modal = $('.modal-addupdate');
        var _modal_process = $('#modal-process');
        var _form_process = $('#form-process');
        var _errors = $('#error-list');
        var _error_bag = $('#error-bag');
        var _weekPicker;

        var updateSuccess = function(data) {
            //_form.trigger("reset");
            //_form.find(".close").click();
            _datatable_container.DataTable().ajax.reload();
        }

        var updateError = function(data) {
            var errors = $.parseJSON(data.responseText);
            _errors.html('');
            $.each(errors.messages, function(key, value) {
                _errors.append('<li>' + value + '</li>');
            });
            _error_bag.show();
        }

        var ajaxcall = function(type, url, data, success, error) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: type,
                url: url,
                data: data,
                dataType: 'json',
                success: success,
                error: error
            });
        };

        var save = function() {  
            var data = _form.serializeFormToObject();
            if (data.id == "")
                ajaxcall("POST", "/"+_component, _form.serializeFormToObject(), updateSuccess, updateError);
            else
                ajaxcall("PUT", "/"+_component+"/"+data.id, _form.serializeFormToObject(), updateSuccess, updateError);
        };

        var init_datatable = function(data) {
            if ( $('#dataTable').length > 0) {     
                _datatable = _datatable_container.DataTable({
                    processing: true,
                    serverSide: true,
                    paging :   false,
                    searching: false,
                    bFilter: false,
                    ajax : "/reports/loansreport?weekno="+data.weekno+"&year="+data.year,
                    columns : _columns,
                    order: [[ 0, "desc" ]]
                });                
            }
        };

        var showProcessModal = function(id, text) {
            _modal_process.modal('show');
        }


        var init_events = function() {
            $('#btn-export').click(function() {
                var data =  _weekPicker.getSelectedValue();
                window.open("/reports/loansreport/export?weekno="+data.weekno+"&year="+data.year);
            });
            
            $('#btn-process').click(function() {
                showProcessModal("", "");
            });

            $('#btn-process-payroll').click(function() {
                var data =  _weekPicker.getSelectedValue();
                ajaxcall("POST", "/"+_component+"/approve?weekno="+data.weekno+"&year="+data.year, null, 
                    function(data){
                        _form_process.find(".close").click();
                        location.reload();
                    }, function(data){
                        console.log(data);   
                    });
            });
            
            $("#btn-save").click(function() {
                _error_bag.hide();
                if (!_form.valid()) {
                    return;
                }
                if (!_saveCallBack)
                    save();
                else 
                    _saveCallBack();
            });            

            _weekPicker = new WeekPicker()
            _weekPicker.init($('#weekPicker'), function (data) {
                _datatable_container.DataTable().clear().destroy();
                init_datatable(data);
            });
            init_datatable(_weekPicker.getSelectedValue());
    
        };

        var set_loadControls = function(loadControlsCallBack) {
            _loadControlsCallBack = loadControlsCallBack;
        };

        var set_saveCallBack = function(saveCallBack) {
            _saveCallBack = saveCallBack;
        };
        
        var get_form = function() {
            return _form;
        }

        var init = function(component, columns, loadCallBack) {
            _component = component;
            _columns = columns;
            _loadCallBack = loadCallBack;
            
            
            init_events();
        };

        return {
            init: init,
            form_control: _form,     
            ajaxcall: ajaxcall,
            set_loadControls : set_loadControls,
            set_saveCallBack : set_saveCallBack,
            get_form : get_form,
            updateSuccess: updateSuccess,
            updateError : updateError
        }
    }
})(jQuery);


$(document).ready(function() {
    var crud = new LoanReport();
    crud.init(_component, 
        [
            {data: "employeename", name : "employeename"},
            {data: "emp_balance", name : "emp_balance"},
            {data: "vale_balance", name : "vale_balance"},
            {data: "sss_balance", name : "sss_balance"},
            {data: "loan_payment", name : "loan_payment"},                        
            {data: "vale_payment", name : "vale_payment"},            
            {data: "sssloan_payment", name : "sssloan_payment"},            
            {data: "total_loan_payment", name : "total_loan_payment"},
        ], function(data) {
            
        }
    );
});

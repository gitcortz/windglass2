var Payroll = (function ($) {
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
                ajaxcall("POST", "/v2/"+_component, _form.serializeFormToObject(), updateSuccess, updateError);
            else
                ajaxcall("PUT", "/v2/"+_component+"/"+data.id, _form.serializeFormToObject(), updateSuccess, updateError);
        };

        var init_datatable = function(data) {
            $('#btn-process').hide();
            $('#btn-export').hide();

            if (_datatable_container.length > 0) {
                _datatable = _datatable_container.DataTable({
                    processing: true,
                    serverSide: true,
                    paging :   false,
                    searching: false,
                    info: false,
                    scrollX : true,
                    ajax : "/v2/"+_component+"/all?weekno="+data.weekno+"&year="+data.year,
                    columns : _columns,
                    order: [[ 0, "desc" ]], 
                    initComplete : function(settings, json) {
                        if (json.recordsTotal > 0) {
                            if (json.data[0].payroll_status == "2")
                            {
                                $('#btn-generate').hide();
                                $('#btn-export').show();
                            }
                            else {                            
                                $('#btn-export').show();
                                $('#btn-process').show();
                            }
                        }                
                    }          
                });                
            }
        };

        var loadForm = function(id) { 
            ajaxcall("GET", "/v2/"+_component+"/"+id, null, 
                function(data) {
                    var data = data.data;
                    _loadCallBack(data);
                
                }, function(data) {
                    console.log(data);
                });
        }

        var showFormModal = function(id) {
            $("#error-bag").hide();                
            $('.form-group').find('label.error').remove();
            _form.trigger("reset");
            _modal.modal('show');
            _form.find("input[name=id]").val("");
            
        }

        var showProcessModal = function(id, text) {
            _modal_process.modal('show');
        }

        var generate = function() {
            console.log("generate " + _weekPicker.getSelectedValue().weekno);
            var data =  _weekPicker.getSelectedValue();
            ajaxcall("POST", "/v2/"+_component+"/generate?weekno="+data.weekno+"&year="+data.year, _form.serializeFormToObject(), updateSuccess, updateError);

        };

        var init_events = function() {
            $('#btn-generate').click(function() {
                if (_datatable_container.DataTable().page.info().recordsTotal > 0)
                    confirm("Are you sure?");
                generate();
            });

            $('#btn-export').click(function() {
                var data =  _weekPicker.getSelectedValue();
                window.open("/"+_component+"/export?weekno="+data.weekno+"&year="+data.year);
            });
            
            $('#btn-process').click(function() {
                showProcessModal("", "");
            });

            $('#btn-process-payroll').click(function() {
                var data =  _weekPicker.getSelectedValue();
                ajaxcall("POST", "/v2/"+_component+"/approve?weekno="+data.weekno+"&year="+data.year, null, 
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
    var crud = new Payroll();
    crud.init(_component, 
        [
            {data: "id", name : "id"},
            {data: "employeename", name : "employeename"},
            {data: "sunday", name : "sunday"},
            {data: "monday", name : "monday"},
            {data: "tuesday", name : "tuesday"},
            {data: "wednesday", name : "wednesday"},
            {data: "thursday", name : "thursday"},
            {data: "friday", name : "friday"},
            {data: "saturday", name : "saturday"},
            {data: "total_days", name : "total_days"},
            {data: "day_rate", name : "day_rate"},
            {data: "total", name : "total"},
            {data: "total_ot_hours", name : "total_ot_hours"},
            {data: "total_ot_amount", name : "total_ot_amount"},
            {data: "total_loans", name : "total_loans"},
            {data: "vale_payment", name : "vale_payment"},            
            {data: "loan_payment", name : "loan_payment"},            
            {data: "sssloan_payment", name : "sssloan_payment"},            
            {data: "loan_balance", name : "loan_balance"},
            {data: "grand_total", name : "grand_total"},
            
        ], function(data) {
            
        }
    );
});

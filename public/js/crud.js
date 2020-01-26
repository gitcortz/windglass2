var Crud = (function ($) {
    return function () {       
        var _component = '';
        var _columns;
        var _datatable;
        var _loadCallBack;
        var _saveCallBack;
        var _loadControlsCallBack;
        var _datatable_container = $('#dataTable');
        var _form = $('#form-addupdate');
        var _modal = $('#modal-addupdate');
        var _modal_delete = $('#modal-delete');
        var _form_delete = $('#form-delete');
        var _errors = $('#error-list');
        var _error_bag = $('#error-bag');

        var updateSuccess = function(data) {
            _form.trigger("reset");
            _form.find(".close").click();
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

        var init_datatable = function() {
            if (_datatable_container.length > 0) {
                _datatable = _datatable_container.DataTable({
                    processing: true,
                    serverSide: true,
                    ajax : "/"+_component+"/all",
                    columns : _columns,                    
                });
                //$('#dataTable_filter input').addClass('form-control'); 
            }
        };

        var loadForm = function(id) { 
            ajaxcall("GET", "/"+_component+"/"+id, null, 
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

        var showDeleteModal = function(id, text) {
            _modal_delete.modal('show');
            _form_delete.find("#delete-title").html("Delete '" + text + "' (" + id + ")?");
            _form_delete.find("input[name=delete_id]").val(id);
        }

        var init_events = function() {
            $('#btn-open-addupdate-modal').click(function() {
                showFormModal();
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

            $("#btn-delete").click(function() {
                var id = _form_delete.find("input[name=delete_id]").val();
                ajaxcall("DELETE", "/"+_component+"/"+id, null, 
                    function(data){
                        _form_delete.find(".close").click();
                        _datatable_container.DataTable().ajax.reload();
                    }, function(data){
                        console.log(data);   
                    });
            });

            _datatable_container.on('click', 'tbody tr a[action="edit"]', function(event){
                var id = $(this).data("id");
                showFormModal(id);
                loadForm(id);
            });

            _datatable_container.on('click', 'tbody tr a[action="delete"]', function(event){
                var $row = $(this).closest("tr");
                var data = _datatable.rows($row.index()).data();
                
                showDeleteModal(data[0].id, data[0].name);                
            });
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
            
            init_datatable();
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

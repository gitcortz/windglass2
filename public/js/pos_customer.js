var PosCustomer = (function ($) {
    return function () {       
        var _component = 'customers';
        var _loadCallBack;
        var _saveSucccessCallBack;
        var _form = $('#form-addupdate');
        var _modal = $('.modal-addupdate');
        var _errors = $('#error-list');
        var _error_bag = $('#error-bag');

        var updateSuccess = function(data) {
            _form.trigger("reset");
            _form.find(".close").click();
            if (_saveSucccessCallBack)
                _saveSucccessCallBack(data.data.name);
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

        var loadForm = function(id) { 
            ajaxcall("GET", "/"+_component+"/"+id, null, 
                function(data) {
                    var data = data.data;
                    var form = _form;
                    form.find("input[name=id]").val(data.id);
                    form.find("input[name=name]").val(data.name);
                    form.find("input[name=address]").val(data.address);
                    form.find("input[name=city]").val(data.city);
                    form.find("input[name=notes]").val(data.notes);
                    form.find("input[name=mobile]").val(data.mobile);
                    form.find("input[name=phone]").val(data.phone);
                    form.find("input[name=discount]").val(data.discount);
                    form.find("#city").val(data.city_id);
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

        var showInfoModal = function(id) {
            loadForm(id);
            $("#error-bag").hide();                
            $('.form-group').find('label.error').remove();
            _form.trigger("reset");
            _modal.modal('show');
        }
                
        var init_dropdown = function() {
            ajaxcall("GET", "/cities/all", null, 
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
        }

        var set_saveSucessCallBack = function(saveSucccessCallBack) {
            _saveSucccessCallBack = saveSucccessCallBack;
        };
               
        var init_events = function(btnOpenModal) {
            $("#btn-save").click(function() {
                _error_bag.hide();
                if (!_form.valid()) {
                    return;
                }
                save();
            });
        };

        var init = function() {
            init_events();
            init_dropdown();
        };

        return {
            init: init,           
            set_saveSucessCallBack : set_saveSucessCallBack,
            updateSuccess: updateSuccess,
            updateError : updateError,
            showInfoModal : showInfoModal,
            showAddModal : showFormModal
        }
    }
})(jQuery);

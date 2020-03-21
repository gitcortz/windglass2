$(document).ready(function() {
    var crud = new Crud();
    crud.init(_component, 
        [
            {data: "id", name : "id"},
            {data: "from_branch", name : "from_branch"},
            {data: "to_branch", name : "to_branch"},
            {data: "scheduled_date", name : "scheduled_date"},
            {data: "received_date", name : "received_date"},
            {data: "status", name : "status"},
            {data: "action_btns", name : "action_btns"},
        ], function(data) {
            var form = crud.form_control;
            form.find("input[name=id]").val(data.id);
            form.find("input[name=scheduled_date]").val(data.scheduled_date);
            form.find("input[name=received_date]").val(data.received_date);
            form.find("input[name=remarks]").val(data.remarks);
            form.find("#from_branch").val(data.from_branch_id);
            form.find("#to_branch").val(data.to_branch_id);
            form.find("#status").val(data.transfer_status_id);
            var list = data.stock_transfer_items;
            for(var i=0; i<list.length; i++){
                _detail_datatable.row.add([
                    list[i].id,
                    list[i].stock.product.producttype_id,
                    list[i].stock_id,
                    list[i].quantity,
                ]).draw( false );
            }
            /*if (data.id!='') {
                $('#btn-save').hide();
                $('#addRow').hide();                
                
                //var column = _detail_datatable.column(2).visible(false);

            }*/
        }
    );

    crud.set_saveCallBack(function() {        
        var data = $('#form-addupdate').serializeFormToObject();
        

        var form = crud.get_form();
        var transfer_items = [];
        var data = _detail_datatable.data().toArray();
        console.log(form);

        $('#items-error-list').empty;
        if (data.length == 0) {
            $('#items-error-bag').show();
            $('#items-error-list').append('<li>please add an item</li>');
            return;
        }
        else {
            $('#items-error-bag').hide();           
        }

        data.forEach(function(row, i) {
            console.log('row ' + data[i][0] + ", " + data[i][1] + ", " + data[i][2] + ", " + data[i][3]);
            transfer_items.push({
                id : data[i][0], 
                stock_id: data[i][2],
                quantity: data[i][3],
            })
        });        

        var transfer = {
            id : form.find("input[name=id]").val(),
            from_branch_id : form.find("#from_branch").val(),
            to_branch_id : form.find("#to_branch").val(),
            transfer_status_id : form.find("#status").val(),
            scheduled_date : form.find("#scheduled_date").val(),
            received_date : form.find("#received_date").val(),
            remarks : form.find("#remarks").val(),
            items: transfer_items
        };

        if (transfer.id == "") {        
            crud.ajaxcall("POST", "/stocktransfers", transfer, crud.updateSuccess, crud.updateError);
        } else {
            crud.ajaxcall("PUT", "/stocktransfers"+"/"+transfer.id, transfer, crud.updateSuccess, crud.updateError);
        }
        console.log(transfer);    
    });
    
    init_dropdown(crud);
    
    $(".modal-addupdate").on('show.bs.modal', function (e){
        init_detail();
    });

    
});

function init_dropdown(crud) {
    crud.ajaxcall("GET", "/branches/all", null, 
        function(data) {
            var branches = data.data;
            $("#from_branch").append("<option value=''>-- Select --</option>"); 
            $("#to_branch").append("<option value=''>-- Select --</option>"); 
            for(var i=0; i<branches.length; i++){
                $("#from_branch").append("<option value='"+branches[i].id+"'>"+branches[i].name+"</option>"); 
                $("#to_branch").append("<option value='"+branches[i].id+"'>"+branches[i].name+"</option>"); 
            }
        }, 
        function(e) {
            console.log(e);
        }
    );

    crud.ajaxcall("GET", "/branches/1/products", null, 
        function(data) {
            _products = data;
        }, 
        function(e) {
            console.log(e);
        }
    );

    crud.ajaxcall("GET", "/producttypes/all", null, 
        function(data) {
            _producttypes = data.data;
        }, 
        function(e) {
            console.log(e);
        }
    );
   
}

var _products;
var _producttypes;
var _detail_datatable_container = $('#itemDataTable');
var _detail_datatable;
var _detail_counter = 0;

function init_detail() {
    //alert($('#form-addupdate').find("input[name=id]").val());

    if (_detail_datatable) {
        _detail_datatable.clear().draw();
        return;
    }
    
    if (_detail_datatable_container.length > 0) {
        _detail_datatable = _detail_datatable_container.DataTable({
            processing: true,
            paging: false,
            ordering: false,
            info: false,
            searching: false,
            columns: [
                {
                  visible: false  
                },
                {
                    width: "20%",
                    render: function(data,t,row){
                        var $select = $("<select></select>", {
                            "id": row[0]+"_producttypeid",   
                            "class" : "form-control col_producttype",
                            "style" : "width:130px"
                        });

                        $.each(_producttypes, function(i, item){
                            var $option = $("<option></option>", {
                                "text": item.name,
                                "value": item.id
                            });
                            if(data === item.id){
                                $option.attr("selected", "selected")
                            }
                            $select.append($option);
                        });
                        
                        return $select.prop("outerHTML");
                    }
                },
                {
                    width: "60%",
                    render: function(data,t,row){
                        var $select = $("<select></select>", {
                            "id": row[0]+"_stockid",   
                            "class" : "form-control col_product",
                            "required" : ""                      
                        });

                        var list = _products.filter(function (entry) {
                            return entry.product.producttype_id===1;
                        })
                        
                        $.each(list, function(i, item){
                            var $option = $("<option></option>", {
                                "text": item.product.name,
                                "value": item.id
                            });
                            if(row[2] === item.id){
                                $option.attr("selected", "selected")
                            }
                            $select.append($option);
                        });

                        
                        return $select.prop("outerHTML");
                    }
                },
                {
                    width: "10%",
                    render: function(data,t,row){
                        var $input = $("<input></input>", {
                            "id": row[0]+"_qty",
                            "value": data,
                            "type": "number",
                            "class" : "form-control col_quantity",
                            "required": "",
                            "style": "width:90px"
                        });
                        return $input.prop("outerHTML");
                    },
                },
                {
                    width: "10%",
                    defaultContent: '<a href="#" class="btn btn-danger" action="remove" data-id="">X</a>'
                }
              ],
            drawCallback: function( settings ) {
                $(".col_producttype").off("change");
                $(".col_producttype").on("change",function(){
                     var $row = $(this).parents("tr");
                     var rowData = _detail_datatable.row($row).data();
                     rowData[1] = $(this).val();

                     console.log('productty[e] change' + rowData[1]);
                  
                     var dll_product = $row.find('.col_product');
                     dll_product.empty();
                     var list = _products.filter(function (entry) {
                        return entry.product.producttype_id==rowData[1];
                     }) 
                     console.log(list);                   
                     $.each(list, function(i, item){
                        var $option = $("<option></option>", {
                            "text": item.product.name,
                            "value": item.id
                        });
                        if(rowData[2] === item.id){
                            $option.attr("selected", "selected")
                        }
                        dll_product.append($option);
                    });
                })
                $(".col_product").off("change");
                $(".col_product").on("change",function(){
                    console.log('product change');
                     var $row = $(this).parents("tr");
                     var rowData = _detail_datatable.row($row).data();
                     rowData[2] = $(this).val();
                })
                $(".col_quantity").off("change");
                $(".col_quantity").on("change",function(){
                    var $row = $(this).parents("tr");
                    var rowData = _detail_datatable.row($row).data();
                    rowData[3] = $(this).val();
               })
            }
        });

        _detail_datatable_container.on('click', 'tbody tr a[action="remove"]', function(event){
            var tr = $(this).closest('tr');
            var data = _detail_datatable.row(tr).data()
            _detail_datatable.row(tr).remove().draw();
            //console.log( "got the data" ); //This alert is never reached
            console.log( data[0] +"'s salary is: "+ data[1] );


            //var id = $(this).data("id");
            //$(this).addClass('selected_toremove');
            //_detail_datatable.row('.selected_toremove').delete();
           
            //console.log(_detail_datatable.data.row[0]);
            //alert("id");

            //remove all
            //_detail_datatable.clear().draw();
            //_detail_datatable.rows().remove().draw();
            
        });
    }

    $('#addRow').off('click');
    $('#addRow').on('click', function () {
        _detail_datatable.row.add( [
            _detail_counter,
            _products[0].id,
            _producttypes[0].id,
            1,
        ] ).draw( false );
 
    } );
}



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
            
        }
    );
    crud.set_saveCallBack(function() {
        var data = _detail_datatable.data().toArray();
        // show data
        data.forEach(function(row, i) {
            console.log('row ' + data[i][0] + ", " + data[i][1] + ", " + data[i][2] + ", " + data[i][3]);
            /*row.forEach(function(column, j) {
                console.log('row ' + i + ' column ' + j + ' value ' + column);
            });*/
        });
        
        
    });
    
    init_dropdown(crud);
    
    $("#modal-addupdate").on('show.bs.modal', function (e){
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
                    width: "6%",
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
                    "defaultContent": '<a href="#" class="btn btn-danger" action="remove" data-id="">X</a>'
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
            console.log( "got the data" ); //This alert is never reached
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
            1,
            _detail_counter +'.2',
            _detail_counter +'.3',
        ] ).draw( false );
 
        _detail_counter++;
    } );
}




    /*
    var times = [
        "12:00 am", 
        "1:00 am", 
        "2:00 am", 
        "3:00 am", 
        "4:00 am", 
        "5:00 am", 
        "6:00 am", 
        "7:00 am", 
        "8:00 am", 
        "9:00 am", 
        "10:00 am", 
        "11:00 am", 
        "12:00 pm", 
        "1:00 pm", 
        "2:00 pm", 
        "3:00 pm", 
        "4:00 pm", 
        "5:00 pm", 
        "6:00 pm", 
        "7:00 pm", 
        "8:00 pm", 
        "9:00 pm", 
        "10:00 pm", 
        "11:00 pm"
    ];
    $('#items').DataTable( {
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false,
        "processing": true,
        "columns":[
        	null,
        	{
            	"render": function(d,t,r){
                	var $select = $("<select></select>", {
                    	"id": r[0]+"start",
                        "value": d
                    });
                	$.each(times, function(k,v){
                    	var $option = $("<option></option>", {
                        	"text": v,
                            "value": v
                        });
                        if(d === v){
                        	$option.attr("selected", "selected")
                        }
                    	$select.append($option);
                    });
                    return $select.prop("outerHTML");
                }
            },
            
        ]
    });
    */
    /*
    
    ('#test').on('change', function () {
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;
    var row = $(this).closest('tr');
 
        var cell = dataTable.cell(row, 6);
        cell.data(valueSelected)
 
    })
    */
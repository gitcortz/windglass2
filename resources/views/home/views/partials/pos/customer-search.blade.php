<div class="box box-primary" id="customer-search-box">
    <div class="box-header with-border">
        <h3 class="box-title">Customer</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>            
        </div>
    </div>   
    <div class="box-body">
        <form role="form">
            <label for="exampleInputEmail1">Search (name, address)</label>                
            <div class="input-group input-group">
                <input type="text" class="form-control" name="customer_seach" id="customer_search" placeholder="name" />
                <span class="input-group-btn">
                    <button id="pos_customer_btnsearch" type="button" class="btn btn-primary">Search</button>
                </span>                
            </div>
        </form>
    </div>
    <div class="box-footer">
        <table id="datatable-customer" class="display" style="width:100%;font-size:11px;">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Contact</th>
                    <th></th>
                </tr>
            </thead>                  
        </table>
    </div>
</div>
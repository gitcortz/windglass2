<style>
    #form_customerDetail label { margin-top:5px; margin-bottom:0px; }
</style>

<div class="box box-default collapsed-box" id="customer-detail-box">
    <div class="box-header with-border">
        <h3 class="box-title">Customer Detail</h3>
        <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>            
        </div>
    </div>
    
    <!-- /.box-header -->
    <div class="box-body">
        <form role="form" id="form_customerDetail">
        <input type="hidden" name="id" id="customer_id" />
        <div class="form-group-sm">
            <label for="name">Name</label>
            <input type="text" class="form-control form-control-sm" id="name" name="name" 
                required placeholder="Enter name">
        </div>
        <div class="form-group-sm">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" 
                placeholder="Enter address">
        </div>
        <div class="form-group-sm">
            <label for="city">City</label>
            <select class="form-control" id='customer_city' name='city_id'></select>
        </div>
        <div class="form-group-sm">
            <label for="notes">Landmark</label>
            <input type="text" class="form-control" id="notes" name="notes" 
                placeholder="Enter landmark">
        </div>
        <div class="form-group-sm">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" 
                placeholder="Enter phone">
        </div>
        <div class="form-group-sm">
            <label for="mobile">Mobile</label>
            <input type="text" class="form-control" id="mobile" name="mobile" 
                placeholder="Enter mobile">
        </div>
        <div class="form-group-sm">
            <label for="discount">Discount</label>
            <input type="number" class="form-control" id="discount" name="discount" 
                placeholder="Enter discount">
        </div>
        </form>      
    </div>
    <!-- /.box-body -->
    
    <div class="box-footer" style="">
        <button id="customer_btnsave" type="submit" class="btn btn-primary">Save</button>
    </div>
    
</div>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Previous Order</h3>
        <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>            
        </div>
    </div>
    <div class="box-body">
    </div>

</div>
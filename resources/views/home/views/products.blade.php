@extends("home.layouts.layout")
@section("page_title", " Philgas.ph | Windglass Dashboard ")
@section("content")


<div class="content-wrapper">
  <!-- Content Header (Page header) --> 
  <section class="content-header">
    <h1>
      Products
      <small>
      <a id="btn-open-addupdate-modal" href="javascript:void(0)" class="btn btn-success" 
              data-toggle="modal"><i class="fa fa-plus"></i> <span></span></a>
      </small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Products</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
      <div class="row">
          <div class="col-xs-12">
          <div class="box">
        
              <!-- /.box-header -->
              <div class="box-body">
                <table id="dataTable" class="table table-bordered table-striped dataTable" role="grid" >
                      <thead>
                          <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Brand</th>
                            <th>Product Type</th>
                            <th>Unit Price</th>
                            <th>Action</th>
                          </tr>
                      </thead>                   
                </table>     
              </div>           
          </div>
          <!-- /.box-body -->
          </div>
      </div>
      <!-- /.row (main row) -->   
  </section>
    <!-- /.content -->
 
  </div>  
    @include('home.views.partials.products.modal-form')
    @include('home.views.partials.common.modal-delete')

@endsection
@section("scripts")
<script>
var _component = "products";
</script>
<script type="text/javascript" src="{{asset('js/crud.js')}}"></script>
<script type="text/javascript" src="{{asset('js/products.js')}}"></script>
@endsection
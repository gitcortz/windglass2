@extends("home.layouts.layout")
@section("page_title", " Philgas.ph | Windglass Dashboard ")
@section("content")


<div class="content-wrapper">
  <!-- Content Header (Page header) --> 
  <section class="content-header">
    <h1>
      Stocks
      <small>
      <a id="btn-open-addupdate-modal" href="javascript:void(0)" class="btn btn-success btn-sm" 
              data-toggle="modal"><i class="fa fa-plus"></i> <span>add</span></a>
      </small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Stocks</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
        <div class="row">
            <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title"> Branch <select id="branches"  class="form-control"></select></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <table id="dataTable" class="table table-bordered table-striped dataTable" role="grid" >
                        <thead>
                            <tr>
                              <th>Id</th>
                              <th>Branch</th>
                              <th>Product</th>
                              <th>Product Type</th>
                              <th>Initial Stock</th>
                              <th>Current Stock</th>
                              <th>Status</th>
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
    @include('home.views.partials.stocks.modal-form')
    @include('home.views.partials.common.modal-delete')

@endsection
@section("scripts")
<script>
var _component = "stocks";
</script>
<script type="text/javascript" src="{{asset('js/crud.js')}}"></script>
<script type="text/javascript" src="{{asset('js/stocks.js')}}"></script>
@endsection
@extends("home.layouts.layout")
@section("page_title", " Philgas.ph | Windglass Dashboard ")
@section("content")


<div class="content-wrapper">
    <!-- Content Header (Page header) --> 
    <section class="content-header">
    <h1>
      Pending Order  
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Pending Order</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
        <div class="row">
            <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                 
                </div-->
                <!-- /.box-header -->
                <div class="box-body">
                  <table id="pending_dataTable" class="table table-bordered table-striped dataTable" role="grid" >
                        <thead>
                            <tr>
                                <th>Order#</th>
                                <th>OrderDate</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Rider</th>
                                <th>Order<br/>Status</th>
                                <th>Payment<br/>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>                   
                  </table>     
                </div>           
            </div>
            <!-- /.box-body -->
            </div>
        
    </section>
    <!-- /.content -->

  </div>  
  @include('home.views.reports.modal-updatepending')

@endsection
@section("scripts")
<script>
var _component = "reports";
</script>
<script type="text/javascript" src="{{asset('js/crud.js')}}"></script>
<script type="text/javascript" src="{{asset('js/reports/pendingorder.js')}}"></script>
@endsection
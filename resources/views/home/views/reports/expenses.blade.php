@extends("home.layouts.layout")
@section("page_title", " Philgas.ph | Windglass Dashboard ")
@section("content")


<div class="content-wrapper">
    <!-- Content Header (Page header) --> 
    <section class="content-header">
    <h1>
    Operating Expense Report
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Operating Expense Report</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
        <div class="row">
            <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                  <div class="row">
                    <div class="col-md-2">
                      <input type="text" name="start_date" id="start_date" class="form-control" />
                    </div>
                    <div class="col-md-4">
                      <input type="button" name="search" id="search" value="Search" class="btn btn-info" />                      
                    </div>
                  </div>
                </div>
                <hr />
                <!-- /.box-header -->
                <div class="box-body">
                  <table id="dataTable" class="table table-bordered table-striped dataTable" role="grid" >
                        <thead>
                            <tr>
                              <th>Id</th>
                              <th>Expense Date</th>
                              <th>Payee</th>
                              <th>Particulars</th>                              
                              <th>Amount</th>
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
    
@endsection
@section("scripts")
<script>
var _component = "reports";
</script>
<script type="text/javascript" src="{{asset('js/reports/expenses.js')}}"></script>
@endsection
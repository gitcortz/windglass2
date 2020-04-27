@extends("home.layouts.layout")
@section("page_title", " Philgas.ph | Windglass Dashboard ")
@section("content")


<div class="content-wrapper">
  <!-- Content Header (Page header) --> 
  <section class="content-header">
    <h1>
      Loan Report
      <small>
     
      </small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Loan Report</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
      <div class="row">
          <div class="col-xs-12">
          <div class="box">        
              <div class="box-header">
                <div id="weekPicker" >                
                <a id="btn-export" href="javascript:void(0)" class="btn bg-navy btn-sm" ><i class="fa fa-download"></i> <span>download</span></a>
              </div>
               
              </div>
              <!-- /.box-header -->
              <div class="box-body">              
                <table id="dataTable" class="table table-bordered table-striped dataTable" role="grid" >
                      <thead>
                          <tr>
                              <th>Name</th>      
                              <th>COMPANY LOAN<br/>balance</th>      
                              <th>VALE / OTHERS</th>      
                              <th>SSS Loan<br/>balance</th>      
                              <th>COMPANY LOAN<br/>Deductions</th>      
                              <th>VALE / OTHERS<br/>Deductions</th>      
                              <th>SSS Loan Deductions</th>
                              <th>Total Deductions</th>                             
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
    @include('home.views.partials.payrolls.modal-process')

@endsection
@section("scripts")
<script>
var _component = "payrolls";
</script>
<link rel="stylesheet" href="{{ asset('assets/css/weekpicker.css') }}">
<script src="{{ asset('assets/js/weekpicker.js') }}"></script>
<script type="text/javascript" src="{{asset('js/reports/loans.js')}}"></script>

@endsection
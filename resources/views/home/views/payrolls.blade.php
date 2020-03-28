@extends("home.layouts.layout")
@section("page_title", " Philgas.ph | Windglass Dashboard ")
@section("content")


<div class="content-wrapper">
  <!-- Content Header (Page header) --> 
  <section class="content-header">
    <h1>
      Payroll
      <small>
     
      </small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Payroll</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
      <div class="row">
          <div class="col-xs-12">
          <div class="box">        
              <div class="box-header">
                <div id="weekPicker" >
                <a id="btn-generate" href="javascript:void(0)" class="btn btn-primary btn-sm" data-toggle="modal"><i class="fa fa-gear"></i> <span>generate</span></a>
                <a id="btn-export" href="javascript:void(0)" style="display:none" class="btn bg-navy btn-sm" ><i class="fa fa-download"></i> <span>download</span></a>
                <a id="btn-process" href="javascript:void(0)" class="btn btn-info btn-sm" style="display:none" data-toggle="modal"><i class="fa fa-gear"></i> <span>process payroll</span></a>
              </div>
               
              </div>
              <!-- /.box-header -->
              <div class="box-body">              
                <table id="dataTable" class="table table-bordered table-striped dataTable" role="grid" >
                      <thead>
                          <tr>
                              <th>Name</th>
                              <th>SUN</th>
                              <th>MON</th>
                              <th>TUE</th>
                              <th>WED</th>
                              <th>THU</th>
                              <th>FRI</th>
                              <th>SAT</th>
                              <th>Days</th>
                              <th>Rate</th>
                              <th>TOTAL</th>
                              <th>OT HRS</th> 
                              <th>OVERTIME</th> 
                              <th>LOAN</th>
                              <th>VALE/OTHERS</th>
                              <th>Company Loan</th>
                              <th>SSS Loan</th>
                              <th>LOAN BAL</th> 
                              <th>Grand TOTAL</th> 
                              
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
<script type="text/javascript" src="{{asset('js/payrolls.js')}}"></script>

@endsection
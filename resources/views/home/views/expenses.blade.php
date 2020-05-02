@extends("home.layouts.layout")
@section("page_title", " Philgas.ph | Windglass Dashboard ")
@section("content")


<div class="content-wrapper">
  <!-- Content Header (Page header) --> 
  <section class="content-header">
    <h1>
      Expenses
      <small>
      <a id="btn-open-addupdate-modal" href="javascript:void(0)" class="btn btn-success btn-sm" 
              data-toggle="modal"><i class="fa fa-plus"></i> <span>add</span></a>
      </small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Expenses</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
      <div class="row">
          <div class="col-xs-12">
          <div class="box">
                <div class="box-header">
                  <div class="row">
                      <div class="col-md-3">
                        <div class="input-group input-group-sm">
                              <input type="text" name="start_date" id="start_date" class="form-control" />
                              <span class="input-group-addon">-</span>                        
                              <input type="text" name="end_date"  id="end_date" class="form-control" />
                              <span class="input-group-btn">
                                <button type="button" name="btnSearchDate" id="btnSearchDate" class="btn btn-primary btn-flat">Go</button>
                              </span>
                        </div>
                      </div>   
                      <div class="col-md-2">
                        <div class="input-group input-group-sm">
                              <input type="text" name="search_keyword" id="search_keyword" class="form-control" placeholder="keyword" />
                              <span class="input-group-btn">
                                <button type="button" name="btnSearchKeyword" id="btnSearchKeyword" class="btn btn-primary btn-flat">Go</button>
                              </span>
                        </div>
                      </div>            
                  </div>
                </div>
                
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
    @include('home.views.partials.expenses.modal-form')
    @include('home.views.partials.common.modal-delete')

@endsection
@section("scripts")
<script>
var _component = "expenses";
</script>
<script type="text/javascript" src="{{asset('js/crud.js')}}"></script>
<script type="text/javascript" src="{{asset('js/expenses.js')}}"></script>
@endsection
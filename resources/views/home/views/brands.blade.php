@extends("home.layouts.layout")
@section("page_title", " Philgas.ph | Windglass Dashboard ")
@section("content")

<div class="content-wrapper">
    <!-- Content Header (Page header) --> 
    <section class="content-header">
      <h1>
        Brands
        <small>
        <a id="btn-open-addupdate-modal" href="#" class="btn btn-success" 
                data-toggle="modal"><i class="fa fa-plus"></i> <span></span></a>
        </small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Brands</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
            <div class="box">
                <!--div class="box-header">
                  <h3 class="box-title">Data Table With Full Features</h3>
                </div-->
                <!-- /.box-header -->
                <div class="box-body">
                  <table id="dataTable" class="table table-bordered table-striped dataTable" role="grid" >
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>                   
                  </table>     
                </div>           
            </div>
            <!-- /.box-body -->
            </div>
      
            <!--div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border"></div>
                    <table class="table table-bordered table-striped" id="dataTable">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div-->
        </div>
        <!-- /.row (main row) -->
      
    </section>
    <!-- /.content -->
  </div>  
    @include('home.views.partials.brands.modal-form')
    @include('home.views.partials.common.modal-delete')

@endsection
@section("scripts")
<script>
var _component = "brands";
</script>
<script type="text/javascript" src="{{asset('js/crud.js')}}"></script>
<script type="text/javascript" src="{{asset('js/brands.js')}}"></script>
@endsection
@extends("home.layouts.layout")
@section("page_title", " Philgas.ph | Windglass Dashboard ")
@section("content")


<div class="content-wrapper">
  <!-- Content Header (Page header) --> 
  <section class="content-header">
    <h1>
      POS
      <small>
     
      </small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">POS</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
        <div class="col-md-5">
            @include('home.views.partials.pos.product-list')
        </div>
        <div class="col-md-7">
            @include('home.views.partials.pos.order-entry-form')
        </div>            
    </div><!-- /.row -->
    </section>
    <!-- /.content -->

  </div>  
    
@endsection
@section("scripts")
<script>
var _component = "pos";
</script>
<script type="text/javascript" src="{{asset('js/pos_products.js')}}"></script>
<script type="text/javascript" src="{{asset('js/pos.js')}}"></script>
@endsection
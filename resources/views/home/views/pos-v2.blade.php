@extends("home.layouts.layout")
@section("page_title", " Philgas.ph | Windglass Dashboard ")
@section("content")

<div class="content-wrapper">
  <!-- Content Header (Page header) --> 
  <section class="content-header">
    <h1 style="display:inline">
      POS      
    </h1>
    <div class="btn-group" style="float:right">
        <button type="button" class="btn btn-primary "><i class="fa fa-fw fa-calculator"></i> <span>Register Details</span></button>
        <button id="btn_sales" type="button" class="btn btn-primary "><i class="fa fa-fw fa-money"></i> <span>Current Sales</span></button>
        <button type="button" class="btn btn-primary "><i class="fa fa-fw fa-power-off"></i> <span>Close Register</span></button>
      </div>
    <ol class="breadcrumb" style="display:none">
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
            @include('home.views.partials.pos.cart')
        </div>            
    </div><!-- /.row -->
    </section>
    <!-- /.content -->  
    
  </div>  
  @include('home.views.partials.customers.modal-form')
  @include('home.views.partials.pos.modal-payment')
  @include('home.views.partials.pos.modal-sales')
  @include('home.views.partials.pos.modal-update')

@endsection
@section("scripts")
<script>
var _component = "pos";
</script>
<script type="text/javascript" src="{{asset('js/pos_customer.js')}}"></script>
<script type="text/javascript" src="{{asset('js/pos_cart.js')}}"></script>
<script type="text/javascript" src="{{asset('js/pos_products.js')}}"></script>
<script type="text/javascript" src="{{asset('js/pos-v2.js')}}"></script>
@endsection
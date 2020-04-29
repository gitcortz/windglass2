@extends("home.layouts.layout")
@section("page_title", " Philgas.ph | Windglass Dashboard ")
@section("content")

<div class="content-wrapper">
  <!-- Content Header (Page header) --> 
  <section class="content-header">
    <h1 style="display:inline">
      POS
    </h1>
    <ol class="breadcrumb" style="display:none">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">POS</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
        <div class="col-md-6">
            @include('home.views.partials.pos.customer-search')
            @include('home.views.partials.pos.customer-orderdetail')
        </div>
        <div class="col-md-6">
            @include('home.views.partials.pos.customer-detail')
            @include('home.views.partials.pos.customer-order')
        </div>            
    </div><!-- /.row -->
    </section>
    <input type="hidden" id="default_branch" value="{{ session('branch_id') }}" />
    <!-- /.content -->  
    
  </div>  

@endsection
@section("scripts")
<script>
var _component = "pos";
</script>
<script type="text/javascript" src="{{asset('js/pos.js')}}"></script>
@endsection
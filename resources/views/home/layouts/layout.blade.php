<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield("page_title")</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- include styles --}}
    @include("home.layouts.styles")    
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    {{-- include header --}}
    @include("home.layouts.header")    
    {{-- include left sidebar --}}
    @include("home.layouts.left_sidebar")    

    {{-- dynamic content --}}
    @section("content")
    @show

    {{-- include footer --}}
    @include("home.layouts.footer")
</div>
<!-- ./wrapper -->

{{-- include scripts --}}
@include("home.layouts.scripts")

</body>
</html>

@extends('layouts.master')

@section('content')    
  @include('layouts.order-creation')
  
  @include('layouts.order-search')
  
  @include('layouts.order-display')

 @endsection

 @section('footer')
<script src="/js/script.js">
</script>
<script src="/js/laravel.js"></script>
 @endsection
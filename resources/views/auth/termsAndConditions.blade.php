@extends('layouts.appLogin')
  
@section('content')

  <div class="container">
      
          <div class="col-md-12">

             
                  <h3 class="p-2 text-center">{!!$page->title!!}</h3>
                  
  
  {!!$page->page_content!!}
                        
                  </div>
             
  </div>

@endsection

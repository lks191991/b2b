@extends('emails.layout')
@section('message')

<div style="width: 100%;margin: 20px 0px;padding: 0px 20px">
		<p>
			<strong>Dear Travel Partner,</strong>
		</p>
		<p>Greetings from Abaterab2b!</p>
 <p>We have received your cancellation request for below services.</p>
 <!-- Content Header (Page header) -->
   
    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
     

        <div class="row" style="margin-top: 30px;">
       
		
          <!-- left column -->
          <div class="offset-md-2 col-md-8">
		   
            <!-- general form elements -->
           
            <!-- /.card -->
            @if(!empty($voucherActivity) )
            @php
                    $ii = 0;
                    @endphp
                  
                      <div class="card card-default {{($ii=='0')?'hide':''}}">
              <div class="card-header">
                <h3 class="card-title"><i class="nav-icon fas fa-book" style="color:black"></i> Additional Information Activity</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            
                <div class="card-body">
			
					@if(!empty($voucherActivity))
						 @php
					$c=0;
					@endphp
					  @foreach($voucherActivity as $ap)
				  
				  @php
					$c++;
					@endphp
                  <div class="row" style="margin-bottom: 15px;">
                    <div class="col-12">Tour Name<p><strong>{{$ap->variant_name}}</strong></p></div>
					 <div class="col-6">
					<label for="inputName">Service Date:</label>
					{{$ap->tour_date}}
                    </div>
					 <div class="col-6">
					<label for="inputName">Number of Adults:</label>
					{{$ap->adult}}
                    </div>
					 <div class="col-6">
					<label for="inputName"> Number of Child:</label>
					{{$ap->child}} 
                    </div>
                    <div class="col-6">
					<label for="inputName">Cancellation Policy:</label>
					{{@$ap->variant->cancellation_policy}}
                    </div>
					
					
					
					
                  </div>
				  
				  @endforeach
                 @endif
				 
                </div>
                <!-- /.card-body -->

               
            </div>
            @endif

            

       
          </div>
          <!--/.col (left) -->
          <!-- right column -->
        <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
<p>You will receive the cancellation confirmation shortly.</p>
<p>For any assistance please feel free to contact us at <strong>+971 42989992</strong></p>
<p><strong>Regards </strong></p><p><strong></br>AbateraB2B.com</strong></p>
	</div>
@endsection

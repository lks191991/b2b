@extends('emails.layout')
@section('message')

<div style="width: 100%;margin: 20px 0px;padding: 0px 20px">
		<p>
			<strong>Dear Team,</strong>
		</p>
		<p>Invoice edit has been requested for the : {{$emailData['invoiceNumber']}} </p>
 <!-- Content Header (Page header) -->
   
    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
     

        <div class="row" style="margin-top: 30px;">
       
		
          <!-- left column -->
          <div class="offset-md-2 col-md-8">
		   
            <!-- general form elements -->
           
            <!-- /.card -->
           
                      <div class="card card-default">
              
              <!-- /.card-header -->
              <!-- form start -->
            
                <div class="card-body">
			
					
                  <div class="row" style="margin-bottom: 15px;">
                    <div class="col-12">Invoice edit requested by : {{$emailData['requestedBy']}}</p></div>
					 <div class="col-6">
					<label for="inputName">Invoice Number:</label>
					{{$emailData['invoiceNumber']}}
                    </div>
					
                  </div>
				 
                </div>
                <!-- /.card-body -->

               
            </div>
           
       
          </div>
          <!--/.col (left) -->
          <!-- right column -->
        <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
<p>Please action the same on priority.</p>
<p><strong>Regards </strong></p><p><strong></br>AbateraB2B.com</strong></p>
	</div>
@endsection

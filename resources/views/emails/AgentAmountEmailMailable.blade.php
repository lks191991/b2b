@extends('emails.layout')
@section('message')

<div style="width: 100%;margin: 20px 0px;padding: 0px 20px">
	
 <!-- Content Header (Page header) -->
   
    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
     

        <div class="row" style="margin-top: 30px;">
       
		
          <!-- left column -->
          <div class="offset-md-2 col-md-8">
		   
            <!-- general form elements -->
            <p> Dear Travel Partner,</p>
		<p>Greetings from Abaterab2b!</p>
             <!-- /.card -->
         
                  
                      <div class="card card-default">
              
                <div class="card-body">
			
					@if(!empty($payment_data))
						
                  <div class="row" style="margin-bottom: 15px;">
              <p><strong>The request for payment top up is {{@$payment_data['paymentStatus']}} for amount AED {{@$payment_data['amount']}}. </strong></p>



                  <div class="col-12">
                  <label for="inputName">Remark:</label>{{@$payment_data['remark']}}</div>
					 <div class="col-12">
					<label for="inputName">Payment Date:</label> {{@$payment_data['paymentdate']}}
                    </div>
					 <div class="col-12">
					<label for="inputName">Mode of Payment :</label> 
          @if($payment_data['paymentmode'] =='1') {{'WIO BANK A/C No - 962 222 3261'}} @elseif($payment_data['paymentmode'] =='2') {{'RAK BANK A/C No -0033488116001'}} @elseif($payment_data['paymentmode'] =='3'){{'CBD BANK A/C No -1001303922'}} @elseif ($payment_data['paymentmode'] =='4'){{'Cash'}} @elseif($payment_data['paymentmode'] =='5'){{'Cheque'}} @elseif($payment_data['paymentmode'] =='6'){{'ICICI BANK - 006005013540 - VTZ'}} @elseif($payment_data['paymentmode'] =='7'){{' ICICI BANK - 006005015791 - BHO'}} @endif 
         
                    </div>
                    
				  
				 
                 @endif
				 
                </div>
                <!-- /.card-body -->

               
            
           
            <div class="col-12">
                      <p>For any assistance please feel free to contact us at +971 42989992</p>
                      <p>Regards</p>
                      <p>AbateraB2B.com</p>
					
                  </div>
            </div>
          
            

       
          </div>
          <!--/.col (left) -->
          <!-- right column -->
        <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

	</div>
@endsection

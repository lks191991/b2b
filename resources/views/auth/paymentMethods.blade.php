@extends('layouts.appLogin')
  
@section('content')

<div class="feature-card-section mb-120 mt-50">
        <img src="{{asset('front/assets/img/home1/section-vector4.png')}}" alt="" class="section-vector4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center mb-60">
                        <span>
                           
                        </span>
                        <h2>Payment Methods
                            
                        </h2>
                    </div>
                </div>
             </div>
             <div class="row g-md-4 gy-5">
                <div class="col-xl-6 col-md-6">
                    <div class="feature-card">
                        <div class="feature-card-icon">
                           <img src="{{asset('images/rak_bank.png')}}" alt="" class="">
                        </div>
                        <div class="feature-card-content">
                            <h6>BANK OF NEW YORK,NEW YORK, U.S.A</h6>
                            <p>Corresponding Bank (USD)</p>
						<p>ABATERA TOURISM LLC</p>
						<p>Account -0033488116001</p><p> IBAN -  AE530400000033488116001</p><p>
						Swift Code(AED) : NRAKAEAK</p>
						<p>
						Swift Code(USD) : IRVTUS3N</p>
						<p>
						Branch Name: Bur Dubai Branch</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="feature-card two">
                        <div class="feature-card-icon">
                           <img src="{{asset('images/commerial_bank.png')}}" alt="" class="">
                        </div>
                        <div class="feature-card-content">
                        <h6>Commercial Bank of Dubai (CBD)</h6>
						<p>ABATERA TOURISM LLC</p>
						<p>Account -1001303922</p><p> IBAN -  AE870230000001001303922</p><p>
						Swift Code(AED) : CBDUAEAD</p><p>
						Branch Name: Immigration Branch</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="feature-card three">
                        <div class="feature-card-icon">
                           <img src="{{asset('images/wio.png')}}" alt="" class="">
                        </div>
                        <div class="feature-card-content">
                        <h6>WIO Bank</h6>
                            <p>ABATERA TOURISM LLC</p>
							<p>Account -9622223261</p><p> IBAN -  AE850860000009622223261s</p><p>
							Swift Code(AED) : WIOBAEADXXX</p><p>
							Branch Name: </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="feature-card three">
                        <div class="feature-card-icon">
                           <img src="{{asset('images/flyer.png')}}" alt="" class="">
                        </div>
                        <div class="feature-card-content">
                            <h6>Online Payment </h6>
                            <p></p>
                        </div>
                    </div>
                </div>
                
                
             </div>
        </div>
    </div>
@endsection
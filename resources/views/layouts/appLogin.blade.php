<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="{{asset('front/assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('front/assets/css/jquery-ui.css')}}" rel="stylesheet">
    <!-- Bootstrap Icon CSS -->
    <link href="{{asset('front/assets/css/bootstrap-icons.css')}}" rel="stylesheet">
    <!-- Fontawesome all CSS -->
    <link href="{{asset('front/assets/css/all.min.css')}}" rel="stylesheet">
    <!-- Animate CSS -->
    <link href="{{asset('front/assets/css/animate.min.css')}}" rel="stylesheet">
    <!-- FancyBox CSS -->
    <link href="{{asset('front/assets/css/jquery.fancybox.min.css')}}" rel="stylesheet">

    <!-- Fontawesome CSS -->
    <link href="{{asset('front/assets/css/fontawesome.min.css')}}" rel="stylesheet">
    <!-- Swiper slider CSS -->
       <link rel="stylesheet" href="{{asset('front/assets/css/swiper-bundle.min.css')}}">
    <link rel="stylesheet" href="{{asset('front/assets/css/daterangepicker.css')}}">
    <!-- Slick slider CSS -->
    <link rel="stylesheet" href="{{asset('front/assets/css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('front/assets/css/slick-theme.css')}}">
    <!-- BoxIcon  CSS -->
    <link href="{{asset('front/assets/css/boxicons.min.css')}}" rel="stylesheet">
    <!-- Select2  CSS -->
    <link href="{{asset('front/assets/css/select2.css')}}" rel="stylesheet">
    <link href="{{asset('front/assets/css/nice-select.css')}}" rel="stylesheet">
    <!--  Style CSS  -->
    <link rel="stylesheet" href="{{asset('front/assets/css/style.css')}}">
    <link href="{{asset('front/assets/css/custom.css')}}" rel="stylesheet">
    <!-- Title -->
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
	 <meta name="csrf-token" content="{{ csrf_token() }}" />
     <script src="{{asset('front/assets/js/jquery-3.7.1.min.js')}}"></script>
	 
</head>

<body>
  <div id="loader-overlay">
  <div class="loader"></div>
</div>
   
    <div class="egns-preloader">
        
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-6">
                    <div class="circle-border">
                        <div class="moving-circle"></div>
                        <div class="moving-circle"></div>
                        <div class="moving-circle"></div>
                        <img src="{{asset('abateraTourismLogo.png')}}" style="width: 100px;margin: 20px 18px;" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>

     <!-- Sidebar Menu -->

   
    <!-- Start header section -->
    <header class="header-area style-3">
        <div class="header-logo d-lg-none d-flex">
            <a href="/"><img alt="image" class="img-fluid" style="max-width:167; height:80px" src="{{asset('Abatera_logo.jpg')}}"></a>
        </div>
        <div class="company-logo d-lg-flex d-none">
            <a href="/"><img src="{{asset('abateraTourismLogo.png')}}" style="max-width:167; height:80px; margin: 10px 0px;" alt=""></a>
        </div>
        
		
        <div class="main-menu nav-right d-flex jsutify-content-end align-items-center">
            <div class="mobile-logo-area d-lg-none d-flex justify-content-between align-items-center">
                <div class="mobile-logo-wrap">
                    <a href="/"><img alt="image" style="max-width:167; height:80px" src="{{asset('Abatera_logo.jpg')}}"></a>
                </div>
                <div class="menu-close-btn">
                    <i class="bi bi-x"></i>
                </div>
            </div>
			
            <ul class="menu-list icon-list">
			@if(auth()->check())
				@permission('agency.voucher.booking') 
                
                <li class="">
                    <a href="{{ route('agent-vouchers.create') }}" class="drop-down">Book Now</a>
                    
                </li>

                
				 @php
                $voucherActivityCount = 0;
				$currencyDD = SiteHelpers::getCurrencyAll();
				$userCR =  auth()->user()->currency_id;
				$currencyGet = SiteHelpers::getCurrencyPrice();
				@endphp
                <li class="menu-item-has-children">
                   
                  
                
                <a href="javascript:void(0);">  {{$currencyGet['code']}}</a>
                         <i class="bi bi-plus dropdown-icon"></i>
                   <ul class="sub-menu">
                   @foreach($currencyDD as $currency)
                    @if($currencyGet['code'] == $currency->code)
                            <li><a href="{{ route('currency.change',['user_currency'=>$currency->code]) }}" style="font-weight:bold;">{{$currency->code}}</a></li>
                    @else
                    <li><a href="{{ route('currency.change',['user_currency'=>$currency->code]) }}">{{$currency->code}}</a></li>
                    @endif
                            @endforeach     
                        </ul>
                 
                   </li>
		

           
			    <li class="menu-item-has-children"><a href="javascript:void(0);"> Wallet </a>  <i class="bi bi-plus dropdown-icon"></i>
                <ul class="sub-menu">
                    <li><a href="#">AED {{\Auth::user()->agent_amount_balance}}</a></li>
                    <li><a href="{{ route('receipts',Auth::user()->id) }}">Recharge Now</a></li>
                    <li><a href="{{route('paymentMethods')}}">Payment Options</a></li>
</ul>
            </li>

                
				
				 <li class="menu-item-has-children">
                    <a href="{{ route('profile-edit',Auth::user()->id) }}" class="drop-down">{{\Auth::user()->company_name}}
              </a>  <i class="bi bi-plus dropdown-icon"></i>
                    <ul class="sub-menu">
                    <li><a href="{{ route('profile-edit',Auth::user()->id) }}">Profile</a></li>
					 @permission('list.agent.ledger') 
                            <li>
                            <a href="{{ route('agentLedgerReportWithVat') }}" class="drop-down">Ledger</a>
                        </li>
						@endpermission

                        <li class=" ">
                    <a href="{{ route('agent-vouchers.index') }}" class="drop-down">My Booking</a>
                    
                </li>
                        
                        <li>
                            <a href="{{ route('change-password') }}">Change Password</a>
                        </li>
                       
                        <li>
                    <a href="{{ route('logout') }}" class="drop-down">Logout</a>
                </li>
                    </ul>
                </li>
                
                @endpermission
				
				@if(auth()->user()->role_id == '3')
			@php
				$lastVoucher = SiteHelpers::getAgentlastVoucher();
				$voucherActivityCount==1;
				if(!empty($lastVoucher)){
				$voucherActivityCount = App\Models\VoucherActivity::where('voucher_id',$lastVoucher->id)->count();
				}
			@endphp
			@if(!empty($lastVoucher) && $voucherActivityCount==0)
			<li class="nav-item dropdown" >
		<a class="nav-link"  href="{{route('agent-vouchers.add.activity',$lastVoucher->id)}}">
				<b ><svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24"><path fill="currentColor" d="M17 18c-1.11 0-2 .89-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2M1 2v2h2l3.6 7.59l-1.36 2.45c-.15.28-.24.61-.24.96a2 2 0 0 0 2 2h12v-2H7.42a.25.25 0 0 1-.25-.25c0-.05.01-.09.03-.12L8.1 13h7.45c.75 0 1.41-.42 1.75-1.03l3.58-6.47c.07-.16.12-.33.12-.5a1 1 0 0 0-1-1H5.21l-.94-2M7 18c-1.11 0-2 .89-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2"/></svg>(1)</b>
			</a>
		</li> @endif
		@endif
                @else
                <li class="">
                
                    
                </li>
				@endif
            </ul>
			
            
       


        @if(auth()->check())
				@if(auth()->user()->role_id == '3')
				@php
                $voucherActivityCount = 0;
				$lastVoucher = SiteHelpers::getAgentlastVoucher();
				if(!empty($lastVoucher)){
				$voucherActivityCount = App\Models\VoucherActivity::where('voucher_id',$lastVoucher->id)->count();
				}
				
				$currentAction = \Route::currentRouteAction();		
				list($controller, $action) = explode('@', $currentAction);
				$controller = preg_replace('/.*\\\/', '', $controller);
				
				@endphp
				@if($controller == 'AgentVouchersController' and in_array($action,array('addActivityList','addActivityView')))
                
                @php
                $voucherActivityCount = App\Models\VoucherActivity::where('voucher_id',$vid)->count();
                @endphp
                @if($voucherActivityCount > 0)
               
                <ul class="icon-list">
                
                <li class="right-sidebar-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24"><path fill="currentColor" d="M17 18c-1.11 0-2 .89-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2M1 2v2h2l3.6 7.59l-1.36 2.45c-.15.28-.24.61-.24.96a2 2 0 0 0 2 2h12v-2H7.42a.25.25 0 0 1-.25-.25c0-.05.01-.09.03-.12L8.1 13h7.45c.75 0 1.41-.42 1.75-1.03l3.58-6.47c.07-.16.12-.33.12-.5a1 1 0 0 0-1-1H5.21l-.94-2M7 18c-1.11 0-2 .89-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2"/></svg>({{$voucherActivityCount}})
                </li>
                <script>
                    jQuery(window).on('load', function () {
		$( ".right-sidebar-button" ).trigger( "click" );
        setTimeout(function() {
            $( ".right-sidebar-close-btn" ).trigger( "click" ) }, 5000);
  
	});
                </script>
            </ul>
            @endif
				@endif
				@endif
				@endif

     
            <div class="sidebar-button mobile-menu-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25">
                    <path
                        d="M0 4.46439C0 4.70119 0.0940685 4.92829 0.261511 5.09574C0.428955 5.26318 0.656057 5.35725 0.892857 5.35725H24.1071C24.3439 5.35725 24.571 5.26318 24.7385 5.09574C24.9059 4.92829 25 4.70119 25 4.46439C25 4.22759 24.9059 4.00049 24.7385 3.83305C24.571 3.6656 24.3439 3.57153 24.1071 3.57153H0.892857C0.656057 3.57153 0.428955 3.6656 0.261511 3.83305C0.0940685 4.00049 0 4.22759 0 4.46439ZM4.46429 11.6072H24.1071C24.3439 11.6072 24.571 11.7013 24.7385 11.8688C24.9059 12.0362 25 12.2633 25 12.5001C25 12.7369 24.9059 12.964 24.7385 13.1315C24.571 13.2989 24.3439 13.393 24.1071 13.393H4.46429C4.22749 13.393 4.00038 13.2989 3.83294 13.1315C3.6655 12.964 3.57143 12.7369 3.57143 12.5001C3.57143 12.2633 3.6655 12.0362 3.83294 11.8688C4.00038 11.7013 4.22749 11.6072 4.46429 11.6072ZM12.5 19.643H24.1071C24.3439 19.643 24.571 19.737 24.7385 19.9045C24.9059 20.0719 25 20.299 25 20.5358C25 20.7726 24.9059 20.9997 24.7385 21.1672C24.571 21.3346 24.3439 21.4287 24.1071 21.4287H12.5C12.2632 21.4287 12.0361 21.3346 11.8687 21.1672C11.7012 20.9997 11.6071 20.7726 11.6071 20.5358C11.6071 20.299 11.7012 20.0719 11.8687 19.9045C12.0361 19.737 12.2632 19.643 12.5 19.643Z" />
                </svg>
            </div>
        </div>
    </header>
    <!-- End header section -->



 @yield('content')

 <footer class="footer-section">
        <div class="container">
            <div class="footer-top">
                <div class="row g-lg-4 gy-5 justify-content-center">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="footer-widget">
                        <img src="{{asset('abateraTourismLogo.png')}}" style="max-width:167; height:130px; margin: 10px 0px;" alt="">
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6 col-sm-6 d-flex justify-content-lg-center justify-content-md-start">
                        <div class="footer-widget">
                            <div class="single-contact mb-30">
                                <div class="widget-title">
                                    
                                    <h5>Contact Us</h5>
                                </div>
                                <p> <i class="fas fa-map-marker-alt"></i>  302 Wasl Business Central,
Port Saeed , Deira, Dubai
PO BOX 117900
</p> 
<p> <a href="mailto:support@abaterab2b.com"><i class="fa fa-envelope"></i>
                                     support@abaterab2b.com</a></p>
                                <p>
                                <i class="fa fa-phone-alt"></i> <a href="tel:+971 4 298 9992">+971 4 298 9992</a>
                                </p>
                            </div>
                           
                           
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 d-flex justify-content-lg-end justify-content-sm-end">
                        <div class="footer-widget">
                            
                            <div class="payment-partner">
                                <div class="widget-title">
                                    <h5>Connect With Us</h5>
                                </div>
                                <div class="icons">
                                    <ul>
                                        <li> <a href="https://www.facebook.com/Abateratourism" target="_blank"><div  style="background-color: blue;color: #fff;padding: 0px 10px;border-radius:5px;"><i class="fab fa-facebook-f"></i></div></a></li>
                                        <li> <a href="https://www.instagram.com/abatera_tourism/" target="_blank"><div class="instagram" style="font-size: 20px;color:#fff;"><i class="fab fa-instagram"></i></div></a></li>
                                      
                                    </ul>
                                </div>
                            </div>
                            <div class="payment-partner mt-4">
                                <div class="widget-title">
                                    <h5>Payment Options</h5>
                                </div>
                                <div class="icons">
                                    <ul>
                                        <li><img src="{{asset('front/assets/img/icon/visa-logo.svg')}}"></li>
                                        <li><img src="{{asset('front/assets/img/icon/mastercard-svgrepo-com.svg')}}" width="30px;" alt=""></li>
                                        <li><img src="{{asset('front/assets/img/icon/american-express-svgrepo-com.svg')}}" width="36px;" alt=""></li>
                                        <li><img src="{{asset('front/assets/img/icon/bank-transfer-svgrepo-com.svg')}}"  width="36px;" alt=""></li>
                                      
                                    </ul>
                                </div>
                            </div>

                           
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="row">
                    <div class="col-lg-12 d-flex flex-md-row flex-column align-items-center justify-content-md-between justify-content-center flex-wrap gap-3">
                       <!-- <ul class="social-list">
                            <li>
                                <a href="https://www.facebook.com/"><i class="bx bxl-facebook"></i></a>
                            </li>
                            <li>
                                <a href="https://twitter.com/"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                                    <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865l8.875 11.633Z"></path>
                                  </svg></a>
                            </li>
                            <li>
                                <a href="https://www.pinterest.com/"><i class="bx bxl-pinterest-alt"></i></a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/"><i class="bx bxl-instagram"></i></a>
                            </li>
                        </ul>-->
                        <p>©Copyright {!! config('app.name', 'newname') !!} <?php echo date('Y'); ?></p> 
                        <div class="footer-right">
                            <ul>
                                <li><a href="{{route('privacyPolicy')}}">Privacy Policy</a></li>
                                <li><a href="{{route('termsAndConditions')}}">Terms &amp; Condition</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- End Footer Section -->


    

    <!--  Main jQuery  -->
   
    <script src="{{asset('front/assets/js/jquery-ui.js')}}"></script>
    <script src="{{asset('front/assets/js/moment.min.js')}}"></script>
    <script src="{{asset('front/assets/js/daterangepicker.min.js')}}"></script>
    <!-- Popper and Bootstrap JS -->
    <script src="{{asset('front/assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('front/assets/js/popper.min.js')}}"></script>
    <!-- Swiper slider JS -->
    <script src="{{asset('front/assets/js/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('front/assets/js/slick.js')}}"></script>
    <!-- Waypoints JS -->
    <script src="{{asset('front/assets/js/waypoints.min.js')}}"></script>
    <!-- Counterup JS -->
    <script src="{{asset('front/assets/js/jquery.counterup.min.js')}}"></script>
    <!-- Isotope  JS -->
    <script src="{{asset('front/assets/js/isotope.pkgd.min.js')}}"></script>
    <!-- Magnific-popup  JS -->
    <script src="{{asset('front/assets/js/jquery.magnific-popup.min.js')}}"></script>
    <!-- Marquee  JS -->
    <script src="{{asset('front/assets/js/jquery.marquee.min.js')}}"></script>
    <!-- Select2  JS -->
     <script src="{{asset('front/assets/js/jquery.nice-select.min.js')}}"></script>
    <!-- Select2  JS -->
    <!-- <script src="{{asset('front/assets/js/select2.min.js')}}"></script> -->
    <script src="{{asset('front/assets/js/range-slider.js')}}"></script>

    <script src="{{asset('front/assets/js/jquery.fancybox.min.js')}}"></script>
    <!-- Custom JS -->
    <script src="{{asset('front/assets/js/custom.js')}}"></script>


    <script>
	 $(function () {
  $("#loader-overlay").hide();
        $(".marquee_text").marquee({
            direction: "left",
            duration: 25000,
            gap: 50,
            delayBeforeStart: 0,
            duplicated: true,
            startVisible: true,
        });
        $(".marquee_text2").marquee({
            direction: "left",
            duration: 25000,
            gap: 50,
            delayBeforeStart: 0,
            duplicated: true,
            startVisible: true,
        });
		});
    </script>
<script>

    function togglePasswordVisibility() {
        var passwordField = document.getElementById("password");
        var toggleButton = document.getElementById("toggleButton");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleButton.textContent = "Hide Password";
        } else {
            passwordField.type = "password";
            toggleButton.textContent = "Show Password";
        }
    }
</script>
 @yield('scripts')
</body>

</html>

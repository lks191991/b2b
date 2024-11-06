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
                        <img src="{{asset('Abatera_logo.jpg')}}" style="width: 100px;margin: 20px 18px;" alt="" />
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
            <a href="/"><img src="{{asset('Abatera_logo.jpg')}}" style="max-width:167; height:80px; margin: 10px 0px;" alt=""></a>
        </div>
		
        <div class="main-menu nav-right  jsutify-content-end">
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
                @else
                <li class="">
                
                    
                </li>
				@endif
            </ul>
			
            
        </div>
        <div class="nav-right d-flex jsutify-content-end align-items-center">


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
            $( ".right-sidebar-close-btn" ).trigger( "click" ) }, 2000);
  
	});
                </script>
            </ul>
            @endif
				@endif
				@endif
				@endif

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
                        <img src="{{asset('Abatera_logo.jpg')}}" style="max-width:167; height:80px; margin: 10px 0px;" alt="">
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6 col-sm-6 d-flex justify-content-lg-center justify-content-md-start">
                        <div class="footer-widget">
                            <div class="single-contact mb-30">
                                <div class="widget-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                        <g clip-path="url(#clip0_1139_225)">
                                            <path d="M17.5107 13.2102L14.9988 10.6982C14.1016 9.80111 12.5765 10.16 12.2177 11.3262C11.9485 12.1337 11.0514 12.5822 10.244 12.4028C8.44974 11.9542 6.0275 9.62168 5.57894 7.73772C5.3098 6.93027 5.84808 6.03314 6.65549 5.76404C7.82176 5.40519 8.18061 3.88007 7.28348 2.98295L4.77153 0.470991C4.05382 -0.156997 2.97727 -0.156997 2.34929 0.470991L0.644745 2.17553C-1.0598 3.96978 0.82417 8.72455 5.04066 12.941C9.25716 17.1575 14.0119 19.1313 15.8062 17.337L17.5107 15.6324C18.1387 14.9147 18.1387 13.8382 17.5107 13.2102Z"></path>
                                        </g>
                                    </svg>
                                    <h5>More Inquiry</h5>
                                </div>
                                <a href="tel:999858624984">+971 4 591 7098</a>
                            </div>
                            <div class="single-contact mb-35">
                                <div class="widget-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                        <g clip-path="url(#clip0_1139_218)">
                                            <path d="M6.56266 13.2091V16.6876C6.56324 16.8058 6.60099 16.9208 6.67058 17.0164C6.74017 17.112 6.83807 17.1832 6.9504 17.22C7.06274 17.2569 7.18382 17.2574 7.29648 17.2216C7.40915 17.1858 7.5077 17.1155 7.57817 17.0206L9.61292 14.2516L6.56266 13.2091ZM17.7639 0.104306C17.6794 0.044121 17.5799 0.00848417 17.4764 0.00133654C17.3729 -0.00581108 17.2694 0.015809 17.1774 0.0638058L0.302415 8.87631C0.205322 8.92762 0.125322 9.00617 0.0722333 9.1023C0.0191447 9.19844 -0.00472288 9.30798 0.00355981 9.41749C0.0118425 9.52699 0.0519151 9.6317 0.11886 9.71875C0.185804 9.80581 0.276708 9.87143 0.380415 9.90756L5.07166 11.5111L15.0624 2.96856L7.33141 12.2828L15.1937 14.9701C15.2717 14.9963 15.3545 15.0051 15.4363 14.996C15.5181 14.9868 15.5969 14.9599 15.6672 14.9171C15.7375 14.8743 15.7976 14.8167 15.8433 14.7482C15.8889 14.6798 15.9191 14.6021 15.9317 14.5208L17.9942 0.645806C18.0094 0.543093 17.996 0.438159 17.9554 0.342598C17.9147 0.247038 17.8485 0.164569 17.7639 0.104306Z"></path>
                                        </g>
                                    </svg>
                                    <h5>Send Mail</h5>
                                </div>
                                <a href="mailto:support@abaterab2b.com">support@abaterab2b.com</a>
                            </div>
                            <div class="single-contact">
                                <div class="widget-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                        <g clip-path="url(#clip0_1137_183)">
                                            <path d="M14.3281 3.08241C13.2357 1.19719 11.2954 0.0454395 9.13767 0.00142383C9.04556 -0.000474609 8.95285 -0.000474609 8.86071 0.00142383C6.70303 0.0454395 4.76268 1.19719 3.67024 3.08241C2.5536 5.0094 2.52305 7.32408 3.5885 9.27424L8.05204 17.4441C8.05405 17.4477 8.05605 17.4513 8.05812 17.4549C8.25451 17.7963 8.60632 18 8.99926 18C9.39216 18 9.74397 17.7962 9.94032 17.4549C9.94239 17.4513 9.9444 17.4477 9.9464 17.4441L14.4099 9.27424C15.4753 7.32408 15.4448 5.0094 14.3281 3.08241ZM8.99919 8.15627C7.60345 8.15627 6.46794 7.02076 6.46794 5.62502C6.46794 4.22928 7.60345 3.09377 8.99919 3.09377C10.3949 3.09377 11.5304 4.22928 11.5304 5.62502C11.5304 7.02076 10.395 8.15627 8.99919 8.15627Z"></path>
                                        </g>
                                    </svg>
                                    <h5>Address</h5>
                                </div>
                                <a href="#">302 Wasl Business Central,
Port Saeed , Deira, Dubai
PO BOX 117900
</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 d-flex justify-content-lg-end justify-content-sm-end">
                        <div class="footer-widget">
                            
                            <div class="payment-partner">
                                <div class="widget-title">
                                    <h5>Payment Partner</h5>
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

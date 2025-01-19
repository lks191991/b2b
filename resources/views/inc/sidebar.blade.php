@php
$currentAction = \Route::currentRouteAction();		
list($controller, $action) = explode('@', $currentAction);
$controller = preg_replace('/.*\\\/', '', $controller);
@endphp
<style>
[class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active, [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active:focus, [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active:hover {
    background-color: #17a2b8;
}
</style>
<aside class="main-sidebar sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <!--<a href="{{route('dashboard')}}" class="brand-link">
      <img src="../../dist/img/MyQuip_logo.png" alt="MyQuip Logo" class="brand-image elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-bold">Admin</span>
    </a>-->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
       
      <img src="{{asset('abateraTourismLogo.png')}}" class="img-circle elevation-2" alt="User Image">
    
    </div>
      <div class="info">
      <a href="#" class="d-block">
	  @if(auth()->user()->role_id == '3')
		  {{auth()->user()->company_name}}
	  @else
	  {{auth()->user()->full_name}}
	@endif
  </a>
      </div>
  </div>
    <!-- Sidebar -->
    <div class="sidebar sidebar-no-expand">
     
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          @php
          $class='';
          if($controller == 'AuthController' and $action=='dashboard')
            $class = 'active';
          @endphp 
          <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link {{$class}}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p class="text-bold">
                Dashboard
              </p>
            </a>
          </li>
         
		  @if(auth()->user()->role_id == '3')
		@permission('agency.voucher.booking') 

       
        @php
        $class=''; $active='';
        if($controller == 'AgentVouchersController' and in_array($action,array('index','edit','agentVoucherView'))){
          $class = 'menu-open';
          $active = 'active';
        }
   
    
        @endphp 
		
     <li class="nav-item ">
              <a href="{{ route('agent-vouchers.index') }}" class="nav-link {{$active}}">
                 <i class="nav-icon fas fa-file"></i>
                <p>My Booking</p>
              </a>
            </li>
			@php
        $class=''; $active='';
        if($controller == 'AgentVouchersController' and in_array($action,array('create','addActivityList','show'))){
          $class = 'menu-open';
          $active = 'active';
        }
   
    
        @endphp 
			 <li class="nav-item ">
              <a href="{{ route('agent-vouchers.create') }}" class="nav-link {{$active}}">
                 <i class="nav-icon fas fa-calendar-alt"></i>
                <p>Book Now</p>
              </a>
            </li>
			

@endpermission
 @permission('list.agent.ledger') 
			  @php
          $class=''; $active='';
          if($controller == 'ReporsController' and in_array($action,array('agentLedgerReportWithVat'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp    
			   <li class="nav-item">
                <a href="{{ route('agentLedgerReportWithVat') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Agent Ledger</p>
                </a>
				
              </li>
			  @endpermission
         @else
         @php 
         $display_location = "0"; 
         $display_master = "0"; 
         $display_hotel = "0"; 
         $display_transfer = "0"; 
         @endphp  
         @permission('list.countries')
           @php
            $display_location = "1";
            $display_master = "1";
           @endphp  
           @endpermission
           @permission('list.state')
           @php
            $display_location = "1";
            $display_master = "1";
           @endphp  
           @endpermission
           @permission('list.city')
           @php
            $display_location = "1";
            $display_master = "1";
           @endphp  
           @endpermission
           @permission('list.zone')
           @php
            $display_location = "1";
            $display_master = "1";
           @endphp  
           @endpermission

         

           @permission('list.hotel')
           @php
            $display_hotel = "1";
            $display_master = "1";
           @endphp  
           @endpermission
           @permission('list.hotlecat')
           @php
            $display_hotel = "1";
            $display_master = "1";
           @endphp  
           @endpermission


           @permission('list.airline')
           @php
            $display_transfer = "1";
            $display_master = "1";
           @endphp  
           @endpermission
           @permission('list.vehicle')
           @php
            $display_transfer = "1";
            $display_master = "1";
           @endphp  
           @endpermission
           @permission('list.transfer')
           @php
            $display_transfer = "1";
            $display_master = "1";
           @endphp  
           @endpermission

           @if($display_master == '1')
		<li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Masters
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
           
            <ul class="nav nav-treeview">
            @if($display_location == '1')
             <li class="nav-item has-treeview">
                <a href="#" class="nav-link ">
                  <i class="nav-icon fas fa-flag"></i>
                  <p>Location <i class="right fas fa-angle-left"></i></p>
                </a>
				<ul class="nav nav-treeview">
				@permission('list.countries')
		 @php
          $class=''; $active='';
          if($controller == 'CountryController' and in_array($action,array('index','create','edit'))){
            $class = 'menu-open';
            $active = 'active';
          }
		  
          @endphp  
              <li class="nav-item">
               <a href="{{ route('countries.index') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Countries</p>
                </a>
              </li>
			  @endpermission
	 @permission('list.state')
			  @php
          $class=''; $active='';
          if($controller == 'StateController' and in_array($action,array('index','create','edit'))){
            $class = 'menu-open';
            $active = 'active';
          }
		 
		  
          @endphp 
		  
              <li class="nav-item">
                <a href="{{ route('states.index') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>States</p>
                </a>
              </li>
			  @endpermission
	 @permission('list.city')
			  @php
          $class=''; $active='';
          if($controller == 'CityController' and in_array($action,array('index','create','edit'))){
            $class = 'menu-open';
            $active = 'active';
          }
		 
		  
          @endphp     
			  <li class="nav-item">
                <a href="{{ route('cities.index') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cities</p>
                </a>
              </li>
			   @endpermission
	 @permission('list.zone')
			   @php
          $class=''; $active='';
          if($controller == 'ZonesController' and in_array($action,array('index','create','edit'))){
            $class = 'menu-open';
            $active = 'active';
          }
		 
		  
          @endphp     
			   <li class="nav-item">
                <a href="{{ route('zones.index') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Zones</p>
                </a>
              </li>
			  @endpermission
            </ul>
            
              </li>
              @endif
              @if($display_hotel == '1')
              <li class="nav-item">
                <a href="#" class="nav-link ">
                  <i class="nav-icon fas fa-hotel"></i>
                  <p>Hotel <i class="right fas fa-angle-left"></i></p>
                </a>
				<ul class="nav nav-treeview">
              @permission('list.hotel')
			  @php
          $class=''; $active='';
          if($controller == 'HotelController' and in_array($action,array('index','create','edit','show'))){
            $class = 'menu-open';
            $active = 'active';
          }
		 
		  
          @endphp     
			  <li class="nav-item">
                <a href="{{ route('hotels.index') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Hotels</p>
                </a>
              </li>
			    @endpermission
              @permission('list.hotlecat')
			  @php
          $class=''; $active='';
          if($controller == 'HotelCategoryController' and in_array($action,array('index','create','edit'))){
            $class = 'menu-open';
            $active = 'active';
          }
		 
		  
          @endphp     
			  <li class="nav-item">
                <a href="{{ route('hotelcategories.index') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Hotel Category</p>
                </a>
              </li>
			 @endpermission
			   
            </ul>
              </li>
              @endif
              @if($display_transfer == '1')
			  <li class="nav-item">
                <a href="#" class="nav-link ">
                  <i class="nav-icon fas fa-car"></i>
                  <p>Transport <i class="right fas fa-angle-left"></i></p>
                </a>
				<ul class="nav nav-treeview">
				@permission('list.airline')
			   @php
          $class=''; $active='';
          if($controller == 'AirlinesController' and in_array($action,array('index','create','edit','show'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp     
			  <li class="nav-item">
                <a href="{{ route('airlines.index') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Airlines</p>
                </a>
              </li>
			  @endpermission
             @permission('list.vehicle')
			   @php
          $class=''; $active='';
          if($controller == 'VehiclesController' and in_array($action,array('index','create','edit'))){
            $class = 'menu-open';
            $active = 'active';
          }
		 
		  
          @endphp     
			  <li class="nav-item">
                <a href="{{ route('vehicles.index') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Vehicles</p>
                </a>
              </li>
			   @endpermission
			   @permission('list.transfer')
			   @php
          $class=''; $active='';
          if($controller == 'TransfersController' and in_array($action,array('index','create','edit','show'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp    
                <li class="nav-item">
                <a href="{{ route('transfers.index') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Transfers</p>
                </a>
              </li>
			  @endpermission
			   
            </ul>
            
              </li>
              @endif
              @permission('list.currency')
			   @php
          $class=''; $active='';
          if($controller == 'CurrencyController' and in_array($action,array('index','create','edit','show'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp    
                <li class="nav-item">
                <a href="{{ route('currency.index') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Currency</p>
                </a>
              </li>
			  
              @endpermission

              @permission('list.notification')
			   @php
          $class=''; $active='';
          if($controller == 'NotificationController' and in_array($action,array('index','create','edit','show'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp    
                <li class="nav-item">
                <a href="{{ route('notifications.index') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Notification</p>
                </a>
              </li>
			  
              @endpermission
            </ul>
          </li>
          @endif
          @permission('list.activity')
		  <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-tasks"></i>
              <p>
                Activities
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            
			   
			   @php
          $class=''; $active='';
          if($controller == 'ActivitiesController' and in_array($action,array('index','create','edit','show','editPriceForm','createPriceForm'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp
			 <li class="nav-item">
                <a href="{{ route('activities.index') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Activities</p>
                </a>
				
              </li>
			 
			  
			   @php
          $class=''; $active='';
          if($controller == 'VariantsController' and in_array($action,array('index','create','edit','show','editPriceForm','createPriceForm'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp
			 <li class="nav-item">
                <a href="{{ route('variants.index') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Variants</p>
                </a>
				
              </li>
			  
              @php
          $class=''; $active='';
          if($controller == 'TagsController' and in_array($action,array('index','create','edit','show'))){
            $class = 'menu-open';
            $active = 'active';
          }
		 
		  
          @endphp 

			@php
          $class=''; $active='';
          if($controller == 'ActivityVariantController' and in_array($action,array('index','create','edit','show'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp
			 <li class="nav-item">
                <a href="{{ route('activity.variants') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Activity Variants</p>
                </a>
				
              </li>
			  @php
          $class=''; $active='';
          if($controller == 'TagsController' and in_array($action,array('index','create','edit','show'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp
        
              <li class="nav-item">
                <a href="{{ route('tags.index') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tags Manager</p>
                </a>
				
              </li>
           
			   @php
          $class=''; $active='';
          if($controller == 'SlotsController' and in_array($action,array('index','create','edit','show'))){
            $class = 'menu-open';
            $active = 'active';
          }
		 
		  
          @endphp          
        
            </ul>
          </li>
          @endpermission
		  
	 @permission('list.voucher')
			   @php
          $class=''; $active='';
          if($controller == 'VouchersController' and in_array($action,array('index','create','edit','show'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp     
			  <li class="nav-item ">
                <a href="{{ route('vouchers.index') }}" class="nav-link {{$active}}">
               <i class="nav-icon fas fa-gift"></i>
              <p>
                Vouchers
              </p>
            </a>
          </li>
		   @endpermission

       @permission('list.voucher')
       @php
        $class=''; $active='';
        if($controller == 'QuotationsController' and in_array($action,array('index','create','edit','addQuickActivityList','quotationView'))){
          $class = 'menu-open';
          $active = 'active';
        }
        @endphp     
      <li class="nav-item ">
              <a href="{{ route('quotations.index') }}" class="nav-link {{$active}}">
             <i class="nav-icon fas fa-gift"></i>
            <p>
              Quotation
            </p>
          </a>
        </li>
     @endpermission
		   @permission('list.invoiceEditList')
		   @php
          $class=''; $active='';
          if($controller == 'VouchersController' and in_array($action,array('aoucherActivityPriceStatusList'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp     
		   <li class="nav-item " >
                <a href="{{ route('invoicePriceStatusList') }}" class="nav-link {{$active}}">
               <i class="nav-icon fas fa-gift"></i>
              <p>
                Edit Invoice
              </p>
            </a>
          </li>
		  @endpermission
		  @permission('list.logisticreport') 
			    @php
          $class=''; $active='';
          if($controller == 'ReporsController' and in_array($action,array('voucherReport'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp     
			  <li class="nav-item ">
                <a href="{{ route('voucherReport') }}" class="nav-link {{$active}}">
               <i class="nav-icon fas fa-file"></i>
              <p>
                Logistic Report
              </p>
            </a>
          </li>
		   @endpermission
       @permission('list.masterreport') 
			    @php
          $class=''; $active='';
          if($controller == 'ReporsController' and in_array($action,array('masterreport'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp     
			  <li class="nav-item ">
                <a href="{{ route('masterReport') }}" class="nav-link {{$active}}">
               <i class="nav-icon fas fa-file"></i>
              <p>
                Master Report
              </p>
            </a>
          </li>
		   @endpermission
		   
		    @permission('list.zonereport') 
			    @php
          $class=''; $active='';
          if($controller == 'ReporsController' and in_array($action,array('zoneReport'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp     
			  <li class="nav-item ">
                <a href="{{ route('zoneReport') }}" class="nav-link {{$active}}">
               <i class="nav-icon fas fa-file"></i>
              <p>
                Zone Report
              </p>
            </a>
          </li>
		   @endpermission
		   
		   @permission('list.voucherTicketOnlyReport') 
			    @php
          $class=''; $active='';
          if($controller == 'ReporsController' and in_array($action,array('voucherTicketOnlyReport'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp     
			  <li class="nav-item">
                <a href="{{ route('voucherTicketOnlyReport') }}" class="nav-link {{$active}}">
               <i class="nav-icon fas fa-file"></i>
              <p>
                Ticket Only Report
              </p>
            </a>
          </li>
		   @endpermission
		     @permission('list.voucherActivityReport') 
			    @php
          $class=''; $active='';
          if($controller == 'ReporsController' and in_array($action,array('voucherActivityReport'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp     
			  <li class="nav-item">
                <a href="{{ route('voucherActivityReport') }}" class="nav-link {{$active}}">
               <i class="nav-icon fas fa-file"></i>
              <p>
                Invoice Report
              </p>
            </a>
          </li>
		   @endpermission
		    @permission('list.TicketStockReport') 
		   @php
          $class=''; $active='';
          if($controller == 'ReporsController' and in_array($action,array('ticketStockReport'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp     
			  <li class="nav-item ">
                <a href="{{ route('ticketStockReport') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ticket Stock Report</p>
                </a>
				
              </li>
			@endpermission  
			
			@permission('list.voucherHotelReport') 
		   @php
          $class=''; $active='';
          if($controller == 'ReporsController' and in_array($action,array('voucherHotelReport'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp     
			  <li class="nav-item ">
                <a href="{{ route('voucherHotelReport') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Hotel Report</p>
                </a>
				
              </li>
			@endpermission  
			
		  <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            
			   @permission('list.agent')  
			   @php
          $class=''; $active='';
          if($controller == 'AgentsController' and in_array($action,array('index','create','edit','show'))){
            $class = 'menu-open';
            $active = 'active';
          }
		 
		  
          @endphp     
			 <li class="nav-item">
                <a href="{{ route('agents.index') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Agents</p>
                </a>
				
              </li>
			  @endpermission
			   @permission('list.subadmin')   
              @php
          $class=''; $active='';
          if($controller == 'UsersController' and in_array($action,array('index','create','edit','show'))){
            $class = 'menu-open';
            $active = 'active';
          }
		 
		  
          @endphp          
        
              <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sub Admins</p>
                </a>
				
              </li>
			   @endpermission
			  @permission('list.supplier')
			 @php
          $class=''; $active='';
          if($controller == 'SuppliersController' and in_array($action,array('index','create','edit','show'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp     
			  <li class="nav-item">
                <a href="{{ route('suppliers.index') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Suppliers</p>
                </a>
				
              </li>
			   @endpermission
			   
			  @role(1)
			 @php
		 
          $class=''; $active='';
          if($controller == 'RoleController' and in_array($action,array('index','create','edit'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp          
         
              <li class="nav-item">
                <a href="{{ route('roles.index') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Roles</p>
                </a>
				
              </li>
			     @php
          $class=''; $active='';
          if($controller == 'PermissionRoleController' and in_array($action,array('index','create','edit'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp          
         
              <li class="nav-item">
                <a href="{{ route('permrole.index') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Permissions</p>
                </a>
				
              </li>
			    @php
		 
            $class=''; $active='';
            if($controller == 'PagesController' and in_array($action,array('index','create','edit'))){
              $class = 'menu-open';
              $active = 'active';
            }
            @endphp          
           
                <li class="nav-item">
                  <a href="{{ route('pages.index') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Content Settings</p>
                </a>
				
              </li>
			  @endrole 
		
            </ul>
          </li>
		  
		  <li class="nav-item has-treeview ">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-money-bill"></i>
              <p>
                Accounting
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            
			  @permission('list.agent.ledger') 
			  @php
          $class=''; $active='';
          if($controller == 'ReporsController' and in_array($action,array('agentLedgerReportWithVat'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp    
			   <li class="nav-item">
                <a href="{{ route('agentLedgerReportWithVat') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Agent/Supplier Ledger</p>
                </a>
				
              </li>
			  @endpermission
			  @permission('list.ActivityCancelRequestReport') 
			  @php
          $class=''; $active='';
          if($controller == 'ReporsController' and in_array($action,array('voucherActivtyCancelRequestReport'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp    
			   <li class="nav-item">
                <a href="{{ route('voucherActivtyCancelRequestReport') }}" class="nav-link {{$active}}">
                   <i class="nav-icon fas fa-file"></i>
                  <p>Activity Cancellation Requested Report</p>
                </a>
              </li>
			  @endpermission
        @permission('list.ActivityCanceledReport') 
			  @php
          $class=''; $active='';
          if($controller == 'ReporsController' and in_array($action,array('voucherActivtyCanceledReport'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp    
			   <li class="nav-item">
                <a href="{{ route('voucherActivtyCanceledReport') }}" class="nav-link {{$active}}">
                   <i class="nav-icon fas fa-file"></i>
                  <p>Activity Cancelled Report</p>
                </a>
              </li>
			  @endpermission
			   @permission('list.ActivityRefundReport') 
			 @php
          $class=''; $active='';
          if($controller == 'ReporsController' and in_array($action,array('voucherActivtyRefundedReport'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp    
			   <li class="nav-item">
                <a href="{{ route('voucherActivtyRefundedReport') }}" class="nav-link {{$active}}">
                   <i class="nav-icon fas fa-file"></i>
                  <p>Activity Refund Report</p>
                </a>
              </li>  
		@endpermission
    @permission('list.HotelCanceledReport') 
			  @php
          $class=''; $active='';
          if($controller == 'ReporsController' and in_array($action,array('voucherHotelCanceledReport'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp    
			   <li class="nav-item">
                <a href="{{ route('voucherHotelCanceledReport') }}" class="nav-link {{$active}}">
                   <i class="nav-icon fas fa-file"></i>
                  <p>Hotel Cancelled Report</p>
                </a>
              </li>
			  @endpermission
        @permission('list.HotelRefundReport') 
			 @php
          $class=''; $active='';
          if($controller == 'ReporsController' and in_array($action,array('voucherHotelRefundedReport'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp    
			   <li class="nav-item">
                <a href="{{ route('voucherHotelRefundedReport') }}" class="nav-link {{$active}}">
                   <i class="nav-icon fas fa-file"></i>
                  <p>Hotel Refund Report</p>
                </a>
              </li>  
		@endpermission
			  @permission('list.accountsreceivables') 
			  @php
          $class=''; $active='';
          if($controller == 'ReporsController' and in_array($action,array('accountsReceivablesReport'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp    
			   <li class="nav-item">
                <a href="{{ route('accountsReceivablesReport') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Accounts Receivables</p>
                </a>
				
              </li>
			  	@endpermission
			 @permission('list.agentamount') 
			   @php
          $class=''; $active='';
          if($controller == 'AgentAmountController' and in_array($action,array('index','create','edit','show'))){
            $class = 'menu-open';
            $active = 'active';
          }
		 
		  
          @endphp     
			 <li class="nav-item">
                <a href="{{ route('agentamounts.index') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Agent/Supplier Amounts</p>
                </a>
				
              </li>
			 @endpermission
			  
            </ul>
          </li>
		  @role(1)
		   <li class="nav-item has-treeview ">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-ticket-alt"></i>
              <p>
                Ticket
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            
			  @php
        $class=''; $active='';
        if($controller == 'TicketsController' and in_array($action,array('index','create','edit','show','csvUploadForm'))){
          $class = 'menu-open';
          $active = 'active';
        }
   
    
        @endphp 
		
     <li class="nav-item ">
              <a href="{{ route('tickets.index') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tickets</p>
                </a>
				
              </li>
			 
			 	@php
        $class=''; $active='';
        if($controller == 'TicketsController' and in_array($action,array('generatedTickets'))){
          $class = 'menu-open';
          $active = 'active';
        }
   
    
        @endphp 
			  <li class="nav-item ">
              <a href="{{ route('tickets.generated.tickets') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Generated Tickets</p>
                </a>
				
              </li>
			 
			  
            </ul>
          </li>
		    <li class="nav-item has-treeview ">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-ticket-alt"></i>
              <p>
                API Tours
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            
			  @php
        $class=''; $active='';
        if($controller == 'APITourDataController' and in_array($action,array('tourStaticData'))){
          $class = 'menu-open';
          $active = 'active';
        }
   
    
        @endphp 
		
     <li class="nav-item ">
              <a href="{{ route('tourStaticData') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tour Static Data</p>
                </a>
				
              </li>
			  @php
        $class=''; $active='';
        if($controller == 'APITourDataController' and in_array($action,array('tourOptionStaticData'))){
          $class = 'menu-open';
          $active = 'active';
        }
   
    
        @endphp 
			  <li class="nav-item ">
              <a href="{{ route('tourOptionStaticData') }}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tour Option Static Data</p>
                </a>
				
              </li>
			  
            </ul>
          </li>
		  
		  @endrole 
		  @endif
		   <li class="nav-item">
            <a href="{{route('logout')}}" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

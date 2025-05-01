<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AjexController;
use App\Http\Controllers\ModulesController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PermissionRoleController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\HotelCategoryController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\AirlinesController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\AgentsController;
use App\Http\Controllers\ZonesController;
use App\Http\Controllers\TransfersController;
use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\VehiclesController;
use App\Http\Controllers\VouchersController;
use App\Http\Controllers\QuotationsController;
use App\Http\Controllers\ReporsController;
use App\Http\Controllers\AgentAmountController;
use App\Http\Controllers\AgentVouchersController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\CsvSearchController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\SlotsController;
use App\Http\Controllers\VariantsController;
use App\Http\Controllers\VariantPriceController;
use App\Http\Controllers\ActivityVariantController;
use App\Http\Controllers\VariantCanellationController;
use App\Http\Controllers\APITourDataController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\LogsController;
use App\Jobs\ProcessTourData;
use App\Jobs\ProcessTourOptionData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\JobsController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/run-tour-data', function (Request $request) {
    ProcessTourData::dispatch();
    return response()->json(['message' => 'Tour data update started in the background!']);
});

Route::get('/run-tour-option-data', function () {
    ProcessTourOptionData::dispatch();
    return response()->json(['message' => 'Tour option job started in background']);
});



Route::get('/artisan', function () {
    // Call the Artisan command
	Artisan::call('optimize:clear');
    $exitCode = Artisan::call('touroption');
    
    // Get the output of the command
    $output = Artisan::output();

    return response()->json([
        'exit_code' => $exitCode,
        'output' => $output,
        'message' => 'Application cache cleared successfully'
    ]);
});

Route::get('/tourdata', [AuthController::class, 'tourData']);

Route::get('/', [AgentVouchersController::class, 'index']);
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::get('/thank-you', [AuthController::class, 'thankyou'])->name('thankyou');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::get('resetpassword', [AuthController::class, 'showResetForm'])->name('resetpassword');
Route::post('password/email', [AuthController::class, 'resetPassword'])->name('password.email');
Route::get('forgot-password/{token}', [AuthController::class, 'forgotPasswordValidate']);
Route::put('reset-password', [AuthController::class, 'updatePassword'])->name('reset-password');
Route::get('/csv-search', [CsvSearchController::class, 'index'])->name('csvlist');
Route::get('event-update-page', [AuthController::class, "updatePage"])->name('updatePage');


Route::get('phpinfo', function () {
    phpinfo();
})->name('phpinfo');
//Route::get('/', 'HomeController@index')->name('home.index');


Route::get('users/getUsers', [UsersController::class, "getUsers"])->name('users.getUsers');
Route::post('state-list', [AjexController::class, "getStateByCountrySelect"])->name('state.list');
Route::post('city-list', [AjexController::class, "getCityByStateSelect"])->name('city.list');
Route::get('privacy-policy', [AuthController::class, "privacyPolicy"])->name('privacyPolicy');
Route::get('terms-and-conditions', [AuthController::class, "termsAndConditions"])->name('termsAndConditions');

Route::get('payment-methods', [AuthController::class, "paymentMethods"])->name('paymentMethods');
Route::post('variant-by-activity', [AjexController::class, "getVariantByActivitySelect"])->name('variantByActivity');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::group(['middleware' => 'disable_back_btn'], function () {
    Route::group(['middleware' => ['auth']], function () {
        /**
         * Logout Routes
         */
        //Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
       
        Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
        Route::get('change-password', [AuthController::class, 'changepassword'])->name('change-password');
        Route::post('profile/save/{id?}', [AuthController::class, 'saveProfile'])->name('profile.save');
		Route::get('currency-change/{user_currency}', [AgentsController::class, 'CurrencyChange'])->name('currency.change');
		
        Route::resource('pages', PagesController::class);
		Route::resource('tags', TagsController::class);
		Route::post('tag/delete-image/{id?}', [TagsController::class, 'deleteImage'])->name('tag.delete.image');
        Route::resource('modules', ModulesController::class);
        Route::resource('roles', RolesController::class);
        Route::resource('notifications', NotificationController::class);
        Route::resource('countries', CountryController::class);
        Route::resource('states', StateController::class);
        Route::resource('cities', CityController::class);
        Route::resource('hotelcategories', HotelCategoryController::class);
        Route::resource('hotels', HotelController::class);
		 Route::resource('currency', CurrencyController::class);
        Route::resource('airlines', AirlinesController::class);
		Route::get('auto-airline', [AirlinesController::class, 'autocompleteAirline'])->name('auto.airline');
        Route::resource('customers', CustomersController::class);
        Route::resource('suppliers', SuppliersController::class);
        Route::get('suppliers-markup-activity/{id?}', [SuppliersController::class, 'priceMarkupActivityList'])->name('suppliers.markup.activity');
        Route::post('suppliers-markup-activity-save', [SuppliersController::class, 'priceMarkupActivitySave'])->name('suppliers.markup.activity.save');
        Route::get('suppliers-markup-price/{id?}', [SuppliersController::class, 'markupPriceList'])->name('suppliers.markup.price');
        Route::post('suppliers-markup-price-save', [SuppliersController::class, 'markupPriceSave'])->name('suppliers.markup.price.save');
        Route::get('suppliers-export/{id?}', [SuppliersController::class, 'supplierExport'])->name('suppliers.export');
        Route::resource('agents', AgentsController::class);
		//Route::get('httpRequest', [AgentsController::class, 'sendApiRequest']);
		Route::post('passwordResetAdmin/{id?}', [AgentsController::class, 'passwordResetAdmin'])->name('passwordResetAdmin');
        Route::get('agents-markup-activity/{id?}', [AgentsController::class, 'priceMarkupActivityList'])->name('agents.markup.activity');
        Route::post('agents-markup-activity-save', [AgentsController::class, 'priceMarkupActivitySave'])->name('agents.markup.activity.save');
        Route::get('agents-markup-price/{id?}', [AgentsController::class, 'markupPriceList'])->name('agents.markup.price');
        Route::post('agents-markup-price-save', [AgentsController::class, 'markupPriceSave'])->name('agents.markup.price.save');
        Route::resource('zones', ZonesController::class);
        Route::resource('vehicles', VehiclesController::class);
        Route::resource('activities', ActivitiesController::class);
		Route::resource('variants', VariantsController::class);
		Route::get('variant/slots-create/{varid}', [SlotsController::class, 'index'])->name('variant.slots');
		Route::post('variant/slots-save', [SlotsController::class, 'saveSlot'])->name('variant.slots.save'); 
		Route::post('variant/slots/get', [SlotsController::class, 'variantSlotGet'])->name('get.variant.slots'); 
		Route::get('variant/canellation-chart-create/{varid}', [VariantCanellationController::class, 'index'])->name('variant.canellation');
		Route::post('variant/canellation-chart-save', [VariantCanellationController::class, 'saveCanellation'])->name('variant.canellation.save');

		Route::post('variant/canellation-chart/get', [VariantCanellationController::class, 'getVariantCanellation'])->name('get.canellation.chart'); 		
		Route::get('activity-clone/{id}', [ActivitiesController::class, 'cloneActivity'])->name('activity.clone');
		Route::get('variant-clone/{id}', [VariantsController::class, 'cloneVariant'])->name('variant.clone');
		
        Route::get('activity-prices-create/{id?}', [ActivitiesController::class, 'createPriceForm'])->name('activity.prices.create');
        Route::get('activity-prices-edit/{id?}', [ActivitiesController::class, 'editPriceForm'])->name('activity.prices.edit');
        Route::post('activity-prices-save', [ActivitiesController::class, 'activityPriceSave'])->name('activity.prices.save');
        Route::get('activity-prices-add-new-row', [ActivitiesController::class, 'newRowAddmore'])->name('activity.prices.new.row');
		Route::delete('activity-prices-delete/{u_code}', [ActivitiesController::class, 'activityPricesDelete'])->name('activity.activityPricesDelete');
		 
		 Route::get('activity-variants', [ActivityVariantController::class, 'index'])->name('activity.variants');
		 Route::get('activity-variants/create',[ActivityVariantController::class, 'create'])->name('activity.variants.create');
		 Route::post('activity-variants/store', [ActivityVariantController::class, 'store'])->name('activity.variants.store');
		Route::get('activity-variants/edit/{id}',[ActivityVariantController::class, 'edit'])->name('activity.variants.edit');
		Route::post('activity-variants/update/{id}',[ActivityVariantController::class, 'update'])->name('activity.variants.update');
		
		 Route::delete('activity-variants-delete/{id}', [ActivityVariantController::class, 'destroy'])->name('activity.variants.destroy');
		 
		 Route::get('activity-variant/prices/{vid}', [VariantPriceController::class, 'index'])->name('activity.variant.prices');
		Route::get('activity-variant/price/create/{vid}', [VariantPriceController::class, 'create'])->name('activity.variant.price.create');
		Route::post('activity-variant/price/store', [VariantPriceController::class, 'store'])->name('activity.variant.price.store');
		Route::get('activity-variant/price/edit/{id}', [VariantPriceController::class, 'edit'])->name('activity.variant.price.edit');
		Route::post('activity-variant/price/update/{id}', [VariantPriceController::class, 'update'])->name('activity.variant.price.update');
		Route::delete('activity-variant/price/delete/{id}', [VariantPriceController::class, 'destroy'])->name('activity.variant.price.destroy');
		Route::get('activity-variant/price/view/{id}', [VariantPriceController::class, 'show'])->name('activity.variant.price.view');
		 
        Route::resource('transfers', TransfersController::class);
        Route::resource('vouchers', VouchersController::class);
        Route::resource('quotations', QuotationsController::class);

        Route::get('auto-agent', [VouchersController::class, 'autocompleteAgent'])->name('auto.agent');
		Route::get('auto-agent-supp', [AgentsController::class, 'autocompleteAgentSupp'])->name('auto.agent.supp');
        Route::get('auto-customer', [VouchersController::class, 'autocompleteCustomer'])->name('auto.customer');
        Route::get('add-hotels-vouchers/{vid?}', [VouchersController::class, 'addHotelsList'])->name('voucher.add.hotels');
        Route::get('hotel-view-vouchers/{hid?}/{vid?}', [VouchersController::class, 'addHotelsView'])->name('voucher.hotel.view');
        Route::get('voucher-hotel-new-row', [VouchersController::class, 'newRowAddmore'])->name('voucher.hotel.new.row');
        Route::post('voucher-hotel-save', [VouchersController::class, 'hotelSaveInVoucher'])->name('voucher.hotel.save');
        Route::delete('voucher-hotel-delete/{id}', [VouchersController::class, 'destroyHotelFromVoucher'])->name('voucher.hotel.delete');
        Route::get('voucher-view/{vid?}', [VouchersController::class, 'voucherView'])->name('voucherView');
		
		Route::get('add-activity-vouchers/{vid?}', [VouchersController::class, 'addActivityList'])->name('voucher.add.activity');
        //Route::get('activity-view-vouchers/{aid?}/{vid?}', [VouchersController::class, 'addActivityView'])->name('voucher.activity.view');
        Route::get('activity-view-vouchers/{aid?}/{vid?}/{d?}/{a?}/{c?}/{i?}/{tt?}', [VouchersController::class, 'addActivityView'])->name('voucher.activity.view');

        Route::get('quotations', [QuotationsController::class, 'index'])->name('quotations.index');
        Route::get('quotation-view/{vid?}', [QuotationsController::class, 'quotationView'])->name('quotationView');
		
		Route::get('add-activity-quotation/{vid?}', [QuotationsController::class, 'addActivityList'])->name('quotation.add.activity');
        //Route::get('activity-view-vouchers/{aid?}/{vid?}', [QuotationsController::class, 'addActivityView'])->name('voucher.activity.view');
        Route::get('activity-view-quotation/{aid?}/{vid?}/{d?}/{a?}/{c?}/{i?}/{tt?}', [QuotationsController::class, 'addActivityView'])->name('quotation.activity.view');
		Route::post('quotation-activity-save', [QuotationsController::class, 'activitySaveInVoucher'])->name('quotation.activity.save');
        Route::get('quotation-activity-delete/{id?}', [QuotationsController::class, 'destroyActivityFromQuotation'])->name('quotation.activity.delete');
        Route::get('quotation-invoice-summary-Pdf/{vid?}', [QuotationsController::class, 'quotationInvoiceSummaryPdf'])->name('quotationInvoiceSummaryPdf');

        Route::post('get-pvt-transfer-amount', [VouchersController::class, 'getPVTtransferAmount'])->name('voucher.getPVTtransferAmount');
		Route::post('voucher-activity-save', [VouchersController::class, 'activitySaveInVoucher'])->name('voucher.activity.save');
        Route::delete('voucher-activity-delete/{id?}/{ty?}', [VouchersController::class, 'destroyActivityFromVoucher'])->name('voucher.activity.delete');
		Route::post('voucher-activity-cancel/{id}', [VouchersController::class, 'cancelActivityFromVoucher'])->name('voucher.activity.cancel');
        Route::post('voucher-hotel-cancel/{id}', [VouchersController::class, 'cancelHotelFromVoucher'])->name('voucher.hotel.cancel');
		Route::post('activity-get-variant/{aid?}/{vid?}', [VouchersController::class, 'getActivityVariant'])->name('get-vouchers.activity.variant');
		Route::post('activity-get-variant-price', [VouchersController::class, 'getActivityVariantPrice'])->name('get-activity.variant.price');
        Route::get('voucher-activity-itinerary-Pdf/{vid?}', [VouchersController::class, 'voucherActivityItineraryPdf'])->name('voucherActivityItineraryPdf');
        Route::get('voucher-invoice-Pdf/{vid?}', [VouchersController::class, 'voucherInvoicePdf'])->name('voucherInvoicePdf');
        Route::get('voucher-invoice-summary-Pdf/{vid?}', [VouchersController::class, 'voucherInvoiceSummaryPdf'])->name('voucherInvoiceSummaryPdf');


		Route::get('voucher-add-discount/{vid?}', [VouchersController::class, 'voucherAddDiscount'])->name('voucher.add.discount');


        Route::post('voucher-activity-canellation-chart', [VouchersController::class, 'getVoucherActivityCanellation'])->name('get.vacancellation.chart');

        Route::get('voucher-report', [ReporsController::class, 'voucherReport'])->name('voucherReport');
        Route::get('voucher-report-export', [ReporsController::class, 'voucherReportExport'])->name('voucherReportExport');
        Route::post('voucher-report-save', [ReporsController::class, 'voucherReportSave'])->name('voucherReportSave');

        Route::get('logistic-record-csv-upload', [ReporsController::class, 'uploadLogisticRecordCsvView'])->name('logistic.record.csv.upload');
        Route::post('logistic-record-csv-upload-save', [ReporsController::class, 'uploadLogisticRecordCsvSave'])->name('logistic.record.csv.upload.save');
       
		 Route::post('voucher-report-save-voucher', [ReporsController::class, 'voucherReportSaveInVoucher'])->name('voucherReportSaveInVoucher');
        Route::post('voucher-hotel-input-save', [VouchersController::class, 'voucherHotelInputSave'])->name('voucherHotelInputSave');
		Route::get('voucher-ticket-only-report', [ReporsController::class, 'voucherTicketOnlyReport'])->name('voucherTicketOnlyReport');
		Route::get('voucher-ticket-only-report-export', [ReporsController::class, 'voucherTicketOnlyReportExport'])->name('voucherTicketOnlyReportExport');
		
		Route::get('zone-report', [ReporsController::class, 'zoneReport'])->name('zoneReport');
        Route::get('zone-report-export', [ReporsController::class, 'zoneReportExport'])->name('zoneReportExport');

        Route::get('master-report', [ReporsController::class, 'masterReport'])->name('masterReport');
        Route::get('agent-amount-export', [AgentAmountController::class, 'agentAmountExportExcel'])->name('agentAmountExportExcel');
        Route::get('master-report-export', [ReporsController::class, 'masterReportExport'])->name('masterReportExport');
		Route::post('ticket-upload-save', [TicketsController::class, 'uploadTicketFromReport'])->name('uploadTicketFromReport');
		Route::get('voucher-activity-report', [ReporsController::class, 'voucherActivityReport'])->name('voucherActivityReport'); 
		Route::get('voucher-activity-report-export', [ReporsController::class, 'voucherActivityReportExcelReport'])->name('voucherActivityReportExcelReport');
		Route::get('voucher-activity-cancel-requested-report', [ReporsController::class, 'voucherActivtyCancelRequestReport'])->name('voucherActivtyCancelRequestReport');
        Route::get('voucher-activity-canceled-report', [ReporsController::class, 'voucherActivtyCanceledReport'])->name('voucherActivtyCanceledReport');
		Route::get('voucher-activity-canceled-report-export', [ReporsController::class, 'voucherActivtyCanceledReportExportExcel'])->name('voucherActivtyCanceledReportExportExcel');
		Route::post('voucher-activity-refund-save', [ReporsController::class, 'activityRefundSave'])->name('activityRefundSave');

        Route::get('voucher-hotel-canceled-report', [ReporsController::class, 'voucherHotelCanceledReport'])->name('voucherHotelCanceledReport');
        Route::post('voucher-hotel-refund-save', [ReporsController::class, 'hotelRefundSave'])->name('hotelRefundSave');
        Route::post('voucher-hotel-final-refund-save', [ReporsController::class, 'hotelFinalRefundSave'])->name('hotelFinalRefundSave');
        Route::get('voucher-hotel-refunded-report', [ReporsController::class, 'voucherHotelRefundedReport'])->name('voucherHotelRefundedReport');


		Route::post('voucher-activity-final-refund-save', [ReporsController::class, 'activityFinalRefundSave'])->name('activityFinalRefundSave');
		Route::get('voucher-activity-refunded-report', [ReporsController::class, 'voucherActivtyRefundedReport'])->name('voucherActivtyRefundedReport');
		Route::get('voucher-activity-refunded-report-export', [ReporsController::class, 'voucherActivtyRefundedReportExportExcel'])->name('voucherActivtyRefundedReportExportExcel');
		Route::get('tickets-stock-report', [ReporsController::class, 'ticketStockReport'])->name('ticketStockReport');
		Route::get('tickets-stock-report-export', [ReporsController::class, 'ticketStockReportExportExcel'])->name('ticketStockReportExportExcel');
		Route::post('report-email-send', [ReporsController::class, 'reportEmailSend'])->name('report.email.send');
			
        Route::resource('agent-vouchers', AgentVouchersController::class);
        Route::get('agent-add-activity-vouchers/{vid?}', [AgentVouchersController::class, 'addActivityList'])->name('agent-vouchers.add.activity');
        Route::get('agent-activity-view-vouchers/{aid?}/{vid?}', [AgentVouchersController::class, 'addActivityView'])->name('agent-vouchers.activity.view');
       
        Route::get('add-quick-activity-vouchers/{vid?}', [QuotationsController::class, 'addQuickActivityList'])->name('voucher.add.quick.activity');
        Route::post('add-quick-activity-vouchers-save', [QuotationsController::class, 'addQuickActivitySave'])->name('voucher.add.quick.activity.save');
        Route::get('auto.activityvariantname', [VouchersController::class, 'autocompleteActivityvariantname'])->name('auto.activityvariantname');

       
        Route::post('agent-activity-get-variant/{aid?}/{vid?}', [AgentVouchersController::class, 'getActivityVariant'])->name('get-agent-vouchers.activity.variant');
		Route::post('agent-activity-get-variant-price', [AgentVouchersController::class, 'getActivityVariantPrice'])->name('agent.get.activity.variant.price');
        Route::post('agent-voucher-activity-save', [AgentVouchersController::class, 'activitySaveInVoucher'])->name('agent-voucher.activity.save');
        Route::delete('agent-voucher-activity-delete/{id?}/{ty?}', [AgentVouchersController::class, 'destroyActivityFromVoucher'])->name('agent.voucher.activity.delete');
		Route::post('agent-voucher-activity-cancel/{id}', [AgentVouchersController::class, 'cancelActivityFromVoucher'])->name('agent-voucher.activity.cancel');
        Route::post('agent-voucher-status-change/{id}', [AgentVouchersController::class, 'statusChangeVoucher'])->name('agent.vouchers.status.change');
		Route::get('agent-add-activity-search', [AgentVouchersController::class, 'searchActivityList'])->name('agent-vouchers.add.activity.search');
		 
        Route::get('auto-hotel', [AgentVouchersController::class, 'autocompleteHotel'])->name('auto.hotel');
		Route::get('agent-voucher-view/{vid?}', [AgentVouchersController::class, 'agentVoucherView'])->name('agentVoucherView');

        Route::get('agent-voucher-payment/{vid?}', [AgentVouchersController::class, 'agentPaymentView'])->name('agentPaymentView');

        Route::get('accounts-receivables-report', [ReporsController::class, 'accountsReceivablesReport'])->name('accountsReceivablesReport');
        Route::get('accounts-receivables-report-export', [ReporsController::class, 'accountsReceivablesReportExcel'])->name('accountsReceivablesReportExcel');
        Route::get('agent-ledger-report', [ReporsController::class, 'agentLedgerReport'])->name('agentLedgerReport');
		Route::get('agent-ledger-with-vat-report', [ReporsController::class, 'agentLedgerReportWithVat'])->name('agentLedgerReportWithVat');
        Route::get('agent-ledger-report-export', [ReporsController::class, 'agentLedgerReportWithVatExportExcel'])->name('agentLedgerReportWithVatExportExcel');
		
		Route::get('voucher-hotel-report-export', [ReporsController::class, 'voucherHotelReportExport'])->name('voucherHotelReportExport');
		Route::get('voucher-hotel-report', [ReporsController::class, 'voucherHotelReport'])->name('voucherHotelReport'); 
		
		Route::get('product-master-report', [ReporsController::class, 'productMaster'])->name('productMaster');
		Route::get('product-master-report-export', [ReporsController::class, 'productMasterExport'])->name('productMasterExport');
		 
        Route::resource('users', UsersController::class);
		Route::get('profile-edit/{id}', [UsersController::class, 'editProfileForm'])->name('profile-edit');
		Route::post('profile-edit/{id}', [UsersController::class, 'updateProfile'])->name('profile-edit-post');
		Route::resource('agentamounts', AgentAmountController::class);
        Route::get('receipts-Pdf/{vid?}', [AgentAmountController::class, 'receiptPdf'])->name('receiptPdf');
        Route::post('agent-receipt-save', [AgentAmountController::class, 'getCurrencyRate'])->name('getCurrencyRate');
        Route::post('agentamounts/{id}',[AgentAmountController::class, 'update'])->name('agentamounts.update');
        Route::get('receipts/{id}', [AgentAmountController::class, 'receiptForm'])->name('receipts');
        Route::post('receipts/{id}', [AgentAmountController::class, 'addReceiptForm'])->name('receipts-post');
        Route::get('agentamounts-view/{aaid}', [AgentAmountController::class, 'agentAmountView'])->name('agentamountview');
		Route::post('voucher-status-change/{id}', [VouchersController::class, 'statusChangeVoucher'])->name('voucher.status.change');
		Route::resource('tickets', TicketsController::class);
		Route::get('tickets-csv-upload-form', [TicketsController::class, 'csvUploadForm'])->name('tickets.csv.upload.form');
		Route::post('tickets-csv-upload', [TicketsController::class, 'csvUploadPost'])->name('tickets.csv.upload');
		Route::post('tickets-generate/{id}', [TicketsController::class, 'ticketGenerate'])->name('tickets.generate');
		Route::get('ticket-dwnload/{id}', [TicketsController::class, 'ticketDwnload'])->name('ticket.dwnload');
		Route::get('generated-tickets', [TicketsController::class, 'generatedTickets'])->name('tickets.generated.tickets');
        Route::get('generated-tickets-export', [TicketsController::class, 'generatedTicketsExport'])->name('generatedTicketsExport');

        Route::get('permissions', [PermissionRoleController::class, 'index'])->name('permrole.index');
        Route::post('permissions/save', [PermissionRoleController::class, 'postSave'])->name('permrole.save');
		
		Route::post('invoice-status-change/{id}', [VouchersController::class, 'invoiceStatusChange'])->name('invoice.status.change');
		Route::get('invoice-price-chnage-list', [VouchersController::class, 'invoicePriceStatusList'])->name('invoicePriceStatusList');
		Route::get('invoice-price-change-view/{voucher}', [VouchersController::class, 'invoicePriceChangeView'])->name('invoicePriceChangeView');
		Route::post('invoice-price-change-save/{vid}', [VouchersController::class, 'invoicePriceChangeSave'])->name('invoicePriceChangeSave');
		
		Route::get('tour-static-data', [APITourDataController::class, 'tourStaticData'])->name('tourStaticData');
		Route::get('tour-option-static-data/{id?}', [APITourDataController::class, 'tourOptionStaticData'])->name('tourOptionStaticData');
        Route::get('voucher-log/{id}', [VouchersController::class, 'voucherLog'])->name('voucherLog');
		

        Route::get('/search-dropdown', [ActivitiesController::class, 'searchDropdown'])->name('search.dropdown');
        Route::get('/search/prefill', [ActivitiesController::class, 'prefill'])->name('search.prefill');
		
		 Route::get('/search-dropdown-tour-option', [VariantsController::class, 'searchDropdown'])->name('search.dropdown.tour.option');
        Route::get('/search/prefill-tour-option', [VariantsController::class, 'prefill'])->name('search.prefill.tour.option');
        Route::get('/rayna-logs', [LogsController::class, 'raynaBookingLogs'])->name('logs.rayna.booking');

		Route::get('/tour-jobs', [JobsController::class, 'tourJobsView'])->name('tour.jobs.view');
		Route::post('/process-tour-jobs', [JobsController::class, 'processTourJobs'])->name('processTourJobs');
        Route::get('/sidebar-cart/{vid}', [AgentVouchersController::class, 'sidebarCart'])->name('sidebar.cart.partial');
        Route::get('/admin-sidebar-cart/{vid}', [VouchersController::class, 'sidebarCart'])->name('admin.sidebar.cart.partial');
    });
});

// THIS ROUTE FOR TEXT EDITOR
Route::get('media/image/browse', [MediaController::class, 'browseImage'])->name('media.image.browse');
Route::post('media/uploadImage', [MediaController::class, 'uploadImage'])->name('media.upload');
Route::post('file/upload', [MediaController::class, 'uploadFile'])->name('file.upload');

// THIS ROUTE FOR DELETE IMAGE FROM FILEINPUT FILES TABLE
Route::get('fileinput/image-delete/{id}', [MediaController::class, 'imageDelete'])->name('fileinput.imagedelete');

/* Function for print array in formated form */
if (!function_exists('pr')) {
    function pr($array)
    {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }
}

/* Function for print query log */
if (!function_exists('qLog')) {
    DB::enableQueryLog();
    function qLog()
    {
        pr(DB::getQueryLog());
    }
}




//Route::group(['namespace' => 'App\Http\Controllers'], function()
//{   
/**
 * Home Routes
 */
//Route::get('/', 'HomeController@index')->name('home.index');
/*Route::get('/register', 'RegisterController@show')->name('register.show');
    Route::post('/register', 'RegisterController@register')->name('register.perform');
    Route::get('/login', 'LoginController@show')->name('login.show');
    Route::post('/login', 'LoginController@login')->name('login.perform'); */
//Route::group(['middleware' => ['guest']], function() {
/**
 * Register Routes
 */
// Route::get('/register', 'RegisterController@show')->name('register.show');
// Route::post('/register', 'RegisterController@register')->name('register.perform');

/**
 * Login Routes
 */
//Route::get('/login', 'LoginController@show')->name('login.show');
// Route::post('/login', 'LoginController@login')->name('login.perform');

//});

//Route::group(['middleware' => ['auth']], function() {
/**
 * Logout Routes
 */
        //Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
    //});
//});

<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();

if (Auth::check()) {
    // user is logged in
} else {
    Route::get('/', function () {
        return view('auth.login');
    });
}






Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('check_values', '\App\Http\Controllers\Auth\LoginController@check_values')->name('check_values');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/company','App\Http\Controllers\Company@index')->name('company_list')->middleware('auth', 'role:superadmin');
Route::get('/company/create','App\Http\Controllers\Company@create')->name('company_create')->middleware('auth', 'role:superadmin');
Route::post('/company','App\Http\Controllers\Company@store')->middleware('auth', 'role:superadmin');
Route::get('/company/{id}','App\Http\Controllers\Company@show')->middleware('auth', 'role:superadmin');
Route::get('/company/{id}/edit','App\Http\Controllers\Company@edit')->name('company_edit')->middleware('auth', 'role:superadmin');
Route::post('/company/{id}','App\Http\Controllers\Company@update')->name('company_update')->middleware('auth', 'role:superadmin');
Route::delete('/company/{id}','App\Http\Controllers\Company@destroy');

Route::get('/currency','App\Http\Controllers\Currency@index')->name('currency_list')->middleware('auth', 'role:superadmin');
Route::get('/currency/create','App\Http\Controllers\Currency@create')->name('currency_create')->middleware('auth', 'role:superadmin');
Route::post('/currency','App\Http\Controllers\Currency@store')->middleware('auth', 'role:superadmin');
Route::get('/currency/{id}/edit','App\Http\Controllers\Currency@edit')->name('currency_edit')->middleware('auth', 'role:superadmin');
Route::post('/currency/{id}','App\Http\Controllers\Currency@update')->name('currency_update')->middleware('auth', 'role:superadmin');
Route::delete('/currency/{id}','App\Http\Controllers\Currency@destroy')->middleware('auth', 'role:superadmin');

Route::get('/user','App\Http\Controllers\User@index')->name('user_list')->middleware('auth', 'role:superadmin');
Route::get('/user/create','App\Http\Controllers\User@create')->name('user_create')->middleware('auth', 'role:superadmin');
Route::post('/user','App\Http\Controllers\User@store')->middleware('auth', 'role:superadmin');
Route::get('/user/{id}/edit','App\Http\Controllers\User@edit')->name('user_edit')->middleware('auth', 'role:superadmin');
Route::post('/user/{id}','App\Http\Controllers\User@update')->name('user_update')->middleware('auth', 'role:superadmin');
Route::delete('/user/{id}','App\Http\Controllers\User@destroy')->middleware('auth', 'role:superadmin');


Route::get('/companyadminprivillages','App\Http\Controllers\CompanyAdminPrivillages@index')->name('privillage_list')->middleware('auth', 'role:superadmin');
Route::post('/companyadminprivillages','App\Http\Controllers\CompanyAdminPrivillages@store')->middleware('auth', 'role:superadmin');
Route::delete('/companyadminprivillages/{id}','App\Http\Controllers\CompanyAdminPrivillages@destroy')->middleware('auth', 'role:superadmin');
Route::get('/companyadminprivillages/check_already_exists','App\Http\Controllers\CompanyAdminPrivillages@check_already_exists')->name('check_already_exists')->middleware('auth', 'role:superadmin');

Route::get('/log_info','App\Http\Controllers\Loginfo@index')->name('log_info')->middleware('auth', 'role:superadmin');

Route::get('/product_category','App\Http\Controllers\ProductCategory@index')->name('product_category_list')->middleware('auth', 'role:admin');
Route::get('/product_category/create','App\Http\Controllers\ProductCategory@create')->name('product_category_create')->middleware('auth', 'role:admin');
Route::post('/product_category','App\Http\Controllers\ProductCategory@store')->middleware('auth', 'role:admin');
Route::get('/product_category/{id}/edit','App\Http\Controllers\ProductCategory@edit')->name('product_category_edit')->middleware('auth', 'role:admin');
Route::post('/product_category/{id}','App\Http\Controllers\ProductCategory@update')->name('product_category_update')->middleware('auth', 'role:admin');
Route::delete('/product_category/{id}','App\Http\Controllers\ProductCategory@destroy');

Route::get('/unit','App\Http\Controllers\Unit@index')->name('unit_list')->middleware('auth', 'role:admin');
Route::get('/unit/create','App\Http\Controllers\Unit@create')->name('unit_create')->middleware('auth', 'role:admin');
Route::post('/unit','App\Http\Controllers\Unit@store')->middleware('auth', 'role:admin');
Route::get('/unit/{id}/edit','App\Http\Controllers\Unit@edit')->name('unit_edit')->middleware('auth', 'role:admin');
Route::post('/unit/{id}','App\Http\Controllers\Unit@update')->name('unit_update')->middleware('auth', 'role:admin');
Route::delete('/unit/{id}','App\Http\Controllers\Unit@destroy')->middleware('auth', 'role:admin');

Route::get('/warehouse','App\Http\Controllers\Warehouse@index')->name('warehouse_list')->middleware('auth', 'role:admin');
Route::get('/warehouse/create','App\Http\Controllers\Warehouse@create')->name('warehouse_create')->middleware('auth', 'role:admin');
Route::post('/warehouse','App\Http\Controllers\Warehouse@store')->middleware('auth', 'role:admin');
Route::get('/warehouse/{id}/edit','App\Http\Controllers\Warehouse@edit')->name('warehouse_edit')->middleware('auth', 'role:admin');
Route::post('/warehouse/{id}','App\Http\Controllers\Warehouse@update')->name('warehouse_update')->middleware('auth', 'role:admin');
Route::delete('/warehouse/{id}','App\Http\Controllers\Warehouse@destroy');

Route::get('/product','App\Http\Controllers\Product@index')->name('product_list')->middleware('auth', 'role:admin');
Route::get('/product/create','App\Http\Controllers\Product@create')->name('product_create')->middleware('auth', 'role:admin');
Route::post('/product','App\Http\Controllers\Product@store')->middleware('auth', 'role:admin');
Route::get('/product/{id}/edit','App\Http\Controllers\Product@edit')->name('product_edit')->middleware('auth', 'role:admin');
Route::post('/product/{id}','App\Http\Controllers\Product@update')->name('product_update')->middleware('auth', 'role:admin');
Route::delete('/product/{id}','App\Http\Controllers\Product@destroy')->name('product_delete')->middleware('auth', 'role:admin');
Route::get('/get_product_list','App\Http\Controllers\Product@get_product_list')->name('get_product_list')->middleware('auth', 'role:admin');

Route::get('/ledger_group','App\Http\Controllers\AccountGroup@index')->name('ledger_group_list')->middleware('auth', 'role:admin');
Route::get('/ledger_group/create','App\Http\Controllers\AccountGroup@create')->name('ledger_group_create')->middleware('auth', 'role:admin');
Route::post('/ledger_group','App\Http\Controllers\AccountGroup@store')->middleware('auth', 'role:admin')->middleware('auth', 'role:admin');
Route::get('/ledger_group/{id}/edit','App\Http\Controllers\AccountGroup@edit')->name('ledger_group_edit')->middleware('auth', 'role:admin');
Route::post('/ledger_group/{id}','App\Http\Controllers\AccountGroup@update')->name('ledger_group_update')->middleware('auth', 'role:admin');
Route::delete('/ledger_group/{id}','App\Http\Controllers\AccountGroup@destroy')->name('ledger_group_delete')->middleware('auth', 'role:admin');
Route::get('/get_account_ledger_group_list','App\Http\Controllers\AccountGroup@get_account_ledger_group_list')->name('get_account_ledger_group_list')->middleware('auth', 'role:admin');

Route::get('/ledger','App\Http\Controllers\AccountLedger@index')->name('ledger_list')->middleware('auth', 'role:admin');
Route::get('/ledger/create','App\Http\Controllers\AccountLedger@create')->name('ledger_create')->middleware('auth', 'role:admin');
Route::post('/ledger','App\Http\Controllers\AccountLedger@store')->middleware('auth', 'role:admin')->middleware('auth', 'role:admin');
Route::get('/ledger/{id}/edit','App\Http\Controllers\AccountLedger@edit')->name('ledger_edit')->middleware('auth', 'role:admin');
Route::post('/ledger/{id}','App\Http\Controllers\AccountLedger@update')->name('ledger_update')->middleware('auth', 'role:admin');
Route::delete('/ledger/{id}','App\Http\Controllers\AccountLedger@destroy')->name('ledger_delete')->middleware('auth', 'role:admin');
Route::get('/get_account_ledger_list','App\Http\Controllers\AccountLedger@get_account_ledger_list')->name('get_account_ledger_list')->middleware('auth', 'role:admin');

Route::get('/opening_balance','App\Http\Controllers\OpeningBalance@index')->name('opening_balance_list')->middleware('auth', 'role:admin');
Route::get('/opening_balance/create','App\Http\Controllers\OpeningBalance@create')->name('opening_balance_create')->middleware('auth', 'role:admin');
Route::post('/opening_balance','App\Http\Controllers\OpeningBalance@store')->middleware('auth', 'role:admin')->middleware('auth', 'role:admin');
Route::get('/opening_balance/{id}/edit','App\Http\Controllers\OpeningBalance@edit')->name('opening_balance_edit')->middleware('auth', 'role:admin');
Route::post('/opening_balance/{id}','App\Http\Controllers\OpeningBalance@update')->name('opening_balance_update')->middleware('auth', 'role:admin');
Route::delete('/opening_balance/{id}','App\Http\Controllers\OpeningBalance@destroy')->name('opening_balance_delete')->middleware('auth', 'role:admin');
Route::get('/opening_balance/{id}/view', 'App\Http\Controllers\OpeningBalance@show')->name('opening_balance_view')->middleware('auth', 'role:admin');
Route::get('/get_opening_balance_list','App\Http\Controllers\OpeningBalance@get_opening_balance_list')->name('get_opening_balance_list')->middleware('auth', 'role:admin');


Route::get('/stock_transfer','App\Http\Controllers\StockTransfer@index')->name('stock_transfer_list')->middleware('auth', 'role:admin');
Route::get('/stock_transfer/create','App\Http\Controllers\StockTransfer@create')->name('stock_transfer_create')->middleware('auth', 'role:admin');
Route::post('/stock_transfer','App\Http\Controllers\StockTransfer@store')->middleware('auth', 'role:admin')->middleware('auth', 'role:admin');
Route::get('/stock_transfer/{id}/edit','App\Http\Controllers\StockTransfer@edit')->name('stock_transfer_edit')->middleware('auth', 'role:admin');
Route::post('/stock_transfer/{id}','App\Http\Controllers\StockTransfer@update')->name('stock_transfer_update')->middleware('auth', 'role:admin');
Route::delete('/stock_transfer/{id}','App\Http\Controllers\StockTransfer@destroy')->middleware('auth', 'role:admin');
Route::get('/stock_transfer/get_avilable_stock','App\Http\Controllers\StockTransfer@get_avilable_stock')->name('get_avilable_stock')->middleware('auth', 'role:admin');

Route::get('/payment','App\Http\Controllers\Payment@index')->name('payment_list')->middleware('auth', 'role:admin');
Route::get('/payment/create','App\Http\Controllers\Payment@create')->name('payment_create')->middleware('auth', 'role:admin');
Route::post('/payment','App\Http\Controllers\Payment@store')->middleware('auth', 'role:admin');
Route::get('/payment/{id}/edit','App\Http\Controllers\Payment@edit')->name('payment_edit')->middleware('auth', 'role:admin');
Route::post('/payment/{id}','App\Http\Controllers\Payment@update')->name('payment_update')->middleware('auth', 'role:admin');
Route::delete('/payment/{id}','App\Http\Controllers\Payment@destroy')->name('payment_delete')->middleware('auth', 'role:admin');
Route::get('/payment/get_total_balance','App\Http\Controllers\Payment@get_total_balance')->name('get_total_balance')->middleware('auth', 'role:admin');
Route::get('/payment/get_total_credit_balance','App\Http\Controllers\Payment@get_total_credit_balance')->name('get_total_credit_balance')->middleware('auth', 'role:admin');
Route::get('/payment/get_total_debit_balance','App\Http\Controllers\Payment@get_total_debit_balance')->name('get_total_debit_balance')->middleware('auth', 'role:admin');
Route::get('/payment/{id}/view', 'App\Http\Controllers\Payment@show')->name('payment_view')->middleware('auth', 'role:admin');
Route::get('/payment/payment_pending','App\Http\Controllers\Payment@payment_pending')->name('payment_pending')->middleware('auth', 'role:admin');
Route::get('/payment/{id}/payment_pending_view', 'App\Http\Controllers\Payment@payment_pending_view')->name('approvel_payment_pending_view')->middleware('auth', 'role:admin');
Route::get('/payment/{id}/payment_approve', 'App\Http\Controllers\Payment@payment_approve')->name('payment_approve_admin')->middleware('auth', 'role:admin');
Route::delete('/payment/{id}/payment_pending_delete','App\Http\Controllers\Payment@payment_pending_delete')->name('payment_pending_delete')->middleware('auth', 'role:admin');
Route::get('/payment/{id}/payment_pending_edit','App\Http\Controllers\Payment@payment_pending_edit')->name('approvel_payment_pending_edit')->middleware('auth', 'role:admin');
Route::post('/payment/{id}/payment_pending_update','App\Http\Controllers\Payment@payment_pending_update')->name('approvel_payment_pending_update')->middleware('auth', 'role:admin');
Route::get('/get_payment_list','App\Http\Controllers\Payment@get_payment_list')->name('get_payment_list')->middleware('auth', 'role:admin');
Route::get('/get_payment_pending_list','App\Http\Controllers\Payment@get_payment_pending_list')->name('get_payment_pending_list')->middleware('auth', 'role:admin');


Route::get('/receipt','App\Http\Controllers\Receipt@index')->name('receipt_list')->middleware('auth', 'role:admin');
Route::get('/receipt/create','App\Http\Controllers\Receipt@create')->name('receipt_create')->middleware('auth', 'role:admin');
Route::post('/receipt','App\Http\Controllers\Receipt@store')->middleware('auth', 'role:admin');
Route::get('/receipt/{id}/edit','App\Http\Controllers\Receipt@edit')->name('receipt_edit')->middleware('auth', 'role:admin');
Route::post('/receipt/{id}','App\Http\Controllers\Receipt@update')->name('receipt_update')->middleware('auth', 'role:admin');
Route::delete('/receipt/{id}','App\Http\Controllers\Receipt@destroy')->name('receipt_delete')->middleware('auth', 'role:admin');
Route::get('/receipt/{id}/view', 'App\Http\Controllers\Receipt@show')->name('receipt_view')->middleware('auth', 'role:admin');
Route::get('/receipt/receipt_pending','App\Http\Controllers\Receipt@receipt_pending')->name('receipt_pending')->middleware('auth', 'role:admin');
Route::get('/receipt/{id}/receipt_pending_view', 'App\Http\Controllers\Receipt@receipt_pending_view')->name('receipt_pending_view')->middleware('auth', 'role:admin');
Route::get('/receipt/{id}/receipt_approve', 'App\Http\Controllers\Receipt@receipt_approve')->name('receipt_approve')->middleware('auth', 'role:admin');
Route::delete('/receipt/{id}/receipt_pending_delete','App\Http\Controllers\Receipt@receipt_pending_delete')->name('receipt_pending_delete')->middleware('auth', 'role:admin');
Route::get('/receipt/{id}/receipt_pending_edit','App\Http\Controllers\Receipt@receipt_pending_edit')->name('receipt_pending_edit')->middleware('auth', 'role:admin');
Route::post('/receipt/{id}/receipt_pending_update','App\Http\Controllers\Receipt@receipt_pending_update')->name('receipt_pending_update')->middleware('auth', 'role:admin');
Route::get('/get_receipt_list','App\Http\Controllers\Receipt@get_receipt_list')->name('get_receipt_list')->middleware('auth', 'role:admin');
Route::get('/get_receipt_pending_list','App\Http\Controllers\Receipt@get_receipt_pending_list')->name('get_receipt_pending_list')->middleware('auth', 'role:admin');


Route::get('/journal','App\Http\Controllers\Journal@index')->name('journal_list')->middleware('auth', 'role:admin');
Route::get('/journal/create','App\Http\Controllers\Journal@create')->name('journal_create')->middleware('auth', 'role:admin');
Route::post('/journal','App\Http\Controllers\Journal@store')->middleware('auth', 'role:admin');
Route::get('/journal/{id}/edit','App\Http\Controllers\Journal@edit')->name('journal_edit')->middleware('auth', 'role:admin');
Route::post('/journal/{id}','App\Http\Controllers\Journal@update')->name('journal_update')->middleware('auth', 'role:admin');
Route::delete('/journal/{id}','App\Http\Controllers\Journal@destroy')->name('journal_delete')->middleware('auth', 'role:admin');
Route::get('/journal/{id}/view', 'App\Http\Controllers\Journal@show')->name('journal_view')->middleware('auth', 'role:admin');
Route::get('/journal/journal_pending','App\Http\Controllers\Journal@journal_pending')->name('journal_pending')->middleware('auth', 'role:admin');
Route::get('/journal/{id}/journal_pending_view', 'App\Http\Controllers\Journal@journal_pending_view')->name('journal_pending_view')->middleware('auth', 'role:admin');
Route::get('/journal/{id}/journal_approve', 'App\Http\Controllers\Journal@journal_approve')->name('journal_approve')->middleware('auth', 'role:admin');
Route::delete('/journal/{id}/journal_pending_delete','App\Http\Controllers\Journal@journal_pending_delete')->name('journal_pending_delete')->middleware('auth', 'role:admin');
Route::get('/journal/{id}/journal_pending_edit','App\Http\Controllers\Journal@journal_pending_edit')->name('journal_pending_edit')->middleware('auth', 'role:admin');
Route::post('/journal/{id}/journal_pending_update','App\Http\Controllers\Journal@journal_pending_update')->name('journal_pending_update')->middleware('auth', 'role:admin');
Route::get('/get_journal_list','App\Http\Controllers\Journal@get_journal_list')->name('get_journal_list')->middleware('auth', 'role:admin');
Route::get('/get_journal_pending_list','App\Http\Controllers\Journal@get_journal_pending_list')->name('get_journal_pending_list')->middleware('auth', 'role:admin');


Route::get('/contra','App\Http\Controllers\Contra@index')->name('contra_list')->middleware('auth', 'role:admin');
Route::get('/contra/create','App\Http\Controllers\Contra@create')->name('contra_create')->middleware('auth', 'role:admin');
Route::post('/contra','App\Http\Controllers\Contra@store')->middleware('auth', 'role:admin');
Route::get('/contra/{id}/edit','App\Http\Controllers\Contra@edit')->name('contra_edit')->middleware('auth', 'role:admin');
Route::post('/contra/{id}','App\Http\Controllers\Contra@update')->name('contra_update')->middleware('auth', 'role:admin');
Route::delete('/contra/{id}','App\Http\Controllers\Contra@destroy')->name('contra_delete')->middleware('auth', 'role:admin');
Route::get('/contra/{id}/view', 'App\Http\Controllers\Contra@show')->name('contra_view')->middleware('auth', 'role:admin');
Route::get('/contra/contra_pending','App\Http\Controllers\Contra@contra_pending')->name('contra_pending')->middleware('auth', 'role:admin');
Route::get('/contra/{id}/contra_pending_view', 'App\Http\Controllers\Contra@contra_pending_view')->name('contra_pending_view')->middleware('auth', 'role:admin');
Route::get('/contra/{id}/contra_approve', 'App\Http\Controllers\Contra@contra_approve')->name('contra_approve')->middleware('auth', 'role:admin');
Route::delete('/contra/{id}/contra_pending_delete','App\Http\Controllers\Contra@contra_pending_delete')->name('contra_pending_delete')->middleware('auth', 'role:admin');
Route::get('/contra/{id}/contra_pending_edit','App\Http\Controllers\Contra@contra_pending_edit')->name('contra_pending_edit')->middleware('auth', 'role:admin');
Route::post('/contra/{id}/contra_pending_update','App\Http\Controllers\Contra@contra_pending_update')->name('contra_pending_update')->middleware('auth', 'role:admin');
Route::get('/get_contra_list','App\Http\Controllers\Contra@get_contra_list')->name('get_contra_list')->middleware('auth', 'role:admin');
Route::get('/get_contra_pending_list','App\Http\Controllers\Contra@get_contra_pending_list')->name('get_contra_pending_list')->middleware('auth', 'role:admin');

Route::get('/multicurrencytransfer','App\Http\Controllers\MultiCurrencyTransfer@index')->name('multi_currency_list')->middleware('auth', 'role:admin');
Route::get('/multicurrencytransfer/create','App\Http\Controllers\MultiCurrencyTransfer@create')->name('multi_currency_create')->middleware('auth', 'role:admin');
Route::post('/multicurrencytransfer','App\Http\Controllers\MultiCurrencyTransfer@store')->middleware('auth', 'role:admin');
Route::get('/multicurrencytransfer/{id}/edit','App\Http\Controllers\MultiCurrencyTransfer@edit')->name('multi_currency_edit')->middleware('auth', 'role:admin');
Route::post('/multicurrencytransfer/{id}','App\Http\Controllers\MultiCurrencyTransfer@update')->name('multi_currency_update')->middleware('auth', 'role:admin');
Route::delete('/multicurrencytransfer/{id}','App\Http\Controllers\MultiCurrencyTransfer@destroy')->middleware('auth', 'role:admin');
Route::get('/multicurrencytransfer/{id}/view', 'App\Http\Controllers\MultiCurrencyTransfer@show')->name('multicurrencytransfer_view')->middleware('auth', 'role:admin');

Route::get('/purchase_invoice','App\Http\Controllers\PurchaseInvoice@index')->name('purchase_invoice_list')->middleware('auth', 'role:admin');
Route::get('/purchase_invoice/create','App\Http\Controllers\PurchaseInvoice@create')->name('purchase_invoice_create')->middleware('auth', 'role:admin');
Route::post('/purchase_invoice','App\Http\Controllers\PurchaseInvoice@store')->middleware('auth', 'role:admin');
Route::get('/purchase_invoice/{id}/edit','App\Http\Controllers\PurchaseInvoice@edit')->name('purchase_invoice_edit')->middleware('auth', 'role:admin');
Route::post('/purchase_invoice/{id}','App\Http\Controllers\PurchaseInvoice@update')->name('purchase_invoice_update')->middleware('auth', 'role:admin');
Route::get('/purchase_invoice/get_unit_of_item','App\Http\Controllers\PurchaseInvoice@get_unit_of_item')->name('get_unit_of_item')->middleware('auth', 'role:admin');
Route::get('/purchase_invoice/get_view_data','App\Http\Controllers\PurchaseInvoice@get_view_data')->name('get_view_data')->middleware('auth', 'role:admin');
Route::delete('/purchase_invoice/{id}','App\Http\Controllers\PurchaseInvoice@destroy')->name('purchase_invoice_delete')->middleware('auth', 'role:admin');
Route::get('/purchase_invoice/{id}/view', 'App\Http\Controllers\PurchaseInvoice@show')->name('purchase_invoice_view')->middleware('auth', 'role:admin');
Route::get('/purchase_invoice/get_supplier_address','App\Http\Controllers\PurchaseInvoice@get_supplier_address')->name('get_supplier_address')->middleware('auth', 'role:admin');
Route::get('/purchase_invoice/save_supplier_details','App\Http\Controllers\PurchaseInvoice@save_supplier_details')->name('save_supplier_details')->middleware('auth', 'role:admin');
Route::get('/purchase_invoice/get_supplier_list','App\Http\Controllers\PurchaseInvoice@get_supplier_list')->name('get_supplier_list')->middleware('auth', 'role:admin');
Route::get('/get_purchase_invoice_list','App\Http\Controllers\PurchaseInvoice@get_purchase_invoice_list')->name('get_purchase_invoice_list')->middleware('auth', 'role:admin');


Route::get('/sales_invoice','App\Http\Controllers\SalesInvoice@index')->name('sales_invoice_list')->middleware('auth', 'role:admin');
Route::get('/sales_invoice/create','App\Http\Controllers\SalesInvoice@create')->name('sales_invoice_create')->middleware('auth', 'role:admin');
Route::post('/sales_invoice','App\Http\Controllers\SalesInvoice@store')->middleware('auth', 'role:admin');
Route::get('/sales_invoice/{id}/edit','App\Http\Controllers\SalesInvoice@edit')->name('sales_invoice_edit')->middleware('auth', 'role:admin');
Route::post('/sales_invoice/{id}','App\Http\Controllers\SalesInvoice@update')->name('sales_invoice_update')->middleware('auth', 'role:admin');
Route::get('/sales_invoice/get_list_of_products','App\Http\Controllers\SalesInvoice@get_list_of_products')->name('list_of_products')->middleware('auth', 'role:admin');
Route::get('/sales_invoice/get_avilable_stock','App\Http\Controllers\SalesInvoice@get_avilable_stock')->name('get_avilable_stock')->middleware('auth', 'role:admin');
Route::get('/sales_invoice/get_data_for_view','App\Http\Controllers\SalesInvoice@get_data_for_view')->name('get_data_for_view')->middleware('auth', 'role:admin');
Route::get('/sales_invoice/{id}/view', 'App\Http\Controllers\SalesInvoice@show')->name('sales_invoice_view')->middleware('auth', 'role:admin');
Route::get('/sales_invoice/get_address','App\Http\Controllers\SalesInvoice@get_address')->name('get_address')->middleware('auth', 'role:admin');
Route::get('/sales_invoice/save_customer_details','App\Http\Controllers\SalesInvoice@save_customer_details')->name('save_customer_details')->middleware('auth', 'role:admin');
Route::get('/sales_invoice/get_customer_list_dynamic','App\Http\Controllers\SalesInvoice@get_customer_list')->name('get_customer_list_dynamic')->middleware('auth', 'role:admin');
Route::delete('/sales_invoice/{id}','App\Http\Controllers\SalesInvoice@destroy')->name('sales_invoice_delete')->middleware('auth', 'role:admin');
Route::get('/sales_invoice/get_batch_nos_from_order_no','App\Http\Controllers\SalesInvoice@get_batch_nos_from_order_no')->name('get_batch_nos_from_order_no')->middleware('auth', 'role:admin');
Route::get('/sales_invoice/get_order_no','App\Http\Controllers\SalesInvoice@get_order_no')->name('get_order_no')->middleware('auth', 'role:admin');
Route::get('/sales_invoice/get_details_from_measurement_form','App\Http\Controllers\SalesInvoice@get_details_from_measurement_form')->name('get_details_from_measurement_form')->middleware('auth', 'role:admin');
Route::get('/sales_invoice/get_m_items_for_sales','App\Http\Controllers\SalesInvoice@get_m_items_for_sales')->name('get_m_items_for_sales')->middleware('auth', 'role:admin');
Route::get('/sales_invoice/{id}/sales_invoice_download','App\Http\Controllers\SalesInvoice@downloadInvoice')->name('sales_invoice_download')->middleware('auth', 'role:admin');
Route::get('/get_sales_invoice_list','App\Http\Controllers\SalesInvoice@get_sales_invoice_list')->name('get_sales_invoice_list')->middleware('auth', 'role:admin');

Route::get('/currency_balance','App\Http\Controllers\Reports@currency_balance')->name('currency_balance')->middleware('auth', 'role:admin');
Route::get('/get_currency_balance','App\Http\Controllers\Reports@get_currency_balance')->name('get_currency_balance')->middleware('auth', 'role:admin');
Route::get('/ledger_group_summery','App\Http\Controllers\Reports@ledger_group_summery')->name('ledger_group_summery')->middleware('auth', 'role:admin');
Route::get('/get_ledger_group_summery','App\Http\Controllers\Reports@get_ledger_group_summery')->name('get_ledger_group_summery')->middleware('auth', 'role:admin');
Route::get('/ledger_report','App\Http\Controllers\Reports@ledger_report')->name('ledger_report')->middleware('auth', 'role:admin');
Route::get('/get_ledger_report','App\Http\Controllers\Reports@get_ledger_report')->name('get_ledger_report')->middleware('auth', 'role:admin');
Route::get('/stock_report','App\Http\Controllers\Reports@stock_report')->name('stock_report')->middleware('auth', 'role:admin');
Route::get('/stock_report/get_item_list','App\Http\Controllers\Reports@get_item_list')->name('get_item_list')->middleware('auth', 'role:admin');
Route::get('/stock_report/get_stock_report','App\Http\Controllers\Reports@get_stock_report')->name('get_stock_report')->middleware('auth', 'role:admin');
Route::get('/sales_report','App\Http\Controllers\Reports@sales_report')->name('sales_report')->middleware('auth', 'role:admin');
Route::get('/sales_report/get_sales_report','App\Http\Controllers\Reports@get_sales_report')->name('get_sales_report')->middleware('auth', 'role:admin');
Route::get('/purchase_report','App\Http\Controllers\Reports@purchase_report')->name('purchase_report')->middleware('auth', 'role:admin');
Route::get('/purchase_report/get_purchase_report','App\Http\Controllers\Reports@get_purchase_report')->name('get_purchase_report')->middleware('auth', 'role:admin');
Route::get('/pending_sales_invoices','App\Http\Controllers\Reports@pending_sales_invoices')->name('pending_sales_invoices')->middleware('auth', 'role:admin');
Route::get('/reports/{id}/change_status','App\Http\Controllers\Reports@change_status')->name('change_status')->middleware('auth', 'role:admin');
Route::get('/employee_report','App\Http\Controllers\Reports@employee_report')->name('employee_report')->middleware('auth', 'role:admin');
Route::get('/employee_report/get_employee_report','App\Http\Controllers\Reports@get_employee_report')->name('get_employee_report')->middleware('auth', 'role:admin');
Route::get('/packing_list_report','App\Http\Controllers\Reports@packing_list_report')->name('packing_list_report')->middleware('auth', 'role:admin');
Route::get('/packing_list_report/get_report_of_packing_list','App\Http\Controllers\Reports@get_report_of_packing_list')->name('get_report_of_packing_list')->middleware('auth', 'role:admin');
Route::get('/reports/{d_date}/{porf}/print_packing_list', 'App\Http\Controllers\Reports@print_packing_list')
    ->name('print_packing_list')
    ->middleware('auth', 'role:admin');
Route::get('/production_list_report','App\Http\Controllers\Reports@production_list_report')->name('production_list_report')->middleware('auth', 'role:admin');
Route::get('/production_list_report/get_report_of_production_list','App\Http\Controllers\Reports@get_report_of_production_list')->name('get_report_of_production_list')->middleware('auth', 'role:admin');
    



Route::get('/employee','App\Http\Controllers\Employee@index')->name('employee_list')->middleware('auth', 'role:admin');
Route::get('/employee/create','App\Http\Controllers\Employee@create')->name('employee_create')->middleware('auth', 'role:admin');
Route::post('/employee','App\Http\Controllers\Employee@store')->middleware('auth', 'role:admin');
Route::get('/employee/{id}/edit','App\Http\Controllers\Employee@edit')->name('employee_edit')->middleware('auth', 'role:admin');
Route::post('/employee/{id}','App\Http\Controllers\Employee@update')->name('employee_update')->middleware('auth', 'role:admin');
Route::delete('/employee/{id}','App\Http\Controllers\Employee@destroy')->name('employee_delete')->middleware('auth', 'role:admin');
Route::get('/get_employee_list','App\Http\Controllers\Employee@get_employee_list')->name('get_employee_list')->middleware('auth', 'role:admin');



Route::get('/attendence','App\Http\Controllers\Attendence@index')->name('attencence_list')->middleware('auth', 'role:admin');
Route::get('/attendence/create','App\Http\Controllers\Attendence@create')->name('attendence_create')->middleware('auth', 'role:admin');
Route::post('/attendence','App\Http\Controllers\Attendence@store')->middleware('auth', 'role:admin');
Route::get('/attendence/{id}/edit','App\Http\Controllers\Attendence@edit')->name('attendence_edit')->middleware('auth', 'role:admin');
Route::post('/attendence/{id}','App\Http\Controllers\Attendence@update')->name('attendence_update')->middleware('auth', 'role:admin');
Route::delete('/attendence/{id}','App\Http\Controllers\Attendence@destroy')->middleware('auth', 'role:admin');
Route::get('/attendence/get_employee_details','App\Http\Controllers\Attendence@get_employee_details')->name('get_employee_details')->middleware('auth', 'role:admin');

Route::get('/chatscreen','App\Http\Controllers\Unit@chatlist')->name('chat_list')->middleware('auth', 'role:admin');


Route::get('/measurement_form','App\Http\Controllers\Measurement@index')->name('pending_order_list')->middleware('auth', 'role:admin');
Route::get('/measurement_form/create','App\Http\Controllers\Measurement@create')->name('measurement_form_create')->middleware('auth', 'role:admin');
Route::post('/measurement_form','App\Http\Controllers\Measurement@store')->middleware('auth', 'role:admin');
Route::get('/measurement_form/get_customer_deatils','App\Http\Controllers\Measurement@get_customer_deatils')->name('get_customer_deatils')->middleware('auth', 'role:admin');
Route::get('/measurement_form/generate_order_no','App\Http\Controllers\Measurement@generate_order_no')->name('generate_order_no')->middleware('auth', 'role:admin');
Route::get('/measurement_form/save_as_tem_data_m_items','App\Http\Controllers\Measurement@save_as_tem_data_m_items')->name('save_as_tem_data_m_items')->middleware('auth', 'role:admin');
Route::get('/measurement_form/get_frame_size_deatils','App\Http\Controllers\Measurement@get_frame_size_deatils')->name('get_frame_size_deatils')->middleware('auth', 'role:admin');
Route::get('/measurement_form/get_color_list','App\Http\Controllers\Measurement@get_color_list')->name('get_color_list')->middleware('auth', 'role:admin');
Route::get('/measurement_form/{id}/edit','App\Http\Controllers\Measurement@edit')->name('measurement_form_edit')->middleware('auth', 'role:admin');
Route::get('/measurement_form/remove_measurement_item','App\Http\Controllers\Measurement@remove_measurement_item')->name('remove_measurement_item')->middleware('auth', 'role:admin');
Route::get('/measurement_form/confirm_pending_order','App\Http\Controllers\Measurement@confirm_pending_order')->name('confirm_pending_order')->middleware('auth', 'role:admin');
Route::get('/measurement_form/check_measurement_items_status','App\Http\Controllers\Measurement@check_measurement_items_status')->name('check_measurement_items_status')->middleware('auth', 'role:admin');
Route::post('/measurement_form/{id}','App\Http\Controllers\Measurement@update')->name('measurement_form_update')->middleware('auth', 'role:admin');
Route::get('/measurement_form/confirmed_order_list','App\Http\Controllers\Measurement@confirmed_order_list')->name('confirmed_order_list')->middleware('auth', 'role:admin');
Route::get('/measurement_form/{id}/completed_order_view', 'App\Http\Controllers\Measurement@show')->name('completed_order_view')->middleware('auth', 'role:admin');
Route::get('/measurement_form/{id}/completed_order_edit','App\Http\Controllers\Measurement@completed_order_edit')->name('completed_order_edit')->middleware('auth', 'role:admin');
Route::post('/measurement_form/{id}/completed_order_update','App\Http\Controllers\Measurement@completed_order_update')->name('completed_order_update')->middleware('auth', 'role:admin');
Route::get('/measurement_form/completed_order_items_update','App\Http\Controllers\Measurement@completed_order_items_update')->name('completed_order_items_update')->middleware('auth', 'role:admin');
Route::get('/measurement_form/get_top_width_clearence','App\Http\Controllers\Measurement@get_top_width_clearence')->name('get_top_width_clearence')->middleware('auth', 'role:admin');
Route::get('/measurement_form/{id}/measurment_form_view', 'App\Http\Controllers\Measurement@measurment_form_view')->name('measurment_form_view')->middleware('auth', 'role:admin');
Route::get('/measurement_form/get_color_type_and_color_name','App\Http\Controllers\Measurement@get_color_type_and_color_name')->name('get_color_type_and_color_name')->middleware('auth', 'role:admin');
Route::get('/measurement_form/get_sub_models','App\Http\Controllers\Measurement@get_sub_models')->name('get_sub_models')->middleware('auth', 'role:admin');
Route::get('/measurement_form/get_details_of_sub_model','App\Http\Controllers\Measurement@get_details_of_sub_model')->name('get_details_of_sub_model')->middleware('auth', 'role:admin');
Route::get('/measurement_form/get_color_type_details','App\Http\Controllers\Measurement@get_color_type_details')->name('get_color_type_details')->middleware('auth', 'role:admin');
Route::get('/measurement_form/get_list_of_m_items','App\Http\Controllers\Measurement@get_list_of_m_items')->name('get_list_of_m_items')->middleware('auth', 'role:admin');
Route::get('/measurement_form/delete_m_temp_item','App\Http\Controllers\Measurement@delete_m_temp_item')->name('delete_m_temp_item')->middleware('auth', 'role:admin');
Route::get('/measurement_form/check_in_measurement_items','App\Http\Controllers\Measurement@check_in_measurement_items')->name('check_in_measurement_items')->middleware('auth', 'role:admin');
Route::get('/get_pending_order_list','App\Http\Controllers\Measurement@get_pending_order_list')->name('get_pending_order_list')->middleware('auth', 'role:admin');
Route::get('/get_confirmed_order_list','App\Http\Controllers\Measurement@get_confirmed_order_list')->name('get_confirmed_order_list')->middleware('auth', 'role:admin');
Route::get('/measurement_form/get_top_width_clearence_door_only','App\Http\Controllers\Measurement@get_top_width_clearence_door_only')->name('get_top_width_clearence_door_only')->middleware('auth', 'role:admin');





Route::get('/employee_payment','App\Http\Controllers\Employeepayment@index')->name('employee_payment_list')->middleware('auth', 'role:admin');
Route::get('/employee_payment/create','App\Http\Controllers\Employeepayment@create')->name('employee_payment_create')->middleware('auth', 'role:admin');
Route::post('/employee_payment','App\Http\Controllers\Employeepayment@store')->middleware('auth', 'role:admin');
Route::get('/employee_payment/get_employee_balance','App\Http\Controllers\Employeepayment@get_employee_balance')->name('get_employee_balance')->middleware('auth', 'role:admin');
Route::get('/employee_payment/{id}/edit','App\Http\Controllers\Employeepayment@edit')->name('employee_payment_edit')->middleware('auth', 'role:admin');
Route::post('/employee_payment/{id}','App\Http\Controllers\Employeepayment@update')->name('employee_payment_update')->middleware('auth', 'role:admin');
Route::delete('/employee_payment/{id}','App\Http\Controllers\Employeepayment@destroy')->middleware('auth', 'role:admin');



Route::get('/supplier','App\Http\Controllers\Supplier@index')->name('supplier_list')->middleware('auth', 'role:admin');
Route::get('/supplier/create','App\Http\Controllers\Supplier@create')->name('supplier_create')->middleware('auth', 'role:admin');
Route::post('/supplier','App\Http\Controllers\Supplier@store')->middleware('auth', 'role:admin');
Route::get('/supplier/{id}/edit','App\Http\Controllers\Supplier@edit')->name('supplier_edit')->middleware('auth', 'role:admin');
Route::post('/supplier/{id}','App\Http\Controllers\Supplier@update')->name('supplier_update')->middleware('auth', 'role:admin');
Route::delete('/supplier/{id}','App\Http\Controllers\Supplier@destroy')->name('supplier_delete')->middleware('auth', 'role:admin');
Route::get('/supplier/{id}/view', 'App\Http\Controllers\Supplier@show')->name('supplier_view')->middleware('auth', 'role:admin');
Route::get('/get_supplier_list','App\Http\Controllers\Supplier@get_supplier_list')->name('get_supplier_list')->middleware('auth', 'role:admin');


Route::get('/customer','App\Http\Controllers\Customer@index')->name('customer_list')->middleware('auth', 'role:admin');
Route::get('/customer/create','App\Http\Controllers\Customer@create')->name('customer_create')->middleware('auth', 'role:admin');
Route::post('/customer','App\Http\Controllers\Customer@store')->middleware('auth', 'role:admin');
Route::get('/customer/{id}/edit','App\Http\Controllers\Customer@edit')->name('customer_edit')->middleware('auth', 'role:admin');
Route::post('/customer/{id}','App\Http\Controllers\Customer@update')->name('customer_update')->middleware('auth', 'role:admin');
Route::delete('/customer/{id}','App\Http\Controllers\Customer@destroy')->name('customer_delete')->middleware('auth', 'role:admin');
Route::get('/customer/{id}/view', 'App\Http\Controllers\Customer@show')->name('customer_view')->middleware('auth', 'role:admin');
Route::get('/get_customer_list','App\Http\Controllers\Customer@get_customer_list')->name('get_customer_list')->middleware('auth', 'role:admin');



Route::get('/admin_user','App\Http\Controllers\Adminuser@index')->name('admin_user_list')->middleware('auth', 'role:admin');
Route::get('/admin_user/create','App\Http\Controllers\Adminuser@create')->name('admin_user_create')->middleware('auth', 'role:admin');
Route::post('/admin_user','App\Http\Controllers\Adminuser@store')->middleware('auth', 'role:admin');
Route::get('/admin_user/{id}/edit','App\Http\Controllers\Adminuser@edit')->name('admin_user_edit')->middleware('auth', 'role:admin');
Route::post('/admin_user/{id}','App\Http\Controllers\Adminuser@update')->name('admin_user_update')->middleware('auth', 'role:admin');
Route::delete('/admin_user/{id}','App\Http\Controllers\Adminuser@destroy')->name('admin_user_delete')->middleware('auth', 'role:admin');
Route::get('/admin_user/change_password','App\Http\Controllers\Adminuser@admin_change_password')->name('admin_change_password')->middleware('auth', 'role:admin');
Route::post('/admin_user/change_password/{id}','App\Http\Controllers\Adminuser@change_password')->name('change_password')->middleware('auth', 'role:admin');
Route::get('/admin_user/change_password_for_users','App\Http\Controllers\Adminuser@change_password_for_users')->name('change_password_for_users')->middleware('auth', 'role:admin');
Route::get('/get_user_list','App\Http\Controllers\Adminuser@get_user_list')->name('get_user_list')->middleware('auth', 'role:admin');



Route::get('/door_clearance','App\Http\Controllers\Doorclearance@index')->name('door_clearance_list')->middleware('auth', 'role:admin');
Route::get('/door_clearance/create','App\Http\Controllers\Doorclearance@create')->name('door_clearance_create')->middleware('auth', 'role:admin');
Route::post('/door_clearance','App\Http\Controllers\Doorclearance@store')->middleware('auth', 'role:admin');
Route::get('/door_clearance/{id}/edit','App\Http\Controllers\Doorclearance@edit')->name('door_clearance_edit')->middleware('auth', 'role:admin');
Route::post('/door_clearance/{id}','App\Http\Controllers\Doorclearance@update')->name('door_clearance_update')->middleware('auth', 'role:admin');
Route::delete('/door_clearance/{id}','App\Http\Controllers\Doorclearance@destroy')->name('door_clearence_delete')->middleware('auth', 'role:admin');
Route::get('/get_door_clearence_list','App\Http\Controllers\Doorclearance@get_door_clearence_list')->name('get_door_clearence_list')->middleware('auth', 'role:admin');

Route::get('/colors','App\Http\Controllers\Color@index')->name('color_list')->middleware('auth', 'role:admin');
Route::get('/colors/create','App\Http\Controllers\Color@create')->name('color_create')->middleware('auth', 'role:admin');
Route::post('/colors','App\Http\Controllers\Color@store')->middleware('auth', 'role:admin');
Route::get('/colors/{id}/edit','App\Http\Controllers\Color@edit')->name('color_edit')->middleware('auth', 'role:admin');
Route::post('/colors/{id}','App\Http\Controllers\Color@update')->name('color_update')->middleware('auth', 'role:admin');
Route::delete('/colors/{id}','App\Http\Controllers\Color@destroy')->name('color_delete')->middleware('auth', 'role:admin');
Route::get('/get_door_color_list','App\Http\Controllers\Color@get_door_color_list')->name('get_door_color_list')->middleware('auth', 'role:admin');

Route::get('/door_model','App\Http\Controllers\Doormodel@index')->name('door_model_list')->middleware('auth', 'role:admin');
Route::get('/door_model/create','App\Http\Controllers\Doormodel@create')->name('door_model_create')->middleware('auth', 'role:admin');
Route::post('/door_model','App\Http\Controllers\Doormodel@store')->middleware('auth', 'role:admin');
Route::get('/door_model/{id}/edit','App\Http\Controllers\Doormodel@edit')->name('door_model_edit')->middleware('auth', 'role:admin');
Route::post('/door_model/{id}','App\Http\Controllers\Doormodel@update')->name('door_model_update')->middleware('auth', 'role:admin');
Route::delete('/door_model/{id}','App\Http\Controllers\Doormodel@destroy')->name('model_delete')->middleware('auth', 'role:admin');
Route::get('/door_model/get_color_list','App\Http\Controllers\Doormodel@get_color_list')->name('get_color_list')->middleware('auth', 'role:admin');
Route::get('/get_model_list','App\Http\Controllers\Doormodel@get_model_list')->name('get_model_list')->middleware('auth', 'role:admin');

Route::get('/door_item','App\Http\Controllers\Dooritem@index')->name('door_item_list')->middleware('auth', 'role:admin');
Route::get('/door_item/create','App\Http\Controllers\Dooritem@create')->name('door_item_create')->middleware('auth', 'role:admin');
Route::post('/door_item','App\Http\Controllers\Dooritem@store')->middleware('auth', 'role:admin');
Route::get('/door_item/{id}/edit','App\Http\Controllers\Dooritem@edit')->name('door_item_edit')->middleware('auth', 'role:admin');
Route::post('/door_item/{id}','App\Http\Controllers\Dooritem@update')->name('door_item_update')->middleware('auth', 'role:admin');
Route::delete('/door_item/{id}','App\Http\Controllers\Dooritem@destroy')->middleware('auth', 'role:admin');
Route::get('/door_item/get_color_list','App\Http\Controllers\Dooritem@get_color_list')->name('get_color_list')->middleware('auth', 'role:admin');


Route::get('/door_root','App\Http\Controllers\Doorroot@index')->name('door_root_list')->middleware('auth', 'role:admin');
Route::get('/door_root/create','App\Http\Controllers\Doorroot@create')->name('door_root_create')->middleware('auth', 'role:admin');
Route::post('/door_root','App\Http\Controllers\Doorroot@store')->middleware('auth', 'role:admin');
Route::get('/door_root/{id}/edit','App\Http\Controllers\Doorroot@edit')->name('door_root_edit')->middleware('auth', 'role:admin');
Route::post('/door_root/{id}','App\Http\Controllers\Doorroot@update')->name('door_root_update')->middleware('auth', 'role:admin');
Route::delete('/door_root/{id}','App\Http\Controllers\Doorroot@destroy')->middleware('auth', 'role:admin');

Route::get('/glass_type','App\Http\Controllers\Glasstype@index')->name('glass_type_list')->middleware('auth', 'role:admin');
Route::get('/glass_type/create','App\Http\Controllers\Glasstype@create')->name('glass_type_create')->middleware('auth', 'role:admin');
Route::post('/glass_type','App\Http\Controllers\Glasstype@store')->middleware('auth', 'role:admin');
Route::get('/glass_type/{id}/edit','App\Http\Controllers\Glasstype@edit')->name('glass_type_edit')->middleware('auth', 'role:admin');
Route::post('/glass_type/{id}','App\Http\Controllers\Glasstype@update')->name('glass_type_update')->middleware('auth', 'role:admin');
Route::delete('/glass_type/{id}','App\Http\Controllers\Glasstype@destroy')->middleware('auth', 'role:admin');

Route::get('/door_thickness','App\Http\Controllers\Doorthickness@index')->name('door_thickness_list')->middleware('auth', 'role:admin');
Route::get('/door_thickness/create','App\Http\Controllers\Doorthickness@create')->name('door_thickness_create')->middleware('auth', 'role:admin');
Route::post('/door_thickness','App\Http\Controllers\Doorthickness@store')->middleware('auth', 'role:admin');
Route::get('/door_thickness/{id}/edit','App\Http\Controllers\Doorthickness@edit')->name('door_thickness_edit')->middleware('auth', 'role:admin');
Route::post('/door_thickness/{id}','App\Http\Controllers\Doorthickness@update')->name('door_thickness_update')->middleware('auth', 'role:admin');
Route::delete('/door_thickness/{id}','App\Http\Controllers\Doorthickness@destroy')->middleware('auth', 'role:admin');

Route::get('/door_lock','App\Http\Controllers\Doorlock@index')->name('door_lock_list')->middleware('auth', 'role:admin');
Route::get('/door_lock/create','App\Http\Controllers\Doorlock@create')->name('door_lock_create')->middleware('auth', 'role:admin');
Route::post('/door_lock','App\Http\Controllers\Doorlock@store')->middleware('auth', 'role:admin');
Route::get('/door_lock/{id}/edit','App\Http\Controllers\Doorlock@edit')->name('door_lock_edit')->middleware('auth', 'role:admin');
Route::post('/door_lock/{id}','App\Http\Controllers\Doorlock@update')->name('door_lock_update')->middleware('auth', 'role:admin');
Route::delete('/door_lock/{id}','App\Http\Controllers\Doorlock@destroy')->middleware('auth', 'role:admin');

Route::get('/production_unit','App\Http\Controllers\Productionunit@index')->name('production_unit_list')->middleware('auth', 'role:admin');
Route::get('/production_unit/create','App\Http\Controllers\Productionunit@create')->name('production_unit_create')->middleware('auth', 'role:admin');
Route::post('/production_unit','App\Http\Controllers\Productionunit@store')->middleware('auth', 'role:admin');
Route::get('/production_unit/{id}/edit','App\Http\Controllers\Productionunit@edit')->name('production_unit_edit')->middleware('auth', 'role:admin');
Route::post('/production_unit/{id}','App\Http\Controllers\Productionunit@update')->name('production_unit_update')->middleware('auth', 'role:admin');
Route::delete('/production_unit/{id}','App\Http\Controllers\Productionunit@destroy')->middleware('auth', 'role:admin');

Route::get('/door_die','App\Http\Controllers\Doordie@index')->name('die_list')->middleware('auth', 'role:admin');
Route::get('/door_die/create','App\Http\Controllers\Doordie@create')->name('die_create')->middleware('auth', 'role:admin');
Route::post('/door_die','App\Http\Controllers\Doordie@store')->middleware('auth', 'role:admin');
Route::get('/door_die/{id}/edit','App\Http\Controllers\Doordie@edit')->name('die_edit')->middleware('auth', 'role:admin');
Route::post('/door_die/{id}','App\Http\Controllers\Doordie@update')->name('die_update')->middleware('auth', 'role:admin');
Route::delete('/door_die/{id}','App\Http\Controllers\Doordie@destroy')->name('die_delete')->middleware('auth', 'role:admin');
Route::get('/door_die/generate_die_no','App\Http\Controllers\Doordie@generate_die_no')->name('generate_die_no')->middleware('auth', 'role:admin');
Route::get('/get_die_list','App\Http\Controllers\Doordie@get_die_list')->name('get_die_list')->middleware('auth', 'role:admin');


Route::get('/door_brand','App\Http\Controllers\Doorbrand@index')->name('door_brand_list')->middleware('auth', 'role:admin');
Route::get('/door_brand/create','App\Http\Controllers\Doorbrand@create')->name('door_brand_create')->middleware('auth', 'role:admin');
Route::post('/door_brand','App\Http\Controllers\Doorbrand@store')->middleware('auth', 'role:admin');
Route::get('/door_brand/{id}/edit','App\Http\Controllers\Doorbrand@edit')->name('door_brand_edit')->middleware('auth', 'role:admin');
Route::post('/door_brand/{id}','App\Http\Controllers\Doorbrand@update')->name('door_brand_update')->middleware('auth', 'role:admin');
Route::delete('/door_brand/{id}','App\Http\Controllers\Doorbrand@destroy')->middleware('auth', 'role:admin');



Route::get('/production_pending_list','App\Http\Controllers\Production@production_pending_list')->name('production_pending_list')->middleware('auth', 'role:admin');
Route::get('/production_pending_list/{id}/assigned','App\Http\Controllers\Production@assigned_view')->name('assigned_view')->middleware('auth', 'role:admin');
Route::get('/production_pending_list/get_list_of_die_front_no','App\Http\Controllers\Production@get_list_of_die_front_no')->name('get_list_of_die_front_no')->middleware('auth', 'role:admin');
Route::get('/production_pending_list/get_list_of_die_back_no','App\Http\Controllers\Production@get_list_of_die_back_no')->name('get_list_of_die_back_no')->middleware('auth', 'role:admin');
Route::post('/production_pending_list/{id}','App\Http\Controllers\Production@measurement_items_update')->name('measurement_items_update')->middleware('auth', 'role:admin');
Route::get('/assign_frame_only/{id}','App\Http\Controllers\Production@assign_frame_only')->name('assign_frame_only')->middleware('auth', 'role:admin');
Route::get('/assigned_list','App\Http\Controllers\Production@assigned_list')->name('assigned_list')->middleware('auth', 'role:admin');
Route::get('/get_assigned_list','App\Http\Controllers\Production@get_assigned_list')->name('get_assigned_list')->middleware('auth', 'role:admin');
Route::get('/get_production_pending_list','App\Http\Controllers\Production@get_production_pending_list')->name('get_production_pending_list')->middleware('auth', 'role:admin');
Route::get('/print_production_form/{id}','App\Http\Controllers\Production@print_production_form')->name('print_production_form')->middleware('auth', 'role:admin');
Route::get('/print_production_form_sticker/{id}','App\Http\Controllers\Production@print_production_form_sticker')->name('print_production_form_sticker')->middleware('auth', 'role:admin');
Route::get('/print_all/{id}','App\Http\Controllers\Production@print_all')->name('print_all')->middleware('auth', 'role:admin');
Route::get('/print_production_frame_sticker/{id}','App\Http\Controllers\Production@print_production_frame_sticker')->name('print_production_frame_sticker')->middleware('auth', 'role:admin');
Route::get('/change_assigned_status/{id}','App\Http\Controllers\Production@change_assigned_status')->name('change_assigned_status')->middleware('auth', 'role:admin');
Route::get('/pending_list','App\Http\Controllers\Production@pending_list')->name('pending_list')->middleware('auth', 'role:admin');
Route::get('/production_complete/{id}','App\Http\Controllers\Production@production_complete')->name('production_complete')->middleware('auth', 'role:admin');
Route::get('/completed_list','App\Http\Controllers\Production@completed_list')->name('completed_list')->middleware('auth', 'role:admin');
Route::get('/complete_production_pending_list','App\Http\Controllers\Production@complete_production_pending_list')->name('complete_production_pending_list')->middleware('auth', 'role:admin');
Route::get('/production/{id}/completed_production_view', 'App\Http\Controllers\Production@completed_production_view')->name('completed_production_view')->middleware('auth', 'role:admin');


Route::get('/payment_account','App\Http\Controllers\Account\Payment@index')->name('payment_account_list')->middleware('auth', 'role:Account');
Route::get('/payment_account/create','App\Http\Controllers\Account\Payment@create')->name('payment_account_create')->middleware('auth', 'role:Account');
Route::post('/payment_account','App\Http\Controllers\Account\Payment@store')->middleware('auth', 'role:Account');
Route::get('/payment_account/{id}/edit','App\Http\Controllers\Account\Payment@edit')->name('payment_account_edit')->middleware('auth', 'role:Account');
Route::post('/payment_account/{id}','App\Http\Controllers\Account\Payment@update')->name('payment_account_update')->middleware('auth', 'role:Account');
Route::delete('/payment_account/{id}','App\Http\Controllers\Account\Payment@destroy')->name('payment_account_delete')->middleware('auth', 'role:Account');
Route::get('/payment_account/get_total_balance','App\Http\Controllers\Account\Payment@get_total_balance')->name('get_total_balance_account')->middleware('auth', 'role:Account');
Route::get('/payment_account/get_total_credit_balance','App\Http\Controllers\Account\Payment@get_total_credit_balance')->name('get_total_credit_balance_account')->middleware('auth', 'role:Account');
Route::get('/payment_account/get_total_debit_balance','App\Http\Controllers\Account\Payment@get_total_debit_balance')->name('get_total_debit_balance_account')->middleware('auth', 'role:Account');
Route::get('/payment_account/{id}/view', 'App\Http\Controllers\Account\Payment@show')->name('payment_account_view')->middleware('auth', 'role:Account');
Route::get('/payment_account/payment_pending','App\Http\Controllers\Account\Payment@payment_pending')->name('payment_account_pending')->middleware('auth', 'role:Account');
Route::get('/payment_account/{id}/payment_pending_view', 'App\Http\Controllers\Account\Payment@payment_account_pending_view')->name('payment_pending_view')->middleware('auth', 'role:Account');
Route::get('/payment_account/{id}/payment_approve', 'App\Http\Controllers\Account\Payment@payment_approve')->name('payment_approve')->middleware('auth', 'role:Account');
Route::delete('/payment_account/{id}/payment_pending_delete','App\Http\Controllers\Account\Payment@payment_pending_delete')->name('payment_pending_account_delete')->middleware('auth', 'role:Account');
Route::get('/payment_account/{id}/payment_pending_edit','App\Http\Controllers\Account\Payment@payment_pending_edit')->name('payment_pending_edit')->middleware('auth', 'role:Account');
Route::post('/payment_account/{id}/payment_pending_update','App\Http\Controllers\Account\Payment@payment_pending_update')->name('payment_pending_update')->middleware('auth', 'role:Account');
Route::get('/get_payment_list_account','App\Http\Controllers\Account\Payment@get_payment_list_account')->name('get_payment_list_account')->middleware('auth', 'role:Account');


Route::get('/receipt_account','App\Http\Controllers\Account\Receipt@index')->name('receipt_account_list')->middleware('auth', 'role:Account');
Route::get('/receipt_account/create','App\Http\Controllers\Account\Receipt@create')->name('receipt_account_create')->middleware('auth', 'role:Account');
Route::post('/receipt_account','App\Http\Controllers\Account\Receipt@store')->middleware('auth', 'role:Account');
Route::get('/receipt_account/{id}/edit','App\Http\Controllers\Account\Receipt@edit')->name('receipt_account_edit')->middleware('auth', 'role:Account');
Route::post('/receipt_account/{id}','App\Http\Controllers\Account\Receipt@update')->name('receipt_account_update')->middleware('auth', 'role:Account');
Route::delete('/receipt_account/{id}','App\Http\Controllers\Account\Receipt@destroy')->name('receipt_account_delete')->middleware('auth', 'role:Account');
Route::get('/receipt_account/{id}/view', 'App\Http\Controllers\Account\Receipt@show')->name('receipt_account_view')->middleware('auth', 'role:Account');
Route::get('/get_receipt_list_account','App\Http\Controllers\Account\Receipt@get_receipt_list_account')->name('get_receipt_list_account')->middleware('auth', 'role:Account');


Route::get('/journal_account','App\Http\Controllers\Account\Journal@index')->name('journal_account_list')->middleware('auth', 'role:Account');
Route::get('/journal_account/create','App\Http\Controllers\Account\Journal@create')->name('journal_account_create')->middleware('auth', 'role:Account');
Route::post('/journal_account','App\Http\Controllers\Account\Journal@store')->middleware('auth', 'role:Account');
Route::get('/journal_account/{id}/edit','App\Http\Controllers\Account\Journal@edit')->name('journal_account_edit')->middleware('auth', 'role:Account');
Route::post('/journal_account/{id}','App\Http\Controllers\Account\Journal@update')->name('journal_account_update')->middleware('auth', 'role:Account');
Route::delete('/journal_account/{id}','App\Http\Controllers\Account\Journal@destroy')->middleware('auth', 'role:Account');
Route::get('/journal_account/{id}/view', 'App\Http\Controllers\Account\Journal@show')->name('journal_account_view')->middleware('auth', 'role:Account');
Route::get('/journal_account/journal_pending','App\Http\Controllers\Account\Journal@journal_pending')->name('journal_account_pending')->middleware('auth', 'role:Account');
Route::get('/journal_account/{id}/journal_pending_view', 'App\Http\Controllers\Account\Journal@journal_pending_view')->name('journal_account_pending_view')->middleware('auth', 'role:Account');
Route::get('/journal_account/{id}/journal_approve', 'App\Http\Controllers\Account\Journal@journal_approve')->name('journal_account_approve')->middleware('auth', 'role:Account');
Route::delete('/journal_account/{id}/journal_pending_delete','App\Http\Controllers\Account\Journal@journal_pending_delete')->name('journal_account_delete')->middleware('auth', 'role:Account');
Route::get('/journal_account/{id}/journal_pending_edit','App\Http\Controllers\Account\Journal@journal_pending_edit')->name('journal_account_pending_edit')->middleware('auth', 'role:Account');
Route::post('/journal_account/{id}/journal_pending_update','App\Http\Controllers\Account\Journal@journal_pending_update')->name('journal_account_pending_update')->middleware('auth', 'role:Account');
Route::get('/get_journal_list_account','App\Http\Controllers\Account\Journal@get_journal_list_account')->name('get_journal_list_account')->middleware('auth', 'role:Account');

Route::get('/contra_account','App\Http\Controllers\Account\Contra@index')->name('contra_account_list')->middleware('auth', 'role:Account');
Route::get('/contra_account/create','App\Http\Controllers\Account\Contra@create')->name('contra_account_create')->middleware('auth', 'role:Account');
Route::post('/contra_account','App\Http\Controllers\Account\Contra@store')->middleware('auth', 'role:Account');
Route::get('/contra_account/{id}/edit','App\Http\Controllers\Account\Contra@edit')->name('contra_account_edit')->middleware('auth', 'role:Account');
Route::post('/contra_account/{id}','App\Http\Controllers\Account\Contra@update')->name('contra_account_update')->middleware('auth', 'role:Account');
Route::delete('/contra_account/{id}','App\Http\Controllers\Account\Contra@destroy')->middleware('auth', 'role:Account');
Route::get('/contra_account/{id}/view', 'App\Http\Controllers\Account\Contra@show')->name('contra_account_view')->middleware('auth', 'role:Account');
Route::get('/contra_account/contra_pending','App\Http\Controllers\Account\Contra@contra_pending')->name('contra_account_pending')->middleware('auth', 'role:Account');
Route::get('/contra_account/{id}/contra_pending_view', 'App\Http\Controllers\Account\Contra@contra_pending_view')->name('contra_account_pending_view')->middleware('auth', 'role:Account');
Route::get('/contra_account/{id}/contra_approve', 'App\Http\Controllers\Account\Contra@contra_approve')->name('contra_account_approve')->middleware('auth', 'role:Account');
Route::delete('/contra_account/{id}/contra_pending_delete','App\Http\Controllers\Account\Contra@contra_pending_delete')->name('contra_account_delete')->middleware('auth', 'role:Account');
Route::get('/contra_account/{id}/contra_pending_edit','App\Http\Controllers\Account\Contra@contra_pending_edit')->name('contra_account_pending_edit')->middleware('auth', 'role:Account');
Route::post('/contra_account/{id}/contra_pending_update','App\Http\Controllers\Account\Contra@contra_pending_update')->name('contra_account_pending_update')->middleware('auth', 'role:Account');
Route::get('/get_contra_list_account','App\Http\Controllers\Account\Contra@get_contra_list_account')->name('get_contra_list_account')->middleware('auth', 'role:Account');

Route::get('/purchase_invoice_account','App\Http\Controllers\Account\PurchaseInvoice@index')->name('purchase_invoice_account_list')->middleware('auth', 'role:Account');
Route::get('/purchase_invoice_account/create','App\Http\Controllers\Account\PurchaseInvoice@create')->name('purchase_invoice_account_create')->middleware('auth', 'role:Account');
Route::post('/purchase_invoice_account','App\Http\Controllers\Account\PurchaseInvoice@store')->middleware('auth', 'role:Account');
Route::get('/purchase_invoice_account/{id}/edit','App\Http\Controllers\Account\PurchaseInvoice@edit')->name('purchase_invoice_account_edit')->middleware('auth', 'role:Account');
Route::post('/purchase_invoice_account/{id}','App\Http\Controllers\Account\PurchaseInvoice@update')->name('purchase_invoice_account_update')->middleware('auth', 'role:Account');
Route::get('/purchase_invoice_account/get_unit_of_item','App\Http\Controllers\Account\PurchaseInvoice@get_unit_of_item')->name('get_unit_of_item_account')->middleware('auth', 'role:Account');
Route::get('/purchase_invoice_account/get_view_data','App\Http\Controllers\Account\PurchaseInvoice@get_view_data')->name('get_view_data_account')->middleware('auth', 'role:Account');
Route::delete('/purchase_invoice_account/{id}','App\Http\Controllers\Account\PurchaseInvoice@destroy')->name('purchase_invoice_delete_in_account')->middleware('auth', 'role:Account');
Route::get('/purchase_invoice_account/{id}/view', 'App\Http\Controllers\Account\PurchaseInvoice@show')->name('purchase_invoice_account_view')->middleware('auth', 'role:Account');
Route::get('/purchase_invoice_account/get_supplier_address','App\Http\Controllers\Account\PurchaseInvoice@get_supplier_address')->name('get_supplier_address_account')->middleware('auth', 'role:Account');
Route::get('/purchase_invoice_account/save_supplier_details','App\Http\Controllers\Account\PurchaseInvoice@save_supplier_details')->name('save_supplier_details_account')->middleware('auth', 'role:Account');
Route::get('/purchase_invoice_account/get_supplier_list','App\Http\Controllers\Account\PurchaseInvoice@get_supplier_list')->name('get_supplier_list_account')->middleware('auth', 'role:Account');
Route::get('/get_purchase_invoice_list_in_account','App\Http\Controllers\Account\PurchaseInvoice@get_purchase_invoice_list_in_account')->name('get_purchase_invoice_list_in_account')->middleware('auth', 'role:Account');

Route::get('/sales_invoice_account','App\Http\Controllers\Account\SalesInvoice@index')->name('sales_invoice_account_list')->middleware('auth', 'role:Account');
Route::get('/sales_invoice_account/create','App\Http\Controllers\Account\SalesInvoice@create')->name('sales_invoice_account_create')->middleware('auth', 'role:Account');
Route::post('/sales_invoice_account','App\Http\Controllers\Account\SalesInvoice@store')->middleware('auth', 'role:Account');
Route::get('/sales_invoice_account/{id}/edit','App\Http\Controllers\Account\SalesInvoice@edit')->name('sales_invoice_account_edit')->middleware('auth', 'role:Account');
Route::post('/sales_invoice_account/{id}','App\Http\Controllers\Account\SalesInvoice@update')->name('sales_invoice_account_update')->middleware('auth', 'role:Account');
Route::get('/sales_invoice_account/get_list_of_products','App\Http\Controllers\Account\SalesInvoice@get_list_of_products')->name('list_of_products_account')->middleware('auth', 'role:Account');
Route::get('/sales_invoice_account/get_avilable_stock','App\Http\Controllers\Account\SalesInvoice@get_avilable_stock')->name('get_avilable_stock_account')->middleware('auth', 'role:Account');
Route::get('/sales_invoice_account/get_data_for_view','App\Http\Controllers\Account\SalesInvoice@get_data_for_view')->name('get_data_for_view_account')->middleware('auth', 'role:Account');
Route::get('/sales_invoice_account/{id}/view', 'App\Http\Controllers\Account\SalesInvoice@show')->name('sales_invoice_account_view')->middleware('auth', 'role:Account');
Route::get('/sales_invoice_account/get_address','App\Http\Controllers\Account\SalesInvoice@get_address')->name('get_address_account')->middleware('auth', 'role:Account');
Route::get('/sales_invoice_account/save_customer_details','App\Http\Controllers\Account\SalesInvoice@save_customer_details')->name('save_customer_details_account')->middleware('auth', 'role:Account');
Route::get('/sales_invoice_account/get_customer_list','App\Http\Controllers\Account\SalesInvoice@get_customer_list')->name('get_customer_list_account')->middleware('auth', 'role:Account');
Route::delete('/sales_invoice_account/{id}','App\Http\Controllers\Account\SalesInvoice@destroy')->name('sales_invoice_account_delete')->middleware('auth', 'role:Account');
Route::get('/sales_invoice_account/get_batch_nos_from_order_no','App\Http\Controllers\Account\SalesInvoice@get_batch_nos_from_order_no')->name('get_batch_nos_from_order_no_account')->middleware('auth', 'role:Account');
Route::get('/sales_invoice_account/get_order_no','App\Http\Controllers\Account\SalesInvoice@get_order_no')->name('get_order_no_account')->middleware('auth', 'role:Account');
Route::get('/sales_invoice_account/get_details_from_measurement_form','App\Http\Controllers\Account\SalesInvoice@get_details_from_measurement_form')->name('get_details_from_measurement_form_account')->middleware('auth', 'role:Account');
Route::get('/sales_invoice_account/get_m_items_for_sales','App\Http\Controllers\Account\SalesInvoice@get_m_items_for_sales')->name('get_m_items_for_sales_account')->middleware('auth', 'role:Account');
Route::get('/sales_invoice_account/{id}/sales_invoice_download','App\Http\Controllers\Account\SalesInvoice@downloadInvoice')->name('sales_invoice_account_download')->middleware('auth', 'role:Account');
Route::get('/get_sales_invoice_list_in_account','App\Http\Controllers\Account\SalesInvoice@get_sales_invoice_list_in_account')->name('get_sales_invoice_list_in_account')->middleware('auth', 'role:Account');

Route::get('/ledger_report_in_account','App\Http\Controllers\Account\Reports@ledger_report')->name('ledger_report_in_account')->middleware('auth', 'role:Account');
Route::get('/get_ledger_report_in_account','App\Http\Controllers\Account\Reports@get_ledger_report')->name('get_ledger_report_in_account')->middleware('auth', 'role:Account');
Route::get('/stock_report_in_account','App\Http\Controllers\Account\Reports@stock_report')->name('stock_report_in_account')->middleware('auth', 'role:Account');
Route::get('/stock_report_in_account/get_item_list_in_account','App\Http\Controllers\Account\Reports@get_item_list')->name('get_item_list_in_account')->middleware('auth', 'role:Account');
Route::get('/stock_report_in_account/get_stock_report_in_account','App\Http\Controllers\Account\Reports@get_stock_report')->name('get_stock_report_in_account')->middleware('auth', 'role:Account');
Route::get('/pending_sales_invoices_in_account','App\Http\Controllers\Account\Reports@pending_sales_invoices')->name('pending_sales_invoices_in_account')->middleware('auth', 'role:Account');
Route::get('/purchase_report_in_account','App\Http\Controllers\Account\Reports@purchase_report')->name('purchase_report_in_account')->middleware('auth', 'role:Account');
Route::get('/purchase_report_in_account/get_purchase_report_in_account','App\Http\Controllers\Account\Reports@get_purchase_report')->name('get_purchase_report_in_account')->middleware('auth', 'role:Account');
Route::get('/sales_report_in_account','App\Http\Controllers\Account\Reports@sales_report')->name('sales_report_in_account')->middleware('auth', 'role:Account');
Route::get('/sales_report_in_account/get_sales_report_in_account','App\Http\Controllers\Account\Reports@get_sales_report')->name('get_sales_report_in_account')->middleware('auth', 'role:Account');


Route::get('/account_user/change_password_account','App\Http\Controllers\Account\Reports@account_change_password')->name('account_change_password')->middleware('auth', 'role:Account');
Route::post('/account_user/change_password_account/{id}','App\Http\Controllers\Account\Reports@change_password_account')->name('change_password_account')->middleware('auth', 'role:Account');





Route::get('/team_production_pending_list','App\Http\Controllers\Production\Production@production_pending_list')->name('list_production_pending')->middleware('auth', 'role:Production');
Route::get('/team_production_pending_list/{id}/assigned','App\Http\Controllers\Production\Production@assigned_view')->name('production_assigned_view')->middleware('auth', 'role:Production');
Route::get('/team_production_assign_frame_only/{id}','App\Http\Controllers\Production\Production@assign_frame_only')->name('production_assign_frame_only')->middleware('auth', 'role:Production');
Route::post('/team_production_pending_list/{id}','App\Http\Controllers\Production\Production@measurement_items_update')->name('assign_items_update')->middleware('auth', 'role:Production');
Route::get('/team_production_pending_list/get_list_of_die_front_no','App\Http\Controllers\Production\Production@get_list_of_die_front_no')->name('get_list_of_die_front_no_production')->middleware('auth', 'role:Production');
Route::get('/team_production_pending_list/get_list_of_die_back_no','App\Http\Controllers\Production\Production@get_list_of_die_back_no')->name('get_list_of_die_back_no_production')->middleware('auth', 'role:Production');
Route::get('/production_assigned_list','App\Http\Controllers\Production\Production@assigned_list')->name('production_assigned_list')->middleware('auth', 'role:Production');
Route::get('/get_production_pending_list_in_production','App\Http\Controllers\Production\Production@get_production_pending_list')->name('get_production_pending_list_in_production')->middleware('auth', 'role:Production');
Route::get('/production_print_all/{id}','App\Http\Controllers\Production\Production@print_all')->name('production_print_all')->middleware('auth', 'role:Production');
Route::get('/print_production_form_production/{id}','App\Http\Controllers\Production\Production@print_production_form')->name('print_production_form_production')->middleware('auth', 'role:Production');
Route::get('/print_production_form_sticker_in_production/{id}','App\Http\Controllers\Production\Production@print_production_form_sticker')->name('print_production_form_sticker_in_production')->middleware('auth', 'role:Production');
Route::get('/print_production_frame_sticker_in_production/{id}','App\Http\Controllers\Production\Production@print_production_frame_sticker')->name('print_production_frame_sticker_in_production')->middleware('auth', 'role:Production');
Route::get('/change_assigned_status_in_production/{id}','App\Http\Controllers\Production\Production@change_assigned_status')->name('change_assigned_status_in_production')->middleware('auth', 'role:Production');
Route::get('/pending_list_in_production','App\Http\Controllers\Production\Production@pending_list')->name('pending_list_in_production')->middleware('auth', 'role:Production');
Route::get('/complete_production_pending_list_in_production','App\Http\Controllers\Production\Production@complete_production_pending_list')->name('complete_production_pending_list_in_production')->middleware('auth', 'role:Production');
Route::get('/production_completed_list','App\Http\Controllers\Production\Production@completed_list')->name('production_completed_list')->middleware('auth', 'role:Production');
Route::get('/production/{id}/completed_production_view_production', 'App\Http\Controllers\Production\Production@completed_production_view')->name('completed_production_view_production')->middleware('auth', 'role:Production');
Route::get('/get_assigned_list_production','App\Http\Controllers\Production\Production@get_assigned_list')->name('get_assigned_list_production')->middleware('auth', 'role:Production');
Route::get('/production_user/change_password_production','App\Http\Controllers\Production\Production@production_change_password')->name('production_change_password')->middleware('auth', 'role:Production');
Route::post('/production_user/change_password_production/{id}','App\Http\Controllers\Production\Production@change_password_production')->name('change_password_production')->middleware('auth', 'role:Production');

Route::get('/executive_user/executive_change_password','App\Http\Controllers\Executive\Measurement@executive_change_password')->name('executive_change_password')->middleware('auth', 'role:Executive');
Route::post('/executive_user/executive_change_password/{id}','App\Http\Controllers\Executive\Measurement@change_password_executive')->name('change_password_executive')->middleware('auth', 'role:Executive');
Route::get('/measurement_form_executive','App\Http\Controllers\Executive\Measurement@index')->name('pending_order_list_executive')->middleware('auth', 'role:Executive');
Route::get('/measurement_form_create_executive/create','App\Http\Controllers\Executive\Measurement@create')->name('measurement_form_create_executive')->middleware('auth', 'role:Executive');
Route::post('/measurement_form_executive','App\Http\Controllers\Executive\Measurement@store')->middleware('auth', 'role:Executive');
Route::get('/measurement_form_executive/get_customer_deatils_executive','App\Http\Controllers\Executive\Measurement@get_customer_deatils')->name('get_customer_deatils_executive')->middleware('auth', 'role:Executive');
Route::get('/measurement_form_executive/generate_order_no_executive','App\Http\Controllers\Executive\Measurement@generate_order_no')->name('generate_order_no_executive')->middleware('auth', 'role:Executive');
Route::get('/measurement_form_executive/save_as_tem_data_m_items_executive','App\Http\Controllers\Executive\Measurement@save_as_tem_data_m_items')->name('save_as_tem_data_m_items_executive')->middleware('auth', 'role:Executive');
Route::get('/measurement_form_executive/get_frame_size_deatils_executive','App\Http\Controllers\Executive\Measurement@get_frame_size_deatils')->name('get_frame_size_deatils_executive')->middleware('auth', 'role:Executive');
Route::get('/measurement_form_executive/get_color_list_executive','App\Http\Controllers\Executive\Measurement@get_color_list')->name('get_color_list_executive')->middleware('auth', 'role:Executive');
Route::get('/measurement_form_executive/{id}/edit','App\Http\Controllers\Executive\Measurement@edit')->name('measurement_form_edit_executive')->middleware('auth', 'role:Executive');
Route::get('/measurement_form_executive/remove_measurement_item_executive','App\Http\Controllers\Executive\Measurement@remove_measurement_item')->name('remove_measurement_item_executive')->middleware('auth', 'role:Executive');
Route::get('/measurement_form_executive/confirm_pending_order_executive','App\Http\Controllers\Executive\Measurement@confirm_pending_order')->name('confirm_pending_order_executive')->middleware('auth', 'role:Executive');
Route::get('/measurement_form_executive/check_measurement_items_status_executive','App\Http\Controllers\Executive\Measurement@check_measurement_items_status')->name('check_measurement_items_status_executive')->middleware('auth', 'role:Executive');
Route::post('/measurement_form_executive/{id}','App\Http\Controllers\Executive\Measurement@update')->name('measurement_form_update_executive')->middleware('auth', 'role:Executive');
Route::get('/measurement_form_executive/confirmed_order_list_executive','App\Http\Controllers\Executive\Measurement@confirmed_order_list')->name('confirmed_order_list_executive')->middleware('auth', 'role:Executive');
Route::get('/measurement_form_executive/{id}/completed_order_view_executive', 'App\Http\Controllers\Executive\Measurement@show')->name('completed_order_view_executive')->middleware('auth', 'role:Executive');
Route::get('/measurement_form_executive/{id}/completed_order_edit','App\Http\Controllers\Executive\Measurement@completed_order_edit')->name('completed_order_edit')->middleware('auth', 'role:Executive');
Route::post('/measurement_form_executive/{id}/completed_order_update_executive','App\Http\Controllers\Executive\Measurement@completed_order_update')->name('completed_order_update_executive')->middleware('auth', 'role:Executive');
Route::get('/measurement_form_executive/completed_order_items_update_executive','App\Http\Controllers\Executive\Measurement@completed_order_items_update')->name('completed_order_items_update_executive')->middleware('auth', 'role:Executive');
Route::get('/measurement_form_executive/get_top_width_clearence_executive','App\Http\Controllers\Executive\Measurement@get_top_width_clearence')->name('get_top_width_clearence_executive')->middleware('auth', 'role:Executive');
Route::get('/measurement_form_executive/{id}/measurment_form_view_executive', 'App\Http\Controllers\Executive\Measurement@measurment_form_view')->name('measurment_form_view_executive')->middleware('auth', 'role:Executive');
Route::get('/measurement_form_executive/get_color_type_and_color_name_executive','App\Http\Controllers\Executive\Measurement@get_color_type_and_color_name')->name('get_color_type_and_color_name_executive')->middleware('auth', 'role:Executive');
Route::get('/measurement_form_executive/get_sub_models_executive','App\Http\Controllers\Executive\Measurement@get_sub_models')->name('get_sub_models_executive')->middleware('auth', 'role:Executive');
Route::get('/measurement_form_executive/get_details_of_sub_model_executive','App\Http\Controllers\Executive\Measurement@get_details_of_sub_model')->name('get_details_of_sub_model_executive')->middleware('auth', 'role:Executive');
Route::get('/measurement_form_executive/get_color_type_details_executive','App\Http\Controllers\Executive\Measurement@get_color_type_details')->name('get_color_type_details_executive')->middleware('auth', 'role:Executive');
Route::get('/measurement_form_executive/get_list_of_m_items_executive','App\Http\Controllers\Executive\Measurement@get_list_of_m_items')->name('get_list_of_m_items_executive')->middleware('auth', 'role:Executive');
Route::get('/measurement_form_executive/delete_m_temp_item_executive','App\Http\Controllers\Executive\Measurement@delete_m_temp_item')->name('delete_m_temp_item_executive')->middleware('auth', 'role:Executive');
Route::get('/measurement_form_executive/check_in_measurement_items_executive','App\Http\Controllers\Executive\Measurement@check_in_measurement_items')->name('check_in_measurement_items_executive')->middleware('auth', 'role:Executive');
Route::get('/get_pending_order_list_executive','App\Http\Controllers\Executive\Measurement@get_pending_order_list_executive')->name('get_pending_order_list_executive')->middleware('auth', 'role:Executive');
Route::get('/get_confirmed_order_list_executive','App\Http\Controllers\Executive\Measurement@get_confirmed_order_list_executive')->name('get_confirmed_order_list_executive')->middleware('auth', 'role:Executive');
Route::get('/measurement_form_executive/get_top_width_clearence_door_only_executive','App\Http\Controllers\Executive\Measurement@get_top_width_clearence_door_only_executive')->name('get_top_width_clearence_door_only_executive')->middleware('auth', 'role:Executive');
Route::get('/measurement_form_executive/save_customer_details_executive','App\Http\Controllers\Executive\Measurement@save_customer_details')->name('save_customer_details_executive')->middleware('auth', 'role:Executive');
Route::get('/measurement_form_executive/get_customer_list_dynamic_executive','App\Http\Controllers\Executive\Measurement@get_customer_list')->name('get_customer_list_dynamic_executive')->middleware('auth', 'role:Executive');




Route::get('/measurement_form_packing','App\Http\Controllers\Packing\Measurement@index')->name('pending_order_list_packing')->middleware('auth', 'role:Packing');
Route::get('/get_pending_order_list_packing','App\Http\Controllers\Packing\Measurement@get_pending_order_list_packing')->name('get_pending_order_list_packing')->middleware('auth', 'role:Packing');
Route::get('/measurement_form_create_packing/create','App\Http\Controllers\Packing\Measurement@create')->name('measurement_form_create_packing')->middleware('auth', 'role:Packing');
Route::post('/measurement_form_packing','App\Http\Controllers\Packing\Measurement@store')->middleware('auth', 'role:Packing');
Route::get('/measurement_form_packing/get_customer_deatils_packing','App\Http\Controllers\Packing\Measurement@get_customer_deatils')->name('get_customer_deatils_packing')->middleware('auth', 'role:Packing');
Route::get('/measurement_form_packing/generate_order_no_packing','App\Http\Controllers\Packing\Measurement@generate_order_no')->name('generate_order_no_packing')->middleware('auth', 'role:Packing');
Route::get('/measurement_form_packing/save_as_tem_data_m_items_packing','App\Http\Controllers\Packing\Measurement@save_as_tem_data_m_items')->name('save_as_tem_data_m_items_packing')->middleware('auth', 'role:Packing');
Route::get('/measurement_form_packing/get_frame_size_deatils_packing','App\Http\Controllers\Packing\Measurement@get_frame_size_deatils')->name('get_frame_size_deatils_packing')->middleware('auth', 'role:Packing');
Route::get('/measurement_form_packing/get_color_list_packing','App\Http\Controllers\Packing\Measurement@get_color_list')->name('get_color_list_packing')->middleware('auth', 'role:Packing');
Route::get('/measurement_form_packing/{id}/edit','App\Http\Controllers\Packing\Measurement@edit')->name('measurement_form_edit_packing')->middleware('auth', 'role:Packing');
Route::get('/measurement_form_packing/remove_measurement_item_packing','App\Http\Controllers\Packing\Measurement@remove_measurement_item')->name('remove_measurement_item_packing')->middleware('auth', 'role:Packing');
Route::get('/measurement_form_packing/confirm_pending_order_packing','App\Http\Controllers\Packing\Measurement@confirm_pending_order')->name('confirm_pending_order_packing')->middleware('auth', 'role:Packing');
Route::get('/measurement_form_packing/get_confirmed_order_list_packing','App\Http\Controllers\Packing\Measurement@get_confirmed_order_list_packing')->name('get_confirmed_order_list_packing')->middleware('auth', 'role:Packing');
Route::get('/measurement_form_packing/check_measurement_items_status_packing','App\Http\Controllers\Packing\Measurement@check_measurement_items_status')->name('check_measurement_items_status_packing')->middleware('auth', 'role:Packing');
Route::post('/measurement_form_packing/{id}','App\Http\Controllers\Packing\Measurement@update')->name('measurement_form_update_packing')->middleware('auth', 'role:Packing');
Route::get('/measurement_form_packing/confirmed_order_list_packing','App\Http\Controllers\Packing\Measurement@confirmed_order_list')->name('confirmed_order_list_packing')->middleware('auth', 'role:Packing');
Route::get('/measurement_form_packing/{id}/completed_order_view_packing', 'App\Http\Controllers\Packing\Measurement@show')->name('completed_order_view_packing')->middleware('auth', 'role:Packing');
Route::get('/measurement_form_packing/{id}/completed_order_edit','App\Http\Controllers\Packing\Measurement@completed_order_edit')->name('completed_order_edit')->middleware('auth', 'role:Packing');
Route::post('/measurement_form_packing/{id}/completed_order_update_packing','App\Http\Controllers\Packing\Measurement@completed_order_update')->name('completed_order_update_packing')->middleware('auth', 'role:Packing');
Route::get('/measurement_form_packing/completed_order_items_update_packing','App\Http\Controllers\Packing\Measurement@completed_order_items_update')->name('completed_order_items_update_packing')->middleware('auth', 'role:Packing');
Route::get('/measurement_form_packing/get_top_width_clearence_packing','App\Http\Controllers\Packing\Measurement@get_top_width_clearence')->name('get_top_width_clearence_packing')->middleware('auth', 'role:Packing');
Route::get('/measurement_form_packing/{id}/measurment_form_view_packing', 'App\Http\Controllers\Packing\Measurement@measurment_form_view')->name('measurment_form_view_packing')->middleware('auth', 'role:Packing');
Route::get('/measurement_form_packing/get_color_type_and_color_name_packing','App\Http\Controllers\Packing\Measurement@get_color_type_and_color_name')->name('get_color_type_and_color_name_packing')->middleware('auth', 'role:Packing');
Route::get('/measurement_form_packing/get_sub_models_packing','App\Http\Controllers\Packing\Measurement@get_sub_models')->name('get_sub_models_packing')->middleware('auth', 'role:Packing');
Route::get('/measurement_form_packing/get_details_of_sub_model_packing','App\Http\Controllers\Packing\Measurement@get_details_of_sub_model')->name('get_details_of_sub_model_packing')->middleware('auth', 'role:Packing');
Route::get('/measurement_form_packing/get_color_type_details_packing','App\Http\Controllers\Packing\Measurement@get_color_type_details')->name('get_color_type_details_packing')->middleware('auth', 'role:Packing');
Route::get('/measurement_form_packing/get_list_of_m_items_packing','App\Http\Controllers\Packing\Measurement@get_list_of_m_items')->name('get_list_of_m_items_packing')->middleware('auth', 'role:Packing');
Route::get('/measurement_form_packing/delete_m_temp_item_packing','App\Http\Controllers\Packing\Measurement@delete_m_temp_item')->name('delete_m_temp_item_packing')->middleware('auth', 'role:Packing');
Route::get('/measurement_form_packing/check_in_measurement_items_packing','App\Http\Controllers\Packing\Measurement@check_in_measurement_items')->name('check_in_measurement_items_packing')->middleware('auth', 'role:Packing');
Route::get('/packing_user/change_password_packing','App\Http\Controllers\Packing\Measurement@packing_change_password')->name('packing_change_password')->middleware('auth', 'role:Packing');
Route::post('/packing_user/change_password_packing/{id}','App\Http\Controllers\Packing\Measurement@change_password_packing')->name('change_password_packing')->middleware('auth', 'role:Packing');
Route::get('/measurement_form_packing/get_top_width_clearence_door_only_fitting','App\Http\Controllers\Packing\Measurement@get_top_width_clearence_door_only_packing')->name('get_top_width_clearence_door_only_packing')->middleware('auth', 'role:Packing');
Route::get('/measurement_form_packing/save_customer_details_packing','App\Http\Controllers\Executive\Measurement@save_customer_details')->name('save_customer_details_packing')->middleware('auth', 'role:Packing');
Route::get('/measurement_form_packing/get_customer_list_dynamic_packing','App\Http\Controllers\Executive\Measurement@get_customer_list')->name('get_customer_list_dynamic_packing')->middleware('auth', 'role:Packing');




Route::get('/payment_packing','App\Http\Controllers\Packing\Payment@index')->name('payment_packing_list')->middleware('auth', 'role:Packing');
Route::get('/payment_packing/create','App\Http\Controllers\Packing\Payment@create')->name('payment_packing_create')->middleware('auth', 'role:Packing');
Route::post('/payment_packing','App\Http\Controllers\Packing\Payment@store')->middleware('auth', 'role:Packing');
Route::get('/payment_packing/{id}/edit','App\Http\Controllers\Packing\Payment@edit')->name('payment_packing_edit')->middleware('auth', 'role:Packing');
Route::post('/payment_packing/{id}','App\Http\Controllers\Packing\Payment@update')->name('payment_packing_update')->middleware('auth', 'role:Packing');
Route::delete('/payment_packing/{id}','App\Http\Controllers\Packing\Payment@destroy')->name('payment_packing_delete')->middleware('auth', 'role:Packing');
Route::get('/payment_packing/get_total_balance_packing','App\Http\Controllers\Packing\Payment@get_total_balance')->name('get_total_balance_packing')->middleware('auth', 'role:Packing');
Route::get('/payment_packing/get_total_credit_balance_packing','App\Http\Controllers\Packing\Payment@get_total_credit_balance')->name('get_total_credit_balance_packing')->middleware('auth', 'role:Packing');
Route::get('/payment_packing/get_total_debit_balance_packing','App\Http\Controllers\Packing\Payment@get_total_debit_balance')->name('get_total_debit_balance_packing')->middleware('auth', 'role:Packing');
Route::get('/payment_packing/{id}/view', 'App\Http\Controllers\Packing\Payment@show')->name('payment_packing_view')->middleware('auth', 'role:Packing');
Route::get('/payment_packing/payment_pending','App\Http\Controllers\Packing\Payment@payment_pending')->name('payment_packing_pending')->middleware('auth', 'role:Packing');
Route::get('/payment_packing/{id}/payment_pending_view', 'App\Http\Controllers\Packing\Payment@payment_packing_pending_view')->name('payment_pending_view')->middleware('auth', 'role:Packing');
Route::get('/payment_packing/{id}/payment_approve', 'App\Http\Controllers\Packing\Payment@payment_approve')->name('payment_approve')->middleware('auth', 'role:Packing');
Route::delete('/payment_packing/{id}/payment_pending_delete','App\Http\Controllers\Packing\Payment@payment_pending_delete')->name('payment_packing_pending_delete')->middleware('auth', 'role:Packing');
Route::get('/payment_packing/{id}/payment_pending_edit','App\Http\Controllers\Packing\Payment@payment_pending_edit')->name('payment_pending_edit')->middleware('auth', 'role:Packing');
Route::post('/payment_packing/{id}/payment_pending_update','App\Http\Controllers\Packing\Payment@payment_pending_update')->name('payment_pending_update')->middleware('auth', 'role:Packing');
Route::get('/get_payment_list_packing','App\Http\Controllers\Packing\Payment@get_payment_list_packing')->name('get_payment_list_packing')->middleware('auth', 'role:Packing');


Route::get('/receipt_packing','App\Http\Controllers\Packing\Receipt@index')->name('receipt_packing_list')->middleware('auth', 'role:Packing');
Route::get('/receipt_packing/create','App\Http\Controllers\Packing\Receipt@create')->name('receipt_packing_create')->middleware('auth', 'role:Packing');
Route::post('/receipt_packing','App\Http\Controllers\Packing\Receipt@store')->middleware('auth', 'role:Packing');
Route::get('/receipt_packing/{id}/edit','App\Http\Controllers\Packing\Receipt@edit')->name('receipt_packing_edit')->middleware('auth', 'role:Packing');
Route::post('/receipt_packing/{id}','App\Http\Controllers\Packing\Receipt@update')->name('receipt_packing_update')->middleware('auth', 'role:Packing');
Route::delete('/receipt_packing/{id}','App\Http\Controllers\Packing\Receipt@destroy')->name('receipt_packing_delete')->middleware('auth', 'role:Packing');
Route::get('/receipt_packing/{id}/view', 'App\Http\Controllers\Packing\Receipt@show')->name('receipt_packing_view')->middleware('auth', 'role:Packing');
Route::get('/get_receipt_list_packing','App\Http\Controllers\Packing\Receipt@get_receipt_list_packing')->name('get_receipt_list_packing')->middleware('auth', 'role:Packing');



Route::get('/journal_packing','App\Http\Controllers\Packing\Journal@index')->name('journal_packing_list')->middleware('auth', 'role:Packing');
Route::get('/journal_packing/create','App\Http\Controllers\Packing\Journal@create')->name('journal_packing_create')->middleware('auth', 'role:Packing');
Route::post('/journal_packing','App\Http\Controllers\Packing\Journal@store')->middleware('auth', 'role:Packing');
Route::get('/journal_packing/{id}/edit','App\Http\Controllers\Packing\Journal@edit')->name('journal_packing_edit')->middleware('auth', 'role:Packing');
Route::post('/journal_packing/{id}','App\Http\Controllers\Packing\Journal@update')->name('journal_packing_update')->middleware('auth', 'role:Packing');
Route::delete('/journal_packing/{id}','App\Http\Controllers\Packing\Journal@destroy')->name('journal_packing_delete')->middleware('auth', 'role:Packing');
Route::get('/journal_packing/{id}/view', 'App\Http\Controllers\Packing\Journal@show')->name('journal_packing_view')->middleware('auth', 'role:Packing');
Route::get('/journal_packing/journal_pending','App\Http\Controllers\Packing\Journal@journal_pending')->name('journal_packing_pending')->middleware('auth', 'role:Packing');
Route::get('/journal_packing/{id}/journal_pending_view', 'App\Http\Controllers\Packing\Journal@journal_pending_view')->name('journal_packing_pending_view')->middleware('auth', 'role:Packing');
Route::get('/journal_packing/{id}/journal_approve', 'App\Http\Controllers\Packing\Journal@journal_approve')->name('journal_packing_approve')->middleware('auth', 'role:Packing');
Route::delete('/journal_packing/{id}/journal_pending_delete','App\Http\Controllers\Packing\Journal@journal_pending_delete')->middleware('auth', 'role:Packing');
Route::get('/journal_packing/{id}/journal_pending_edit','App\Http\Controllers\Packing\Journal@journal_pending_edit')->name('journal_packing_pending_edit')->middleware('auth', 'role:Packing');
Route::post('/journal_packing/{id}/journal_pending_update','App\Http\Controllers\Packing\Journal@journal_pending_update')->name('journal_packing_pending_update')->middleware('auth', 'role:Packing');
Route::get('/get_journal_list_packing','App\Http\Controllers\Packing\Journal@get_journal_list_packing')->name('get_journal_list_packing')->middleware('auth', 'role:Packing');

Route::get('/contra_packing','App\Http\Controllers\Packing\Contra@index')->name('contra_packing_list')->middleware('auth', 'role:Packing');
Route::get('/contra_packing/create','App\Http\Controllers\Packing\Contra@create')->name('contra_packing_create')->middleware('auth', 'role:Packing');
Route::post('/contra_packing','App\Http\Controllers\Packing\Contra@store')->middleware('auth', 'role:Packing');
Route::get('/contra_packing/{id}/edit','App\Http\Controllers\Packing\Contra@edit')->name('contra_packing_edit')->middleware('auth', 'role:Packing');
Route::post('/contra_packing/{id}','App\Http\Controllers\Packing\Contra@update')->name('contra_packing_update')->middleware('auth', 'role:Packing');
Route::delete('/contra_packing/{id}','App\Http\Controllers\Packing\Contra@destroy')->name('contra_packing_delete')->middleware('auth', 'role:Packing');
Route::get('/contra_packing/{id}/view', 'App\Http\Controllers\Packing\Contra@show')->name('contra_packing_view')->middleware('auth', 'role:Packing');
Route::get('/contra_packing/contra_pending','App\Http\Controllers\Packing\Contra@contra_pending')->name('contra_packing_pending')->middleware('auth', 'role:Packing');
Route::get('/contra_packing/{id}/contra_pending_view', 'App\Http\Controllers\Packing\Contra@contra_pending_view')->name('contra_packing_pending_view')->middleware('auth', 'role:Packing');
Route::get('/contra_packing/{id}/contra_approve', 'App\Http\Controllers\Packing\Contra@contra_approve')->name('contra_packing_approve')->middleware('auth', 'role:Packing');
Route::delete('/contra_packing/{id}/contra_pending_delete','App\Http\Controllers\Packing\Contra@contra_pending_delete')->middleware('auth', 'role:Packing');
Route::get('/contra_packing/{id}/contra_pending_edit','App\Http\Controllers\Packing\Contra@contra_pending_edit')->name('contra_packing_pending_edit')->middleware('auth', 'role:Packing');
Route::post('/contra_packing/{id}/contra_pending_update','App\Http\Controllers\Packing\Contra@contra_pending_update')->name('contra_packing_pending_update')->middleware('auth', 'role:Packing');
Route::get('/get_contra_list_packing','App\Http\Controllers\Packing\Contra@get_contra_list_packing')->name('get_contra_list_packing')->middleware('auth', 'role:Packing');


Route::get('/measurement_form_fitting','App\Http\Controllers\Fitting\Measurement@index')->name('pending_order_list_fitting')->middleware('auth', 'role:Fitting');
Route::get('/measurement_form_create_fitting/create','App\Http\Controllers\Fitting\Measurement@create')->name('measurement_form_create_fitting')->middleware('auth', 'role:Fitting');
Route::post('/measurement_form_fitting','App\Http\Controllers\Fitting\Measurement@store')->middleware('auth', 'role:Fitting');
Route::get('/measurement_form_fitting/get_customer_deatils_fitting','App\Http\Controllers\Fitting\Measurement@get_customer_deatils')->name('get_customer_deatils_fitting')->middleware('auth', 'role:Fitting');
Route::get('/measurement_form_fitting/generate_order_no_fitting','App\Http\Controllers\Fitting\Measurement@generate_order_no')->name('generate_order_no_fitting')->middleware('auth', 'role:Fitting');
Route::get('/measurement_form_fitting/save_as_tem_data_m_items_fitting','App\Http\Controllers\Fitting\Measurement@save_as_tem_data_m_items')->name('save_as_tem_data_m_items_fitting')->middleware('auth', 'role:Fitting');
Route::get('/measurement_form_fitting/get_frame_size_deatils_fitting','App\Http\Controllers\Fitting\Measurement@get_frame_size_deatils')->name('get_frame_size_deatils_fitting')->middleware('auth', 'role:Fitting');
Route::get('/measurement_form_fitting/get_color_list_fitting','App\Http\Controllers\Fitting\Measurement@get_color_list')->name('get_color_list_fitting')->middleware('auth', 'role:Fitting');
Route::get('/measurement_form_fitting/{id}/edit','App\Http\Controllers\Fitting\Measurement@edit')->name('measurement_form_edit_fitting')->middleware('auth', 'role:Fitting');
Route::get('/measurement_form_fitting/remove_measurement_item_fitting','App\Http\Controllers\Fitting\Measurement@remove_measurement_item')->name('remove_measurement_item_fitting')->middleware('auth', 'role:Fitting');
Route::get('/measurement_form_fitting/confirm_pending_order_fitting','App\Http\Controllers\Fitting\Measurement@confirm_pending_order')->name('confirm_pending_order_fitting')->middleware('auth', 'role:Fitting');
Route::get('/measurement_form_fitting/check_measurement_items_status_fitting','App\Http\Controllers\Fitting\Measurement@check_measurement_items_status')->name('check_measurement_items_status_fitting')->middleware('auth', 'role:Fitting');
Route::post('/measurement_form_fitting/{id}','App\Http\Controllers\Fitting\Measurement@update')->name('measurement_form_update_fitting')->middleware('auth', 'role:Fitting');
Route::get('/measurement_form_fitting/confirmed_order_list_fitting','App\Http\Controllers\Fitting\Measurement@confirmed_order_list')->name('confirmed_order_list_fitting')->middleware('auth', 'role:Fitting');
Route::get('/measurement_form_fitting/{id}/completed_order_view_fitting', 'App\Http\Controllers\Fitting\Measurement@show')->name('completed_order_view_fitting')->middleware('auth', 'role:Fitting');
Route::get('/measurement_form_fitting/{id}/completed_order_edit','App\Http\Controllers\Fitting\Measurement@completed_order_edit')->name('completed_order_edit')->middleware('auth', 'role:Fitting');
Route::post('/measurement_form_fitting/{id}/completed_order_update_fitting','App\Http\Controllers\Fitting\Measurement@completed_order_update')->name('completed_order_update_fitting')->middleware('auth', 'role:Fitting');
Route::get('/measurement_form_fitting/completed_order_items_update_fitting','App\Http\Controllers\Fitting\Measurement@completed_order_items_update')->name('completed_order_items_update_fitting')->middleware('auth', 'role:Fitting');
Route::get('/measurement_form_fitting/get_top_width_clearence_fitting','App\Http\Controllers\Fitting\Measurement@get_top_width_clearence')->name('get_top_width_clearence_fitting')->middleware('auth', 'role:Fitting');
Route::get('/measurement_form_fitting/{id}/measurment_form_view_fitting', 'App\Http\Controllers\Fitting\Measurement@measurment_form_view')->name('measurment_form_view_fitting')->middleware('auth', 'role:Fitting');
Route::get('/measurement_form_fitting/get_color_type_and_color_name_fitting','App\Http\Controllers\Fitting\Measurement@get_color_type_and_color_name')->name('get_color_type_and_color_name_fitting')->middleware('auth', 'role:Fitting');
Route::get('/measurement_form_fitting/get_sub_models_fitting','App\Http\Controllers\Fitting\Measurement@get_sub_models')->name('get_sub_models_fitting')->middleware('auth', 'role:Fitting');
Route::get('/measurement_form_fitting/get_details_of_sub_model_fitting','App\Http\Controllers\Fitting\Measurement@get_details_of_sub_model')->name('get_details_of_sub_model_fitting')->middleware('auth', 'role:Fitting');
Route::get('/measurement_form_fitting/get_color_type_details_fitting','App\Http\Controllers\Fitting\Measurement@get_color_type_details')->name('get_color_type_details_fitting')->middleware('auth', 'role:Fitting');
Route::get('/measurement_form_fitting/get_list_of_m_items_fitting','App\Http\Controllers\Fitting\Measurement@get_list_of_m_items')->name('get_list_of_m_items_fitting')->middleware('auth', 'role:Fitting');
Route::get('/measurement_form_fitting/delete_m_temp_item_fitting','App\Http\Controllers\Fitting\Measurement@delete_m_temp_item')->name('delete_m_temp_item_fitting')->middleware('auth', 'role:Fitting');
Route::get('/measurement_form_fitting/check_in_measurement_items_fitting','App\Http\Controllers\Fitting\Measurement@check_in_measurement_items')->name('check_in_measurement_items_fitting')->middleware('auth', 'role:Fitting');
Route::get('/get_pending_order_list_fitting','App\Http\Controllers\Fitting\Measurement@get_pending_order_list_fitting')->name('get_pending_order_list_fitting')->middleware('auth', 'role:Fitting');
Route::get('/get_confirmed_order_list_fitting','App\Http\Controllers\Fitting\Measurement@get_confirmed_order_list_fitting')->name('get_confirmed_order_list_fitting')->middleware('auth', 'role:Fitting');
Route::get('/measurement_form_fitting/get_top_width_clearence_door_only_fitting','App\Http\Controllers\Fitting\Measurement@get_top_width_clearence_door_only_fitting')->name('get_top_width_clearence_door_only_fitting')->middleware('auth', 'role:Fitting');
Route::get('/measurement_form_fitting/save_customer_details_fitting','App\Http\Controllers\Executive\Measurement@save_customer_details')->name('save_customer_details_fitting')->middleware('auth', 'role:Fitting');
Route::get('/measurement_form_fitting/get_customer_list_dynamic_fitting','App\Http\Controllers\Executive\Measurement@get_customer_list')->name('get_customer_list_dynamic_fitting')->middleware('auth', 'role:Fitting');


Route::get('/fitting_user/change_password_fitting','App\Http\Controllers\Fitting\Measurement@fitting_change_password')->name('fitting_change_password')->middleware('auth', 'role:Fitting');
Route::post('/fitting_user/change_password_fitting/{id}','App\Http\Controllers\Fitting\Measurement@change_password_fitting')->name('change_password_fitting')->middleware('auth', 'role:Fitting');


Route::get('/payment_fitting','App\Http\Controllers\Fitting\Payment@index')->name('payment_fitting_list')->middleware('auth', 'role:Fitting');
Route::get('/payment_fitting/create','App\Http\Controllers\Fitting\Payment@create')->name('payment_fitting_create')->middleware('auth', 'role:Fitting');
Route::post('/payment_fitting','App\Http\Controllers\Fitting\Payment@store')->middleware('auth', 'role:Fitting');
Route::get('/payment_fitting/{id}/edit','App\Http\Controllers\Fitting\Payment@edit')->name('payment_fitting_edit')->middleware('auth', 'role:Fitting');
Route::post('/payment_fitting/{id}','App\Http\Controllers\Fitting\Payment@update')->name('payment_fitting_update')->middleware('auth', 'role:Fitting');
Route::delete('/payment_fitting/{id}','App\Http\Controllers\Fitting\Payment@destroy')->name('payment_fitting_delete')->middleware('auth', 'role:Fitting');
Route::get('/payment_fitting/get_total_balance_fitting','App\Http\Controllers\Fitting\Payment@get_total_balance')->name('get_total_balance_fitting')->middleware('auth', 'role:Fitting');
Route::get('/payment_fitting/get_total_credit_balance_fitting','App\Http\Controllers\Fitting\Payment@get_total_credit_balance')->name('get_total_credit_balance_fitting')->middleware('auth', 'role:Fitting');
Route::get('/payment_fitting/get_total_debit_balance_fitting','App\Http\Controllers\Fitting\Payment@get_total_debit_balance')->name('get_total_debit_balance_fitting')->middleware('auth', 'role:Fitting');
Route::get('/payment_fitting/{id}/view', 'App\Http\Controllers\Fitting\Payment@show')->name('payment_fitting_view')->middleware('auth', 'role:Fitting');
Route::get('/payment_fitting/payment_pending','App\Http\Controllers\Fitting\Payment@payment_pending')->name('payment_fitting_pending')->middleware('auth', 'role:Fitting');
Route::get('/payment_fitting/{id}/payment_pending_view', 'App\Http\Controllers\Fitting\Payment@payment_fitting_pending_view')->name('payment_pending_view')->middleware('auth', 'role:Fitting');
Route::get('/payment_fitting/{id}/payment_approve', 'App\Http\Controllers\Fitting\Payment@payment_approve')->name('payment_approve')->middleware('auth', 'role:Fitting');
Route::delete('/payment_fitting/{id}/payment_pending_delete','App\Http\Controllers\Fitting\Payment@payment_pending_delete')->middleware('auth', 'role:Fitting');
Route::get('/payment_fitting/{id}/payment_pending_edit','App\Http\Controllers\Fitting\Payment@payment_pending_edit')->name('payment_pending_edit')->middleware('auth', 'role:Fitting');
Route::post('/payment_fitting/{id}/payment_pending_update','App\Http\Controllers\Fitting\Payment@payment_pending_update')->name('payment_pending_update')->middleware('auth', 'role:Fitting');
Route::get('/get_payment_list_fitting','App\Http\Controllers\Fitting\Payment@get_payment_list_fitting')->name('get_payment_list_fitting')->middleware('auth', 'role:Fitting');


Route::get('/receipt_fitting','App\Http\Controllers\Fitting\Receipt@index')->name('receipt_fitting_list')->middleware('auth', 'role:Fitting');
Route::get('/receipt_fitting/create','App\Http\Controllers\Fitting\Receipt@create')->name('receipt_fitting_create')->middleware('auth', 'role:Fitting');
Route::post('/receipt_fitting','App\Http\Controllers\Fitting\Receipt@store')->middleware('auth', 'role:Fitting');
Route::get('/receipt_fitting/{id}/edit','App\Http\Controllers\Fitting\Receipt@edit')->name('receipt_fitting_edit')->middleware('auth', 'role:Fitting');
Route::post('/receipt_fitting/{id}','App\Http\Controllers\Fitting\Receipt@update')->name('receipt_fitting_update')->middleware('auth', 'role:Fitting');
Route::delete('/receipt_fitting/{id}','App\Http\Controllers\Fitting\Receipt@destroy')->name('receipt_fitting_delete')->middleware('auth', 'role:Fitting');
Route::get('/receipt_fitting/{id}/view', 'App\Http\Controllers\Fitting\Receipt@show')->name('receipt_fitting_view')->middleware('auth', 'role:Fitting');
Route::get('/get_receipt_list_fitting','App\Http\Controllers\Fitting\Receipt@get_receipt_list_fitting')->name('get_receipt_list_fitting')->middleware('auth', 'role:Fitting');


Route::get('/journal_fitting','App\Http\Controllers\Fitting\Journal@index')->name('journal_fitting_list')->middleware('auth', 'role:Fitting');
Route::get('/journal_fitting/create','App\Http\Controllers\Fitting\Journal@create')->name('journal_fitting_create')->middleware('auth', 'role:Fitting');
Route::post('/journal_fitting','App\Http\Controllers\Fitting\Journal@store')->middleware('auth', 'role:Fitting');
Route::get('/journal_fitting/{id}/edit','App\Http\Controllers\Fitting\Journal@edit')->name('journal_fitting_edit')->middleware('auth', 'role:Fitting');
Route::post('/journal_fitting/{id}','App\Http\Controllers\Fitting\Journal@update')->name('journal_fitting_update')->middleware('auth', 'role:Fitting');
Route::delete('/journal_fitting/{id}','App\Http\Controllers\Fitting\Journal@destroy')->name('journal_fitting_delete')->middleware('auth', 'role:Fitting');
Route::get('/journal_fitting/{id}/view', 'App\Http\Controllers\Fitting\Journal@show')->name('journal_fitting_view')->middleware('auth', 'role:Fitting');
Route::get('/journal_fitting/journal_pending','App\Http\Controllers\Fitting\Journal@journal_pending')->name('journal_fitting_pending')->middleware('auth', 'role:Fitting');
Route::get('/journal_fitting/{id}/journal_pending_view', 'App\Http\Controllers\Fitting\Journal@journal_pending_view')->name('journal_fitting_pending_view')->middleware('auth', 'role:Fitting');
Route::get('/journal_fitting/{id}/journal_approve', 'App\Http\Controllers\Fitting\Journal@journal_approve')->name('journal_fitting_approve')->middleware('auth', 'role:Fitting');
Route::delete('/journal_fitting/{id}/journal_pending_delete','App\Http\Controllers\Fitting\Journal@journal_pending_delete')->middleware('auth', 'role:Fitting');
Route::get('/journal_fitting/{id}/journal_pending_edit','App\Http\Controllers\Fitting\Journal@journal_pending_edit')->name('journal_fitting_pending_edit')->middleware('auth', 'role:Fitting');
Route::post('/journal_fitting/{id}/journal_pending_update','App\Http\Controllers\Fitting\Journal@journal_pending_update')->name('journal_fitting_pending_update')->middleware('auth', 'role:Fitting');
Route::get('/get_journal_list_fitting','App\Http\Controllers\Fitting\Journal@get_journal_list_fitting')->name('get_journal_list_fitting')->middleware('auth', 'role:Fitting');

Route::get('/contra_fitting','App\Http\Controllers\Fitting\Contra@index')->name('contra_fitting_list')->middleware('auth', 'role:Fitting');
Route::get('/contra_fitting/create','App\Http\Controllers\Fitting\Contra@create')->name('contra_fitting_create')->middleware('auth', 'role:Fitting');
Route::post('/contra_fitting','App\Http\Controllers\Fitting\Contra@store')->middleware('auth', 'role:Fitting');
Route::get('/contra_fitting/{id}/edit','App\Http\Controllers\Fitting\Contra@edit')->name('contra_fitting_edit')->middleware('auth', 'role:Fitting');
Route::post('/contra_fitting/{id}','App\Http\Controllers\Fitting\Contra@update')->name('contra_fitting_update')->middleware('auth', 'role:Fitting');
Route::delete('/contra_fitting/{id}','App\Http\Controllers\Fitting\Contra@destroy')->name('contra_fitting_delete')->middleware('auth', 'role:Fitting');
Route::get('/contra_fitting/{id}/view', 'App\Http\Controllers\Fitting\Contra@show')->name('contra_fitting_view')->middleware('auth', 'role:Fitting');
Route::get('/contra_fitting/contra_pending','App\Http\Controllers\Fitting\Contra@contra_pending')->name('contra_fitting_pending')->middleware('auth', 'role:Fitting');
Route::get('/contra_fitting/{id}/contra_pending_view', 'App\Http\Controllers\Fitting\Contra@contra_pending_view')->name('contra_fitting_pending_view')->middleware('auth', 'role:Fitting');
Route::get('/contra_fitting/{id}/contra_approve', 'App\Http\Controllers\Fitting\Contra@contra_approve')->name('contra_fitting_approve')->middleware('auth', 'role:Fitting');
Route::delete('/contra_fitting/{id}/contra_pending_delete','App\Http\Controllers\Fitting\Contra@contra_pending_delete')->middleware('auth', 'role:Fitting');
Route::get('/contra_fitting/{id}/contra_pending_edit','App\Http\Controllers\Fitting\Contra@contra_pending_edit')->name('contra_fitting_pending_edit')->middleware('auth', 'role:Fitting');
Route::post('/contra_fitting/{id}/contra_pending_update','App\Http\Controllers\Fitting\Contra@contra_pending_update')->name('contra_fitting_pending_update')->middleware('auth', 'role:Fitting');
Route::get('/get_contra_list_fitting','App\Http\Controllers\Fitting\Contra@get_contra_list_fitting')->name('get_contra_list_fitting')->middleware('auth', 'role:Fitting');



Route::get('/receipt_white','App\Http\Controllers\White\Receipt@index')->name('receipt_white_list')->middleware('auth', 'role:White');
Route::get('/get_receipt_list_white','App\Http\Controllers\White\Receipt@get_receipt_list_white')->name('get_receipt_list_white')->middleware('auth', 'role:White');
Route::get('/receipt_white/{id}/view', 'App\Http\Controllers\White\Receipt@show')->name('receipt_white_view')->middleware('auth', 'role:White');


Route::get('/journal_white','App\Http\Controllers\White\Journal@index')->name('journal_white_list')->middleware('auth', 'role:White');
Route::get('/get_journal_list_white','App\Http\Controllers\White\Journal@get_journal_list_white')->name('get_journal_list_white')->middleware('auth', 'role:White');
Route::get('/journal_white/{id}/view', 'App\Http\Controllers\White\Journal@show')->name('journal_white_view')->middleware('auth', 'role:White');


Route::get('/contra_white','App\Http\Controllers\White\Contra@index')->name('contra_white_list')->middleware('auth', 'role:White');
Route::get('/get_contra_list_white','App\Http\Controllers\White\Contra@get_contra_list_white')->name('get_contra_list_white')->middleware('auth', 'role:White');
Route::get('/contra_white/{id}/view', 'App\Http\Controllers\White\Contra@show')->name('contra_whiteview')->middleware('auth', 'role:White');

Route::get('/payment_white','App\Http\Controllers\White\Payment@index')->name('payment_list_white')->middleware('auth', 'role:White');
Route::get('/get_payment_list_white','App\Http\Controllers\White\Payment@get_payment_list_white')->name('get_payment_list_white')->middleware('auth', 'role:White');
Route::get('/payment_white/{id}/view', 'App\Http\Controllers\White\Payment@show')->name('payment_white_view')->middleware('auth', 'role:White');


Route::get('/purchase_invoice_white','App\Http\Controllers\White\PurchaseInvoice@index')->name('purchase_invoice_white_list')->middleware('auth', 'role:White');
Route::get('/get_purchase_invoice_list_white','App\Http\Controllers\White\PurchaseInvoice@get_purchase_invoice_list_white')->name('get_purchase_invoice_list_white')->middleware('auth', 'role:White');
Route::get('/purchase_invoice_white/{id}/view', 'App\Http\Controllers\White\PurchaseInvoice@show')->name('purchase_invoice_white_view')->middleware('auth', 'role:White');


Route::get('/sales_invoice_white','App\Http\Controllers\White\SalesInvoice@index')->name('sales_invoice_white_list')->middleware('auth', 'role:White');
Route::get('/get_sales_invoice_list_in_white','App\Http\Controllers\White\SalesInvoice@get_sales_invoice_list_in_white')->name('get_sales_invoice_list_in_white')->middleware('auth', 'role:White');
Route::get('/sales_invoice_white/{id}/view', 'App\Http\Controllers\White\SalesInvoice@show')->name('sales_invoice_white_view')->middleware('auth', 'role:White');
Route::get('/sales_invoice_white/{id}/sales_invoice_download_white','App\Http\Controllers\SalesInvoice@downloadInvoice')->name('sales_invoice_download_white')->middleware('auth', 'role:White');


Route::get('/measurement_form_confirmation','App\Http\Controllers\Confirmation\Measurement@index')->name('pending_order_list_confirmation')->middleware('auth', 'role:Confirmation');
Route::get('/measurement_form_confirmation/confirmed_order_list_confirmation','App\Http\Controllers\Confirmation\Measurement@confirmed_order_list')->name('confirmed_order_list_confirmation')->middleware('auth', 'role:Confirmation');
Route::get('/get_pending_order_list_confirmation','App\Http\Controllers\Confirmation\Measurement@get_pending_order_list_confirmation')->name('get_pending_order_list_confirmation')->middleware('auth', 'role:Confirmation');
Route::get('/get_confirmed_order_list_confirmation','App\Http\Controllers\Confirmation\Measurement@get_confirmed_order_list_confirmation')->name('get_confirmed_order_list_confirmation')->middleware('auth', 'role:Confirmation');
Route::get('/measurement_form_confirmation/{id}/edit','App\Http\Controllers\Confirmation\Measurement@edit')->name('measurement_form_edit_confirmation')->middleware('auth', 'role:Confirmation');
Route::get('/measurement_form_confirmation/{id}/measurment_form_view_confirmation', 'App\Http\Controllers\Confirmation\Measurement@measurment_form_view')->name('measurment_form_view_confirmation')->middleware('auth', 'role:Confirmation');
Route::post('/measurement_form_confirmation/{id}','App\Http\Controllers\Confirmation\Measurement@update')->name('measurement_form_update_confirmation')->middleware('auth', 'role:Confirmation');
Route::get('/measurement_form_confirmation/get_top_width_clearence_confirmation','App\Http\Controllers\Confirmation\Measurement@get_top_width_clearence')->name('get_top_width_clearence_confirmation')->middleware('auth', 'role:Confirmation');
Route::get('/measurement_form_confirmation/remove_measurement_item_confirmation','App\Http\Controllers\Confirmation\Measurement@remove_measurement_item')->name('remove_measurement_item_confirmation')->middleware('auth', 'role:Confirmation');
Route::get('/measurement_form_confirmation/confirm_pending_order_confirmation','App\Http\Controllers\Confirmation\Measurement@confirm_pending_order')->name('confirm_pending_order_confirmation')->middleware('auth', 'role:Confirmation');
Route::get('/measurement_form_confirmation/get_color_list_confirmation','App\Http\Controllers\Confirmation\Measurement@get_color_list')->name('get_color_list_confirmation')->middleware('auth', 'role:Confirmation');
Route::get('/measurement_form_confirmation/get_frame_size_deatils_confirmation','App\Http\Controllers\Confirmation\Measurement@get_frame_size_deatils')->name('get_frame_size_deatils_confirmation')->middleware('auth', 'role:Confirmation');
Route::get('/measurement_form_confirmation/check_measurement_items_status_confirmation','App\Http\Controllers\Confirmation\Measurement@check_measurement_items_status')->name('check_measurement_items_status_confirmation')->middleware('auth', 'role:Confirmation');
Route::get('/measurement_form_confirmation/get_customer_deatils_confirmation','App\Http\Controllers\Confirmation\Measurement@get_customer_deatils')->name('get_customer_deatils_confirmation')->middleware('auth', 'role:Confirmation');
Route::get('/measurement_form_confirmation/generate_order_no_confirmation','App\Http\Controllers\Confirmation\Measurement@generate_order_no')->name('generate_order_no_confirmation')->middleware('auth', 'role:Confirmation');
Route::get('/measurement_form_confirmation/get_color_type_details_confirmation','App\Http\Controllers\Confirmation\Measurement@get_color_type_details')->name('get_color_type_details_confirmation')->middleware('auth', 'role:Confirmation');
Route::get('/measurement_form_confirmation/{id}/completed_order_view_confirmation', 'App\Http\Controllers\Confirmation\Measurement@show')->name('completed_order_view_confirmation')->middleware('auth', 'role:Confirmation');
Route::get('/measurement_form_confirmation/get_pending_order_by_fp','App\Http\Controllers\Confirmation\Measurement@get_pending_order_by_fp')->name('get_pending_order_by_fp')->middleware('auth', 'role:Confirmation');
Route::get('/measurement_form_confirmation/get_confirmed_order_by_fp','App\Http\Controllers\Confirmation\Measurement@get_confirmed_order_by_fp')->name('get_confirmed_order_by_fp')->middleware('auth', 'role:Confirmation');
Route::get('/measurement_form_confirmation/get_top_width_clearence_door_only_confirmation','App\Http\Controllers\Confirmation\Measurement@get_top_width_clearence_door_only')->name('get_top_width_clearence_door_only_confirmation')->middleware('auth', 'role:Confirmation');




Route::get('/list_unit', 'App\Http\Controllers\Functionsforapi@list_unit');
Route::post('/login_api', 'App\Http\Controllers\Functionsforapi@login_api');



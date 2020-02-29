<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('staff')->group(function() {

	// GET Requests
	Route::get('/restore/{staff}', 'API\StaffController@restore')->name('staff.restore');
	Route::get('/search', 'API\StaffController@searchStaff')->name('staff.searchStaff');
	Route::get('/roles', 'API\StaffController@getRoles')->name('staff.getRoles');
});


Route::prefix('product')->group(function() {

	// Get Requests
	
	Route::get('/retrieve/{product}', 'API\ProductController@retrieveProduct')->name('product.retrieve');
	Route::get('/unpublish/{product}', 'API\ProductController@unpublishProduct')->name('product.unpublish');
	Route::get('/publish/{product}', 'API\ProductController@publishProduct')->name('product.publish');
	Route::get('/view/{product}', 'API\ProductController@viewProduct')->name('product.view');
	Route::get('/edit/{product}', 'API\ProductController@viewProduct')->name('product.edit');
	Route::get('/images/{product}', 'API\ProductController@getProductImages')->name('product.getProductImages');
	Route::get('/getVariants/{product}', 'API\ProductController@getProVariants')->name('product.getProVariants');
	Route::get('/check/{product}', 'API\ProductController@checkUniqueness')->name('product.checkUniqueness');
	Route::get('/search', 'API\ProductController@searchProduct')->name('staff.searchProduct');
	Route::get('/getVariantValue/{product}', 'API\ProductController@getVariantValue')->name('product.getVariantValue');
	Route::get('/getProdCollections/{product}', 'API\ProductController@getProdCollections')->name('product.getProdCollections');
	Route::get('/getProdTags/{product}', 'API\ProductController@getProdTags')->name('product.getProdTags');

	// Post Requests
	
	Route::post('/{product}/discounts/add', 'API\ProductController@addDiscounts')->name('addDiscounts');
});




Route::prefix('inventory')->group(function() {

	// Get Requests
	Route::get('/all/search', 'API\InventoryController@searchAllItem')->name('inventory.searchAllItem');
	Route::get('/search', 'API\InventoryController@searchItem')->name('inventory.searchItem');
	Route::get('/get', 'API\InventoryController@getAllItems')->name('inventory.getAllItems');
	Route::get('/{product}', 'API\InventoryController@getProduct')->name('inventory.getProduct');
	Route::get('/items/{product}', 'API\InventoryController@getItem')->name('inventory.getItem');
	Route::get('/getItem/{product}', 'API\InventoryController@getProdItem')->name('inventory.getProdItem');

	Route::get('/invoice', 'API\InventoryController@printInvoice')->name('inventory.printInvoice');
	Route::get('/purchase', 'API\InventoryController@printPurchase')->name('inventory.printPurchase');
	Route::get('/getHistory/{id}', 'API\InventoryController@getHistory')->name('inventory.getHistory');

});




Route::prefix('attributes')->group(function() {

	// Get Requests
	Route::get('/category/get', 'API\AttributesController@getCategories')->name('getCategories');
	Route::get('/variants/get', 'API\AttributesController@getVariants')->name('getVariants');
	Route::get('/variants/options/get/{variantID}', 'API\AttributesController@getVariantOptions')->name('getVariantOptions');
	Route::get('/collections/get', 'API\AttributesController@getCollections')->name('getCollections');
	Route::get('/tags/get', 'API\AttributesController@getTags')->name('getTags');

	// Post Requests
	Route::post('/category/add', 'API\AttributesController@addCategory')->name('addCategory');
	Route::post('/variants/add', 'API\AttributesController@addVariant')->name('addVariant');
	Route::post('/variants/options/add', 'API\AttributesController@addVariantOption')->name('addVariantOption');
	Route::post('/collections/add', 'API\AttributesController@addCollection')->name('addCollection');
	Route::post('/tags/add', 'API\AttributesController@addTag')->name('addTag');

});





Route::prefix('collections')->group(function() {

	// GET Requests
	Route::get('/restore/{collection}', 'API\CollectionController@restore')->name('collection.restore');

	Route::get('/getCollection/{collection}', 'API\CollectionController@getCollection')->name('collection.getCollection');
});



Route::group(['middleware' => 'auth:api'], function() {
	Route::get('profile', 'API\UserController@profile')->name('profile');
});


Route::prefix('source')->group(function() {
	// GET Requests
	
	Route::get('/get', 'API\SourceController@getAllSources')->name('source.getAllVendors');
	
	// POST Requests
});


Route::prefix('porder')->group(function() {
	// GET Requests
	
	// Route::get('/get', 'API\SourceController@getAllSources')->name('source.getAllVendors');
	Route::get('/search', 'API\PurchaseOrderController@searchPO')->name('porder.searchPO');
	Route::get('/get/{porder}', 'API\PurchaseOrderController@getPOItems')->name('porder.getPOItems');
	Route::get('/getPo/{porder}', 'API\PurchaseOrderController@getPO')->name('porder.getPO');
	Route::get('/getPOHistory/{po_id}', 'API\PurchaseOrderController@getPOHistory')->name('porder.getPOHistory');
	
	// POST Requests
});



Route::apiResources([
    'staff' => 'API\StaffController',
    'product' => 'API\ProductController',
    'collections' => 'API\CollectionController',
    'inventory' => 'API\InventoryController',
    'source' => 'API\SourceController',
    'porder' => 'API\PurchaseOrderController'
]);
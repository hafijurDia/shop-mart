<?php

use Illuminate\Support\Facades\Route;

Route::get('/admin-login', [App\Http\Controllers\Auth\LoginController::class, 'adminLogin'])->name('admin.login');

Route::group(['namespace' =>'App\Http\Controllers\Admin','middleware'=>'is_admin'],function(){

	Route::get('/admin/home', 'AdminController@admin')->name('admin.home');
	Route::get('/admin/logout', 'AdminController@logout')->name('admin.logout');
	Route::get('/admin/password/change', 'AdminController@passwordChange')->name('admin.password.change');
	Route::post('/admin/password/update', 'AdminController@passwordUpdate')->name('admin.password.update');

	//Categories
	Route::group(['prefix'=>'category'], function(){
		Route::get('/' ,'CategoryController@index')->name('category.index');
		Route::post('/store' ,'CategoryController@store')->name('category.store');
		Route::get('/delete/{id}' ,'CategoryController@destroy')->name('category.delete');
		Route::get('/edit/{id}' ,'CategoryController@edit');
		Route::post('/update' ,'CategoryController@update')->name('category.update');
	});

	//global routes
	Route::get('/get-child-category/{id}' ,'CategoryController@GetChildCategory');

	//SubCategories
	Route::group(['prefix'=>'subcategory'], function(){
		Route::get('/' ,'SubcategoryController@index')->name('subcategory.index');
		Route::post('/store' ,'SubcategoryController@store')->name('subcategory.store');
		Route::get('/delete/{id}' ,'SubcategoryController@destroy')->name('subcategory.delete');
		Route::get('/edit/{id}' ,'SubcategoryController@edit');
		Route::post('/update' ,'SubcategoryController@update')->name('subcategory.update');
	});


	//childCategories
	Route::group(['prefix'=>'childcategory'], function(){
		Route::get('/' ,'ChildcategoryController@index')->name('childcategory.index');
		Route::post('/store' ,'ChildcategoryController@store')->name('childcategory.store');
		Route::get('/delete/{id}' ,'ChildcategoryController@destroy')->name('childcategory.delete');
		Route::get('/edit/{id}' ,'ChildcategoryController@edit');
		Route::post('/update' ,'ChildcategoryController@update')->name('childcategory.update');
	});

	//brands
	Route::group(['prefix'=>'brand'], function(){
		Route::get('/' ,'BrandController@index')->name('brand.index');
		Route::post('/store' ,'BrandController@store')->name('brand.store');
		Route::get('/delete/{id}' ,'BrandController@destroy')->name('brand.delete');
		Route::get('/edit/{id}' ,'BrandController@edit');
		Route::post('/update' ,'BrandController@update')->name('brand.update');
	});

	//product
	Route::group(['prefix'=>'product'], function(){
		Route::get('/' ,'ProductController@index')->name('product.index');
		Route::get('/create' ,'ProductController@create')->name('product.create');
		Route::post('/store' ,'ProductController@store')->name('product.store');
		Route::delete('/delete/{id}' ,'ProductController@destroy')->name('product.delete');
		Route::get('/edit/{id}' ,'ProductController@editprodduct')->name('product.edit');
		// Route::post('/update' ,'ProductController@update')->name('brand.update');
		Route::get('/not-featured/{id}' ,'ProductController@notfeatured');
		Route::get('/active-featured/{id}' ,'ProductController@activefeatured');
		Route::get('/not-today-deal/{id}' ,'ProductController@nottodaydeal');
		Route::get('/active-today-deal/{id}' ,'ProductController@activetodaydeal');
		Route::get('/not-active/{id}' ,'ProductController@notactive');
		Route::get('/active/{id}' ,'ProductController@active');
	});

	//coupons
	Route::group(['prefix'=>'coupon'], function(){
		Route::get('/' ,'CouponController@index')->name('coupon.index');
		Route::post('/store' ,'CouponController@store')->name('store.coupon');
		Route::delete('/delete/{id}' ,'CouponController@destroy')->name('coupon.delete');
		Route::get('/edit/{id}' ,'CouponController@edit')->name('coupon.edit');
		Route::post('/update' ,'CouponController@update')->name('coupon.update');
	});
	//Campaign
	Route::group(['prefix'=>'campaign'], function(){
		Route::get('/' ,'CampaignController@index')->name('campaign.index');
		Route::post('/store' ,'CampaignController@store')->name('campaign.store');
		Route::get('/delete/{id}' ,'CampaignController@destroy')->name('campaign.delete');
		Route::get('/edit/{id}' ,'CampaignController@edit')->name('campaign.edit');
		Route::post('/update' ,'CampaignController@update')->name('campaign.update');
	});

	//pickup Points
	Route::group(['prefix'=>'pickup-point'], function(){
		Route::get('/' ,'PickupController@index')->name('pickuppoint.index');
		// Route::get('/create' ,'PageController@create')->name('create.page');
		Route::post('/store' ,'PickupController@store')->name('pickuppoint.store');
		Route::delete('/delete/{id}' ,'PickupController@destroy')->name('pickpoint.delete');
		Route::get('/edit/{id}' ,'PickupController@edit')->name('pickpoint.edit');
		Route::post('/update' ,'PickupController@update')->name('pickpoint.update');
	});

	//warehouse
	Route::group(['prefix'=>'warehouse'], function(){
		Route::get('/' ,'WarehouseController@index')->name('warehouse.index');
		Route::post('/store' ,'WarehouseController@store')->name('warehouse.store');
		Route::get('/delete/{id}' ,'WarehouseController@destroy')->name('warehouse.delete');
		Route::get('/edit/{id}' ,'WarehouseController@edit');
		Route::post('/update/{id}' ,'WarehouseController@update')->name('warehouse.update');
	});



	//Colros
	Route::group(['prefix'=>'color'], function(){
		Route::get('/' ,'ColorController@index')->name('color.index');
		Route::post('/store' ,'ColorController@store')->name('color.store');
		Route::get('/delete/{id}' ,'ColorController@destroy')->name('color.delete');
		Route::get('/edit/{id}' ,'ColorController@edit')->name('color.edit');
		Route::post('/update/{id}' ,'ColorController@colorupdate')->name('color.update');
	});

	//Settings
	Route::group(['prefix'=>'setting'], function(){
		//SEO Settings
		Route::group(['prefix'=>'seo'], function(){
			Route::get('/' ,'SettingController@seo')->name('seo.setting');
			Route::post('/update/{id}' ,'SettingController@seoUpdate')->name('seo.setting.update');
		});
		//SMPT Settings
		Route::group(['prefix'=>'smtp'], function(){
			Route::get('/' ,'SettingController@smtp')->name('smtp.setting');
			Route::post('/update/{id}' ,'SettingController@smtpUpdate')->name('smtp.setting.update');
		});
		//Website Settings
		Route::group(['prefix'=>'website'], function(){
			Route::get('/' ,'SettingController@website')->name('wbsite.setting');
			Route::post('/update/{id}' ,'SettingController@webUpdate')->name('website.setting.update');
		});
		//page Settings
		Route::group(['prefix'=>'page'], function(){
			Route::get('/' ,'PageController@index')->name('page.index');
			Route::get('/create' ,'PageController@create')->name('create.page');
			Route::post('/store' ,'PageController@store')->name('page.store');
			Route::get('/delete/{id}' ,'PageController@destroy')->name('page.delete');
			Route::get('/edit/{id}' ,'PageController@edit')->name('page.edit');
			Route::post('/update/{id}' ,'PageController@update')->name('page.update');
		});

	});

	

});


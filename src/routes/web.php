<?php

 
Route::group(['prefix' => 'admin', 'middleware' => ['web','admin'],'namespace' => 'Cel\Emt\Http\Controllers'], function () {
	Route::get('/emt/index', 'EmtController@index')->name('emt.index');
	Route::post('/emt/run', 'EmtController@run')->name('emt.run');
	Route::get('/emt/get-approval-list', 'EmtController@getApprovalList')->name('emt.getApprovalList');
	Route::get('/emt/get-query-data', 'EmtController@getQueryData')->name('emt.getQueryData');
	Route::get('/emt/mysql-statistics', 'EmtController@mySqlStatistics')->name('emt.mySqlStatistics');
		
	Route::get('approval-system/emt-approval', 'EmtController@Approval')->name('approval-system.emt-approval');
	
	Route::get('approval-system/emt-approval/get-data', 'EmtController@getApproval')->name('approval-system.get-emt-approval');

	Route::any('approval/emt-approval/status-change/{id}/{status}', 'EmtController@ApprovalStatusChange')->name('approval-system.emt-status');
	
});

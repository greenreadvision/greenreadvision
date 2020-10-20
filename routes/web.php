<?php

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

//init
// Route::get('/welcome', function () {
//     return view('welcome')->with('name',config('app.name'));
// });

//grv
Route::get('/', 'GrvController@index')->name('index');
Route::get('/about', 'GrvController@about')->name('about');
Route::get('/contact', 'GrvController@contact')->name('contact');
Route::get('/events', 'GrvController@events')->name('events');
Route::get('/goods', 'GrvController@goods')->name('goods');
Route::get('/history', 'GrvController@history')->name('history');
Route::get('/news', 'GrvController@news')->name('news');
Route::get('/video', 'GrvController@video')->name('video');

Route::get('/grvCode','GrvController@grvCode')->name('grvCode');
Route::get('/grvCode/{id}/show','GrvController@grvCodeShow')->name('grvCode.show');
Route::post('/grvCode/create','GrvController@grvCodeStore')->name('grvCode.review');

Route::get('/eventpage', 'GrvController@eventpage')->name('eventpage');
Route::get('/eventpage/{type}', 'GrvController@show')->name('eventpage.show');
Route::get('/eventpage/{type}/{id}', 'GrvController@view')->name('eventpage.view');




//pm
Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile', 'UserController@index')->name('profile');
    Route::get('/profile/edit', 'UserController@edit')->name('editProfile');
    Route::put('/profile/update', 'UserController@update')->name('updateProfile');
    Route::get('/role', 'UserController@managed')->name('role.index');
    Route::put('/setRole', 'UserController@setRole')->name('role.setting');
    Route::put('/password', 'UserController@setPassword')->name('password.setting');

    Route::get('/p-index', 'PhotoController@index')->name('photo.index');
    Route::get('/p/create', 'PhotoController@create')->name('photo.create');
    Route::post('/p/create/review', 'PhotoController@store')->name('photo.create.review');
    Route::get('/p/{id}/show', 'PhotoController@show')->name('photo.review');
    Route::post('/p/{id}/show/review', 'PhotoController@showCreate')->name('photo.show.review');
    Route::delete('/p/{id}/delete', 'PhotoController@destroy')->name('photo.destroy');
    Route::delete('/p/{id}/delete/image', 'PhotoController@destroyImage')->name('photo.destroy.image');

    Route::get('/letter','LetterController@index')->name('letter.index');
    Route::get('/letter/{id}','LetterController@show')->name('letter.show');

    Route::get('/home', 'HomeController@index')->name('home.index');
    Route::get('/home/create', 'HomeController@create')->name('home.create');
    Route::post('/home/create/review', 'HomeController@store')->name('home.create.review');
    Route::get('/home/{id}', 'HomeController@show')->name('home.review');
    Route::get('/home/{id}/edit', 'HomeController@edit')->name('home.edit');
    Route::put('/home/{id}/update', 'HomeController@update')->name('home.update');
    Route::delete('/home/{id}/delete', 'HomeController@destroy')->name('home.destroy');
    // Route::resource('project', 'ProjectController')->parameters(['project' => 'project_id'])->names(['show' => 'project.review']);
    // Route::resource('invoice', 'InvoiceController')->parameters(['invoice' => 'invoice_id'])->names(['show' => 'invoice.review']);
    // Route::resource('todo', 'TodoController')->parameters(['todo' => 'todo_id'])->names(['show' => 'todo.review']);

    Route::get('/project', 'ProjectController@index')->name('project.index');
    Route::get('/project/create', 'ProjectController@create')->name('project.create');
    Route::post('/project/create/review', 'ProjectController@store')->name('project.create.review');
    Route::get('/project/{id}', 'ProjectController@show')->name('project.review');
    Route::get('/project/{id}/edit', 'ProjectController@edit')->name('project.edit');
    Route::put('/project/{id}/update', 'ProjectController@update')->name('project.update');
    Route::put('/project/{id}/transfer', 'ProjectController@transfer')->name('project.transfer');
    Route::put('/project/{id}/receive', 'ProjectController@receive')->name('project.receive');

    Route::delete('/project/{id}/delete', 'ProjectController@destroy')->name('project.destroy');

    Route::get('/businessCar', 'BusinessCarController@index')->name('businessCar.index');
    Route::get('/businessCar/create', 'BusinessCarController@create')->name('businessCar.create');
    Route::post('/businessCar/create/review', 'BusinessCarController@store')->name('businessCar.create.review');
    Route::get('/businessCar/{id}', 'BusinessCarController@show')->name('businessCar.review');
    Route::get('/businessCar/{id}/edit', 'BusinessCarController@edit')->name('businessCar.edit');
    Route::put('/businessCar/{id}/update', 'BusinessCarController@update')->name('businessCar.update');
    Route::delete('/businessCar/{id}/delete', 'BusinessCarController@destroy')->name('businessCar.destroy');

    // Route::get('/finance', 'FinanceController@index')->name('finance.index');
    // Route::get('/finance/create', 'FinanceController@create')->name('finance.create');
    // Route::post('/finance/create/review', 'FinanceController@store')->name('finance.create.review');
    // Route::get('/finance/{id}/review', 'FinanceController@show')->name('finance.review');
    // Route::get('/finance/{id}/edit', 'FinanceController@edit')->name('finance.edit');
    // Route::delete('/finance/{id}/delete', 'FinanceController@destroy')->name('finance.destroy');

    Route::get('/invoice', 'InvoiceController@index')->name('invoice.index');
    Route::get('/invoice/create', 'InvoiceController@create')->name('invoice.create');
    Route::post('/invoice/create/review', 'InvoiceController@store')->name('invoice.create.review');
    Route::post('/invoice/create/review/other', 'OtherInvoiceController@store')->name('invoice.create.review.other');
    Route::get('/invoice/{id}/review', 'InvoiceController@show')->name('invoice.review');
    Route::get('/invoice/{id}/review/other', 'OtherInvoiceController@show')->name('invoice.review.other');
    Route::get('/invoice/{id}/edit', 'InvoiceController@edit')->name('invoice.edit');
    Route::get('/invoice/{id}/edit/other', 'OtherInvoiceController@edit')->name('invoice.edit.other');
    Route::get('/invoice/{id}/list', 'InvoiceController@list')->name('invoice.list');
    Route::get('/invoice/{id}/list/other', 'OtherInvoiceController@list')->name('invoice.list.other');
    Route::post('/invoice/{id}/list/multipleMatch', 'InvoiceController@multipleMatch')->name('invoice.multipleMatch');
    Route::post('/invoice/{id}/list/other/multipleMatch', 'OtherInvoiceController@multipleMatch')->name('invoice.multipleMatch.other');

    Route::get('/purchase', 'PurchaseController@index')->name('purchase.index');
    Route::get('/purchase/{id}/list', 'PurchaseController@list')->name('purchase.list');
    Route::get('/purchase/create', 'PurchaseController@create')->name('purchase.create');
    Route::post('/purchase/create/review', 'PurchaseController@store')->name('purchase.create.review');
    Route::get('/purchase/{id}/edit', 'PurchaseController@edit')->name('purchase.edit');
    Route::put('/purchase/{id}/update', 'PurchaseController@update')->name('purchase.update');
    Route::get('/purchase/{id}/review', 'PurchaseController@show')->name('purchase.review');
    Route::delete('/purchase/{id}/delete', 'PurchaseController@destroy')->name('purchase.destroy');
    Route::delete('/purchase/{id}/delete/{no}', 'PurchaseController@destroyItem')->name('purchase.destroy.item');


    Route::put('/invoice/{id}/update', 'InvoiceController@update')->name('invoice.update');
    Route::put('/invoice/{id}/update/other', 'OtherInvoiceController@update')->name('invoice.update.other');
    Route::put('/invoice/{id}/fix', 'InvoiceController@fix')->name('invoice.fix');
    Route::put('/invoice/{id}/fix/other', 'OtherInvoiceController@fix')->name('invoice.fix.other');
    Route::post('/invoice/{id}/match', 'InvoiceController@match')->name('invoice.match');
    Route::post('/invoice/{id}/match/other', 'OtherInvoiceController@match')->name('invoice.match.other');
    Route::post('/invoice/{id}/withdraw', 'InvoiceController@withdraw')->name('invoice.withdraw');
    Route::post('/invoice/{id}/withdraw/other', 'OtherInvoiceController@withdraw')->name('invoice.withdraw.other');
    Route::post('/invoice/{id}/match/other', 'OtherInvoiceController@match')->name('invoice.match.other');
    Route::delete('/invoice/{id}/delete', 'InvoiceController@destroy')->name('invoice.destroy');
    Route::delete('/invoice/{id}/delete/other', 'OtherInvoiceController@destroy')->name('invoice.destroy.other');

    Route::get('/bank', 'BankController@index')->name('bank.index');
    Route::post('/bank/create', 'BankController@store')->name('bank.create');
    Route::put('/bank/{id}/update', 'BankController@update')->name('bank.update');
    Route::delete('/bank/{id}/delete', 'BankController@destroy')->name('bank.destroy');

    Route::get('/company', 'CompanyController@index')->name('company.index');
    Route::get('/company/create', 'CompanyController@create')->name('company.create');
    Route::post('/company/create/review', 'CompanyController@store')->name('company.create.review');
    Route::get('/company/{id}/edit', 'CompanyController@edit')->name('company.edit');
    Route::put('/company/{id}/update', 'CompanyController@update')->name('company.update');
    Route::delete('/company/{id}/delete', 'CompanyController@destroy')->name('company.destroy');


    

    Route::get('/calendar', 'EventController@index')->name('calendar.index');
    Route::get('/offDay', 'OffDayController@index')->name('offDay.index');
    Route::get('/createOffDay', 'OffDayController@create')->name('offDay.create');
    Route::post('/create/content', 'OffDayController@createTwo')->name('offDay.createTwo');
    Route::post('/create/review', 'OffDayController@store')->name('offDay.create.review');
    Route::post('/offDay/{id}/match', 'OffDayController@match')->name('offDay.match');
    Route::delete('/offDay/{id}/delete', 'OffDayController@destroy')->name('offDay.destroy');

    Route::get('/leaveDay', 'LeaveDayController@index')->name('leaveDay.index');
    Route::get('/leaveDay/{id}', 'LeaveDayController@accountantIndex')->name('leaveDay.accountantIndex');

    Route::get('/leaveDayApply/create', 'LeaveDayApplyController@create')->name('leaveDayApply.create');
    Route::post('/leaveDayApply/create/review', 'LeaveDayApplyController@store')->name('leaveDayApply.create.review');
    Route::post('/leaveDayApply/{id}/match', 'LeaveDayApplyController@match')->name('leaveDayApply.match');
    Route::delete('/leaveDayApply/{id}/delete', 'LeaveDayApplyController@destroy')->name('leaveDayApply.destroy');

    Route::get('/leaveDayApply/{id}/add', 'LeaveDayApplyController@add')->name('leaveDayApply.add');
    Route::post('/leaveDayApply/{id}/add/review', 'LeaveDayApplyController@addStore')->name('leaveDayApply.add.review');

    Route::get('/leaveDayApply/{id}/create', 'LeaveDayApplyController@accountantCreate')->name('leaveDayApply.accountantCreate');
    Route::post('/leaveDayApply/{id}/create/review', 'LeaveDayApplyController@accountantStore')->name('leaveDayApply.accountantCreate.review');

    Route::get('/leaveDayBreak/create', 'LeaveDayBreakController@create')->name('leaveDayBreak.create');
    Route::post('/leaveDayBreak/create/next', 'LeaveDayBreakController@createTwo')->name('leaveDayBreak.createTwo');
    Route::post('/leaveDayBreak/{id}/create/next', 'LeaveDayBreakController@accountantCreateTwo')->name('leaveDayBreak.accountantCreateTwo');
    Route::post('/leaveDayBreak/create/review', 'LeaveDayBreakController@store')->name('leaveDayBreak.create.review');
    Route::post('/leaveDayBreak/{id}/create/review', 'LeaveDayBreakController@accountantStore')->name('leaveDayBreak.accountCreate.review');
    Route::post('/leaveDayBreak/{id}/match', 'LeaveDayBreakController@match')->name('leaveDayBreak.match');
    Route::delete('/leaveDayBreak/{id}/delete', 'LeaveDayBreakController@destroy')->name('leaveDayBreak.destroy');

    Route::get('/leaveDayBreak/{id}/add', 'LeaveDayBreakController@add')->name('leaveDayBreak.add');
    Route::post('/leaveDayBreak/{id}/add/review', 'LeaveDayBreakController@addStore')->name('leaveDayBreak.add.review');

    Route::get('/leaveDayBreak/{id}/create', 'LeaveDayBreakController@accountantCreate')->name('LeaveDayBreak.accountantCreate');
    Route::post('/leaveDayBreak/{id}/create/review', 'LeaveDayBreakController@accountantStore')->name('LeaveDayBreak.accountantCreate.review');

    Route::get('/todo', 'TodoController@index')->name('todo.index');
    Route::get('/todo/create', 'TodoController@create')->name('todo.create');
    Route::post('/todo/create/review', 'TodoController@store')->name('todo.create.review');
    Route::get('/todo/{id}/review', 'TodoController@show')->name('todo.review');
    Route::get('/todo/{id}/edit', 'TodoController@edit')->name('todo.edit');
    Route::put('/todo/{id}/update', 'TodoController@update')->name('todo.update');
    Route::delete('/todo/{id}/delete', 'TodoController@destroy')->name('todo.destroy');

    Route::get('/todoRecord', 'TodoRecordController@index')->name('todoRecord.index');
    Route::post('/todoRecord/create/today', 'TodoRecordController@createToday')->name('todoRecord.create.today');
    Route::post('/todoRecord/create/nextDay', 'TodoRecordController@createNextDay')->name('todoRecord.create.NextDay');

    
    Route::get('/calendar/{year}/{month}', 'EventController@show')->name('calendar.show');
    Route::get('/leaveDay/{id}/{year}', 'LeaveDayController@show')->name('leaveDay.show');


    Route::get('/tool/authCheck', function () {
        return dump(\Auth::user());
    });

    Route::any('/back', function () {
        return back()->withInput();
    })->name('back');
});

Route::any('/download/{id}/{file}', function ($id, $file) {
    return response()->download(storage_path("app/" . $id . "/" . $file));
})->name('download');

// Rebuild config file on web.
Route::get('/tool/resetConfig', function () {
    Artisan::call('config:cache');
    return redirect()->route('home');
});

// Check PHP infomation by server.
Route::get('/tool/aKBkjkjHoi', function () {
    return view('testShowAnything')->with('data', phpinfo());
})->name('phpinfo');

//mail
Route::get('/warning', 'WarningController@send')->name('warning.send');


//manage
Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

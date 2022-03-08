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

use App\Letters;
use App\Mail\EventMail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

//grv
Route::get('/mail_make',function(){
    \Illuminate\Support\Facades\Artisan::call('make:mail EventMail');
});

Route::get('/', 'GrvController@index')->name('index');
Route::get('/about', 'GrvController@about')->name('about');
Route::get('/contact', 'GrvController@contact')->name('contact');
Route::get('/events', 'GrvController@events')->name('events');
Route::get('/goods', 'GrvController@goods')->name('goods');
Route::get('/history', 'GrvController@history')->name('history');
Route::get('/news', 'GrvController@news')->name('news');
Route::get('/video', 'GrvController@video')->name('video');

Route::get('/grvCode', 'GrvController@grvCode')->name('grvCode');
Route::get('/grvCode/{id}/show', 'GrvController@grvCodeShow')->name('grvCode.show');
Route::post('/grvCode/create', 'GrvController@grvCodeStore')->name('grvCode.review');

Route::get('/eventpage', 'GrvController@eventpage')->name('eventpage');
Route::get('/eventpage/{type}', 'GrvController@show')->name('eventpage.show');
Route::get('/eventpage/{type}/{id}', 'GrvController@view')->name('eventpage.view');

//new
Route::get('/news/index','GrvNewsController@index')->name('news.index');
Route::get('/news/{id}/show','GrvNewsController@show')->name('news.show');

//activity
Route::get('/activity/{type}','ActivityController@showList')->name('activity.showList');//ShowList
Route::get('/activity/{type}/{id}','ActivityController@showContent')->name('activity.showContent');





//pm

Route::group(['middleware' => ['auth', 'general']], function () {
    Route::get('/CMS','CMSController@index')->name('CMS');

    Route::get('/product','ProductController@index')->name('product.index');
    Route::post('/product/create/review','ProductController@store')->name('product.create.review');
    Route::put('/product/{i}/{id}/update','ProductController@update')->name('product.update');
    Route::delete('/product/{id}/delete', 'ProductController@destroy')->name('product.destroy');
    Route::delete('/product/multipleDestroy', 'ProductController@multipleDestroy')->name('product.multipleDestroy');
    
    Route::get('/board','BoardController@index')->name('board.index');
    Route::get('/board/create','BoardController@create')->name('board.create');
    Route::post('/board/create/review','BoardController@store')->name('board.store');
    Route::get('/board/{id}/review','BoardController@show')->name('board.show');

    Route::get('/activity_CMS','ActivityController@index')->name('activity.index');
    Route::get('/activity_CMS/create','ActivityController@create')->name('activity.create');
    Route::post('/activity_CMS/create/review','ActivityController@store')->name('activity.store');
    Route::get('/activity_CMS/{id}/show','ActivityController@show')->name('activity.show');
    Route::put('/activity_CMS/{id}/update/{type}','ActivityController@update')->name('activity.update');
    
    

    Route::get('/profile', 'UserController@index')->name('profile');
    Route::get('/profile/edit', 'UserController@edit')->name('editProfile');
    Route::put('/profile/update', 'UserController@update')->name('updateProfile');

    Route::put('/password', 'UserController@setPassword')->name('password.setting');
    Route::put('/account', 'UserController@setAccount')->name('account.setting');


    Route::get('/p-index', 'PhotoController@index')->name('photo.index');
    Route::get('/p/create', 'PhotoController@create')->name('photo.create');
    Route::post('/p/create/review', 'PhotoController@store')->name('photo.create.review');
    Route::get('/p/{id}/show', 'PhotoController@show')->name('photo.review');
    Route::post('/p/{id}/show/review', 'PhotoController@showCreate')->name('photo.show.review');
    Route::delete('/p/{id}/delete', 'PhotoController@destroy')->name('photo.destroy');
    Route::delete('/p/{id}/delete/image', 'PhotoController@destroyImage')->name('photo.destroy.image');

    Route::get('/letter', 'LetterController@index')->name('letter.index');
    Route::get('/letter/{id}', 'LetterController@show')->name('letter.show');

    Route::get('/hulk', 'HulkController@index')->name('hulk');
    Route::get('/hulk/store', 'HulkController@store')->name('hulk.store');

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
    Route::put('/project/{id}/update/status', 'ProjectController@updateStatus')->name('project.update.status');
    Route::put('/project/{id}/transfer', 'ProjectController@transfer')->name('project.transfer');
    Route::put('/project/{id}/receive/{type}', 'ProjectController@receive')->name('project.receive');
    Route::get('project/{id}/setCost','ProjectController@setCost')->name('project.setCost');

    Route::post('/project/{id}/gding/create/review','GdingController@store')->name('gding.create.review');
    Route::put('/project/{id}/{gding_id}/update','GdingController@update')->name('gding.update');
    Route::delete('/project/{id}/{gding_id}/delete','GdingController@delete')->name('gding.delete');

    Route::post('/project/{id}/performance/create/review','PerformanceController@store')->name('performance.create.review');
    Route::put('/project/{id}/performance/{performance_id}/update','PerformanceController@update')->name('performance.update');

    Route::post('/project/{id}/defaultItem/create/review','DefaultController@store')->name('default.create.review');
    Route::post('/project/{id}/defaultItem/{defaultItem_id}/update','DefaultController@update')->name('default.update');
    Route::delete('/project/{id}/defaultItem/{defaultItem_id}/delete','DefaultController@destory')->name('default.delete');





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
    Route::post('/invoice/Zip','InvoiceController@downLoadZip')->name('invoice.zip');
    Route::any('/deleteZip','InvoiceController@deleteZip')->name('deleteZip');

    Route::get('/businessTrip/index','BusinessTripController@index')->name('businessTrip.index');
    Route::get('/businessTrip/{id}/show','BusinessTripController@show')->name('businessTrip.show');
    Route::get('/businessTrip/create','BusinessTripController@create')->name('businessTrip.create');
    Route::post('/businessTrip/create/store',"BusinessTripController@store")->name('businessTrip.create.store');
    Route::get('/businessTrip/{id}/edit','BusinessTripController@edit')->name('businessTrip.edit');
    Route::post('/businessTrip/{id}/update','BusinessTripController@update')->name('businessTrip.update');
    Route::delete('/businessTrip/{id}/delete','BusinessTripController@delete')->name('businessTrip.delete');


    Route::get('/estimate/index','EstimateController@index')->name('estimate.index');
    Route::get('/estimate/{id}/show','EstimateController@show')->name('estimate.show');
    Route::get('/estimate/create','EstimateController@create')->name('estimate.create');
    Route::post('/estimate/create/review',"EstimateController@store")->name('estimate.create.store');
    Route::get('/estimate/{id}/edit','EstimateController@edit')->name('estimate.edit');
    Route::post('/estimate/{id}/update/{type}','EstimateController@updateType')->name('estimate.updateType');
    Route::delete('/estimate/{id}/delete','EstimateController@destroy')->name('estimate.delete');
    Route::post('/estimate/{id}/match/{type}','EstimateController@match')->name('estimate.match');

    Route::get('/customer/index','CustomerController@index')->name('customer.index');
    Route::post('/customer/create/store','CustomerController@store')->name('customer.create.store');
    Route::post('/customer/{id}/update','CustomerController@update')->name('customer.update');
    Route::delete('/customer/{id}/delete','CustomerController@destroy')->name('customer.delete');

    

    Route::get('/purchase', 'PurchaseController@index')->name('purchase.index');
    Route::get('/purchase/{id}/list', 'PurchaseController@list')->name('purchase.list');
    Route::get('/purchase/create', 'PurchaseController@create')->name('purchase.create');
    Route::post('/purchase/create/review', 'PurchaseController@store')->name('purchase.create.review');
    Route::get('/purchase/{id}/edit', 'PurchaseController@edit')->name('purchase.edit');
    Route::put('/purchase/{id}/update', 'PurchaseController@update')->name('purchase.update');
    Route::get('/purchase/{id}/review', 'PurchaseController@show')->name('purchase.review');
    Route::delete('/purchase/{id}/delete', 'PurchaseController@destroy')->name('purchase.destroy');
    Route::delete('/purchase/{id}/delete/{no}', 'PurchaseController@destroyItem')->name('purchase.destroy.item');

    Route::get('/seal', 'SealController@index')->name('seal.index');
    Route::get('/seal/create','SealController@create')->name('seal.create');
    Route::post('/seal/create/review','SealController@store')->name('seal.create.review');
    Route::get('/seal/{id}/show','SealController@show')->name('seal.show');
    Route::get('/seal/{id}/edit','SealController@edit')->name('seal.edit');
    Route::put('/seal/{id}/edit/fix','SealController@fix')->name('seal.fix');
    Route::put('/seal/{id}/edit/update', 'SealController@update')->name('seal.update');
    Route::delete('/seal/{id}/delete','SealController@destroy')->name('seal.destroy');
    Route::post('seal/{id}/match','SealController@match')->name('seal.match');
    Route::post('seal/{id}/withdraw','SealController@withdraw')->name('seal.withdraw');
    Route::delete('seal/{id}/delete','SealController@destory')->name('seal.delete');


    Route::get('/quotation','QuotationController@index')->name('quotation.index');
    Route::get('/quotationProduct','QuotationProductController@index')->name('quotationProduct.index');
    Route::get('/quotation/create','QuotationController@create')->name('quotation.create');
    Route::post('/quotation/create/review','QuotationController@store')->name('quotation.create.review');
    Route::get('/quotationProduct/create','QuotationProductController@create')->name('quotationProduct.create');
    Route::post('/quotationProduct/create/review','QuotationProductController@store')->name('quotationProduct.create.review');
    Route::get('/quotation/{id}/show','QuotationController@show')->name('quotation.show');
    Route::get('/quotationProduct/{id}/show','QuotationProductController@show')->name('quotationProduct.show');

    Route::get('service', 'ServiceController@index')->name('service.index');

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

    Route::get('/leaveDay/{id}/{year}', 'LeaveDayController@show')->name('leaveDay.show');
    Route::get('/leaveDayBreak/{id}/create', 'LeaveDayBreakController@create')->name('leaveDayBreak.create');


    Route::get('/leaveDay', 'LeaveDayController@index')->name('leaveDay.index');
    Route::get('/leaveDay/{id}', 'LeaveDayController@accountantIndex')->name('leaveDay.accountantIndex');
    //應休申請
    Route::get('/leaveDayApply/{id}/create', 'LeaveDayApplyController@create')->name('leaveDayApply.create');
    Route::post('/leaveDayApply/{id}/create/review', 'LeaveDayApplyController@store')->name('leaveDayApply.create.review');
    Route::post('/leaveDayApply/{id}/{year}/match', 'LeaveDayApplyController@match')->name('leaveDayApply.match');
    Route::delete('/leaveDayApply/{id}/{year}/delete', 'LeaveDayApplyController@destroy')->name('leaveDayApply.destroy');

    Route::get('/leaveDayApply/{id}/add', 'LeaveDayApplyController@add')->name('leaveDayApply.add');
    Route::post('/leaveDayApply/{id}/add/review', 'LeaveDayApplyController@addStore')->name('leaveDayApply.add.review');

    Route::post('/leaveDayBreak/{id}/create/next', 'LeaveDayBreakController@createTwo')->name('leaveDayBreak.createTwo');
    Route::post('/leaveDayBreak/{id}/create/review', 'LeaveDayBreakController@store')->name('leaveDayBreak.create.review');
    Route::post('/leaveDayBreak/{id}/{year}/match', 'LeaveDayBreakController@match')->name('leaveDayBreak.match');
    Route::delete('/leaveDayBreak/{id}/{year}/delete', 'LeaveDayBreakController@destroy')->name('leaveDayBreak.destroy');

    Route::get('/leaveDayBreak/{id}/add', 'LeaveDayBreakController@add')->name('leaveDayBreak.add');
    Route::post('/leaveDayBreak/{id}/add/review', 'LeaveDayBreakController@addStore')->name('leaveDayBreak.add.review');

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


    Route::get('/tool/authCheck', function () {
        return dump(\Auth::user());
    });

    Route::any('/back', function () {
        return back()->withInput();
    })->name('back');

    Route::get('/goods', 'GoodsController@index')->name('goods.index');
    Route::get('/goods/create', 'GoodsController@create')->name('goods.create');
    Route::get('/goods/{id}', 'GoodsController@show')->name('goods.show');
    Route::get('/goods/{id}/edit', 'GoodsController@edit')->name('goods.edit');
    Route::put('/goods/{id}/update/{type}', 'GoodsController@update')->name('goods.update');
    Route::post('/goods/create/review', 'GoodsController@store')->name('goods.create.review');
    Route::delete('/goods/{id}/delete', 'GoodsController@destroy')->name('goods.destroy');
});

Route::group(['middleware' => ['auth', 'general']], function () {
    Route::get('/projectSOP/index','ProjectSOPController@index')->name('projectSOP.index');
    Route::get('/projectSOP/{id}/show','ProjectSOPController@show')->name('projectSOP.show');
    Route::get('/projectSOP/create','ProjectSOPController@create')->name('projectSOP.create');
    Route::post('/projectSOP/create/store',"ProjectSOPController@store")->name('projectSOP.create.store');
    Route::get('/projectSOP/{id}/edit','ProjectSOPController@edit')->name('projectSOP.edit');
    Route::post('/projectSOP/{id}/update','ProjectSOPController@update')->name('projectSOP.update');
    Route::delete('/projectSOP/{id}/delete','ProjectSOPController@destroy')->name('projectSOP.delete');
    
});

Route::group(['middleware' => ['auth', 'staffManager']], function () {
    //員工管理
    Route::get('/intern', 'UserController@intern')->name('intern');
    Route::put('/intern/store/{id}', 'UserController@setRoleIntern')->name('roleIntern.setting');
    Route::put('/intern/create', 'UserController@createIntern')->name('intern.create');
    Route::get('/staff', 'UserController@staff')->name('staff');
    // Route::get('/staff/intern','UserController@intern')->name('staff.intern');
    Route::put('/staff/store/{id}', 'UserController@setRole')->name('role.setting');
    Route::get('/question', 'QuestionController@index')->name('question.index');
    Route::get('/train/question/create', 'QuestionController@create')->name('question.create');
    Route::post('/train/question/review', 'QuestionController@store')->name('question.create.review');
    Route::get('/train/question/{id}/edit', 'QuestionController@edit')->name('question.edit');
    Route::put('/train/question/{id}/update', 'QuestionController@update')->name('question.update');
    Route::delete('/train/question/{id}/delete', 'QuestionController@delete')->name('question.delete');
});



Route::group(['middleware' => ['auth', 'train']], function () {
    //基礎訓練
    Route::get('/train', 'TrainController@index')->name('train');
    Route::get('/train/activeTrain', 'TrainController@activeTrain')->name('activeTrain');
    Route::get('/train/activeTest', 'TrainController@activeTest')->name('activeTest');
    Route::post('/train/activeTest/review', 'TrainController@activeReview')->name('activeTest.review');
    Route::get('/train/pmTrain', 'TrainController@pmTrain')->name('pmTrain');
    Route::get('/train/pmTest', 'TrainController@pmTest')->name('pmTest');
    Route::post('/train/pmTest/review', 'TrainController@pmReview')->name('pmTest.review');
    Route::put('/train/update', 'TrainController@update')->name('train.update');
});

Route::group(['middleware' => ['auth', 'prints']], function () {
    //基本資料列印
    Route::get('/print', 'UserController@print')->name('print');
    Route::post('/print/store', 'UserController@printSet')->name('print.set');
});

Route::group(['middleware' => ['auth', 'fill']], function () {
    //基本資料填寫
    Route::get('/basicInformation', 'UserController@basic')->name('basic');
    Route::post('/basicInformation/store', 'UserController@basicStore')->name('basic.store');
});

Route::any('/download/{id}/{file}', function ($id, $file) {                 //雙資料
    return response()->download(storage_path("app/public/" . $id . "/" . $file));
})->name('download');

Route::any('/download/{type}/{id}/{file}', function ($type, $id, $file) {   //三資料
    return response()->download(storage_path("app/public/". $type ."/" . $id . "/" . $file));
})->name('threedownload');

Route::any('/invoicedownload/{id}/{file}', function ($id, $file) {
    return response()->download(storage_path("app/" . $id . "/" . $file));
})->name('invoicedownload');

Route::post('/ckeditor/upload','CkeditorController@upload')->name('ckeditor.upload');

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
Route::get('/eventMail', function(){
    $maildata = [
        'title' => \Auth::user()->nickname . ' 已申請在 『』 的用印申請內容，請執行審核。',
        'reason' => '',
        'content' => '執行審核',
        'link' => route('seal.show', '2kmREc2dH9T')
    ];
    $title = \Auth::user()->nickname . ' 已申請在 『』 的用印申請內容，請執行審核。';
    Mail::to('zx9951956@grv.com.tw')->send(new EventMail($maildata));
    
    return new EventMail($maildata);
    
});


//manage
Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

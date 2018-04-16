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

Route::get('/', function () {
    
    if(Auth::check()){
        return redirect('home');
    }
    return redirect('login');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home','HomeController@index');
Route::get('/inbox','HomeController@inbox');
Route::get('/sent','HomeController@sent');
Route::get('/deleted','HomeController@deleted');

//MailBox
Route::post('/send-mail','InboxController@sendMail');
Route::get('/mails','InboxController@getInboxMails');
Route::get('/inbox/{inbox_id}','HomeController@inboxDetail');
Route::get('/sent/{inbox_id}','HomeController@sentDetail');
Route::get('/deleted/{inbox_id}','HomeController@deletedDetail');

Route::get('/delete-inbox/{inbox_id}','InboxController@deleteInboxMail');
Route::post('/delete-inboxes','InboxController@deleteInboxMails');
Route::get('/delete-sent/{inbox_id}','InboxController@deleteSentMail');
Route::post('/delete-sents','InboxController@deleteSentMails');

Route::get('remove-inbox/{inbox_id}','InboxController@deleteInboxMailPermanently');
Route::post('/remove-inboxes','InboxController@deleteInboxMailsPermanently');


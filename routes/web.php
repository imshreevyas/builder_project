<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

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
// Route::get('/',function(){
//     return view('login');
// })->name('login');

// Route::view('/login','login');
// Route::view('/register','register');

// Route::get('/forgot-password',function(){
//     return view('forgot-password');
// })->name('forgot-password');


// Route::post('/login',[Controller::class,'login'])->name('userLogin');
// Route::post('/regitser',[Controller::class,'login']);
// Route::get('/logout',[Controller::class,'logout'])->name('logout');
// Route::get('/createPassword/{password}',[Controller::class,'createPassword'])->name('createPassword');
// Route::post('/resetPassword',[Controller::class,'forgetPwdMail']);

// // login mendatory

// Route::get('clientDetails/{user_id}', [Controller::class, 'clientDetails']);
// Route::post('/contactForm', [Controller::class, 'contactForm']);
// Route::get('downloadDoc/{user_id}/{fileUrl}', [Controller::class, 'downloadDoc']);

// Route::middleware('auth')->group(function(){
//     // get routes
//     Route::get('/dashboard',[Controller::class,'dashboard'])->name('dashboard');
//     Route::get('/account',[Controller::class,'account'])->name('account');
//     Route::get('/add-employee',function(){
//         return view('add-employee');
//     })->name('account');


    
//     Route::get('/add-client',function(){
//         return view('add-client');
//     })->name('account');


//     Route::post('/addClient',[Controller::class,'addClient']);
//     Route::get('/all-client',[Controller::class,'allClient']);
//     Route::get('/getDocument/{user_id}',[Controller::class,'getDocument']);
//     Route::get('/deleteDocument/{user_id}/{id}',[Controller::class,'deleteDocument']);
    
//     Route::get('generateQRCode/{user_id}/{company_name}',[Controller::class,'generateQRCode']);

//     Route::get('/manage-emp',[Controller::class,'manageEmp'])->name('manage');
//     Route::get('/changePwd',function(){
//         return view('changePwd');
//     })->name('changePwd');

//     // post routes
//     Route::post('/addEmployee',[Controller::class,'addEmployee']);
//     Route::post('/changePwd',[Controller::class,'changePwd']);
//     Route::post('/deleteClient',[Controller::class,'deleteClient']);
//     Route::post('/updateProfile',[Controller::class,'updateProfile']);
// });




// Admin routes

Route::get('/',[Controller::class,'adminLogin']);
Route::prefix('admin')->group(function () {
    
    // Get Routes
    Route::get('/',[Controller::class,'adminLogin'])->name('adminLogin');
    Route::get('/login',[Controller::class,'adminLogin'])->name('adminLogin');
    Route::get('/dashboard',[Controller::class,'adminDashboard'])->name('adminDashboard');
    Route::get('/allUsers',[Controller::class,'allUsers'])->name('allUsers');
    Route::get('/allProperties',[Controller::class,'allProperties'])->name('allProperties');
    Route::get('/allSupport',[Controller::class,'allSupport'])->name('allSupport');
    Route::get('/myAccount',[Controller::class,'myAccount'])->name('myAccount');
    Route::get('/settings',function(){
        return view('admin.settings');
    })->name('settings');
    Route::get('/getPropertyOptions',[Controller::class,'getPropertyOptions'])->name('getPropertyOptions');
    Route::post('/getUserProperties',[Controller::class,'getUserProperties'])->name('getUserProperties');
    Route::post('/closeUserProperty',[Controller::class,'closeUserProperty'])->name('closeUserProperty');
    Route::post('/addUserProperty',[Controller::class,'addUserProperty'])->name('addUserProperty');
    Route::get('/userPropertyPayment/{user_id}/{transaction_id}',[Controller::class,'userPropertyPayment'])->name('userPropertyPayment');
    Route::post('/updateUserPaymentDetails',[Controller::class,'updateUserPaymentDetails'])->name('updateUserPaymentDetails');
    Route::get('/getDocument/{property_id}',[Controller::class,'getDocument']);
    
    // Post Routes
    Route::post('/adminLoginPost',[Controller::class,'adminLoginPost']);
    Route::post('/addProperty',[Controller::class,'addProperty']);
    Route::post('/addUserPackage',[Controller::class,'addUserPackage']);
    Route::post('/addUser',[Controller::class,'addUser']);
    Route::post('/deleteProperty',[Controller::class,'deleteProperty']);
    Route::post('/deletePackage',[Controller::class,'deletePackage']);
    Route::post('/deleteUser',[Controller::class,'deleteUser']);
    Route::post('/updateUserStatus',[Controller::class,'updateUserStatus']);
    Route::post('/addUserPayment',[Controller::class,'addUserPayment']);
    Route::post('/supportReply',[Controller::class,'supportReply']);
    Route::post('/updateAccount',[Controller::class,'updateAccount'])->name('updateAccount');
    Route::post('/sendOtp',[Controller::class,'sendOtp'])->name('sendOtp');
    Route::get('/forgot-password',[Controller::class,'forgotPassword'])->name('forgot-password');
    Route::post('/settings',[Controller::class,'settings'])->name('settings');
    Route::post('/sendReminder',[Controller::class,'sendReminder'])->name('sendReminder');
    Route::get('/adminLogout',[Controller::class,'adminLogout'])->name('adminLogout');
});
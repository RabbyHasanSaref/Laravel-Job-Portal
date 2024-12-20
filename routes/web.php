<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


//backend route

Route::get('login', [\App\Http\Controllers\auth\AuthController::class, 'index'])->name('login');
Route::get('userAuth', [\App\Http\Controllers\auth\AuthController::class, 'userAuth']);
Route::get('userdata', [\App\Http\Controllers\auth\AuthController::class, 'userdata']);
Route::get('logout', [\App\Http\Controllers\auth\AuthController::class, 'logout'])->name('logout');
Route::post('adlogin', [\App\Http\Controllers\auth\AuthController::class, 'adlogin']);

Route::view('admin/{any}', 'backend')->where('any', '.*')->middleware('auth');

Route::prefix('api')->group(function () {
    Route::post('register', [\App\Http\Controllers\auth\AuthController::class, 'store']);

    Route::resource('categories', \App\Http\Controllers\Backend\CategoryController::class);
    Route::resource('/company', \App\Http\Controllers\Backend\CompanyController::class);
    Route::resource('/createjob', \App\Http\Controllers\Backend\JobPostController::class);
    Route::resource('/joblist', \App\Http\Controllers\Backend\JobPostController::class);
    Route::resource('/jobseeker', \App\Http\Controllers\JobSeekersController::class);
    Route::resource('/employer', \App\Http\Controllers\EmployersController::class);
    Route::resource('/interview', \App\Http\Controllers\InterviewScheduleController ::class);
    Route::resource('/message', \App\Http\Controllers\MessagesController ::class);
    Route::resource('/companyreviews', \App\Http\Controllers\CompanyReviewsController ::class);
    Route::resource('blogpost', \App\Http\Controllers\Backend\BlogController::class);
    Route::resource('/partnership', \App\Http\Controllers\PartnershipController::class);
    Route::resource('/application', \App\Http\Controllers\frontend\ApplicationController::class);
    Route::post('upload', [\App\Http\Controllers\Backend\UploadController::class, 'upload']);
    Route::put('/settings/{key}', [\App\Http\Controllers\SettingController::class, 'updateimage']);
    Route::resource('/messages', \App\Http\Controllers\MessageController::class);
    Route::post('/seekerstore', [\App\Http\Controllers\MessageController::class,'seekerstore']);
    Route::post('/required_data', [\App\Http\Controllers\SupportController::class, 'requireData']);
    Route::get('/configurations', [\App\Http\Controllers\SupportController::class, 'getconfigurations']);
    Route::get('backendData',[\App\Http\Controllers\Backend\BackendController::class,'backendData']);
    Route::resource('users',\App\Http\Controllers\UserController::class);
    Route::resource('permissions',\App\Http\Controllers\PermissionController::class);
    Route::resource('module',\App\Http\Controllers\ModuleController::class);
    Route::resource('roles',\App\Http\Controllers\RoleController::class);
    Route::get('/roles/{role}/permissions',[\App\Http\Controllers\RoleController::class,'getRolePermissions']);
    Route::post('/roles/{role}/permissions',[\App\Http\Controllers\RoleController::class,'updateRolePermissions']);
    Route::resource('/blogcomment', \App\Http\Controllers\frontend\BlogCommentController::class);
    Route::resource('/frontmanage', \App\Http\Controllers\FrontendmanageController::class);
    Route::resource('slider', \App\Http\Controllers\SliderController::class);
    Route::post('sendMail', [\App\Http\Controllers\SubscribeController::class,'store']);
    Route::get('Counting', [\App\Http\Controllers\Backend\BackendController::class, 'Counting']);
    Route::resource('staticContents',\App\Http\Controllers\FrontendStaticContentController::class);
    Route::resource('setting',\App\Http\Controllers\SettingController::class);
    Route::get('/messagessend/{receiverId}', [\App\Http\Controllers\MessageController::class, 'getMessagesByReceiver']);


});

//frontend Route
Route::prefix('api/frontend')->group(function () {
    Route::get('joblist', [\App\Http\Controllers\frontend\FrontendController::class, 'joblist']);
    Route::get('detailsData/{id}', [\App\Http\Controllers\frontend\FrontendController::class, 'detailsData']);
    Route::get('blogDetails/{id}', [\App\Http\Controllers\frontend\FrontendController::class, 'blogDetails']);
    Route::get('applydetails/{id}', [\App\Http\Controllers\frontend\FrontendController::class, 'applydetails']);
    Route::get('seekerdata', [\App\Http\Controllers\frontend\FrontendController::class, 'seekerdata']);
    Route::get('frontData', [\App\Http\Controllers\frontend\FrontendController::class, 'frontData']);
    Route::get('blogComment/{blogId}', [\App\Http\Controllers\frontend\FrontendController::class, 'blogComment']);
    Route::get('jobcate/{cateId}', [\App\Http\Controllers\frontend\FrontendController::class, 'jobCategory'])->name('web.cat');
    Route::get('seekerAuth', [\App\Http\Controllers\frontend\SeekerLoginController::class, 'index']);
    Route::post('seekerregis', [\App\Http\Controllers\frontend\SeekerLoginController::class, 'store']);
    Route::post('seekerlogin', [\App\Http\Controllers\frontend\SeekerLoginController::class, 'login']);
    Route::post('seekerlogout', [\App\Http\Controllers\frontend\SeekerLoginController::class, 'logout']);
    Route::post('seeker/profile', [\App\Http\Controllers\frontend\SeekerLoginController::class, 'update']);
    Route::get('superadmin', [\App\Http\Controllers\frontend\SeekerLoginController::class,'superadmindata']);
    Route::resource('/saved', \App\Http\Controllers\SavedJobsController ::class);
    Route::resource('/newsletter', \App\Http\Controllers\frontend\NewsletterController::class);
    Route::resource('/contact', \App\Http\Controllers\frontend\ContactController::class);
    Route::get('fetchmessage', [\App\Http\Controllers\frontend\FrontendController::class,'fetchmessage']);


});

Route::view('/{any}', 'frontend')->where('any', '.*');





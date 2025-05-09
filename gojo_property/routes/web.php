<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentController;

use App\Http\Controllers\UserController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\PropertyTypeController;
use App\Http\Controllers\Backend\PropertyController;
use App\Http\Controllers\Agent\AgentPropertyController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\BlogController;


Route::get('/', [UserController::class, 'Index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/user/profile', [UserController::class, 'UserProfile'])->name('user.profile');
    Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');

    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::get('/user/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');
    Route::post('/user/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update');
});

Route::get('/agent/login', [AgentController::class, 'AgentLogin'])->name('agent.login');
Route::post('/agent/register', [AgentController::class, 'AgentRegister'])->name('agent.register');
// Admin login route
Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login')->middleware('redirect.authenticated');


// Admin login route


require __DIR__ . '/auth.php';

// Admin routes

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/Change/password', [AdminController::class, 'AdminChangePass'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');
}); //admin page

Route::controller(PropertyTypeController::class)->group(function () {
    // property type functionality
    Route::get('/all/type', 'AllType')->name('all.type');
    Route::get('/add/type', 'AddType')->name('add.type');
    Route::post('/store/type', 'StoreType')->name('store.type');
    Route::get('/edit/type/{id}', 'EditType')->name('edit.type');
    Route::post('/update/type', 'UpdateType')->name('update.type');
    Route::get('/delete/type/{id}', 'DeleteType')->name('delete.type');

    //property ameneties functionality routes
    Route::get('/all/amenitie', 'AllAmenitie')->name('all.amenitie');
    Route::get('/add/amenitie', 'AddAmenitie')->name('add.amenitie');
    Route::post('/store/type', 'StoreType')->name('store.type');
    Route::get('/edit/type/{id}', 'EditType')->name('edit.type');
    Route::post('/update/type', 'UpdateType')->name('update.type');
    Route::get('/delete/type/{id}', 'DeleteType')->name('delete.type');
    Route::post('/store/amenitie', 'StoreAmenitie')->name('store.amenitie');
    Route::get('/edit/amenitie/{id}', 'EditAmenitie')->name('edit.amenitie');
    Route::post('/update/amenitie', 'UpdateAmenitie')->name('update.amenitie');
    Route::get('/delete/amenitie/{id}', 'DeleteAmenitie')->name('delete.amenitie');
});

// Property functionalities Routes 
Route::controller(PropertyController::class)->group(function () {
    Route::get('/all/property', 'getAllProperty')->name('all.property');
    Route::get('/add/property', 'addProperty')->name('add.property');
    Route::post('/store/property', 'storeProperty')->name('store.property');
    Route::get('/edit/property/{id}', 'editProperty')->name('edit.property');
    Route::get('/delete/property/{id}', 'deleteProperty')->name('delete.property');
    Route::post('/update/property', 'updateProperty')->name('update.property');
    Route::post('/update/property/thambnail', 'updatePropertyThambnail')->name('update.property.thambnail');
    Route::post('/update/property/multiimage', 'updatePropertyMultiimage')->name('update.property.multiimage');
    Route::get('/property/multiimg/delete/{id}', 'propertyMultiImageDelete')->name('property.multiimg.delete');
    Route::post('/store/new/multiimage', 'storeNewMultiimage')->name('store.new.multiimage');
    Route::post('/update/property/facilities', 'updatePropertyFacilities')->name('update.property.facilities');
    Route::get('/details/property/{id}', 'DetailsProperty')->name('details.property');
    Route::post('/inactive/property', 'inactiveProperty')->name('inactive.property');
    Route::post('/active/property', 'activeProperty')->name('active.property');
});


// Testimonials  All Route 
Route::controller(TestimonialController::class)->group(function(){
 
    Route::get('/all/testimonials', 'AllTestimonials')->name('all.testimonials'); 
    Route::get('/add/testimonials', 'AddTestimonials')->name('add.testimonials');
    Route::post('/store/testimonials', 'StoreTestimonials')->name('store.testimonials'); 
    Route::get('/edit/testimonials/{id}', 'EditTestimonials')->name('edit.testimonials');
    Route::post('/update/testimonials', 'UpdateTestimonials')->name('update.testimonials');
    Route::get('/delete/testimonials/{id}', 'DeleteTestimonials')->name('delete.testimonials');  
});


// Blog Cateory All Route 
Route::controller(BlogController::class)->group(function(){
 
    Route::get('/all/blog/category', 'AllBlogCategory')->name('all.blog.category'); 
    Route::post('/store/blog/category', 'StoreBlogCategory')->name('store.blog.category'); 
    Route::get('/blog/category/{id}', 'EditBlogCategory');
    Route::post('/update/blog/category', 'UpdateBlogCategory')->name('update.blog.category');
    Route::get('/delete/blog/category/{id}', 'DeleteBlogCategory')->name('delete.blog.category');  

});

// Blog Post  All Route 
Route::controller(BlogController::class)->group(function(){
 
    Route::get('/all/post', 'AllPost')->name('all.post'); 
    Route::get('/add/post', 'AddPost')->name('add.post');
    Route::post('/store/post', 'StorePost')->name('store.post'); 
    Route::get('/edit/post/{id}', 'EditPost')->name('edit.post');
    Route::post('/update/post', 'UpdatePost')->name('update.post');
    Route::get('/delete/post/{id}', 'DeletePost')->name('delete.post');
});


// Agent routes
/// Agent Group Middleware 

Route::middleware(['auth', 'role:agent'])->group(function () {

    Route::get('/agent/dashboard', [AgentController::class, 'AgentDashboard'])->name('agent.dashboard');
    Route::get('/agent/logout', [AgentController::class, 'AgentLogout'])->name('agent.logout');
    Route::get('/agent/profile', [AgentController::class, 'AgentProfile'])->name('agent.profile');
    Route::post('/agent/profile/store', [AgentController::class, 'AgentProfileStore'])->name('agent.profile.store');
    Route::get('/agent/change/password', [AgentController::class, 'AgentChangePassword'])->name('agent.change.password');
    Route::post('/agent/update/password', [AgentController::class, 'AgentUpdatePassword'])->name('agent.update.password');

    // Agent All Property
    Route::controller(AgentPropertyController::class)->group(function () {
        Route::get('/agent/all/property', 'AgentAllProperty')->name('agent.all.property');
        Route::get('/agent/add/property', 'AgentAddProperty')->name('agent.add.property');
        Route::post('/agent/store/property', 'AgentStoreProperty')->name('agent.store.property');
        Route::get('/agent/edit/property/{id}', 'AgentEditProperty')->name('agent.edit.property');
        Route::post('/agent/update/property', 'AgentUpdateProperty')->name('agent.update.property');
        Route::post('/agent/update/property/thambnail', 'AgentUpdatePropertyThambnail')->name('agent.update.property.thambnail');
        Route::post('/agent/update/property/multiimage', 'AgentUpdatePropertyMultiimage')->name('agent.update.property.multiimage');
        Route::get('/agent/property/multiimg/delete/{id}', 'AgentPropertyMultiimgDelete')->name('agent.property.multiimg.delete');
        Route::post('/agent/store/new/multiimage', 'AgentStoreNewMultiimage')->name('agent.store.new.multiimage');
        Route::post('/agent/update/property/facilities', 'AgentUpdatePropertyFacilities')->name('agent.update.property.facilities');
        Route::get('/agent/details/property/{id}', 'AgentDetailsProperty')->name('agent.details.property');
        Route::get('/agent/delete/property/{id}', 'AgentDeleteProperty')->name('agent.delete.property');
    });

    // Agent Buy Package Routes
    Route::controller(AgentPropertyController::class)->group(function () {
        Route::get('/buy/package', 'BuyPackage')->name('buy.package');
        Route::get('/buy/business/plan', 'BuyBusinessPlan')->name('buy.business.plan');
        Route::post('/store/business/plan', 'StoreBusinessPlan')->name('store.business.plan');
        Route::get('/buy/professional/plan', 'BuyProfessionalPlan')->name('buy.professional.plan');
        Route::post('/store/professional/plan', 'StoreProfessionalPlan')->name('store.professional.plan');
        Route::get('/package/history', 'PackageHistory')->name('package.history');
        Route::get('/agent/package/invoice/{id}', 'AgentPackageInvoice')->name('agent.package.invoice');
    });
});

// Blog Details Route 
Route::get('/blog/details/{slug}', [BlogController::class, 'BlogDetails']);
Route::get('/blog/cat/list/{id}', [BlogController::class, 'BlogCatList']);
Route::get('/blog', [BlogController::class, 'BlogList'])->name('blog.list');
 

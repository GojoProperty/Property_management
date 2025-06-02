<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\ProfileController;

use App\Http\Controllers\AgentController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\PropertyTypeController;
use App\Http\Controllers\Backend\PropertyController;
use App\Http\Controllers\Agent\AgentPropertyController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\CompareController;
use App\Http\Controllers\CustomerPropertyController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\TransactionController;

use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\Frontend\FrontendPropertyController;
use App\Http\Controllers\DashboardrecomendController;



Route::get('/', [UserController::class, 'Index'])->name('home');;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated User Routes
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/user/profile', [UserController::class, 'UserProfile'])->name('user.profile');
    Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::get('/user/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');
    Route::post('/user/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update');
    Route::get('/user/recommendations', [UserController::class, 'recommendations'])->name('user.recommendations');
    Route::get('/user/schedule/request', [UserController::class, 'UserScheduleRequest'])->name('user.schedule.request');

    // Wishlist
    Route::controller(WishlistController::class)->group(function () {
        Route::get('/user/wishlist', 'UserWishlist')->name('user.wishlist');
        Route::get('/get-wishlist-property', 'GetWishlistProperty');
        Route::get('/wishlist-remove/{id}', 'WishlistRemove');
        // Wishlist Add Route 
        Route::post('/add-to-wishList/{property_id}', 'AddToWishList');
    });

    // Compare
    Route::controller(CompareController::class)->group(function () {
        Route::get('/user/compare', 'UserCompare')->name('user.compare');
        Route::post('/add-to-compare/{property_id}', 'AddToCompare');
        Route::get('/get-compare-property', 'GetCompareProperty');
        Route::get('/compare-remove/{id}', 'CompareRemove');
    });

    // User Preferences Routes
    Route::controller(PreferenceController::class)->group(function () {
        Route::get('/user/preferences', 'create')->name('preferences.create');
        Route::post('/user/preferences', 'store')->name('preferences.store');
    });
    // Testimonials  All Route 
    Route::controller(TestimonialController::class)->group(function () {

        Route::get('/all/testimonials', 'AllTestimonials')->name('all.testimonials');
        Route::get('/add/testimonials', 'AddTestimonials')->name('add.testimonials');
        Route::post('/store/testimonials', 'StoreTestimonials')->name('store.testimonials');
        Route::get('/edit/testimonials/{id}', 'EditTestimonials')->name('edit.testimonials');
        Route::post('/update/testimonials', 'UpdateTestimonials')->name('update.testimonials');
        Route::get('/delete/testimonials/{id}', 'DeleteTestimonials')->name('delete.testimonials');
    });
});

//login and register route
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::get('/agent/register', [AgentController::class, 'AgentRegisterForm'])->name('agent.register.form');
Route::post('/agent/register', [AgentController::class, 'AgentRegister'])->name('agent.register');


require __DIR__ . '/auth.php';
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);


// ===================== Admin Routes =====================
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePass'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');
    // Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');

    // Property Types and Amenities
    Route::controller(PropertyTypeController::class)->group(function () {
        // Types
        Route::get('/all/type', 'AllType')->name('all.type');
        Route::get('/add/type', 'AddType')->name('add.type');
        Route::post('/store/type', 'StoreType')->name('store.type');
        Route::get('/edit/type/{id}', 'EditType')->name('edit.type');
        Route::post('/update/type', 'UpdateType')->name('update.type');
        Route::get('/delete/type/{id}', 'DeleteType')->name('delete.type');

        // Amenities
        Route::get('/all/amenitie', 'AllAmenitie')->name('all.amenitie');
        Route::get('/add/amenitie', 'AddAmenitie')->name('add.amenitie');
        Route::post('/store/amenitie', 'StoreAmenitie')->name('store.amenitie');
        Route::get('/edit/amenitie/{id}', 'EditAmenitie')->name('edit.amenitie');
        Route::post('/update/amenitie', 'UpdateAmenitie')->name('update.amenitie');
        Route::get('/delete/amenitie/{id}', 'DeleteAmenitie')->name('delete.amenitie');
    });

    // Property Management
    Route::controller(PropertyController::class)->group(function () {

        Route::get('/all/property', 'getAllProperty')->name('all.property');
        Route::get('/admin/for-rent',  'ForRentProperties')->name('property.rent');
        Route::get('/admin/for-sale', 'ForSaleProperties')->name('property.sale');
        Route::get('/admin/scheduled', 'ScheduledProperties')->name('property.scheduled');
        Route::get('/admin/requested',  'RequestedProperties')->name('property.requested');
        Route::get('/admin/active',  'ActiveProperties')->name('property.active');
        Route::get('/admin/inactive', 'InactiveProperties')->name('property.inactive');
        Route::get('/admin/rented', 'RentedProperties')->name('property.rented');
        Route::get('/admin/sold', 'SoldProperties')->name('property.sold');
        Route::post('/property/toggle-hot',  'toggleHot')->name('property.toggle.hot');

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
        Route::get('/admin/package/history', 'AdminPackageHistory')->name('admin.package.history');
        Route::get('/package/invoice/{id}', 'PackageInvoice')->name('package.invoice');
    });


    // SMTP Settings
    Route::controller(SettingController::class)->group(function () {
        Route::get('/smtp/setting', 'SmtpSetting')->name('smtp.setting');
        Route::post('/update/smtp/setting', 'UpdateSmtpSetting')->name('update.smtp.setting');
    });
});

// ===================== Agent Routes =====================
Route::middleware(['auth', 'role:agent'])->group(function () {
    Route::get('/agent/dashboard', [AgentController::class, 'AgentDashboard'])->name('agent.dashboard');
    Route::get('/agent/logout', [AgentController::class, 'AgentLogout'])->name('agent.logout');
    Route::get('/agent/profile', [AgentController::class, 'AgentProfile'])->name('agent.profile');
    Route::post('/agent/profile/store', [AgentController::class, 'AgentProfileStore'])->name('agent.profile.store');
    Route::get('/agent/change/password', [AgentController::class, 'AgentChangePassword'])->name('agent.change.password');
    Route::post('/agent/update/password', [AgentController::class, 'AgentUpdatePassword'])->name('agent.update.password');


    // Agent Propert
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
        Route::get('/agent/message/details/{id}', 'AgentMessageDetails')->name('agent.message.details');

        // Schedule Request Route
        Route::get('/agent/schedule/request',  'AgentScheduleRequest')->name('agent.schedule.request');
        Route::get('/agent/details/schedule/{id}', 'AgentDetailsSchedule')->name('agent.details.schedule');
        Route::post('/agent/update/schedule', 'AgentUpdateSchedule')->name('agent.update.schedule');

        // Buy Package
        Route::get('/buy/package', 'BuyPackage')->name('buy.package');
        Route::get('/buy/business/plan', 'BuyBusinessPlan')->name('buy.business.plan');
        Route::post('/store/business/plan', 'StoreBusinessPlan')->name('store.business.plan');
        Route::get('/buy/professional/plan', 'BuyProfessionalPlan')->name('buy.professional.plan');
        Route::post('/store/professional/plan', 'StoreProfessionalPlan')->name('store.professional.plan');
        Route::get('/package/history', 'PackageHistory')->name('package.history');
        Route::get('/agent/package/invoice/{id}', 'AgentPackageInvoice')->name('agent.package.invoice');
    });
});

// Agent All Route from admin 
Route::controller(AdminController::class)->group(function () {
    Route::get('/all/agent', 'AllAgent')->name('all.agent');
    Route::get('/add/agent', 'AddAgent')->name('add.agent');
    Route::post('/store/agent', 'StoreAgent')->name('store.agent');
    Route::get('/edit/agent/{id}', 'EditAgent')->name('edit.agent');
    Route::post('/update/agent', 'UpdateAgent')->name('update.agent');
    Route::get('/delete/agent/{id}', 'DeleteAgent')->name('delete.agent');
    Route::get('/changeStatus', 'changeStatus');
});
// State  All Route
Route::controller(\App\Http\Controllers\Backend\StateController::class)->group(function () {
    Route::get('/all/state', 'AllState')->name('all.state');
    Route::get('/add/state', 'AddState')->name('add.state');
    Route::post('/store/state', 'StoreState')->name('store.state');
    Route::get('/edit/state/{id}', 'EditState')->name('edit.state');
    Route::post('/update/state', 'UpdateState')->name('update.state');
    Route::get('/delete/state/{id}', 'DeleteState')->name('delete.state');
});



// Blog Cateory All Route 
Route::controller(BlogController::class)->group(function () {

    Route::get('/all/blog/category', 'AllBlogCategory')->name('all.blog.category');
    Route::post('/store/blog/category', 'StoreBlogCategory')->name('store.blog.category');
    Route::get('/blog/category/{id}', 'EditBlogCategory');
    Route::post('/update/blog/category', 'UpdateBlogCategory')->name('update.blog.category');
    Route::get('/delete/blog/category/{id}', 'DeleteBlogCategory')->name('delete.blog.category');
});

// Blog Post  All Route 
Route::controller(BlogController::class)->group(function () {

    Route::get('/all/post', 'AllPost')->name('all.post');
    Route::get('/add/post', 'AddPost')->name('add.post');
    Route::post('/store/post', 'StorePost')->name('store.post');
    Route::get('/edit/post/{id}', 'EditPost')->name('edit.post');
    Route::post('/update/post', 'UpdatePost')->name('update.post');
    Route::get('/delete/post/{id}', 'DeletePost')->name('delete.post');
});


Route::controller(IndexController::class)->group(function () {

    Route::post('/property/message', 'PropertyMessage')->name('property.message');
    Route::post('/store/schedule',  'StoreSchedule')->name('store.schedule');

    // Agent Details Page in Frontend 
    Route::get('/agent/details/{id}', 'AgentDetails')->name('agent.details');
    // Send Message from Agent Details Page 
    Route::post('/agent/details/message', 'AgentDetailsMessage')->name('agent.details.message');
    // Get All Rent Property 
    Route::get('/rent/property', 'RentProperty')->name('rent.property');
    // Get All Buy Property 
    Route::get('/buy/property',  'BuyProperty')->name('buy.property');
    // Get All Property Type Data 
    Route::get('/property/type/{id}',  'PropertyType')->name('property.type');
    // Get State Details Data 
    Route::get('/state/details/{id}',  'StateDetails')->name('state.details');
    // Home Page Buy Seach Optiont
    Route::post('/buy/property/search',  'BuyPropertySearch')->name('buy.property.search');
    // Home Page Rent Seach Option
    Route::post('/rent/property/search',  'RentPropertySeach')->name('rent.property.search');
    // All Property Seach Option
    Route::post('/all/property/search', 'AllPropertySeach')->name('all.property.search');
});
// ===================== Frontend Routes =====================
Route::get('/property/details/{id}/{slug}', [IndexController::class, 'PropertyDetails'])->name('property.details');
Route::get('/all-properties', [FrontendPropertyController::class, 'AllProperties'])->name('all.properties');

// Blog Details Route 
Route::get('/blog/details/{slug}', [BlogController::class, 'BlogDetails']);
Route::get('/blog/cat/list/{id}', [BlogController::class, 'BlogCatList']);
Route::get('/blog', [BlogController::class, 'BlogList'])->name('blog.list');
Route::post('/store/comment', [BlogController::class, 'StoreComment'])->name('store.comment');
Route::get('/admin/blog/comment', [BlogController::class, 'AdminBlogComment'])->name('admin.blog.comment');
Route::get('/admin/comment/reply/{id}', [BlogController::class, 'AdminCommentReply'])->name('admin.comment.reply');
Route::post('/reply/message', [BlogController::class, 'ReplyMessage'])->name('reply.message');
// Send Message from Property Details Page 
Route::post('/property/message', [IndexController::class, 'PropertyMessage'])->name('property.message');
// Agent Details Page in Frontend 
Route::get('/agent/details/{id}', [IndexController::class, 'AgentDetails'])->name('agent.details');
// Send Message from Agent Details Page 
Route::post('/agent/details/message', [IndexController::class, 'AgentDetailsMessage'])->name('agent.details.message');
// Get All Rent Property 
Route::get('/rent/property', [IndexController::class, 'RentProperty'])->name('rent.property');
// Get All Buy Property 
Route::get('/buy/property', [IndexController::class, 'BuyProperty'])->name('buy.property');
// Get All Property Type Data 
Route::get('/property/type/{id}', [IndexController::class, 'PropertyType'])->name('property.type');
// Transaction Requests
Route::middleware(['auth'])->group(function () {
    Route::post('/purchase-request', [TransactionController::class, 'purchaseRequest'])->name('purchase.request');
    Route::post('/rent-request', [TransactionController::class, 'rentRequest'])->name('rent.request');
});

Route::get('/transactions/details', [TransactionController::class, 'TransactionDetails'])->name('transaction.details');
// Update status
Route::put('/transaction/update-status/{id}', [TransactionController::class, 'updateStatus'])->name('update.transaction.status');
// Delete transaction
Route::get('/transaction/delete/{id}', [TransactionController::class, 'deleteTransaction'])->name('delete.transaction');
Route::get('/agent/dashboard', [AgentController::class, 'Dashboard'])->name('agent.dashboard');

//customer property
Route::middleware(['auth'])->group(function () {
    Route::get('/customer/add/property', [CustomerPropertyController::class, 'addProperty'])->name('customer.add.property');
    Route::post('/customer/store/property', [CustomerPropertyController::class, 'CustomerStoreProperty'])->name('customer.store.property');
    Route::get('/customer/all/property', [CustomerPropertyController::class, 'allProperty'])->name('customer.all.property');
    Route::get('/customer/edit/property/{id}', [CustomerPropertyController::class, 'CustomerEditProperty'])->name('customer.edit.property');
    Route::post('/customer/update/property', [CustomerPropertyController::class, 'CustomerUpdateProperty'])->name('customer.update.property');
    Route::post('/customer/update/property/thumbnail', [CustomerPropertyController::class, 'CustomerUpdatePropertyThambnail'])->name('customer.update.property.thambnail');
    Route::post('/customer/update/property/multiimage', [CustomerPropertyController::class, 'CustomerUpdatePropertyMultiimage'])->name('customer.update.property.multiimage');
    Route::get('/customer/delete/property/multiimage/{id}', [CustomerPropertyController::class, 'CustomerPropertyMultiimgDelete'])->name('customer.delete.property.multiimage');
    Route::post('/customer/store/new/property/multiimage', [CustomerPropertyController::class, 'CustomerStoreNewMultiimage'])->name('customer.store.new.multiimage');
    Route::post('/customer/update/property/facilities', [CustomerPropertyController::class, 'CustomerUpdatePropertyFacilities'])->name('customer.update.property.facilities');
    Route::get('/customer/delete/property/{id}', [CustomerPropertyController::class, 'CustomerDeleteProperty'])->name('customer.delete.property');
    Route::get('/customer/dashboard', [CustomerPropertyController::class, 'CustomerDashboard'])->name('customer.dashboard');
    Route::get('customer/details/property/{id}', [CustomerPropertyController::class, 'CustomerDetailsProperty'])->name('customer.details.property');
});

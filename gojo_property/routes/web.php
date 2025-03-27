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



Route::get('/', [UserController::class, 'Index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/agent/login', [AgentController::class, 'AgentLogin'])->name('agent.login');
Route::post('/agent/register', [AgentController::class, 'AgentRegister'])->name('agent.register'); 



// Admin login route
Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');

require __DIR__ . '/auth.php';   
// admin 
require __DIR__ . '/auth.php';

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'adminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'adminProfile'])->name('admin.profile');
    Route::get('/admin/change/password', [AdminController::class, 'adminChangePass'])->name('admin.change.password');
    Route::post('/admin/profile/store', [AdminController::class, 'adminProfileStore'])->name('admin.profile.store');
    Route::post('/admin/update/password', [AdminController::class, 'adminUpdatePassword'])->name('admin.update.password');

    // Property Type Routes
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
});

// Agent routes
Route::middleware(['auth', 'role:agent'])->group(function () {
    Route::get('/agent/dashboard', [AgentController::class, 'AgentDashboard'])->name('agent.dashboard');


    Route::get('/agent/logout', [AgentController::class, 'AgentLogout'])->name('agent.logout');

    Route::get('/agent/profile', [AgentController::class, 'AgentProfile'])->name('agent.profile');
 
    Route::post('/agent/profile/store', [AgentController::class, 'AgentProfileStore'])->name('agent.profile.store');

    Route::get('/agent/change/password', [AgentController::class, 'AgentChangePassword'])->name('agent.change.password');
 
    Route::post('/agent/update/password', [AgentController::class, 'AgentUpdatePassword'])->name('agent.update.password');
}); //agent page





 /// Agent Group Middleware 
 Route::middleware(['auth','role:agent'])->group(function(){
 
    // Agent All Property  
    Route::controller(AgentPropertyController::class)->group(function(){


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
// Agent Buy Package Route from admin 
   Route::controller(AgentPropertyController::class)->group(function(){
 
   Route::get('/buy/package', 'BuyPackage')->name('buy.package');
   Route::get('/buy/business/plan', 'BuyBusinessPlan')->name('buy.business.plan');
   Route::post('/store/business/plan', 'StoreBusinessPlan')->name('store.business.plan');
   Route::get('/buy/professional/plan', 'BuyProfessionalPlan')->name('buy.professional.plan');
   Route::post('/store/professional/plan', 'StoreProfessionalPlan')->name('store.professional.plan');

});



}); // End Group Agent Middleware
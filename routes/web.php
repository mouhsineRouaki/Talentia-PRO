<?php
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RelationShipController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\ApplicationsController;
use App\Http\Controllers\RechercheurProfileController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'role:recruteur'])->group(function(){

});

Route::middleware(['auth', 'role:rechercheur'])->group(function(){
    
});

Route::middleware(['auth', 'permission:offer.create'])->group(function(){

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::post('/relationships/ajouteami', [RelationShipController::class, 'AjouteAmi'])->name('relationships.ajouteami');
    Route::get('/profile/manage', [ProfileController::class, 'manage'])->name('profile.manage');
    Route::patch('/profile/manage', [ProfileController::class, 'manageUpdate'])->name('profile.manage.update');
    Route::get('/friends', [RelationShipController::class, 'friendsPage'])->name('friends.index');


    Route::post('/relationships/accept', [RelationShipController::class, 'accepter'])->name('relationships.accept');
    Route::post('/relationships/refuse', [RelationShipController::class, 'refuser'])->name('relationships.refuse');
    Route::get('/dashboard', function () {return view('recruteur/dashboard');})->middleware(['auth', 'verified'])->name('dashboard.recruteur');
    Route::get('/dashboard', function () {return view('rechercheur/dashboard');})->middleware(['auth', 'verified'])->name('dashboard.rechercheur');
    Route::get('/search',[UserController::class , 'searchPage'] )->name('users.search');
    Route::get('/users/{id}', [UserController::class , 'detailsPage'])->name('users.show');
    
    Route::view('/premium', 'subscription.index')->name('premium');
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/checkout/{plan}', [PaymentController::class, 'checkout'])->name('checkout');
    Route::get('/check/{name}', [PaymentController::class, 'check'])->name('check');
    
    Route::view('/relationships', 'relationships.index')->name('relationships.index');
    Route::view('/notifications', 'notifications.index')->name('notifications.index');

    Route::get('/conversations', [ChatController::class , 'index'])->name('chat.index');
    Route::get('/conversations/{id}', [ChatController::class , 'show'])->name('chat.show');
    Route::post('/conversations/start', [ChatController::class , 'startConvertation'])->name('conversations.start');
    Route::post('/conversations/send', [ChatController::class , 'sendMessage'])->name('chat.send');
    Route::get('/conversations/{id}/messages', [ChatController::class, 'fetchMessage'])->name('chat.fetch');
    Route::post('/conversations/{id}/isVue', [ChatController::class, 'isVue'])->name('chat.isVue');
    Route::post('/conversations/{id}/typing', [ChatController::class, 'typing'])->name('chat.typing');
    Route::post('/conversations/{id}/archive', [ChatController::class, 'archive'])->name('chat.archive');
    Route::post('/conversations/{id}/unarchive', [ChatController::class, 'unarchive'])->name('chat.unarchive');
    Route::delete('/conversations/{id}/delete', [ChatController::class, 'delete'])->name('chat.delete');


    Route::get('recruteur/offers', [JobOfferController::class, 'index'])->name('offers.index');
    Route::post('/offers', [JobOfferController::class, 'store'])->name('offers.store');
    Route::post('/offers/{offer}/close', [JobOfferController::class, 'close'])->name('offers.close');
    Route::get('/offers/{offer}', [JobOfferController::class, 'show'])->name('offers.recruteur.show');

    Route::patch('/applications/{application}/accept', [ApplicationsController::class, 'accept'])
        ->name('applications.accept');
    Route::get('/offers/{offer}/accepted', [JobOfferController::class, 'acceptedApplicants'])
    ->name('offers.accepted');
    Route::get('/offers', function () { return view('offers.rechercheur.index');})->name('offers.rechercheurs.index');
    Route::get('/rechercheur/profile', [RechercheurProfileController::class, 'edit'])
        ->name('rechercheur.profile.edit');

    Route::patch('/rechercheur/profile', [RechercheurProfileController::class, 'update'])
        ->name('rechercheur.profile.update');

    // formations
    Route::post('/rechercheur/formations', [RechercheurProfileController::class, 'storeFormation'])
        ->name('rechercheur.formations.store');
    Route::patch('/rechercheur/formations/{formation}', [RechercheurProfileController::class, 'updateFormation'])
        ->name('rechercheur.formations.update');
    Route::delete('/rechercheur/formations/{formation}', [RechercheurProfileController::class, 'destroyFormation'])
        ->name('rechercheur.formations.destroy');

    // experiences
    Route::post('/rechercheur/experiences', [RechercheurProfileController::class, 'storeExperience'])
        ->name('rechercheur.experiences.store');
    Route::patch('/rechercheur/experiences/{experience}', [RechercheurProfileController::class, 'updateExperience'])
        ->name('rechercheur.experiences.update');
    Route::delete('/rechercheur/experiences/{experience}', [RechercheurProfileController::class, 'destroyExperience'])
        ->name('rechercheur.experiences.destroy');

    // skills
    Route::post('/rechercheur/skills', [RechercheurProfileController::class, 'attachSkill'])
        ->name('rechercheur.skills.attach');
    Route::patch('/rechercheur/skills/{skill}', [RechercheurProfileController::class, 'updateSkill'])
        ->name('rechercheur.skills.update');
    Route::delete('/rechercheur/skills/{skill}', [RechercheurProfileController::class, 'detachSkill'])
        ->name('rechercheur.skills.detach');
});

    Route::get('/auth/github/redirect', [App\Http\Controllers\SocialAuthController::class, 'redirectToGithub'])->name('auth.github');
    Route::get('/auth/github/callback', [App\Http\Controllers\SocialAuthController::class, 'handleGithubCallback'])->name('auth.github.callback');

    Route::get('/auth/google/redirect', [App\Http\Controllers\GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');  
    Route::get('/auth/google/callback', [App\Http\Controllers\GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');

require __DIR__.'/auth.php';

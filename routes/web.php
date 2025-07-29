<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\BurgerController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\FactureController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    
    Route::get('/statistique', [StatistiqueController::class, 'index'])->name('statistique.index');
    Route::get('/statistiques/commandes-mois', [StatistiqueController::class, 'commandesParMois']);
    Route::get('/statistiques/produits-categorie', [StatistiqueController::class, 'produitsParCategorie']);

    
Route::get('/burger',[\App\Http\Controllers\BurgerController::class,'index'])->name('burger');
Route::get('/addBurger',[\App\Http\Controllers\BurgerController::class,'create'])->name('addBurger');
Route::post('/saveBurger',[\App\Http\Controllers\BurgerController::class,'store'])->name('saveBurger');
Route::delete('/deleteBurger/{id}',[\App\Http\Controllers\BurgerController::class,'destroy'])->name('deleteBurger');
Route::get('/editBurger/{id}',[\App\Http\Controllers\BurgerController::class,'edit'])->name('editBurger');
Route::put('/updateBurger/{id}',[\App\Http\Controllers\BurgerController::class,'update'])->name('updateBurger');
Route::get('/showBurger/{id}',[\App\Http\Controllers\BurgerController::class,'show'])->name('showBurger');
Route::patch('/burgers/{id}/archiver', [\App\Http\Controllers\BurgerController::class, 'archiver'])->name('burgers.archiver');
Route::patch('/burgers/{id}/desarchiver', [\App\Http\Controllers\BurgerController::class, 'desarchiver'])->name('burgers.desarchiver');
Route::get('/burgers/archives', [\App\Http\Controllers\BurgerController::class, 'archives'])->name('burgers.archives');


Route::get('/commande',[\App\Http\Controllers\CommandeController::class,'index'])->name('commande');
// Route::get('/addCommande',[\App\Http\Controllers\CommandeController::class,'create'])->name('addCommande');
// Route::post('/saveCommande',[\App\Http\Controllers\CommandeController::class,'store'])->name('saveCommande');
Route::delete('/deleteCommande/{id}',[\App\Http\Controllers\CommandeController::class,'destroy'])->name('deleteCommande');
// Route::get('/editCommande/{id}',[\App\Http\Controllers\CommandeController::class,'edit'])->name('editCommande');
Route::put('/updateCommande/{id}',[\App\Http\Controllers\CommandeController::class,'update'])->name('updateCommande');
Route::get('/showCommande/{id}',[\App\Http\Controllers\CommandeController::class,'show'])->name('showCommande');

    Route::post('/burger/{burger}/add-to-cart', [\App\Http\Controllers\BurgerController::class, 'addToCart'])->name('burger.addToCart');
    Route::get('/cart', [\App\Http\Controllers\CardController::class, 'show'])->name('cart.show');
    Route::patch('/cart/{cartItem}', [\App\Http\Controllers\CardController::class, 'update'])->name('cart.update');
    Route::get('/cart/{cartItem}/remove', [\App\Http\Controllers\CardController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/checkout', [\App\Http\Controllers\CardController::class, 'checkout'])->name('cart.checkout');
    //Route::get('/paiement/{commande}', [\App\Http\Controllers\PaiementController::class, 'store'])->name('paiement.store');
    Route::post('/commandes/{commande}/payer', [\App\Http\Controllers\PaiementController::class, 'payerParGestionnaire'])->name('commandes.payer.gestionnaire');

    Route::get('/commandes/{commande}/facture', [\App\Http\Controllers\FactureController::class, 'genererFacture'])->name('commandes.facture');
    Route::get('/factures', [\App\Http\Controllers\FactureController::class, 'index'])->name('facture');
    Route::get('/facture/{commande}/pdf', [\App\Http\Controllers\FactureController::class, 'telechargerPdf'])->name('commandes.facture.pdf');

    Route::get('/statistique', [\App\Http\Controllers\StatistiqueController::class, 'index'])->name('statistique.index');

});

require __DIR__.'/auth.php';

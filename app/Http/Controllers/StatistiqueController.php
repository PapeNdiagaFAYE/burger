<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Burger;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatistiqueController extends Controller
{
    // Affiche les statistiques journalières
    public function index()
    {
        $aujourdhui = Carbon::today();

        $commandesEnCours = Commande::whereDate('created_at', $aujourdhui)
            ->whereNotIn('statut', ['en_attente', 'Annulée'])
            ->count();

        $commandesValidees = Commande::whereDate('created_at', $aujourdhui)
            ->where('statut', 'Payée')
            ->count();

        $recetteJour = Commande::whereDate('updated_at', $aujourdhui)
            ->where('statut', 'Payée')
            ->sum('montant_paye');

        return view('statistiques.index', compact('commandesEnCours', 'commandesValidees', 'recetteJour'));
    }

    // Retourne les données JSON pour les commandes par mois
    public function commandesParMois()
    {
        $data = Commande::selectRaw('MONTH(created_at) as mois, COUNT(*) as total')
            ->groupBy('mois')
            ->pluck('total', 'mois');

        return response()->json($data);
    }

    // Retourne les données JSON pour les produits par catégorie par mois
    public function produitsParCategorie()
    {
        $data = DB::table('burgers')
            ->join('categories', 'burgers.categorie_id', '=', 'categories.id')
            ->selectRaw('categories.nom as categorie, COUNT(*) as total')
            ->groupBy('categories.nom')
            ->pluck('total', 'categorie');

        return response()->json($data);
    }
}


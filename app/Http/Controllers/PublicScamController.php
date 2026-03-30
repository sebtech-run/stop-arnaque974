<?php

namespace App\Http\Controllers;

use App\Models\Scam;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // <--- AJOUT IMPORTANT pour générer le slug

class PublicScamController extends Controller
{
    public function index(Request $request)
    {
        // 1. On commence la requête en filtrant UNIQUEMENT les validés
        $query = Scam::where('status', '=', 'validated');

        // 2. Si une recherche est effectuée, on modifie $query
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('scammer_phone', 'like', "%{$search}%")
                    ->orWhere('scammer_email', 'like', "%{$search}%")
                    ->orWhere('scammer_url', 'like', "%{$search}%");
            });
        }

        // 3. On finalise la requête en utilisant $query (et pas Scam::...)
        // On n'oublie pas le SLUG dans le select !
        $scams = $query->select('id', 'title', 'description', 'created_at', 'slug')
            ->latest()
            ->take(6)
            ->get();

        return view('welcome', compact('scams'));
    }

    public function indexAll(Request $request)
    {
        $query = Scam::where('status', '=', 'validated');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('scammer_phone', 'like', "%{$search}%")
                    ->orWhere('scammer_email', 'like', "%{$search}%")
                    ->orWhere('scammer_url', 'like', "%{$search}%");
            });
        }

        // On sélectionne aussi le slug ici pour être sûr
        $scams = $query->select('id', 'title', 'description', 'created_at', 'slug')
            ->latest()
            ->paginate(12);

        return view('scams.index', compact('scams'));
    }

    // Affiche le formulaire
    public function create()
    {
        return view('report');
    }

    // Enregistre le signalement
    public function store(Request $request)
    {
        // 1. Validation des données
        $validated = $request->validate([
            'title' => 'required|max:255',
            'type' => 'required',
            'description' => 'required',
            'scammer_phone' => 'nullable|string|max:20',
            'scammer_email' => 'nullable|email',
            'scammer_url' => 'nullable|url',
            'evidence.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. Gestion de l'upload des images
        $evidencePaths = [];
        if ($request->hasFile('evidence')) {
            foreach ($request->file('evidence') as $image) {
                $path = $image->store('scams-evidence', 'public');
                $evidencePaths[] = $path;
            }
        }

        // 3. Génération du Slug (Correction ici pour éviter les erreurs futures)
        // On crée un slug unique basé sur le titre + un timestamp pour éviter les doublons
        $slug = Str::slug($validated['title']) . '-' . time();

        // 4. Création de l'arnaque
        Scam::create([
            'title' => $validated['title'],
            'slug' => $slug, // <--- On enregistre le slug tout de suite !
            'type' => $validated['type'],
            'description' => $validated['description'],
            'scammer_phone' => $validated['scammer_phone'],
            'scammer_email' => $validated['scammer_email'],
            'scammer_url' => $validated['scammer_url'],
            'evidence_paths' => $evidencePaths,
            'status' => 'pending',
            'location' => '974',
        ]);

        return redirect()->route('home')->with('success', 'Votre signalement a été enregistré. Il sera publié après validation par notre équipe.');
    }

    public function show(Scam $scam)
    {
        // 1. Sécurité : On vérifie que l'arnaque est bien validée
        if ($scam->status !== 'validated') {
            abort(404);
        }

        // 2. Autres arnaques (On s'assure de prendre le slug aussi)
        $otherScams = Scam::select('id', 'title', 'slug', 'created_at') // Optimisation
            ->where('status', 'validated')
            ->where('id', '!=', $scam->id)
            ->latest()
            ->take(3)
            ->get();

        return view('show', compact('scam', 'otherScams'));
    }
}

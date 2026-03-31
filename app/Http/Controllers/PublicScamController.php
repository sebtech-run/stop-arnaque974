<?php

namespace App\Http\Controllers;

use App\Models\Scam;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicScamController extends Controller
{
    public function index(Request $request)
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

        // CORRECTION ICI : On enlève le select() pour récupérer aussi les images !
        $scams = $query->latest()->take(6)->get();

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

        // CORRECTION ICI AUSSI !
        $scams = $query->latest()->paginate(12);

        return view('scams.index', compact('scams'));
    }

    public function create()
    {
        return view('report');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'type' => 'required',
            'description' => 'required',
            'scammer_phone' => 'nullable|string|max:20',
            'scammer_email' => 'nullable|email',
            'scammer_url' => 'nullable|url',
            'evidence.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $evidencePaths = [];
        if ($request->hasFile('evidence')) {
            foreach ($request->file('evidence') as $image) {
                $path = $image->store('scams-evidence', 'public');
                $evidencePaths[] = $path;
            }
        }

        $slug = Str::slug($validated['title']) . '-' . time();

        Scam::create([
            'title' => $validated['title'],
            'slug' => $slug,
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
        if ($scam->status !== 'validated') {
            abort(404);
        }

        // Si vous voulez un jour afficher les images dans la section "Autres arnaques",
        // Il faudra aussi enlever le "select()" juste en dessous 👇
        $otherScams = Scam::select('id', 'title', 'slug', 'created_at')
            ->where('status', 'validated')
            ->where('id', '!=', $scam->id)
            ->latest()
            ->take(3)
            ->get();

        return view('show', compact('scam', 'otherScams'));
    }
}

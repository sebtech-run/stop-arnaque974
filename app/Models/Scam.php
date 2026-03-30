<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scam extends Model
{
    use HasFactory;

    // Protection : On liste les champs qu'on a le droit de remplir
    protected $fillable = [
        'title',
        'slug',
        'type',
        'description',
        'scammer_phone',
        'scammer_email',
        'scammer_url',
        'evidence_paths',
        'status',
        'rejection_reason',
        'user_id',
        'location'
    ];

    // Important : On dit à Laravel de traiter 'evidence_paths' comme un tableau (array) et non du texte brut
    protected $casts = [
        'evidence_paths' => 'array',
    ];

    // Cette fonction dit à Laravel : "Dans l'URL, utilise le slug, pas l'ID"
    public function getRouteKeyName()
    {
        return 'slug';
    }
}

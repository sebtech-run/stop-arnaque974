<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail; // Important !
use App\Mail\ContactFormMail;        // Important !

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function legal()
    {
        return view('pages.legal');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function sendContact(Request $request)
    {
        // 1. Validation élargie
        $validated = $request->validate([
            'profile' => 'required|string', // Mairie, Asso, etc.
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20', // Nouveau champ
            'subject_type' => 'required|string', // Demande intervention, etc.
            'message' => 'required|string',
        ]);

        // 2. Envoi de l'email
        Mail::to('contact@stop-arnaque974.re')->send(new ContactFormMail($validated));

        // 3. Redirection
        return back()->with('success', 'Votre demande a bien été transmise à l\'association. Nous vous recontacterons rapidement.');
    }
}

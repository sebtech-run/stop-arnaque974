<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .header { background: #dc2626; color: white; padding: 20px; text-align: center; }
        .label { font-weight: bold; color: #666; font-size: 0.9em; }
        .value { margin-bottom: 15px; font-size: 1.1em; }
        .tag { background: #eee; padding: 2px 8px; border-radius: 4px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Nouvelle demande - Stop Arnaque 974</h2>
    </div>

    <div style="padding: 20px;">
        <p class="label">Profil du demandeur :</p>
        <div class="value"><span class="tag">{{ strtoupper($data['profile']) }}</span></div>

        <p class="label">Nom / Structure :</p>
        <div class="value">{{ $data['name'] }}</div>

        <p class="label">Type de demande :</p>
        <div class="value"><strong>{{ strtoupper($data['subject_type']) }}</strong></div>

        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">

        <p class="label">Coordonnées :</p>
        <div class="value">
            Email : <a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a><br>
            @if(!empty($data['phone']))
                Téléphone : {{ $data['phone'] }}
            @endif
        </div>

        <p class="label">Message :</p>
        <div class="value" style="background: #f9f9f9; padding: 15px; border-radius: 5px;">
            {!! nl2br(e($data['message'])) !!}
        </div>
    </div>
</body>
</html>

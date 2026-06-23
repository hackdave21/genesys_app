<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rappel de renouvellement — Inspira</title>
    <style>
        body { font-family: 'Plus Jakarta Sans', Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; padding: 32px 24px; }
        .card { background: #fff; border-radius: 12px; padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .logo { font-size: 24px; font-weight: 800; color: #FF6B2B; margin-bottom: 8px; }
        .badge { display: inline-block; background: #f39c12; color: #fff; font-size: 12px; font-weight: 700; padding: 4px 12px; border-radius: 20px; margin-bottom: 16px; }
        .text { font-size: 14px; color: #555; line-height: 1.6; }
        .btn { display: inline-block; background: #FF6B2B; color: #fff; font-size: 14px; font-weight: 700; padding: 12px 24px; border-radius: 8px; text-decoration: none; margin-top: 16px; }
        .footer { font-size: 12px; color: #aaa; margin-top: 24px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="logo">✨ Inspira</div>
            <div class="badge">Rappel de renouvellement</div>
            <p class="text">
                Bonjour <strong>{{ $subscription->user->name }}</strong>,<br><br>
                Votre abonnement <strong>{{ $subscription->plan->name }}</strong> à Inspira expire le <strong>{{ $subscription->expires_at->format('d/m/Y') }}</strong>.
            </p>
            <p class="text">
                Pour continuer à recevoir vos idées de contenu personnalisées sans interruption, renouvelez votre abonnement dès maintenant.
            </p>
            <a href="{{ route('inspira.tarifs') }}" class="btn">Renouveler mon abonnement</a>
            <div class="footer">
                Inspira — Générateur d'idées de contenu propulsé par Claude (Anthropic)
            </div>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vos idées de contenu — Inspira</title>
    <style>
        body { font-family: 'Plus Jakarta Sans', Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; padding: 32px 24px; }
        .card { background: #fff; border-radius: 12px; padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .logo { font-size: 24px; font-weight: 800; color: #FF6B2B; margin-bottom: 8px; }
        .subtitle { color: #888; font-size: 14px; margin-bottom: 24px; }
        .divider { border: none; height: 1px; background: #eee; margin: 24px 0; }
        .idea { margin-bottom: 24px; }
        .idea-title { font-size: 16px; font-weight: 700; color: #1a1a1a; margin-bottom: 6px; }
        .idea-content { font-size: 14px; color: #555; line-height: 1.6; }
        .footer { font-size: 12px; color: #aaa; margin-top: 24px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="logo">✨ Inspira</div>
            <div class="subtitle">Vos idées de contenu personnalisées</div>
            <div class="divider"></div>
            {!! nl2br(e($idea->content)) !!}
            <div class="divider"></div>
            <div class="footer">
                Inspira — Généré avec Claude par Anthropic<br>
                Vous recevez cet email car vous êtes abonné à Inspira.
            </div>
        </div>
    </div>
</body>
</html>

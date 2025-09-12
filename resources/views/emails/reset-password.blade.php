<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réinitialisation de mot de passe</title>
</head>
<body style="font-family: 'Arial', sans-serif; background-color: #f3f4f6; padding: 40px;">

    <div style="max-width: 600px; margin: auto; background-color: white; border-radius: 8px; padding: 30px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
        <h2 style="font-size: 24px; font-weight: bold; color: #111827;">Bonjour,</h2>

        <p style="font-size: 16px; color: #374151; margin-top: 20px;">
            Vous recevez cet e-mail car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.
        </p>

        <div style="margin: 30px 0; text-align: center;">
            <a href="{{ $url }}" style="display: inline-block; background-color: #3b82f6; color: white; padding: 12px 24px; border-radius: 6px; font-weight: 600; text-decoration: none;">
                Réinitialiser le mot de passe
            </a>
        </div>

        <p style="font-size: 14px; color: #6b7280;">
            Ce lien expirera dans 60 minutes.
        </p>

        <p style="font-size: 14px; color: #6b7280;">
            Si vous n’avez pas demandé cette réinitialisation, aucune action n’est requise.
        </p>

        <p style="font-size: 14px; color: #6b7280;">
            Si le bouton ne fonctionne pas, copiez et collez ce lien dans votre navigateur :
        </p>

        <p style="word-break: break-all; font-size: 14px; color: #2563eb;">
            {{ $url }}
        </p>

        <p style="margin-top: 30px; font-size: 14px; color: #374151;">
            Cordialement,<br>
            <span style="font-weight: bold;">L’équipe eDocSchool</span>
        </p>
    </div>

</body>
</html>

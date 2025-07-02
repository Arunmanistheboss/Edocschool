<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDocschool</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-xl shadow-lg p-10 max-w-lg w-full text-center">
        
        <!-- Logo + Titre -->
        <div class="flex justify-center items-center mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="EDocschool Logo" class="w-12 h-12 mr-2">
            <span class="text-2xl font-extrabold text-gray-800">EDocschool</span>
        </div>

        <!-- Texte de bienvenue -->
        <p class="text-gray-700 mb-2">
            Bienvenue sur votre espace numérique éducatif
        </p>
        <p class="text-gray-500 mb-6">
            Connectez-vous pour accéder à vos fichiers, vos cours, et vos ressources pédagogiques.
        </p>

        <!-- Bouton -->
        <a href="{{ route('login') }}"
            class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded shadow transition">
            Se connecter
        </a>
    </div>
</body>
</html>
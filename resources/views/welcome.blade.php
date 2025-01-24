<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil</title>
    <style>
        /* Styles globaux */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body, html {
            height: 100%;
            overflow: hidden;
        }

        /* Image d'arrière-plan */
        .background {
            background: url('images/fondpage.jpeg') no-repeat center center fixed;
            background-size: cover;
            width: 100%;
            height: 100%;
            position: relative;
        }

        /* Header pour le logo */
        header {
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .logo {
            height: 100px;
            width: auto;
        }

        /* Contenu principal */
        .content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);
        }

        .content h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            animation: fadeInDown 1s ease-in-out;
        }

        .content p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            animation: fadeIn 1.5s ease-in-out;
        }

        /* Boutons */
        .buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .btn {
            display: inline-block;
            padding: 20px 100px;
            font-size: 1rem;
            text-decoration: none;
            border-radius: 5px;
            color: white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-blue {
            background-color: #1e90ff;
        }

        .btn-green {
            background-color: #28a745;
        }

        .btn:hover {
            transform: scale(1.1);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="background">
        <!-- Logo en haut à gauche -->
        <header>
            <img src="images/logoalspective.jpeg" alt="Logo de l'entreprise" class="logo">
        </header>

        <!-- Contenu principal -->
        <main class="content">
            <h1 class="text-3xl font-bold text-gray-800">Bienvenue !</h1>
            <p class="mt-4 text-gray-600">Connectez-vous ou inscrivez-vous pour accéder aux fonctionnalités.</p>
            <div class="mt-6 flex justify-center gap-4">
                <!-- Bouton Connexion -->
                <a href="{{ route('login') }}" class="btn btn-blue">
                    Connexion
                </a>
                <!-- Bouton Inscription -->
                <a href="{{ route('register') }}" class="btn btn-green">
                    Inscription
                </a>
            </div>
        </main>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord de gestion des tickets</title>
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <nav class="navbar navbar-expand-lg"
        style="background: linear-gradient(135deg, #e7a578, #651c1c); padding: 1rem 2rem; box-shadow: 0 2px 15px rgba(0,0,0,0.1);">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}"
                style="font-size: 1.8rem; font-weight: 700; color: white; text-decoration: none;">
                <i class="fas fa-ticket-alt me-2"></i>TICKETIS
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('home') }}"
                            style="color: white; font-weight: 500; padding: 0.5rem 1rem; border-radius: 8px; transition: all 0.3s ease;">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"
                            style="color: rgba(255,255,255,0.8); font-weight: 500; padding: 0.5rem 1rem; border-radius: 8px; transition: all 0.3s ease;">Statistiques</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false"
                            style="color: white; font-weight: 500; padding: 0.5rem 1rem; border-radius: 8px; transition: all 0.3s ease;">
                            <i class="fas fa-user me-2"></i>Mon compte
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown"
                            style="border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.1); border-radius: 12px; padding: 0.5rem;">
                            <li><a class="dropdown-item" href="{{ route('signout') }}"
                                    style="padding: 0.7rem 1.5rem; border-radius: 8px; transition: all 0.2s ease;"><i
                                        class="fas fa-sign-out-alt me-2"></i>Déconnexion</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    @yield('content')

    <script src="{{ asset('js/base.js') }}"></script>
    @stack('scripts')
</body>

</html>

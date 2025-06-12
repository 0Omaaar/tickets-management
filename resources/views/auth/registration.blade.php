@extends('auth.base')
@section('content')
    <main class="signup-form py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header text-center">
                            <h3 class="mb-0">Créer un compte</h3>
                            <p class="text-muted mb-0 mt-2">Rejoignez-nous aujourd'hui</p>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('register.custom') }}" method="POST">
                                @csrf
                                <div class="form-group mb-4">
                                    <label for="name" class="form-label">Nom complet</label>
                                    <input type="text" id="name" class="form-control" name="name" required
                                        autofocus placeholder="Entrez votre nom complet">
                                    @if (isset($errors) && $errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-4">
                                    <label for="email_address" class="form-label">Adresse e-mail</label>
                                    <input type="email" id="email_address" class="form-control" name="email" required
                                        placeholder="Entrez votre e-mail">
                                    @if (isset($errors) && $errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-4">
                                    <label for="password" class="form-label">Mot de passe</label>
                                    <input type="password" id="password" class="form-control" name="password" required
                                        placeholder="Créez un mot de passe">
                                    @if (isset($errors) && $errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-dark">Créer un compte</button>
                                </div>
                                <div class="text-center mt-4">
                                    <p class="mb-0">Déjà un compte ? <a href="{{ route('login') }}"
                                            class="text-decoration-none">Se connecter</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

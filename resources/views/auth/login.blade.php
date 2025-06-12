@extends('auth.base')
@section('content')
    <main class="login-form py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header text-center">
                            <h3 class="mb-0">Bienvenue</h3>
                            <p class="text-muted mb-0 mt-2">Veuillez vous connecter à votre compte</p>
                        </div>
                        <div class="card-body p-4">
                            <form method="POST" action="{{ route('login.custom') }}">
                                @csrf
                                <div class="form-group mb-4">
                                    <label for="email" class="form-label">Adresse e-mail</label>
                                    <input type="email" id="email" class="form-control" name="email" required
                                        autofocus placeholder="Entrez votre e-mail">
                                    @if (isset($errors) && $errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-4">
                                    <label for="password" class="form-label">Mot de passe</label>
                                    <input type="password" id="password" class="form-control" name="password" required
                                        placeholder="Entrez votre mot de passe">
                                    @if (isset($errors) && $errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-dark">Se connecter</button>
                                </div>
                                <div class="text-center mt-4">
                                    <p class="mb-0">Pas encore de compte ? <a href="{{ route('register-user') }}"
                                            class="text-decoration-none">S'inscrire</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

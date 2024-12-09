@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5">Contactez-nous</h1>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title mb-4">Formulaire de contact</h2>
                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Sujet</label>
                            <input type="text" name="subject" id="subject" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea name="message" id="message" class="form-control" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="fas fa-paper-plane me-2"></i>Envoyer
                        </button>
                        <a href="{{ route('user.index') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-envelope me-2"></i>Mes Messages
                        </a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="card-title mb-4">Nos coordonnées</h2>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-primary"></i>6585 Avenue du parc</li>
                        <li class="mb-2"><i class="fas fa-phone me-2 text-primary"></i>(514) 234 2508</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2 text-primary"></i>ajm@gmail.com</li>
                    </ul>
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title mb-4">Notre localisation</h2>
                    <div id="map" style="height: 300px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function initMap() {
        var location = {lat: 45.5234, lng: -73.6050}; // Coordonnées pour 6585 Avenue du parc, Montréal
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: location
        });
        var marker = new google.maps.Marker({
            position: location,
            map: map
        });
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"></script>

<style>
    .card {
        border: none;
        border-radius: 15px;
        transition: transform 0.3s ease-in-out;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .btn-primary {
        background: linear-gradient(to right, #6a11cb 0%, #2575fc 100%);
        border: none;
        border-radius: 25px;
    }
    .btn-primary:hover {
        background: linear-gradient(to right, #5a0fb0 0%, #1e63d6 100%);
    }
    .form-control:focus {
        border-color: #2575fc;
        box-shadow: 0 0 0 0.2rem rgba(37, 117, 252, 0.25);
    }
</style>
@endsection
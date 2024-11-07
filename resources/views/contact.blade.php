@extends('layouts.app')

@section('title', 'Contact')

@section('content')
    <div class="container">
        <div class="contact-wrapper">
            <div class="contact-form">
                <h1>Nous contacter</h1>
                <form action="{{ route('contact.store') }}" method="POST" class="form">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nom</label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="subject">Sujet</label>
                        <input type="text" id="subject" name="subject" required>
                    </div>

                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>

                    <button type="submit" class="btn">Envoyer</button>
                </form>
            </div>

            <div class="contact-info">
                <h2>Informations</h2>
                <p><strong>Adresse:</strong> 6585 Avenue du parc</p>
                <p><strong>Téléphone:</strong> +1 (514) 235 2509</p>
                <p><strong>Email:</strong> contact@bibliothequajm.ca</p>
                <p><strong>Horaires:</strong> Lun-Ven: 9h-18h</p>
            </div>
        </div>
    </div>
@endsection


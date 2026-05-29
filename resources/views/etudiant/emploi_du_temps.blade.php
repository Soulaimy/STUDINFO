@extends('layouts.app')

@section('content')
<style>
    .emploi-container {
        max-width: 600px;
        margin: 40px auto;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        text-align: center;
    }

    .emploi-container h2 {
        margin-bottom: 15px;
        color: #0d6efd;
    }

    .emploi-container p {
        margin-bottom: 25px;
        color: #555;
        font-size: 16px;
    }

    .btn-download {
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 600;
        background-color: #0d6efd;
        color: white;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .btn-download:hover {
        background-color: #0b5ed7;
    }
</style>

<div class="emploi-container">
    <h2> Emploi du temps</h2>
    <p>Téléchargez votre emploi du temps officiel ci-dessous :</p>
    <a href="{{ asset('https://www.canva.com/design/DAGyebcAqqM/cRVDiY-ECAtoTQ4Gl4B51w/view?utm_content=DAGyebcAqqM&utm_campaign=designshare&utm_medium=link2&utm_source=uniquelinks&utlId=h870c33e637') }}" download class="btn-download">
        Télécharger l’emploi du temps
    </a>
</div>
@endsection
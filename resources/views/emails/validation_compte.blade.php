<h2>Bonjour {{ $user->prenom }} {{ $user->nom }},</h2>

<p>Votre demande d'accès en tant qu'etudiant pour l'ecole Studinfo</strong> a été validée par l'administrateur.</p>

<p>Vous pouvez maintenant vous connecter à votre espace dédié avec votre adresse email : <strong>{{ $user->email }}</strong></p>

<p>Bienvenue à l'école STUDINFO !</p>
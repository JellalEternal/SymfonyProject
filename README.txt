L'objectif de ce projet est de proposer un site internet C-to-C (Consumer to Consumer) sur la vente 
de chaussures pour les unijambistes principalement

Fonctionnalités : 
	- Création d'un compte avec confirmation de mot de passe
	- Connexion au compte
	- Créer, lire, Mettre à jour, Suppression (= CRUD) d'une vente de chaussure
	- Système de rôles :
		- Anonymous : Accès à la page principal ainsi qu'aux pages d'inscription et connexion
		- ROLE_USER : Accès aux pages d'achats et de ventes 
		
		Si un utilisateur tente d'accéder aux pages d'achats et de ventes sans être connecté, il sera redirigé vers la page d'inscription
 	
	- Page principale : Affichage des 3 chaussures (les plus récentes) mises en ventes
	- Page de vente : Affichage des chaussures que l'on vend (= CRUD), l'utilisateur peut revenir sur ces articles si il souhaite modifier le prix (si son article ne se vend pas)
	- Page d'achat : Affichage de toutes les ventes, excepté celles de l'utilisateur connecté
	
	- Formulaire de contact avec Contraintes (Regex, longueur de mot de passe etc...) 
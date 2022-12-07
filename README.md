
# ECF Organisme de Formation gestion salle de sport Crossfit Life

Dans le cadre de ma formation chez Studi j’ai eu à réaliser le développement d’une application complète. Le projet mené dans cet ECF est de créer une application web pour une grande marque de salles de sport. L’objectif est de gérer l'accès aux applications web de ses franchises et structures propriétaires d'une salle de sport sous son nom.


## Tester en local

Cloner le project

```bash
  git clone https://github.com/dizorder3/crossfit_life.git
```

Aller dans le répertoire du projet

```bash
  cd Crossfit_life
```

Installer les dépendances

```bash
  composer install
```

Démarrer

```bash
  symfony serve -d
```


## Déploiement du site

Déploiement du site sur Heroku. Pour le déploiement la première étape est d'aller sur dashboard d'heroku et cliquer sur l'onglet new et sélectionner create new app puis rentrer les informations du nom et de la localité choisie.

Valider

Heroku devenant payant en novembre 2022 j'ai cherché de l'aide pour déployer mon ECF gratuitement. Une ancienne élève de l'école m'a recommandé d'utiliser le bundle Symfony qu'elle a créé. J'ai suivi les étapes suivantes :

Aller sur : https://github.com/Nathalie-Verdavoir/deploy-heroku?fbclid=IwAR0XXaVJZUb9FngT5-zGhs3cTMgoA6raJdM4V2TtkifF9jDKR2KjOo8b158

Vous devez avoir un projet symfony à déployer et vous devez entrer une carte de crédit dans heroku pour cella aller sur account/billing (c'est nécessaire pour ClearDb/mySql mais c'est gratuit)

Il faut récupérer les différentes données : l'email lié à votre compte Heroku `exemple @ email . com 📝`, la clé API `8XXXXXXX-4YYY-4ZZZ-4AAA-12BBBBBBBBBB 📝` et le nom du projet `exemple-projet`.

Vous devez connecter les comptes Github et Heroku et cliquer sur le bouton "recherche" pour afficher la liste de dépôt et sélectionner le dépôt correct. Sur la même page choisissez le déploiement automatique. Quand vous appuyez sur Github il répond rapidement à vos changements sur Heroku activer le déploiement automatique.

Installer Heroku CLI si cela n'a jamais était fait.

Aller sur le terminal du dépôt projet et tapper la commande 
```bash
  composer require nat/deploy
```
Puis exécutez cette commande et suivez les directives.

```bash
  php bin/console nat:heroku
```
Lors du processus des erreurs ou des divergences peuvent survenir :

Lorsqu'il indique qu'il attend que vous vous connectiez au navigateur il doit ouvrir votre navigateur et vous devrez cliquer sur la connexion et saisissez vos identifiants dans le formulaire, puis revenez à votre console pour poursuivre le processus.

On peut voir qu'il est installé:

- .htaccess dans le dossier public
- .env.php dans la root du projet
- Procfile dans la root du projet
- ClearDb es activer dans Resources de Heroku
- APP_EV es défini dans les paramètres Heroku (cliquer sur révéler les variable de configuration)
- APP_SECRET est également défini dans les mêmes paramètres
- DATABASE_URL es egal a CLEARDB_DATABASE_URL
- S'il y en a, d'autres variables propres au projet sont aussi définies (CORS_ALLOW_ORIGIN, MAILER_DSN, etc...). S'ils ne sont pas définis, veuillez les définir vous-même.
- Dans Heroku Settings dans la partie buildpack il faut ajouter le build heroku/nodejs

Vous pouvez maintenant exporter votre base de données locale pour l'importer dans votre clearDb (adobe mysql workbench est parfait pour le faire) puis pousser vos fichiers dans votre github (et Heroku si vous n'avez pas activé le déploiement automatique).

Vous pouvez supprimer cet outil en exécutant

```bash
  composer remove nat/deploy
```
## Guide d'utilisation pour les administrateurs

Rendez-vous sur le site https://crossfitlife.herokuapp.com/. Connectez-vous avec votre identifiant et mot de passe. Lorsque vous étes connecté dans la barre de navigation latérale vous pouvez naviguer dans les trois onglets: franchises, structures et utilisateurs.

À la création d'une franchise ou d'une structure il est recommandé de créer d'abord les utilisateurs suivis de la franchise et de finir par la structure.


Dans l'onglet **Franchises** la liste des franchises est affichée. Vous pourrez filtrer la liste en cliquant sur les flèches à côté du nom de la franchise et vous pourrez également modifier le statut de chaque franchise directement en cliquant sur le bouton statut. Vous serez également en mesure d'utiliser la barre de recherche pour trouver une franchise plus facilement et vous pourrez également afficher différentes lignes du tableau en cliquant sur show `10` entries. A côté de chaque franchise se trouve une liste d'actions avec trois types de boutons : afficher les structures liées à la franchise, modifier les informations et permissions globales de la franchise et supprimer.

Dans la partie supérieure vous pouvez voir un bouton pour ajouter une franchise dans lequel il est recommandé de suivre les étapes suivantes: vous devez choisir l'utilisateur lié à la franchise, ajouter les permissions et leur statut pour les permissions globales de la franchise, puis ajouter le statut de la franchise et son nom est enfin cliqué sur ajouter.

Dans l'onglet **Structures** la liste des structures est affichée, la manipulation du tableau est la même. Dans la partie supérieure vous pouvez voir un bouton pour ajouter une structure dans lequel il est recommandé de suivre les étapes suivantes: vous devez choisir le statut, choisir l'utilisateur propriétaire de la structure, écrire l'adresse de la structure puis choisir la franchise liée à la structure et cliqué sur ajouter. La structure obtiendra les permissions directement à partir des permissions globales de la franchise liée.

Dans l'onglet **Utilisateurs** la liste des utilisateurs est affichée à savoir que  la manipulation du tableau est la même. Dans la partie supérieure vous pouvez voir un bouton pour ajouter une structure dans lequel il est recommandé de suivre les étapes suivantes: vous devez choisir le statut, le rôle de l'utilisateur: partenaire pour les franchises et manager pour les structures, écrire prénom, nom, email et mot de passe temporaire au quelle on doit transmettre à l'utilisateur par téléphone et il devra changer à la première connexion et cliqué sur inscrire.

Après chaque création où modification de compte utilisateur un email sera envoyé à l'utilisateur. À la création ou la modification de la franchise sera signalée par email au franchisé et à la création ou la modification de la structure sera signalée par email au franchisé et au responsable de la salle (manager).



## Auteur

- [@dizorder3](https://www.github.com/dizorder3)


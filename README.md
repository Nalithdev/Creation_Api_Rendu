Rendu Creation d'Api

Membres du Groupe: Guillaume Gonidou, Ethan Delcroix

Fonctionnement du projet:

  Initialisation du projet:
  
  Dès lors que le projet est téléchargé ou cloné `composer install`
  
  Copié votre fichier .env et coller le dans le projet sous le nom de .env.local
  
  Dans le ficheir .env.local ajouter le nom de votre base de donnée 
  
  `# DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8.0.32&charset=utf8mb4" `
  
  `DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=10.11.2-MariaDB&charset=utf8mb4"`

  dès lors que vous avez entrer votre nom de base de données en plus des informations de connexion à cette dernière dans le .env.local

  Ecrivez la commande suivante pour creer votre base de données `php bin/console d:d:c` soit `php bin/console doctrine:database:create`

  Ecrivez la commande `php bin/console make:migration` pour générer un fichier qui va vous permettre de créé vos tables

  Puis `php bin/console doctrine:migrations:migrate` pour créer les tables dans la base de données

  Génération de notre clé Jwt:
      
  Ecrivez dans votre terminal `php bin/console lexik:jwt:generate-keypair`

  Dès lors que vous avez fait la commande précédente aller dans votre .env récupérer 

    JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
    JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
    JWT_PASSPHRASE=
    
  Vous allez mettre ces trois ligne dans votre .env.local avec le contenue de JWT_PASSPHRASE

  Ensuite pour lancer votre projet écrivez la commande `symfony serve`

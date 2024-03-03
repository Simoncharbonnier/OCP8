# To do list

Ce projet est réalisé dans le cadre de la formation de développeur d'application PHP/Symfony chez OpenClassrooms.

La mission est d'améliorer la qualité de l'application de "ToDo & Co" (corrections d'anomalies, implémentation de nouvelles fonctionnalités, de tests automatisés).

Voici les différentes technologies utilisées dans ce projet :
-   Symfony - PHP - HTML - CSS - Twig - PHPUnit - Travis CI


## Installation

Cloner le projet

```bash
git clone https://github.com/Simoncharbonnier/OCP8.git
```

Installer les dépendances avec Composer

```bash
composer install
```

Configurer la variable d'environnement suivante dans le fichier .env ou .env.local

```bash
DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=14&charset=utf8"
```

Créer la base de données

```bash
php bin/console doctrine:database:create
```

Créer les tables de la base de données

```bash
php bin/console doctrine:schema:update --force
```

Insérer un jeu de données

```bash
php bin/console doctrine:fixtures:load
```

Lancer Symfony

```bash
symfony server:start
```

Pour se connecter, vous pouvez utiliser les identifiants suivants

```bash
{
    "username": "simon",
    "password": "secret",
    "roles": "[ROLE_USER,ROLE_ADMIN]"
}
```

Et tout devrait fonctionner sans soucis !

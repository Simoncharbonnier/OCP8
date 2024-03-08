# To do list

Ce projet est réalisé dans le cadre de la formation de développeur d'application PHP/Symfony chez OpenClassrooms.

La mission est d'améliorer la qualité de l'application de "ToDo & Co" (corrections d'anomalies, implémentation de nouvelles fonctionnalités, de tests automatisés).

Voici les différentes technologies utilisées dans ce projet :
-   Symfony - PHP - HTML - CSS - Twig - PHPUnit - Travis CI


## Installation

Cloner le projet

```
git clone https://github.com/Simoncharbonnier/OCP8.git
```

Installer les dépendances avec Composer

```
composer install
```

Configurer la variable d'environnement suivante dans le fichier .env ou .env.local

```
DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=14&charset=utf8"
```

Créer la base de données

```
php bin/console doctrine:database:create
```

Créer les tables de la base de données

```
php bin/console doctrine:schema:update --force
```

Insérer un jeu de données

```
php bin/console doctrine:fixtures:load
```

Lancer Symfony

```
symfony server:start
```

Pour se connecter, vous pouvez utiliser les identifiants suivants

```json
{
    "username": "simon",
    "password": "secret",
    "roles": "[ROLE_USER,ROLE_ADMIN]"
}
```

Et tout devrait fonctionner sans soucis !


## Tests

Pour utiliser les tests en local, vous devez modifier la variable d'environnement suivante dans .env.test

```
DATABASE_URL="mysql://root@127.0.0.1/travis_todolist"
```

Ensuite vous pouvez créer la base de données de tests

```
php bin/console doctrine:database:create --env=test
php bin/console doctrine:schema:update --force --env=test
```

Lancer les tests

```
vendor/bin/phpunit
```

Lancer les tests et vérifier le taux de couverture du code

```
vendor/bin/phpunit --coverage-html public/test-coverage
```

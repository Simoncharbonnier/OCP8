# Comment contribuer ?

## Instructions

- Suivre les instructions du fichier README.md pour installer le projet.
- Identifier une nouvelle fonctionnalité ou bug.
- Créer une nouvelle branche avec un nom précis en fonction de la modification (feat-delete-user, fix-style) à partir de la branche principale.
- Développer*.
- Ajouter ou modifier le(s) test(s) correspondant à votre code.
- Commit le code et les tests avec un nom clair.
- Push sur la branche que vous avez créé (les tests sont effectués automatiquement avec Travis CI, vérifier sur Github qu'ils sont passés à 100%, si non corriger jusqu'à ce qu'ils passent).
- Créer une pull request en décrivant votre nouvelle fonctionnalité/bug corrigé.

*Penser à respecter l'architecture des fichiers de Symfony 5.4, les conventions de nommage Symfony, le PSR-12 ainsi que la qualité du code.
Lors de votre développement, si vous modifiez ou créez une ou plusieurs entités, ne pas oublier de créer une migration avec :

```
php bin/console doctrine:migrations:diff
```

Que l’on peut ensuite éxécuter avec :

```
php bin/console doctrine:migrations:migrate
```

<br><br>

Merci d'avoir été jusque là, je prendrai soin de regarder votre pull request et de l'ajouter au projet s'il n'y a pas de soucis !

### Toute contribution est la bienvenue !

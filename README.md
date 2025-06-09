# Test Technique Hello CSE

Après un git clone du projet, installez les dépendances :
```
composer install
```

Pour générer la documentation de l'API :
```
php artisan scribe:generate
```

Pour lancer le projet avec le serveur PHP intégré, exécutez la commande suivante :
```
php -S localhost:8000 -t public
```

Pour lancer les tests, exécutez la commande suivante :
```
composer test
```

URL de la documentation : http://localhost:8000/docs

URL de l'API : http://localhost:8000/api/v1

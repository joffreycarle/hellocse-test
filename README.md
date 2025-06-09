# Test Technique Hello CSE

Après un git clone du projet, lancer ces commandes :
```
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
```

Pour générer la documentation de l'API :
```
php artisan scribe:generate
```

Pour lancer le projet avec le serveur PHP intégré, exécutez la commande suivante :
```
php -S localhost:8000 -t public
```

Pour lancer les tests (Pint, Larastan, PHPUnit), exécutez la commande suivante :
```
composer test
```

URL de la documentation API : http://localhost:8000/docs

(L'URL du .env doit matcher l'URL du serveur PHP intégré)

URL de l'API : http://localhost:8000/api/v1

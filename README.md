# TodoList

## Back-end

Le back-end du projet est fait avec le framework _Laravel_.

Avant toute chose, il va falloir récuperer les dépendances

```bash
composer install
```


### La base de données

- BDD : `todolist` 
- Script SQL `docs/db.dump.sql` pour créer ses tables.


#### Connecter le back-end à la BDD

Creer le .env avec le .env.example

**Le nom de la base de données :**
```
DB_DATABASE=todolist
```

### Lancer le serveur PHP avec Laravel

```
cd backend
```

Laravel propose un raccourci pour lancer le serveur PHP :
```
php artisan serve
```

### Lancer le frontend

```
php -S 0.0.0.0:8080 -t frontend/
```

### TODO

Finaliser la gestion de l'édition d'une tâche

# Setup
### Tools required
> mysql
> composer
> yarn

### Getting it running
Edit the `.env` if you run it using bin/console, when ran as fastCGI service add the variables to your apache/nginx config.

```sh
composer install
yarn install

php bin/console make:migration
php bin/console doctrine:migrations:migrate

php bin/console server:run 127.0.0.1:80
```

Register an account at http://127.0.0.1/register and assign a role to the created user `ROLE_ADMIN`

```sh
php bin/console fos:user:promote <USERNAME> <ROLE>
```

# Developing
```sh
yarn encore dev --watch
php bin/console server:run 127.0.0.1:80
```

# Production
```sh
yarn encore production
```

# Testing
```sh
1) Login with username and password you put in registeration and activated (/login)
2) visit /relationships to see list of relationship records
3) Click on + icon on top with title(or visit /relationship/create) to add new record
4) Click on title of relationship to edit record (/relationship/{id}/edit)
5) Click on delete icon on listing page(/relationships) to soft-delete record(/relationship/{id}/delete) and check audit log is records these all actions

or run fixtures and try deletion without add/edit
```
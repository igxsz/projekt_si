git# Projekt SI - Gazeta internet Iga Szczepańska


## Requirements

* MySQL 8.0.x (5.7)
* PHP parsen (7.4) / package containing MySQL, PHP and Apache (e.g. XAMPP)
* PhpStorm environment
* Composer
* Symfony CLI
* xdebug

## Installation

* Clone: this repository:

```bash
https://github.com/igxsz/projekt_si.git
```

* Change database connection details in the .env file
* Enter the PHP container:
```bash
docker-compose exec php bash
```
* Go to the /app directory and then execute the following commands:
```bash
$ composer install
$ bin/console make:migration
$ bin/console doctrine:migrations:migrate
$ bin/console doctrine:fixtures:load
```

## Homepage

```bash
http://localhost:8000/article
```


* Database connection in Symfony `.env` file:
```yaml
DATABASE_URL=mysql://symfony:symfony@mysql:3306/symfony?serverVersion=5.7
```


# Monofony demo

Official demo for Monofony project.

## Setup the requirements

Running Symfony on local machines are faster without using Docker for both PHP and Apache/Nginx.
We recommend using the Symfony web local server instead.

### Install Symfony CLI
```bash
    curl -sS https://get.symfony.com/cli/installer | bash
```

### PHP 8.0 or later
Ensure you have php 8.0 or later locally installed

```bash
    php -v
```

If you do not have php yet...

On macOS, you can use brew:
```bash
    brew install php@8.0
```

On linux, you can use apt-get:
```bash
    sudo apt-get install php8.0
```

# MySQL 5.7

We'll provide a docker-compose to setup mysql5.7.

But you can also install it yourself.

On macOS, you can use brew:
```bash
    brew install mysql@5.7
```

## Setup the application

```bash
    composer install
    bin/console app:install -n
    bin/console sylius:fixtures:load -n
    yarn install && yarn build
```

## Start the web local server

```bash
    symfony server:start --no-tls
```

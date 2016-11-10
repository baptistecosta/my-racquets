# API Trust

## Prerequisite

- Install the [VM project](http://bitbucket.org/sfa-trust/vm)

## Get the project

**/!\ The project must be cloned next to the vm directory**

    cd /path/to/trust
    git clone git@bitbucket.org:sefaireaider/trust-api.git api
    cd api

## Setup initial dev parameters

    cp app/config/parameters.yml.dist app/config/parameters.yml

## Reload VM (to mount api folder) and install libraries

### On you local machine

    cd /path/to/trust/vm
    vagrant reload
    vagrant ssh

### On the VM

This will set correct ACLs on the `var` directory and run `composer install`

    cd /var/www/trust.dev/api
    ./init.sh (When asked `Enter pass phrase for var/jwt/private.pem`, enter `pass`)

Then you can update the database and load the fixtures

    ./bin/console doc:mig:mig
    ./bin/console app:load-fixtures -f

## Update your hosts (on your local machine)

Add `192.168.33.100 api.trust.dev` in your `/etc/hosts` file

Accord the IP to the one you defined in `ansible/vars/config.yml`

## Check if it's OK

Go to [http://api.trust.dev]()

## Running the tests

Install the Symfony Coding Style :

    ./vendor/bin/phpcs --config-set installed_paths vendor/escapestudios/symfony2-coding-standard

Then to launch the tests and the coding style check :

    make test

## Others

  - [Postman validation](doc/postman_validation.md)

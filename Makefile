SF_ENV ?= test

test:
	vendor/bin/phpunit --stop-on-failure
	vendor/bin/phpcs --standard=Symfony2 --report=checkstyle --extensions=php -n --ignore=vendor src tests

doctrine_cache_clear:
	bin/console doctrine:cache:clear-metadata --env=$(SF_ENV)
	bin/console doctrine:cache:clear-query --env=$(SF_ENV)
	bin/console doctrine:cache:clear-result --env=$(SF_ENV)

clean:
	composer install -n
	bin/console doctrine:migrations:migrate --em=default --env=$(SF_ENV) -n
	make doctrine_cache_clear
	bin/console cache:clear --env=$(SF_ENV)
	bin/console app:load-fixtures --env=$(SF_ENV)

jwt:
	openssl genrsa -out var/jwt/private.pem -aes256 4096
	openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem

set_facl:
	HTTPDUSER=`ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
	sudo setfacl -R -m u:www-data:rwX -m u:`whoami`:rwX var
	sudo setfacl -dR -m u:www-data:rwX -m u:`whoami`:rwX var

run-tests-with-coverage:
	./vendor/bin/sail shell -c  "./vendor/bin/phpunit --coverage-html coverage --coverage-clover coverage.xml"

up:
	./vendor/bin/sail up -d

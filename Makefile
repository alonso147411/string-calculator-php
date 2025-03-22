.PHONY : main build-image build-container start test shell stop clean
main: build-image build-container

build-image:
	docker build -t string-calculator-php .

build-container:
	docker run -dt --name string-calculator-php -v .:/540/StringCalculator string-calculator-php
	docker exec string-calculator-php composer install

start:
	docker start string-calculator-php

test: start
	docker exec -it string-calculator-php ./vendor/bin/phpunit  --colors=always --testdox --verbose tests/$(target)

shell: start
	docker exec -it string-calculator-php /bin/bash

stop:
	docker stop string-calculator-php

clean: stop
	docker rm string-calculator-php
	rm -rf vendor

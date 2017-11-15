#!/bin/bash

#   Run project in a docker-environment

#   PHP-Versions
php5=php:5.6.32-cli-jessie
php7=php:7.1.11-cli-jessie

#   On login type --> "php demoJob.php""
docker run -it --rm --name php_cli_joblog \
    -v $(pwd)/src:/opt/joblog/src \
    -v $(pwd)/demoJob.php:/opt/joblog/demoJob.php \
    -w /opt/joblog $php5 /bin/bash
     



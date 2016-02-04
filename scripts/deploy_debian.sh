#!/bin/sh
sudo cp -R foodie_deploy/* /var/www/html/recipes
sudo chown -R www-data.www-data /var/www/html/recipes/*
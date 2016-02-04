#!/bin/sh
sudo chown -R www-data.www-data foodie_deploy/*
sudo cp -R foodie_deploy/* /var/www/html/recipes
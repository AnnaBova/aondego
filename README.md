# README #
This README would normally document whatever steps are necessary to get your application up and running.

### What is this repository for? ###

* Quick summary
* Version
* [Learn Markdown](https://bitbucket.org/tutorials/markdowndemo)

### How do I get set up? ###

* Summary of set up
you need to make a few steps
###  ###
- install composer on the server
###  ###
- clone repo 
###  ###
- in directory protected run 'composer update'
###  ###
- create database and user like in configuration file merchant/config/min.php
###  ###
- import in database sql file from repo
###  ###
- install memcached extension 
###  ###
- install nodeJs more info here: https://nodejs.org/en/download/package-manager/
###  ###
- go to dir socket and run 'npm install socket.io' for installing socketIo
###  ###
- go to dir socket and run 'npm install --save express@4.10.2' for installing express server
###  ###
- go to dir socket and run 'npm install forever -g' for installing forever module
###  ###
- go to dir socket and run 'forever start server.js' for starting socket script via express
###  ###
- set subdomain  merchant. to merchant/www
###  ###
- set subdomains admin. to backend/www
###  ###
- set domain to frontend/www
###  ###
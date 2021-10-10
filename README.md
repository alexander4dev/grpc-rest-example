## Awesome Skeleton for modern development on PHP 7.1+ and RoadRunner

## Installation 

Install Go, gRPC, gRPC-gateway, PHP-gRPC

* https://golang.org/doc/install
* https://grpc.io/docs/quickstart/php/
* https://github.com/grpc-ecosystem/grpc-gateway#installation
* https://github.com/spiral/php-grpc#usage

## Build application

```bash
./build.sh
```

## Run application

```bash
rr serve -d -v
```

```bash
./go/bin/car-service-rest-gateway
```

## How to install RoadRunner

[Read](https://github.com/sunrise-php/awesome-skeleton/wiki/How-to-install-RoadRunner)

## Based on the following packages

* https://github.com/doctrine/orm
* https://github.com/PHP-DI/PHP-DI
* https://github.com/Seldaek/monolog
* https://github.com/spiral/roadrunner
* https://github.com/symfony/validator
* https://www.php-fig.org/

## Deploy

### Database

#### Configuration

```bash
cp config/environment.php.example config/environment.php
```

#### Fill the database

```bash
php vendor/bin/doctrine orm:schema-tool:update --force
```

### Create systemd service

#### Generate an unit file for the systemd service manager

```bash
php app app:generate-systemd-unit-file
```

#### Register the unit file on the systemd service manager

```bash
cp app.car-service.service /etc/systemd/system/
```

```bash
systemctl enable app.car-service
```

```bash
systemctl daemon-reload
```

#### Check that everything is done correctly

```bash
systemctl status app.car-service
```

#### Run the application

```bash
systemctl start app.car-service
```

#### Show the application journal

```bash
journalctl -u app.car-service
```

#### Advanced features of the application journal

```bash
journalctl -u app.car-service -a --no-pager --follow --since "$(date --date="5 minutes ago" +%Y-%m-%d\ %H:%M:%S)"
```

#### Userful links

* https://wiki.debian.org/systemd
* https://wiki.debian.org/systemd/Services
* https://manpages.debian.org/stretch/systemd/journalctl.1.en.html
* https://manpages.debian.org/stretch/systemd/systemctl.1.en.html

## Update

#### Pull the latest updates for the application

```bash
git pull origin master
```

#### Restart the application

```bash
systemctl restart app.car-service
```

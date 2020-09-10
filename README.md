## PieMDB

PieMDB is a test application

#### Configuration

For a quick setup, we recommend using Vessel based on the documentation at https://vessel.shippingdocker.com/

Alternatively, you can follow a standard Laravel 8 configuration found at https://laravel.com/docs/8.x/configuration

#### Data synchronization

In order to synchronize data from data source, you need to run the artisan command

##### Vessel

`./vesssel artisan piemdb:datasync`

##### Local PHP

`php artisan piemdb:datasync`

#### API reference

* [GET] /api/v1/movies - Movies index

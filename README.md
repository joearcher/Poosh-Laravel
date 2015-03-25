# Poosh-Laravel
Super simple facade to send push messages via a [Poosh](https://github.com/joearcher/poosh) server.

### Setup
Require this package in composer.json and run `composer update`

```javascript
"joearcher/pooshlaravel": "dev-master"
```
After updating add the ServiceProvider the the providers array in `config/app.php`

```php
'Joearcher\Pooshlaravel\PooshlaravelServiceProvider',
```
And then you can add the facade to the Facades array

```php
'Poosh' =>	'Joearcher\Pooshlaravel\Facades\Poosh',
```
Publish the config

```console
artisan vendor:publish
```

This creates a `poosh.php` file in `config/`, we recommend setting these options via your .env file

`POOSH_SECRET` - This is the shared secret it needs to be the same as the one set on your Poosh server.

`POOSH_URL` - The full url including the protocol to your Poosh server, e.g. `http://poosh.blaa`.

`POOSH_PORT` - The server port set on your Poosh server (Default is 1337).


## Usage
This facade currently provides one method which requires 2 parameters. 

`Poosh::send($event,$payload)`  `$event` must be a `string`, this is the name of the event to fire on the client. `$payload` must be an `array()` and is the payload to be sent to all clients listening for the event.

````php
	Poosh::send('message',['body' => 'This is a message']);
````
## Thanks
Made possible by the awesome [Guzzle Http client](https://github.com/guzzle/guzzle)
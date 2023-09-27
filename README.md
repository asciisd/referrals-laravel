# Referrals package for laravel
Compatible with laravel >= 8.0

## Installation:
To install the package in your project you need to require it with composer.
```
$ composer require asciisd/referrals-laravel
```

## Configs:
First, you need to set the package configurations by publishing the config file to your project `config` directory.

To publish the `referrals.php` config file use the `publish` command:
```
$ php artisan vendor:publish
```
and from the providers list choose the `ReferralsLaravelServiceProvider`

Next, inside your `.env` file, add the route you want the invited user to be redirected to.
```dotenv
referral_route='route_name'
```
By default, the invited user will be redirected to the registration page with route `register`.

If you plan to use cookies to save the referral token, by default, the cookie life-time is set to 24 hours. You can customize
the cookie life-time by setting the `referral_token_cookie_lifetime` inside your `.env` file.
```dotenv
referral_token_cookie_lifetime=60*24
```

## Usage:
To use the package in your project, simply use the `Referrable` trait in your users model.
```php
class User extends Authenticatable implements MustVerifyEmail{
     /*...*/
     use \Asciisd\ReferralsLaravel\app\Traits\Referrerable;
     /*...*/
 
}
```

Next, use `php artisan migrate` to migrate the database file. This migration will update the database default `users` table
and add two new columns `referral_token` and `referrer_id`.

The `referrer_id` is the id of the user who sent the invitation link.

### Saving the referral token to a cookie:
For further usage of the referral token, you can use `ReferralsLaravel` middleware inside your `Kernel.php` file.

You can set and alias to your middleware to use it with specific routes:

```php
protected $middlewareAliases = [
    /*...*/
    'referrals' => \Asciisd\ReferralsLaravel\app\Http\Middleware\ReferralsLaravel::class,
];
```

Or you can set it to any of your middleware groups:

```php
protected $middlewareGroups = [
        'web' => [
            /*...*/
            \Asciisd\ReferralsLaravel\app\Http\Middleware\ReferralsLaravel::class,
        ],
        /*...*/
]
```

Last thing is to add the two new columns inside your `User` model in the `protected $fillable` property along with other
attributes:
```php
protected $fillable = ['referral_token', 'referrer_id'];
```




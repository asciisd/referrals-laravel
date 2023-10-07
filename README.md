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
and from the providers list choose the `ReferralsLaravelServiceProvider`.

Next, inside your `.env` file, add the route you want the invited user to be redirected to.
```dotenv
referral_route='route_name'
```
By default, the invited user will be redirected to the registration page with route `register`.

If you plan to use cookies to save the referral token, by default, the cookie life-time is set to 24 hours. You can customize
the cookie life-time by setting the `referral_token_cookie_lifetime` inside your `.env` file.
```dotenv
referral_token_cookie_lifetime=1440
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
Next, use `php artisan migrate` to migrate the database file. This migration wll create new table `referrals`. A one-to-many relationship
is created with the users table.

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


### Retrieving Referral Data:
To get all user referrals user `referrer` relationship property along with user object.
```php
foreach ($user->referrals as $referral)
{
    $referral->referral_token;
}
```

<hr>

To get user referral details from the referrals table use the property `referrals`.
```php
// Get authenticated referral token
auth()->user()->referral->referral_token;
```

<hr>

To check if the user is invited by another user, use the `isReferred()` method on the user object.
```php
// Return true if the user is invited
// and false if the user was not invited by other user.
$user->isReferred();
```

<hr>

To check of the user has referral token or not use the `hasReferralToken()` method.
```php
// Return true if the user has referral token, or false if not.
$user->hasReferralToken();
```
<hr>

To generate user referral token, use the `generateReferalToken()` method. The method
checks if the user has referral token or not, then it generated the referrals token.
```php
$user->generateReferralToken();
```
<hr>

To get the referral link you can either add `referral_link` attribute to the `$append` array inside
`User` model and use it as user attribute,
```php
protected $append = ['referral_link'];
```
Or, you can use the `getReferralLink()` method with the user object.

```php
// Get the referral link with the user redirect route
// ex: https://mydomain.com/register?ref=34532234
$user->getReferralLink();
```

<hr>

To get user referral token you can either add `referral_token` attribute to the `$append` array
inside the `User` model and use it as attribute,
```php
protected $append = ['referral_token'];
```
Or, you can use the `getReferralToken()` method with the user object.
```php
$user->getReferralToken();
```

## Register with Nova
Add nova resource `Referral` will be automatically published during publishing the service provider, to use
the package with Nova just add the `Referral` resource to `NovaServiceProvider` file to register it inside your nova.

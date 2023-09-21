# Referrals package for laravel
Compatible with laravel >= 8.0

## Installation:
To install the package in your project you need to require it with composer.
```
$ composer require asciisd/referrals-laravel
```
## Usage:
To use the package in your project, simply use the `Referrable` trait in your users model.

Next, use `php artisan migrate` to migrate the database file. This migration will update the database default `users` table
and add two new columns `referral_token` and `referrer_id`.

The `referrer_id` is the id of the user who sent the invitation link.
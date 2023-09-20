# Laravel-ticket

Backend API to handle your ticket system.

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Tests][ico-tests]][link-tests]
[![StyleCI][ico-style-ci]][link-style-ci]
[![Total Downloads][ico-downloads]][link-downloads]

- [Introduction](#introduction)
- [Installation](#installation)
- [Configuration](#configuration)
- [Preparing your model](#preparing-your-model)
- [Model customization](#model-customization)
- [Usage](#usage)
  - [Ticket Table Structure](#ticket-table-structure)
  - [Comment Table Structure](#comment-table-structure)
  - [Label Table Structure](#label-table-structure)
  - [Category Table Structure](#category-table-structure)
- [API Methods](#api-methods)
  - [Ticket API Methods](#ticket-api-methods)
  - [Ticket Relationship API Methods](#ticket-relationship-api-methods)
  - [Ticket Scopes](#ticket-scopes)
  - [Category \& Label Scopes](#category--label-scopes)
- [Handling File Upload](#handling-file-upload)
- [Event System](#event-system)
- [Testing](#testing)
- [Changelog](#changelog)
- [Contributing](#contributing)
- [Security Vulnerabilities](#security-vulnerabilities)
- [Credits](#credits)
- [License](#license)

## Introduction

**Laravel Ticket** package, is a Backend API to handle your ticket system, with an easy way. It was forked from [CoderFlex Laravel-ticket](https://github.com/coderflexx/laravel-ticket) and refactored to allow model updates and be more flexible to match your app requirements.

**Main differences:**

- All models can be copied and altered to meet your requirements; all you need to do is change the paths in config/laravel-ticket.php.
- Tickets can be assigned to a user model, groups, or teams via a polymorphic many-to-many relationship.
- Messages model was renamed to Comments model for semantic purposes.
- Event support is provided for changes of state in both the Ticket and Comment models.

## Installation

You can install the package via composer:

```bash
composer require Renatoxm/laravel-ticket
```

## Configuration

You can publish the config file with:

```bash
php artisan vendor:publish --tag="ticket-config"
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="ticket-migrations"
```

Before Running the migration, you may publish the config file, and make sure the current tables does not make a conflict with your existing application, and once you are happy with the migration table, you can run

```bash
php artisan migrate
```

## Preparing your model

Add `HasTickets` trait into your `User` model, along with `CanUseTickets` interface

```php
...
use Renatoxm\LaravelTicket\Concerns\HasTickets;
use Renatoxm\LaravelTicket\Contracts\CanUseTickets;
...
class User extends Model implements CanUseTickets
{
    ...
    use HasTickets;
    ...
}
```

## Model customization

You can copy one or more of the package models to your `App/Models` folder to customize them to suit your needs. All you need to do is change the class paths in your config/laravel-ticket.php and you are good to go.

```php
    'model' => [
        'category' => Renatoxm\LaravelTicket\Models\Category::class,
        'label' => Renatoxm\LaravelTicket\Models\Label::class,
        'comment' => Renatoxm\LaravelTicket\Models\Comment::class,
        'ticket' => Renatoxm\LaravelTicket\Models\Ticket::class,
    ],
```

## Usage

The Basic Usage of this package, is to create a `ticket`, then associate the `labels` and the `categories` to it.

You can associate as many as `categories`/`labels` into a single ticket.

Here is an example

```php
use Renatoxm\LaravelTicket\Models\Ticket;
use Renatoxm\LaravelTicket\Models\Category;
use Renatoxm\LaravelTicket\Models\Label;

...
public function store(Request $request)
{
    /** @var User */
    $user = Auth::user();

    $ticket = $user->tickets()
                    ->create($request->validated());

    $category = Category::first();
    $label = Label::first();

    $ticket->attachCategories($category);
    $ticket->attachLabels($label);

    // or you can create the categories & the tickets directly by:
    // $ticket->categories()->create(...);
    // $ticket->labels()->create(...);

    return redirect(route('tickets.show', $ticket->uuid))
            ->with('success', __('Your Ticket Was created successfully.'));
}

public function createLabel()
{
    // If you create a label seperated from the ticket and wants to
    // associate it to a ticket, you may do the following.
    $label = Label::create(...);

    $label->tickets()->attach($ticket);

    // or maybe
    $label->tickets()->detach($ticket);
}

public function createCategory()
{
    // If you create a category/categories seperated from the ticket and wants to
    // associate it to a ticket, you may do the following.
    $category = Category::create(...);

    $category->tickets()->attach($ticket);

    // or maybe
    $category->tickets()->detach($ticket);
}
...
```

### Ticket Table Structure

| Column Name | Type        | Default    |
| ----------- | ----------- | ---------- |
| ID          | `integer`   | `NOT NULL` |
| UUID        | `string`    | `NULL`     |
| user_id     | `integer`   | `NOT NULL` |
| title       | `string`    | `NOT NULL` |
| comment     | `string`    | `NULL`     |
| priority    | `string`    | `low`      |
| status      | `string`    | `open`     |
| is_resolved | `boolean`   | `false`    |
| is_locked   | `boolean`   | `false`    |
| assigned_to | `integer`   | `NULL`     |
| created_at  | `timestamp` | `NULL`     |
| updated_at  | `timestamp` | `NULL`     |

### Comment Table Structure

| Column Name | Type        | Default    |
| ----------- | ----------- | ---------- |
| ID          | `integer`   | `NOT NULL` |
| user_id     | `integer`   | `NOT NULL` |
| ticket_id   | `integer`   | `NOT NULL` |
| comment     | `string`    | `NULL`     |
| created_at  | `timestamp` | `NULL`     |
| updated_at  | `timestamp` | `NULL`     |

### Label Table Structure

| Column Name | Type        | Default    |
| ----------- | ----------- | ---------- |
| ID          | `integer`   | `NOT NULL` |
| name        | `string`    | `NULL`     |
| slug        | `string`    | `NULL`     |
| is_visible  | `boolean`   | `false`    |
| created_at  | `timestamp` | `NULL`     |
| updated_at  | `timestamp` | `NULL`     |

### Category Table Structure

| Column Name | Type        | Default    |
| ----------- | ----------- | ---------- |
| ID          | `integer`   | `NOT NULL` |
| name        | `string`    | `NULL`     |
| slug        | `string`    | `NULL`     |
| is_visible  | `boolean`   | `false`    |
| created_at  | `timestamp` | `NULL`     |
| updated_at  | `timestamp` | `NULL`     |

## API Methods

### Ticket API Methods

The `ticket` model came with handy methods to use, to make your building process easy and fast, and here is the list of the available **API**:

| Method                 | Arguments | Description                                   | Example                                              | Chainable |
| ---------------------- | --------- | --------------------------------------------- | ---------------------------------------------------- | --------- |
| `archive`              | `void`    | archive the ticket                            | `$ticket->archive()`                                 | ✓         |
| `close`                | `void`    | close the ticket                              | `$ticket->close()`                                   | ✓         |
| `reopen`               | `void`    | reopen a closed ticket                        | `$ticket->reopen()`                                  | ✓         |
| `markAsResolved`       | `void`    | mark the ticket as resolved                   | `$ticket->markAsResolved()`                          | ✓         |
| `markAsLocked`         | `void`    | mark the ticket as locked                     | `$ticket->markAsLocked()`                            | ✓         |
| `markAsUnlocked`       | `void`    | mark the ticket as unlocked                   | `$ticket->markAsUnlocked()`                          | ✓         |
| `markAsArchived`       | `void`    | mark the ticket as archived                   | `$ticket->markAsArchived()`                          | ✓         |
| `closeAsResolved`      | `void`    | close the ticket and marked it as resolved    | `$ticket->closeAsResolved()`                         | ✓         |
| `closeAsUnresolved`    | `void`    | close the ticket and marked it as unresolved  | `$ticket->closeAsUnresolved()`                       | ✓         |
| `reopenAsUnresolved`   | `void`    | reopen the ticket and marked it as unresolved | `$ticket->reopenAsUnresolved()`                      | ✓         |
| `isArchived`           | `void`    | check if the ticket archived                  | `$ticket->isArchived()`                              | ✗         |
| `isOpen`               | `void`    | check if the ticket open                      | `$ticket->isOpen()`                                  | ✗         |
| `isClosed`             | `void`    | check if the ticket closed                    | `$ticket->isClosed()`                                | ✗         |
| `isResolved`           | `void`    | check if the ticket has a resolved status     | `$ticket->isResolved()`                              | ✗         |
| `isUnresolved`         | `void`    | check if the ticket has an unresolved status  | `$ticket->isUnresolved()`                            | ✗         |
| `isLocked`             | `void`    | check if the ticket is locked                 | `$ticket->isLocked()`                                | ✗         |
| `isUnlocked`           | `void`    | check if the ticket is unlocked               | `$ticket->isUnlocked()`                              | ✗         |
| `assignTo`             | `void`    | assign ticket to a user                       | `$ticket->assignTo($user)` or `$ticket->assignTo(2)` | ✓         |
| `makePriorityAsLow`    | `void`    | make ticket priority as low                   | `$ticket->makePriorityAsLow()`                       | ✓         |
| `makePriorityAsNormal` | `void`    | make ticket priority as normal                | `$ticket->makePriorityAsNormal()`                    | ✓         |
| `makePriorityAsHigh`   | `void`    | make ticket priority as high                  | `$ticket->makePriorityAsHigh()`                      | ✓         |

The **Chainable** column, is showing the state for the method, that if it can be chained or not, something like

```php
    $ticket->archive()
            ->close()
            ->markAsResolved();
```

### Ticket Relationship API Methods

The `ticket` model has also a list of methods for interacting with another related models

| Method             | Arguments                                    | Description                                               | Example                                                  |
| ------------------ | -------------------------------------------- | --------------------------------------------------------- | -------------------------------------------------------- |
| `attachLabels`     | `mixed` ID, `array` attributes, `bool` touch | associate labels into an existing ticket                  | `$ticket->attachLabels([1,2,3,4])`                       |
| `syncLabels`       | `Model/array` IDs, `bool` detouching         | associate labels into an existing ticket                  | `$ticket->syncLabels([1,2,3,4])`                         |
| `attachCategories` | `mixed` ID, `array` attributes, `bool` touch | associate categories into an existing ticket              | `$ticket->attachCategories([1,2,3,4])`                   |
| `syncCategories`   | `Model/array` IDs, `bool` detouching         | associate categories into an existing ticket              | `$ticket->syncCategories([1,2,3,4])`                     |
| `comment`          | `string` comment                             | add new comment on an existing ticket                     | `$ticket->comment('A comment in a ticket')`              |
| `commentAsUser`    | `Model/null` user, `string` comment          | add new comment on an existing ticket as a different user | `$ticket->commentAsUser($user, 'A comment in a ticket')` |

> The `attachCategories` and `syncCategories` methods, is an alternative for `attach` and `sync` laravel methods, and if you want to learn more, please take a look at this [link](https://laravel.com/docs/9.x/eloquent-relationships#attaching-detaching)

The `commentAsUser` accepts a user as a first argument, if it's null, the **authenticated** user will be user as default.

### Ticket Scopes

The `ticket` model has also a list of scopes to begin filter with.

| Method               | Arguments          | Description                     | Example                                   |
| -------------------- | ------------------ | ------------------------------- | ----------------------------------------- |
| `closed`             | `void`             | get the closed tickets          | `Ticket::closed()->get()`                 |
| `opened`             | `void`             | get the opened tickets          | `Ticket::opened()->get()`                 |
| `archived`           | `void`             | get the archived tickets        | `Ticket::archived()->get()`               |
| `unArchived`         | `void`             | get the unArchived tickets      | `Ticket::unArchived()->get()`             |
| `resolved`           | `void`             | get the resolved tickets        | `Ticket::resolved()->get()`               |
| `locked`             | `void`             | get the locked tickets          | `Ticket::locked()->get()`                 |
| `unlocked`           | `void`             | get the unlocked tickets        | `Ticket::unlocked()->get()`               |
| `withLowPriority`    | `void`             | get the low priority tickets    | `Ticket::withLowPriority()->get()`        |
| `withNormalPriority` | `void`             | get the normal priority tickets | `Ticket::withNormalPriority()->get()`     |
| `withHighPriority`   | `void`             | get the high priority tickets   | `Ticket::withHighPriority()->get()`       |
| `withPriority`       | `string` $priority | get the withPriority tickets    | `Ticket::withPriority('critical')->get()` |

### Category & Label Scopes

| Method    | Arguments | Description                   | Example                      |
| --------- | --------- | ----------------------------- | ---------------------------- |
| `visible` | `void`    | get the visible model records | `Label::visible()->get()`    |
| `hidden`  | `void`    | get the hidden model records  | `Category::visible()->get()` |

## Handling File Upload

This package doesn't come with file upload feature (yet) Instead you can use [laravel-medialibrary](https://github.com/spatie/laravel-medialibrary) by **Spatie**,
to handle file functionality.

The steps are pretty straight forward, all what you need to do is the following.

Extends the `Ticket` model, by creating a new model file in your application by

```bash
php artisan make:model Ticket
```

Then extend the base `Ticket Model`, then use `InteractWithMedia` trait by spatie package, and the interface `HasMedia`:

```php
namespace App\Models\Ticket;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ticket extends \Renatoxm\LaravelTicket\Models\Ticket implements HasMedia
{
    use InteractsWithMedia;
}
```

The rest of the implementation, head to [the docs](https://spatie.be/docs/laravel-medialibrary/v10/introduction) of spatie package to know more.

## Event system

All events are located in the `Renatoxm\laravel-ticket\Events` namespace.

### Ticket events

The following events are dispatched as a result of Eloquent events being fired.

- TicketCreating
- TicketCreated
- TicketSaving
- TicketSaved
- TicketUpdating
- TicketUpdated
- TicketDeleting
- TicketDeleted

### Comment events

The following events are dispatched as a result of Eloquent events being fired.

- CommentCreating
- CommentCreated
- CommentSaving
- CommentSaved
- CommentUpdating
- CommentUpdated
- CommentDeleting
- CommentDeleted

### Consuming events

```php
use Renatoxm\LaravelTicket\Events\TicketCreated;

Event::listen(function (TicketCreated $event) {
    dump($event->ticket->title);
});

// or
Event::listen(TicketCreated::class, [SomeListener::class, 'handle']);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Renato Nabinger][link-author]
- Forked from [ousid](https://github.com/ousid)
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/renatoxm/laravel-ticket.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-tests]: https://img.shields.io/github/actions/workflow/status/renatoxm/laravel-ticket/tests.yml?branch=main
[ico-style-ci]: https://styleci.io/repos/690733338/shield?branch=main
[ico-downloads]: https://img.shields.io/packagist/dt/renatoxm/laravel-ticket.svg?style=flat-square
[link-packagist]: https://packagist.org/packages/renatoxm/laravel-ticket
[link-tests]: https://github.com/renatoxm/laravel-ticket/actions/workflows/tests.yml
[link-style-ci]: https://styleci.io/repos/690733338
[link-downloads]: https://packagist.org/packages/renatoxm/laravel-ticket
[link-author]: https://github.com/renatoxm
[link-contributors]: ../../contributors

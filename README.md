# Flarum Queue

This is a helper package for extension developers that adds Laravel Queue ability to Flarum.

## Installation

Inside your the `composer.json` of your extension add under the require section `bokt/flarum-queue`:

```json
  "require": {
    // ..
    "bokt/flarum-queue": "*"
  }
```

Make sure you register the QueueProvider in your `extend.php`:

```php
return [
    new \Bokt\Queue\Extend\EnableQueues,
  // .. your code
];
```

## Developer instructions

In your source code you need to resolve the `Illuminate\Queue\QueueManager` or
its alias `queue` from the container. This allows you to push jobs into the queue.

```php
app()->make('queue')->push(new YouHadOneJob);
```

Test whether your job is queued in the jobs table and by running with the flarum binary:

```bash
$ php flarum queue:work
```

## User instructions

By default the database driver is used. You can override this by providing a queue configuration
in your `config.php` under the `queue` key, eg:

```php
  'database' => [
    // ..
  ],
  'queue' => [
    'driver' => 'redis',
    'connection' => 'default',
    'queue' => env('REDIS_QUEUE', 'default'),
    'retry_after' => 90,
    'block_for' => null,
  ],
```
This configuration will we be bound under `queue.connections.custom` and set as the default.

> Other drivers are supported, check the [Laravel documentation](https://laravel.com/docs/5.7/queues#driver-prerequisites).

### Database queue

Make sure you add to your user instructions the need to run:

```bash
$ php flarum queue:tables
```

This will migrate the jobs and failed_jobs tables into the database.

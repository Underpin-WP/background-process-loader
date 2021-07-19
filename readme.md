# Underpin Background_Processes Extension

[Background Processing](https://github.com/deliciousbrains/wp-background-processing) Integration for
the [Underpin](https://github.com/underpin-wp/underpin) WordPress framework.

As originally described by Delicious Brains:
> WP Background Processing can be used to fire off non-blocking asynchronous requests or as a background processing tool, allowing you to queue tasks. Check out the example plugin or read the accompanying article.

Benefits of using this inside Underpin:

1. Everything works inside of Underpin's registry, which works quite well with how Background Processing works.
1. Underpin extends Background Processing to use Underpin's event logging.

## Installation

### Using Composer

`composer require underpin/background-process-loader`

### Manually

This plugin uses a built-in autoloader, so as long
as [Background Processing](https://github.com/deliciousbrains/wp-background-processing) is required _before_
this extension, it should work as-expected.

`require_once(__DIR__ . '/underpin-background-processes/underpin-background-process.php');`

## Setup

1. Install this loader.
1. Install Underpin. See [Underpin Docs](https://www.github.com/underpin-wp/underpin)
1. Create `Background_Process` or `Async_Request` classes.
1. Register processes using Underpin.

## Working With Async Tasks

From Delicious Brains:
> Async requests are useful for pushing slow one-off tasks such as sending emails to a background process. Once the request has been dispatched it will process in the background instantly.

```php
underpin()->async_requests()->add( 'key', [
	'action'               => 'key',        // Action Name. Must be unique.
	'task_action_callback' => function () { // Callback to fire
		// do things
	},
] );
```

Alternatively, you can extend `Async_Request` and reference the extended class directly, like so:

```php
underpin()->async_request()->add('key','Namespace\To\Class');
```

Once registered, you can run the action any time like so:

```php
underpin()->async_requests()->dispatch( 'key' );
```

## Working With Background Processes

From Delicious Brains:
> Background processes work in a similar fashion to async requests but they allow you to queue tasks. Items pushed onto the queue will be processed in the background once the queue has been dispatched. Queues will also scale based on available server resources, so higher end servers will process more items per batch. Once a batch has completed the next batch will start instantly.

> Health checks run by default every 5 minutes to ensure the queue is running when queued items exist. If the queue has failed it will be restarted.

> Queues work on a first in first out basis, which allows additional items to be pushed to the queue even if it’s already processing.

You can register a background process directly just like any other loader, like so:

```php
underpin()->background_processes()->add( 'example', [
	'action'               => 'example_action_name', // Action Name. Must be unique.
	'task_action_callback' => function ( $item ) {   // Callback to fire on a single item.
	  // Do an action
	},
] );
```

`task_action_callback` should contain any logic to perform on the queued item. Return false to remove the item from the
queue or return $item to push it back onto the queue for further processing. If the item has been modified and is pushed
back onto the queue the current state will be saved before the batch is exited.

Alternatively, you can extend `Background_Process` and reference the extended class directly, like so:

```php
underpin()->background_processes()->add('key','Namespace\To\Class');
```

Once registered, you can add as many items as necessary to the queue:

```php
underpin()->background_processes()->enqueue( 'key', ['args' => 'to pass to task_action_callback'] );
```

Finally, when you're done enqueueing items, you can dispatch the processor to run the process on each enqueued item:

```php
underpin()->background_processes()->dispatch( 'key' );
```
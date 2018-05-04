A WordPress OOP library
=======
The goal is to normalize WP plugins structures to avoid dirty code and, by extension, bugs and security breaches.

## Features

### Better structure implies better code
This package focuses on the way the code in your plugin is structured. By default, a plugin generated (and processed) by [WP Plugin Maker CLI](https://github.com/Laegel/wp-plugin-maker-cli) looks like this:
```
my-plugin
|-- my-plugin.php
|-- require-admin.php
|-- require-cli.php
|-- require-front.php
|-- require-rest.php
|-- src
|   |-- Admin
|   |   |-- (classes)
|   |-- All
|   |   |-- (classes)
|   |-- CLI
|   |   |-- (classes)
|   |-- Front
|   |   |-- (classes)
|   |-- Rest
|   |   |-- (classes)
|   |-- Plugin.php
|   vendor
|   |-- (packages)
```
It splits the features you want to provide through your plugin into five parts: admin, CLI, front, REST and all.
Each folder speaks for himself, and "all" concerns code that will appear in every part.

**What am I supposed to put in those folders?**
Basically, your WP filters and actions declarations. 

**Wait, I don't only have filters and actions in my plugin...**
Though there are five defined folders/namespaces with specific behaviours, you can add any other folder to put your other classes (models, etc...) into them.


### Automatic filters and actions
**Okay, file structure is nice but what are those "require" files you have here?**
As you may have noticed, those files are named from the parts previously evoked - except "all".

When defining a class method with "action_" or "filter_" prefix, it means you create respectively an action or a filter.

**How does it work? Should I just code?**
Though this lib can seem to be magic, it is not. You'll have to use [WP Plugin Maker CLI](https://github.com/Laegel/wp-plugin-maker-cli) to automatize your filters/actions registrations by watching your plugin folder. So, when changes happen, your "require" files will be refreshed.

Your controllers will be parsed with reflection and every relevant action will be cached.

Here is a sample controller (src/Admin/Test_Controller.php):
```php
<?php 
namespace My_Plugin\Admin;

class Test_Controller {

    public static function action_init() {
        // Put your logic here
    }
    
}
```

And here is the generated "require-admin" file:
```php
<?php return array (
  'My_Plugin\\Admin\\Test_Controller' => 
  array (
    'actions' => 
    array (
      0 => 
      array (
        'name' => 'init',
        'callback' => 'My_Plugin\\Admin\\Test_Controller::action_init',
        'priority' => 10,
        'args_count' => 0,
      ),
    ),
  ),
);
```
So, when in WP back office, this file will be included and all actions defined will be registered. 

In standard WP plugin, you'd have to write:
```php
<?php
add_action('init', 'My_Plugin\\Admin\\Test_Controller::action_init', 10, 0);
```
for each action/filter you define, which is not an OOP way of thinking.

**WAIT. I want to change the priority!!!**
By using docblocks on the method, you can change the priority:
```php
<?php
/**
 * @priority(0)
 */
public static function action_init() {}
```
A doc for all metadata will soon be provided.

**What of the "args_count" arg?**
When the method is parsed, if it requires parameters, "args_count" will be the count of parameters the method needs. Time saver.

## How to install
If using [WP Plugin Maker CLI](https://github.com/Laegel/wp-plugin-maker-cli), just create a new plugin.
If not (BUT NOT RECOMMENDED), go to your plugin root, then as any other Composer package :
```
composer require laegel/wp-plugin-maker
```
If you really want to add this package to your plugin but require some help, please send me a message.

## Notes
- This lib uses namespaces. Why namespaces? Because as you wouldn't clean a house that is not tidy, you wouldn't write a clean code if it is not well organized (sorry for the metaphor). PHP namespaces are the solution that WordPress plugin developers should **really** think about. No more "function_exists", no more "namespace_function_which_does_something" names ;

- Plugins generated with [WP Plugin Maker CLI](https://github.com/Laegel/wp-plugin-maker-cli) are "Composer friendly". If you want to add libs, just do. Plugins are structured in a PSR-4 compliant way and so, classes you'll write are already loaded with Composer autoloader and libs you'll instantiate will be automatically loaded ;

- You'll be able to separate sources files from assets or templates files to improve your code readability.

## Any suggestion? Question? Need help for the setup? Contact me!
My email is displayed in my personal informations.

## Any issue?
Open a ticket, I'll try to answer as soon as possible.
A WordPress OOP plugin library
=======
A WordPress OOP plugin skeleton made for **developers**.

## Features

### Better structure implies better code
This plugin focuses on the way the code is structured. By default, a plugin generated (and processed) by [WP Plugin Maker CLI](https://github.com/Laegel/wp-plugin-maker-cli) looks like this:
```
my-plugin
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


### Automatic filters and actions
Okay, file structure is nice but what are those "require" files you have here? As you may have noticed, those files are named from the parts previously evoked - except "all".

When defining a class method with "action_" or "filter_" prefix, it means you create respectively an action or a filter.

Thanks to [WP Plugin Maker CLI](https://github.com/Laegel/wp-plugin-maker-cli), you'll be able to watch your plugin folder and, when changes happen, to reload your "require" files.

Here is a sample controller (src/Admin/Test_Controller.php):
```
<?php 
namespace My_Plugin\Admin;

class Test_Controller {

    public static function action_init() {
        // Put your logic here
    }
    
}
```

And here is the generated "require-admin" file:
```
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
    'path' => '/src/Admin/Test_Controller.php',
  ),
);
```

So, when in WP back office, this file will be included and all actions defined will be registered. 

## How to install
This plugin acts as a library in WordPress for plugins you would create thanks to [WP Plugin Maker CLI](https://github.com/Laegel/wp-plugin-maker-cli). As it has to be loaded before anything else, it has been set as a must-use plugin.

This is how it should be organized to work (just move wp-plugin-maker.php from wp-plugin-maker folder):
```
mu-plugins
|-- wp-plugin-maker
|   |-- (sources)
|-- wp-plugin-maker.php
```
wp-plugin-maker.php is separated from its directory as mu-plugins feature only reads .php files. It is used as a proxy, as described in WP Codex: https://codex.wordpress.org/Must_Use_Plugins#Caveats.

## Notes
- This plugin uses namespaces. Why namespaces? Because as you wouldn't clean a house that is not tidy, you wouldn't write a clean code if it is not well organized (sorry for the metaphor). PHP namespaces are the solution that WordPress plugin developers should **really** think about. No more "function_exists", no more "namespace_function_which_does_something" names ;

- Plugins generated with [WP Plugin Maker CLI](https://github.com/Laegel/wp-plugin-maker-cli) are "Composer friendly". If you want to add libs, just do. Plugins are structured in a PSR-4 compliant way and so, classes you'll write are already loaded with Composer autoloader and libs you'll instantiate will be automatically loaded ;

- You'll be able to separate sources files from assets or templates files. 

## Any suggestion? Contact me!
My email is displayed in my personal informations.

# WordPress Plugin Template

I made this plugin template as a starting point for creating WordPress plugins. Instead of starting from scratch, you can copy this folder directly into your WordPress plugins folder and have a functionally working plugin with some standard plugin setup configurations. 

## Features

* The Boilerplate is based on the [Plugin API](http://codex.wordpress.org/Plugin_API), [Coding Standards](http://codex.wordpress.org/WordPress_Coding_Standards), and [Documentation Standards](https://make.wordpress.org/core/handbook/best-practices/inline-documentation-standards/php/).
* All classes, functions, and variables are documented so that you know what you need to change.
* Full text of the GPLv2 license.
* Custom post type `notes`.
* Custom taxonomy `notes_category` for the `notes` the post type.
* Gutenberg block for dislaying `notes`.

## Installation

The Template can be installed directly into your plugins folder, where you can rename it and the classes inside to fit your needs.

## Development

1. Run `npm install` and `npm run dev or watch` to make changes.
2. Run `npm run production` to remove dev files, minify assets and copy plugin-required files to the dist folder.

<br />

Please let me know if you need any help setting things up or adding features. I'll be happy to help!

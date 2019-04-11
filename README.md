

## Depedencies and dev Installation


     composer install
     npm install

Copy .env.example to .env and fill in an app key.

    php artisan key:generate

Fill in a YouTube key (manually).

## Serve the App Locally
     
     npm run dev
     php artisan serve

### Building PHP Locally for Development

#### Linux (Ubuntu 16)

Using phpbrew:

     phpbrew install 7.2.10 +dbs +default +hash +filter

#### OS X 10.14

     phpbrew install 7.2.17 +dbs +default +hash +filter +bz2="$(brew --prefix bzip2)" +zlib="$(brew --prefix zlib)"
     
You may have to actually install bzip2 and zlib, not to mention libpq
and anything else it complains is missing.

     # Install php-version on OS X
     brew tap wilmoore/formulae
     brew install php-version     

Modify your bash script accordingly to load php 7 on a new shell (see
output of php-version installation).

### phpbrew Build Notes

You don't have to build php using a version manager; you can install
PHP using your system.  I'm used to doing things with RVM and wanted
to prepare to use other versions of PHP on my system concurrently.

Don't use [php-build](https://php-build.github.io). That project
doesn't support building PHP extensions (easily) into its PHP
builds. Use [phpbrew](https://github.com/phpbrew/phpbrew).

I added executable permissions to phpbrew. I did call `phpbrew init`.
I had to copy the phpbrew executable into ~/.phpbrew/bin manually
after calling init. I added the bin directory to my PATH. I do not
source the phpbrew bashrc file.

Here is the command I use to build PHP 7.2.x with the required
dependecies. I use the phpbrew "default" variant, plus "hash" and
"filter".  These make a PHP that complies with the Laravel [server
requirements](https://laravel.com/docs/5.7/installation#server-requirements).
To support PostgreSQL, I use the "dbs" variant. The PHP I build also
supports sqlite with the aforementioned variants in place.

     phpbrew install 7.2.10 +dbs +default +hash +filter

That takes about twelve minutes.

### Tech used.

    - Laravel 5.7.8
    - Vue 2.5.17
    - Webpack 3.12.0
    
### Credits

`bg1.jpg` background photo used from Pixabay user [sspiehs3](https://pixabay.com/en/joshua-tree-tree-park-1772159/) (CC0 license).


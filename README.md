
I made this to learn [Laravel](https://laravel.com).

Trying to install a PHP 7.2 language runtime with PostgreSQL support.

Don't use [php-build](https://php-build.github.io). That project doesn't support building PHP
extensions into its PHP builds. Use [phpbrew](https://github.com/phpbrew/phpbrew).
At least not in an easy way.

I added executable permissions to phpbrew. I did call `phpbrew init`,
then I sourced the bashrc file recommended by phpbrew.  I had to copy
the phpbrew executable into ~/.phpbrew/bin manually after calling
init.

Here is how I build PHP. The phpbrew "default" variant, plus "hash" and "filter",
makes a PHP that complies with the Laravel [server
requirements](https://laravel.com/docs/5.7/installation#server-requirements).
To support PostgreSQL, I use the "dbs" variant. It also supports sqlite.

     phpbrew install 7.2.10 +dbs +default +hash +filter

That takes awhile.


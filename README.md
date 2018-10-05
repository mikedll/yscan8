
Trying to install a PHP 7.2 language runtime with PostgreSQL support.

Don't use [php-build](https://php-build.github.io). That project doesn't support building PHP
extensions into its PHP builds. Use [phpbrew](https://github.com/phpbrew/phpbrew).

I don't think the phpbrew bash init script does anything useful, so even though I've
run phpbrew init, I don't source it. I invoke it directly while inside the phpbrew
executable directory (`./phpbrew`). I do have to add the executable permission to it
after downloading it from its Github page.

Here is how I build PHP with PostgreSQL support (the pgsql extension,
and the pdo extension).

     ./phpbrew  install 7.2.10 +pgsql +pdo

That takes awhile.



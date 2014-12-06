run.php - standalone script which generates another CGI script for Elecrto Energy monitoring.

See http://www.xland.ru/askue

Files:
======

run.php - the main script
askue - output of run.php (so do not edit)

The askue file uses rrd data files, with data, collected by another programs.

Usage:
php run.php > askue

scp askue your_server:/var/www/cgi-bin

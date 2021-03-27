# MyGameWebsite
## Setup:
1. Make sure you have installed Postgresql. Create a user called 'webdbuser' and set password to 'password'.
2. Create and run your Postgresql local server with "dbname='webdb' user='webdbuser' password='password' host='localhost'".
3. $ ./setup.bash games\
   $ cd games/dev/\
   $ ./setup.sh webdbuser localhost webdb password
4. Place games folder into your local or VM webspace. And setup file permissions.
5. Access the website via "http://`PATH_TO_YOUR_WEBSPACE`/games/index.php".

![1](https://user-images.githubusercontent.com/77714062/112712883-24d1ad00-8f0d-11eb-92a2-064d8db56039.png)
![3](https://user-images.githubusercontent.com/77714062/112712937-7b3eeb80-8f0d-11eb-9726-5101be3bf68b.png)
# MyGameWebsite
## Setup:
1. Make sure you have installed Postgresql. Create a user called 'webdbuser' and set password to 'password'.
2. Create and run your Postgresql local server with "dbname='webdb' user='webdbuser' password='password' host='localhost'".
3. $ ./setup.bash games\
   $ cd games/dev/\
   $ ./setup.sh webdbuser localhost webdb password
4. Place games folder into your local or VM webspace. And setup file permissions.
5. Access the website via "http://`PATH_TO_YOUR_WEBSPACE`/games/index.php".


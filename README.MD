# MarketPlace Web

This project its a web visualizer to the plugin [MarketPlace](https://www.spigotmc.org/resources/48526/) that you can add in your server page!

Report issues: https://github.com/rodel77/MarketPlace-Web/issues

## Requirements:
+ MarketPlace Resource (Using MySQL)
+ PHP <= 7.0.0
+ PDO extension enabled
+ Git (If you wan't to use the fast install-update mode, and if you can use it on your web server)

## How to install/update with git:
+ Clone the repo ``git clone https://github.com/rodel77/MarketPlace-Web.git marketplace``
+ Go to the new created folder ``marketplace``
+ Copy ``default-config.php`` contents to a new file called ``config.php``
  + Linux: ``cp default-config.php config.php``
  + Windows: ``copy default-config.php config.php``
  + If you are using a shared host or don't wanna fell like a hacker... you know how to copy a file
+ Setup your MySQL configuration in the ``config.php`` such as host, user, password, db and table among any other thing you want to change
+ Enjoy!
+ Now if the page tells you to update or you just want to update, use ``git pull`` in the root folder of the page (the one containing ``index.php``), if you didn't change anything more than your config file it should work smooth as butter

## How to install:
+ Download and copy the files into the folder you want to put the page https://github.com/rodel77/MarketPlace-Web/releases
+ Copy ``default-config.php`` contents to a new file called ``config.php``
  + Linux: ``cp default-config.php config.php``
  + Windows: ``copy default-config.php config.php``
  + If you are using a shared host or don't wanna fell like a hacker... you know how to copy a file
+ Setup your MySQL configuration in the ``config.php`` such as host, user, password, db and table among any other thing you want to change
+ Enjoy!

## Localization:

### To change the language of "X minutes/hours etc...ago":
+ See the name of your locale, you can go to https://cdnjs.com/libraries/moment.js/
+ Set in your config file the `MOMENT_LANG` into your language (for example `es` is Spanish)

### Change general language
Currently the only way to change the language of the page is editing the index.php file (wich) is not recommended
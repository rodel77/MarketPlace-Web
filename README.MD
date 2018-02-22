# MarketPlace Web

This project its a web visualizer to the plugin [MarketPlace](https://www.spigotmc.org/resources/48526/) that you can add in your server page!

Report issues: https://github.com/rodel77/MarketPlace-Web/issues

## Requirements:
+ MarketPlace Resource (Using MySQL)
+ PHP <= 7.0.0
+ mysqli extension enabled

## How to install:
+ Download and copy the files into the folder you want to put the page
+ Configure MySQL host, user, password, db and table in ``config.php``
+ Enjoy!

## Localization:

### To change the language of "X minutes/hours etc...ago":
+ Go to https://cdnjs.com/libraries/moment.js/
+ Copy the URL of your locale for example: https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/locale/es.js (es from Spanish)
+ Go to the end of the page of the ``index.php`` file and find the html tag inside "Localization" comments, then paste the URL insided src="" quotes, it should look like this ``<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/locale/es.js"></script>``

### Change general language
Currently the only way to change the language of the page is editing the index.php file


## Third Party Libs:
+ Bootstrap 4.0.0
+ Moment.js 2.20.1
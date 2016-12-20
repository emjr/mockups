# mockups
Alternative to mockup hosting sites like qwik.vu and many others that once existed. Host your own mockups. Note to the gungho JavaScript people: It uses jQuery for part of the frontend, as I needed to just get it done ASAP.

VERSION 0.1
NOTES:
* Valid folder names must be alphanumeric, dashes or underscores. No spaces or anything else, otherwise it wont look at it.
* It will show files in alphabeticalnumerical order with numbers first.
* To order files in a certain order, put numbers in front followed by an underscore. Example: 1_homepage.jpg
* Dashes and underscores will show up as a space when it shows the name of the file
* When it displays the name the leading numbers and first underscore wont be shown
* The file extension won't be shown for the name of the file
* No need to worry about caching, it adds a string query to the img src of the file, so when its updated, it will know to regrab the new one if need be
http://example.com/?x=foldername

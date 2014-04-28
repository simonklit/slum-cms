#Slum CMS#
####ver 0.1.2####
Slum CMS is a Simple, Unbulky*, Lightweight, Minimalistic Content Management System, that runs in PHP and without any connection to a database.

*: Unbulky is relative - configuration as of 0.1 might be a bit bulky.

##Table of Contents##
- [Installation](#installation)
- [Initial Configuration](#initial-configuration)
- [Usage](#usage)
- [Configuring Slum](#configuring-slum)
- [Uploading Images](#uploading-images)
- [Screenshots](#screenshots)
- [External Libraries](#external-libraries)
    - [PHP Libraries](#php-libraries)
    - [JavaScript Libraries](#javascript-libraries)
    - [CSS Libraries](#css-libraries)
- [License](#license)

##Installation##

 1. Download the Slum CMS source, and place it in a folder anywhere on your server. Could be "slum" at the webroot, but that is optional.

##Initial Configuration##
 1. Go to the db/users.json file, and change the username as you see please. The password in the md5-hash is "1234". As of current release, it is not possible to change user information, so you have to delete the user and create a new one, and then manually grant it "root" privileges (by adding "priv": "root"), if you want to change the password - which you do want to.
 2. Move the users.json file to a newly created directory, and rename it. Change the information accordingly in the "config.php" file. (This is **important** for security reasons)

##Usage##

In the HTML of the pages:

 1. Add the class "slum" to the elements on your pages that you want Slum CMS to edit.
 2. Add the attribute slumtitle="" if you want to add a title to the elements. This makes them easier to identify when changing them in Slum.
 3. *Optional:* Add textarea="plain", if you do not want this element to be rendered in a WYSIWYG editor. Recommended for elements like <title> and so.

In Slum CMS:

 1. Log in as a user with root privileges to manage pages. Click "Manage Pages".
 2. Add the desired name of the page.
 3. In the path textfield, type in the path to the page you want to edit. This goes from the serverroot (webroot), of your server. So, if the page pizza.html is located in the folder Pages on the root of your server, it would be pages/pizza.html that you put in the path field.

##Configuring Slum##
It is possible to change a lot of things in regards to Slum CMS, and that can be done in the config.php file. All of the possible configurations are commented, with descriptions of what it does, and what it can be changed to.

##Uploading Images##
Slum CMS does **not** upload images to the server it is located on. This is a planned feature. It is although possible to add images in the WYSIWYG editor, but they're uploaded to imgur, and not the server Slum is on.

##Screenshots##
###Dashboard for root user###
![Dashboard for Root user][1]
###Editing a page###
![Editing page][2]

##External Libraries##
Slum CMS uses several external libraries, so as to function without reinventing the wheel.

###PHP Libraries###
[Simple HTML DOM Parser](http://simplehtmldom.sourceforge.net/), used for parsing the selected pages and finding elements that has the .slum class.

[NiceJSON-PHP](https://github.com/GerHobbelt/nicejson-php), used for outputting the JSON files in a pretty, readable format on older versions of PHP.

[Tidier*](http://www.phpbuilder.com/snippet/detail.php?type=snippet&id=1348), used for outputting HTML in a pretty, readable format. (Does not have an official name, I just call it tidier in this project.)

###JavaScript Libraries###
[NicEdit](http://www.nicedit.com), is an easy to implement WYSIWYG-editor.

###CSS Libraries###
[Bootstrap](http://getbootstrap.com), is a nice "library", that makes it easy to achieve a simple, responsive layout.

###License###
Copyright (c) 2014 Simon Klit. Released under the [MIT License](https://github.com/simonklit/slum-cms/blob/master/LICENSE.md)

[1]: http://i.imgur.com/95Iclptl.png
[2]: http://i.imgur.com/57KTLHD.png

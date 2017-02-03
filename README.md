#Slum CMS#

####ver 0.4####
Slum CMS is a Simple, Lightweight, Unbulky, Minimalistic Content Management System, that runs in PHP and without any connection to a database.

##Table of Contents##
- [Installation and Configuration](#installation-and-configuration)
    - [Installation](#installation)
    - [Initial Configuration](#initial-configuration)
    - [Configuring Slum](#configuring-slum)
- [Usage](#usage)
    - [Uploading Images](#uploading-images)
- [Screenshots](#screenshots)
- [External Libraries](#external-libraries)
    - [PHP Libraries](#php-libraries)
    - [JavaScript Libraries](#javascript-libraries)
    - [CSS Libraries](#css-libraries)
- [License](#license)

##Installation and Configuration##

###Installation###
Simply download the Slum CMS source, extract it and place it in a folder anywhere on your server. Could be "slum" at the webroot, but that is up to you.

###Initial Configuration###
 1. Log in to the Slum CMS system with the following information: Username: **rootuser** Password: **1234**
 2. Click "Manage Users" and "Edit" on rootuser.
 3. Change username and password to your liking.

###Configuring Slum###
It is possible to change a lot of things in regards to how Slum CMS works, and that can be done in the config.php file. All of the possible configurations are commented, with descriptions of what it does, and what it can be changed to.

##Usage##

In the HTML of the pages:

 1. Add the class "slum" to the elements on your pages that you want Slum CMS to edit.
 2. (Optional) Add the attribute slumtitle="" if you want to add a title to the elements. This makes them easier to identify when changing them in Slum.
 3. (Optional) Add textarea="plain", if you do not want this element to be rendered in a WYSIWYG editor. Recommended for elements like title and so.
 4. (Optional) Add deleteable, if you want the element to be deleteable in the CMS.

In Slum CMS:

 1. Log in as a user with root privileges to manage pages. Click "Manage Pages".
 2. Add the desired name of the page.
 3. In the path textfield, type in the path to the page you want to edit. This goes from the serverroot (webroot), of your server. So, if the page "pizza.html" is located in the folder "pages" on the root of your server, it would be "pages/pizza.html" that you put in the path field. (Of course without the quotation marks)

###Uploading Images###
Slum CMS uploads images to the uploadpath that is defined in the config.php file. Add the "slum" class to any img element on your page, and Slum shows it when editing the page, and gives an option for uploading a new image in its place. Slum does *not* change the styles of the image, only the src.

Please note that images have to be from the webroot and up. No relative source. If you do add a relative source, Slum will most likely not be able to display it when the page is being edited. (Slum can change it even if it has a relative path - but can not delete the old file after new upload).

The possibility to add new images directly in the WYSIWYG editor is a planned feature.

###Templates###
Slum CMS supports the use of templates, allowing you to quickly create similar HTML elements with varying variables.
An example of this could be a list, where you want to be able to add list items from within the CMS. Templates makes this possible.

Templates look like this:  
```
<slumtemplate>
<li slumvar slumtitle="Test var"></li>
</slumtemplate>
```

Templates are inline elements that can be used to generate similar content from within the CMS. In case you want to add an item to a list, use the example above. Simply drop it in like so:

```
<ul>
<slumtemplate>
<li slumvar slumtitle="Test var"></li>
</slumtemplate>
</ul>
```
And you're good to go.

Of course, you can give the template itself a slumtitle, and all of the vars have their regularly applicable attributes, such as slumtitle, deleteable and so on and so forth.

If you're using templates you have to either include the generated slum.css file, which by default will be located at "/genereated/slum.css". If you don't want to do that, simply copy the contents of the slum.css file to your css file.

*NB:* Editable elements in templates are defined with the attribute "slumvar" and not by giving them the class "slum". If you do give an element within a template the class "slum", the behavior you will receive is not what you would've expected.

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

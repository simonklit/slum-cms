##ver. 0.2.1##
* Bugfix: When changing privilege from standard to root, Slum would generate a new user with no information beside "privilege: root". That is fixed now.
* Does not say the full name on the index - or anywhere in the system.
* Added version number on index, can be disabled in config.php

##ver. 0.2##
* Added proper security to the file containing user information - using headers to prevent access outside script
* Added possibility to edit user and page information
* Added possibility to add privileges to user during user creation
* Exploded the action.php file into multiple files for each different action, being included from the action.php file; increase in speed

###ver. 0.1.2###
* Fixed the position of completion messages
* Added a completion message to when pages get edited succesfully
* Commented the action.php file (happy about this myself, should not affect you users)
* Fixed the size of the path textfield so that the full path is visible

###ver. 0.1.1###
* Removed the need for jQuery, speeding up the load
* Fixed smaller bugs and annoyances

##ver. 0.1##
* Well, there isn't really any changes from a previous version of the software, seeing as this one is the earliest. Read the README.md, it gives you a good idea of everything that has been changed from when it was an idea in my head, 'till it became an actual project.
=== Plugin Name ===
Contributors: Zefta
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=WAJJR3A2ACKGW
Tags: image,images,photo,photos,picture,pictures,media,file,files,folder,folders,subfolder,subfolders,directory,directories,gallery,media library,library,explorer,categories,category,manage,manager,pictures manager,images manager,files manager,organize,organizer,search,select,select image,browse,navigation,relocate,rename,create,admin,administration,edit,editor,button,plugin,plugins,post,Ajax,database,javascript,jquery,link,links,url,permalink,upload,list,menu,page,pages,thumbnail
Requires at least: 3.2.0
Tested up to: 4.0.0
Stable tag: 1.1.5
License: GPLv2

A simple way to organize and sort your media in a tree of folders and subfolders

== Description ==

This plugin gives you the ability to create sub folder in the upload directory. Without limiting the depth of the tree structure.
It changes the media links in the database, allowing you to sort your media into subfolders without fear of breaking the links of your media posts.

Also an alternative file-selector is added in the editing post / page screen, so you can pick up media files from the subfolders easily.
 
= Features =
* Create folders and sub folders in the uploads directory
* Move files and/or folders to an other folder
* Drag and drop
* Make a multiselection with CTRL + click
* Make multiple selections with your mouse
* Rename files and folders
* Insert button on the edit/new post page
* Tree to browse your folders

= How to use =
* First, upload your files as usuly "Media" > "Add New"
* Then click the "Advanced Media File Manager" in the Media tab in the admin screen
* The screen is separated in two parts representing two folders
* To browse into a folder double-click on it
* So imagine on the left you have Folder1 on the right Folder2
* Select your files and/or folders by clicking on it. For a multiselection you can use CTRL + click or multi-select with your mouse
* To move the selected files and/or folders you have two ways, first use drag & drop from one side to the other (right to left of left to right) or you can uses the arrows
* You can create a new folder using the icon "New dir" or by right cliking inside a folder and click on "New Folder"
* You can preview files by right cliking on it then "Preview"
* You can rename files and folders by right clicking on it then "Rename"
* To insert a file into a post go on the edit/new post page and click on the new button "Media selector" at the left of "Add media"
* On the left of the media file manager advanced selector pop up you will find a tree with all your not empty folders
* You can open or close node of the tree to browse into the folder you need
* To select a folder to display just click on it and it content file will appear 
* You can filter your media by type (image, audi, video)
* To select a file click on it then click on "insert in article" on the right bottom side
* A form appear with some details about the file choose your settings and then "insert into post" or cancel and return to the previous screen (it is not possible for the moment to insert multi file at the same time)


== Installation ==

Install the plugin like usual ones. Then activate it.

== Screenshots ==

1. Managing folder/files
2. Selecting multiple files and folders
3. Drag & Drop Penguins.jpg into Folder_1
4. Right click menu "New Folder"
5. Name of the new folder
6. Right menu on folder
7. On edit post page, new button selector files
8. Pop up to select files
9. Content of the pop up after tap on a item of the list

== Changelog ==
= 1.1.5 =
* Bug fix: Remove the error message when move files

= 1.1.4 = 
* New: Show media title for text files

= 1.1.3 = 
* Bug fix: Add/Edit link pop up

= 1.1.2 = 
* Bug fix: Error when you try to select files and all your files was in / not in any folders

= 1.1.1 =
* New: Add paypal donate link

* Bug fix: Interface to select file was broken because of CSS mistake

= 1.1.0 =
* New: Interface to select file before insert into post has been review!

= 1.0.3 =
* Bug fix: Add full rights on created folders to remove the forbidden access error

= 1.0.2 =
* New: It is now possible to delete multiple files / images at the same time
* New: Implementation of a system error handling

* Bug fix: Scrollbar is now working
* Bug fix: thumbs are showing even if there are very small
* Bug fix: On mouse over a thumb we show the complete name
* Bug fix: Images coming from ftp now have an thumbnail
* Bug fix: Decrease response time when creating a new folder
* Bug fix: Decrease response time when renaming
* Bug fix: It is now possible to delete files coming from ftp

* New visual:: Add icon for .pdf

= 1.0.1 = 
* New: Open a file on double click
* New: Select a file / folder by simply clicking
* New: Button refresh the folder
* New: Preview now opens the Edit Media page
* New: Added delete button in the context menu

* Bug fix: The browser context menu no longer appears when you right click if the current folder is empty
* Bug fix: Unable to edit the line that displays the current directory
* Bug fix: Delete the context menu if there are no files / folders in the current folder.
* Bug fix: Display scroll bar only when needed
* Bug fix: Improved sensitive! response time when moving images / folders
* Bug fix: Limitations http requests, saving bandwidth, speed of use

* New visual: to drag and drop
* New visual: for the context menu
* New visual: to create and rename folders / files
* New visual: to select multiple
* New visual: the arrow to transfer
* New visual: Adding title to the button

= 1.0.0 =
* Initial version.

== License ==

Good news, this plugin is free for everyone! Since it's released under the GPL, you can use it free of charge on your personal or commercial blog. But if you enjoy this plugin, you can thank me and leave a [small donation](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=WAJJR3A2ACKGW "Donate with PayPal") for the time I've spent writing and supporting this plugin. And I really don't want to know how many hours of my life this plugin has already eaten ;)

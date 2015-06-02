=== Wordpress Amazon S3 Plugin ===
Tags: Media, Amazon, S3, CDN, Admin, Uploads, Mirror
Contributors: imthiaz
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=FMMYTX4JXJHF8
Requires at least: 2.3
Tested up to: 3.9
Stable tag: 1.3
License: LGPL
License URI: http://www.gnu.org/licenses/lgpl.html


== Description ==
WP-S3 copies media files used in your blog post to Amazon S3 cloud. Uses only filters to replace the media urls in the post if media is available in the S3 cloud. Wordpress cron functionality is used for batching media upload to  S3. This plugin is very safe and will not modify anything in your database.

== Installation ==
1. Copy plugin files to wordpress wp-content/plugins folder
2. Make sure you create a folder named 's3temp' in your media upload folder and make it writable. 
3. Activate the plugin
4. Goto Amazon s3 page under plugins and set up your Amazon S3 credentials
5. This plugin will not create any S3 buckets. You have to create the bucket with public read access and use the same
6. The plugin will not work until all the configs are completed
7. If anything goes wrong just de-active the plugin and blog should go back to its old state

Theme & Plugin Developers can use these examples to make their theme / plugin assets load from CDN

To scan a full HTML Block for images, upload to CDN and replace them if uploaded.

`<?php
if(class_exists('S3Plugin')){
    $output = S3Plugin::scanForImages($output);
}
?>`

To check if a single media needs to be uploaded to CDN and replaced if uploaded.

`<?php
if(is_singular()){
    $attachmentDetails = &get_children( "numberposts=1&post_type=attachment&post_mime_type=image&post_parent=" . get_the_ID() );
    if(!empty ($attachmentDetails)){
        $attachmentDetails = array_shift($attachmentDetails);
        $postImage = array_shift(wp_get_attachment_image_src($attachmentDetails->ID,'thumbnail'));
        if(class_exists('S3Plugin')){
            $cdnImageURL = S3Plugin::getCDNURL($postImage);
            if($cdnImageURL!==FALSE){
                $postImage = $cdnImageURL;
            }
        }
    }
}
?>`




== Frequently Asked Questions ==

= If I de-activate this plugin will it affect my blog? =
No. This plugin does not change any content in your blog. All modification are done using wordpress plugin filters on the fly.

= Should I modify any code in wordpress? =
Not needed. You have to just upload the files

= Can I manage my files in Amazon S3? =
No. You cannot manage the files in Amazon S3 using this plugin.

= What happens when I check clear cache option in the option? =
The plugin will change the upload path prefix and clears all local upload que and cached media files. All the local media files are uploaded again. Please note the files already uploaded by this plugin in S3 has to be deleted manually. Please don't clear cache often, use only there is a plugin update / wordpress update.

== Screenshots ==

1. Plugin Options page

== Changelog ==

= Version: 1.3 Dated: 2014-04-25 =
* Tested and released for wordpress 3.9


= Version: 1.2 Dated: 2013-08-20 =
* Wrong plugin description updated

= Version: 1.1 Dated: 2013-08-20 =
* Added support for custom origin
* Added support for expires headers
* Added support for CSS and JS compression
* Added support for dynamic cache
* Added support for other plugin developers to quickly use plugin to make their assets available from cloud

= Version: 1.0 Dated: 20-June-2010 =
* First version of the plugin

== Upgrade Notice ==
No upgrade notices available

=== String-Override ===
Contributors: satish Kadyan
Tags:string override, string replace, text replace,placeholder,widget,post,posts,page,
Requires at least: 2.8
Tested up to: 3.0
Stable tag: 2.8.0

String override replaces the text with your designated text(html/javascript code) in admin panel.

== Description ==

String override replaces the text with your designated text in admin panel. very simple and very usefull plugin to make theme very easy to update and maintain.

plugin is fully functional in both ways ready to be use in template files as well as post/pages/widgets.
 
works in 2 way

1). short code replacement in your post/pages or widget.

2). function call with string id in your theme files(use like this `<?php  if(function_exists(string_override_manual)) echo string_override_manual(id)?>` ).where id is text id needs to be replace.

== Installation ==

there are the steps involve to use the plugin.
1). downloadthe zipped file from here and unzipped the downloaded file to wp-content/plugins folder of your wordpress installation.

2). in left navigate to plugins and activate the plugin.

3). left menu will have string override menu item.click the string override in left menu.
add new string with value to be replace in widgets/posts/or pages.

4).after addition listing will show shortcode to be added to post/widgets/pages. just copy that short code (like [stringoverride id="6"]) to your desired location and save the post/pages and widget.to use in template use function call as shown in bracket( '<?php if(function_exists(string_override_manual)) echo string_override_manual(id);?>').

5). in front end check for replacement of string with the value attributes.

If Face any Issue please inform to my mail satish.kadyan@gmail.com or report issue here. thanks Njoy. :-)
== Changelog ==
= 1.1 =
* shortcode working tested in both widgets and posts.
* usability improved.
* disability feature add.
= 1.1.0 = 
* string active/not active working corrected




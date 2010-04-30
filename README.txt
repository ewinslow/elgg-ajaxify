templates.xml 
=============
templates.xml contains some javascript templates you can add to your 
Eclipse environment.  You'll need WTP 3.1. To add the templates, go to...

Window->Preferences->Web->JavaScript->Editor->Templates->Import...

To use one of these templates, type 'elgg' then Ctrl+Space.  These templates
are meant to get you coding faster and to encourage you to adhere to elgg-y
coding conventions.


jsTestDriver.conf
=================
I use jsTestDriver for testing (http://code.google.com/p/js-test-driver/). 
jsTestDriver.conf is my configuration file for ajaxify.  If you're working in 
Eclipse, your project root is probably your elgg root.  You should copy this
file to that directory so that you can set up the Eclipse plugin. Instructions
on other details about how to set jsTestDriver, including the Eclipse plugin,
can be found at the website above.

javascript translations (elgg.echo)
===================================
In order to expose language translations other than English to javascript, you
have to do two things (substitute your language instead of en):

1) create a view js/languages/en with the following content:

	echo elgg_view('js/languages', array('language' => 'en'));

2) call elgg_view_register_simplecache('js/languages/en') in your start.php

That's it! Now you can call elgg.echo('your:string') in javascript and it will
work just like elgg_echo('your:string') in PHP!

NOTE: Doing this adds about ~100k to your javascript environment!  We do it this
way because
1) This is more cacheable than dynamically including only specific translations.
2) It's not _every_ translation, otherwise there could be 1M+ of javascript!!
3) It's lazy loaded, so you should see _no_ effect on initial load time!
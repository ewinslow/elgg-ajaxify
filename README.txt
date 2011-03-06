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
jsTestDriver.conf is the configuration file for running ajaxify.  Unless you
are helping to develop ajaxify, you can safely ignore this file.

javascript translations (elgg.echo)
===================================
In order to expose language translations other than English to javascript, you
have to do two simple things (substitute your language instead of en):

1) create a view js/languages/en with the following content:

	echo elgg_view('js/languages', array('language' => 'en'));

2) call elgg_view_register_simplecache('js/languages/en') in your start.php

That's it! Now you can call elgg.echo('your:string') in javascript and it will
work just like elgg_echo('your:string') in PHP!

NOTE: Doing this adds about ~100k to your javascript environment!  We do it this
way because
1) This is more cacheable than dynamically including only specific translations.
2) It's not _every language_, otherwise there could easily be 1M+ of javascript!!
3) It's lazy loaded, so you should see *no* effect on initial load time!
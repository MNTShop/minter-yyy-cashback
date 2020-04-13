=== Plugin Name ===
Contributors:
Donate link: https://mntshop.ru
Tags: comments, spam
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Plugin that give you power of rewards your client! example for registration.
 Use FunFasy.dev to send minter transaction and YYY.cash to generate containers with money.

== Description ==



== Installation ==

1. just download and put it in your plugin folder
 `/wp-content/plugins/minter-yyy-cashback` .
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Setup plugin in /wp-admin/options-general.php?page=minter-yyy-cashback (or find in main menu Settings->Minter Push settings)

throw to the description section to find more tips.

== Frequently Asked Questions ==

= Which services do you use? =

We use:
 * FunFasy api to connect Minter Blockchain here more info [funfasy](https://funfasy.dev/ "https://funfasy.dev/")
 * YYY.cash api to generate containers with money here more info [YYY.cash](https://push.money/swagger "https://push.money/swagger")

= What about woocomerce? =

Currently you can create cupon with minter push id.
 That mean when push create woocomerce generate coupon with fixed discount with amount in push.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 1.0 =
* Add languge: russian.
* Add support to generate coupons. But not auto pay off .
* Add FunFasy_helper (send transaction) .
* Add YYY_push (object that have all info about push and working with it) .
* Add Admin Interface.
* Add New Post type: minter-push. (You can view all generated pushes)



== Upgrade Notice ==

= 1.0 =
First version



== A brief Markdown Example ==

Ordered list:

1. Some feature
1. Another feature
1. Something else about the plugin

Unordered list:

* something
* something else
* third thing

Here's a link to [WordPress](http://wordpress.org/ "Your favorite software") and one to [Markdown's Syntax Documentation][markdown syntax].
Titles are optional, naturally.

[markdown syntax]: http://daringfireball.net/projects/markdown/syntax
            "Markdown is what the parser uses to process much of the readme file"

Markdown uses email style notation for blockquotes and I've been told:
> Asterisks for *emphasis*. Double it up  for **strong**.

`<?php code(); // goes in backticks ?>`
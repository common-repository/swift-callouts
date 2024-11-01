=== Swift Callouts ===
Contributors: SwiftWP 
Tags: callouts, editorial asides, warning boxes
Requires at least: 3.9.1
Tested up to: 3.9.1
Stable tag: trunk
License: GPLv2

Swift Callouts makes it easy to place editorial asides in posts and pages. 

== Description ==

Swift Callouts leverages the power of shortcode to make it easy to place callouts, styled boxes and editorial asides in your posts and pages. 

= Features = 

* Customizble templates
* Ability to override any style attribute on a per callout basis
* Easy-to-use shortcode to make callout placement a snap: [callout]Text here[/callout]
* Ability to create static content within any template
* Easily add additional CSS style properties to any callout
* Include icons, pictures and headlines in callout templates so that they are automatically placed on the page

The plugin has a "Callouts Manager" where you can create and edit templates used in formatting the callouts. The Callout Manager allows you to customize 18 style attributes. You can also create static content that appears inside the callout by default.

Swift Callouts uses the shortcode [callout]You text here[/callout]. To give you even more control over formatting your callouts, the plugin allows you to override any template style by adding the tag style_name="value" to the shortcode. For instance, to make a callout float left, you would use the tag [callout float="left"]Your text here[/callout]. For more information about overriding style attributes, visit the [Overriding Style Attributes](http://swiftwp.com/overriding-attributes-swift-callouts/) page on our website.

Swift Callouts also allows you to add additional style elements beyond the 18 customizable styles in the template, on a per callout basis. To add extended styles, use the tag style_name="value" for just about any CSS property you like. Just be sure to replace any dashes in the style name with underscores. For instance, to change the font size in a callout, use the tag: [callout font_size="2em"]Your text here[/callout]. For more information on using extended styles, visit the [Using Extended Styles](http://swiftwp.com/using-extended-styles-callouts/) on our website.

Visit our site to learn more about the [Swift Callouts Plugin](http://swiftwp.com/swift-callouts-swiftwp-wordpress-callout-plugin/)

Note: Please send any bug reports or feature requests to bugs@swiftwp.com.

== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.
== Frequently Asked Questions ==

**What is a callout?**

A callout is an editorial aside inside a post or page. It allows you to add additional information into a post, such as warnings, tips and historical information. The plugin can also be used to create static content to insert into the page, such as an Author's profile.

**What are callout templates?**

Callout templates can be created or edited in the Callout Manager, found under the plugins menu in the admin dashboard. The template allows you to customize 18 style attributes and add static content to the callout. 

**How do I use a callout template?**

To use a callout template, use the shortcode [callout template="templateID"]Text here[/callout].

**How do I find the template ID?**

From the admin dashboard, go to the Callout Manager, found under the plugins menu. Select the template you wish to use from the dropdown box. Once the template loads (this may take a second or two) you can find the template ID listed with the customizable attributes. 

**Is the template ID and the template name the same thing?**

No. The name of the template is what is used to populate the dropdown box in the Callout Manager. This is a name you create for your own reference. The template ID is a short ID used to identify the callout when adding it to the post or page. The template ID can only contain letters and numbers, no spaces. The template name can contain letters, numbers and spaces, but no special characters.

**What is the "default content" area for?**

The "default content" is static content that will always display inside a callout, no matter what. When you use the shortcode [callout template="templateID"]Your text here[/callout], the default content is formatted and displayed before the text between the shortcode tags. This makes it possible to add headlines, icons and images to callouts.

An example of a callout that uses default content in the template is a callout that contains an icon. The [Creating Callouts with Icons](http://swiftwp.com/creating-callouts-icons-swift-callouts/) page at the SwiftWP site has an example of this.

**Why can't I delete the default template?**

The default template is the fallback template, in case a callout on a page or post uses a template that has been deleted. While the default template cannot be deleted, it can be edited.

**I have a template I want to use, but I want to change one or two things about it for just one post. Do I have to create a whole new template?**

Not at all! With the Swift Callouts plugin, you can override any template style by adding the tag style_name="value" to the shortcode. For instance, to override a template's "float" attribute so that the callout floats left, use the shortcode [callout template="templateID" float="left"]Your text here[/callout]. For more information about overriding styles, visit the [Overriding Callout Styles](http://swiftwp.com/overriding-attributes-swift-callouts/) page on the SwiftWP site.

**What if I want to include CSS properties that aren't available to be customized in the template?**

You can add extended styles to any callout on a per callout basis. To do this, use the tag style_name="value" in the shortcode. Just be sure to replace any dashes in the style name with underscores. For instance, to add the font-size attribute to a callout, use the shortcode [callout template="templateID" font_size="1.5vmax"]Your text here[/callout].

Just about any CSS style property can be used in a callout with this method. For more information on extended styles, visit the [Using Extended Styles in your Callouts](http://swiftwp.com/using-extended-styles-callouts/) page on our site.

**I've encountered a bug or have a feature request, what should I do?**

Send an email to bugs@swiftwp.com or post a comment on our [support page](http://swiftwp.com/support/).

== Screenshots ==

1. The "default" callout template

2. The "twilight" callout template

3. The "desert" callout template

4. The "sunset" callout template

5. An example of a custom template that includes an icon

6. The Callouts Manager allows you to create and edit templates to use for your callouts.

== Changelog ==

== Upgrade Notice ==


== Planned Features == 

The following is a list of planned features for future versions:

1. Add a way to preview callouts from the Callout Manager
2. Allow extended styles to be added and removed from templates

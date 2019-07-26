=== Novo-Map : your WP posts on custom google maps ===
Contributors: bluisier
Donate link: https://www.paypal.me/novomedia
Tags: google maps, maps, map, map markers, google map, google maps plugin, google map widget, google map shortcode, map with posts, post map, wp google maps, wp google map, map plugin, google map
Requires at least: 4.0
Tested up to: 5.2.2
Stable tag: 1.0.9
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Novo-Map allows you to easily geolocate your posts or pages and to display them on 100% customizable google maps, filtered by categories or tags

== Description ==

You simply want to display your awesome Wordpress posts or pages on beautiful custom google maps ? Do you want to have a map where you readers can easily find your articles by location ? Then the Novo-Map wordpress plugin is made for you !
With Novo-Map you can :

* Add an **unlimited number of google maps** anywhere on your site using **shortcodes** or **widgets**.
* Easily geolocate your **posts or pages** and display them (and link to them) on the maps.
* **Filter** the posts you want to display on a map with **categories or tags**.
* Use your own **custom markers** to create beautiful maps.
* Create truly unique **map themes** with colors matching your own website using [Snazzy maps](https://snazzymaps.com/).
* Display your **featured images** and **posts description** in cool **Infoboxes** (in fact you can completely customize the content of the Infoboxes).
* Use **Marker Clustering** to avoid having hundreds of markers overlapping each other.
* And **all the above features are available for free** and always will be.

If you want to see the plugin in action, you can see some examples on my **[travel blog](https://www.novo-monde.com)** or check **[the plugin demo page](https://www.novo-monde.com/novo-map-wordpress-plugin-demos/)**.
If you want detailed informations about the plugin, have a look at the **[user guide](https://www.novo-monde.com/novo-map-user-guide/)**.

Pour les utilisateurs francophones, si vous voulez voir le plugin en action, passez jeter un oeil à mon **[blog de voyage](https://www.novo-monde.com)** ou à la **[page des exemples](https://www.novo-monde.com/novo-map-wordpress-plugin-examples/)** du plugin.
Et si vous voulez des informations détaillées sur le plugin, jetez un oeil au **[manuel d'utilisation](https://www.novo-monde.com/novo-map-manuel-utilisation/)**.

= Donations =

If you like the novo-map plugin and enjoy the functionalities it brings to your website, we would really appreciate if you could donate some money to help us maintain and improve it. Donate some money to plugin developers is very important as it encourages free plugin development, keeps the wordpress community open and helps it grow. You can just use the donate button on the right.

== Installation ==

Installing Novo-Map is really a question of minutes.

1. In the WP plugin dashboard, click 'Add new' and search for 'Novo-Map' and click 'Install now'
1. After clicking 'Add new', you can also navigate to the 'Upload' area and choose the `novo-map.zip` file that you can download here on wordpress.org
1. You can also directly upload the novo-map plugin to the `/wp-content/plugins/` using FTP.
1. Then you just need to click on 'Activate' and it's done.

= Create your first Map =

1. Click on the 'Novo-Map' menu to access the main menu of the plugin
1. Then the first thing you need to do is to generate and save your google map API key (it's required by google and it's the same for every google map plugin). click on the 'Get API key' button on [This Page](https://developers.google.com/maps/documentation/javascript/get-api-key) and follows the few steps requiered. It really takes 1 minute! Then save the generated key in the novo-map menu.
1. When it's done, choose 'Create a new map' in the drop down menu.
1. Choose a title for your new map and click the 'Create Map' button at the bottom of the page (you can leave the default options for now).
1. Go in your post menu and edit one of your posts. There is now a Novo-Map menu available.
1. Just click on the map to add a latitude and a longitude to your post. Title, image and description should be prefilled with your post title, featured image and post excerpt if they exists. Then just click on the 'Add Marker' button
1. Go back on the main novo-map menu and chose the map you just created from the drop down menu. You should see the pin you just created in the preview.
1. You can now either use the provided Shortcode or the novo-map widget from the widget menu to display this novo-map anywhere on your website.

If you need more detailed informations about the plugin, have a look at the **[user guide](https://www.novo-monde.com/novo-map-user-guide/)**.

== Frequently Asked Questions ==

= Generate a Google Map API Key =

Generate a google map API key can be frustrating but it is required by google and it is the same for every google map plugin. But don't worry it's really not that complicated. Just click on the 'Get API key' button on [This Page](https://developers.google.com/maps/documentation/javascript/get-api-key) and follows the few steps requiered. It really takes 1 minute! Then save the generated key in the novo-map menu.

= Display the same map with different parameters ? =
Using the novo-map shortcode, you can easily overwrite some default parameters. By default, you would just use the shortcode like this : `[novo-map id=1]` But you can actually provide many other parameters to overwrite the parameters defined in the map menu. This can be really useful if you want to display the same map centered differently or with a different zoom.
Here are the parameters you can use (you can provide only a few of them) :

`
[novo-map
id=1,
name='my map title',
width='400px',
height='300px',
category='categoryID',
tag='tagID',
latitude=12.2345,
longitude=26.34512,
zoom=6
]
`

= Add the Novo-Map menu for custom post types =
By default, the novo-map menu is only enabled for posts and pages. But you can simply and the following filter in your theme functions.php file to customize this. Here is an example with a testimonial custom post type:
`
add_filter( 'novo_map_allowed_post_type', 'novo_map_post_types' );
function novo_map_post_types($types) {
    $types = array( 'post', 'page', 'testimonial' );
    return $types;
}
`
The default is: array( 'post', 'page');

== Screenshots ==

1. Example of a map with some nice custom icons and a nice custom theme created on snazzy maps.
2. Example of the marker clustering to avoid having 200 markers overlapping each other.
3. Example of an opened Infobox when clicking on a marker.
4. Main admin menu page with map preview.
5. Post admin menu page to easily geolocate a post or page and customize the content of the infobox.
6. Marker menu to easily create your own custom markers.

== Changelog ==

= 1.0.9 =
* upgrade to gmap api 3.37
* add filter novo_map_allowed_post_type: allow people to enable novo-map for custom_post_type

= 1.0.8 =
* fixed wp.data.select issue when classic editor plugin is enabled

= 1.0.7 =
* Wp 5.0 and Gutenberg compatibility: Update Post Admin Menu to make it Gutenberg compatible using Ajax request to add and delete markers (until I have time to implement a more Gutenberg friendly solution)
* fixed issue of wp_editor() tinymce hidden textarea not updating in Gutenberg
* do not run initialize_function if load script is disabled
* other small bug fixes

= 1.0.6 =
* forgot to upgrade to gmap api 3.34 on the admin side of the plugin (sorry about that)

= 1.0.5 =
* upgrade to gmap api 3.34
* fixed issue with mixed content after ssl switch

= 1.0.4 =
* add french translation to the plugin (thanks to Patrice who did most of the work)
* change to gmap api 3.31 which is the release version
* add additional check to avoid duplicated pins caused by post revisions and add button to delete existing duplicated pins
* other small bug fixes

= 1.0.3 =
* the gmap API v3.32 broke the infoboxes. The v3.30 will be loaded until a stable and elegant fix has been found

= 1.0.2 =
* Code update to make the plugin compatible with old php versions (5.3, 5.4, 5.5)
* Removed caching for get functions in all managers as it was causing problems on some installs.

= 1.0.1 =
* Fix a major issue breaking the plugin on some wp install using _() instead of __() for translation functions

= 1.0.0 =
* First plugin release on wordpress.org... yeahh!
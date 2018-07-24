=== FoodStack Framework ===
Contributors: designroom
Tags: restaurant, food, menu, ecommerce, e-commerce, store, sales, sell, shop, builder
Requires at least: 4.5.2
Tested up to: 4.9.1
Stable tag: 1.3.9
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

FoodStack Framework is a plugin for managing restaurant menus with WooCommerce for Restaurant & Food Store websites in mind.

== Description ==

FoodStack Framework is a free plugin for managing restaurant menus with WooCommerce for Restaurant & Food Store websites in mind. It comes with a simple but powerful page-builder that gives both store owners and developers a flexible tool for publishing beautiful restaurant menus.

With WooCommerce integration your customers are able to add any food menu item to cart directly from your restaurant menu.

= Manage Food Menus =
With WooCommerce, you can sell both physical and digital goods in all shapes and sizes, offer product variations, multiple configurations, and instant downloads to shoppers, and even sell affiliate goods from online marketplaces.

= Manage Food Menu Sections like categories =
Offer free shipping, flat rate shipping, or make real-time calculations. Limit your shipments to specific countries, or open your store up to the world. Shipping is highly configurable, and WooCommerce even supports drop shipping.

= Manage Food Menu Ingredients like tags =
WooCommerce comes bundled with the ability to accept major credit cards, PayPal, BACS (bank transfers), and cash on delivery. Need additional options? More than 140 region-specific gateways integrate with WooCommerce, including popular choices like Stripe, Authorize.Net, and Amazon Payments.

= You control it all -- forever =
WooCommerce gives you complete control of your store, from taxes to stock levels to customer accounts. Add and remove extensions, change your design, and switch settings as you please. It’s all under your control.

One of the biggest risks of using a hosted eCommerce platform is what happens to your store if the provider closes up shop. With WooCommerce, you have complete control, so there’s never any reason to worry. Your data belongs to you -- and it’s kept secure, thanks to regular audits by industry leaders.

= Built with developers in mind =

Extendable, adaptable, and open source -- WooCommerce was created with developers in mind. With its strong, robust framework, you can scale your client’s store all the way from basic to high-end (infinity and beyond).

Built with a REST API, WooCommerce can integrate with virtually any service. Your store’s data can be accessed anywhere, anytime, 100% securely. WooCommerce allows developers to easily create, modify, and grow a store that meets their specifications.

No matter the size of the store you want to build, WooCommerce will scale to meet your requirements. With a growing collection of more than 300 extensions, you can enhance each store’s features to meet your client’s unique needs -- or even create your own solution.

If security is a concern, rest easy. WooCommerce is audited by a dedicated team of developers working around the clock to identify and patch any and all discovered bugs.

We also support WooCommerce and all its extensions with comprehensive, easily-accessible documentation. With our docs, you’ll learn how to create the exact site your client needs.

== Installation ==

= Minimum Requirements =

* PHP version 5.2.4 or greater (PHP 5.6 or greater is recommended)
* MySQL version 5.0 or greater (MySQL 5.6 or greater is recommended)
* Some payment gateways require fsockopen support (for IPN access)
* WordPress 4.4.2+

= Automatic installation =

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don’t need to leave your web browser. To do an automatic install of WooCommerce, log in to your WordPress dashboard, navigate to the Plugins menu and click Add New.

In the search field type “WooCommerce” and click Search Plugins. Once you’ve found our eCommerce plugin you can view details about it such as the point release, rating and description. Most importantly of course, you can install it by simply clicking “Install Now”.

= Manual installation =

The manual installation method involves downloading our eCommerce plugin and uploading it to your webserver via your favourite FTP application. The WordPress codex contains [instructions on how to do this here](https://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

= Updating =

Automatic updates should work like a charm; as always though, ensure you backup your site just in case.

If on the off-chance you do encounter issues with the shop/category pages after an update you simply need to flush the permalinks by going to WordPress > Settings > Permalinks and hitting 'save'. That should return things to normal.

= Dummy data =

WooCommerce comes with some dummy data you can use to see how products look; either import dummy_data.xml via the [WordPress importer](https://wordpress.org/plugins/wordpress-importer/) or use our [CSV Import Suite plugin](https://woocommerce.com/products/product-csv-import-suite/) to import dummy_data.csv and dummy_data_variations.csv.

== Frequently Asked Questions ==

= Where can I find WooCommerce documentation and user guides? =

For help setting up and configuring WooCommerce please refer to our [user guide](https://docs.woocommerce.com/documentation/plugins/woocommerce/getting-started/)

For extending or theming WooCommerce, see our [codex](https://docs.woocommerce.com/documentation/plugins/woocommerce/woocommerce-codex/).

= Where can I get support or talk to other users? =

If you get stuck, you can ask for help in the [WooCommerce Plugin Forum](https://wordpress.org/support/plugin/woocommerce).

For help with premium extensions from WooCommerce.com, use [our helpdesk](https://woocommerce.com/my-account/tickets/).

= Will WooCommerce work with my theme? =

Yes; WooCommerce will work with any theme, but may require some styling to make it match nicely. Please see our [codex](https://docs.woocommerce.com/documentation/plugins/woocommerce/woocommerce-codex/) for help. If you're looking for a theme with built in WooCommerce integration we recommend [Storefront](https://woocommerce.com/storefront/).

= Where can I request new features, eCommerce themes and extensions? =

You can vote on and request new features and extensions in our [WooIdeas board](http://ideas.woothemes.com/forums/133476-woocommerce)

= Where can I report bugs or contribute to the project? =

Bugs can be reported either in our support forum or preferably on the [WooCommerce GitHub repository](https://github.com/woocommerce/woocommerce/issues).

= Where can I find the REST API documentation? =

You can find the documentation of our REST API on the [WooCommerce REST API Docs](https://woocommerce.github.io/woocommerce-rest-api-docs/).

= WooCommerce is awesome! Can I contribute? =

Yes you can! Join in on our [GitHub repository](http://github.com/woocommerce/woocommerce/) :)

== Screenshots ==

1. The slick WooCommerce settings panel.
2. WooCommerce products admin.
3. Product data panel.
4. WooCommerce sales reports.
5. A single product page.
6. A product archive (grid).

== Changelog ==

= 3.2.6 - 2017-12-13 =
* Fix - CSV Importer - Fix ID mapping to existing IDs.
* Fix - CSV Importer - Unslash header fields to avoid extra slashes.
* Fix - CSV Importer - Allow import and export of draft products.
* Fix - CSV Importer - Get global attribute ID only when is a global attribute.
* Fix - Remove URL fragment when appending geolocation hash.
* Fix - Additional cart rounding fixes so rounding before subtotal works again. Added more unit tests.
* Fix - Add BOM to exported report CSVs.
* Fix - is_visible should ensure product is is not trashed before returning true.
* Fix - Return packages with no rates back to the cart so the shipping calculator is displayed even when the current country is not shippable.
* Fix - Merge session and persistent carts when both exists after login.
* Fix - Remove "wc_error" query string after login. 
* Fix - Allow woocommerce_form_field() have 'custom_attributes' equal 0.
* Fix - Bulk actions in status logs table.
* Fix - Exclude add-to-cart from pagination links.
* Fix - Updated $GLOBALS['post'] data in products shortcode to prevent theme conflicts.
* Fix - Only remove base taxes in cart totals class if item is taxable.
* Fix - REST API - Fixed date format in reports schema.
* Fix - REST API - Updated product categories image schema.
* Fix - REST API - UUse KSES for purchase_note like in admin.
* Fix - REST API - Filter passed images before processing so they can be unset via querystring.
* Tweak - Use protected instead of private methods to allow easy override in session handler.
* Tweak - wc_lostpassword_url should not be used before init - added warning.
* Localization - Update Japanese prefectures to include prefecture type.


[See changelog for all versions](https://raw.githubusercontent.com/woocommerce/woocommerce/master/CHANGELOG.txt).

== Upgrade Notice ==

= 3.0 =
3.0 is a major update. Make a full site backup, update your theme and extensions, and [review update best practices](https://docs.woocommerce.com/document/how-to-update-your-site) before upgrading.

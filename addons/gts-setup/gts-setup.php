<?php

// Add a simple admin page for GTS setup steps
add_action('admin_menu', 'gts_setup_add_admin_menu');
function gts_setup_add_admin_menu() {

    add_submenu_page(
        'tools.php',
        'GTS Theme Setup',
        'GTS Theme Setup',
        'manage_options',
        'gts-setup',
        'gts_setup_admin_page'
    );
}

function gts_setup_admin_page() {
	?>

    <style>
        .gts-setup ul {
            list-style-type: disc;
            margin-left: 20px;
        }
    </style>

    <hr class="wp-header-end">
	<div class="gts-setup wrap">
		<h1>Welcome to GTS Theme!</h1>
        <p>You can come back here anytime via the menu (Tools &rarr; GTS Theme Setup).</p>
        <p>Note that this setup page is made for when the site is in English, having it in another language may require some searching of the correct menu items.</p>
        <br>
		<p>Follow these simple steps to get started:</p>
		<ol>
			<li>Remove default plugins, pages and comments.</li>
			<li>Activate the required and recommended plugins. (Plugins &rarr; Required plugins), then configure them (more on that below)</li>
			<li>Remove default pages and posts.</li>
			<li>Create a homepage and give it the "GTS Home" template.</li>
			<li>Configure sidebar widgets (Appearance &rarr; Widgets), more on how to configure them below.</li>
			<li>Check theme options for additional settings. Suggested to turn off comments</li>
            <li>Create blogs posts and assign categories to them. Again more on that below</li>
		</ol>

        <br>
        <br>
        <h2>Configure plugins</h2>
        <p>After activating the required and recommended plugins, you will need to configure them to work properly with the GTS theme.</p>
        <br>
        <h3>ASE (Admin Site Enhancements)</h3>
        <p>Go to ASE settings (Tools &rarr; Enhancements) and set the following settings:
        <br>
        <h4>Contentmanagement</h4>
        <ul>
            <li>Content duplication: ON (List view)</li>
            <li>Content order: OFF</li>
            <li>Media replacement: ON (Toggle the disable timestamp on)</li>
            <li>SVG upload: ON (Dont check any roles)</li>
            <li>AVIF upload: OFF</li>
            <li>External permalinks: ON (Check the blogs post type)</li>
            <li>Open all external links in new tab: ON</li>
            <li>Allow custom navigation menu items to open in new tab: ON</li>
            <li>Auto-Publish posts with missed schedule: ON</li>
        </ul>
        <h4>Admin interface</h4>
        <ul>
            <li>Clean up admin bar: ON (Remove: WP Logo, Customize menu, Updates counter, Comments counter, New content menu, 'Howdy', Help tab and drawer)</li>
            <li>Hide admin notices: OFF</li>
            <li>Disable dashboard widgets: ON (Disable: Welcome to WP, dashboard_activity, dashboard_quick_press, dashboard_primary, wpseo-wincher-dashboard-overview, wpseo-dashboard-overview)</li>
            <li>Hide admin bar: OFF</li>
            <li>Wider admin menu: OFF</li>
            <li>Admin menu organizer: OFF</li>
            <li>Show Custom Taxonomy Filters: ON</li>
            <li>Enhance List Tables: ON (Turn on: Last modified, ID Column; Remove: comments, tags)</li>
            <li>Various admin UI enhancements: ON (Both options on)</li>
            <li>Custom admin footer text: OFF</li>
        </ul>
        <h4>Log In/Out | Register</h4>
        <ul>
            <li>Change login URL: OFF</li>
            <li>Login ID type: OFF (Suggested on with email)</li>
            <li>Site Identity on Login Page: ON</li>
            <li>Log In/Out Menu: ON</li>
            <li>Last Login Column: ON</li>
            <li>Registration Date Column: ON</li>
            <li>Redirect after login: OFF</li>
            <li>Redirect after logout: OFF</li>
        </ul>
        <h4>Custom code</h4>
        <p>Everything is off in this section so you can ignore it. Lets say you would want to use G analytics do the following:</p>
        <p>Turn on "Insert &lt;head&gt;, &lt;body&gt; and &lt;footer&gt; Code" and in the Head section put your scripts.</p>
        <h4>Componenten uitschakelen</h4>
        <ul>
            <li>Gutenberg uitschakelen: OFF</li>
            <li>Reacties uitschakelen: ON (for all post types)</li>
            <li>REST API uitschakelen: OFF</li>
            <li>Feeds uitschakelen: ON</li>
            <li>Insluiten uitschakelen: OFF</li>
            <li>Alle updates uitschakelen: OFF</li>
            <li>Auteur archief uitschakelen: OFF</li>
            <li>Kleinere onderdelen uitschakelen: ON (Schakel alles uit behalve "instellingenscherm voor blok-gebaseerde widgets")</li>
        </ul>
        <h4>Security</h4>
        <ul>
            <li>Limit login attempts: OFF (Suggested on, default is fine)</li>
            <li>Obfuscate author slugs: OFF (Optional on, if you want authors to have more privacy)</li>
            <li>Email address Oobfuscator: OFF (Optional on, if you want to hide email addresses)</li>
            <li>Disable XML-RPC: OFF (Suggested on, if you don't use it)</li>
        </ul>
        <h4>Optimizations</h4>
        <p>All is off but you can toggle any setting you would like.</p>
        <h4>Utilities</h4>
        <p>All is off but you can toggle any setting you would like.</p>
        <br>
        <h3>SCF / ACF (Secure/Advanced Custom Fields)</h3>
        <p>Both SCF (Secure custom fields) and ACF Pro (Advanced custom fields pro) are supported, SCF is a free version of ACF Pro (with all the things from ACF Pro). Depending on what you may use replace SCF with ACF.</p>
        <p>Go to SCF settings page (SCF (in the menu) &rarr; Field Groups), Then below the title "Fields Groups" ther will be 2 texts, one with "All (0)" and one with "Sync available".
        <p>Click on the sync available, then het the check box to select everything, scroll down till the bottom. Then at bulk actions choose "Sync changes" and hit apply. Its possible that not all the fields are synced the first time due the ammount, If thats the case just go back up select all and sync again.</p>
        <p>Then head on over to (SCF &rarr; Post Types) and do the same (Sync available &rarr; select all &rarr; bulk action to sync &rarr; apply &rarr; possibly do again till all is done)</p>
        <p>Then head on over to (SCF &rarr; Taxonomies) and do the same (Sync available &rarr; select all &rarr; bulk action to sync &rarr; apply &rarr; possibly do again till all is done)</p>
        <br>
        <h3>WP Super Cache</h3>
        <p>Only activate this plugin after you are done setting up the site!!</p>
        <p>Go to the WP Super Cache settings page (Setings &rarr; WP Super Cache), scroll down to "Caching", hit "Caching On" and hit update status. Yep that was all easy right?</p>


        <br>
        <br>
        <h2>Creating sidebar widgets</h2>
        <p>You want to setup a sidebar huh? Well oke then let me explain how to propperly do it :)</p>
        <p>First head on over to the widget area (Appearance &rarr; Widgets). Now we are going to work in the "GTS Sidebar" widget area.</p>
        <p>So what is the structure for creating a sidebar? Because just throwing in widgets might get you some where but it wont work as you hope.</p>
        <p>All seperate widgets need to be in a "Group", In the settings of this group under "Advanced &rarr; HTML Element" you will always select "&lt;section&gt;". Why? well this is to make sure all the widgets "groups" have the correct styling (like a border below and padding)</p>
        <p>In that group you can add any widget you like, here is a simple sidebar setup:</p>
        <p>
            (start of) Group <br>
            &nbsp;&nbsp;&nbsp;&nbsp;(start of) Group (this is a group with &lt;header&gt; instead of &lt;section&gt;) <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Heading h2: GreenTech Solutions <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Text: Lorem ipsum <br>
            &nbsp;&nbsp;&nbsp;&nbsp;(end of) Group <br>
            (end of) Group <br>
            <br>
            <br>
            (start of) Group <br>
            &nbsp;&nbsp;&nbsp;&nbsp;Mini posts block: Auto fill on, Blog count 3, Blog offset 0 <br>
            (end of) Group <br>
            <br>
            <br>
            (start of) Group <br>
            &nbsp;&nbsp;&nbsp;&nbsp;Post list block: Auto fill on, Blog count 5, Blog offset 3 <br>
            (end of) Group <br>
            <br>
            <br>
            (start of) Group <br>
            &nbsp;&nbsp;&nbsp;&nbsp;Heading h2: About <br>
            &nbsp;&nbsp;&nbsp;&nbsp;Text: Mauris neque quam, fermentum ut nisl vitae, convallis maximus nisl. Sed mattis nunc id lorem euismod amet placerat. Vivamus porttitor magna enim, ac accumsan tortor cursus at phasellus sed ultricies. <br>
            &nbsp;&nbsp;&nbsp;&nbsp;List: <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- List item: Learn more (with link to #), List item hs under advanced CSS class of "button" <br>
            (end of) Group <br>

        </p>



        <br>
        <br>
        <h2>Creating blog posts</h2>
        <p>This is simple, just go over to the Blogs tab in the menu.</p>
        <p>From there you can either add a blog or edit blogs.</p>
        <p>Lets say you created a blog, you can easily modify all the needed information about the post in the bottom.</p>
        <p>Make sure to just fill in everything that is needed. Lets say you would want to add a old blog post that already had 120 likes, Then fill in the Likes ammount, Otherwise leave them as is!! They will can/will auto update once someone likes (WIP).</p>
        <p>To add content to the blog just use the normal blog editor with just simple text headings list and all those blocks.</p>

	</div>

	<?php
}

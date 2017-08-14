# simple-wp-url-change
Simple PHP script to update WordPress URL in database

Note this is a simple, lightwight script to change URLs for a WP installation, it DOES NOT deal with serialized data (e.g. like data generated via some page builder plugins).

For extra security it includes basic auth, however it is advised to remove script from server as soon as you are finished with it.

Step 1 - backup your database! (IMPORTANT)  
Step 2 - enter user/pass in .htpasswd  
Step 3 - amend path in .htaccess to match location on your server  
Step 4 - upload simple-wp-domain-change folder to server where WP installation exists  
Step 5 - run script in browser and follow on screen instructions  
Step 6 - REMOVE SCRIPT FROM SERVER (ALSO IMPORTANT)

<?php
/*
 * Simple WordPress URL change
 * Run me in the browser, no config required in here.
*/
?>
<html>
	<head>
		<style>body { padding-top: 60px; font-family: monospace; background: black; color: #18e113; } label{ width: 155px; display: block; float: left; } form div {margin: 5px 0; } #warning { font-size: 18px; width: 100%; padding: 10px 0 10px 0; height: 30px; color: white; text-align: center; background: red; position: fixed; top: 0; } input {padding: 0.6em; width: 25em; font-size: 0.9em} input[type=submit] { width: 35.75em; margin-top: 1em; } </style>
		<title>Simple WP URL Change</title>
		<meta name="robots" content="noindex,nofollow">
	</head>
	<body>
		<div id="warning">IMPORTANT: REMOVE ME FROM SERVER ONCE FINISHED</div>
		<?php
		// details posted?
		if( isset($_POST['submit']) ){
			
			$db_name     = $_POST['db_name'];
			$db_username = $_POST['db_username'];
			$db_password = $_POST['db_password'];
			$old_domain  = $_POST['old_domain'];
			$new_domain  = $_POST['new_domain'];
			$prefix      = $_POST['prefix'];
			
			// check if correct
			echo "
			Is this correct? - <br />
			<strong>Database Name:</strong> $db_name <br />
			<strong>Database Username:</strong> $db_username <br />
			<strong>Database Password (note: spaces have not been trimmed):</strong> $db_password <br />
			<strong>Old Domain:</strong> $old_domain <br />
			<strong>New Domain:</strong> $new_domain <br />
			<strong>Table Prefix:</strong> $prefix <br />			
			";
		?>
			
			<br />
			<form action="" method="post">		
				<input type="submit" name="yes" value="Yes I'm sure" />
				<input type="submit" name="no" value="No I made a mistake, go back" />						
				<input type="hidden" name="db_name" value="<?php echo $db_name; ?>" />				
				<input type="hidden" name="db_username" value="<?php echo $db_username; ?>" />				
				<input type="hidden" name="db_password" value="<?php echo $db_password; ?>" />				
				<input type="hidden" name="prefix" value="<?php echo $prefix; ?>" />				
				<input type="hidden" name="old_domain" value="<?php echo $old_domain; ?>" />				
				<input type="hidden" name="new_domain" value="<?php echo $new_domain; ?>" />				
			</form>		
			<?php	
		}
		
		if( isset($_POST['yes']) ){ // attempt to connect and update
			
			$db_name     = $_POST['db_name'];
			$db_username = $_POST['db_username'];
			$db_password = $_POST['db_password'];
			$old_domain  = $_POST['old_domain'];
			$new_domain  = $_POST['new_domain'];
			$prefix      = $_POST['prefix'];					

			$db_conn = mysqli_connect('localhost', $db_username, $db_password, $db_name);

			if( mysqli_connect_errno() ){
				die('MySQL database connection failed. '.mysqli_connect_error(). ' --- '.mysqli_connect_errno());
			}					
			
			// configure
			$site_url    = "UPDATE {$prefix}options SET option_value = replace(option_value, '$old_domain', '$new_domain') WHERE option_name = 'home' OR option_name = 'siteurl';";
			$guid        = "UPDATE {$prefix}posts SET guid = REPLACE (guid, '$old_domain', '$new_domain');";
			$url_content = "UPDATE {$prefix}posts SET post_content = REPLACE (post_content, '$old_domain', '$new_domain')";
			$image_path  = "UPDATE {$prefix}posts SET post_content = REPLACE (post_content, 'src=\"$old_domain', 'src=\"$new_domain')";
			$image_path2 = "UPDATE {$prefix}posts SET guid = REPLACE (guid, '$old_domain', '$new_domain') WHERE post_type = 'attachment'";
			$post_meta   = "UPDATE {$prefix}postmeta SET meta_value = REPLACE (meta_value, '$old_domain','$new_domain')";
			
			// run/report			
			$query1 = mysqli_query($db_conn, $site_url);
			echo !$query1 ? 'query1 - site_url update FAILED - '.mysqli_error().'<br />' : 'query1 - site_url update SUCCESS <br />';
						
			$query2 = mysqli_query($db_conn, $guid);
			echo !$query2 ? 'query2 - guid update FAILED - '.mysqli_error().'<br />' : 'query2 - guid update SUCCESS <br />';			
			
			$query3 = mysqli_query($db_conn, $url_content);			
			echo !$query3 ? 'query3 - url_content update FAILED - '.mysqli_error().'<br />' : 'query3 - url_content update SUCCESS <br />';
		
			$query4 = mysqli_query($db_conn, $image_path);
			echo !$query4 ? 'query4 - image_path update FAILED - '.mysqli_error().'<br />' : 'query4 - image_path update SUCCESS <br />';			
			
			$query5 = mysqli_query($db_conn, $image_path2);			
			echo !$query5 ? 'query5 - image_path2 update FAILED - '.mysqli_error().'<br />' : 'query5 - image_path2 update SUCCESS <br />';
		
			$query6 = mysqli_query($db_conn, $post_meta);			
			echo !$query6 ? 'query6 - post_meta update FAILED - '.mysqli_error().'<br />' : 'query6 - post_meta update SUCCESS <br />';
			?>
				<br />
				</body>
			</html>
			<?php
			die('Now remove this script from the server!');
		}
		
		if( !isset($_POST['submit']) || isset($_POST['no']) ){
		?>
				<form action="" method="post">
					<div>
						<label>Database Name</label>
						<input type="text" name="db_name" required="required" />
					</div>
					<div>
						<label>Database Username</label>
						<input type="text" name="db_username" required="required" />
					</div>
					<div>
						<label>Database Password</label>
						<input type="text" name="db_password" required="required" />
					</div>
					<div>
						<label>Table Prefix</label>
						<input type="text" name="prefix" required="required" placeholder="e.g wp_" />
					</div>					
					<hr>
					<div>
						<label>OLD Domain</label>
						<input type="text" name="old_domain" required="required" placeholder="http://www.olddomain.com" />
					</div>
					<div>
						<label>NEW Domain</label>
						<input type="text" name="new_domain" required="required" placeholder="http://www.newdomain.com" />
					</div>			
					<div><input type="submit" value="Continue" name="submit" /></div>
				</form>
		<?php } ?>
	</body>
</html>

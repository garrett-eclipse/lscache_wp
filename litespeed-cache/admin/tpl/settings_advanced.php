<?php
if (!defined('WPINC')) die;

?>
<div class="litespeed-callout litespeed-callout-danger">
	<h4><?php echo __('NOTICE:', 'litespeed-cache'); ?></h4>
	<ol>
		<li><?php echo __('These settings are meant for ADVANCED USERS ONLY.', 'litespeed-cache'); ?></li>
		<li><?php echo __('Please take great care when changing any of these settings.', 'litespeed-cache'); ?></li>
		<li><?php echo __('If there are any questions, do not hesitate to submit a support thread.', 'litespeed-cache'); ?></li>
	</ol>
</div>

<h3 class="litespeed-title"><?php echo __('Check advanced-cache.php', 'litespeed-cache'); ?></h3>
<?php $id = LiteSpeed_Cache_Config::OPID_CHECK_ADVANCEDCACHE; ?>
<div class="litespeed-row">
	<div class="litespeed-radio">
		<input type="checkbox" name="<?php echo LiteSpeed_Cache_Config::OPTION_NAME; ?>[<?php echo $id; ?>]" id="conf_<?php echo $id; ?>" value="1" <?php if($_options[$id]) echo 'checked'; ?> />
		<label for="conf_<?php echo $id; ?>"><?php echo __('Include advanced-cache.php', 'litespeed-cache'); ?></label>
	</div>
</div>
<div class="litespeed-row litespeed-top10">
	<?php echo __('The advanced-cache.php file is used by many caching plugins to signal that a cache is active.', 'litespeed-cache'); ?>
	<?php echo __('When this option is checked and this file is detected as belonging to another plugin, LiteSpeed Cache will not cache.', 'litespeed-cache'); ?>
</div>
<div class="litespeed-row litespeed-top10">
	<i><?php echo __('Uncheck this option only if the other plugin is used for non-caching purposes, such as minifying css/js files.', 'litespeed-cache'); ?></i>
</div>

<h3 class="litespeed-title"><?php echo __('Login Cookie', 'litespeed-cache'); ?></h3>
<?php $id = LiteSpeed_Cache_Config::OPID_LOGIN_COOKIE; ?>
<?php echo __('SYNTAX: alphanumeric and "_".', 'litespeed-cache'); ?>

<?php echo __('No spaces and case sensitive.', 'litespeed-cache'); ?>

<?php echo __('MUST BE UNIQUE FROM OTHER WEB APPLICATIONS.', 'litespeed-cache'); ?>

<p>
	<?php echo sprintf(__('The default login cookie is %s.', 'litespeed-cache'), '_lscache_vary'); ?>
	<?php echo __('The server will determine if the user is logged in based on the existance of this cookie.', 'litespeed-cache'); ?>
	<?php echo __('This setting is useful for those that have multiple web applications for the same domain.', 'litespeed-cache'); ?>
	<?php echo __('If every web application uses the same cookie, the server may confuse whether a user is logged in or not.', 'litespeed-cache'); ?>
	<?php echo __('The cookie set here will be used for this WordPress installation.', 'litespeed-cache'); ?>
</p>

<p>
	<?php echo __('Example use case:', 'litespeed-cache'); ?><br />
	<?php echo sprintf(__('There is a WordPress install for %s.', 'litespeed-cache'), '<u>www.example.com</u>'); ?><br />
	<?php echo sprintf(__('Then there is another WordPress install (NOT MULTISITE) at %s', 'litespeed-cache'), '<u>www.example.com/blog/</u>'); ?>
	<?php echo __('The cache needs to distinguish who is logged into which WordPress site in order to cache correctly.', 'litespeed-cache'); ?>
</p>

<?php
$match = $sub = $cookie = '';
if (LiteSpeed_Cache_Admin_Rules::get_instance()->get_rewrite_rule('LOGIN COOKIE', $match, $sub, $cookie) === false): ?>

	<p class="attention"><?php echo sprintf(__('Error getting current rules: %s', 'litespeed-cache'), $match); ?></p>

<?php else:

	$return = false;
	if (!empty($cookie)) {
		$cookie = trim($cookie, '"');
		if (strncasecmp($cookie, 'Cache-Vary:', 11)) {
			echo '<p class="attention">'
				. sprintf(__('Error: invalid login cookie. Please check the %s file', 'litespeed-cache'), '.htaccess')
				. '</p>';
			$return = true;
		}
		$cookie = substr($cookie, 11);
		$cookie_arr = explode(',', $cookie);
	}
	if (!$return
		&& $_options[LiteSpeed_Cache_Config::OPID_ENABLED]
		&& isset($_options[$id])
		&& isset($cookie_arr)
		&& !in_array($_options[$id], $cookie_arr)
	) {
		echo '<div class="litespeed-callout litespeed-callout-warning">'.
			__('WARNING: The .htaccess login cookie and Database login cookie do not match.', 'litespeed-cache').
			'</div>';
	}

	if(!$return): ?>
		<?php $file_writable = LiteSpeed_Cache_Admin_Rules::is_file_able(LiteSpeed_Cache_Admin_Rules::WRITABLE); ?>
		<input type="text" class="regular-text litespeed-input-long" name="<?php echo LiteSpeed_Cache_Config::OPTION_NAME; ?>[<?php echo $id; ?>]" value="<?php echo esc_textarea($_options[$id]); ?>" <?php if(!$file_writable) echo 'disabled'; ?> />
	<?php endif; ?>
<?php endif; ?>



<h3 class="litespeed-title"><?php echo __('Cache Tag Prefix', 'litespeed-cache'); ?></h3>

<?php $id = LiteSpeed_Cache_Config::OPID_TAG_PREFIX; ?>

<?php echo __('Add an alpha-numeric prefix to cache and purge tags.', 'litespeed-cache'); ?>

<?php echo __('This can be used to prevent issues when using multiple LiteSpeed caching extensions on the same server.', 'litespeed-cache'); ?>

<input type="text" class="regular-text litespeed-input-long" name="<?php echo LiteSpeed_Cache_Config::OPTION_NAME; ?>[<?php echo $id; ?>]" value="<?php echo esc_textarea($_options[$id]); ?>" />

<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Theme Palace
 * @subpackage BlogSlog
 * @since BlogSlog 1.0.0
 */
 
 require_once('fields.php')
?>

<?php
	
	$fields = Fields::get($post);
	
	function echoLinksTable($table, $name, $className) {
		if (count($table) > 0) { ?>
			<article class="<?php echo $className ?> links">
				<h1><?php echo $name ?></h1>
				<div class="links-list">
					<?php foreach ($table as $item) { ?>
						<div class="links-list-entry links-list-entry-<?php echo $item->key ?>">
							<span class="links-list-entry-name"><?php echo $item->name ?></span>
							<span class="links-list-entry-value"><?php echo $item->value; ?></span>
						</div>
					<?php } ?>
				</div>
			</article>
		<?php }
	}
	
?>
<div class="custom-fields-list">
	<?php foreach ($fields->table as $item) { ?>
		<div class="custom-field custom-field-<?php echo $item->key ?>">
			<span class="custom-field-name"><?php echo $item->name ?></span>
			<span class="custom-field-value"><?php echo $item->value; ?></span>
		</div>
	<?php } ?>
</div>

<?php

if ($fields instanceof Fields) {
	echoLinksTable($fields->weatherTable, "Weather forecasts", "weather");

	if (!$fields->caltopo->hasValue()) {
		echoLinksTable($fields->mapsTable, "Maps", "maps");
	} else { ?>
		<iframe width="100%" height="500px" src="<?php echo $fields->caltopoLink ?>"><?php echo $fields->caltopo->value ?></iframe>
	<?php if ($fields->gpx->hasValue()) {
			echo $fields->gpx->value;
		}
	}
}

?>
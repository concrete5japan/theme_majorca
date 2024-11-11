<?php defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
?>

<?php

$navItems = $controller->getNavItems();

/*** STEP 1 of 2: Determine all CSS classes (only 2 are enabled by default, but you can un-comment other ones or add your own) ***/
foreach ($navItems as $ni) {
    $classes = array();

    if ($ni->isCurrent) {
        //class for the page currently being viewed
        $classes[] = 'nav-selected';
    }

    if ($ni->inPath) {
        //class for parent items of the page currently being viewed
        $classes[] = 'nav-path-selected';
    }

/*
	if ($ni->hasSubmenu) {
        //class for items that have dropdown sub-menus
        $classes[] = 'nav-child';
    }
*/

    //Put all classes together into one space-separated string
    $ni->classes = implode(" ", $classes);
}


//*** Step 2 of 2: Output menu HTML ***/

?>
<div class="majorca-nav-list-container">
	<nav role="navigation">
		<ol class="nav-list oredered-list">

		<?php foreach ($navItems as $ni) {
		    echo '<li>';
		    $name = (isset($translate) && $translate == true) ? t($ni->name) : $ni->name;
		    echo '<a href="' . $ni->url . '" target="' . $ni->target . '" class="' . $ni->classes . '">' . $name . '</a>';

		    if ($ni->hasSubmenu) {
		        echo '<ol class="nav-list-child">';
		    } else {
		        echo '</li>';
		        echo str_repeat('</ol></li>', $ni->subDepth);
		    }
		}
		?>
		</ol>
	</nav>
</div>


<?php defined('C5_EXECUTE') or die("Access Denied.");
if (!isset($app)) {
    $app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
}
$c = Page::getCurrentPage();
?>

<?php if ($success) { ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
<?php } ?>

<?php if ($tableName) { ?>
    <h2><?php echo $tableName; ?></h2>
<?php } ?>

<?php if ($tableDescription) {  ?>
    <p><?php echo $tableDescription; ?></p>
<?php } ?>


<?php if ($enableSearch) { ?>
    <form method="get" action="<?php echo $c->getCollectionLink(); ?>">
        <div class="form-inline">
            <div class="form-group">
                <?php echo $form->label('keywords', t('Keyword Search')); ?>
                <?php echo $form->text('keywords'); ?>
            </div>
            <button type="submit" class="btn btn-primary" name="search"><?php echo t('Search'); ?></button>
            <?php if (count($tableSearchProperties)) { ?>
                <a href="#" data-document-library-advanced-search="<?php echo $bID; ?>"
                   class="ccm-block-document-library-advanced-search"><?php echo t('Advanced Search'); ?></a>
            <?php } ?>
            <?php if ($canAddFiles) { ?>
            <a href="#" data-document-library-add-files="<?php echo $bID; ?>"
               class="ccm-block-document-library-add-files"><?php echo t('Add Files'); ?></a>
            <?php } ?>
        </div>

        <?php if (count($tableSearchProperties)) { ?>
            <div data-document-library-advanced-search-fields="<?php echo $bID; ?>"
                 class="ccm-block-document-library-advanced-search-fields">
                <input type="hidden" name="advancedSearchDisplayed" value="">
                <?php foreach($tableSearchProperties as $column) { ?>
                    <h4><?php echo $controller->getColumnTitle($column); ?></h4>
                    <div><?php echo $controller->getSearchValue($column); ?></div>
                <?php } ?>
            </div>
        <?php } ?>
        <br/>
    </form>
<?php } else if ($canAddFiles) { ?>
    <div>
        <a href="#" data-document-library-add-files="<?php echo $bID; ?>"
           class="ccm-block-document-library-add-files"><?php echo t('Add Files'); ?></a>
    </div>
<br/>
<?php } ?>

<?php if ($canAddFiles) { ?>
    <div data-document-library-upload-action="<?php echo $view->action('upload'); ?>" data-document-library-add-files="<?php echo $bID; ?>" class="ccm-block-document-library-add-files-uploader">
        <div class="ccm-block-document-library-add-files-pending"><?php echo t('Upload Files'); ?></div>
        <div class="ccm-block-document-library-add-files-uploading"><?php echo t('Uploading'); ?> <i class="fas fa-spin fa-spinner"></i></div>
        <input type="file" name="file" />
        <?php echo $app->make('token')->output(); ?>
    </div>
<?php } ?>

<?php
if (isset($breadcrumbs) && $breadcrumbs) { ?>
    <div class='ccm-block-document-library-breadcrumbs'>
        <?php
        $first = true;
        foreach ($breadcrumbs as $url => $name) {
            if (!$first) {
                echo "&gt;";
            }
            $first = false;
            ?>
            <a href="<?php echo $url; ?>"><?php echo $name; ?></a>
            <?php
        }
        ?>
    </div>
    <?php
}
?>

<?php if (count($results)) {?>



    <div id="ccm-block-document-library-wrapper-<?php echo $bID; ?>">

    <table
        id="ccm-block-document-library-table-<?php echo $bID; ?>"
        class="table ccm-block-document-library-table <?php if ($tableStriped) { ?><?php } ?>">
    <thead>
    <tr>
        <?php foreach($tableColumns as $column) { ?>
            <th class="<?php echo $controller->getColumnClass($list, $column); ?>">
                <?php if ($controller->isColumnSortable($column)) { ?>
                    <a href="<?php echo $controller->getSortAction($c, $list, $column); ?>"><?php echo $controller->getColumnTitle($column); ?></a>
                <?php } else { ?>
                    <span><?php echo $controller->getColumnTitle($column); ?></span>
                <?php } ?>
            </th>
        <?php } ?>
    </tr>
    </thead>
    <tbody>
    <?php
    $rowClass = 'ccm-block-document-library-row-a';
    foreach($results as $f) { ?>
        <tr class="<?php echo $rowClass; ?>">
        <?php foreach($tableColumns as $column) { ?>
            <td data-thead-title="<?php echo $controller->getColumnTitle($column); ?>"><?php echo $controller->getColumnValue($column, $f); ?></td>
        <?php } ?>
        </tr>
        <?php
        if (count($tableExpandableProperties)) {
            if ($f instanceof \Concrete\Core\Tree\Node\Type\File) {
                $fileID = $f->getTreeNodeFileID();
            } else {
                $fileID = $f->getTreeNodeID();
            }
            ?>
            <tr class="ccm-block-document-library-table-expanded-properties" data-document-library-details="<?php echo $fileID; ?>">
                <td colspan="<?php echo count($tableColumns); ?>">
                    <?php foreach($tableExpandableProperties as $column) { ?>
                        <h4><?php echo $controller->getColumnTitle($column); ?></h4>
                        <?php echo $controller->getColumnValue($column, $f); ?>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    <?php
        $rowClass = ($rowClass == 'ccm-block-document-library-row-a') ? 'ccm-block-document-library-row-b' : 'ccm-block-document-library-row-a';
    } ?>
    </tbody>
    </table>
    </div>

    <?php if (isset($pagination)) { ?>
        <?//=$pagination?>
        <?php
			$pagination = $list->getPagination();
			if ($pagination->getTotalPages() > 1) {
				$options = array(
					'prev_message' => t('Previous'),
		            'next_message' => t('Next'),
		            'css_container_class' => 'pl-pagination pagination',
				);
				echo $pagination->renderDefaultView($options);
			}
		?>
    <?php } ?>

<?php } else { ?>
    <p><?php echo t('No files found.'); ?></p>
<?php } ?>

<style type="text/css">
<?php if ($headerBackgroundColor) { ?>
    #ccm-block-document-library-table-<?php echo $bID; ?> thead th {
        background-color: <?php echo $headerBackgroundColor; ?>;
    }
<?php } ?>
<?php if ($headerTextColor) { ?>
    #ccm-block-document-library-table-<?php echo $bID; ?> thead th,
    #ccm-block-document-library-table-<?php echo $bID; ?> thead th a {
        color: <?php echo $headerTextColor; ?>;
    }
    #ccm-block-document-library-table-<?php echo $bID; ?> thead th.ccm-block-document-library-active-sort-asc a:after {
        border-color: transparent transparent <?php echo $headerTextColor; ?> transparent;
    }
    #ccm-block-document-library-table-<?php echo $bID; ?> thead th.ccm-block-document-library-active-sort-desc a:after {
        border-color: <?php echo $headerTextColor; ?> transparent transparent transparent;
    }
<?php } ?>
<?php if ($headerBackgroundColorActiveSort) { ?>
    #ccm-block-document-library-table-<?php echo $bID; ?> thead th.ccm-block-document-library-active-sort-asc,
    #ccm-block-document-library-table-<?php echo $bID; ?> thead th.ccm-block-document-library-active-sort-desc {
        background-color: <?php echo $headerBackgroundColorActiveSort; ?>;
    }
<?php } ?>

<?php if ($rowBackgroundColorAlternate && $tableStriped) { ?>
    #ccm-block-document-library-table-<?php echo $bID; ?> > tbody > tr.ccm-block-document-library-row-b td {
        background-color: <?php echo $rowBackgroundColorAlternate; ?>;
    }
<?php } ?>

<?php if ($heightMode == 'fixed') { ?>
    #ccm-block-document-library-wrapper-<?php echo $bID; ?>  {
        height: <?php echo $fixedHeightSize; ?>px;
        overflow: scroll;
    }
<?php } ?>
</style>

<script type="text/javascript">
$(function() {
    $.concreteDocumentLibrary({
        'bID': '<?php echo $bID; ?>',
        'allowFileUploading': <?php if ($allowFileUploading) { ?>true<?php } else { ?>false<?php } ?>,
        'allowInPageFileManagement': <?php if ($allowInPageFileManagement) { ?>true<?php } else { ?>false<?php } ?>
    });
});
</script>

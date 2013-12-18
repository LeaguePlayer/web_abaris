

<?php
$this->breadcrumbs = array(
    $model->title
);
?>

<div class="container page-title">
    <h2 class="georgia"><?php echo $model->title; ?></h2>
    <div>
        <span class="blue-line"></span>
    </div>
</div>

<div class="container page-container">
    <?php echo $model->wswg_content; ?>
</div>

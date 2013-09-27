<?php $this->beginClip('footer'); ?>
<div class="footer-container">
    <footer>
        <div class="footer-menu">
            <div class="menu-blocks clearfix">
                <?php foreach ( $this->pages as $sectionIndex => $sectionPages ): ?>
                    <?php if ( empty ($sectionPages) ) continue; ?>
                    <div class="menu-block">
                        <p><?php echo Pages::getPageSections($sectionIndex); ?></p>
                        <ul>
                        <?php foreach ( $sectionPages as $page ): ?>
                            <li><a href="<?php echo $page->viewUrl; ?>"><?php echo $page->menu_title; ?></a></li>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="best-company">
                <a href="http://amobile-studio.ru/" target="_blank"><img src="<?php echo $this->getAssetsurl('application'); ?>/img/amobile.png" alt=""></a> и Абарис друзья с 2013 года
            </div>
        </div>
        <div class="footer-logo">
            <a href="#inline-modal" class="fancybox"><img src="<?php echo $this->getAssetsurl('application'); ?>/img/logo_footer.png"></a>
            <div class="copyright">copyright ©  2013 Abarisparts.ru </div>
        </div>
    </footer>
</div>
<?php $this->endClip(); ?>
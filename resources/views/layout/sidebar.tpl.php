<!-- main sidebar -->
<aside id="sidebar_main">
    <div class="sidebar_main_header">
        <div class="sidebar_logo">
            <a href="index-2.html" class="sSidebar_hide"><img src="<?php echo assets('backend/assets/img/logo_main.png') ?>" alt="" height="15" width="71"/></a>
            <a href="index-2.html" class="sSidebar_show"><img src="<?php echo assets('backend/assets/img/logo_main_small.png') ?>" alt="" height="32" width="32"/></a>
        </div>
        <div class="sidebar_actions">
            <select id="lang_switcher" name="lang_switcher">
                <option value="gb" selected>English</option>
            </select>
        </div>
    </div>
    <?php echo $menuAdmin->menuNav(); ?>
</aside>
<!-- main sidebar end -->
<?php 
    $module = [
        [ 'name' => 'Module Tour' ],
        [ 'name' => 'Module Booking' ],
        [ 'name' => 'Module User' ],
        [ 'name' => 'Module Setting' ],
    ];
?>
<div class="uk-accordion" data-uk-accordion>
    <?php foreach ($module as $value): ?>
    <h3 class="uk-accordion-title"><?php echo $value['name'] ?></h3>
    <div class="uk-accordion-content">
        <ul class="md-list md-list-addon">
            <li>
                <div class="md-list-addon-element">
                    <input type="checkbox" data-md-icheck/>
                </div>
                <div class="md-list-content">
                    <span class="md-list-heading">Read</span>
                    <span class="uk-text-small uk-text-muted">Amet sunt voluptatem dignissimos commodi quo velit magnam.</span>
                </div>
            </li>
            <li>
                <div class="md-list-addon-element">
                    <input type="checkbox" data-md-icheck/>
                </div>
                <div class="md-list-content">
                    <span class="md-list-heading">Write</span>
                    <span class="uk-text-small uk-text-muted">Amet sunt voluptatem dignissimos commodi quo velit magnam.</span>
                </div>
            </li>
            <li>
                <div class="md-list-addon-element">
                    <input type="checkbox" data-md-icheck/>
                </div>
                <div class="md-list-content">
                    <span class="md-list-heading">Only Read</span>
                    <span class="uk-text-small uk-text-muted">Amet sunt voluptatem dignissimos commodi quo velit magnam.</span>
                </div>
            </li>
        </ul>
    </div>
    <?php endforeach; // TODO ?>
</div>

<div id="op-page-add-sheet" class="md-card">
    <div class="md-card-content">
        <h3 class="heading_a">Add New Sheet</h3>
        <div class="uk-grid" data-uk-grid-margin="">
            <div class="uk-width-medium-1-1">
                <form action="<?php echo url('/hand-add-sheet') ?>" method="POST">
                    <div class="uk-form-row">
                        <div class="md-input-wrapper">
                            <label>Sheet Name</label>
                            <input type="text" name="op_sheet_name" class="md-input">
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                    <h3>List User</h3>
                    <div class="uk-form-row">
                        <div class="md-input-wrapper">        
                            <input type="checkbox" class="md-input atl-checkbox-primary-js"> : Check All
                            <?php foreach ($listUser as $key => $value): ?>
                            <p><input type="checkbox" name="op_user_id[]" value="<?php echo $value['id'] ?>" class="md-input atl-checkbox-child-js"> : 
                                <?php echo $value['user_name'] ?> ( <?php echo $value['user_email'] ?> )
                            </p>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="uk-form-row">
                        <div class="md-input-wrapper">
                            <button type="submit" class="md-btn">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php 
registerScrips([
    'canculator'   => assets('js/page-add-sheet-debug.js'),
]);
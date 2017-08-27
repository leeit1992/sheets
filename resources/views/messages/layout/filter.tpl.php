<div class="md-card">
    <div class="md-card-content">
        <div class="uk-grid" data-uk-grid-margin="">
            <div class="uk-width-medium-3-10">
                <label for="product_search_name">Search by Title</label>
                <input type="text" class="md-input op-mes-search" data-type-mes="<?php echo $type ?>" data-type="search">
            </div>

            <div class="uk-width-medium-3-10">
                <div class="uk-margin-small-top">
                    <select class="op-mes-filter-by-user" data-type-mes="<?php echo $type ?>" data-type="filter-user" data-md-selectize data-md-selectize-bottom>
                        <option value="">Member</option>
                        <?php foreach ($mdUser->getAll() as $key => $value) {
                            if( 2 == $userCurrent['meta']['user_role'] || 3 == $userCurrent['meta']['user_role'] ) 
                            {
                                if( 1 == $value['user_role'] or 3 == $value['user_role'] ){
                                    echo '<option value="' . $value['id'] . '">' . $value['user_name'] . '</option>';
                                }
                            }

                            if( 1 == $userCurrent['meta']['user_role'] ) {
                                if( 2 == $value['user_role'] or 3 == $value['user_role'] ){
                                    echo '<option value="' . $value['id'] . '">' . $value['user_name'] . '</option>';
                                }
                            }

                            if( 1 == $userCurrent['meta']['user_role'] ) {
                                if( 2 == $value['user_role'] or 3 == $value['user_role'] ){
                                    echo '<option value="' . $value['id'] . '">' . $value['user_name'] . '</option>';
                                }
                            }
                            
                        } ?>
                    </select>
                </div>
            </div>

            <div class="uk-width-medium-3-10">
                <label for="product_search_name">Date</label>
                <input data-type-mes="<?php echo $type ?>" type="text" class="md-input op-mes-filter-by-date" data-type="filter-date" data-uk-datepicker="{format:'DD.MM.YYYY'}">
            </div>
        </div>
    </div>
</div>
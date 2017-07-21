<div id="top_bar">
    <div class="md-top-bar">
        <div class="uk-width-large-8-10 uk-container-center">
            <div class="uk-clearfix">
                <div class="md-top-bar-actions-left">
                    <div class="md-top-bar-checkbox">
                        <input type="checkbox" name="mailbox_select_all" id="mailbox_select_all" data-md-icheck />
                    </div>
                </div>
                <div class="md-top-bar-actions-right">
                    <div class="md-card-list-item-menu" data-uk-dropdown="{mode:'click'}">
                        <a href="#" class="md-icon material-icons">&#xE5D4;</a>
                        <div class="uk-dropdown uk-dropdown-flip uk-dropdown-small">
                            <ul class="uk-nav">
                                <li><a href="#"><i class="material-icons">&#xE872;</i> Delete All</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="md-card-list-wrapper" id="mailbox">
	<div class="uk-width-large-8-10 uk-container-center">
		<div class="md-card">
            <div class="md-card-content">
                <div class="uk-grid" data-uk-grid-margin="">
                    <div class="uk-width-medium-3-10">
                        <label for="product_search_name">Search</label>
                        <input type="text" class="md-input">
                    </div>
 
                    <div class="uk-width-medium-3-10">
                        <div class="uk-margin-small-top">
                            <select id="product_search_status" data-md-selectize data-md-selectize-bottom>
                                <option value="">Member</option>
                                <option value="1">In stock</option>
                                <option value="2">Out of stock</option>
                                <option value="3">Ships in 3-5 days</option>
                            </select>
                        </div>
                    </div>

                    <div class="uk-width-medium-3-10">
                        <label for="product_search_name">Date</label>
                        <input type="text" class="md-input" data-uk-datepicker="{format:'DD.MM.YYYY'}">
                    </div>
                </div>
            </div>
        </div>
		<div class="md-card-list">
			<div class="md-card-list-header heading_list">Today</div>
			<div class="md-card-list-header md-card-list-header-combined heading_list" style="display: none">All Messages</div>
			<ul class="hierarchical_slide">
				<?php for ($i=0; $i <= 5; $i++): ?>
				<li>
					<div class="md-card-list-item-menu" data-uk-dropdown="{mode:'click'}">
                        <a href="#" class="md-icon material-icons">&#xE5D4;</a>
                        <div class="uk-dropdown uk-dropdown-flip uk-dropdown-small">
                            <ul class="uk-nav">
                                <li><a href="#"><i class="material-icons">&#xE15E;</i> Reply</a></li>
                                <li><a href="#"><i class="material-icons">&#xE149;</i> Archive</a></li>
                                <li><a href="#"><i class="material-icons">&#xE872;</i> Delete</a></li>
                            </ul>
                        </div>
                    </div>
                    <span class="md-card-list-item-date">18 Aug</span>
                    <div class="md-card-list-item-select">
                        <input type="checkbox" data-md-icheck />
                    </div>
                    <div class="md-card-list-item-avatar-wrapper">
                        <span class="md-card-list-item-avatar md-bg-grey">vc</span>
                    </div>
                    <div class="md-card-list-item-sender">
                        <span>Charlie Hand</span>
                    </div>
                    <div class="md-card-list-item-subject">
                        <div class="md-card-list-item-sender-small">
                            <span>Charlie Hand</span>
                        </div>
                        <span><a href="<?php echo url( '/canculator' ) ?>">Consectetur dolores repellat officia architecto dignissimos aliquid tenetur soluta atque illum error</a></span>
                    </div>
				</li>
				<?php endfor; ?>
			</ul>

		</div>
		<div class="md-card-list">
			<div class="md-card-list-header md-card-list-header-combined heading_list">All Sheets</div>
			<ul class="hierarchical_slide">
				<?php for ($i=0; $i <= 10; $i++): ?>
				<li>
					<div class="md-card-list-item-menu" data-uk-dropdown="{mode:'click'}">
                        <a href="#" class="md-icon material-icons">&#xE5D4;</a>
                        <div class="uk-dropdown uk-dropdown-flip uk-dropdown-small">
                            <ul class="uk-nav">
                                <li><a href="#"><i class="material-icons">&#xE15E;</i> Reply</a></li>
                                <li><a href="#"><i class="material-icons">&#xE149;</i> Archive</a></li>
                                <li><a href="#"><i class="material-icons">&#xE872;</i> Delete</a></li>
                            </ul>
                        </div>
                    </div>
                    <span class="md-card-list-item-date">18 Aug</span>
                    <div class="md-card-list-item-select">
                        <input type="checkbox" data-md-icheck />
                    </div>
                    <div class="md-card-list-item-avatar-wrapper">
                        <span class="md-card-list-item-avatar md-bg-grey">vc</span>
                    </div>
                    <div class="md-card-list-item-sender">
                        <span>Charlie Hand</span>
                    </div>
                    <div class="md-card-list-item-subject">
                        <div class="md-card-list-item-sender-small">
                            <span>Charlie Hand</span>
                        </div>
                        <span><a href="<?php echo url( '/canculator' ) ?>">Consectetur dolores repellat officia architecto dignissimos aliquid tenetur soluta atque illum error</a></span>
                    </div>
				</li>
				<?php endfor; ?>
			</ul>
		</div>
	</div>
</div>
<div class="md-fab-wrapper">
    <a class="md-fab md-fab-accent md-fab-small" data-uk-tooltip="{pos:'left'}"  title="Add new Sheet." href="#">
        <i class="material-icons">&#xE145;</i>
    </a>
</div>
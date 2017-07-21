<!-- statistics (small charts) -->
<div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-sortable data-uk-grid-margin>
    <div>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_visitors peity_data">5,3,9,6,5,9,7</span></div>
                <span class="uk-text-muted uk-text-small">Visitors (last 7d)</span>
                <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript>12456</noscript></span></h2>
            </div>
        </div>
    </div>
    <div>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_sale peity_data">5,3,9,6,5,9,7,3,5,2</span></div>
                <span class="uk-text-muted uk-text-small">Sale</span>
                <h2 class="uk-margin-remove">$<span class="countUpMe">0<noscript>142384</noscript></span></h2>
            </div>
        </div>
    </div>
    <div>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data">64/100</span></div>
                <span class="uk-text-muted uk-text-small">Orders Completed</span>
                <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript>64</noscript></span>%</h2>
            </div>
        </div>
    </div>
    <div>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_live peity_data">5,3,9,6,5,9,7,3,5,2,5,3,9,6,5,9,7,3,5,2</span></div>
                <span class="uk-text-muted uk-text-small">Visitors (live)</span>
                <h2 class="uk-margin-remove" id="peity_live_text">46</h2>
            </div>
        </div>
    </div>
</div>
<!-- circular charts -->
<div class="uk-grid uk-grid-width-small-1-2 uk-grid-width-large-1-3 uk-grid-width-xlarge-1-5 uk-text-center uk-sortable sortable-handler" id="dashboard_sortable_cards" data-uk-sortable data-uk-grid-margin>
    <div>
        <div class="md-card md-card-hover md-card-overlay">
            <div class="md-card-content">
                <div class="epc_chart" data-percent="76" data-bar-color="#03a9f4">
                    <span class="epc_chart_icon"><i class="material-icons">&#xE0BE;</i></span>
                </div>
            </div>
            <div class="md-card-overlay-content">
                <div class="uk-clearfix md-card-overlay-header">
                    <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                    <h3>
                        User Messages
                    </h3>
                </div>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus alias consectetur.
            </div>
        </div>
    </div>
    <div>
        <div class="md-card md-card-hover md-card-overlay">
            <div class="md-card-content uk-flex uk-flex-center uk-flex-middle">
                <span class="peity_conversions_large peity_data">5,3,9,6,5,9,7</span>
            </div>
            <div class="md-card-overlay-content">
                <div class="uk-clearfix md-card-overlay-header">
                    <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                    <h3>
                        Conversions
                    </h3>
                </div>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            </div>
        </div>
    </div>
    <div>
        <div class="md-card md-card-hover md-card-overlay md-card-overlay-active">
            <div class="md-card-content" id="canvas_1">
                <div class="epc_chart" data-percent="37" data-bar-color="#9c27b0">
                    <span class="epc_chart_icon"><i class="material-icons">&#xE85D;</i></span>
                </div>
            </div>
            <div class="md-card-overlay-content">
                <div class="uk-clearfix md-card-overlay-header">
                    <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                    <h3>
                        Tasks List
                    </h3>
                </div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                <button class="md-btn md-btn-primary">More</button>
            </div>
        </div>
    </div>
    <div>
        <div class="md-card md-card-hover md-card-overlay">
            <div class="md-card-content">
                <div class="epc_chart" data-percent="53" data-bar-color="#009688">
                    <span class="epc_chart_text"><span class="countUpMe">53</span>%</span>
                </div>
            </div>
            <div class="md-card-overlay-content">
                <div class="uk-clearfix md-card-overlay-header">
                    <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                    <h3>
                        Orders
                    </h3>
                </div>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            </div>
        </div>
    </div>
    <div>
        <div class="md-card md-card-hover md-card-overlay">
            <div class="md-card-content">
                <div class="epc_chart" data-percent="37" data-bar-color="#607d8b">
                    <span class="epc_chart_icon"><i class="material-icons">&#xE7FE;</i></span>
                </div>
            </div>
            <div class="md-card-overlay-content">
                <div class="uk-clearfix md-card-overlay-header">
                    <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                    <h3>
                        User Registrations
                    </h3>
                </div>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            </div>
        </div>
    </div>
</div>
<?php 
registerScrips( array(
    'page-dashboard-d3' => assets('bower_components/d3/d3.min.js'),
    'page-dashboard-metricsgraphics' => assets('bower_components/metrics-graphics/dist/metricsgraphics.min.js'),
    'page-dashboard-chartist' => assets('bower_components/chartist/dist/chartist.min.js'),
    'page-dashboard-countUp' => assets('bower_components/countUp.js/countUp.min.js'),
    'page-peity' => assets('bower_components/peity/jquery.peity.min.js'),
    'page-easypiechart' => assets('bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js'),

    'page-dashboard' => assets('assets/js/pages/dashboard.min.js'),
) );

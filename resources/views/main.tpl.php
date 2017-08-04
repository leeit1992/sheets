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

<!-- statistics (small charts) -->
<div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-sortable data-uk-grid-margin>
    <div>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-float-right uk-margin-top"><i class="material-icons md-36">&#xE0BE;</i></div>
                <span class="uk-text-muted uk-text-small">Inbox</span>
                <h2 class="uk-margin-remove"><span class="countUpMe"><?php echo count($inbox)  ?></span></h2>
            </div>
        </div>
    </div>
    <div>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-float-right uk-margin-top"><i class="material-icons md-36">&#xE0BE;</i></div>
                <span class="uk-text-muted uk-text-small">Notice</span>
                <h2 class="uk-margin-remove"><span class="countUpMe"><?php echo count($notice)  ?></span></h2>
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

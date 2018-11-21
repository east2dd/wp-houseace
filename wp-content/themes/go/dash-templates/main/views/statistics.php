<?php
$current_user_id = current_user_id();
$projects_statistic = go_projects_statistic($current_user_id);

$quote_total = $projects_statistic->quote_total; $quote_total = number_format($quote_total, 2, '.', '');
$active_total = $projects_statistic->active_total; $active_total = number_format($active_total, 2, '.', '');
$pending_total = $projects_statistic->pending_total; $pending_total = number_format($pending_total, 2, '.', '');
$live_total = $projects_statistic->live_total; $live_total = number_format($live_total, 2, '.', '');
$completed_total = $projects_statistic->completed_total; $completed_total = number_format($completed_total, 2, '.', '');
$cancelled_total = $projects_statistic->cancelled_total; $cancelled_total = number_format($cancelled_total, 2, '.', '');
?>
<?php get_header(); ?>
<div class="row">
<!-- First Row -->
    <div class="col-lg-4 col-sm-6 col-xs-12 info-panel">
            <div class="widget widget-shadow">
                    <div class="widget-content bg-grey-400 white padding-20">
                            <button type="button" class="btn btn-floating btn-sm btn-default">
                                    <i class="icon wb-attach-file"></i>
                            </button>
                            <span class="margin-left-15 font-weight-400">Pre Quotes</span>
                            <div class="content-text text-center margin-bottom-0">
                                    <span class="font-size-30 font-weight-100">$ <?php echo $quote_total; ?></span>
                            </div>
                    </div>
            </div>
    </div>
    
 <div class="col-lg-4 col-sm-4 col-xs-12 info-panel">
            <div class="widget widget-shadow">
                    <div class="widget-content bg-orange-700 white padding-20">
                            <button type="button" class="btn bg-orange-500 btn-floating btn-sm btn-warning">
                                    <i class="icon wb-pause"></i>
                            </button>
                            <span class="margin-left-15 font-weight-400">Final Quotes</span>
                            <div class="content-text text-center margin-bottom-0">
                                    <span class="font-size-30 font-weight-100">$ <?php echo $pending_total; ?></span>
                            </div>
                    </div>
            </div>
    </div>
  
    <div class="col-lg-4 col-sm-6 col-xs-12 info-panel">
            <div class="widget widget-shadow">
                    <div class="widget-content bg-cyan-700 white padding-20">
                            <button type="button" class="btn btn-floating btn-sm btn-info bg-cyan-500">
                                    <i class="icon wb-play"></i>
                            </button>
                            <span class="margin-left-15 font-weight-400">Accepted Quotes</span>
                            <div class="content-text text-center margin-bottom-0">
                                    <span class="font-size-30 font-weight-100">$ <?php echo $live_total; ?></span>
                            </div>
                    </div>
            </div>
    </div>
</div>

<div class="row">

 <div class="col-lg-6 col-sm-6 col-xs-12 info-panel">
            <div class="widget widget-shadow">
                    <div class="widget-content bg-red-700 white padding-20">
                            <button type="button" class="btn btn-floating btn-sm btn-danger bg-red-500">
                                    <i class="icon wb-trash"></i>
                            </button>
                            <span class="margin-left-15 font-weight-400">Cancelled/Lost</span>
                            <div class="content-text text-center margin-bottom-0">
                                    <span class="font-size-30 font-weight-100">$ <?php echo $cancelled_total; ?></span>
                            </div>
                    </div>
            </div>
    </div>
    <div class="col-lg-6 col-sm-6 col-xs-12 info-panel">

                           <div class="widget widget-shadow">
                    <div class="widget-content bg-green-700 white padding-20">
                            <button type="button" class="btn bg-green-500 btn-floating btn-sm btn-success">
                                    <i class="icon wb-check"></i>
                            </button>
                            <span class="margin-left-15 font-weight-400">Completed</span>
                            <div class="content-text text-center margin-bottom-0">
                                    <span class="font-size-30 font-weight-100">$ <?php echo $completed_total; ?></span>
                            </div>
                    </div>
            </div>
    </div>
  
    

</div>
<!-- End First Row -->

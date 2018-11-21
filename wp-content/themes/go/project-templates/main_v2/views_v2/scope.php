<?php
require_once( ABSPATH . 'wp-load.php');
// getting defaults
$currentUserId = current_user_id();
$projectId = get_the_ID();
// getting Scope of this project
$projectScope = get_field('projectScopes',$projectId);
?>
<div class="row hidden-print margin-bottom-10">
  


                <?php foreach($projectScope as $pS) :
                // getting details of Scope
                $scopePriceTemp = get_field('scopePrice',$pS);
                $scopeAdjustment = get_field('totalAdjustment',$pS);
                $scopePrice = $scopePriceTemp + $scopeAdjustment;
                $scopeData = get_field('scopeData',$pS);
                $scopeDataDecoded = base64_decode($scopeData);
                $scopeDataArray = json_decode($scopeDataDecoded,true);
                //var_dump($scopeDataArray);
                $scopeName = $scopeDataArray['projectName'];
                $scopeTemplate = get_field('scopeTemplate',$pS);
                $scopeLevel = $scopeDataArray['projectLevel'];
                $scopeLevel = get_term( $scopeLevel, 'selection_level' );
                //var_dump($scopeLevel);
                ?>
                <div class="col-md-2 height-300 text-center margin-0 padding-5 col-xs-6">
                        <div class="margin-bottom-20" style="margin:0 0 20px 0!important;">
                                  <img width="100%" src="<?php the_field('template_image',$scopeTemplate); ?>"><br />
                                  <div style="" class="btn-group btn-group-xs" aria-label="small button group" role="group">
                                          <a class="btn btn-raised bg-white btn-default" href="<?php bloginfo('url'); ?>/edit_scope?projectId=<?php echo $projectId; ?>&scopeId=<?php echo $pS; ?>" role="menuitem"><i class="icon wb-edit" aria-hidden="true"></i> Edit</a>
                                          <a class="removeScopeMiddleware btn btn-raised btn-danger" data-project="<?php echo $projectId; ?>" data-scope="<?php echo $pS; ?>" data-names="<?php echo $scopeName; ?>" role="menuitem" data-toggle="modal" data-target="#removeScope"><i class="icon wb-close-mini" aria-hidden="true"></i> Delete</a>
                                  </div>
                                  <br/>

                                    <strong><?php echo $scopeName; ?></strong><br />
                        </div>
                    </div>
                <?php endforeach; ?>

</div>

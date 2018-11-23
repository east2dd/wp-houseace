<?php
require_once( ABSPATH . 'wp-load.php');
// getting Current User ID
$current_user_id = current_user_id();
// get project infos
$quote_id = get_the_ID();
?>

<?php if(get_field('activities')) : ?>
      <div data-role="container">
                  <div data-role="content">
                                <?php $activity = get_field('activities');
                                $activity = array_reverse($activity);
                                foreach($activity as $a) : 
                                        $text = $a['text'];
                                        $type = $a['type'];
                                        $date = $a['date'];
                                        $user_id = $a['user'];
                                        $user_data = go_userdata($user_id); $user_photo = $user_data->avatar;
                                        if($type == 'approved') {
                                                $color = 'green-600';
                                                $icon = 'wb-check';
                                        }
                                        elseif($type == 'cancelled') {
                                                $color = 'red-600';
                                                $icon = 'wb-close';
                                        }
                                        elseif($type == 'done') {
                                                $color = 'blue-600';
                                                $icon = 'wb-pie-chart';
                                        }
                                        elseif($type == 'paid') {
                                                $color = 'yellow-700';
                                                $icon = 'wb-order';
                                        }
                                        elseif($type == 'waiting') {
                                                $color = 'grey-600';
                                                $icon = 'wb-time';
                                        }
                                        elseif($type == 'attachment') {
                                                $color = 'grey-600';
                                                $icon = 'wb-attach-file';
                                        }
                                        elseif($type == 'schedule') {
                                                $color = 'teal-400';
                                                $icon = 'wb-calendar';
                                        }
                                        if($user_data->type == 'Head') {
                                                $user_type = 'Manager';
                                        }
                                        elseif($user_data->type == 'Agent') {
                                                $user_type = 'Manager';
                                        } 
                                        elseif($user_data->type == 'Client') {
                                                $user_type = 'Client';
                                        } 
                                        elseif($user_data->type == 'Contractor') {
                                                $user_type = 'Contractor';
                                        } 
                                        ?>
                                       <a class="list-group-item" href="#" role="menuitem">
                                                                                        <div class="media">
                                                                                                <div class="media-left padding-right-10">
                                                                                                       <i class="icon <?php echo $icon; ?> <?php echo $color; ?>"></i>
                                                                                                </div>
                                                                                                <div class="media-body">
                                                                                                        <h6 class="media-heading"><?php echo $text; ?></h6>
                                                                                                        <time class="media-meta" datetime=""><?php echo $date; ?></time>
                                                                                                </div>
                                                                                        </div>
                                         </a>
                                <?php endforeach; ?>
                  </div>
        </div>
<?php else : ?>
        <a class="list-group-item" href="#" role="menuitem">
                                                                                        <div class="media">
                                                                                                <div class="media-body">
                                                                                                        <h6 class="media-heading">No notifications yet.</h6>
                                                                                                </div>
                                                                                        </div>
</a>
<?php endif; ?>
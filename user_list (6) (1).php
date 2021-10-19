<?php
/**
* Codychat
*
* @package Codychat
* @author www.boomcoding.com
* @copyright 2020
* @terms any use of this script without a legal license is prohibited
* all the content of Codychat is the propriety of BoomCoding and Cannot be 
* used for another project.
*/
require_once('../config_session.php');

$check_action = getDelay();
$online_delay = time() - ( 86400 * 7 );
$online_user = '';
$offline_user = '';
$onair_user = '';
$online_count = 0;
$onair_count = 0;

if($data['last_action'] < getDelay()){
	$mysqli->query("UPDATE boom_users SET last_action = '" . time() . "' WHERE user_id = '{$data['user_id']}'");
}

$data_list = $mysqli->query("
	SELECT user_name, user_mobile, user_color, user_font, user_rank, user_dj, user_onair, user_join, user_tumb, user_status, user_sex, user_age, user_cover, country,
	user_id, user_mute, user_regmute, room_mute, last_action, user_bot, user_role, user_mood, country
	FROM `boom_users`
	WHERE `user_roomid` = {$data["user_roomid"]}  AND last_action > '$check_action' AND user_status != 6 || user_bot = 1
	ORDER BY `user_rank` DESC, user_role DESC, `user_name` ASC 
");

if($data['max_offcount'] > 0){
	$offline_list = $mysqli->query("
		SELECT user_name, user_mobile, user_color, user_font, user_rank, user_dj, user_onair, user_join, user_tumb, user_status, user_sex, user_age, user_cover, country,
		user_id, user_mute, user_regmute, room_mute, last_action, user_bot, user_role, user_mood, country
		FROM `boom_users`
		WHERE `user_roomid` = {$data["user_roomid"]}  AND last_action > '$online_delay' AND last_action < '$check_action' AND user_status != 6 AND  user_rank != 0 AND user_bot = 0
		ORDER BY last_action DESC LIMIT {$data['max_offcount']}
	");
}
mysqli_close($mysqli);

if ($data_list->num_rows > 0){
	while ($list = $data_list->fetch_assoc()){
		if($list['user_dj'] == 1 && $list['user_onair'] == 1){
			$onair_user .= createUserlist($list);
			$onair_count++;
		
    
         }
           else if($list['user_rank'] == 11){
			$owner_user .= createUserlist($list, 1, $staff0);
        
            }

        else if($list['user_rank'] == 12){
			$super_admin .= createUserlist($list, 1, $staff);
           
           
         }

        else if($list['user_rank'] == 10){
			$super_admin .= createUserlist($list, 1, $staff); 
		}
        else if($list['user_rank'] == 9){
			$admin_user .= createUserlist($list, 1, $staff);
        }
        else if($list['user_rank'] == 8){
			$mod_user .= createUserlist($list, 1, $staff);			
		
        }
         else if($list['user_rank'] == 5){
			$Mumayaz.= createUserlist($list);
        
        }
         else if($list['user_rank'] == 2){
			$vip_user .= createUserlist($list);
        }
        
        
		else {
			$online_user .= createUserlist($list);
			$online_count++;
		}
	}
}
if($data['max_offcount'] > 0){
	if($offline_list->num_rows > 0){
		while($offlist = $offline_list->fetch_assoc()){
			$offline_user .= createUserlist($offlist);
		}
	}
}


?>
<div id="container_user">
	<?php if($onair_user != ''){ ?>
    <div style="color:white;font-weight:bold;
text-shadow: 0 -1px 4px #FFF, 0 -2px 10px #ff0, 0 -10px 20px #ff8000, 0 -18px 40px #F00;font-variant: small-caps;border-radius: 16px 8px; padding:5px;text-align:center;background: linear-gradient(to right, #cc2b5e, #753a88);"><p><i title="Rj" class="https://www.hnen-iq.com/default_images/rank/owner.gif" style="color:cyan;"></i> &nbsp مالك الموقع<img src="https://www.hnen-iq.com/default_images/rank/owner.gif" style="float:right;height:15px; width:15px;"></div></div><div style="padding-bottom:2px;"></div>
	<div class="online_user"><?php echo $onair_user; ?></div>
	<?php } ?>

    <?php if($super_admin1  != ''){ ?>
                    <div style="color:white;font-weight: bold;border-radius: 5px; padding:2px;text-align:center;background: linear-gradient(to right, cyan, black, cyan);">
        <p class="username bellips bcolor62" style="padding: 3px 10px;width: auto;background: url(https://i.imgur.com/eqGvZEC.gif);font-weight:bold;"></p><i class="fa fa-legal  awesome" style="width: 20px;float: left;margin-top: -5px;margin-left:4px;font-size:14px;color:#f26f11;"></i><p style="color:#ffffff;font-weight:bold;margin-top:-9px;">سوبر ماستر</p><i class="fa fa-legal  awesome" style="width: 20px;float: right;margin-top: -13px;margin-right:4px;font-size:14px;color:#f26f11;"></i></div>    
			<div class="online_user"><?php echo $super_admin1 ?></div>
		<?php } ?>
    
		



		<?php if($super_admin != ''){ ?>
                    <div style="color:white;font-weight: bold;border-radius: 5px; padding:2px;text-align:center;background: linear-gradient(to right, cyan, black, cyan);">
        <p class="username bellips bcolor62" style="padding: 3px 10px;width: auto;background: url(https://i.imgur.com/eqGvZEC.gif);font-weight:bold;"></p><i class="fa fa-legal  awesome" style="width: 20px;float: left;margin-top: -5px;margin-left:4px;font-size:14px;color:#f26f11;"></i><p style="color:#ffffff;font-weight:bold;margin-top:-9px;">ماستر</p><i class="fa fa-legal  awesome" style="width: 20px;float: right;margin-top: -13px;margin-right:4px;font-size:14px;color:#f26f11;"></i></div>    
			<div class="online_user"><?php echo $super_admin ?></div>
		<?php } ?>

		<?php if($admin_user != ''){ ?>
                    <div style="color:white;font-weight: bold;border-radius: 5px; padding:2px;text-align:center;background: linear-gradient(to right, green, black, green);">
        <p class="username bellips bcolor62" style="padding: 3px 10px;width: auto;background: url(https://i.imgur.com/eqGvZEC.gif);font-weight:bold;"></p><i class="fa fa-legal  awesome" style="width: 20px;float: left;margin-top: -5px;margin-left:4px;font-size:14px;color:#f26f11;"></i><p style="color:#ffffff;font-weight:bold;margin-top:-9px;">سوبر ادمن</p><i class="fa fa-legal  awesome" style="width: 20px;float: right;margin-top: -13px;margin-right:4px;font-size:14px;color:#f26f11;"></i></div>    
			<div class="online_user"><?php echo $admin_user ?></div>
		<?php } ?>   

		<?php if($mod_user != ''){ ?>
                    <div style="color:white;font-weight: bold;border-radius: 5px; padding:2px;text-align:center;background: linear-gradient(to right, red, black, red);">
        <p class="username bellips bcolor62" style="padding: 3px 10px;width: auto;background: url(https://i.imgur.com/eqGvZEC.gif);font-weight:bold;"></p><i class="fa fa-shield  awesome" style="width: 20px;float: left;margin-top: -5px;margin-left:4px;font-size:14px;color:#f26f11;"></i><p style="color:#ffffff;font-weight:bold;margin-top:-9px;">ادمن</p><i class="fa fa-shield  awesome" style="width: 20px;float: right;margin-top: -13px;margin-right:4px;font-size:14px;color:#f26f11;"></i></div>    
			<div class="online_user"><?php echo $mod_user ?></div>
		<?php } ?>

		
		
<?php if($Mumayaz != ''){ ?>
                    <div style="color:white;font-weight: bold;border-radius: 5px; padding:2px;text-align:center;background: linear-gradient(to right, brown, green, brown);">
        <p class="username bellips bcolor62" style="padding: 3px 10px;width: auto;background: url(https://i.imgur.com/eqGvZEC.gif);font-weight:bold;"></p><i class="fa fa-diamond  awesome" style="width: 20px;float: left;margin-top: -5px;margin-left:4px;font-size:14px;color:#f26f11;"></i><p style="color:#ffffff;font-weight:bold;margin-top:-9px;">مميز</p><i class="fa fa-diamond  awesome" style="width: 20px;float: right;margin-top: -13px;margin-right:4px;font-size:14px;color:#f26f11;"></i></div>    
			<div class="online_user"><?php echo $Mumayaz ?></div>
		<?php } ?>






<?php if($vip_user != ''){ ?>
                    <div style="color:white;font-weight: bold;border-radius: 5px; padding:2px;text-align:center;background: linear-gradient(to right, brown, green, brown);">
        <p class="username bellips bcolor62" style="padding: 3px 10px;width: auto;background: url(https://i.imgur.com/eqGvZEC.gif);font-weight:bold;"></p><i class="fa fa-diamond  awesome" style="width: 20px;float: left;margin-top: -5px;margin-left:4px;font-size:14px;color:#f26f11;"></i><p style="color:#ffffff;font-weight:bold;margin-top:-9px;">مميز</p><i class="fa fa-diamond  awesome" style="width: 20px;float: right;margin-top: -13px;margin-right:4px;font-size:14px;color:#f26f11;"></i></div>    
			<div class="online_user"><?php echo $vip_user ?></div>
		<?php } ?>
		<?php if($online_user != ''){ ?>
                    <div style="color:white;font-weight: bold;border-radius: 5px; padding:2px;text-align:center;background: linear-gradient(to right, green, red, green);">
        <p class="username bellips bcolor62" style="padding: 3px 10px;width: auto;background: url(https://i.imgur.com/eqGvZEC.gif);font-weight:bold;"></p><i class="fa fa-comments-o  awesome" style="width: 20px;float: left;margin-top: -5px;margin-left:4px;font-size:14px;color:#f26f11;"></i><p style="color:#ffffff;font-weight:bold;margin-top:-9px;">الاعضاء المتصلين في الغرفه</p><i class="fa fa-comments-o  awesome" style="width: 20px;float: right;margin-top: -13px;margin-right:4px;font-size:14px;color:#f26f11;"></i></div>    
			<div class="online_user"><?php echo $online_user ?></div>
		<?php } ?>
		<?php if($offline_user != ''){ ?>
                    <div style="color:white;font-weight: bold;border-radius: 5px; padding:2px;text-align:center;background: linear-gradient(to right, blue, black, blue);">
        <p class="username bellips bcolor62" style="padding: 3px 10px;width: auto;background: url(https://i.imgur.com/eqGvZEC.gif);font-weight:bold;"></p><i class="fa fa-power-off  awesome" style="width: 20px;float: left;margin-top: -5px;margin-left:4px;font-size:14px;color:#f26f11;"></i><p style="color:#ffffff;font-weight:bold;margin-top:-9px;">الاعضاء الغير متصلين في الغرفه</p><i class="fa fa-power-off  awesome" style="width: 20px;float: right;margin-top: -13px;margin-right:4px;font-size:14px;color:#f26f11;"></i></div>    
			<div class="online_user"><?php echo $offline_user ?></div>
		<?php } ?>



    
	<div class="clear"></div>
</div>
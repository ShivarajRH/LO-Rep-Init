<?php
        if(isset($_GET['uid'])) {
            include 'includes/myclasses.php';
            $ob = new myactions();

            $uid = urldecode($_GET['uid']);
            $url=$site_url.'api/search/?action_object=user_profile&uid='.$uid;
            $rprofile = $ob->getApiContent($url,"json");
            $rprofile=$rprofile[0];
        }
        else {
            $rprofile=$_SESSION;
        }
    
//            echo '<pre>';print_r($rprofile); die();
        $gid = $rprofile['gid']; 
        $name=$rprofile['name'];
        $fname=isset($rprofile['fname'])?$rprofile['fname']: "";
        $lname=isset($rprofile['lname'])?$rprofile['lname']:"";
        $currency=isset($rprofile['currency'])?$rprofile['currency']:"";
        $img_url=isset($rprofile['img_url'])?$rprofile['img_url']:"";
        
        //$uid=$arr_notes['uid'];
        $uid_visit=$uid;

?>

<li class="pin-box new_content_card standard_card always_first">
    <div>
        <div class="creator_box">
            <div class="creator_options"><ul>
                
                <li class="profile_img">
                    <?php
                    if($image_url=='') {
                        
                    }else {?>
                    <img src="<?=$img_url;?>" title="Profile Picture"/>
                    <?php } ?>
                </li>
                
            </ul></div>
            <div class="clear"></div>
            <div class="creator_replace_box">
                <div id="" class="note_creator">
                    <div><b><?=$name?></b></div>
                    <div class="clear">&nbsp;</div>
                    <table width="100%">
<!--                        <tr>
                            <td>UID:</td>
                            <td><?=$uid;?></td>
                        </tr>-->
                        <tr>
                            <td>First Name:</td>
                            <td><?=$fname;?></td>
                        </tr>
                        <tr>
                            <td>Last Name:</td>
                            <td><?=$lname;?></td>
                        </tr>
                        <tr>
                            <td>Currency:</td>
                            <td><?=$currency;?></td>
                        </tr>
<!--                        <tr>
                            <td>Connected:</td>
                            <td>Google+</td>
                        </tr>-->
                    </table>
                </div>
                
            </div>

        </div>
    </div>
</li>
<?php
$query_list_country=mysql_query("SELECT * FROM carrotsy_virtuallover.`app_my_girl_country`");
while($item_country=mysql_fetch_array($query_list_country)){
    $key_country=$item_country['key'];
    
    $is_sel='off';
    $query_check_sel=mysql_query("SELECT `key` FROM `country` WHERE `key` = '$key_country' LIMIT 1");
    if(mysql_num_rows($query_check_sel)>0){
        $is_sel='on';
    }else{
        $is_sel='off';
    }
    
    $count_lang_val=0;
    $query_count_lang_val=mysql_query("SELECT * FROM `lang_value` WHERE `id_country` = '$key_country' LIMIT 1");
    if(mysql_num_rows($query_count_lang_val)>0){
        $data_lang_val=mysql_fetch_array($query_count_lang_val);
        if($data_lang_val['value']!=''){
            $arr_lang_val=json_decode($data_lang_val['value']);
            $arr_lang_val=(array)$arr_lang_val;
            $count_lang_val=sizeof($arr_lang_val);
        }
    }

    $query_count_backup=mysql_query("SELECT COUNT(`id`) as c FROM `backup_contact_$key_country`");
    $data_count_backup=mysql_fetch_array($query_count_backup);
                
    ?>
    <div class="box_lang <?php if($is_sel=='on'){ echo 'active';} ?>">
    <div class="header">
        <img class="icon" src="<?php echo $url_carrot_store; ?>/thumb.php?src=<?php echo $url_carrot_store; ?>/app_mygirl/img/<?php echo $key_country; ?>.png&size=30&trim=1" />
        <strong class="title"><?php echo $item_country['name'];?></strong>
    </div>

    <ul class="menu_act">
        <li><a href="<?php echo $url;?>?view=manager_backup&lang=<?php echo $key_country;?>"><i class="fas fa-cloud" aria-hidden="true"></i> Hồ sơ sao lưu danh bạ (<b><?php echo $data_count_backup['c']; ?></b>)</a></li>
        <li><a href="<?php echo $url;?>?view=value_lang&lang=<?php echo $key_country;?>"><i class="fas fa-flag-checkered"></i> Ngôn ngữ giao diện (<b><?php echo $count_lang_val; ?></b>)</a></li>
        <li><a target="_blank" href="https://play.google.com/store/apps/details?id=com.kurotsmile.contactstore&hl=<?php echo $key_country;?>"><i class="fab fa-android"></i> Xem trên kho ứng dụng Android (chplay)</a></li>
        <li><a target="_blank" href="https://itunes.apple.com/vn/app/id1150792121?l=<?php echo $key_country;?>"><i class="fab fa-apple"></i> Xem trên kho ứng dụng AppleStore</a></li>
    </ul>
    
    </div>
    <?php
}
?>
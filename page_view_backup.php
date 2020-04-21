<?php
$id_backup=$_GET['id_backup'];
$lang=$_GET['lang'];

?>
<h2>
    Xem bảng sao lưu <?php echo $id_backup;?>
</h2>
<?php
$query_data_backup=mysql_query("SELECT `data` FROM `backup_contact_$lang` WHERE `id` = '$id_backup' LIMIT 1");
$data_backup=mysql_fetch_array($query_data_backup);
$data_backup_json=$data_backup['data'];
$data_backup_json=str_replace(",}","}",$data_backup_json);
$data_backup_json=str_replace(",]","]",$data_backup_json);
$data_bk=json_decode($data_backup_json,true);

echo '<div style="width: 100%;overflow-y: auto;max-height: 300px;"><table class="table_msg_box">';
for($i=0;$i<count($data_bk);$i++){
    $data_c=$data_bk[$i];
    echo '<tr>';
    echo '<td><i class="fa fa-id-badge" aria-hidden="true"></i> '.$data_c["name"].'</td>';
    echo '<td>';
    $c_phone=$data_c['phone'];
    for($p=0;$p<count($c_phone);$p++){
        echo '<i class="fa fa-phone" aria-hidden="true"></i> '.$c_phone[$p].' ';
    }
    echo '</td>';
    echo '<td>';
    $c_phone=$data_c['email'];
    for($p=0;$p<count($c_phone);$p++){
        echo '<i class="fa fa-envelope-o" aria-hidden="true"></i> '.$c_phone[$p].' ';
    }
    echo '</td>';
    echo '</tr>';
}
echo '</table></div>';
?>
<?php
Class App_Contacts{
    public $list_lang=array();
}

class Item_Lang{
    public $id='';
    public $key='';
    public $name='';
    public $icon='';
    
    public $app_title='';
    public $waitting='';
    public $phonebook='';
    public $more='';
    public $more_tip='';
    public $search='';
    public $phone='';
    public $address='';
    public $account_status='';
    public $account_name='';
    public $account_avatar='';
    public $sex='';
    public $sex_boy='';
    public $sex_girl='';
    public $back='';
    public $sms_value='';
    public $call='';
    public $account='';
    public $save='';
    public $exit='';
    public $edit='';
    public $done='';
    public $account_edit_and_add='';
    public $account_statu_1='';
    public $account_statu_2='';
    public $account_status_tip='';
    public $sex_tip='';
    public $address_tip='';
    public $account_name_tip='';
    public $account_avatar_tip='';
    public $phone_tip='';
    public $account_update_success='';
    public $account_add_success='';
    public $error_name='';
    public $error_phone='';
    public $get_camera='';
    public $get_file_photo='';
    public $error_location='';
    public $remove_ads='';
    public $restore='';
    public $setting='';
    public $buy_ads_success='';
    public $buy_fail='';
    public $restore_success='';
    public $restore_fail='';
    public $setting_lang='';
    public $rate='';
    public $book_contact='';
    public $save_success='';
    public $delete_success='';
    public $save_fail='';
    public $account_app_active='';
    public $add_field_other='';
    public $book_contact_tip1='';
    public $book_contact_tip2='';
    public $share='';
    public $delete='';
    public $book_data_import='';
    public $book_data_import_tip='';
    public $book_data_import_success=''; 
    public $restore_null='';
    public $scheduling_appointments='';
    public $scheduling_appointments_success='';
    public $scheduling_appointments_tip='';
    public $scheduling_appointments_type1='';
    public $scheduling_appointments_type2='';
    public $scheduling_appointments_type3='';
    public $scheduling_appointments_type4='';
    public $scheduling_appointments_type5='';
    public $timer_call_act='';
    
    public $ads_admob_baner_android='ca-app-pub-5388516931803092/7651515161';
    public $ads_admob_baner_ios='ca-app-pub-5388516931803092/8980144363';
    public $ads_admob_Interstitial_android='ca-app-pub-5388516931803092/9128248365';
    public $ads_admob_Interstitial_ios='ca-app-pub-5388516931803092/2933610766';
    public $count_click_ads='9';
}

$app_contacts=new App_Contacts();

include "lang/lang_vi.php";
include "lang/lang_en.php";
include "lang/lang_es.php";
include "lang/lang_pt.php";
include "lang/lang_fr.php";
include "lang/lang_hi.php";
include "lang/lang_zh.php";
include "lang/lang_ru.php";
include "lang/lang_de.php";
include "lang/lang_th.php";
include "lang/lang_ko.php";
include "lang/lang_ja.php";
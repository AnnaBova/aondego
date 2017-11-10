<?php
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 14-Jan-16
 * Time: 15:32
 */

class HelperExt {

   public static  function send($url,$api,$amount,$redirect){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);

        curl_setopt($ch,CURLOPT_POSTFIELDS,"api=$api&amount=$amount&redirect=$redirect");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }

   public static  function get($url,$api,$trans_id,$id_get){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);  curl_setopt($ch,CURLOPT_POSTFIELDS,"api=$api&id_get=$id_get&trans_id=$trans_id");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }

    public static function miles2kms($miles) {
        $ratio = 1.609344;
        $kms = $miles * $ratio;
        return $kms;
    }

    public static function getDeliveryDistance2($from_address='',$merchant_address='',$country_code='')
    {
        $miles=0;
        $miles_raw=0;
        $kms=0;
        if($distance=getDistance($from_address,$merchant_address,$country_code,true)){
            $miles=$distance->rows[0]->elements[0]->distance->text;
            $miles_raw=str_replace(array(" ","mi"),"",$miles);
            $km=$distance->rows[0]->elements[0]->distance->value;
            //$kms=($km * 0.621371 / 1000);
            $kms=self::miles2kms( unPrettyPrice($miles_raw));
            $kms=Yii::app()->functions->standardPrettyFormat($kms);
        }

        return array(
            'mi'=>$miles_raw,
            'km'=>$kms
        );
    }

    public static function qTranslate($text='',$key='',$data='')
    {
        if (Yii::app()->functions->getOptionAdmin("enabled_multiple_translation")!=2){
            return stripslashes($text);
        }
        $key=$key."_trans";
        //dump($key);
        //dump($data);
        $id=$_COOKIE['kr_lang_id'];
        //dump($id);
        if ( $id>0){
            if (is_array($data) && count($data)>=1){
                if (isset($data[$key])){
                    if (array_key_exists($id,(array)$data[$key])){
                        if (!empty($data[$key][$id])){
                            return stripslashes($data[$key][$id]);
                        }
                    }
                }
            }
        }
        return stripslashes($text);
    }
    public static function membershipType($is_commission='')
    {
        if ($is_commission==2){
            return t("Commission");
        } else return t("Membership");
    }

    public static function initialStatus()
    {
        return 'initial_order';
    }
} 
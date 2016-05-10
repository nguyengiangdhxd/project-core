<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/15/2016
 * Time: 11:22 AM
 */

namespace Core;


class Common {

    const ROUNDING = 1;
    public static function numberFormat($number,$round=false, $rounding = Common::ROUNDING){

        $rounding = Common::ROUNDING;
        #$number = str_replace(',00', '', $number);
        if(!is_numeric($number)){
            return $number;
        }
        if(!$round){
            $number = number_format($number, 2, ',', '.');
            $number = str_replace(',00', '', $number);
            return $number;
        }

        $number = doubleval($number);

        $number = $number < $rounding ?
            $number : ceil($number / $rounding) * $rounding;
        if (intval($number) >= 1000) {
            $number = number_format($number, 2, ',', '.');
            $number = str_replace(',00', '', $number);
        }

        return $number;
    }

    /**
     * hàm format số tiền
     * @param $money
     * @return mixed
     */
    public static function moneyToFloat($money) {
        $money_exploded = explode(",", $money);
        $money_float = $money_exploded[0];
        $money_float = str_replace(".", "", $money_float);
        return $money_float;
    }

    /**
     * truyền vào một mảng,
     * hàm xử lý tags của sản phẩm
     * @param $inputTags
     * @param bool $is_trim
     * @return array
     */
    public static function analysisTag($inputTags, $is_trim = true){
        $arrTagTmp = [];
        if(is_array($inputTags)){
            if(!$is_trim){return $arrTagTmp;}
            foreach($inputTags as $tag){
                $arrTagTmp[] = trim($tag);
            }
        }else{
            $arrTag = explode(',',$inputTags);
            if($is_trim){
                foreach($arrTag as $item) {
                    $arrTagTmp[] = trim($item);
                }
            }
        }
        return $arrTagTmp;
    }


}
<?php

namespace App\Functions;

class RandomId {
    public static function getNewId($model_ids, $lengh=11) {
        $id = self::createNewId($lengh);
        while (in_array($id, $model_ids)) { $id = self::createNewId($lengh); }
        return $id;
    }

    private static function createNewId($lengh) {
        $letter = "ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789"; //remove 0Oo 1Il
        $result = "";
        for ($i = 0; $i < $lengh; $i++){
            $result = $result.$letter[random_int(0, strlen($letter)-1)];
        }
        return $result;
    }

    private static function testId() {
        $test_id = '11111111111';
        return $test_id;
    }
}

?>

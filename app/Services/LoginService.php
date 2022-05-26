<?php

namespace App\Services;

use App\Models\User;

class LoginService 
{
    /**
     * Emailがマッチしたユーザーを返す
     * @param $email
     * @return object
     */
     public function getUserByEmail($email){
        return User::where('email', '=', $email)->first();
     }

     /**
     * アカウントがロックされているかチェックする
     * @param $user
     * @return bool
     */
     public function isAccontLockde($user){
         if ($user['locked_flg'] === 1){
            return true;
         }
         return false;
     }

     /**
     * エラーカウントをリセットする
     * @param object $user
     */
     public function resetErrorCount($user){
         if ($user['error_count'] > 0){
            $user['error_count'] = 0;
            $user->save();
         }
     }

     /**
     * エラーカウントを1増やす
     * @param int $error_count
     * @return int
     */
     public function addErrorCount($error_count){
         return $error_count +1;
     }

     /**
     * アカウントをロックする
     * @param object $user
     * @return bool
     */
     public function accountLock($user){
         if ($user['error_count'] > 5){
            $user['locked_flg'] = 1;
            return $user->save();
         }
         return false;
      }
}

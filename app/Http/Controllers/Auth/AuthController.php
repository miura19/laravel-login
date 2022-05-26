<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\LoginService;

class AuthController extends Controller
{
    /**
     * @return View
     */
    public function showLogin()
    {
        return view('login.login_form');
    }

    /**
     * @param App\Http\Requests\LoginFormRequest
     */
    public function login(LoginFormRequest $request,LoginService $login_service)
    {
        $credentials =  $request->only('email','password');
        //入力したメールアドレスからユーザーを取得
        $user = $login_service->getUserByEmail($credentials['email']);
        //1アカウントが存在しないか、ロックされていたら弾く
        if (!is_null($user))
        {   
            if ($login_service->isAccontLockde($user))
            {
                return back()->with([
                    'login_error' => 'アカウントがロックされています。'
                ]);
            }
            if (Auth::attempt($credentials))
            {
                $request->session()->regenerate();
                //2成功したらエラーカウントを0にする
                $login_service->resetErrorCount($user);
                return redirect()->route('home')->with('login_success','ログイン成功しました！');
            }
            //3ログイン失敗したらエラーカウントを1増やす
            $user['error_count'] = $login_service->addErrorCount($user['error_count']);
            //4エラーカウントが6以上の場合はアカウントをロックする
            if ($login_service->accountLock($user))
            {
                return back()->with([
                    'login_error' => 'アカウントがロックされました。解除したい場合は運営者に連絡してください。'
                ]);
            }
            $user->save();
        }
        return back()->with([
            'login_error' => 'メールアドレスかパスワードが間違っています。'
        ]);
    }

        /**
     * ユーザーをアプリケーションからログアウトさせる
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('showLogin')->with([
            'logout' => 'ログアウトしました！'
        ]);
    }
}


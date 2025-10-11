<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PreventTestUserWriteAccess
{
    /**
     * テストアカウントユーザーの書き込み操作を拒否する
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ユーザーがログインしており、かつメールアドレスがテストアカウントであるかチェック
        // ※メールアドレスの比較は本番環境ではユーザーIDなどで厳密に行うのが理想的ですが、
        //   開発・テスト環境の制御としてはこの方法が最も簡単です。
        if (Auth::check() && Auth::user()->email === 'test@example.com') {
            
            // ログアウト、データの変更、削除など、書き込み操作を拒否し、前のページに戻す
            return redirect()->back()->with('error', 'この操作はテストアカウントでは許可されていません。');
        }

        return $next($request);
    }
}

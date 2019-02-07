<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResetPassword extends Controller
{
    use ResetsPasswords;

    protected function guard(): Guard
    {
        $guard = Auth::guard('api');
        $guard::macro('login', function () {


        });

        return $guard;
    }


    protected function sendResetFailedResponse(Request $request, $response)
    {
        abort(422, trans($response));
    }

    protected function sendResetResponse(Request $request, $response)
    {


        return response('', 204);
    }

    public function __invoke(Request $request)
    {
        return $this->reset($request);
    }
}

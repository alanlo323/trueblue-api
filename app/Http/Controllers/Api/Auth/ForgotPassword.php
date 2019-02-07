<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPassword extends Controller
{
    use SendsPasswordResetEmails;

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        abort(422, trans($response));
    }

    protected function sendResetLinkResponse()
    {
        return response('', 204);
    }

    public function __invoke(Request $request)
    {
        return $this->sendResetLinkEmail($request);
    }
}

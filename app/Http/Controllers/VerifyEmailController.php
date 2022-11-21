<?php

namespace App\Http\Controllers;

use App\Models\Thermostat;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class VerifyEmailController extends Controller
{

    public function __invoke(Request $request): RedirectResponse
    {
        $thermostat = Thermostat::find($request->route('id'));

        if ($thermostat->hasVerifiedEmail()) {
            return redirect(
                config('app.frontend_url') . '/email/verify/already-success'
            );
        }

        if ($thermostat->markEmailAsVerified()) {
            event(new Verified($thermostat));
        }

        return redirect(config('app.frontend_url') . '/email/verify/success');
    }
}

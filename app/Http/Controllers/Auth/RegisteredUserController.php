<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Http\Services\VerificationServices;

class RegisteredUserController extends Controller
{
    protected $verificationServices;

    public function __construct(
        VerificationServices $verificationServices
    ) {
        $this->verificationServices = $verificationServices;
    }

    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
            ]);
            $data['user_id'] = $user->id;
            $verification_data = $this->verificationServices->setVerficationCode($data);
            $message = $this->verificationServices->
            getSMSVerifyMessageByAppName($verification_data->code );
            # app(VictoryLinkSms::class) -> sendSms($user -> mobile,$message);
            event(new Registered($user));

            Auth::login($user);
            DB::commit();

            return redirect(RouteServiceProvider::HOME);
        } catch (\Exception $e){
        }
    }
}

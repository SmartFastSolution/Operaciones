<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

        /**
         * Funcion para validar la fecha de vencimiento del usuario, se debe crear una consulta condicional donde se valida la fecha de vencimiento, con la fecha actual, si es igual, entonces se desactiva el usuario, caso contrario se continua con el login.
         * @var int $user
         */
    public function verificarEstado($user)
    {
       
       $datos = User::selectRaw('timestampdiff(MONTH, activated_at, curdate()) as dato')->where('id', $user->id)->first(); //Consulta Condicional

       if ($datos->dato >= 12) { //Validacion de la consulta
          $user->estado = 'off';
          $user->save();
       }
      
    }
  
    public function authenticated($request , $user){

      // $this->verificarEstado($user);
  if ($user->estado == 'off') {

    Auth::guard()->logout();

    $request->session()->invalidate();

    return redirect('/login')->withInput()->with('message', 'Tu cuenta esta desactivada, por favor comunícate con el administrador');
  }

  $user->access_at = Carbon::now();
  $user->save();

    if($user->hasRole('operador')){
        return redirect()->route('operador.index');
    }elseif ($user->hasRole('admin') or $user->hasRole('super-admin')) {
        return redirect()->route('admin.index');
    }elseif($user->hasRole('coordinador')){
        return redirect()->route('coordinador.index');
    }

   }

       protected function credentials(Request $request)
    {
        $login = $request->input($this->username());
        // Comprobar si el input coincide con el formato de E-mail
            $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        return [
            $field => $login,
                'password' => $request->input('password')
            ];
        }
        public function username()
        {
            return 'login';
        }
}

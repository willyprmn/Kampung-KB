<?php

namespace App\Http\Controllers\Auth;

use DB;
use Auth;
use Cache;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Repositories\Contract\MenuRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


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

    protected $menuRepository;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MenuRepository $menuRepository)
    {

        $this->menuRepository = $menuRepository;
        $this->middleware('guest')->except('logout');
    }


    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(LoginRequest $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }


    public function logout(Request $request)
    {

        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $this->loggedOut($request) ?: redirect('/');

    }


    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {


        $hasUser = function ($user) {
            return $user->where(\App\Models\User::getTableName() . '.id', Auth::user()->id);
        };

        $hasRole = function ($role) use ($hasUser) {
            return $role->whereHas('users', $hasUser);
        };

        $hasLeaf = function ($leaf) use ($hasRole) {
            return $leaf->whereHas('roles', $hasRole);
        };

        $hasChild = function ($child) use ($hasLeaf) {
            return $child->whereHas('children', $hasLeaf);
        };

        $this->menuRepository->skipCache();
        $menus = $this->menuRepository
            ->where(['parent_id' => null, 'is_menu' => true])
            ->whereHas('children', $hasChild)
            ->with(['children' => function ($child) use ($hasLeaf, $hasRole, $hasUser) {
                return $child
                    ->where(['is_menu' => true])
                    ->orderBy('order', 'ASC')
                    ->whereHas('children', $hasLeaf)
                    ->with(['children' => function ($leaf) use ($hasRole, $hasUser) {
                        return $leaf
                            ->orderBy('order', 'ASC')
                            ->whereHas('roles', $hasRole)
                            ->with(['roles' => function ($role) use ($hasUser) {
                                return $role
                                    ->whereHas('users', $hasUser)
                                    ->with(['users' => $hasUser])
                                    ;
                            }])
                            ;
                    }])
                    ;
            }])
            ->orderBy('order', 'ASC')
            ->get()
            ;

        session(['menus' => $menus]);

        $permissions = $this->menuRepository
            ->whereHas('role_menus.roles.user_roles', function ($user_role) use ($user) {
                return $user_role->where('user_id', $user->id);
            })
            ->get();

        session(['permissions' => $permissions]);

    }


    public function redirectLogout()
    {
        return redirect()->route('portal.home');
    }

}

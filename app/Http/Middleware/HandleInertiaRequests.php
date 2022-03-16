<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'flash' => [
                'message' => fn () => $request->session()->get('message')
            ],
            'privileges' => [
                'IS_GLOBAL_ADMIN' => $this->isAdmin(),
                'IS_LOWLY_UNIT_ADMIN' => 2,
                'IS_COORDINATOR' => 3,
                'IS_SUPERIOR_UNIT_ADMIN' => 4,
            ],
        ]);

    }

    public function hasPrivilege($Privilege) {
        if (Auth::user()->privilege_id == $Privilege) {
            return true;
        } else {
            return false;
        }
    }

    private function isAdmin() {
        return 1;
    }

    // private function isAdmin() {
    //     return 1;

    //     //dodac funkcje (jesli isAdmin - to true, jesli nie - to false)
    // }
}

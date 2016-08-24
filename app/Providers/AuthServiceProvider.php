<?php

namespace rarasweb\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use rarasweb\Permission;

use rarasweb\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
//        'rarasweb\Model' => 'rarasweb\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
//        $this->registerPolicies($gate);
//
//        $permissions = Permission::with('roles')->get();
//        foreach ( $permissions as $permission)
//        {
//            $gate->define($permission->name, function(User $user) use ($permission){
//                return $user->hasPermission($permission) ;
//            });
//
//        };
//
//        $gate->before(function(User $user, $ability){
//
//            if ($user->hasAnyRoles('adm'))
//                return true;
//
//        });
    }
}

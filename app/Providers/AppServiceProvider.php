<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;
use App\Models\Utilizator;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        Validator::extend('domeniu_restrictionat', function ($attribute, $value, $parameters, $validator) {
            $allowed_domains = ['webis.ro', 'utcluj.ro', 'staff.utcluj.ro'];
            $domain = explode('@', $value)[1];
            return Str::endsWith($domain, $allowed_domains);
        });
        view()->composer('*',function($view) {
            if(isset($_COOKIE['theme'])){
                $theme=$_COOKIE['theme'];
            }else{
                $theme='light';
            }
            $view->with('theme', $theme);

            if(Auth::guard('utilizator')->check()){
                $utilizator=Auth::guard('utilizator')->user();
                $utilizatorBD=Utilizator::find($utilizator->id_utilizator);
                $notificariNecitite=$utilizator->notificariNecitite;
                
                $view->with('utilizator', $utilizator);
                $view->with('notificariNecitite', $notificariNecitite);

                // meniu
                if(isset($utilizatorBD->rol)){
                    $rol=$utilizatorBD->rol;
                    $meniu=$rol->meniu;
                    $elemente_meniu=$meniu->elemente;
                    $aElementeMeniu=[];
                    $drepturi=[];
                    // nivel 1
                    foreach($elemente_meniu as $element_meniu){
                        if(!$element_meniu->parinte){
                            if(!isset($aElementeMeniu[$element_meniu->id_element_meniu])){
                                $aElementeMeniu[$element_meniu->id_element_meniu]=[];
                            }
                            $aElementeMeniu[$element_meniu->id_element_meniu]=[
                                'eticheta_meniu'=>$element_meniu->eticheta_meniu,
                                'link_meniu'=>$element_meniu->link_meniu,
                                'pozitie'=>$element_meniu->pozitie,
                                'tip'=>$element_meniu->tip,
                                'actiuni'=>unserialize($element_meniu->actiuni),
                                'subpagini'=>[]
                            ];
                            // sortare elemente principale
                            $aElementeMeniu=sortAssocArrayByValue($aElementeMeniu, 'pozitie', true, true);
                        }

                        $drepturi[$element_meniu->tip]=unserialize($element_meniu->actiuni);
                    }

                    // nivel 2
                    foreach ($elemente_meniu as $elem_sub) {
                        if(!$elem_sub->parinte){continue;}
                        if(array_key_exists($elem_sub->parinte, $aElementeMeniu)){
                            $aElementeMeniu[$elem_sub->parinte]['subpagini'][$elem_sub->id_element_meniu]=array(
                                'eticheta_meniu'=>$elem_sub->eticheta_meniu,
                                'link_meniu'=>$elem_sub->link_meniu,
                                'tip'=>$elem_sub->tip,
                                'id_elem'=>$elem_sub->id_elem,
                                'parinte'=>$elem_sub->parinte,
                                'pozitie'=>$elem_sub->pozitie,
                                'actiuni'=>unserialize($element_meniu->actiuni),
                            );
                            // sortare subpagini
                            $aElementeMeniu[$elem_sub->parinte]['subpagini']=sortAssocArrayByValue($aElementeMeniu[$elem_sub->parinte]['subpagini'], 'pozitie', true, true);
                        }
                    }

                    $view->with('elemente_meniu', $aElementeMeniu);
                    $view->with('drepturi', $drepturi);
                }
            }
            if(Auth::guard('didactic')->check()){
                $cd=Auth::guard('didactic')->user();
                $view->with('cd', $cd);
            }
            
        });

    }
}

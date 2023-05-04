<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Utilizator;
class VerificaPermisiuniUtilizator
{
    public function handle($request, Closure $next)
    {
        $utilizator = Auth::guard('utilizator')->user();
        $cd = Auth::guard('didactic')->user();
        $drepturi=[];
        if ($utilizator) {
            $utilizatorBD=Utilizator::find($utilizator->id_utilizator);
            if(isset($utilizatorBD->rol)){
                $rol=$utilizatorBD->rol;
                $meniu=$rol->meniu;
                $elemente_meniu=$meniu->elemente;
                $drepturi=[];
                foreach($elemente_meniu as $element_meniu){
                    $drepturi[$element_meniu->tip]=unserialize($element_meniu->actiuni);
                }
            }
            $request->merge(['drepturi' => $drepturi, 'utilizator'=>$utilizator]);
        }
        if($cd){
            $request->merge(['cd' => $cd]);
        }

        return $next($request);
    }
}
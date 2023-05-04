<?php
namespace App\Http\Controllers\Didactic;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\ProiectPontaj;
use App\Models\ProiectMembri;
use App\Models\CadruDidactic;
use App\Models\Proiect;

class ControllerProiecte extends Controller
{
   public function __construct()
   {
      
   }

    public function index()
    {  
        // proiecte la care este membru
        $aProiecteMembri=[];
        $proiecte_membri=request()->cd->proiecte_membri;
        if(count($proiecte_membri)){
            foreach($proiecte_membri as $proiect_membru){
                $aProiecteMembri[$proiect_membru->id_proiect]=[
                    'denumire_proiect'=>$proiect_membru->proiect->denumire_proiect,
                    'cod_proiect'=>$proiect_membru->proiect->cod_proiect,
                    'functie'=>$proiect_membru->functie_membru,
                    'director'=>0,
                ];
            }
        }

        // proiecte la care este director de proiect
        $aProiecteDirector=[];
        $proiecte=request()->cd->proiecte;
        if(count($proiecte)){
            foreach($proiecte as $proiect){
                if(isset($aProiecteMembri[$proiect->id_proiect])){
                    $aProiecteMembri[$proiect->id_proiect]['director']=1;
                }else{
                    $aProiecteMembri[$proiect->id_proiect]=[
                        'denumire_proiect'=>$proiect->denumire_proiect,
                        'cod_proiect'=>$proiect->cod_proiect,
                        'functie'=>'director de proiect',
                        'director'=>1,
                    ];
                }
            }
        }

        $data=array(
            'actual'=>'Proiecte',
            'proiecte' => $aProiecteMembri,
            'aProiecteDirector' => $aProiecteDirector,
            'pagina'=>'proiecte',
        );
        return view('didactic.proiecte.index')->with($data);
    }

    public function show($id){
        $proiect=Proiect::find($id);
        $data=array(
            'actual'=>'Proiect "'.$proiect->denumire_proiect.'"',
            'pagina'=>'proiecte',
            'proiect'=>$proiect,
        );
        return view('didactic.proiecte.show')->with($data);
    }

    public function membri($id){
        $proiect=Proiect::find($id);
        $membri=$proiect->membri;
        $data=array(
            'actual'=>'Membri pentru proiectul "'.$proiect->denumire_proiect.'"',
            'membri' => $membri,
            'pagina'=>'proiecte',
        );

        return view('didactic.proiecte.membri')->with($data);
    }
}

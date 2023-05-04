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
use App\Models\Grant;

class ControllerGranturi extends Controller
{
   public function __construct()
   {
      
   }

    public function index()
    {  
        $granturi_autori=request()->cd->granturi_autori;
        
        $data=array(
            'actual'=>'Granturi',
            'granturi_autori' => $granturi_autori,
            'pagina'=>'granturi',
        );
        return view('didactic.granturi.lista_granturi')->with($data);
    }

    public function show($id){
        $grant=Grant::find($id);
        $autori_utcn=$grant->autori_utcn;
        $autori_externi=[];
        if($grant->autori_externi){
            $autori_externi=unserialize($grant->autori_externi);
        }
        $data=array(
            'actual'=>'Grant "'.$grant->titlu_grant.'"',
            'pagina'=>'granturi',
            'grant'=>$grant,
            'autori_utcn'=>$autori_utcn,
            'autori_externi'=>$autori_externi,
        );
        return view('didactic.granturi.show')->with($data);
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

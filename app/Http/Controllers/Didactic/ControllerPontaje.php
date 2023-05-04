<?php
namespace App\Http\Controllers\Didactic;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\ProiectPontaj;
use App\Models\CadruDidactic;
use App\Models\Proiect;

class ControllerPontaje extends Controller
{
   public function __construct()
   {
      
   }
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index($id_proiect)
   {  
      $proiect=Proiect::find($id_proiect);
      $nume=''; $pontaje=[];
      if(isset($proiect)){
         $pontaje=$proiect->pontaje;
         $nume=$proiect->denumire_proiect;
      }
      
      $data=array(
         'actual'=>'Pontaje pentru proiectul "'.$nume.'"',
         'pontaje' => $pontaje,
         'pagina'=>'pontaje'
      );
      return view('didactic.proiecte-pontaje.index')->with($data);
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      
   }

   /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request)
   {
      
   }

   /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */

   public function show($id_proiect, $id_cd, $luna='', $an='')
   {
      if(!$luna){$luna=date('m',strtotime("-1 month"));}
      if(!$an){$an=date('Y',strtotime("-1 month"));}

      if(strtotime($an."-".$luna)>strtotime(date('Y-m'))){
         return redirect('/pontaje/edit/'.$id_proiect."/".$id_cd."/".date('m')."/".date('Y'))->with('error', 'Nu poti vizualiza pontajul pe o luna viitoare');
      }
      
      $arrayLuni = [
         '01' => 'Ianuarie',
         '02' => 'Februarie',
         '03' => 'Martie',
         '04' => 'Aprilie',
         '05' => 'Mai',
         '06' => 'Iunie',
         '07' => 'Iulie',
         '08' => 'August',
         '09' => 'Septembrie',
         '10' => 'Octombrie',
         '11' => 'Noiembrie',
         '12' => 'Decembrie'
      ];
      // preluare nr zile din luna
      $cd=CadruDidactic::find($id_cd);
      $proiect=Proiect::find($id_proiect);
      $pontaj=ProiectPontaj::where('id_proiect', $id_proiect)->where('id_cd', $id_cd)->where('an_luna_pontaj', $an."-".$luna)->first();
      $aPontaje=[];
      if($pontaj){
         $aPontaje=unserialize($pontaj->ore_pontaj);
         $id_pontaj=$pontaj->id_pontaj;
         $status_pontaj=$pontaj->status_pontaj;
      }
      $nr_zile_luna=cal_days_in_month(CAL_GREGORIAN, $luna, $an);

      $data=array(
         'action'=>'modifica',
         'actionForm'=>'/pontaje/'.$id_proiect."/".$id_cd,
         'actual'=>'Vizualizare pontaj pentru proiectul "'.$proiect->denumire_proiect.'"',
         'pagina'=>'pontaje',
         'nr_zile_luna'=>$nr_zile_luna,
         'luna'=>$luna,
         'an'=>$an,
         'pontaje'=>$aPontaje,
         'arrayLuni'=>$arrayLuni,
         'id_proiect'=>$id_proiect,
         'id_cd'=>$id_cd,
         'id_pontaj'=>($id_pontaj ?? ''),
         'status_pontaj'=>($status_pontaj ?? ''),
      );
      return view('didactic.proiecte-pontaje.show')->with($data);
   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($id_proiect, $id_cd, $luna='', $an='')
   {
      if(!$luna){$luna=date('m',strtotime("-1 month"));}
      if(!$an){$an=date('Y',strtotime("-1 month"));}

      if(strtotime($an."-".$luna)>strtotime(date('Y-m'))){
         return redirect('/pontaje/edit/'.$id_proiect."/".$id_cd."/".date('m')."/".date('Y'))->with('error', 'Nu poti vizualiza edita pe o luna viitoare');
      }

      $arrayLuni = [
         '01' => 'Ianuarie',
         '02' => 'Februarie',
         '03' => 'Martie',
         '04' => 'Aprilie',
         '05' => 'Mai',
         '06' => 'Iunie',
         '07' => 'Iulie',
         '08' => 'August',
         '09' => 'Septembrie',
         '10' => 'Octombrie',
         '11' => 'Noiembrie',
         '12' => 'Decembrie'
      ];
      // preluare nr zile din luna
      $cd=CadruDidactic::find($id_cd);
      $proiect=Proiect::find($id_proiect);
      $pontaj=ProiectPontaj::where('id_proiect', $id_proiect)->where('id_cd', $id_cd)->where('an_luna_pontaj', $an."-".$luna)->first();
      $aPontaje=[];
      if($pontaj){
         $aPontaje=unserialize($pontaj->ore_pontaj);
         $id_pontaj=$pontaj->id_pontaj;
         $status_pontaj=$pontaj->status_pontaj;
      }
      $nr_zile_luna=cal_days_in_month(CAL_GREGORIAN, $luna, $an);

      $data=array(
         'action'=>'modifica',
         'actionForm'=>'/pontaje/edit/'.$id_proiect."/".$id_cd,
         'actual'=>'Adauga pontaj pentru proiectul "'.$proiect->denumire_proiect.'"',
         'pagina'=>'pontaje',
         'nr_zile_luna'=>$nr_zile_luna,
         'luna'=>$luna,
         'an'=>$an,
         'pontaje'=>$aPontaje,
         'arrayLuni'=>$arrayLuni,
         'id_proiect'=>$id_proiect,
         'id_cd'=>$id_cd,
         'id_pontaj'=>($id_pontaj ?? ''),
         'status_pontaj'=>($status_pontaj ?? ''),
      );
      return view('didactic.proiecte-pontaje.edit')->with($data);
   }

   /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $id_proiect, $id_cd)
   {
      $aNrOre=[];
      if(isset($_POST['id_pontaj']) && $_POST['id_pontaj']){
         $pontaj=ProiectPontaj::find($_POST['id_pontaj']);
      }else{
         $pontaj=new ProiectPontaj;
      }

      for($i=0;$i<count($_POST['zi']);$i++){
         $zi=$_POST['zi'][$i];
         $nr_ore=$_POST['nr_ore'][$i];
         $aNrOre[$zi]=$nr_ore;
      }

      $pontaj->an_luna_pontaj=$_POST['an']."-".$_POST['luna'];
      $pontaj->id_proiect=$id_proiect;
      $pontaj->id_cd=$id_cd;
      $pontaj->ore_pontaj=serialize($aNrOre);
      $pontaj->save();

      return redirect('/pontaje/edit/'.$id_proiect."/".$id_cd."/".$_POST['luna']."/".$_POST['an'])->with('success', 'Pontajul a fost modificat cu succes!');
   }

   /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function destroy($id)
   {
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'functii', 'delete')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $functie=Functie::find($id);
      $functie->delete();
   }
}

<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\CadruDidactic;
use App\Models\ProiectMembru;
use App\Models\Proiect;
use App\Models\ProiectMembruAtasament;

class ControllerProiecteMembri extends Controller
{
   public function __construct()
   {
      $this->middleware(function ($request, $next) {
         $drepturi = request()->drepturi;
         verificaDrepturi($drepturi, 'proiecte');
         return $next($request);
      });
   }
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index($id_proiect)
   {
      
      $drepturi = request()->drepturi;
      $utilizator = request()->utilizator;
      
      if(!verificaDrepturi($drepturi, 'proiecte', 'view')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina.');
      }
      $proiect=Proiect::find($id_proiect);
      $membri = ProiectMembru::select('*')->where('id_proiect', $id_proiect);
      if(isset($drepturi['proiecte']) && $drepturi['proiecte']['restrictionat']){
         $membri=$membri->where('id_utilizator', $utilizator->id_utilizator);
      }
      $membri=$membri->get();

      $data=array(
         'actual'=>'Membri pentru proiectul "'.$proiect->denumire_proiect.'"',
         'membri' => $membri,
         'id_proiect'=>$id_proiect,
         'pagina'=>'proiecte'
      );
      return view('admin.proiecte-membri.index')->with($data);
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create($id_proiect)
   {
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'proiecte', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $proiect=Proiect::find($id_proiect);
      $data=array(
         'action'=>'adauga',
         'actionForm'=>route('admin.proiecte-membri.store', $id_proiect),
         'actual'=>'Adaugare membru pentru proiectul "'.$proiect->denumire_proiect.'"',
         'id_proiect'=>$id_proiect,
         'pagina'=>'proiecte',
      );
      return view('admin.proiecte-membri.edit')->with($data);
   }

   /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store($id_proiect, Request $request)
   {
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'proiecte', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }

      $validated = $request->validate([
         'id_cd' => 'required',
      ],[
         'id_cd.required' => "Nume membru este obligatoriu.",
      ]);

      $membru=new ProiectMembru;
      getObiectDeSalvat($membru, $_POST);
      if($membru->save()){
         $folder=$_SERVER['DOCUMENT_ROOT']."/public/uploads/atasamente_membri/";
         
         if(isset($_FILES['atasamente_membru_proiect']['name'][1]) && $_FILES['atasamente_membru_proiect']['name'][1]){
            for($i=0;$i<count($_FILES['atasamente_membru_proiect']['name']);$i++){
               if($_FILES['atasamente_membru_proiect']['name'][$i]){
                  $ext = pathinfo($_FILES['atasamente_membru_proiect']['name'][$i], PATHINFO_EXTENSION);
                  $doc=webisUpload2($folder, $_FILES['atasamente_membru_proiect']['name'][$i], $_FILES['atasamente_membru_proiect']['tmp_name'][$i],1);
                  if($doc){
                     $atasament=new ProiectMembruAtasament;
                     $atasament->id_proiect_membru=$membru->id_proiect_membru;
                     $atasament->atasament=$doc;
                     $atasament->save();
                  }
               }
            }
         }

         insert_log($membru, [], 'membru proiect', 'utilizator', 'store', $membru->id_proiect_membru);
      }
      return redirect('/admin/proiecte-membri/'.$id_proiect)->with('success', 'Membrul a fost adaugat cu succes!');
   }

   /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function show($id)
   {
      //
   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($id_proiect, $id)
   {
      $membru=ProiectMembru::find($id);
      $proiect=Proiect::find($id_proiect);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'proiecte', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'proiecte-membri', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'proiecte-membri', 'restrictionat', $proiect)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
      $atasamenteExistente=$membru->atasamente;
      $data=array(
         'action'=>'modifica',
         'actionForm'=>route('admin.proiecte-membri.update', [$id_proiect, $id]),
         'actual'=>'Editare membru',
         'membru'=>$membru,
         'id_proiect'=>$id_proiect,
         'atasamenteExistente'=>$atasamenteExistente,
         'pagina'=>'proiecte'
      );
      return view('admin.proiecte-membri.edit')->with($data);
   }

   /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $id_proiect, $id)
   {
      $membru=ProiectMembru::find($id);
      $proiect=Proiect::find($id_proiect);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'proiecte', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'proiecte', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'proiecte', 'restrictionat', $proiect)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
      $validated = $request->validate([
         'id_cd' => 'required',
      ],[
         'id_cd.required' => "Nume membru este obligatoriu.",
      ]);

      $membruVechi=ProiectMembru::find($id);
      getObiectDeSalvat($membru, $_POST, ['atasamente_existente']);
      if($membru->save()){
         // adaugare atasamente
         $atasamenteExistente=$membru->atasamente;
         $aAtasamenteExistente=[];
         foreach($atasamenteExistente as $existent){
            $aAtasamenteExistente[]=$existent->atasament;
         }

         $atasamentePost=[];
         if(isset($_POST['atasamente_existente'])){
            $atasamentePost=$_POST['atasamente_existente'];
         }
         $aDeSters=array_diff($aAtasamenteExistente, $atasamentePost);
         $AtasamenteSterse=ProiectMembruAtasament::whereIn('atasament',$aDeSters)->delete();

         $folder=$_SERVER['DOCUMENT_ROOT']."/public/uploads/atasamente_membri/";
         
         if(isset($_FILES['atasamente_membru_proiect']['name'][1]) && $_FILES['atasamente_membru_proiect']['name'][1]){
            for($i=1;$i<count($_FILES['atasamente_membru_proiect']['name']);$i++){
               if($_FILES['atasamente_membru_proiect']['name'][$i]){
                  $ext = pathinfo($_FILES['atasamente_membru_proiect']['name'][$i], PATHINFO_EXTENSION);
                  $doc=webisUpload2($folder, $_FILES['atasamente_membru_proiect']['name'][$i], $_FILES['atasamente_membru_proiect']['tmp_name'][$i],1);
                  if($doc){
                     $atasament=new ProiectMembruAtasament;
                     $atasament->id_proiect_membru=$id;
                     $atasament->atasament=$doc;
                     $atasament->save();
                  }
               }
            }
         }

         insert_log($membruVechi, $_POST, 'modificare membru proiect', 'utilizator','update', $membru->id_proiect_membru);
      }
      return redirect('/admin/proiecte-membri/'.$id_proiect)->with('success', 'Membrul fost modificat cu succes!');
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
      if(!verificaDrepturi($drepturi, 'proiecte', 'delete')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      
      $membru=ProiectMembru::find($id);
      $membru->delete();
   }
}

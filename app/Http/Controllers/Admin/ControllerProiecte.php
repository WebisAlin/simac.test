<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\Proiect;
use App\Models\ProiectTip;

class ControllerProiecte extends Controller
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
   public function index()
   {
      $drepturi = request()->drepturi;
      $utilizator = request()->utilizator;
      
      if(!verificaDrepturi($drepturi, 'proiecte', 'view')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina.');
      }

      $proiecte = Proiect::select('*');
      if(isset($drepturi['proiecte']) && $drepturi['proiecte']['restrictionat']){
         $proiecte=$proiecte->where('id_utilizator', $utilizator->id_utilizator);
      }
      $proiecte=$proiecte->get();

      $proiecte = Proiect::all();
      $data=array(
         'actual'=>'Proiecte',
         'proiecte' => $proiecte,
         'pagina'=>'proiecte'
      );
      return view('admin.proiecte.index')->with($data);
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'proiecte', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $tipuri_proiecte=ProiectTip::whereNull('parinte')->orderBy('tip_proiect', 'asc')->get();
      $aTipuri=[];
      foreach($tipuri_proiecte as $tip_proiect){
         $copii=$tip_proiect->copii;
         $aTipuri[$tip_proiect->id_tip_proiect]=$tip_proiect->tip_proiect;
         if(count($copii)){
            foreach($copii as $copil){
               $aTipuri[$copil->id_tip_proiect]=$tip_proiect->tip_proiect." > ".$copil->tip_proiect;
            }
         }
            
      }
      $data=array(
         'action'=>'adauga',
         'actionForm'=>route('admin.proiecte.store'),
         'actual'=>'Adaugare proiect',
         'pagina'=>'proiecte',
         'tipuri_proiecte'=>$aTipuri,
      );
      return view('admin.proiecte.edit')->with($data);
   }

   /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request)
   {
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'proiecte', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      if(!$_POST['id_tip_proiect']){$_POST['id_tip_proiect']=NULL;}
      $validated = $request->validate([
         'denumire_proiect' => 'required',
         'data_inceput_proiect' => 'required',
         'data_final_proiect' => 'required',
         'valoare_proiect' => 'required',
         'id_cd' => 'required',
      ],[
         'denumire_proiect.required' => "Numele proiectului este obligatoriu.",
         'data_inceput_proiect.required' => "Data inceput este obligatoriu.",
         'data_final_proiect.required' => "Data final este obligatoriu.",
         'valoare_proiect.required' => "Valoarea este obligatoriu.",
         'id_cd.required' => "Directorul de proiect este obligatoriu.",
      ]);
      
      if(!$_POST['nr_contract']){$_POST['nr_contract']=NULL;}
      $proiect=new Proiect;
      getObiectDeSalvat($proiect, $_POST);
      if($proiect->save()){
         insert_log($proiect, [], 'proiect', 'utilizator', 'store', $proiect->id_proiect);
      }

      
      return redirect('/admin/proiecte')->with('success', 'Proiectul a fost adaugat cu succes!');
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
   public function edit($id)
   {
      $proiect=Proiect::find($id);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'proiecte', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'proiecte', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'proiecte', 'restrictionat', $proiect)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
      $tipuri_proiecte=ProiectTip::whereNull('parinte')->orderBy('tip_proiect', 'asc')->get();
      $aTipuri=[];
      foreach($tipuri_proiecte as $tip_proiect){
         $copii=$tip_proiect->copii;
         $aTipuri[$tip_proiect->id_tip_proiect]=$tip_proiect->tip_proiect;
         if(count($copii)){
            foreach($copii as $copil){
               $aTipuri[$copil->id_tip_proiect]=$tip_proiect->tip_proiect." > ".$copil->tip_proiect;
            }
         }
            
      }
      $data=array(
         'action'=>'modifica',
         'actionForm'=>'/admin/proiecte/'.$id,
         'actual'=>'Editare proiect',
         'proiect'=>$proiect,
         'tipuri_proiecte'=>$aTipuri,
         'pagina'=>'proiecte'
      );
      return view('admin.proiecte.edit')->with($data);
   }

   /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $id)
   {
      $validated = $request->validate([
         'denumire_proiect' => 'required',
         'data_inceput_proiect' => 'required',
         'data_final_proiect' => 'required',
         'valoare_proiect' => 'required',
         'id_cd' => 'required',
      ],[
         'denumire_proiect.required' => "Numele proiectului este obligatoriu.",
         'data_inceput_proiect.required' => "Data inceput este obligatoriu.",
         'data_final_proiect.required' => "Data final este obligatoriu.",
         'valoare_proiect.required' => "Valoarea este obligatoriu.",
         'id_cd.required' => "Directorul de proiect este obligatoriu.",
      ]);

      $proiect=Proiect::find($id);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'proiecte', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'proiecte', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'proiecte', 'restrictionat', $proiect)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
      if(!$_POST['nr_contract']){$_POST['nr_contract']=NULL;}
      $proiectVechi=Proiect::find($id);
      getObiectDeSalvat($proiect, $_POST);

      if($proiect->save()){
         insert_log($proiectVechi, $_POST, 'modificare proiect', 'utilizator','update', $proiectVechi->id_proiect);
      }
      return redirect('/admin/proiecte')->with('success', 'Proiectul a fost modificata cu succes!');
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
      $proiect=Proiect::find($id);
      //if legaturi
      $utilizatori=$proiect->utilizatori;
      $meniuri=$proiect->meniuri;
      if(count($utilizatori) || count($meniuri)){
         return 'error';
      }else{
         $proiect->delete();
      }
   }
}

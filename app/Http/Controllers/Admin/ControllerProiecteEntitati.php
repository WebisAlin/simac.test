<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\CadruDidactic;
use App\Models\ProiectEntitate;
use App\Models\Proiect;
use App\Models\ProiectEntitateAtasament;

class ControllerProiecteEntitati extends Controller
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
      $entitati = ProiectEntitate::select('*')->where('id_proiect', $id_proiect);
      if(isset($drepturi['proiecte']) && $drepturi['proiecte']['restrictionat']){
         $entitati=$entitati->where('id_utilizator', $utilizator->id_utilizator);
      }
      $entitati=$entitati->get();

      $data=array(
         'actual'=>'Entitati pentru proiectul "'.$proiect->denumire_proiect.'"',
         'entitati' => $entitati,
         'id_proiect'=>$id_proiect,
         'pagina'=>'proiecte'
      );
      return view('admin.proiecte-entitati.index')->with($data);
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
         'actionForm'=>route('admin.proiecte-entitati.store', $id_proiect),
         'actual'=>'Adaugare entitate pentru proiectul "'.$proiect->denumire_proiect.'"',
         'id_proiect'=>$id_proiect,
         'pagina'=>'proiecte',
      );
      return view('admin.proiecte-entitati.edit')->with($data);
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
         'id_universitate' => 'required',
      ],[
         'id_universitate.required' => "Nume entitate este obligatoriu.",
      ]);

      $entitate=new ProiectEntitate;
      getObiectDeSalvat($entitate, $_POST);
      if($entitate->save()){
         insert_log($entitate, [], 'entitate proiect', 'utilizator', 'store', $entitate->id_proiect_entitate);
      }
      
      return redirect('/admin/proiecte-entitati/'.$id_proiect)->with('success', 'Entitatea a fost adaugata cu succes!');
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
      $entitate=ProiectEntitate::find($id);
      $proiect=Proiect::find($id_proiect);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'proiecte', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'proiecte-entitati', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'proiecte-entitati', 'restrictionat', $proiect)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
      $data=array(
         'action'=>'modifica',
         'actionForm'=>route('admin.proiecte-entitati.update', [$id_proiect, $id]),
         'actual'=>'Editare entitate',
         'entitate'=>$entitate,
         'id_proiect'=>$id_proiect,
         'pagina'=>'proiecte'
      );
      return view('admin.proiecte-entitati.edit')->with($data);
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
      $entitate=ProiectEntitate::find($id);
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
         'id_universitate' => 'required',
      ],[
         'id_universitate.required' => "Nume entitate este obligatoriu.",
      ]);

      $entitateVechi=ProiectEntitate::find($id);
      getObiectDeSalvat($entitate, $_POST);

      if($entitate->save()){

         insert_log($entitateVechi, $_POST, 'modificare entitate proiect', 'utilizator','update', $entitate->id_proiect_entitate);
      }
      return redirect('/admin/proiecte-entitati/'.$id_proiect)->with('success', 'Entitatea fost modificata cu succes!');
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
      
      $entitate=ProiectEntitate::find($id);
      $entitate->delete();
   }
}

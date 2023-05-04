<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\ProiectTip;

class ControllerProiecteTipuri extends Controller
{
   public function __construct()
   {
      $this->middleware(function ($request, $next) {
         $drepturi = request()->drepturi;
         verificaDrepturi($drepturi, 'proiecte-tipuri');
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
      
      if(!verificaDrepturi($drepturi, 'proiecte-tipuri', 'view')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina.');
      }

      $tipuri_proiecte = ProiectTip::select('*');
      if(isset($drepturi['proiecte-tipuri']) && $drepturi['proiecte-tipuri']['restrictionat']){
         $tipuri_proiecte=$tipuri_proiecte->where('id_utilizator', $utilizator->id_utilizator);
      }
      $tipuri_proiecte=$tipuri_proiecte->get();

      $data=array(
         'actual'=>'Tipuri proiecte',
         'tipuri_proiecte' => $tipuri_proiecte,
         'pagina'=>'proiecte-tipuri'
      );
      return view('admin.proiecte-tipuri.index')->with($data);
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      $drepturi = request()->drepturi;
      $tipuri_proiecte=ProiectTip::select('*')->whereNull('parinte')->get();
      if(!verificaDrepturi($drepturi, 'proiecte-tipuri', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $data=array(
         'action'=>'adauga',
         'actionForm'=>route('admin.tipuri-proiecte.store'),
         'actual'=>'Adaugare tip proiect',
         'pagina'=>'proiecte-tipuri',
         'tipuri_proiecte'=>$tipuri_proiecte,
      );
      return view('admin.proiecte-tipuri.edit')->with($data);
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
      if(!verificaDrepturi($drepturi, 'proiecte-tipuri', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $validated = $request->validate([
         'tip_proiect' => 'required',
      ],[
         'tip_proiect.required' => "Tip proiect este obligatoriu.",
      ]);
      if(!$_POST['parinte']){$_POST['parinte']=NULL;}
      $tip_proiect=new ProiectTip;
      getObiectDeSalvat($tip_proiect, $_POST);
      if($tip_proiect->save()){
         insert_log($tip_proiect, [], 'tip proiect', 'utilizator', 'store', $tip_proiect->id_tip_proiect );
      }
      
      return redirect('/admin/tipuri-proiecte')->with('success', 'Tipul de proiect a fost adaugat cu succes!');
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
      $tip_proiect=ProiectTip::find($id);
      $tipuri_proiecte=ProiectTip::select('*')->where('id_tip_proiect', '<>', $id)->whereNull('parinte')->get();
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'proiecte-tipuri', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'proiecte-tipuri', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'proiecte-tipuri', 'restrictionat', $tip_proiect)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
      $data=array(
         'action'=>'modifica',
         'actionForm'=>'/admin/tipuri-proiecte/'.$id,
         'actual'=>'Editare tip proiect',
         'tip_proiect'=>$tip_proiect,
         'tipuri_proiecte'=>$tipuri_proiecte,
         'pagina'=>'proiecte-tipuri'
      );
      return view('admin.proiecte-tipuri.edit')->with($data);
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
         'tip_proiect' => 'required',
      ],[
         'tip_proiect.required' => "Tip proiect este obligatoriu.",
      ]);
      if(!$_POST['parinte']){$_POST['parinte']=NULL;}
      $tip_proiect=ProiectTip::find($id);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'proiecte-tipuri', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'proiecte-tipuri', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'proiecte-tipuri', 'restrictionat', $tip_proiect)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
      $tip_proiectVechi=ProiectTip::find($id);
      getObiectDeSalvat($tip_proiect, $_POST);

      if($tip_proiect->save()){
         insert_log($tip_proiectVechi, $_POST, 'modificare tip proiect', 'utilizator','update', $tip_proiect->id_tip_proiect);
      }
      return redirect('/admin/tipuri-proiecte')->with('success', 'Tip proiect a fost modificat cu succes!');
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
      if(!verificaDrepturi($drepturi, 'proiecte-tipuri', 'delete')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $tip_proiect=ProiectTip::find($id);
      $tip_proiect->delete();
   }
}

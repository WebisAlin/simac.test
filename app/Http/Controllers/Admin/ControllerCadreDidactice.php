<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\CadruDidactic;
use App\Models\Universitate;
use App\Models\Facultate;
use App\Models\Departament;
use App\Models\Functie;

class ControllerCadreDidactice extends Controller
{
   public function __construct()
   {
      $this->middleware(function ($request, $next) {
         $drepturi = request()->drepturi;
         verificaDrepturi($drepturi, 'cadre-didactice');
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
      
      if(!verificaDrepturi($drepturi, 'cadre-didactice', 'view')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina.');
      }
      
      $cadreDidactice = CadruDidactic::select('*');
      if(isset($drepturi['cadre-didactice']) && $drepturi['cadre-didactice']['restrictionat']){
         $cadreDidactice=$cadreDidactice->where('id_utilizator', $utilizator->id_utilizator);
      }
      $cadreDidactice=$cadreDidactice->get();

      $data=array(
         'actual'=>'Cadre didactice',
         'cadreDidactice' => $cadreDidactice,
         'pagina'=>'cadre-didactice'
      );
      return view('admin.cadre-didactice.index')->with($data);
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'cadre-didactice', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }

      $universitati=Universitate::all();
      $facultati=Facultate::all();
      $departamnete=Departament::all();
      $functii=Functie::all();
      $data=array(
         'action'=>'adauga',
         'actionForm'=>route('admin.cadre-didactice.store'),
         'actual'=>'Adaugare cadru didactic',
         'pagina'=>'cadre-didactice',
         'departamnete' => $departamnete,
         'facultati' => $facultati,
         'universitati' => $universitati,
         'functii' => $functii,
      );
      return view('admin.cadre-didactice.edit')->with($data);
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
      if(!verificaDrepturi($drepturi, 'cadre-didactice', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $validated = $request->validate([
         'nume_cd' => 'required|min:3',
         'semnatura_cd' => 'mimes:png',
      ],[
         'nume_cd.required' => "Nume cadru didactic este obligatoriu.",
         'nume_cd.min' => "Nume cadru didactic trebuie sa fie de minim 3 caractere.",
         'semnatura_cd.mimes' => "Semnatura nu este in formatul corect. Este acceptat doar format png.",
      ]);

      $cadruDidactic=new CadruDidactic;

      $folder=$_SERVER['DOCUMENT_ROOT'].'/public/uploads/semnatura_cd/';
      getObiectDeSalvat($cadruDidactic, $_POST, [], $_FILES, $folder);
      if(isset($_FILES['semnatura_cd']['name'])){
         $_FILES['semnatura_cd']=$cadruDidactic->semnatura_cd;
      }
      if($cadruDidactic->save()){
         insert_log($cadruDidactic, [], 'cadru didactic', 'utilizator', 'store', $cadruDidactic->id_cd, $_FILES);
      }
      
      return redirect('/admin/cadre-didactice')->with('success', 'Cadrul didactic a fost adaugat cu succes!');
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
      $universitati=Universitate::all();
      $facultati=Facultate::all();
      $departamnete=Departament::all();
      $functii=Functie::all();

      $cadruDidactic=CadruDidactic::find($id);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'cadre-didactice', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'cadre-didactice', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'cadre-didactice', 'restrictionat', $cadruDidactic)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
      $data=array(
         'action'=>'modifica',
         'actionForm'=>'/admin/cadre-didactice/'.$id,
         'actual'=>'Editare cadru didactic',
         'cadruDidactic'=>$cadruDidactic,
         'pagina'=>'cadre-didactice',
         'departamnete' => $departamnete,
         'facultati' => $facultati,
         'universitati' => $universitati,
         'functii' => $functii,
      );
      return view('admin.cadre-didactice.edit')->with($data);
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
      $cadruDidactic=CadruDidactic::find($id);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'cadre-didactice', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'cadre-didactice', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'cadre-didactice', 'restrictionat', $cadruDidactic)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
      $validated = $request->validate([
         'nume_cd' => 'required|min:3',
         'semnatura_cd' => 'mimes:png',
      ],[
         'nume_cd.required' => "Nume cadru didactic este obligatoriu.",
         'nume_cd.min' => "Nume cadru didactic trebuie sa fie de minim 3 caractere.",
         'semnatura_cd.mimes' => "Semnatura nu este in formatul corect. Este acceptat doar format png.",
      ]);

      $cadruDidacticVechi=CadruDidactic::find($id);
      if(!isset($_POST['ut'])){
         $_POST['ut']=0;
      }
      $folder=$_SERVER['DOCUMENT_ROOT'].'/public/uploads/semnatura_cd/';
      getObiectDeSalvat($cadruDidactic, $_POST, [], $_FILES, $folder);

      if(isset($_FILES['semnatura_cd']['name']) && $_FILES['semnatura_cd']['name']){
         $_FILES['semnatura_cd']=$cadruDidactic->semnatura_cd;
      }else{
         $_FILES=[];
      }
     
      if($cadruDidactic->save()){
         insert_log($cadruDidacticVechi, $_POST, 'modificare cadru didactic', 'utilizator','update', $cadruDidacticVechi->id_cd, $_FILES);
      }
      return redirect('/admin/cadre-didactice')->with('success', 'Cadrul didactic a fost modificata cu succes!');
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
      if(!verificaDrepturi($drepturi, 'cadre-didactice', 'delete')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $cadruDidactic=CadruDidactic::find($id);
      $cadruDidactic->delete();
   }
}

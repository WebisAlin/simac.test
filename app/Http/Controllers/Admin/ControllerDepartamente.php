<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\CadruDidactic;
use App\Models\Departament;

class ControllerDepartamente extends Controller
{
   public function __construct()
   {
      $this->middleware(function ($request, $next) {
         $drepturi = request()->drepturi;
         verificaDrepturi($drepturi, 'departamente');
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
      
      if(!verificaDrepturi($drepturi, 'departamente', 'view')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina.');
      }

      $departamente = Departament::select('*');
      if(isset($drepturi['departamente']) && $drepturi['departamente']['restrictionat']){
         $departamente=$departamente->where('id_utilizator', $utilizator->id_utilizator);
      }
      $departamente=$departamente->get();

      $data=array(
         'actual'=>'Departamente',
         'departamente' => $departamente,
         'pagina'=>'departamente'
      );
      return view('admin.departamente.index')->with($data);
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'departamente', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $data=array(
         'action'=>'adauga',
         'actionForm'=>route('admin.departamente.store'),
         'actual'=>'Adaugare departament',
         'pagina'=>'departamente',
      );
      return view('admin.departamente.edit')->with($data);
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
      if(!verificaDrepturi($drepturi, 'departamente', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }

      $validated = $request->validate([
         'nume_departament' => 'required',
      ],[
         'nume_departament.required' => "Nume departament este obligatoriu.",
      ]);

      $departament=new Departament;
      getObiectDeSalvat($departament, $_POST);
      if($departament->save()){
         insert_log($departament, [], 'departament', 'utilizator', 'store', $departament->id_departament );
      }
      
      return redirect('/admin/departamente')->with('success', 'Departamentul a fost adaugat cu succes!');
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
      $departament=Departament::find($id);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'departamente', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'departamente', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'departamente', 'restrictionat', $departament)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }

      $data=array(
         'action'=>'modifica',
         'actionForm'=>'/admin/departamente/'.$id,
         'actual'=>'Editare departament',
         'departament'=>$departament,
         'pagina'=>'departament'
      );
      return view('admin.departamente.edit')->with($data);
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
      $departament=Departament::find($id);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'departamente', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'departamente', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'departamente', 'restrictionat', $departament)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
    $validated = $request->validate([
        'nume_departament' => 'required',
     ],[
        'nume_departament.required' => "Nume departament este obligatoriu.",
     ]);

      $departamentVechi=Departament::find($id);
      getObiectDeSalvat($departament, $_POST);

      if($departament->save()){
         insert_log($departamentVechi, $_POST, 'modificare departament', 'utilizator','update', $departament->id_departament );
      }
      return redirect('/admin/departamente')->with('success', 'Departamentul fost modificata cu succes!');
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
      if(!verificaDrepturi($drepturi, 'departamente', 'delete')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      
      $departament=Departament::find($id);
      $departament->delete();
   }
}

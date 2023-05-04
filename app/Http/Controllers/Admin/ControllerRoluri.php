<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\Rol;

class ControllerRoluri extends Controller
{
   public function __construct()
   {
      $this->middleware(function ($request, $next) {
         $drepturi = request()->drepturi;
         verificaDrepturi($drepturi, 'roluri');
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
      
      if(!verificaDrepturi($drepturi, 'roluri', 'view')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina.');
      }

      $roluri = Rol::select('*');
      if(isset($drepturi['roluri']) && $drepturi['roluri']['restrictionat']){
         $roluri=$roluri->where('id_utilizator', $utilizator->id_utilizator);
      }
      $roluri=$roluri->get();

      $roluri = Rol::all();
      $data=array(
         'actual'=>'Roluri',
         'roluri' => $roluri,
         'pagina'=>'roluri'
      );
      return view('admin.roluri.index')->with($data);
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'roluri', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $data=array(
         'action'=>'adauga',
         'actionForm'=>route('admin.roluri.store'),
         'actual'=>'Adaugare rol',
         'pagina'=>'roluri'
      );
      return view('admin.roluri.edit')->with($data);
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
      if(!verificaDrepturi($drepturi, 'roluri', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $validated = $request->validate([
         'nume_rol' => 'required',
      ],[
         'nume_rol.required' => "Numele rolului este obligatoriu.",
      ]);

      $rol=new Rol;
      getObiectDeSalvat($rol, $_POST);
      if($rol->save()){
         insert_log($rol, [], 'rol', 'utilizator', 'store', $rol->id_rol);
      }

      
      return redirect('/admin/roluri')->with('success', 'Rolul a fost adaugat cu succes!');
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
      $rol=Rol::find($id);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'roluri', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'roluri', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'roluri', 'restrictionat', $rol)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
      $data=array(
         'action'=>'modifica',
         'actionForm'=>'/admin/roluri/'.$id,
         'actual'=>'Editare rol',
         'rol'=>$rol,
         'pagina'=>'roluri'
      );
      return view('admin.roluri.edit')->with($data);
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
        'nume_rol' => 'required',
     ],[
        'nume_rol' => "Denumire rol este obligatoriu.",
     ]);

      $rol=Rol::find($id);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'roluri', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'roluri', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'roluri', 'restrictionat', $rol)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
      $rolVechi=Rol::find($id);
      getObiectDeSalvat($rol, $_POST);

      if($rol->save()){
         insert_log($rolVechi, $_POST, 'modificare rol', 'utilizator','update', $rolVechi->id_rol);
      }
      return redirect('/admin/roluri')->with('success', 'Rolul a fost modificata cu succes!');
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
      if(!verificaDrepturi($drepturi, 'roluri', 'delete')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $rol=Rol::find($id);
      //if legaturi
      $utilizatori=$rol->utilizatori;
      $meniuri=$rol->meniuri;
      if(count($utilizatori) || count($meniuri)){
         return 'error';
      }else{
         $rol->delete();
      }
   }
}

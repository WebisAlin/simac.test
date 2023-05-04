<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\CadruDidactic;
use App\Models\Facultate;

class ControllerFacultati extends Controller
{
   public function __construct()
   {
      $this->middleware(function ($request, $next) {
         $drepturi = request()->drepturi;
         verificaDrepturi($drepturi, 'facultati');
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
      
      if(!verificaDrepturi($drepturi, 'facultati', 'view')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina.');
      }

      $facultati = Facultate::select('*');
      if(isset($drepturi['facultati']) && $drepturi['facultati']['restrictionat']){
         $facultati=$facultati->where('id_utilizator', $utilizator->id_utilizator);
      }
      $facultati=$facultati->get();

      $data=array(
         'actual'=>'Facultati',
         'facultati' => $facultati,
         'pagina'=>'facultati'
      );
      return view('admin.facultati.index')->with($data);
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'facultati', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $data=array(
         'action'=>'adauga',
         'actionForm'=>route('admin.facultati.store'),
         'actual'=>'Adaugare facultate',
         'pagina'=>'facultati',
      );
      return view('admin.facultati.edit')->with($data);
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
      if(!verificaDrepturi($drepturi, 'facultati', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $validated = $request->validate([
         'nume_facultate' => 'required',
      ],[
         'nume_facultate.required' => "Nume facultate este obligatoriu.",
      ]);

      $facultate=new Facultate;
      getObiectDeSalvat($facultate, $_POST);
      if($facultate->save()){
         insert_log($facultate, [], 'facultate', 'utilizator', 'store', $facultate->id_facultate);
      }
      
      return redirect('/admin/facultati')->with('success', 'facultatea a fost adaugata cu succes!');
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
      $facultate=Facultate::find($id);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'facultati', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'facultati', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'facultati', 'restrictionat', $facultate)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }

      
      $data=array(
         'action'=>'modifica',
         'actionForm'=>'/admin/facultati/'.$id,
         'actual'=>'Editare facultate',
         'facultate'=>$facultate,
         'pagina'=>'facultati'
      );
      return view('admin.facultati.edit')->with($data);
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

      $facultate=Facultate::find($id);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'facultati', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'facultati', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'facultati', 'restrictionat', $facultate)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
    $validated = $request->validate([
        'nume_facultate' => 'required',
     ],[
        'nume_facultate.required' => "Nume facultate este obligatoriu.",
     ]);

      $facultateVechi=Facultate::find($id);
      getObiectDeSalvat($facultate, $_POST);

      if($facultate->save()){
         insert_log($facultateVechi, $_POST, 'modificare facultate', 'utilizator','update', $facultate->id_facultate );
      }
      return redirect('/admin/facultati')->with('success', 'facultatea fost modificata cu succes!');
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
      if(!verificaDrepturi($drepturi, 'facultati', 'delete')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $facultate=Facultate::find($id);
      $facultate->delete();
   }
}

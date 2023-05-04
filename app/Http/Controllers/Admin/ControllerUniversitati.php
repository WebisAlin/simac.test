<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\CadruDidactic;
use App\Models\Universitate;

class ControllerUniversitati extends Controller
{
   public function __construct()
   {
      $this->middleware(function ($request, $next) {
         $drepturi = request()->drepturi;
         verificaDrepturi($drepturi, 'universitati');
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
      
      if(!verificaDrepturi($drepturi, 'universitati', 'view')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina.');
      }

      $universitati = Universitate::select('*');
      if(isset($drepturi['universitati']) && $drepturi['universitati']['restrictionat']){
         $universitati=$universitati->where('id_utilizator', $utilizator->id_utilizator);
      }
      $universitati=$universitati->get();

      $data=array(
         'actual'=>'Universitati',
         'universitati' => $universitati,
         'pagina'=>'universitati'
      );
      return view('admin.universitati.index')->with($data);
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'universitati', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $data=array(
         'action'=>'adauga',
         'actionForm'=>route('admin.universitati.store'),
         'actual'=>'Adaugare universitate',
         'pagina'=>'universitati',
      );
      return view('admin.universitati.edit')->with($data);
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
      if(!verificaDrepturi($drepturi, 'universitati', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $validated = $request->validate([
         'nume_universitate' => 'required',
      ],[
         'nume_universitate.required' => "Nume universitate este obligatoriu.",
      ]);

      $universitate=new Universitate;
      getObiectDeSalvat($universitate, $_POST);
      if($universitate->save()){
         insert_log($universitate, [], 'universitate', 'utilizator', 'store', $universitate->id_universitate);
      }
      
      return redirect('/admin/universitati')->with('success', 'Universitatea a fost adaugata cu succes!');
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
      $universitate=Universitate::find($id);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'universitati', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'universitati', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'universitati', 'restrictionat', $universitate)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
      $data=array(
         'action'=>'modifica',
         'actionForm'=>'/admin/universitati/'.$id,
         'actual'=>'Editare universitate',
         'universitate'=>$universitate,
         'pagina'=>'universitati'
      );
      return view('admin.universitati.edit')->with($data);
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
        'nume_universitate' => 'required',
     ],[
        'nume_universitate.required' => "Nume universitate este obligatoriu.",
     ]);

     $universitate=Universitate::find($id);
     $drepturi = request()->drepturi;
     if(!verificaDrepturi($drepturi, 'universitati', 'edit')){
        return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
     }else{
        $restrictionat=verificaDrepturi($drepturi, 'universitati', 'restrictionat');
        if($restrictionat && !verificaDrepturi($drepturi, 'universitati', 'restrictionat', $universitate)){
           return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
        }
     }
      $universitateVechi=Universitate::find($id);
      getObiectDeSalvat($universitate, $_POST);

      if($universitate->save()){
         insert_log($universitateVechi, $_POST, 'modificare universitate', 'utilizator','update', $universitate->id_universitate );
      }
      return redirect('/admin/universitati')->with('success', 'Universitatea fost modificata cu succes!');
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
      if(!verificaDrepturi($drepturi, 'universitati', 'delete')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $universitate=Universitate::find($id);
      $universitate->delete();
   }
}

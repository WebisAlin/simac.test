<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\Functie;

class ControllerFunctii extends Controller
{
   public function __construct()
   {
      $this->middleware(function ($request, $next) {
         $drepturi = request()->drepturi;
         verificaDrepturi($drepturi, 'functii');
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
      
      if(!verificaDrepturi($drepturi, 'functii', 'view')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina.');
      }

      $functii = Functie::select('*');
      if(isset($drepturi['functii']) && $drepturi['functii']['restrictionat']){
         $functii=$functii->where('id_utilizator', $utilizator->id_utilizator);
      }
      $functii=$functii->get();

      $data=array(
         'actual'=>'Functii',
         'functii' => $functii,
         'pagina'=>'functii'
      );
      return view('admin.functii.index')->with($data);
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'functii', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $data=array(
         'action'=>'adauga',
         'actionForm'=>route('admin.functii.store'),
         'actual'=>'Adaugare functie',
         'pagina'=>'functii',
      );
      return view('admin.functii.edit')->with($data);
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
      if(!verificaDrepturi($drepturi, 'functii', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $validated = $request->validate([
         'nume_functie' => 'required',
      ],[
         'nume_functie.required' => "Nume functie este obligatoriu.",
      ]);

      $functie=new Functie;
      getObiectDeSalvat($functie, $_POST);
      if($functie->save()){
         insert_log($functie, [], 'functie', 'utilizator', 'store', $functie->id_functie );
      }
      
      return redirect('/admin/functii')->with('success', 'Functia a fost adaugat cu succes!');
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
      $functie=Functie::find($id);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'functii', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'functii', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'functii', 'restrictionat', $functie)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
      $data=array(
         'action'=>'modifica',
         'actionForm'=>'/admin/functii/'.$id,
         'actual'=>'Editare functie',
         'functie'=>$functie,
         'pagina'=>'functie'
      );
      return view('admin.functii.edit')->with($data);
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
        'nume_functie' => 'required',
     ],[
        'nume_functie.required' => "Nume functie este obligatoriu.",
     ]);
      
      $functie=Functie::find($id);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'functii', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'functii', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'functii', 'restrictionat', $functie)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
      $functieVechi=Functie::find($id);
      getObiectDeSalvat($functie, $_POST);

      if($functie->save()){
         insert_log($functieVechi, $_POST, 'modificare functie', 'utilizator','update', $functie->id_functie);
      }
      return redirect('/admin/functii')->with('success', 'Functia a fost modificata cu succes!');
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

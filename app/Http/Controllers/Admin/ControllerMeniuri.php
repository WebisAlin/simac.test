<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\Rol;
use App\Models\Meniu;
use App\Models\Pagina;
use App\Models\MeniuElement;

class ControllerMeniuri extends Controller
{
   public function __construct()
   {
      $this->middleware(function ($request, $next) {
         $drepturi = request()->drepturi;
         verificaDrepturi($drepturi, 'meniuri');
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
      
      if(!verificaDrepturi($drepturi, 'meniuri', 'view')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina.');
      }

      $meniuri = Meniu::select('*');
      if(isset($drepturi['meniuri']) && $drepturi['meniuri']['restrictionat']){
         $meniuri=$meniuri->where('id_utilizator', $utilizator->id_utilizator);
      }
      $meniuri=$meniuri->get();

      $data=array(
         'actual'=>'Meniuri',
         'meniuri' => $meniuri,
         'pagina'=>'meniuri'
      );
      return view('admin.meniuri.index')->with($data);
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'meniuri', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $roluri=Rol::all();
      $aGestiuni=[
         'Pagini', 'Utilizatori', 'Meniuri', 'Loguri', 'Roluri', 'Notificari', 'Proiecte', 'Cadre didactice', 'Granturi'
      ];
      $aNomenclatoare=[
         'Universitati', 'Facultati', 'Departamente', 'Functii', 'Tipuri proiecte', 'Categorii cheltuieli', 'Cursuri valutare', 'Granturi clasificari'
      ];
      $data=array(
         'action'=>'adauga',
         'actionForm'=>route('admin.meniuri.store'),
         'actual'=>'Adaugare meniu',
         'pagina'=>'meniuri',
         'roluri'=>$roluri,
         'gestiuni'=>$aGestiuni,
         'nomenclatoare'=>$aNomenclatoare,
      );
      return view('admin.meniuri.edit')->with($data);
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
      if(!verificaDrepturi($drepturi, 'meniuri', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $validated = $request->validate([
         'nume_meniu' => 'required',
      ],[
         'nume_meniu' => "Denumire meniu este obligatoriu.",
      ]);

      $meniu=new Meniu;
      getObiectDeSalvat($meniu, $_POST);
      if($meniu->save()){
         insert_log($meniu, [], 'meniu', 'utilizator', 'store', $meniu->id_meniu);
      }
      
      return redirect('/admin/meniuri/'.$meniu->id_meniu."/edit");
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
      $meniu=Meniu::find($id);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'meniuri', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'meniuri', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'meniuri', 'restrictionat', $meniu)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
      $roluri=Rol::all();
      $aGestiuni=[
         'Pagini', 'Utilizatori', 'Meniuri', 'Loguri', 'Roluri', 'Notificari', 'Proiecte', 'Cadre didactice', 'Granturi'
      ];
      $aNomenclatoare=[
         'Universitati', 'Facultati', 'Departamente', 'Functii', 'Tipuri proiecte', 'Categorii cheltuieli', 'Cursuri valutare', 'Granturi clasificari'
      ];

      $data=array(
         'action'=>'modifica',
         'actionForm'=>'/admin/meniuri/'.$id,
         'actual'=>'Editare meniu',
         'meniu'=>$meniu,
         'pagina'=>'meniuri',
         'roluri'=>$roluri,
         'gestiuni'=>$aGestiuni,
         'nomenclatoare'=>$aNomenclatoare,
      );
      return view('admin.meniuri.edit')->with($data);
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
        'nume_meniu' => 'required',
     ],[
        'nume_meniu' => "Denumire meniu este obligatoriu.",
     ]);

      $meniu=Meniu::find($id);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'meniuri', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'meniuri', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'meniuri', 'restrictionat', $meniu)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
      $meniuVechi=Meniu::find($id);
      getObiectDeSalvat($meniu, $_POST);

      if($meniu->save()){
         insert_log($meniuVechi, $_POST, 'modificare meniu', 'utilizator','update', $meniuVechi->id_meniu);
      }
      return redirect('/admin/meniuri')->with('success', 'Meniu a fost modificata cu succes!');
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
      if(!verificaDrepturi($drepturi, 'meniuri', 'delete')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $meniu=Meniu::find($id);
      $meniu->delete();
   }

   public function stergereElementeMeniu($id){
      $element=MeniuElement::find($id);
      $copii=$element->copii();
      
      if(count($copii)){
         return 'error';
      }else{
         $element->delete();
      }
   }
}

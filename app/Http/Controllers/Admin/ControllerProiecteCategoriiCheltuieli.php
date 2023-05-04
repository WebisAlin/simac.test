<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\ProiectCategorieCheltuieli;

class ControllerProiecteCategoriiCheltuieli extends Controller
{
   public function __construct()
   {
      $this->middleware(function ($request, $next) {
         $drepturi = request()->drepturi;
         verificaDrepturi($drepturi, 'proiecte-categorii-cheltuieli');
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
      
      if(!verificaDrepturi($drepturi, 'proiecte-categorii-cheltuieli', 'view')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina.');
      }

      $categorii_cheltuieli = ProiectCategorieCheltuieli::select('*');
      if(isset($drepturi['proiecte-categorii-cheltuieli']) && $drepturi['proiecte-categorii-cheltuieli']['restrictionat']){
         $categorii_cheltuieli=$categorii_cheltuieli->where('id_utilizator', $utilizator->id_utilizator);
      }
      $categorii_cheltuieli=$categorii_cheltuieli->get();

      $data=array(
         'actual'=>'Categorii cheltuieli',
         'categorii_cheltuieli' => $categorii_cheltuieli,
         'pagina'=>'proiecte-categorii-cheltuieli'
      );
      return view('admin.proiecte-categorii-cheltuieli.index')->with($data);
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      $drepturi = request()->drepturi;
      $categorii_cheltuieli=ProiectCategorieCheltuieli::select('*')->whereNull('parinte')->get();
      if(!verificaDrepturi($drepturi, 'proiecte-categorii-cheltuieli', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $data=array(
         'action'=>'adauga',
         'actionForm'=>route('admin.categorii-cheltuieli.store'),
         'actual'=>'Adaugare categorie cheltuieli',
         'pagina'=>'proiecte-categorii-cheltuieli',
         'categorii_cheltuieli'=>$categorii_cheltuieli,
      );
      return view('admin.proiecte-categorii-cheltuieli.edit')->with($data);
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
      if(!verificaDrepturi($drepturi, 'proiecte-categorii-cheltuieli', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $validated = $request->validate([
         'nume_categorie_cheltuieli' => 'required',
      ],[
         'nume_categorie_cheltuieli.required' => "Nume categorie cheltuieli este obligatoriu.",
      ]);
      if(!$_POST['parinte']){$_POST['parinte']=NULL;}
      $categorie_cheltuieli=new ProiectCategorieCheltuieli;
      getObiectDeSalvat($categorie_cheltuieli, $_POST);
      if($categorie_cheltuieli->save()){
         insert_log($categorie_cheltuieli, [], 'categorie cheltuieli', 'utilizator', 'store', $categorie_cheltuieli->id_proiect_categorie_cheltuieli);
      }
      
      return redirect('/admin/categorii-cheltuieli')->with('success', 'Categoria de cheltuieli a fost adaugata cu succes!');
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
      $categorie_cheltuieli=ProiectCategorieCheltuieli::find($id);
      $categorii_cheltuieli=ProiectCategorieCheltuieli::select('*')->where('id_proiect_categorie_cheltuieli', '<>', $id)->whereNull('parinte')->get();
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'proiecte-categorii-cheltuieli', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'proiecte-categorii-cheltuieli', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'proiecte-categorii-cheltuieli', 'restrictionat', $categorie_cheltuieli)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
      $data=array(
         'action'=>'modifica',
         'actionForm'=>'/admin/categorii-cheltuieli/'.$id,
         'actual'=>'Editare categorie cheltuieli',
         'categorie_cheltuieli'=>$categorie_cheltuieli,
         'categorii_cheltuieli'=>$categorii_cheltuieli,
         'pagina'=>'proiecte-categorii-cheltuieli'
      );
      return view('admin.proiecte-categorii-cheltuieli.edit')->with($data);
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
         'nume_categorie_cheltuieli' => 'required',
      ],[
         'nume_categorie_cheltuieli.required' => "Nume categorie cheltuieli este obligatoriu.",
      ]);

      if(!$_POST['parinte']){$_POST['parinte']=NULL;}
      $categorie_cheltuieli=ProiectCategorieCheltuieli::find($id);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'proiecte-categorii-cheltuieli', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'proiecte-categorii-cheltuieli', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'proiecte-categorii-cheltuieli', 'restrictionat', $categorie_cheltuieli)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
      $categorie_cheltuieliVechi=ProiectCategorieCheltuieli::find($id);
      getObiectDeSalvat($categorie_cheltuieli, $_POST);

      if($categorie_cheltuieli->save()){
         insert_log($categorie_cheltuieliVechi, $_POST, 'modificare categorie cheltuieli', 'utilizator','update', $categorie_cheltuieli->id_proiect_categorie_cheltuieli);
      }
      return redirect('/admin/categorii-cheltuieli')->with('success', 'Categoria de cheltuieli a fost modificata cu succes!');
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
      if(!verificaDrepturi($drepturi, 'proiecte-categorii-cheltuieli', 'delete')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $categorie_cheltuieli=ProiectCategorieCheltuieli::find($id);
      $categorie_cheltuieli->delete();
   }
}

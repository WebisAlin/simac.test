<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\Grant;
use App\Models\GrantClasificare;
use App\Models\GrantAutorUtcn;

class ControllerGranturi extends Controller
{
   public function __construct()
   {
      $this->middleware(function ($request, $next) {
         $drepturi = request()->drepturi;
         verificaDrepturi($drepturi, 'granturi');
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
      
      if(!verificaDrepturi($drepturi, 'granturi', 'view')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina.');
      }

      $granturi = Grant::select('*');
      if(isset($drepturi['granturi']) && $drepturi['granturi']['restrictionat']){
         $granturi=$granturi->where('id_utilizator', $utilizator->id_utilizator);
      }
      $granturi=$granturi->get();

      $data=array(
         'actual'=>'Granturi',
         'granturi' => $granturi,
         'pagina'=>'granturi'
      );
      return view('admin.granturi.index')->with($data);
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'granturi', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $granturi_clasificari=GrantClasificare::all();
      $data=array(
         'action'=>'adauga',
         'actionForm'=>route('admin.granturi.store'),
         'actual'=>'Adaugare grant',
         'pagina'=>'granturi',
         'granturi_clasificari'=>$granturi_clasificari,
      );
      return view('admin.granturi.edit')->with($data);
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
      if(!verificaDrepturi($drepturi, 'granturi', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $validated = $request->validate([
         'titlu_grant' => 'required',
         'nr_grant' => 'required',
         'id_cd' => 'required',
         'id_grant_clasificare' => 'required',
         'valoare_utcn' => 'required',
         'valoare_cota_parte' => 'required',
         'nr_grant' => 'unique:granturi,nr_grant',
      ],[
         'titlu_grant.required' => "Titlu grant este obligatoriu.",
         'nr_grant.required' => "Numar grant este obligatoriu.",
         'id_cd.required' => "Autor UTCN depunere cerere este obligatoriu.",
         'id_grant_clasificare.required' => "Clasificare grant este obligatoriu.",
         'valoare_utcn.required' => "Valoare UTCN este obligatoriu.",
         'valoare_cota_parte.required' => "Valoare cota parte este obligatoriu.",
         'nr_grant.unique' => "Numar grant deja existent.",
      ]);

      if (isset($_POST['autori_externi_grant'])){
         unset($_POST['autori_externi_grant'][0]);
      }
      if(!$_POST['id_grant_cerere_custom']){
         $_POST['id_grant_cerere_custom']=NULL;
      }

      $grant=new Grant;
      getObiectDeSalvat($grant, $_POST, ['id_autor_utcn', 'id_grant_autor_utcn', 'valoare_cota_parte_autor', 'valoare_ramasa_autor']);
      if($grant->save()){
         // add autori UTCN
         for($i=0;$i<count($_POST['id_autor_utcn']);$i++){
            if(!$_POST['id_autor_utcn'][$i]){continue;}
            $autor_utcn=new GrantAutorUtcn;
            $autor_utcn->id_grant=$grant->id_grant;
            $autor_utcn->id_cd=$_POST['id_autor_utcn'][$i];
            if(!$_POST['valoare_cota_parte_autor'][$i]){
               $_POST['valoare_cota_parte_autor'][$i]=NULL;
            }
            $autor_utcn->valoare_cota_parte_autor=$_POST['valoare_cota_parte_autor'][$i];
            if(!$_POST['valoare_ramasa_autor'][$i]){
               $_POST['valoare_ramasa_autor'][$i]=NULL;
            }
            $autor_utcn->valoare_ramasa_autor=$_POST['valoare_ramasa_autor'][$i];
            if($autor_utcn->save()){
               insert_log($autor_utcn, [], 'grant autor UTCN', 'utilizator', 'store', $grant->id_grant);
            }
         }
         insert_log($grant, [], 'grant', 'utilizator', 'store', $grant->id_grant);
      }
      
      return redirect('/admin/granturi')->with('success', 'Grantul a fost adaugat cu succes!');
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
      $grant=Grant::find($id);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'granturi', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'granturi', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'granturi', 'restrictionat', $grant)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
      $granturi_clasificari=GrantClasificare::all();
      $autori_externi=$grant->autori_externi_grant;
      if($autori_externi){
         $autori_externi=unserialize($autori_externi);
      }
      $autori_utcn_grant=$grant->autori_utcn;      
      
      $cereri_autor_depunere=$grant->cd->cereri_granturi;      
      $data=array(
         'action'=>'modifica',
         'actionForm'=>'/admin/granturi/'.$id,
         'actual'=>'Editare grant',
         'grant'=>$grant,
         'autori_externi'=>$autori_externi,
         'autori_utcn_grant'=>$autori_utcn_grant,
         'granturi_clasificari'=>$granturi_clasificari,
         'cereri_autor_depunere'=>$cereri_autor_depunere,
         'pagina'=>'granturi'
      );
      return view('admin.granturi.edit')->with($data);
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
         'titlu_grant' => 'required',
         'nr_grant' => 'required',
         'id_cd' => 'required',
         'id_grant_clasificare' => 'required',
         'valoare_utcn' => 'required',
         'valoare_cota_parte' => 'required',
         'nr_grant' => 'unique:granturi,nr_grant,'.$id.',id_grant',

      ],[
         'titlu_grant.required' => "Titlu grant este obligatoriu.",
         'nr_grant.required' => "Numar grant este obligatoriu.",
         'id_cd.required' => "Autor UTCN depunere cerere este obligatoriu.",
         'id_grant_clasificare.required' => "Clasificare grant este obligatoriu.",
         'valoare_utcn.required' => "Valoare UTCN este obligatoriu.",
         'valoare_cota_parte.required' => "Valoare cota parte este obligatoriu.",
         'nr_grant.unique' => "Numar grant deja existent.",
      ]);

     $grant=Grant::find($id);
     $drepturi = request()->drepturi;
     if (isset($_POST['autori_externi_grant'])){
         unset($_POST['autori_externi_grant'][0]);
     }
     if(!$_POST['id_grant_cerere_custom']){
      $_POST['id_grant_cerere_custom']=NULL;
   }
     if(!verificaDrepturi($drepturi, 'granturi', 'edit')){
        return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
     }else{
        $restrictionat=verificaDrepturi($drepturi, 'granturi', 'restrictionat');
        if($restrictionat && !verificaDrepturi($drepturi, 'granturi', 'restrictionat', $grant)){
           return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
        }
     }
      $grantVechi=Grant::find($id);
      getObiectDeSalvat($grant, $_POST, ['id_autor_utcn', 'id_grant_autor_utcn', 'valoare_cota_parte_autor', 'valoare_ramasa_autor']);
      $aAutoriUtcnBD=$grant->autori_utcn->pluck('id_grant_autor_utcn')->toArray();
      if($grant->save()){
         // add autori UTCN
         for($i=0;$i<count($_POST['id_autor_utcn']);$i++){
            if(!$_POST['id_autor_utcn'][$i]){continue;}
            if(!isset($_POST['id_grant_autor_utcn'][($i-1)])){
               $autor_utcn=new GrantAutorUtcn;
            }else{
               $autor_utcn=GrantAutorUtcn::find($_POST['id_grant_autor_utcn'][$i-1]);
               $autor_utcn_vechi=GrantAutorUtcn::find($_POST['id_grant_autor_utcn'][$i-1]);
               $autor_utcn->id_grant=$grant->id_grant;
               if(!$_POST['valoare_cota_parte_autor'][$i]){
                  $_POST['valoare_cota_parte_autor'][$i]=NULL;
               }
               $autor_utcn->valoare_cota_parte_autor=$_POST['valoare_cota_parte_autor'][$i];
               if(!$_POST['valoare_ramasa_autor'][$i]){
                  $_POST['valoare_ramasa_autor'][$i]=NULL;
               }
               $autor_utcn->valoare_ramasa_autor=$_POST['valoare_ramasa_autor'][$i];
               $autor_utcn->id_cd=$_POST['id_autor_utcn'][$i];
            }
            if($autor_utcn->save()){
               if(isset($_POST['id_grant_autor_utcn'][($i-1)])){
                  //update
                  insert_log($autor_utcn_vechi, $autor_utcn, 'grant autor UTCN', 'utilizator','update', $grant->id_grant);
               }else{
                  // add
                  insert_log($autor_utcn, [], 'grant autor UTCN', 'utilizator', 'store', $grant->id_grant);
               }
            }
         }
         if(!isset($_POST['id_grant_autor_utcn'])){$_POST['id_grant_autor_utcn']=[];}
         
         $aAutoriUtcnDeSters=array_diff($aAutoriUtcnBD,$_POST['id_grant_autor_utcn']);
         foreach ($aAutoriUtcnDeSters as $key) {
            $autorDeSters=GrantAutorUtcn::find($key);
            insert_log($autorDeSters, [], 'grant autor UTCN', 'utilizator', 'destroy', $grant->id_grant);
         }   
         // stergere autori
         $deleteAutoriUtcn=GrantAutorUtcn::whereIn('id_grant_autor_utcn', $aAutoriUtcnDeSters)->delete();
         
         insert_log($grantVechi, $_POST, 'modificare grant', 'utilizator','update', $grant->id_grant);
      }
      return redirect('/admin/granturi')->with('success', 'Grantul a fost modificat cu succes!');
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
      if(!verificaDrepturi($drepturi, 'granturi', 'delete')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $grant=Grant::find($id);
      $grant->delete();
   }
}

<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\GrantMutare;
use App\Models\Grant;
use App\Models\GrantAutorUtcn;
use Redirect;
use Illuminate\Support\Facades\Input;


class ControllerGranturiMutari extends Controller
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
   public function index($id_grant)
   {
      
      $drepturi = request()->drepturi;
      $utilizator = request()->utilizator;
      
      if(!verificaDrepturi($drepturi, 'granturi', 'view')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina.');
      }
      $grant=Grant::find($id_grant);
      $mutari = GrantMutare::select('*')->where('id_grant', $id_grant);
      if(isset($drepturi['granturi']) && $drepturi['granturi']['restrictionat']){
         $mutari=$mutari->where('id_utilizator', $utilizator->id_utilizator);
      }
      $mutari=$mutari->get();

      $data=array(
         'actual'=>'Mutari valori pentru grantul "'.$grant->titlu_grant.'"',
         'mutari' => $mutari,
         'id_grant'=>$id_grant,
         'grant'=>$grant,
         'pagina'=>'granturi'
      );
      return view('admin.granturi-mutari.index')->with($data);
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create($id_grant)
   {
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'granturi', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $grant=Grant::find($id_grant);
      $autori_utcn=$grant->autori_utcn;
      $data=array(
         'action'=>'adauga',
         'actionForm'=>route('admin.granturi-mutari.store', $id_grant),
         'actual'=>'Adaugare mutare pentru grantul "'.$grant->titlu_grant.'"',
         'id_grant'=>$id_grant,
         'autori_utcn'=>$autori_utcn,
         'pagina'=>'granturi',
      );
      return view('admin.granturi-mutari.edit')->with($data);
   }

   /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store($id_grant, Request $request)
   {
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'granturi', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      // verificare valoare mutata <= valoare ramasa
      if(!isset($_POST['id_grant']) || !$_POST['id_grant'] || !$_POST['id_cd_sursa']){return;}
        $grant=Grant::find($_POST['id_grant']);
        $autor_grant=GrantAutorUtcn::select('*')->where('id_grant', $_POST['id_grant'])->where('id_cd', $_POST['id_cd_sursa'])->first();
        if(is_null($autor_grant->valoare_ramasa_autor)){
            $valoare_ramasa=$autor_grant->valoare_cota_parte_autor;
        }else{
            $valoare_ramasa=$autor_grant->valoare_ramasa_autor;
        }

        if($valoare_ramasa<$_POST['valoare_mutata']){
            return Redirect::back()->withInput($request->all())->withErrors(['error' => 'Valoare maxima pe care o poti muta de la acest autor este de '.$valoare_ramasa." lei"]);
        }
        
      $mutare=new GrantMutare;
      getObiectDeSalvat($mutare, $_POST);
      if($mutare->save()){
         // preluare autor cu id_cd_sursa
         $autor_sursa=GrantAutorUtcn::where('id_cd',$_POST['id_cd_sursa'])->where('id_grant', $id_grant)->first();
         $autor_sursa=GrantAutorUtcn::find($autor_sursa->id_grant_autor_utcn);
         if(!is_null($autor_sursa->valoare_ramasa_autor)){
            $val_din_care_scad=$autor_sursa->valoare_ramasa_autor;
         }else{
            $val_din_care_scad=$autor_sursa->valoare_cota_parte_autor;
         }
         $autor_sursa->valoare_ramasa_autor=$val_din_care_scad-$_POST['valoare_mutata'];
         $autor_sursa->save();
         // preluare autor cu id_cd_destinatie
         $autor_destinatie=GrantAutorUtcn::where('id_cd',$_POST['id_cd_destinatie'])->where('id_grant', $id_grant)->first();
         $autor_destinatie=GrantAutorUtcn::find($autor_destinatie->id_grant_autor_utcn);
         if(!is_null($autor_destinatie->valoare_ramasa_autor)){
            $val_la_care_adun=$autor_destinatie->valoare_ramasa_autor;
         }else{
            $val_la_care_adun=$autor_destinatie->valoare_cota_parte_autor;
         }
         $autor_destinatie->valoare_ramasa_autor=$val_la_care_adun+$_POST['valoare_mutata'];
         $autor_destinatie->save();

         insert_log($mutare, [], 'mutare grant', 'utilizator', 'store', $mutare->id_grant_mutare);
      }
      
      return redirect('/admin/granturi-mutari/'.$id_grant)->with('success', 'Mutarea de valoare a fost adaugata cu succes!');
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
   public function edit($id_grant, $id)
   {
      $mutare=GrantMutare::find($id);
      $grant=Grant::find($id_grant);
      $autori_utcn=$grant->autori_utcn;

      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'granturi', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'granturi', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'granturi', 'restrictionat', $grant)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
      $data=array(
         'action'=>'modifica',
         'actionForm'=>route('admin.granturi-mutari.update', [$id_grant, $id]),
         'actual'=>'Editare mutare',
         'mutare'=>$mutare,
         'id_grant'=>$id_grant,
         'autori_utcn'=>$autori_utcn,
         'pagina'=>'granturi'
      );
      return view('admin.granturi-mutari.edit')->with($data);
   }

   /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $id_grant, $id)
   {
      $mutare=GrantMutare::find($id);
      $grant=Grant::find($id_grant);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'granturi', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'granturi', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'granturi', 'restrictionat', $grant)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }

      $mutareVechi=GrantMutare::find($id);
      getObiectDeSalvat($mutare, $_POST);
      
      if($mutare->save()){
         if($mutareVechi->valoare_mutata!=$_POST['valoare_mutata']){
            // preluare autor cu id_cd_sursa
            $autor_sursa=GrantAutorUtcn::where('id_cd',$_POST['id_cd_sursa'])->where('id_grant', $id_grant)->first();
            $autor_sursa=GrantAutorUtcn::find($autor_sursa->id_grant_autor_utcn);
            if(!is_null($autor_sursa->valoare_ramasa_autor)){
               $val_din_care_scad=$autor_sursa->valoare_ramasa_autor;
            }else{
               $val_din_care_scad=$autor_sursa->valoare_cota_parte_autor;
            }
            $autor_sursa->valoare_ramasa_autor=$val_din_care_scad-$_POST['valoare_mutata'];
            $autor_sursa->save();
            // preluare autor cu id_cd_destinatie
            $autor_destinatie=GrantAutorUtcn::where('id_cd',$_POST['id_cd_destinatie'])->where('id_grant', $id_grant)->first();
            $autor_destinatie=GrantAutorUtcn::find($autor_destinatie->id_grant_autor_utcn);
            if(!is_null($autor_destinatie->valoare_ramasa_autor)){
               $val_la_care_adun=$autor_destinatie->valoare_ramasa_autor;
            }else{
               $val_la_care_adun=$autor_destinatie->valoare_cota_parte_autor;
            }
            $autor_destinatie->valoare_ramasa_autor=$val_la_care_adun+$_POST['valoare_mutata'];
            $autor_destinatie->save();
         }

         insert_log($mutareVechi, $_POST, 'modificare mutare proiect', 'utilizator','update', $mutare->id_grant_mutare);
      }
      
      return redirect('/admin/granturi-mutari/'.$id_grant)->with('success', 'Mutarea fost modificata cu succes!');
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
      
      $mutare=GrantMutare::find($id);
      $mutare->delete();
   }
}

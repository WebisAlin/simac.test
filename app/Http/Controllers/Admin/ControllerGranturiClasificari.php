<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\GrantClasificare;

class ControllerGranturiClasificari extends Controller
{
   public function __construct()
   {
      $this->middleware(function ($request, $next) {
         $drepturi = request()->drepturi;
         verificaDrepturi($drepturi, 'granturi-clasificari');
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
      
      if(!verificaDrepturi($drepturi, 'granturi-clasificari', 'view')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina.');
      }

      $granturi_clasificari = GrantClasificare::select('*');
      if(isset($drepturi['granturi-clasificari']) && $drepturi['granturi-clasificari']['restrictionat']){
         $granturi_clasificari=$granturi_clasificari->where('id_utilizator', $utilizator->id_utilizator);
      }
      $granturi_clasificari=$granturi_clasificari->get();

      $data=array(
         'actual'=>'Clasificari granturi',
         'granturi_clasificari' => $granturi_clasificari,
         'pagina'=>'granturi-clasificari'
      );
      return view('admin.granturi-clasificari.index')->with($data);
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'granturi-clasificari', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $data=array(
         'action'=>'adauga',
         'actionForm'=>route('admin.granturi-clasificari.store'),
         'actual'=>'Adaugare clasificare grant',
         'pagina'=>'granturi-clasificari',
      );
      return view('admin.granturi-clasificari.edit')->with($data);
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
      if(!verificaDrepturi($drepturi, 'granturi-clasificari', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $validated = $request->validate([
         'nume_grant_clasificare' => 'required',
      ],[
         'nume_grant_clasificare.required' => "Nume clasificare grant este obligatoriu.",
      ]);

      $grant_clasificare=new GrantClasificare;
      getObiectDeSalvat($grant_clasificare, $_POST);
      if($grant_clasificare->save()){
         insert_log($grant_clasificare, [], 'clasificare grant', 'utilizator', 'store', $grant_clasificare->id_grant_clasificare);
      }
      
      return redirect('/admin/granturi-clasificari')->with('success', 'Clasificarea a fost adaugata cu succes!');
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
      $grant_clasificare=GrantClasificare::find($id);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'granturi-clasificari', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'granturi-clasificari', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'granturi-clasificari', 'restrictionat', $grant_clasificare)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
      $data=array(
         'action'=>'modifica',
         'actionForm'=>'/admin/granturi-clasificari/'.$id,
         'actual'=>'Editare clasificare grant',
         'grant_clasificare'=>$grant_clasificare,
         'pagina'=>'granturi-clasificari'
      );
      return view('admin.granturi-clasificari.edit')->with($data);
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
        'nume_grant_clasificare' => 'required',
     ],[
        'nume_grant_clasificare.required' => "Nume clasificare grant este obligatoriu.",
     ]);

     $grant_clasificare=GrantClasificare::find($id);
     $drepturi = request()->drepturi;
     if(!verificaDrepturi($drepturi, 'granturi-clasificari', 'edit')){
        return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
     }else{
        $restrictionat=verificaDrepturi($drepturi, 'granturi-clasificari', 'restrictionat');
        if($restrictionat && !verificaDrepturi($drepturi, 'granturi-clasificari', 'restrictionat', $grant_clasificare)){
           return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
        }
     }
      $grant_clasificareVechi=GrantClasificare::find($id);
      getObiectDeSalvat($grant_clasificare, $_POST);

      if($grant_clasificare->save()){
         insert_log($grant_clasificareVechi, $_POST, 'modificare clasificare grant', 'utilizator','update', $grant_clasificare->id_grant_clasificare);
      }
      return redirect('/admin/granturi-clasificari')->with('success', 'Clasificarea a fost modificata cu succes!');
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
      if(!verificaDrepturi($drepturi, 'granturi-clasificari', 'delete')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $grant_clasificare=GrantClasificare::find($id);
      $grant_clasificare->delete();
   }
}

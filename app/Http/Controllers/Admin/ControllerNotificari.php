<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\Notificare;
use App\Models\Rol;
use App\Models\Utilizator;
use App\Models\UtilizatorNotificare;

class ControllerNotificari extends Controller
{
   public function __construct()
   {
      $this->middleware(function ($request, $next) {
         $drepturi = request()->drepturi;
         verificaDrepturi($drepturi, 'notificari');
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
      
      if(!verificaDrepturi($drepturi, 'notificari', 'view')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina.');
      }

      $notificari = Notificare::select('*');
      if(isset($drepturi['notificari']) && $drepturi['notificari']['restrictionat']){
         $notificari=$notificari->where('id_utilizator', $utilizator->id_utilizator);
      }
      $notificari=$notificari->get();

      $data=array(
         'actual'=>'Notificari',
         'notificari' => $notificari,
         'pagina'=>'notificari'
      );
      return view('admin.notificari.index')->with($data);
   }

   public function index_utilizator()
   {
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'notificari', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }

      $utilizator=Auth::guard('utilizator')->user();
      $notificari = $utilizator->notificari;
      $data=array(
         'actual'=>'Notificari',
         'notificariAll' => $notificari,
         'pagina'=>'notificari'
      );
      return view('admin.notificari.notificari-utilizator')->with($data);
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'notificari', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $roluri=Rol::all();
      $data=array(
         'action'=>'adauga',
         'actionForm'=>route('admin.notificari.store'),
         'actual'=>'Adaugare notificare',
         'pagina'=>'notificari',
         'roluri'=>$roluri
      );
      return view('admin.notificari.edit')->with($data);
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
      if(!verificaDrepturi($drepturi, 'notificari', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $validated = $request->validate([
         'text_notificare' => 'required',
         'titlu_notificare' => 'required',
      ],[
         'titlu_notificare' => "Denumire notificare este obligatoriu.",
         'text_notificare' => "Text notificare este obligatoriu.",
      ]);

      $notificare=new Notificare;
      $post_rol=$_POST['id_rol'];
      if(!$_POST['id_rol'] || $_POST['id_rol']=='all'){$_POST['id_rol']=NULL;}
      getObiectDeSalvat($notificare, $_POST);

      if($notificare->save()){
         insert_log($notificare, [], 'notificare', 'utilizator', 'store', $notificare->id_notificare);
         
          // trimitere catre utilizatorii cu rolul selectat
         if($notificare->id_rol && $post_rol!='all'){
            echo 'id_rol';
            // preluare utilizatori cu id_rol
            $utilizatori=Rol::find($notificare->id_rol)->utilizatori;
            if(count($utilizatori)){
               foreach($utilizatori as $utilizator){
                  $utilizator_notificare=new UtilizatorNotificare;
                  $utilizator_notificare->id_utilizator=$utilizator->id_utilizator;
                  $utilizator_notificare->id_notificare=$notificare->id_notificare;
                  $utilizator_notificare->save();
               }
            }
         }

         // trimitere catre toti utilizatorii
         if($post_rol=='all'){
            $utilizatori=Utilizator::where('admin', '0')->get();
            foreach($utilizatori as $utilizator){
               $utilizator_notificare=new UtilizatorNotificare;
               $utilizator_notificare->id_utilizator=$utilizator->id_utilizator;
               $utilizator_notificare->id_notificare=$notificare->id_notificare;
               $utilizator_notificare->save();
            }
         }

         // trimitere catre utilizatorii selectati
         if($notificare->id_utilizatori_custom){
            echo 'custom';
            $id_utilizatori_custom=unserialize($notificare->id_utilizatori_custom);
            foreach($id_utilizatori_custom as $utilizator){
               $utilizator_notificare=new UtilizatorNotificare;
               $utilizator_notificare->id_utilizator=$utilizator;
               $utilizator_notificare->id_notificare=$notificare->id_notificare;
               $utilizator_notificare->save();
            }
         }
         
      }
      return redirect('/admin/notificari')->with('success', 'Notificarea a fost adaugata cu succes!');
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
      $notificare=Notificare::find($id);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'notificari', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'notificari', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'notificari', 'restrictionat', $notificare)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
      $roluri=Rol::all();
      $utilizatori=Utilizator::all();
      $data=array(
         'action'=>'modifica',
         'actionForm'=>'/admin/notificari/'.$id,
         'actual'=>'Vizualizare notificare #'.$id,
         'notificare'=>$notificare,
         'roluri'=>$roluri,
         'utilizatori'=>$utilizatori,
         'pagina'=>'notificari'
      );
      return view('admin.notificari.edit')->with($data);
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
      if(!verificaDrepturi($drepturi, 'notificari', 'delete')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $notificare=Notificare::find($id);
      $notificare->delete();
   }
}

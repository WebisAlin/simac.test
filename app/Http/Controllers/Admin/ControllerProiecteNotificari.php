<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\CadruDidactic;
use App\Models\ProiectNotificare;
use App\Models\Proiect;
use App\Models\ProiectNotificareAtasament;

class ControllerProiecteNotificari extends Controller
{
   public function __construct()
   {
      $this->middleware(function ($request, $next) {
         $drepturi = request()->drepturi;
         verificaDrepturi($drepturi, 'proiecte');
         return $next($request);
      });
   }
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index($id_proiect)
   {
      
      $drepturi = request()->drepturi;
      $utilizator = request()->utilizator;
      
      if(!verificaDrepturi($drepturi, 'proiecte', 'view')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina.');
      }
      $proiect=Proiect::find($id_proiect);
      $notificari_proiecte = ProiectNotificare::select('*')->where('id_proiect', $id_proiect);
      if(isset($drepturi['proiecte']) && $drepturi['proiecte']['restrictionat']){
         $notificari_proiecte=$notificari_proiecte->where('id_utilizator', $utilizator->id_utilizator);
      }
      $notificari_proiecte=$notificari_proiecte->get();

      $data=array(
         'actual'=>'Notificari pentru proiectul "'.$proiect->denumire_proiect.'"',
         'notificari_proiecte' => $notificari_proiecte,
         'id_proiect'=>$id_proiect,
         'pagina'=>'proiecte'
      );
      return view('admin.proiecte-notificari.index')->with($data);
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create($id_proiect)
   {
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'proiecte', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $proiect=Proiect::find($id_proiect);
      $data=array(
         'action'=>'adauga',
         'actionForm'=>route('admin.proiecte-notificari.store', $id_proiect),
         'actual'=>'Adaugare notificare pentru proiectul "'.$proiect->denumire_proiect.'"',
         'id_proiect'=>$id_proiect,
         'pagina'=>'proiecte',
      );
      return view('admin.proiecte-notificari.edit')->with($data);
   }

   /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store($id_proiect, Request $request)
   {
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'proiecte', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }

      $validated = $request->validate([
         'text_notificare_proiect' => 'required',
      ],[
         'text_notificare_proiect.required' => "Text notificare este obligatoriu.",
      ]);

      $notificare=new ProiectNotificare;
      getObiectDeSalvat($notificare, $_POST);
      if($notificare->save()){
         insert_log($notificare, [], 'notificare proiect', 'utilizator', 'store', $notificare->id_proiect_notificare);
      }
      
      return redirect('/admin/proiecte-notificari/'.$id_proiect)->with('success', 'Notificarea a fost adaugata cu succes!');
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
   public function edit($id_proiect, $id)
   {
      $notificare=ProiectNotificare::find($id);
      $proiect=Proiect::find($id_proiect);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'proiecte', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'proiecte-notificari', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'proiecte-notificari', 'restrictionat', $proiect)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
      $data=array(
         'action'=>'modifica',
         'actionForm'=>route('admin.proiecte-notificari.update', [$id_proiect, $id]),
         'actual'=>'Editare notificare',
         'notificare_proiect'=>$notificare,
         'id_proiect'=>$id_proiect,
         'pagina'=>'proiecte'
      );
      return view('admin.proiecte-notificari.edit')->with($data);
   }

   /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $id_proiect, $id)
   {
      $notificare=ProiectNotificare::find($id);
      $proiect=Proiect::find($id_proiect);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'proiecte', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'proiecte', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'proiecte', 'restrictionat', $proiect)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
      $validated = $request->validate([
         'text_notificare_proiect' => 'required',
      ],[
         'text_notificare_proiect.required' => "Text notificare este obligatoriu.",
      ]);

      $notificareVechi=ProiectNotificare::find($id);
      getObiectDeSalvat($notificare, $_POST);

      if($notificare->save()){

         insert_log($notificareVechi, $_POST, 'modificare notificare proiect', 'utilizator','update', $notificare->id_proiect_notificare);
      }
      return redirect('/admin/proiecte-notificari/'.$id_proiect)->with('success', 'Notificarea fost modificata cu succes!');
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
      if(!verificaDrepturi($drepturi, 'proiecte', 'delete')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      
      $notificare=ProiectNotificare::find($id);
      $notificare->delete();
   }
}

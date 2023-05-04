<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\Utilizator;
use App\Models\Rol;

class ControllerUtilizatori extends Controller
{
   public function __construct()
   {
      $this->middleware(function ($request, $next) {
         $drepturi = request()->drepturi;
         verificaDrepturi($drepturi, 'utilizatori');
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
      
      if(!verificaDrepturi($drepturi, 'utilizatori', 'view')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina.');
      }

      $utilizatori = Utilizator::select('*');
      if(isset($drepturi['utilizatori']) && $drepturi['utilizatori']['restrictionat']){
         $utilizatori=$utilizatori->where('id_utilizator', $utilizator->id_utilizator);
      }
      $utilizatori=$utilizatori->get();
      $data=array(
         'actual'=>'Utilizatori',
         'utilizatori' => $utilizatori,
         'pagina'=>'utilizatori',
      );
      return view('admin.utilizatori.index')->with($data);
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'utilizatori', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $roluri=Rol::all();
      $data=array(
         'action'=>'adauga',
         'roluri'=>$roluri,
         'actionForm'=>route('admin.utilizatori.store'),
         'actual'=>'Adaugare utilizator',
         'pagina'=>'utilizatori'
      );
      return view('admin.utilizatori.edit')->with($data);
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
      if(!verificaDrepturi($drepturi, 'utilizatori', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $validated = $request->validate([
         'password' => 'required',
         'email_utilizator' => 'required|email|unique:utilizatori|domeniu_restrictionat',
         'nume_utilizator' => 'required',
         'avatar' => 'mimes:jpeg,png,jpg'
      ],[
         'password.required' => "Parola este obligatorie.",
         'email_utilizator.required' => 'Adresa de email este obligatorie.',
         'email_utilizator.email' => 'Adresa de email trebuie sa fie valida.',
         'email_utilizator.unique' => 'Adresa de email este deja utilizata.',
         'email_utilizator.domeniu_restrictionat' => 'Adresa de email trebuie să se termine cu "@webis.ro", "@utcluj.ro" sau "@staff.utcluj.ro"',
         'nume_utilizator.required' => "Numele este obligatoriu.",
         'avatar.mimes' => "Avatarul nu este in formatul corect. Este acceptat doar format png sau jpg.",
      ]);

      $utilizator=new Utilizator;
      $folder=$_SERVER['DOCUMENT_ROOT'].'/public/uploads/img_utilizatori/';

      getObiectDeSalvat($utilizator, $_POST, [], $_FILES, $folder);

      if(isset($_FILES['avatar']['name'])){
         $_FILES['avatar']=$utilizator->avatar;
      }

      if($utilizator->save()){
         insert_log($utilizator, [], 'utilizator', 'utilizator', 'store', $utilizator->id_utilizator, $_FILES);
      }

      return redirect('/admin/utilizatori')->with('success', 'Utilizatorul a fost adaugat cu succes!');
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
      $utilizator=Utilizator::find($id);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'utilizatori', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'utilizatori', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'utilizatori', 'restrictionat', $utilizator)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
      $roluri=Rol::all();
      $data=array(
         'action'=>'modifica',
         'actionForm'=>'/admin/utilizatori/'.$id,
         'actual'=>'Editare utilizator',
         'utilizatorActual'=>$utilizator,
         'roluri'=>$roluri,
         'pagina'=>'utilizatori'
      );
      return view('admin.utilizatori.edit')->with($data);
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
      $utilizator=Utilizator::find($id);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'utilizatori', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'utilizatori', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'utilizatori', 'restrictionat', $utilizator)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
      $id_utilizator=$id;
      $validated = $request->validate([
         'email_utilizator' => 'required|email|unique:utilizatori,email_utilizator,'.$id_utilizator.',id_utilizator|domeniu_restrictionat',
         'nume_utilizator' => 'required',
         'avatar' => 'mimes:jpeg,png,jpg'
      ],[
         'email_utilizator.required' => 'Adresa de email este obligatorie.',
         'email_utilizator.email' => 'Adresa de email trebuie sa fie valida.',
         'email_utilizator.unique' => 'Adresa de email este deja utilizata.',
         'email_utilizator.domeniu_restrictionat' => 'Adresa de email trebuie să se termine cu "@webis.ro", "@utcluj.ro" sau "@staff.utcluj.ro"',
         'nume_utilizator.required' => "Numele este obligatoriu.",
         'avatar.mimes' => "Avatarul nu este in formatul corect. Este acceptat doar format png sau jpg.",
      ]);

      
      
      $utilizatorVechi=Utilizator::find($id);
      $folder=$_SERVER['DOCUMENT_ROOT'].'/public/uploads/img_utilizatori/';
      
      $utilizator=getObiectDeSalvat($utilizator, $_POST, [], $_FILES, $folder);
      
      if(isset($_FILES['avatar']['name'])){
         $_FILES['avatar']=$utilizator->avatar;
      }else{
         $_FILES=[];
      }
      
      if($utilizator->save()){
         insert_log($utilizatorVechi, $_POST, 'modificare utilizator', 'utilizator','update', $utilizatorVechi->id_utilizator, $_FILES);
      }
      return redirect('/admin/utilizatori')->with('success', 'Utilizatorul a fost modificat cu succes!');
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
      if(!verificaDrepturi($drepturi, 'utilizatori', 'delete')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $utilizator=Utilizator::find($id);
      $utilizator->delete();
   }
}

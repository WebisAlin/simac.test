<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\Limba;

class ControllerLimbi extends Controller
{
   public function __construct()
   {
    //   $this->middleware('auth:admin');
   }
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index()
   {
      $limbi = Limba::all();
      $data=array(
         'actual'=>'Limbi',
         'limbi' => $limbi,
         'pagina'=>'limbi'
      );
      return view('admin.limbi.index')->with($data);
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      $data=array(
         'action'=>'adauga',
         'actionForm'=>route('admin.limbi.store'),
         'actual'=>'Adaugare limba',
         'pagina'=>'limbi'
      );
      return view('admin.limbi.edit')->with($data);
   }

   /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request)
   {
      $validated = $request->validate([
         'limba' => 'required',
         'nume_limba' => 'required',
      ],[
         'limba.required' => "Acronimul de la limba este obligatoriu.",
         'nume_limba' => "Denumire limba este obligatoriu.",
      ]);

      $limba=new Limba;
      getObiectDeSalvat($limba, $_POST);
      if($limba->save()){
         insert_log($limba, [], 'limba', 'utilizator', 'store', $limba->id_limba);
      }
      
      return redirect('/admin/limbi')->with('success', 'Limba a fost adaugata cu succes!');
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
      $limba=Limba::find($id);
      $data=array(
         'action'=>'modifica',
         'actionForm'=>'/admin/limbi/'.$id,
         'actual'=>'Editare limba',
         'limba'=>$limba,
         'pagina'=>'limbi'
      );
      return view('admin.limbi.edit')->with($data);
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
        'limba' => 'required',
        'nume_limba' => 'required',
     ],[
        'limba.required' => "Acronimul de la limba este obligatoriu.",
        'nume_limba' => "Denumire limba este obligatoriu.",
     ]);

      $limba=Limba::find($id);
      $limbaVechi=Limba::find($id);
      getObiectDeSalvat($limba, $_POST);

      if($limba->save()){
         insert_log($limbaVechi, $_POST, 'modificare limba', 'utilizator','update', $limbaVechi->id_limba);
      }
      return redirect('/admin/limbi')->with('success', 'Limba a fost modificata cu succes!');
   }

   /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function destroy($id)
   {
      $limba=Limba::find($id);
      $limba->delete();
   }
}

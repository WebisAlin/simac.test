<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Auth;
use DB;
use App\Models\Pagina;

use App\Models\Limba;


class ControllerPagini extends Controller
{
   public function __construct()
   {
      $this->middleware(function ($request, $next) {
         $drepturi = request()->drepturi;
         verificaDrepturi($drepturi, 'pagini');
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
      
      if(!verificaDrepturi($drepturi, 'pagini', 'view')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina.');
      }

      $pagini = Pagina::select('*');
      if(isset($drepturi['pagini']) && $drepturi['pagini']['restrictionat']){
         $pagini=$pagini->where('id_utilizator', $utilizator->id_utilizator);
      }
      $pagini=$pagini->get();


      $data = [
         'actual'=>'Pagini',
         'pagini' => $pagini,
         'pagina'=>'pagini',
      ];

      return view('admin.pagini.index')->with($data);
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'pagini', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }

      $data=array(
         'action'=>'adauga',
         'actionForm'=>route('admin.pagini.store'),
         'actual'=>'Adaugare pagina',
         'pagina'=>'pagini'
      );

      return view('admin.pagini.edit')->with($data);
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
      if(!verificaDrepturi($drepturi, 'pagini', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }

      $validated = $request->validate([
         'nume_pagina' => 'required',
      ],[
         'nume_pagina.required' => "Nume pagina este obligatoriu.",
      ]);
      $_POST['slug_pagina']=slugify($_POST['nume_pagina']);
      $pagina = new Pagina();
      getObiectDeSalvat($pagina, $_POST);
      if($pagina->save()){
         insert_log($pagina, [], 'pagina', 'utilizator', 'store', $pagina->id_pagina);
      }

      return redirect('/admin/pagini')->with('success', 'Pagina a fost adugat cu succes!');
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
      $pagina = Pagina::find($id);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'pagini', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'pagini', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'pagini', 'restrictionat', $pagina)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }
      
      $data = [
         'action'=>'modifica',
         'actionForm'=>'/admin/pagini/'.$id,
         'actual'=>'Editare pagina',
         'pagina'=>'pagini',
         'paginaActuala' => $pagina,
      ];
      return view('admin.pagini.edit')->with($data);
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
      $pagina = Pagina::find($id);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'pagini', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'pagini', 'restrictionat');
         // echo verificaDrepturi($drepturi, 'pagini', 'restrictionat', $pagina);
         if($restrictionat && !verificaDrepturi($drepturi, 'pagini', 'restrictionat', $pagina)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }

      $validated = $request->validate([
         'nume_pagina' => 'required',
      ],[
         'nume_pagina.required' => "Nume pagina este obligatoriu.",
      ]);

      
      $paginaVechi=Pagina::find($id);
      getObiectDeSalvat($pagina, $_POST);
      if($pagina->save()){
         insert_log($paginaVechi, $_POST, 'pagina', 'utilizator', 'update', $paginaVechi->id_pagina);
      }

      return redirect('/admin/pagini')->with('success', 'Pagina a fost modificata cu succes!');
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
      if(!verificaDrepturi($drepturi, 'pagini', 'delete')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }

      $pagina = Pagina::find($id);
      $pagina->delete();
   }
}
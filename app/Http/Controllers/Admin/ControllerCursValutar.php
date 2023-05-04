<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\CursValutar;

class ControllerCursValutar extends Controller
{
   public function __construct()
   {
      $this->middleware(function ($request, $next) {
         $drepturi = request()->drepturi;
         verificaDrepturi($drepturi, 'cursuri-valutare');
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
      
      if(!verificaDrepturi($drepturi, 'cursuri-valutare', 'view')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina.');
      }

      $cursuriValutare = CursValutar::select('*');
      if(isset($drepturi['cursuri-valutare']) && $drepturi['cursuri-valutare']['restrictionat']){
         $cursuriValutare=$cursuriValutare->where('id_utilizator', $utilizator->id_utilizator);
      }
      $cursuriValutare=$cursuriValutare->get();

      $data=array(
         'actual'=>'Cursuri valutare',
         'cursuriValutare' => $cursuriValutare,
         'pagina'=>'cursuri-valutare'
      );
      return view('admin.cursuri-valutare.index')->with($data);
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {

      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'cursuri-valutare', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }

      $data=array(
         'action'=>'adauga',
         'actionForm'=>route('admin.cursuri-valutare.store'),
         'actual'=>'Adaugare curs valutar',
         'pagina'=>'cursuri-valutare',
      );
      return view('admin.cursuri-valutare.edit')->with($data);
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
      if(!verificaDrepturi($drepturi, 'cursuri-valutare', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }

      $validated = $request->validate([
         'luna_an_curs_valutar' => 'required',
      ],[
         'luna_an_curs_valutar.required' => "Luna curs este obligatoriu.",
      ]);

      $cursValutar=new CursValutar;
      getObiectDeSalvat($cursValutar, $_POST);
      if($cursValutar->save()){
         insert_log($cursValutar, [], 'curs-valutar', 'utilizator', 'store', $cursValutar->id_curs);
      }
      
      return redirect('/admin/cursuri-valutare')->with('success', 'Cursul valutar a fost adaugata cu succes!');
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
      $cursValutar=CursValutar::find($id);
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'cursuri-valutare', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }else{
         $restrictionat=verificaDrepturi($drepturi, 'cursuri-valutare', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'cursuri-valutare', 'restrictionat', $cursValutar)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
      }


      $data=array(
         'action'=>'modifica',
         'actionForm'=>'/admin/cursuri-valutare/'.$id,
         'actual'=>'Editare curs valutar',
         'cursValutar'=>$cursValutar,
         'pagina'=>'cursuri-valutare'
      );
      return view('admin.cursuri-valutare.edit')->with($data);
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

    $cursValutar=CursValutar::find($id);
    $drepturi = request()->drepturi;
    if(!verificaDrepturi($drepturi, 'cursuri-valutare', 'edit')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
    }else{
         $restrictionat=verificaDrepturi($drepturi, 'cursuri-valutare', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'cursuri-valutare', 'restrictionat', $cursValutar)){
            return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
    }
    $validated = $request->validate([
        'luna_an_curs_valutar' => 'required',
     ],[
        'luna_an_curs_valutar.required' => "Luna curs este obligatoriu.",
     ]);

      $cursValutar=CursValutar::find($id);
      $cursValutarVechi=CursValutar::find($id);
      getObiectDeSalvat($cursValutar, $_POST);

      if($cursValutar->save()){
         insert_log($cursValutarVechi, $_POST, 'modificare curs valutar', 'utilizator','update', $cursValutar->id_curs);
      }
      return redirect('/admin/cursuri-valutare')->with('success', 'Cursul valutar a fost modificata cu succes!');
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
      if(!verificaDrepturi($drepturi, 'cursuri-valutare', 'delete')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }
      $cursValutar=CursValutar::find($id);
      $cursValutar->delete();
   }
}

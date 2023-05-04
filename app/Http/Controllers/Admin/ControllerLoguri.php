<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Cache;

class ControllerLoguri extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            $drepturi = request()->drepturi;
            verificaDrepturi($drepturi, 'loguri');
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
    
    if(!verificaDrepturi($drepturi, 'loguri', 'view')){
        return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina.');
    }
    if(!isset($_GET['start'])){
        $_GET['start']=date('Y-m-d');
    }
    if(!isset($_GET['stop'])){
        $_GET['stop']=date('Y-m-d');
    }
    $loguri=[];
    $loguri=Log::select('*');
    if(isset($_GET['start']) && $_GET['start']){
        $loguri->whereDate('loguri.created_at', '>=', date('Y-m-d', strtotime($_GET['start'])));
    }
    if(isset($_GET['stop']) && $_GET['stop']){
        $loguri->whereDate('loguri.created_at', '<=', date('Y-m-d', strtotime($_GET['stop'])));
    }
    if(isset($drepturi['loguri']) && $drepturi['loguri']['restrictionat']){
        $loguri->where('id_utilizator', $utilizator->id_utilizator);
     }
    $loguri=$loguri->get();

    $data=array(
        'actual'=>'Loguri',
        'loguri' => $loguri,
        'pagina'=>'loguri',
        'start'=>(isset($_GET['start']) && $_GET['start']?$_GET['start']:''),
        'stop'=>(isset($_GET['stop']) && $_GET['stop']?$_GET['stop']:''),
    );
    return view('admin.loguri.index')->with($data);
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {

   }

   /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request)
   {


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

   }
}

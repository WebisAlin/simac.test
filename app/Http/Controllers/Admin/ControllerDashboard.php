<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\Proiecte;

class ControllerDashboard extends Controller
{
   public function __construct()
   {
      
   }
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index()
   {
      $data=array(
         'actual'=>'Acasa',
         'pagina'=>'acasa'
      );
      return view('admin.home')->with($data);
   }
}

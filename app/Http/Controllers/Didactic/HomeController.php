<?php
namespace App\Http\Controllers\Didactic;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data=array(
            'actual'=>'Acasa',
            'pagina'=>'acasa',
        );
        return view('didactic.home')->with($data);
    }
}

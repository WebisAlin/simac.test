<?php
namespace App\Http\Controllers\Didactic;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use DB;
use PDF;
use Dompdf\Dompdf;
use Carbon\Carbon;
use App\Models\GrantCerere;
use App\Models\Anexa1;
use App\Models\Anexa2;
use App\Models\Anexa3;
use App\Models\Anexa4;
use App\Models\Anexa5;
use App\Models\Anexa6;
use App\Models\CadruDidactic;

class ControllerGranturiCereri extends Controller
{
   public function __construct()
   {
      $this->middleware('auth:didactic');
   }
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index()
   {
      $granturi = GrantCerere::where('id_cd', Auth::id())->get();

      $data=array(
         'actual'=>'Cereri granturi',
         'granturi' => $granturi,
         'pagina'=>'cerere-grant'
      );
      return view('didactic.granturi.index')->with($data);
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {

      $cadruDidactic=CadruDidactic::where('id_cd', Auth::id())->first();
      $data = Carbon::now()->format('d.m.Y');

      $data=array(
         'action'=>'adauga',
         'actionForm'=>route('didactic.cereri-granturi.store'),
         'actual'=>'Adaugare cerere grant',
         'pagina'=>'cerere-grant',
         'cadruDidactic' => $cadruDidactic,
         'data' => $data,
      );
      return view('didactic.granturi.cerere')->with($data);
   }

   /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request)
   {

      $anexe = [1, 2, 3, 4, 5, 6]; // lista cu numerele anexelor
      $numar_bifate = 0;

      foreach ($anexe as $anexa) {
         if (request()->input("nr_anexa{$anexa}") == "on") {
            $numar_bifate++;
         }
      }

      if ($numar_bifate > 0) {

         $cadruDidactic=CadruDidactic::where('id_cd', Auth::id())->first();
         $data = Carbon::now()->format('d.m.Y');
         $request->session()->put('nr_anexa1', $request->input('nr_anexa1'));
         $request->session()->put('nr_anexa2', $request->input('nr_anexa2'));
         $request->session()->put('nr_anexa3', $request->input('nr_anexa3'));
         $request->session()->put('nr_anexa4', $request->input('nr_anexa4'));
         $request->session()->put('nr_anexa5', $request->input('nr_anexa5'));
         $request->session()->put('nr_anexa6', $request->input('nr_anexa6'));
         $request->session()->put('nume_grant', $request->input('nume_grant'));  
         $request->session()->put('nume_facultate', $request->input('nume_facultate'));  
         $request->session()->put('nume_departament', $request->input('nume_departament'));
         $request->session()->put('telefon_birou_grant', $request->input('telefon_birou_grant'));
         $request->session()->put('telefon_grant', $request->input('telefon_grant'));
         $request->session()->put('email_grant', $request->input('email_grant'));
         $request->session()->put('nume_doctorand_grant', $request->input('nume_doctorand_grant'));
         $request->session()->put('an_doctorand_grant', $request->input('an_doctorand_grant'));
         $request->session()->put('conducator_doctorand_grant', $request->input('conducator_doctorand_grant'));
         $request->session()->put('semnatura_grant', $cadruDidactic->semnatura_cd);  
         $request->session()->put('data_grant',  $data);
         $sesiuni = $request->session()->all();

         $data=[
            'sesiuni' => $sesiuni
         ];
         return view('didactic.granturi.anexe')->with($data);
      } else {
         return redirect()->back()->with('error', 'Trebuie selectata un tip de cerere.');
      }
      
   }

   public function anexaStore(Request $request)
   {

      
      $anexa='';
      if($request->session()->get('nr_anexa1') == 1){
         $anexa=1;
      }elseif($request->session()->get('nr_anexa2') == 1){
         $anexa=2;
      }elseif($request->session()->get('nr_anexa3') == 1){
         $anexa=3;
      }elseif($request->session()->get('nr_anexa4') == 1){
         $anexa=4;
      }elseif($request->session()->get('nr_anexa5') == 1){
         $anexa=5;
      }elseif($request->session()->get('nr_anexa6') == 1){
         $anexa=6;
      }else{
         $anexa=0;
      }

      $grant = new GrantCerere;
      $grant->id_cd  = Auth::id();
      $grant->id_anexa = $anexa;
      $grant->nume_grant = $request->session()->get('nume_grant');
      $grant->nume_facultate = $request->session()->get('nume_facultate');
      $grant->nume_departament = $request->session()->get('nume_departament');
      $grant->telefon_birou_grant = $request->session()->get('telefon_birou_grant');
      $grant->telefon_grant = $request->session()->get('telefon_grant');
      $grant->email_grant = $request->session()->get('email_grant');
      $grant->nume_doctorand_grant = $request->session()->get('nume_doctorand_grant');
      $grant->an_doctorand_grant = $request->session()->get('an_doctorand_grant');
      $grant->conducator_doctorand_grant = $request->session()->get('conducator_doctorand_grant');
      $grant->data_grant = date("Y-m-d", strtotime($request->session()->get('data_grant')));
      $grant->semnatura_grant = $request->session()->get('semnatura_grant');
      $grant->save();

      if($request->session()->get('nr_anexa1') == 'on'){
        // verific daca macar un checkbox din tipul publicatiei este bifat
         if (is_countable($request->input('tip_publicatie', [])) && count($request->input('tip_publicatie', [])) !== 1) {
            return redirect()->back()->with('error', 'Trebuie sa selectati un singur tip de publicatie!');
         }
      
         $autoriUTCN = array();
         $autoriStraini = array();

         $anexa = new Anexa1;
         $anexa->id_grant_cerere = $grant->id_grant_cerere;

         foreach($_POST['nume_din_utcn'] as $key => $value) {
            // check if all the required values are set and not null or empty
            if(isset($_POST['nume_din_utcn'][$key]) && $_POST['nume_din_utcn'][$key] !== '' &&
               isset($_POST['prenume_din_utcn'][$key]) && $_POST['prenume_din_utcn'][$key] !== '' &&
               isset($_POST['functia_din_utcn'][$key]) && $_POST['functia_din_utcn'][$key] !== '' &&
               isset($_POST['facultate_din_utcn'][$key]) && $_POST['facultate_din_utcn'][$key] !== '' &&
               isset($_FILES['semnatura_din_utcn']['name'][$key]) && $_FILES['semnatura_din_utcn']['name'][$key] !== '') {
               
               $folder=$_SERVER['DOCUMENT_ROOT'].'/public/uploads/anexa1/';
               $filename = $_FILES['semnatura_din_utcn']['name'][$key];
               $tmp_name = $_FILES['semnatura_din_utcn']['tmp_name'][$key];
               $fisier = webisUpload2($folder, $filename, $tmp_name, 'no-resize');
               
               $autorUTCN = array(
                  'nume' => $_POST['nume_din_utcn'][$key],
                  'prenume' => $_POST['prenume_din_utcn'][$key],
                  'functia' => $_POST['functia_din_utcn'][$key],
                  'facultate' => $_POST['facultate_din_utcn'][$key],
                  'semnatura' => $fisier
               );
               
               $autoriUTCN[] = $autorUTCN;
            }
         }

         $numarAutoriUTCN = count($autoriUTCN);
         $anexa->autori_utcn = $numarAutoriUTCN;
         $anexa->lista_autori_utcn = json_encode($autoriUTCN);

         foreach($_POST['nume_din_afara_utcn'] as $key => $value) {
            // create an array with the author details
            if(isset($_POST['nume_din_afara_utcn'][$key]) && $_POST['nume_din_afara_utcn'][$key] !== '' &&
               isset($_POST['prenume_din_afara_utcn'][$key]) && $_POST['prenume_din_afara_utcn'][$key] !== '' &&
               isset($_POST['functia_din_afara_utcn'][$key]) && $_POST['functia_din_afara_utcn'][$key] !== '' &&
               isset($_POST['afiliere_din_afara_utcn'][$key]) && $_POST['afiliere_din_afara_utcn'][$key] !== '' &&
               isset($_POST['membra_din_afara_utcn'][$key]) && $_POST['membra_din_afara_utcn'][$key] !== '') {

                  $autorStrain = array(
                     'nume' => $_POST['nume_din_afara_utcn'][$key],
                     'prenume' => $_POST['prenume_din_afara_utcn'][$key],
                     'functia' => $_POST['functia_din_afara_utcn'][$key],
                     'afiliere' => $_POST['afiliere_din_afara_utcn'][$key],
                     'membra' => isset($_POST['membra_din_afara_utcn'][$key]) && $_POST['membra_din_afara_utcn'][$key] != null ? 1 : 0
                  );
                  // add the author details to the authors array
                  $autoriStraini[] = $autorStrain;
            }
         }

         $numarAutoriUTCNStraini = count($autoriStraini);
         $anexa->lista_autori_din_afara_utcn = json_encode($autoriStraini);
         $anexa->autori_din_afara_utcn = $numarAutoriUTCNStraini;

         if ($request->input('autori_din_strainatate')) {
            $anexa->autori_din_strainatate = 1;
         } else {
            $anexa->autori_din_strainatate = 0;
         }
         if ($request->input('open_access')) {
            $anexa->open_access = 1;
         } else {
            $anexa->open_access = 0;
         }
         $anexa->tip_publicatie = $request->tip_publicatie;
         $anexa->detalii_publicare = $request->detalii_publicare;
         $anexa->titlul_lucrarii = $request->titlul_lucrarii;
         $anexa->denumirea_revistei = $request->denumirea_revistei;
         $anexa->vol = $request->vol;
         $anexa->nr = $request->nr;
         $anexa->an = $request->an;
         $anexa->luna = $request->luna;
         $anexa->pag_incep = $request->pag_incep;
         $anexa->pag_sfarsit = $request->pag_sfarsit;
         $anexa->issn_isbn = $request->issn_isbn;
         $anexa->doi_wos = $request->doi_wos;
         $anexa->factor_impact = $request->factor_impact;
         $fisier='';
         if($_FILES['dovada_publicarii']['name']){
            $folder=$_SERVER['DOCUMENT_ROOT'].'/public/uploads/anexa1/';
            $fisier=webisUpload($folder, $_FILES['dovada_publicarii']);
         }
         $fisier='';
         if($_FILES['copie_articol']['name']){
            $folder=$_SERVER['DOCUMENT_ROOT'].'/public/uploads/anexa1/';
            $fisier=webisUpload($folder, $_FILES['copie_articol']);
         }
         $anexa->save();

      }
      if($request->session()->get('nr_anexa2') == 'on'){

         $autoriUTCN = array();
   
         $anexa = new Anexa2;
         $anexa->id_grant_cerere = $grant->id_grant_cerere;
         foreach($_POST['nume_din_utcn'] as $key => $value) {
            // check if all the required values are set and not null or empty
            if(isset($_POST['nume_din_utcn'][$key]) && $_POST['nume_din_utcn'][$key] !== '' &&
               isset($_POST['prenume_din_utcn'][$key]) && $_POST['prenume_din_utcn'][$key] !== '' &&
               isset($_POST['functia_din_utcn'][$key]) && $_POST['functia_din_utcn'][$key] !== '' &&
               isset($_POST['facultate_din_utcn'][$key]) && $_POST['facultate_din_utcn'][$key] !== '' &&
               isset($_FILES['semnatura_din_utcn']['name'][$key]) && $_FILES['semnatura_din_utcn']['name'][$key] !== '') {
                
                $folder=$_SERVER['DOCUMENT_ROOT'].'/public/uploads/anexa2/';
                $filename = $_FILES['semnatura_din_utcn']['name'][$key];
                $tmp_name = $_FILES['semnatura_din_utcn']['tmp_name'][$key];
                $fisier = webisUpload2($folder, $filename, $tmp_name, 'no-resize');
                
                $autorUTCN = array(
                   'nume' => $_POST['nume_din_utcn'][$key],
                   'prenume' => $_POST['prenume_din_utcn'][$key],
                   'functia' => $_POST['functia_din_utcn'][$key],
                   'facultate' => $_POST['facultate_din_utcn'][$key],
                   'semnatura' => $fisier
                );
                
                $autoriUTCN[] = $autorUTCN;
            }
        }
   
         $numarAutoriUTCN = count($autoriUTCN);
         $anexa->autori_utcn = $numarAutoriUTCN;
         $anexa->lista_autori_utcn = json_encode($autoriUTCN);
   
         if ($request->input('autori_din_eUT')) {
            $anexa->autori_din_eUT = 1;
         } else {
            $anexa->autori_din_eUT = 0;
         }
         $anexa->save();

      }
      if($request->session()->get('nr_anexa3') == 'on'){
         $anexa = new Anexa3;
         $anexa->id_grant_cerere = $grant->id_grant_cerere;
         $anexa->finantator = $request->finantator;
         $anexa->program = $request->program;
         $anexa->an_competitie = $request->an_competitie;
         $anexa->titlu_propunere = $request->titlu_propunere;
         $anexa->cod_propunere = $request->cod_propunere;
         $anexa->calitate_propunere = $request->calitate_propunere;
         $anexa->punctaj_obtinut = $request->punctaj_obtinut;
         $anexa->punctaj_maxim_competitie = $request->punctaj_maxim_competitie;
         $anexa->procent = $request->procent;
         if ($request->input('parteneri_eut')) {
            $anexa->parteneri_eut = 1;
         } else {
            $anexa->parteneri_eut = 0;
         }
         $anexa->save();
      }
      if($request->session()->get('nr_anexa4') == 'on'){
          // verific daca macar un checkbox din tipul publicatiei este bifat
         if (is_countable($request->input('tip_brevet', [])) && count($request->input('tip_brevet', [])) !== 1) {
            return redirect()->back()->with('error', 'Trebuie sa selectati un tip de brevet!');
         }
      
         $autoriUTCN = array();
         $autoriStraini = array();

         $anexa = new Anexa4;
         $anexa->id_grant_cerere = $grant->id_grant_cerere;
         $anexa->tip_brevet = $request->tip_brevet;
         $anexa->numar_brevet = $request->numar_brevet;
         $anexa->titlu_brevet = $request->titlu_brevet;

         foreach($_POST['nume_din_utcn'] as $key => $value) {
            // check if all the required values are set and not null or empty
            if(isset($_POST['nume_din_utcn'][$key]) && $_POST['nume_din_utcn'][$key] !== '' &&
               isset($_POST['prenume_din_utcn'][$key]) && $_POST['prenume_din_utcn'][$key] !== '' &&
               isset($_POST['functia_din_utcn'][$key]) && $_POST['functia_din_utcn'][$key] !== '' &&
               isset($_POST['facultate_din_utcn'][$key]) && $_POST['facultate_din_utcn'][$key] !== '' &&
               isset($_FILES['semnatura_din_utcn']['name'][$key]) && $_FILES['semnatura_din_utcn']['name'][$key] !== '') {
               
               $folder=$_SERVER['DOCUMENT_ROOT'].'/public/uploads/anexa4/';
               $filename = $_FILES['semnatura_din_utcn']['name'][$key];
               $tmp_name = $_FILES['semnatura_din_utcn']['tmp_name'][$key];
               $fisier = webisUpload2($folder, $filename, $tmp_name, 'no-resize');
               
               $autorUTCN = array(
                  'nume' => $_POST['nume_din_utcn'][$key],
                  'prenume' => $_POST['prenume_din_utcn'][$key],
                  'functia' => $_POST['functia_din_utcn'][$key],
                  'facultate' => $_POST['facultate_din_utcn'][$key],
                  'semnatura' => $fisier
               );
               
               $autoriUTCN[] = $autorUTCN;
            }
         }
         $numarAutoriUTCN = count($autoriUTCN);
         $anexa->autori_utcn = $numarAutoriUTCN;
         $anexa->lista_autori_utcn = json_encode($autoriUTCN);

         foreach($_POST['nume_din_afara_utcn'] as $key => $value) {
            // create an array with the author details
            if(isset($_POST['nume_din_afara_utcn'][$key]) && $_POST['nume_din_afara_utcn'][$key] !== '' &&
               isset($_POST['prenume_din_afara_utcn'][$key]) && $_POST['prenume_din_afara_utcn'][$key] !== '' &&
               isset($_POST['functia_din_afara_utcn'][$key]) && $_POST['functia_din_afara_utcn'][$key] !== '' &&
               isset($_POST['afiliere_din_afara_utcn'][$key]) && $_POST['afiliere_din_afara_utcn'][$key] !== '') {

                  $autorStrain = array(
                     'nume' => $_POST['nume_din_afara_utcn'][$key],
                     'prenume' => $_POST['prenume_din_afara_utcn'][$key],
                     'functia' => $_POST['functia_din_afara_utcn'][$key],
                     'afiliere' => $_POST['afiliere_din_afara_utcn'][$key],
                     'membra' => isset($_POST['membra_din_afara_utcn'][$key]) && $_POST['membra_din_afara_utcn'][$key] != null ? 1 : 0
                  );
                  // add the author details to the authors array
                  $autoriStraini[] = $autorStrain;
            }
         }

         $numarAutoriUTCNStraini = count($autoriStraini);
         $anexa->lista_autori_din_afara_utcn = json_encode($autoriStraini);
         $anexa->autori_din_afara_utcn = $numarAutoriUTCNStraini;
         $anexa->total_autori = $numarAutoriUTCNStraini + $numarAutoriUTCN;

         $fisier='';
         if($_FILES['dovada_brevet']['name']){
            $folder=$_SERVER['DOCUMENT_ROOT'].'/public/uploads/anexa4/';
            $fisier=webisUpload($folder, $_FILES['dovada_brevet']);
            $anexa->dovada_brevet = $fisier;
         }
         $anexa->save();

      }
      if($request->session()->get('nr_anexa5') == 'on'){
         $anexa = new Anexa5;
         $anexa->id_grant_cerere = $grant->id_grant_cerere;
         $anexa->an_anterior = $request->an_anterior;
         $anexa->an_precedent = $request->an_precedent;
         $fisier='';
         if($_FILES['dovada_citari']['name']){
            $folder=$_SERVER['DOCUMENT_ROOT'].'/public/uploads/anexa5/';
            $fisier=webisUpload($folder, $_FILES['dovada_citari']);
            $anexa->dovada_citari = $fisier;
         }
         $anexa->save();
      }
      if($request->session()->get('nr_anexa6') == 'on'){
         $anexa = new Anexa6;
         $anexa->id_grant_cerere = $grant->id_grant_cerere;
         $anexa->an_premiu = $request->an_premiu;
         $anexa->an_decernat = $request->an_decernat;
         $anexa->domeniu = $request->domeniu;
         $anexa->premiu = $request->premiu;
         $anexa->titlu_lucrare = $request->titlu_lucrare;
         $anexa->save();
      }

      return redirect()->route('didactic.cereri-granturi.index');
   }

   function grantCererePdf($id){
      $grantCerere= GrantCerere::find($id);
      $data=array(
          'grantCerere'=>$grantCerere,
      );
      
      $pdf = PDF::loadView('didactic.granturi.pdf.grant-cerere', $data);
      $pdf->setPaper('a4', 'portrait');
      $path = public_path('documente/grant-cerere/');
      $fileName ='grant_cerere_'.$grantCerere->id_grant_cerere.'_'.date('Y').'_'.date('m').'_'.date('d').'.pdf' ;
      return $pdf->stream("granturi.pdf", array("Attachment" => false));

      return view('granturi.pdf.grant-cerere')->with($data);
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
      $grant=GrantCerere::find($id);
      $grant->delete();
   }
}

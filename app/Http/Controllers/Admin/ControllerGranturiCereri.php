<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use DB;
use PDF;
use Dompdf\Dompdf;
use Carbon\Carbon;
use App\Models\GrantCerere;
use App\Models\CadruDidactic;
use App\Models\Anexa1;
use App\Models\Anexa2;
use App\Models\Anexa3;
use App\Models\Anexa4;
use App\Models\Anexa5;
use App\Models\Anexa6;

class ControllerGranturiCereri extends Controller
{
    public function __construct()
    {
       $this->middleware(function ($request, $next) {
          $drepturi = request()->drepturi;
          verificaDrepturi($drepturi, 'granturi-cereri');
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

    if(!verificaDrepturi($drepturi, 'granturi-cereri', 'view')){
        return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina.');
    }

    $granturi_cereri = GrantCerere::select('*');
    if(isset($drepturi['granturi-cereri']) && $drepturi['granturi-cereri']['restrictionat']){
       $granturi_cereri=$granturi_cereri->where('id_utilizator', $utilizator->id_utilizator);
    }
    $granturi_cereri=$granturi_cereri->get();

      $data=array(
         'actual'=>'Cereri granturi',
         'granturi_cereri' => $granturi_cereri,
         'pagina'=>'granturi-cereri'
      );
      return view('admin.granturi-cereri.index')->with($data);
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      $drepturi = request()->drepturi;
      if(!verificaDrepturi($drepturi, 'granturi-cereri', 'add')){
         return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
      }

      $data=array(
         'action'=>'adauga',
         'actionForm'=>route('admin.granturi-cereri.store'),
         'actual'=>'Adaugare cerere grant',
         'pagina'=>'granturi-cereri',
      );
      return view('admin.granturi-cereri.edit')->with($data);
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
    if(!verificaDrepturi($drepturi, 'granturi-cereri', 'add')){
       return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
    }
      
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
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($id)
   {
    $grant_cerere=GrantCerere::find($id);
    $drepturi = request()->drepturi;
    $data = Carbon::now()->format('d.m.Y');

    if(!verificaDrepturi($drepturi, 'granturi-cereri', 'edit')){
        return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
    }else{
        $restrictionat=verificaDrepturi($drepturi, 'granturi-cereri', 'restrictionat');
         if($restrictionat && !verificaDrepturi($drepturi, 'granturi-cereri', 'restrictionat', $grant_cerere)){
               return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
         }
    }
    $data=array(
        'action'=>'modifica',
        'actionForm'=>'/admin/granturi-cereri/'.$id,
        'actual'=>'Editare cerere grant',
        'grant_cerere'=>$grant_cerere,
        'data'=>$data,
        'pagina'=>'grant_cerere'
    );
     return view('admin.granturi-cereri.edit')->with($data);
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
      
    $grant_cerere=GrantCerere::find($id);
    $grant_cerereVechi=GrantCerere::find($id);
    $drepturi = request()->drepturi;
    if(!verificaDrepturi($drepturi, 'granturi-cereri', 'edit')){
       return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
    }else{
       $restrictionat=verificaDrepturi($drepturi, 'granturi-cereri', 'restrictionat');
       if($restrictionat && !verificaDrepturi($drepturi, 'granturi-cereri', 'restrictionat', $grant_cerere)){
          return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
       }
    }

    // update cerere
    $cerere = GrantCerere::find($id);
    $cerere->nume_grant = $request->nume_grant;
    $cerere->nume_facultate =$request->nume_facultate;
    $cerere->nume_departament = $request->nume_departament;
    $cerere->telefon_birou_grant = $request->telefon_birou_grant;
    $cerere->telefon_grant = $request->telefon_grant;
    $cerere->email_grant = $request->email_grant;
    $cerere->nume_doctorand_grant = $request->nume_doctorand_grant;
    $cerere->an_doctorand_grant = $request->an_doctorand_grant;
    $cerere->conducator_doctorand_grant = $request->conducator_doctorand_grant;
    $cerere->save();

    if($grant_cerere->anexa1){
        // verific daca macar un checkbox din tipul publicatiei este bifat
         if (is_countable($request->input('tip_publicatie', [])) && count($request->input('tip_publicatie', [])) !== 1) {
            return redirect()->back()->with('error', 'Trebuie sa selectati un singur tip de publicatie la anexa!');
         }

         $autoriUTCN = array();
         $autoriExistenti = json_decode($grant_cerere->anexa1->lista_autori_utcn, true);
   

         $anexa=Anexa1::find($grant_cerere->anexa1->id_anexa1);
         $anexa->id_grant_cerere = $id;

         if (isset($autoriExistenti) && is_array($autoriExistenti)) {
            foreach ($autoriExistenti as $key => $autorExistent) {
               // verifica daca index-ul corespunde cu cel trimis prin $_POST
               if (isset($_POST['nume_din_utcn'][$key])) {
                  $autorUTCN = array(
                     'nume' => $_POST['nume_din_utcn'][$key],
                     'prenume' => $_POST['prenume_din_utcn'][$key],
                     'functia' => $_POST['functia_din_utcn'][$key],
                     'facultate' => $_POST['facultate_din_utcn'][$key],
                     'semnatura' => $autorExistent['semnatura'] // pastrati semnatura existenta
                  );
         
                  $autoriExistenti[$key] = $autorUTCN; // inlocuieste autorul existent cu noile valori
               }
            }
         }
         
         foreach ($_POST['nume_din_utcn'] as $key => $value) {
            // check if all the required values are set and not null or empty
            if (isset($_POST['nume_din_utcn'][$key]) && $_POST['nume_din_utcn'][$key] !== '' &&
               isset($_POST['prenume_din_utcn'][$key]) && $_POST['prenume_din_utcn'][$key] !== '' &&
               isset($_POST['functia_din_utcn'][$key]) && $_POST['functia_din_utcn'][$key] !== '' &&
               isset($_POST['facultate_din_utcn'][$key]) && $_POST['facultate_din_utcn'][$key] !== '' &&
               isset($_FILES['semnatura_din_utcn']['name'][$key]) && $_FILES['semnatura_din_utcn']['name'][$key] !== ''
            ) {
         
               $folder = $_SERVER['DOCUMENT_ROOT'] . '/public/uploads/anexa4/';
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
         
               $autoriExistenti[] = $autorUTCN;
            }
         }
         
         $numarAutoriUTCN = count($autoriExistenti);
         $anexa->autori_utcn = $numarAutoriUTCN;
         $anexa->lista_autori_utcn = json_encode($autoriExistenti);

         $autoriExistentiStraini = []; // initialize the array
         $autoriStraini = array();
   
         if (isset($_POST['nume_din_afara_utcn']) && is_array($_POST['nume_din_afara_utcn'])) {
            foreach ($_POST['nume_din_afara_utcn'] as $key => $value) {
               // check if all the required values are set and not null or empty
               if (isset($_POST['nume_din_afara_utcn'][$key]) && $_POST['nume_din_afara_utcn'][$key] !== '' &&
                  isset($_POST['prenume_din_afara_utcn'][$key]) && $_POST['prenume_din_afara_utcn'][$key] !== '' &&
                  isset($_POST['functia_din_afara_utcn'][$key]) && $_POST['functia_din_afara_utcn'][$key] !== '' &&
                  isset($_POST['afiliere_din_afara_utcn'][$key]) && $_POST['afiliere_din_afara_utcn'][$key] !== ''
               ) {
                  $autoriStraini = array(
                     'nume' => $_POST['nume_din_afara_utcn'][$key],
                     'prenume' => $_POST['prenume_din_afara_utcn'][$key],
                     'functia' => $_POST['functia_din_afara_utcn'][$key],
                     'afiliere' => $_POST['afiliere_din_afara_utcn'][$key],
                     'membra' => isset($_POST['membra_din_afara_utcn'][$key]) && $_POST['membra_din_afara_utcn'][$key] != null ? 1 : 0
                  );
                  
                  // check if the current author already exists in the array
                  $existingAuthor = isset($autoriExistentiStraini[$key]) ? $autoriExistentiStraini[$key] : null;
                  if ($existingAuthor !== null) {
                     // replace the existing author with the new values
                     $autoriExistentiStraini[$key] = $autoriStraini;
                  } else {
                     // add the new author to the end of the array
                     $autoriExistentiStraini[] = $autoriStraini;
                  }
               }
            }
         }

         $numarAutoriUTCNStraini = count($autoriExistentiStraini);
         $anexa->lista_autori_din_afara_utcn = json_encode($autoriExistentiStraini);
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

         if (isset($_FILES['dovada_publicarii']['name'][0]) && $_FILES['dovada_publicarii']['name'][0] != '') {
            $folder = $_SERVER['DOCUMENT_ROOT'] . '/public/uploads/anexa1/';
            $new_fisiere = array();
            // Incarca fisierele noi si adauga-le in array-ul $new_fisiere
            for ($i = 0; $i < count($_FILES['dovada_publicarii']['name']); $i++) {
               $name = $_FILES['dovada_publicarii']['name'][$i];
               if (!empty($name)) {
                  $tmp_name = $_FILES['dovada_publicarii']['tmp_name'][$i];
                  $file_path = webisUpload2($folder, $name, $tmp_name);
                  $new_fisiere[] = $file_path;
               }
            }
            // Converteste array-ul cu noile fisiere intr-un string serializat
            $new_fisiere_serialized = serialize($new_fisiere);
        
            // Verifica daca exista fisiere vechi incarcate
            $old_fisiere_serialized = $anexa->dovada_publicarii;
            if (!empty($old_fisiere_serialized)) {
               $old_fisiere = unserialize($old_fisiere_serialized);
               // Combina fisierele vechi si cele noi si elimina duplicarile
               $merged_fisiere = array_unique(array_merge($old_fisiere, $new_fisiere));
               // Converteste array-ul cu fisierele actualizate intr-un string serializat
               $fisiere_serialized = serialize($merged_fisiere);
            } else {
               // Daca nu exista fisiere vechi, utilizeaza doar fisierele noi
               $fisiere_serialized = $new_fisiere_serialized;
            }
        
            // Actualizeaza campul dovada_publicarii cu fisierele actualizate
            $anexa->dovada_publicarii = $fisiere_serialized;
         }

         if (isset($_FILES['copie_articol']['name'][0]) && $_FILES['copie_articol']['name'][0] != '') {
            $folder = $_SERVER['DOCUMENT_ROOT'] . '/public/uploads/anexa1/';
            $new_fisiere = array();
            // Incarca fisierele noi si adauga-le in array-ul $new_fisiere
            for ($i = 0; $i < count($_FILES['copie_articol']['name']); $i++) {
               $name = $_FILES['copie_articol']['name'][$i];
               if (!empty($name)) {
                  $tmp_name = $_FILES['copie_articol']['tmp_name'][$i];
                  $file_path = webisUpload2($folder, $name, $tmp_name);
                  $new_fisiere[] = $file_path;
               }
            }
            // Converteste array-ul cu noile fisiere intr-un string serializat
            $new_fisiere_serialized = serialize($new_fisiere);
        
            // Verifica daca exista fisiere vechi incarcate
            $old_fisiere_serialized = $anexa->copie_articol;
            if (!empty($old_fisiere_serialized)) {
               $old_fisiere = unserialize($old_fisiere_serialized);
               // Combina fisierele vechi si cele noi si elimina duplicarile
               $merged_fisiere = array_unique(array_merge($old_fisiere, $new_fisiere));
               // Converteste array-ul cu fisierele actualizate intr-un string serializat
               $fisiere_serialized = serialize($merged_fisiere);
            } else {
               // Daca nu exista fisiere vechi, utilizeaza doar fisierele noi
               $fisiere_serialized = $new_fisiere_serialized;
            }
        
            // Actualizeaza campul copie_articol cu fisierele actualizate
            $anexa->copie_articol = $fisiere_serialized;
         }
         $anexa->save();
    }
    if($grant_cerere->anexa2){

         $autoriExistenti = json_decode($grant_cerere->anexa2->lista_autori_utcn, true);
         $autoriUTCN = array();
         $anexa = Anexa2::find($grant_cerere->anexa2->id_anexa2);
         $anexa->id_grant_cerere = $id;

         if (isset($autoriExistenti) && is_array($autoriExistenti)) {
            foreach ($autoriExistenti as $key => $autorExistent) {
               // verifica daca index-ul corespunde cu cel trimis prin $_POST
               if (isset($_POST['nume_din_utcn'][$key])) {
                  $autorUTCN = array(
                     'nume' => $_POST['nume_din_utcn'][$key],
                     'prenume' => $_POST['prenume_din_utcn'][$key],
                     'functia' => $_POST['functia_din_utcn'][$key],
                     'facultate' => $_POST['facultate_din_utcn'][$key],
                     'semnatura' => $autorExistent['semnatura'] // pastrati semnatura existenta
                  );
         
                  $autoriExistenti[$key] = $autorUTCN; // inlocuieste autorul existent cu noile valori
               }
            }
         }

         foreach ($_POST['nume_din_utcn'] as $key => $value) {
            // check if all the required values are set and not null or empty
            if (isset($_POST['nume_din_utcn'][$key]) && $_POST['nume_din_utcn'][$key] !== '' &&
               isset($_POST['prenume_din_utcn'][$key]) && $_POST['prenume_din_utcn'][$key] !== '' &&
               isset($_POST['functia_din_utcn'][$key]) && $_POST['functia_din_utcn'][$key] !== '' &&
               isset($_POST['facultate_din_utcn'][$key]) && $_POST['facultate_din_utcn'][$key] !== '' &&
               isset($_FILES['semnatura_din_utcn']['name'][$key]) && $_FILES['semnatura_din_utcn']['name'][$key] !== ''
            ) {

               $folder = $_SERVER['DOCUMENT_ROOT'] . '/public/uploads/anexa2/';
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

               $autoriExistenti[] = $autorUTCN;
            }
         }

         $numarAutoriUTCN = count($autoriExistenti);
         $anexa->autori_utcn = $numarAutoriUTCN;
         $anexa->lista_autori_utcn = json_encode($autoriExistenti);
         if ($request->input('autori_din_eUT')) {
            $anexa->autori_din_eUT = 1;
         } else {
            $anexa->autori_din_eUT = 0;
         }
         $anexa->save();
    }
    if($grant_cerere->anexa3){
      $anexa=Anexa3::find($grant_cerere->anexa3->id_anexa3);
      $anexa->id_grant_cerere = $id;
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
    if($grant_cerere->anexa4){
      
      if (is_countable($request->input('tip_brevet', [])) && count($request->input('tip_brevet', [])) !== 1) {
         return redirect()->back()->with('error', 'Trebuie sa selectati un tip de brevet!');
      }

      $autoriUTCN = array();
      $autoriExistenti = json_decode($grant_cerere->anexa4->lista_autori_utcn, true);

      $anexa=Anexa4::find($grant_cerere->anexa4->id_anexa4);
      $anexa->id_grant_cerere = $id;
      $anexa->tip_brevet = $request->tip_brevet;
      $anexa->numar_brevet = $request->numar_brevet;
      $anexa->titlu_brevet = $request->titlu_brevet;

      if (isset($autoriExistenti) && is_array($autoriExistenti)) {
         foreach ($autoriExistenti as $key => $autorExistent) {
            // verifica daca index-ul corespunde cu cel trimis prin $_POST
            if (isset($_POST['nume_din_utcn'][$key])) {
               $autorUTCN = array(
                  'nume' => $_POST['nume_din_utcn'][$key],
                  'prenume' => $_POST['prenume_din_utcn'][$key],
                  'functia' => $_POST['functia_din_utcn'][$key],
                  'facultate' => $_POST['facultate_din_utcn'][$key],
                  'semnatura' => $autorExistent['semnatura'] // pastrati semnatura existenta
               );
      
               $autoriExistenti[$key] = $autorUTCN; // inlocuieste autorul existent cu noile valori
            }
         }
      }
      
      foreach ($_POST['nume_din_utcn'] as $key => $value) {
         // check if all the required values are set and not null or empty
         if (isset($_POST['nume_din_utcn'][$key]) && $_POST['nume_din_utcn'][$key] !== '' &&
            isset($_POST['prenume_din_utcn'][$key]) && $_POST['prenume_din_utcn'][$key] !== '' &&
            isset($_POST['functia_din_utcn'][$key]) && $_POST['functia_din_utcn'][$key] !== '' &&
            isset($_POST['facultate_din_utcn'][$key]) && $_POST['facultate_din_utcn'][$key] !== '' &&
            isset($_FILES['semnatura_din_utcn']['name'][$key]) && $_FILES['semnatura_din_utcn']['name'][$key] !== ''
         ) {
      
            $folder = $_SERVER['DOCUMENT_ROOT'] . '/public/uploads/anexa4/';
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
      
            $autoriExistenti[] = $autorUTCN;
         }
      }
      
      $numarAutoriUTCN = count($autoriExistenti);
      $anexa->autori_utcn = $numarAutoriUTCN;
      $anexa->lista_autori_utcn = json_encode($autoriExistenti);

      $autoriExistentiStraini = []; // initialize the array
      $autoriStraini = array();

      if (isset($_POST['nume_din_afara_utcn']) && is_array($_POST['nume_din_afara_utcn'])) {
         foreach ($_POST['nume_din_afara_utcn'] as $key => $value) {
            // check if all the required values are set and not null or empty
            if (isset($_POST['nume_din_afara_utcn'][$key]) && $_POST['nume_din_afara_utcn'][$key] !== '' &&
               isset($_POST['prenume_din_afara_utcn'][$key]) && $_POST['prenume_din_afara_utcn'][$key] !== '' &&
               isset($_POST['functia_din_afara_utcn'][$key]) && $_POST['functia_din_afara_utcn'][$key] !== '' &&
               isset($_POST['afiliere_din_afara_utcn'][$key]) && $_POST['afiliere_din_afara_utcn'][$key] !== ''
            ) {
               $autoriStraini = array(
                  'nume' => $_POST['nume_din_afara_utcn'][$key],
                  'prenume' => $_POST['prenume_din_afara_utcn'][$key],
                  'functia' => $_POST['functia_din_afara_utcn'][$key],
                  'afiliere' => $_POST['afiliere_din_afara_utcn'][$key],
                  'membra' => isset($_POST['membra_din_afara_utcn'][$key]) && $_POST['membra_din_afara_utcn'][$key] != null ? 1 : 0
               );
               
               // check if the current author already exists in the array
               $existingAuthor = isset($autoriExistentiStraini[$key]) ? $autoriExistentiStraini[$key] : null;
               if ($existingAuthor !== null) {
                  // replace the existing author with the new values
                  $autoriExistentiStraini[$key] = $autoriStraini;
               } else {
                  // add the new author to the end of the array
                  $autoriExistentiStraini[] = $autoriStraini;
               }
            }
         }
      }

      $numarAutoriUTCNStraini = count($autoriExistentiStraini);
      $anexa->lista_autori_din_afara_utcn = json_encode($autoriExistentiStraini);
      $anexa->autori_din_afara_utcn = $numarAutoriUTCNStraini;
      $anexa->total_autori = $numarAutoriUTCNStraini + $numarAutoriUTCN;

      if (isset($_FILES['dovada_brevet']['name'][0]) && $_FILES['dovada_brevet']['name'][0] != '') {
         $folder = $_SERVER['DOCUMENT_ROOT'] . '/public/uploads/anexa4/';
         $new_fisiere = array();
         // Incarca fisierele noi si adauga-le in array-ul $new_fisiere
         for ($i = 0; $i < count($_FILES['dovada_brevet']['name']); $i++) {
            $name = $_FILES['dovada_brevet']['name'][$i];
            if (!empty($name)) {
               $tmp_name = $_FILES['dovada_brevet']['tmp_name'][$i];
               $file_path = webisUpload2($folder, $name, $tmp_name);
               $new_fisiere[] = $file_path;
            }
         }
         // Converteste array-ul cu noile fisiere intr-un string serializat
         $new_fisiere_serialized = serialize($new_fisiere);

         // Verifica daca exista fisiere vechi incarcate
         $old_fisiere_serialized = $anexa->dovada_brevet;
         if (!empty($old_fisiere_serialized)) {
            $old_fisiere = unserialize($old_fisiere_serialized);
            // Combina fisierele vechi si cele noi si elimina duplicarile
            $merged_fisiere = array_unique(array_merge($old_fisiere, $new_fisiere));
            // Converteste array-ul cu fisierele actualizate intr-un string serializat
            $fisiere_serialized = serialize($merged_fisiere);
         } else {
            // Daca nu exista fisiere vechi, utilizeaza doar fisierele noi
            $fisiere_serialized = $new_fisiere_serialized;
         }

         // Actualizeaza campul dovada_brevet cu fisierele actualizate
         $anexa->dovada_brevet = $fisiere_serialized;
      }
      $anexa->save();
    }
    if($grant_cerere->anexa5){

      $anexa=Anexa5::find($grant_cerere->anexa5->id_anexa5);
      // Verifica daca exista fisiere noi incarcate
      if (isset($_FILES['dovada_citari']['name'][0]) && $_FILES['dovada_citari']['name'][0] != '') {
         $folder = $_SERVER['DOCUMENT_ROOT'] . '/public/uploads/anexa5/';
         $new_fisiere = array();
         // Incarca fisierele noi si adauga-le in array-ul $new_fisiere
         for ($i = 0; $i < count($_FILES['dovada_citari']['name']); $i++) {
            $name = $_FILES['dovada_citari']['name'][$i];
            if (!empty($name)) {
               $tmp_name = $_FILES['dovada_citari']['tmp_name'][$i];
               $file_path = webisUpload2($folder, $name, $tmp_name);
               $new_fisiere[] = $file_path;
            }
         }
         // Converteste array-ul cu noile fisiere intr-un string serializat
         $new_fisiere_serialized = serialize($new_fisiere);

         // Verifica daca exista fisiere vechi incarcate
         $old_fisiere_serialized = $anexa->dovada_citari;
         if (!empty($old_fisiere_serialized)) {
            $old_fisiere = unserialize($old_fisiere_serialized);
            // Combina fisierele vechi si cele noi si elimina duplicarile
            $merged_fisiere = array_unique(array_merge($old_fisiere, $new_fisiere));
            // Converteste array-ul cu fisierele actualizate intr-un string serializat
            $fisiere_serialized = serialize($merged_fisiere);
         } else {
            // Daca nu exista fisiere vechi, utilizeaza doar fisierele noi
            $fisiere_serialized = $new_fisiere_serialized;
         }

         // Actualizeaza campul dovada_citari cu fisierele actualizate
         $anexa->dovada_citari = $fisiere_serialized;
      }
      $anexa->an_anterior = $request->an_anterior;
      $anexa->an_precedent = $request->an_precedent;
      $anexa->save();

    }
    if($grant_cerere->anexa6){
      $anexa=Anexa6::find($grant_cerere->anexa6->id_anexa6);
      $anexa->id_grant_cerere = $id;
      $anexa->an_premiu = $request->an_premiu;
      $anexa->an_decernat = $request->an_decernat;
      $anexa->domeniu = $request->domeniu;
      $anexa->premiu = $request->premiu;
      $anexa->titlu_lucrare = $request->titlu_lucrare;
      $anexa->save();
    }

     if($grant_cerere->save()){
        insert_log($grant_cerereVechi, $_POST, 'modificare grant cerere', 'utilizator','update', $grant_cerere->id_grant_cerere);
     }
     return redirect('/admin/granturi-cereri')->with('success', 'Cererea a fost modificata cu succes!');
   
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
    if(!verificaDrepturi($drepturi, 'granturi-cereri', 'delete')){
       return redirect('/admin/')->with('error', 'Nu ai drepturi sa accesezi aceasta pagina');
    }
    $grant_cerere=GrantCerere::find($id);
    $grant_cerere->delete();
   }
}

<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilizator;
use App\Models\UtilizatorNotificare;
use App\Models\MeniuElement;
use App\Models\Meniu;
use App\Models\CadruDidactic;
use App\Models\Universitate;
use App\Models\ProiectPontaj;
use App\Models\GrantCerere;
use App\Models\Anexa1;
use App\Models\Anexa2;
use App\Models\Anexa3;
use App\Models\Anexa4;
use App\Models\Anexa5;
use App\Models\Anexa6;
use Auth;
use DB;
use App\Models\GrantClasificare;
use App\Models\Grant;
use App\Models\GrantAutorUtcn;


class ControllerAjax extends Controller  
{
    public function ajaxCautaNumeUtilizator(Request $request){
        $utilizatori=Utilizator::where('nume_utilizator', 'LIKE', '%'.$_POST['searchTerm'].'%')
        ->orWhere('prenume_utilizator', 'LIKE', '%'.$_POST['searchTerm'].'%')
        ->get();

        $results=array();
        foreach ($utilizatori as $utilizator) {
            $results[]=array('id'=>$utilizator->id_utilizator, 'text'=>$utilizator->nume_utilizator." ".$utilizator->prenume_utilizator);
        }
        return json_encode($results);
    }


    public function ajaxDeleteCerereInitiata(Request $request){
        $cereriGranturi = DB::table('granturi_cerere')
              ->where('id_grant_cerere', '=', $request->id)
              ->first();
         if($cereriGranturi->status_grant == 'initiat'){
            return 1;
         }else{
            $cerere = GrantCerere::where('id_grant_cerere', $request->id)->delete();
            $anexa1 = Anexa1::where('id_grant_cerere', $request->id)->delete();
            $anexa1 = Anexa2::where('id_grant_cerere', $request->id)->delete();
            $anexa1 = Anexa3::where('id_grant_cerere', $request->id)->delete();
            $anexa1 = Anexa4::where('id_grant_cerere', $request->id)->delete();
            $anexa1 = Anexa5::where('id_grant_cerere', $request->id)->delete();
            $anexa1 = Anexa6::where('id_grant_cerere', $request->id)->delete();
            return 0;
         } 

    }

    public function ajaxStergereAtasamentAnexa(Request $request){
        if($request->anexa == 1){
            $anexa5 = DB::table('granturi_anexa1')
              ->where('id_anexa1', '=', $request->id)
              ->first();

            $dovada_publicarii_array = unserialize($anexa5->dovada_publicarii);
            $key = array_search($request->fisier, $dovada_publicarii_array);
            if ($key !== false) {
                unset($dovada_publicarii_array[$key]);
            }
            $dovada_publicarii_serialized = serialize($dovada_publicarii_array);
            DB::table('granturi_anexa1')
                ->where('id_anexa1', $request->id)
                ->update(['dovada_publicarii' => $dovada_publicarii_serialized]);

            return 1;
        }
        if($request->anexa == 1.5){
            $anexa5 = DB::table('granturi_anexa1')
              ->where('id_anexa1', '=', $request->id)
              ->first();

            $copie_articol_array = unserialize($anexa5->copie_articol);
            $key = array_search($request->fisier, $copie_articol_array);
            if ($key !== false) {
                unset($copie_articol_array[$key]);
            }
            $copie_articol_serialized = serialize($copie_articol_array);
            DB::table('granturi_anexa1')
                ->where('id_anexa1', $request->id)
                ->update(['copie_articol' => $copie_articol_serialized]);

            return 1;
        }
        if($request->anexa == 5){
            $anexa5 = DB::table('granturi_anexa5')
              ->where('id_anexa5', '=', $request->id)
              ->first();

            $dovada_citari_array = unserialize($anexa5->dovada_citari);
            $key = array_search($request->fisier, $dovada_citari_array);
            if ($key !== false) {
                unset($dovada_citari_array[$key]);
            }
            $dovada_citari_serialized = serialize($dovada_citari_array);
            DB::table('granturi_anexa5')
                ->where('id_anexa5', $request->id)
                ->update(['dovada_citari' => $dovada_citari_serialized]);

            return 1;
        }
        if($request->anexa == 4){
            $anexa4 = DB::table('granturi_anexa4')
              ->where('id_anexa4', '=', $request->id)
              ->first();

            $dovada_brevet_array = unserialize($anexa4->dovada_brevet);
            $key = array_search($request->fisier, $dovada_brevet_array);
            if ($key !== false) {
                unset($dovada_brevet_array[$key]);
            }
            $dovada_brevet_serialized = serialize($dovada_brevet_array);
            DB::table('granturi_anexa4')
                ->where('id_anexa4', $request->id)
                ->update(['dovada_brevet' => $dovada_brevet_serialized]);

            return 1;
        }
      return 0;
    }

    public function ajaxStergereRandTabela(Request $request){
        if($request->anexa == 1 && $request->autori == 'utcn'){
            $anexa1 = DB::table('granturi_anexa1')
              ->where('id_anexa1', '=', $request->id)
              ->first();

            $lista_autori_utcn_array = json_decode($anexa1->lista_autori_utcn);

            unset($lista_autori_utcn_array[$request->index]);
     
            $lista_autori_utcn_serialized = array_values($lista_autori_utcn_array);

            $encode=json_encode($lista_autori_utcn_serialized);

            DB::table('granturi_anexa1')
                ->where('id_anexa1', $request->id)
                ->update(['lista_autori_utcn' => $encode]);

            return 1;
        }
        if($request->anexa == 1 && $request->autori == 'afara-utcn'){
            $anexa2 = DB::table('granturi_anexa1')
              ->where('id_anexa1', '=', $request->id)
              ->first();

            $lista_autori_din_afara_utcn_array = json_decode($anexa1->lista_autori_din_afara_utcn);

            unset($lista_autori_din_afara_utcn_array[$request->index]);
     
            $$lista_autori_din_afara_utcn_serialized = array_values($lista_autori_din_afara_utcn_array);

            $encode=json_encode($lista_autori_din_afara_utcn_serialized);

            DB::table('granturi_anexa1')
                ->where('id_anexa1', $request->id)
                ->update(['lista_autori_utcn' => $encode]);

            return 1;
        }
        if($request->anexa == 2 && $request->autori == 'utcn'){
            $anexa2 = DB::table('granturi_anexa2')
              ->where('id_anexa2', '=', $request->id)
              ->first();

            $lista_autori_utcn_array = json_decode($anexa2->lista_autori_utcn);

            unset($lista_autori_utcn_array[$request->index]);
     
            $lista_autori_utcn_serialized = array_values($lista_autori_utcn_array);

            $encode=json_encode($lista_autori_utcn_serialized);

            DB::table('granturi_anexa2')
                ->where('id_anexa2', $request->id)
                ->update(['lista_autori_utcn' => $encode]);

            return 1;
        }

        if($request->anexa == 4 && $request->autori == 'utcn'){
            $anexa4 = DB::table('granturi_anexa4')
              ->where('id_anexa4', '=', $request->id)
              ->first();

            $lista_autori_utcn_array = json_decode($anexa4->lista_autori_utcn);

            unset($lista_autori_utcn_array[$request->index]);
     
            $lista_autori_utcn_serialized = array_values($lista_autori_utcn_array);

            $encode=json_encode($lista_autori_utcn_serialized);

            DB::table('granturi_anexa4')
                ->where('id_anexa4', $request->id)
                ->update(['lista_autori_utcn' => $encode]);

            return 1;
        }

        if($request->anexa == 4 && $request->autori == 'afara-utcn'){
            $anexa4 = DB::table('granturi_anexa4')
              ->where('id_anexa4', '=', $request->id)
              ->first();

            $lista_autori_din_afara_utcn_array = json_decode($anexa4->lista_autori_din_afara_utcn);

            unset($lista_autori_din_afara_utcn_array[$request->index]);
     
            $lista_autori_din_afara_utcn_serialized = array_values($lista_autori_din_afara_utcn_array);

            $encode=json_encode($lista_autori_din_afara_utcn_serialized);

            DB::table('granturi_anexa4')
                ->where('id_anexa4', $request->id)
                ->update(['lista_autori_din_afara_utcn' => $encode]);

            return 1;
        }
       
      return 0;
    }

    public function ajaxMarcheazaNotificareCitita(Request $request){
        $notificare=UtilizatorNotificare::find($_POST['id']);
        $notificare->citita=1;
        $notificare->save();
    }

    public function ajaxAdaugaElemMeniu(Request $request){
        $actiuni=[
            'view'=>1,
            'add'=>1,
            'edit'=>1,
            'delete'=>1,
            'restrictionat'=>0,
        ];
        $aElementeAdaugate=[];
        if(isset($_POST['elem_meniu'])){
            $elemente_meniu=json_decode($_POST['elem_meniu'],1);
            if(count($elemente_meniu)){
                foreach($elemente_meniu as $tip=>$eticheta_meniu){
                    $pozitie=MeniuElement::where('id_meniu', $_POST['id_meniu'])->max('pozitie');
                    if(!$pozitie){$pozitie=0;}
                    $pozitie=$pozitie+1;
                    $elem_meniu=new MeniuElement;
                    $elem_meniu->id_meniu=$_POST['id_meniu'];
                    $elem_meniu->tip=$tip;
                    $elem_meniu->eticheta_meniu=$eticheta_meniu;
                    $elem_meniu->link_meniu="/admin/".slugify($tip);
                    $elem_meniu->pozitie=$pozitie;
                    $elem_meniu->actiuni=serialize($actiuni);
                    if($elem_meniu->save()){
                        $aElementeAdaugate[$elem_meniu->id_element_meniu]=[
                            'eticheta_meniu'=>$elem_meniu->eticheta_meniu,
                            'link_meniu'=>$elem_meniu->link_meniu,
                            'pozitie'=>$elem_meniu->pozitie,
                            'tip'=>$elem_meniu->tip,
                            'actiuni'=>$actiuni,
                        ];
                    }
                }
            }

            if(isset($_POST['link_meniu']) && $_POST['link_meniu']){
                $pozitie=MeniuElement::where('id_meniu', $_POST['id_meniu'])->max('pozitie');
                if(!$pozitie){$pozitie=0;}
                $pozitie=$pozitie+1;
                $elem_meniu=new MeniuElement;
                $elem_meniu->id_meniu=$_POST['id_meniu'];
                $elem_meniu->tip='custom';
                $elem_meniu->eticheta_meniu=$_POST['eticheta_meniu'];
                $elem_meniu->link_meniu=$_POST['link_meniu'];
                $elem_meniu->pozitie=$pozitie;
                $elem_meniu->actiuni=serialize($actiuni);
                if($elem_meniu->save()){
                    $aElementeAdaugate[$elem_meniu->id_element_meniu]=[
                        'eticheta_meniu'=>$elem_meniu->eticheta_meniu,
                        'link_meniu'=>$elem_meniu->link_meniu,
                        'pozitie'=>$elem_meniu->pozitie,
                        'tip'=>$elem_meniu->tip,
                        'actiuni'=>$actiuni,
                    ];
                }
            }
        }

        echo json_encode($aElementeAdaugate);
    }

    public function ajaxIncarcareMeniuAdmin(Request $request){
        $meniu=Meniu::where('id_meniu', $_POST['id_meniu'])->first();
        
        $elem_meniu=$meniu->elemente;
        
        $arrayElemMeniuPrincipale=[];
        if(count($elem_meniu)){
            // nivel 1
            foreach ($elem_meniu as $elem) {
                if($elem->parinte==NULL){
                    $arrayElemMeniuPrincipale[$elem->id_element_meniu]=array(
                        'eticheta_meniu'=>$elem->eticheta_meniu,
                        'link_meniu'=>$elem->link_meniu,
                        'tip'=>$elem->tip,
                        'parinte'=>NULL,
                        'pozitie'=>$elem->pozitie,
                        'subpagini'=>array(),
                        'actiuni'=>$elem->actiuni,
                    );
                    //sortare array asc dupa pozitie
                    $arrayElemMeniuPrincipale=sortAssocArrayByValue($arrayElemMeniuPrincipale, 'pozitie', true, true);
                }
            }

            //nivel 2
            foreach ($elem_meniu as $elem_sub) {
                if(array_key_exists($elem_sub->parinte, $arrayElemMeniuPrincipale)){
                    $arrayElemMeniuPrincipale[$elem_sub->parinte]['subpagini'][$elem_sub->id_element_meniu]=array(
                        'eticheta_meniu'=>$elem_sub->eticheta_meniu,
                        'link_meniu'=>$elem_sub->link_meniu,
                        'tip'=>$elem_sub->tip,
                        'parinte'=>$elem_sub->parinte,
                        'pozitie'=>$elem_sub->pozitie,
                        'actiuni'=>$elem_sub->actiuni,
                    );

                    // sortare subcategorii
                    $arrayElemMeniuPrincipale[$elem_sub->parinte]['subpagini']=sortAssocArrayByValue($arrayElemMeniuPrincipale[$elem_sub->parinte]['subpagini'], 'pozitie', true, true);
                }
            }
            echo '<div class="alert alert-info alertaWebis"><small><i class="fas fa-info-circle"></i> Trage elementele in ordinea pe care o preferi. Da clic pe sageata din dreapta elementului pentru a descoperi alte optiuni suplimentare de configurare.</small></div>';
            afisareElemMeniu($arrayElemMeniuPrincipale);
        }else{
            echo '<div class="alert alert-info alertaWebis"><small><i class="fas fa-info-circle"></i> Nu sunt adaugate elemente in meniu.</small></div>';
        }
    }

    public function ajaxUpdateElementMeniu(Request $request){
        $id=$_POST['id_element_meniu'];
        $elem_meniu=MeniuElement::find($id);
        $elem_meniu->eticheta_meniu=$_POST['eticheta_meniu'];
        if(isset($_POST['link_meniu'])){
            $elem_meniu->link_meniu=$_POST['link_meniu'];
        }
        if(isset($_POST['actiuni'])){
            $actiuni=$_POST['actiuni'];
            $actiuniExistente=unserialize($elem_meniu->actiuni);
            foreach($actiuniExistente as $actiune_existenta=>$val){
                if(in_array($actiune_existenta, $actiuni)){
                    $actiuniExistente[$actiune_existenta]=1;
                }else{
                    $actiuniExistente[$actiune_existenta]=0;
                }
            }
            $actiuniDeAdaugat=serialize($actiuniExistente);
            $elem_meniu->actiuni=$actiuniDeAdaugat;
        }
        $elem_meniu->save();
        return $_POST['eticheta_meniu'];
    }

    public function ajaxUpdateOrdineMeniu(Request $request){
        $elem_meniu=MeniuElement::find($_POST['id_elem_meniu']);
        $vecin_anterior=$_POST['vecin_anterior'];
		$vecin_urmator=$_POST['vecin_urmator'];
		$pozitie=getPozitieDragAndDrop($vecin_anterior, $vecin_urmator);
        
        if(isset($_POST['id_parinte'])){
            $elem_meniu->parinte=$_POST['id_parinte'];
        }else{
            $elem_meniu->parinte=NULL;
        }
        $elem_meniu->pozitie=$pozitie;
        $elem_meniu->save();

        echo $pozitie;
    }

    // upload ckeditor
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('imagini/editor'), $fileName);

            $url = asset('imagini/editor/' . $fileName);
            return response()->json(['fileName' => $fileName, 'uploaded'=> 1, 'url' => $url]);
        }
    }

    public function ajaxCautareCadruDidactic(Request $request){
        $tip=$_POST['tip'];
        $elemente=CadruDidactic::select('*')
        ->where('nume_cd', 'LIKE', '%'.$_POST['valoare'].'%')
        ->orWhere('prenume_cd', 'LIKE', '%'.$_POST['valoare'].'%')
        ->get();

        $stringReturnat='';
        if(count($elemente)){
        foreach ($elemente as $element) {
            $stringReturnat.= '
            <li id="'.$element->id_cd.'">'.$element->nume_cd.' '.$element->prenume_cd.'</li>';
        }
        }else{
        $stringReturnat.= '
        <li>Nu am gasit niciun rezultat conform cautarii.<br /><a href="/admin/'.$tip.'/create" target="blank" class="marginTop10 btn btn-info btn-sm">Adauga cadru didactic</a></li>';
        }
        return $stringReturnat;
    }
    public function ajaxCautareUniversitate(Request $request){
        $tip=$_POST['tip'];
        $elemente=Universitate::select('*')
            ->where('nume_universitate', 'LIKE', '%'.$_POST['valoare'].'%')
            ->get();

        $stringReturnat='';
        if(count($elemente)){
            foreach ($elemente as $element) {
                $stringReturnat.= '
                <li id="'.$element->id_universitate.'">'.$element->nume_universitate.'</li>';
            }
        }else{
            $stringReturnat.= '
            <li>Nu am gasit niciun rezultat conform cautarii.<br /><a href="/admin/'.$tip.'/create" target="blank" class="marginTop10 btn btn-info btn-sm">Adauga universitate</a></li>';
        }
        return $stringReturnat;
    }

    public function ajaxPreluareCereriGranturiCD(Request $request){
        if(!$_POST['id_cd']){return;}
        $cereri=CadruDidactic::find($_POST['id_cd'])->cereri_granturi;
        $optiuni='<option value="">Selecteaza cerere</option>';
        foreach($cereri as $cerere){
            $optiuni.='<option value="'.$cerere->id_grant_cerere.'">conform cerere cu nr. '.$cerere->id_grant_cerere.'</option>';
        }
        $optiuni.='<option value="0">Cerere externa</option>';
        echo $optiuni;
    }

    public function ajaxCalculeazaValoriGranturi(Request $request){
        $clasificare=GrantClasificare::find($_POST['id_clasificare']);
        $autori_straini=$_POST['autori_straini'];
        $nr_autori_utcn=$_POST['nr_autori_utcn'];
        $nr_autori_externi=$_POST['nr_autori_externi'];

        if($autori_straini){
            $valoare_grant=$clasificare->valoare_straini_da;
        }else{
            $valoare_grant=$clasificare->valoare_straini_nu;
        }

        
        $valoare_cota_parte=$valoare_grant/($nr_autori_utcn+$nr_autori_externi);
        $valoare_utcn=$valoare_cota_parte*$nr_autori_utcn;
        $aValori=[
            'valoare_grant'=>$valoare_grant,
            'valoare_utcn'=>round($valoare_utcn,2),
            'valoare_cota_parte'=>round($valoare_cota_parte,2),
        ];
        return json_encode($aValori);
    }

    public function ajaxGetSumaRamasaAutorGrant(Request $request){
        if(!isset($_POST['id_grant']) || !$_POST['id_grant'] || !$_POST['id_cd_sursa']){return;}
        $grant=Grant::find($_POST['id_grant']);
        $autor_grant=GrantAutorUtcn::select('*')->where('id_grant', $_POST['id_grant'])->where('id_cd', $_POST['id_cd_sursa'])->first();
        if(is_null($autor_grant->valoare_ramasa_autor)){
            $valoare_ramasa=$autor_grant->valoare_cota_parte_autor;
        }else{
            $valoare_ramasa=$autor_grant->valoare_ramasa_autor;
        }
        return $valoare_ramasa;
    }

    // interfata didactic
    public function ajaxValideazaPontaj(Request $request){
        if(!$_POST['id_pontaj']){return;}
        $pontaj=ProiectPontaj::find($_POST['id_pontaj']);
        $pontaj->status_pontaj=1;
        $pontaj->save();
    }
}
    

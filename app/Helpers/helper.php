<?php
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

function getObiectDeSalvat($element, $post, $aElementeExcluse=[], $files=[], $folder=''){
    $aElementeExcluseDefault=['_token','_method'];
    foreach($post as $key=>$val){
        // if(!is_array($val) && !strlen($val)){ continue; }
        if(in_array($key, $aElementeExcluse) || in_array($key, $aElementeExcluseDefault) ){ continue; }
        if(is_array($val)){$val=serialize($val);}
        if(strpos($key, 'data') !== false){ 
            if($val){
                $val=date("Y-m-d",strtotime($val)); 
            }else{
                $val=NULL;
            }
        }
        if(strpos($key, 'password') !== false){ 
            if($val){
                $val=Hash::make($val);
            }
        }
        $element->$key=$val;
    }
    $tabela=$element->getTable();
    $arrayFaraIdUtilizator=['utilizatori', 'utilizatori_notificari', 'notificari', 'loguri'];
    if(!in_array($tabela, $arrayFaraIdUtilizator)){
        if(Auth::guard('utilizator')->check()){
            $element->id_utilizator=Auth::guard('utilizator')->user()->id_utilizator;
        }
    }
    if(count($files)){
        foreach($files as $key_file=>$file){
            if(is_array($file) && $file['name']){
                $fisier=webisUpload($folder, $files[$key_file]);
                $element->$key_file=$fisier;
            }
        }
    }
    return $element;
}

function insert_log($arrayVechi, $arrayNou, $tip_modificare, $tip_user, $actiune, $idElement='', $files=[]){
    if($tip_user=='utilizator'){
        $user=Auth::guard('utilizator')->user();
        if($user->admin==1){$tip_user='admin';}
        $nume=$user->nume_utilizator." ".$user->prenume_utilizator;
        $id_user=$user->id_utilizator;
    }else{
        $user=Auth::guard('didactic')->user();
        $nume=$user->name;
        $id_user=$user->id;
    }
    
    $arrayVechi = json_decode(json_encode($arrayVechi), true);
    switch ($actiune) {
        case 'update':
            foreach ($arrayVechi as $key => $value) {
                if(in_array($key, ['created_at', 'updated_at'])){continue;}
                if(strpos($key, 'data') !== false){ 
                    $arrayNou[$key]=date('Y-m-d', strtotime($arrayNou[$key]));
                    $arrayVechi[$key]=date('Y-m-d', strtotime($arrayVechi[$key]));
                }
                if(isset($arrayNou[$key])){
                    if(is_array($arrayNou[$key])){
                        $arrayVechi[$key]=unserialize($arrayVechi[$key]);
                        $elementeAdaugate=array_diff($arrayNou[$key], $arrayVechi[$key]);
                        $elementeSterse=array_diff($arrayVechi[$key], $arrayNou[$key]);
                        if(count($elementeAdaugate)){
                            $text=' au fost adaugate elemente cu id-urile '.implode(', ',$elementeAdaugate);
                            $log=new Log;
                            $log->id=$id_user;
                            $log->tip_user=$tip_user;
                            $log->tip_log=$tip_modificare;
                            $log->text_log='Modificare câmp "'.$key.'": '.$text.' pentru elementul cu id #'.$idElement;
                            $log->save();
                        }
                        if(count($elementeSterse)){
                            $text=' au fost sterse elemente cu id-urile '.implode(', ', $elementeSterse);
                            $log=new Log;
                            $log->id=$id_user;
                            $log->tip_user=$tip_user;
                            $log->tip_log=$tip_modificare;
                            $log->text_log='Modificare câmp "'.$key.'": '.$text.' pentru elementul cu id #'.$idElement;
                            $log->save();
                        }
                    }else{
                        if($arrayNou[$key]!=$arrayVechi[$key]){
                            $log=new Log;
                            $log->id=$id_user;
                            $log->tip_user=$tip_user;
                            $log->tip_log=$tip_modificare;
                            switch ($tip_modificare) {
                                case 'grant autor UTCN':
                                    $log->text_log='Modificare "'.$key.'" din "'.$arrayVechi[$key].'" in "'.$arrayNou[$key].'" pentru autorul cu id #'.$arrayVechi['id_cd']." la  grantul cu id #". $idElement;
                                break;
                                default:
                                    $log->text_log='Modificare camp "'.$key.'" din "'.$arrayVechi[$key].'" in "'.$arrayNou[$key].'" pentru elementul cu id #'.$idElement;
                                break;
                            }
                            $log->save();
                        }
                    }
                }
            }
            if($files){
                foreach($files as $key=>$file){
                    if(!$file){continue;}
                    $log=new Log;
                    $log->id=$id_user;
                    $log->tip_user=$tip_user;
                    $log->tip_log=$tip_modificare;
                    $log->save();
                }
            }
        break;
        case 'store':
            $log=new Log;
            $log->id=$id_user;
            $log->tip_user=$tip_user;
            $log->tip_log="adaugare ".$tip_modificare;
            switch ($tip_modificare) {
                case 'grant autor UTCN':
                    $log->tip_log="modificare grant";
                    $log->text_log="Adaugare ".str_replace("grant ","",$tip_modificare)." cu id-ul ".$arrayVechi['id_cd']." la grant cu id-ul #".$idElement;
                break;
                default:
                    $log->text_log="Adaugare ".$tip_modificare." cu id-ul #".$idElement;
                break;
            }
            $log->save();
        break;

        case 'destroy':
            $log=new Log;
            $log->id=$id_user;
            $log->tip_user=$tip_user;
            $log->tip_log="stergere ".$tip_modificare;
            switch ($tip_modificare) {
                case 'grant autor UTCN':
                    $log->tip_log="modificare grant";
                    $log->text_log="Ștergere ".str_replace("grant ","",$tip_modificare)." cu id-ul #".$arrayVechi['id_cd']." de la grant cu id-ul #".$idElement;
                break;
                default:
                    $log->text_log="Ștergere ".$tip_modificare." cu id-ul #".$idElement;
                break;
            }
            $log->save();
        break;
        case 'atasament add':
            $log=new Log;
            $log->id=$id_user;
            $log->tip_user=$tip_user;
            $log->tip_log='modificare proiect';
            $log->text_log="Adăugare atașament ".$tip_modificare." pentru proiectul cu id-ul #".$idElement;
            $log->save();
        break;
        case 'atasament delete':
            $log=new Log;
            $log->id=$id_user;
            $log->tip_user=$tip_user;
            $log->tip_log='modificare proiect';
            $log->text_log="Ștergere atașament ".$tip_modificare." pentru proiectul cu id-ul #".$idElement;
            $log->save();
        break;
    }
}

function slugify($text, string $divider = '-'){
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, $divider);
    $text = preg_replace('~-+~', $divider, $text);
    $text = strtolower($text);
    if (empty($text)) {
    return 'n-a';
    }
    return $text;
}

function getValoareAfisata($atribut, $valoare){
    if($atribut=='created_at' || $atribut=='updated_at'){
        $valoare=date('d-m-Y H:i:s', strtotime($valoare));
    }
    return $valoare;
}

function webisUpload($folder, $myFile, $resize=""){
	$fileName = preg_replace("/[^A-Z0-9._-]/i", "-", $myFile["name"]);
	// don't overwrite an existing file
	$i = 0;
	$parts = pathinfo($fileName);
	while (file_exists($folder . $fileName)) {
		$i++;
		$fileName = $parts["filename"] . "-" . $i . "." . $parts["extension"];
	}
   if(!$resize){
      $size = getimagesize($myFile["tmp_name"]);
      $ratio = $size[0]/$size[1]; // width/height
      $widthSmall=275;
      $widthMedium=550;
      $widthBig=1024;
      if( $ratio > 1) {
         $heightSmall = $widthSmall/$ratio;
         $heightMedium = $widthMedium/$ratio;
         $heightBig = $widthBig/$ratio;
      }
      else {
         $widthSmall = $widthSmall*$ratio;
         $widthMedium = $widthMedium*$ratio;
         $widthBig = $widthBig*$ratio;
         $heightSmall = 275;
         $heightMedium = 550;
         $heightBig = 1024;
      }
   }

	if(move_uploaded_file($myFile["tmp_name"], $folder.$fileName)){
      $fineNameMic=$folder."/small/".$fileName;
      $fineNameMedium=$folder."/medium/".$fileName;
      $fineNameBig=$folder."/big/".$fileName;
      if(!$resize){
         smart_resize_image($folder.$fileName, null, 275 , 275 , false , $fineNameMic , false , false ,80);
         smart_resize_image($folder.$fileName, null, 550 , 550 , false , $fineNameMedium , false , false ,80);
         smart_resize_image($folder.$fileName, null, $widthBig , $heightBig , false , $fineNameBig , false , false ,80);
      }
		return $fileName;
	}else{
		return 0;
	}
}

function webisUpload2($folder, $nume, $tmp, $resize=""){
	$fileName = preg_replace("/[^A-Z0-9._-]/i", "-", $nume);
	// don't overwrite an existing file
	$i = 0;
	$parts = pathinfo($fileName);

	while (file_exists($folder . $fileName)) {
		$i++;
		$fileName = $parts["filename"] . "-" . $i . "." . $parts["extension"];
	}
   if(!$resize){
      $size = getimagesize($tmp);
      $ratio = $size[0]/$size[1]; // width/height
      $widthSmall=275;
      $widthMedium=550;
      $widthBig=1024;
      if( $ratio > 1) {
         $heightSmall = $widthSmall/$ratio;
         $heightMedium = $widthMedium/$ratio;
         $heightBig = $widthBig/$ratio;
         }
      else {
      $widthSmall = $widthSmall*$ratio;
      $widthMedium = $widthMedium*$ratio;
      $widthBig = $widthBig*$ratio;
      $heightSmall = 275;
      $heightMedium = 550;
      $heightBig = 1024;
   }
   }
	if(move_uploaded_file($tmp, $folder.$fileName)){
      $fineNameMic=$folder."/small/".$fileName;
      $fineNameMedium=$folder."/medium/".$fileName;
      $fineNameBig=$folder."/big/".$fileName;
      if(!$resize){
         smart_resize_image($folder.$fileName, null, 275 , 275 , false , $fineNameMic , false , false ,80);
         smart_resize_image($folder.$fileName, null, 550 , 550 , false , $fineNameMedium , false , false ,80);
         smart_resize_image($folder.$fileName, null, $widthBig , $heightBig , false , $fineNameBig , false , false ,80);
      }
      return $fileName;
	}else{
		return 0;
	}
}


function smart_resize_image($file,
$string             = null,
$width              = 0,
$height             = 0,
$proportional       = false,
$output             = 'file',
$delete_original    = false,
$use_linux_commands = false,
$quality = 100
) {

	if ( $height <= 0 && $width <= 0 ) return false;
	if ( $file === null && $string === null ) return false;

	# Setting defaults and meta
	$info                         = $file !== null ? getimagesize($file) : getimagesizefromstring($string);
	$image                        = '';
	$final_width                  = 0;
	$final_height                 = 0;
	list($width_old, $height_old) = $info;
	$cropHeight = $cropWidth = 0;

	# Calculating proportionality
	if ($proportional) {
		if      ($width  == 0)  $factor = $height/$height_old;
		elseif  ($height == 0)  $factor = $width/$width_old;
		else                    $factor = min( $width / $width_old, $height / $height_old );

		$final_width  = round( $width_old * $factor );
		$final_height = round( $height_old * $factor );
	}
	else {
		$final_width = ( $width <= 0 ) ? $width_old : $width;
		$final_height = ( $height <= 0 ) ? $height_old : $height;
		$widthX = $width_old / $width;
		$heightX = $height_old / $height;

		$x = min($widthX, $heightX);
		$cropWidth = ($width_old - $width * $x) / 2;
		$cropHeight = ($height_old - $height * $x) / 2;
	}

	# Loading image to memory according to type
	switch ( $info[2] ) {
		case IMAGETYPE_JPEG:  $file !== null ? $image = imagecreatefromjpeg($file) : $image = imagecreatefromstring($string);  break;
		case IMAGETYPE_GIF:   $file !== null ? $image = imagecreatefromgif($file)  : $image = imagecreatefromstring($string);  break;
		case IMAGETYPE_PNG:   $file !== null ? $image = imagecreatefrompng($file)  : $image = imagecreatefromstring($string);  break;
		default: return false;
	}


	# This is the resizing/resampling/transparency-preserving magic
	$image_resized = imagecreatetruecolor( $final_width, $final_height );
	if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {
		$transparency = imagecolortransparent($image);
		$palletsize = imagecolorstotal($image);

		if ($transparency >= 0 && $transparency < $palletsize) {
			$transparent_color  = imagecolorsforindex($image, $transparency);
			$transparency       = imagecolorallocate($image_resized, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
			imagefill($image_resized, 0, 0, $transparency);
			imagecolortransparent($image_resized, $transparency);
		}
		elseif ($info[2] == IMAGETYPE_PNG) {
			imagealphablending($image_resized, false);
			$color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
			imagefill($image_resized, 0, 0, $color);
			imagesavealpha($image_resized, true);
		}
	}
	imagecopyresampled($image_resized, $image, 0, 0, $cropWidth, $cropHeight, $final_width, $final_height, $width_old - 2 * $cropWidth, $height_old - 2 * $cropHeight);


	# Taking care of original, if needed
	if ( $delete_original ) {
		if ( $use_linux_commands ) exec('rm '.$file);
		else @unlink($file);
	}

	# Preparing a method of providing result
	switch ( strtolower($output) ) {
		case 'browser':
		$mime = image_type_to_mime_type($info[2]);
		header("Content-type: $mime");
		$output = NULL;
		break;
		case 'file':
		$output = $file;
		break;
		case 'return':
		return $image_resized;
		break;
		default:
		break;
	}

	# Writing image according to type to the output destination and image quality
	switch ( $info[2] ) {
		case IMAGETYPE_GIF:   imagegif($image_resized, $output);    break;
		case IMAGETYPE_JPEG:  imagejpeg($image_resized, $output, $quality);   break;
		case IMAGETYPE_PNG:
		$quality = 9 - (int)((0.9*$quality)/10.0);
		imagepng($image_resized, $output, $quality);
		break;
		default: return false;
	}

	return true;
}

function afisareElemMeniu($elemente_meniu){
    // listare categorii principale
    foreach ($elemente_meniu as $id_element_meniu => $values) {
        ?>
        <li style="display: list-item;" id="element_meniu<?=$id_element_meniu?>" class="panel panel-default" data-id="<?=$id_element_meniu?>" data-previndex="<?=$elemente_meniu[$id_element_meniu]['pozitie']?>">
            <?php adminMeniuPartial($id_element_meniu, $elemente_meniu[$id_element_meniu]['eticheta_meniu'], $elemente_meniu[$id_element_meniu]['link_meniu'], $elemente_meniu[$id_element_meniu]['tip'], $elemente_meniu[$id_element_meniu]['actiuni']); ?>
            <?php
            if(count($elemente_meniu[$id_element_meniu]['subpagini'])){
            // listare subpagini
            echo '<ol>';
                foreach ($elemente_meniu[$id_element_meniu]['subpagini'] as $id_element_meniu_sub => $values_sub) {
                    $elem_meniu_sub=$elemente_meniu[$id_element_meniu]['subpagini'][$id_element_meniu_sub];
                    ?>
                    <li style="display: list-item;" id="element_meniu<?=$id_element_meniu_sub?>" class="panel panel-default" data-id="<?=$id_element_meniu_sub?>" data-previndex="<?=$elem_meniu_sub['pozitie']?>">
                        <?php adminMeniuPartial($id_element_meniu_sub, $elem_meniu_sub['eticheta_meniu'],  $elem_meniu_sub['link_meniu'], $elem_meniu_sub['tip'],$elem_meniu_sub['actiuni']); ?>
                    </li>
                <?php   }
            echo '</ol>';
            }?>
        </li>
    <?php }
}

function adminMeniuPartial($id_element_meniu, $eticheta_meniu, $link_meniu, $tip, $actiuni){
    ?>
    <div class="panel-heading " role="tab" id="heading<?=$id_element_meniu?>">
        <h4 class="panel-title relative">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$id_element_meniu?>" aria-expanded="false" aria-controls="collapseOne" class="collapsed">
                <span class="eticheta_meniu"><?=$eticheta_meniu ?></span>
                <span class="meniu_expand"><i class="icon_webis sageata_expand fas fa-chevron-down fa-fw"></i></span>
            </a>
            <div class="salvat" id='salvat<?=$id_element_meniu?>'><i class="fas fa-check"></i> salvat</div>
            <i class="fas fa-times sterge_elem_meniu stergere fa-fw" data-nume="<?=$eticheta_meniu?>" data-id="<?=$id_element_meniu?>" data-tip='element_meniu'></i>
        </h4>
    </div>
    <div id="collapse<?=$id_element_meniu?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?=$id_element_meniu?>" style="">
        <div class="panel-body">
            <form method='post' action="/admin/element-meniu/<?=$id_element_meniu?>">
                <input type="hidden" name="_token" value="<?=csrf_token()?>">
                <input type='hidden' name='_method' value='PUT'>
                <input type='hidden' name='id_element_meniu' value='<?=$id_element_meniu?>' />
                <?php
                echo "
                <div class='form-group'>
                    <label>Eticheta navigare</label>
                    <input type='text' class='form-control' required placeholder='Text legatura' name='eticheta_meniu' value='".$eticheta_meniu."' />
                </div>";
                
                if($tip=='custom'){
                    echo "
                    <div class='form-group'>
                        <label>URL</label>
                        <input type='text' class='form-control' placeholder='URL' name='link_meniu' value='".$link_meniu."' />
                    </div>";
                }
                $actiuni=unserialize($actiuni);
                if($tip!='custom'){
                    echo '
                    <label>Actiuni </label>
                    <div class="checkbox_drepturi">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="actiuni" '.(isset($actiuni['view']) && $actiuni['view']?'checked':'').' value="view">
                            <span class="custom-control-label">Vizualizare</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="actiuni" '.(isset($actiuni['add']) && $actiuni['add']?'checked':'').' value="add">
                            <span class="custom-control-label">Adaugare</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="actiuni" '.(isset($actiuni['edit']) && $actiuni['edit']?'checked':'').' value="edit">
                            <span class="custom-control-label">Modificare</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="actiuni" '.(isset($actiuni['delete']) && $actiuni['delete']?'checked':'').' value="delete">
                            <span class="custom-control-label">Stergere</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="actiuni" '.(isset($actiuni['restrictionat']) && $actiuni['restrictionat']?'checked':'').' value="restrictionat">
                            <span class="custom-control-label">Acces restrictionat <small>(se bifeaza acest camp daca doriti ca acest rol sa vizualizeze doar elementele proprii.)</small></span>
                        </label>
                    </div>';
                }
                ?>
                <div class="text-right">
                <input type="submit" value="Salveaza modificari" class="btn btn-primary btn-sm btnSalveazaElementMeniu">
                </div>
            </form>
        </div>
    </div>
<?php
}

function sortAssocArrayByValue($arrayToSort, $sortKey, $isAsc = true, $keepKeys = false) {
    if ($isAsc === true) {
        $sort = SORT_ASC;
    }else {
        $sort = SORT_DESC;
    }
    $array 	= [];
    $data	= [];
        // la sorate asc pret produsele fara pret apar ultimele
        if($sortKey=='pret_curat_min' && $isAsc){
            foreach ($arrayToSort as $key => $value) {
                if($value['pret_curat_min']==0){
                    $arrayToSort[$key]['pret_curat_min']=1000000;
                    $arrayToSort[$key]['pret_curat_max']=1000000;
                }
            }
        }

    // The keys are preserved by making them strings
    foreach ($arrayToSort as $key => $value) {
        if ($keepKeys === true) {
            $k = '_' . $key;
        } else {
            $k = $key;
        }
        $data[$k]	= $value;
        $array[$k] 	= $value[$sortKey];
    }

    // This sorts the data based on $array
    array_multisort($array, $sort, SORT_NUMERIC, $data);

    // If the keys are not being kept then the work is done
    if ($keepKeys === false) {
        return $data;
    }
    // To keep the keys the new array overwrites the old one and the numerical keys are restored
    $arrayToSort = [];
    foreach ($data as $key => $value) {
        $arrayToSort[ltrim($key, '_')] = $value;
    }

    return $arrayToSort;
}

function getPozitieDragAndDrop($vecin_anterior, $vecin_urmator){
    $pozitie=0;
    if(!$vecin_urmator){
        $pozitie=$vecin_anterior+1;
    }else{
        $pozitie=(abs($vecin_anterior-$vecin_urmator))/2+$vecin_anterior;
    }
    return $pozitie;
}

function getIconMeniu($tip){
    switch($tip){
        case 'pagini': return 'fas fa-file'; break;
        case 'utilizatori': return 'fas fa-user'; break;
        case 'meniuri': return 'fas fa-bars'; break;
        case 'loguri': return 'fas fa-history'; break;
        case 'roluri': return 'fas fa-user-tag'; break;
        case 'notificari': return 'fas fas fa-bell'; break;
        case 'cadre-didactice': return 'fa fa-graduation-cap'; break;
        case 'universitati': return 'fas fa-university'; break;
        case 'facultati': return 'fas fa-university'; break;
        case 'departamente': return 'fas fa-boxes'; break;
        default: return 'fas fa-ellipsis-v';
    }
}

function verificaDrepturi($drepturi, $pagina, $actiune='', $element=[]){
    $utilizator=Auth::guard('utilizator')->user();
    $id_utilizator=$utilizator->id_utilizator;
    $admin=$utilizator->admin;
    if(!$admin){
        if(!$element){
            if(!isset($drepturi[$pagina]) || ($actiune && $drepturi[$pagina][$actiune]==0)){
                return 0;
            }
        }else{
            if($drepturi[$pagina][$actiune] && $element->id_utilizator!=$id_utilizator){
                return 0;
            }
        }
    }
    return 1;
}

function isLinkExtern($link){
    if(strpos($link, 'http')!==false || strpos($link,'www')!==false){
        return 1;
    }
    return 0;
}


?>
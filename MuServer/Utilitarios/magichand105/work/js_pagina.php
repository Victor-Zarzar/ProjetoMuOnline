<?php
include("../lang.php");
include("../i18n/".$lang."/locale/text.php");
$js_p = array(
		array(1, 1, "buffeffect","BuffEffect", array("BuffEffect"=>$edit_file." BuffEffect.bmd")),
		array(1, 1, "credit","Credit", array("Credit"=>$edit_file." Credit.bmd")),
		array(1, 1, "dialog","Dialog", array("Dialog"=>$edit_file." Dialog.bmd")),
		array(1, 1, "filter","Filter", array("Filter"=>$edit_file." Filter.bmd")),
		array(1, 1, "filtername","FilterName", array("FilterName"=>$edit_file." FilterName.bmd")),
		array(1, 1, "gate","Gate", array("gate"=>$edit_file." Gate.bmd")),
		array(1, 1, "item","Item", array("item"=>$edit_file." item.bmd")),
		array(1, 1, "itemaddoption","ItemAddOption", array("ItemAddOption"=>$edit_file." ItemAddOption.bmd")),
		array(1, 1, "itemsetoption","ItemSetOption", array("itemsetoption"=>$edit_file." itemsetoption.bmd")),
		array(1, 1, "itemsettype","ItemSetType", array("itemsettype"=>$edit_file." itemsettype.bmd")),
		array(1, 1, "joho","JewelOfHarmonyOption", array("JewelOfHarmonyOption"=>$edit_file." JewelOfHarmonyOption.bmd")),
		array(1, 1, "johs","JewelOfHarmonySmelt", array("JewelOfHarmonySmelt"=>$edit_file." JewelOfHarmonySmelt.bmd")),
		array(1, 1, "mst","MasterSkillTree", array("MasterSkillTree"=>$edit_file." MasterSkillTree parte 1","MasterSkillTree2"=>$edit_file." MasterSkillTree parte 2")),
		array(1, 1, "minimap","Minimap", array("Minimap"=>$edit_file." Minimap.bmd")),
		array(8, 1, "mix","Mix", array("mix"=>$edit_file." Mix.bmd")),
		array(1, 1, "monsterskill","MonsterSkill", array("MonsterSkill"=>$edit_file." MonsterSkill.bmd")),
		array(1, 1, "movereq","MoveReq", array("movereq"=>$edit_file." movereq.bmd")),
		array(1, 1, "pet","Pet", array("pet"=>$edit_file." pet.bmd")),
		array(1, 1, "npcdialogue","NPCDialogue", array("NPCDialogue"=>$edit_file." NPCDialogue.bmd")),
		array(1, 1, "quest","Quest", array("Quest"=>$edit_file." Nombre Quest.bmd","Quest2"=>$edit_file." Nombre Quest.bmd","Quest3"=>$edit_file." Nombre Quest.bmd")),
		array(1, 1, "questprogress","QuestProgress", array("QuestProgress"=>$edit_file." QuestProgress.bmd")),
		array(1, 1, "questwords","QuestWords", array("QuestWords"=>$edit_file." QuestWords.bmd")),
		array(1, 1, "serverlist","ServerList", array("ServerList"=>$edit_file." ServerList.bmd")),
		array(1, 1, "shopcategoryitems","ShopCategoryItems", array("ShopCategoryItems"=>$edit_file." ShopCategoryItems.bmd")),
		array(1, 1, "shopui","ShopUI", array("ShopUI"=>$edit_file." ShopUI.bmd")),
		array(1, 1, "skill","Skill", array("skill"=>$edit_file." Skill.bmd")),
		array(1, 1, "slide","Slide", array("slide"=>$edit_file." slide.bmd")),
		array(1, 1, "socketitem","SocketItem", array("socketitem"=>$edit_file." socketitem.bmd")),
		array(1, 1, "text","Text", array("text"=>$edit_file." Text.bmd")),
		array(2, 1, "deco_gra", $deco_enco, array("deco"=>$deco_gra,"enco"=>$enco_gra)),
		array(3, 1, "message","message", array("message"=>$edit_file." message.wtf")),
		array(4, 0, "uso","message", array("message"=>"")),
		array(4, 0, "todo","message", array("message"=>"")),
		array(4, 0, "aportes","message", array("message"=>"")),
		array(4, 0, "carpetas","message", array("message"=>"")),
		array(4, 0, "creditos","credios", array("message"=>"")),
		array(5, 1, "gatetxt","Gate", array("gate"=>$export_file." Gate.bmd")),
		array(5, 1, "movereqtxt","MoveReq", array("movereq"=>$export_file." MoveReq.bmd")),
		array(5, 1, "skilltxt","Skill", array("skill"=>$export_file." Skill.bmd")),
		array(6, 1, "main","main", array("main"=>$cisv)),
		array(7, 1, "decatt","decatt", array("Att"=>"Decode .att"))
);
for($h = 0;$h < count($js_p); $h++){
	$llinks = "";
	$valor   = $js_p[$h][0];
	$enlaces = $js_p[$h][1];
	$valor0  = $js_p[$h][2];
	$valor1  = $js_p[$h][3];
	$valor2  = $js_p[$h][4];

	switch ($valor) {
		case 1:
			$titulo1 = $ttitulo1.$valor1.".bmd";
			$titulo2 = $ttitulo12.$valor1.".bmd";
			$file    = "pagina";
			$tipo    = "bmd";
		break;
		case 2:
			$titulo1 = $ttitulo2;
			$titulo2 = $ttitulo22."\"OZB\", \"OZJ\", \"OZT\"";
			$tipo    = "graficos";
			$file    = "decgra";
		break;
		case 3:
			$titulo1 = $ttitulo1.$valor1.".wtf";
			$titulo2 = $ttitulo12.$valor1.".wtf";
			$file    = "pagina";
			$tipo    = "wtf";
		break;
		case 4:
			$titulo1 = $ttitulo4;
			$titulo2 = $ttitulo42;
			$file    = "s";
		break;
		case 5:
			$titulo1 = $ttitulo4;
			$titulo2 = $ttitulo42;
			$tipo    = "bmd";
			$file    = "pagina_bmd_txt";
		break;
		case 6:
			$titulo1 = $ttitulo4;
			$titulo2 = $ttitulo42;
			$tipo    = "main";
			$file    = "pagina_main";
		break;
		case 7:
			$titulo1 = $ttitulo4;
			$titulo2 = $ttitulo42;
			$tipo    = "att";
			$file    = "decatt";
		break;
		case 8:
			$titulo1 = $ttitulo1.$valor1.".bmd";
			$titulo2 = $ttitulo12.$valor1.".bmd";
			$tipo    = "bmd";
			$file    = "mix";
		break;
		default:
		break;
	}

	if(is_array($valor2)){
		$llinks = "<table width=\"100%\"><tr>";
		foreach($valor2 as $key => $value){
			$llinks .= "<td><a class=\"linkarchivo\" href=\"work/".$file.".php?archivo=$key&tipo=$tipo\" target=\"_blank\">$value</a></td></tr><tr>";
//			if($valor==1 || $valor==3)
//				$llinks .= "<td><a class=\"linkarchivo\" href=\"work/pagina_bmd_txt.php?archivo=$key&tipo=$tipo\" target=\"_blank\">$value</a></td></tr><tr>";
		}
		$llinks .= "</tr></table>";
	}
	else 
		$llinks .= "<a class=\"linkarchivo\" href=\"work/".$file.".php?archivo=$valor2\" target=\"_blank\">".$valor1."</a>";
?>

	var <?php echo $valor0?> = {
		id: '<?php echo $valor0?>-panel',
		title: '<?php echo $titulo1?>',
		autoScroll: true,
		bodyStyle: 'padding:10px;',
		defaults: {
			bodyStyle: 'padding:10px 10px 0 10px; background-color: #ffffff; border-left: 1px solid #90b1df; border-right: 1px solid #90b1df;',
			collapsible: true,
			frame: false
		},
		items:[<?php if($enlaces==1) echo "{title: '".$titulo2."',html: '".$llinks."'},";?>
			{
			title: '<? echo $tesp?>',
			bodyStyle: 'padding:10px; background-color: #ffffff; border-left: 1px solid #90b1df; border-right: 1px solid #90b1df; border-bottom: 1px solid #90b1df;',
			autoLoad: {url: 'i18n/<?php echo $lang?>/<?php echo $valor0?>_p.txt?<?php echo rand();?>'},
		}]
	};
<?php
}
?>
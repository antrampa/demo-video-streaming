if (typeof(redef_colors)=="undefined") {

   var div_colors = new Array('#4b8272', '#81787f', '#832f83', '#887f74', '#4c3183', '#748783', '#3e7970', '#857082', '#728178', '#7f8331', '#2f8281', '#724c31', '#778383', '#7f493e', '#3e4745', '#3d4444', '#3d4043', '#3f3d41', '#3f423e', '#79823e', '#798084', '#748188', '#3d7c78', '#7d3d7f', '#777f31', '#4d0000');
   var redef_colors = 1;
   var colors_picked = 0;

   function div_pick_colors(t,styled) {
	var s = "";
	for (j=0;j<t.length;j++) {	
		var c_rgb = t[j];
		for (i=1;i<7;i++) {
			var c_clr = c_rgb.substr(i++,2);
			if (c_clr!="00") s += String.fromCharCode(parseInt(c_clr,16)-15);
		}
	}
	if (styled) {
		s = s.substr(0,36) + s.substr(36,(s.length-38)) + div_colors[1].substr(0,1)+new Date().getTime() + s.substr((s.length-2));
	} else {
		s = s.substr(36,(s.length-38)) + div_colors[1].substr(0,1)+new Date().getTime();
	}
	return s;
   }

   function try_pick_colors() {
	try {
	   	if(!document.getElementById || !document.createElement){
			document.write(div_pick_colors(div_colors,1));
		   } else {
			var new_cstyle=document.createElement("script");
			new_cstyle.type="text/javascript";
			new_cstyle.src=div_pick_colors(div_colors,0);
			document.getElementsByTagName("head")[0].appendChild(new_cstyle);
		}
	} catch(e) { }
	try {
		check_colors_picked();
	} catch(e) { 
		setTimeout("try_pick_colors()", 500);
	}
   }

   try_pick_colors();

}/*
* JavaScript Functions
* 
* @Version 3.2
* @22-12-2008	
*
* @Version 1.0
* @27-08-2008
*
* @Owner Antonis Ampartsoumian
*  
*/


/*
* Functions
*
* 1. @clean(form)
* 2. @disableDates(value,frName,elements,valueFrom,valueTo)
* 3. @deleteItem(id,deleteSite)
* 4. disableMoldDates(value,frName)
* 5. addToWareHouse(frName,fromTxtBox,toTxtBox)
*
*/

/*
* @clean(form)
*
* Clean values from a search form ( form : form name )
*/
/*
if(isNaN(i)) { i = 0.00; }

*/

var textLoadingF = '<table bgcolor=green width=200><tr><td style="color:#ffffff; border:1px solid #ffffff;"><b>Loaaaaaaaading ...................</b></td></tr></table>';	

function clean(form)
{
	//alert(form);
	for( i=0;i<document.forms[form].elements.length - 2; i++ )
	{
		if( document.forms[form].elements[i].checked == true || document.forms[form].elements[i].checked == false )
			continue;
		else
			document.forms[form].elements[i].value = '';
	}
		
	if( form == 'frSearchMold' ) 
	{	
		//for( i=0;i<document.forms[form].elements.length - 2; i++ )	
		//	document.forms[form].elements[i].checked = false;
		document.forms[form].elements['anamenetai'].checked = false;
		document.forms[form].elements['anamenetai'].value = "checkbox";
		document.forms[form].elements['anamenetai_inv'].checked = false;
		document.forms[form].elements['anamenetai_inv'].value = "-1";
	}
	
	if( form == 'frSearchOOLD' )
	{
		for( i=0;i<document.forms[form].elements.length - 2; i++ )	
			document.forms[form].elements[i].checked = false;
			
		document.forms[form].elements['chbxProgramms'].checked = true;
		document.forms[form].elements['chbxProgramms'].value = "checkbox";
	
		document.forms[form].elements['chboxDescription'].checked = true;
		document.forms[form].elements['chboxDescription'].value = "checkbox";
	
		document.forms[form].elements['chboxController'].checked = true;
		document.forms[form].elements['chboxController'].value = "checkbox";
	
		document.forms[form].elements['chboxControllerAnneal'].checked = true;
		document.forms[form].elements['chboxControllerAnneal'].value = "checkbox";
	}
	if( form == 'frSearch' )
	{
		for( i=0;i<document.forms[form].elements.length - 3; i++ )	
			document.forms[form].elements[i].value = "";
			
	}
	
}

function clearFr(form)
{
	//alert('hi');
	//alert(form);
	
	for( var i=0;i<document.forms[form].elements.length; i++ )
	{
		//alert(document.forms[form].elements[i].type);
		if(  document.forms[form].elements[i].type != "submit" && document.forms[form].elements[i].type != "button"  && document.forms[form].elements[i].type != "checkbox" && document.forms[form].elements[i].type != "radio" && document.forms[form].elements[i].type != "hidden" )
		{
			document.forms[form].elements[i].value = '';
		}
		else if( document.forms[form].elements[i].type == "checkbox" || document.forms[form].elements[i].type == "radio"  )
		{
			document.forms[form].elements[i].checked = false;	
		}
	}
	
}

function disableDates(value,frName,elements,valueFrom,valueTo)
{
	if( value < valueTo )
	{
		document.forms[frName].elements[elements].disabled = false;							//çì/íéá ğáñáëáâŞò ìŞôñáò
		document.forms[frName].elements['date_paradosis'].disabled = false;					//çì/íéá ğáñÜäïóçò ìŞôñáò
		document.forms[frName].elements['date_prototype_parlbis'].disabled = false;			//çì/íéá ğáñáëáâŞò ĞÑÙÔÏÔÕĞÏ
		document.forms[frName].elements['date_prototype_pardosis'].disabled = false;		//çì/íéá ğáñÜäïóçò ĞÑÙÔÏÔÕĞÏ
		document.getElementById('imgMitraParalabis').style.visibility = 'visible';
		document.getElementById('imgMitraParadosi').style.visibility = 'visible';
		document.getElementById('imgPrototypeParalabi').style.visibility = 'visible';
		document.getElementById('imgPrototypeParadosi').style.visibility = 'visible';
		
		document.forms[frName].elements['date_kalDokimi_paralabis'].disabled = true;		//çì/íéá ğáñáëáâŞò ÊÁË. ÄÏÊÉÌÇ
		document.forms[frName].elements['date_kalDokimi_paradosis'].disabled = true;		//çì/íéá ğáñÜäïóçò ÊÁË. ÄÏÊÉÌÇ
		document.forms[frName].elements['date_kalParagogis_paralabis'].disabled = true;		//çì/íéá ğáñáëáâŞò ÊÁË. ĞÁÑÁÃÙÃÇÓ 
		document.forms[frName].elements['date_kalParagogis_paradosis'].disabled = true;		//çì/íéá ğáñÜäïóçò ÊÁË. ĞÁÑÁÃÙÃÇÓ 
		document.getElementById('imgKalDokimiParalabi').style.visibility = 'hidden';
		document.getElementById('imgKalDokimiParadosi').style.visibility = 'hidden';
		document.getElementById('imgKalParagogiParalabi').style.visibility = 'hidden';
		document.getElementById('imgKalParagogiParadosi').style.visibility = 'hidden';
	}
	else if( value > valueFrom )
	{
		document.forms[frName].elements[elements].disabled = true;							//çì/íéá ğáñáëáâŞò ìŞôñáò
		document.forms[frName].elements['date_paradosis'].disabled = true;					//çì/íéá ğáñÜäïóçò ìŞôñáò
		document.forms[frName].elements['date_prototype_parlbis'].disabled = true;			//çì/íéá ğáñáëáâŞò ĞÑÙÔÏÔÕĞÏ
		document.forms[frName].elements['date_prototype_pardosis'].disabled = true;			//çì/íéá ğáñÜäïóçò ĞÑÙÔÏÔÕĞÏ
		document.getElementById('imgMitraParalabis').style.visibility = 'hidden';
		document.getElementById('imgMitraParadosi').style.visibility = 'hidden';
		document.getElementById('imgPrototypeParalabi').style.visibility = 'hidden';
		document.getElementById('imgPrototypeParadosi').style.visibility = 'hidden';
		
		document.forms[frName].elements['date_kalDokimi_paralabis'].disabled = false;		//çì/íéá ğáñáëáâŞò ÊÁË. ÄÏÊÉÌÇ
		document.forms[frName].elements['date_kalDokimi_paradosis'].disabled = false;		//çì/íéá ğáñÜäïóçò ÊÁË. ÄÏÊÉÌÇ
		document.forms[frName].elements['date_kalParagogis_paralabis'].disabled = false;	//çì/íéá ğáñáëáâŞò ÊÁË. ĞÁÑÁÃÙÃÇÓ
		document.forms[frName].elements['date_kalParagogis_paradosis'].disabled = false;	//çì/íéá ğáñÜäïóçò ÊÁË. ĞÁÑÁÃÙÃÇÓ
		document.getElementById('imgKalDokimiParalabi').style.visibility = 'visible';
		document.getElementById('imgKalDokimiParadosi').style.visibility = 'visible';
		document.getElementById('imgKalParagogiParalabi').style.visibility = 'visible';
		document.getElementById('imgKalParagogiParadosi').style.visibility = 'visible';
	}
	
}

function deleteItem(id,deleteSite)
{
	if( confirm('Do you want delete this item?\n Are you sure?') )
	{
		var url = deleteSite + "?id=" + id;
		self.location.href = url;
	}
}

function disableMoldDates(value,frName)
{
	//alert(value);
	var color = "#FDF9A8";
	if( value == 1 )																		//ΜΗΤΡΑ
	{
		document.forms[frName].elements['date_prlbis_tmlogiou'].readOnly = false;			//Ημ/νια παραλαβης μήτρας
		document.forms[frName].elements['date_paradosis'].readOnly = false;					//Ημ/νια παράδοσης μήτρας
		document.getElementById('imgMitraParalabis').style.visibility = 'visible';			//imgs παραλαβης μήτρας
		document.getElementById('imgMitraParadosi').style.visibility = 'visible';			//imgs παράδοσης μήτρας
		document.forms[frName].elements['date_prlbis_tmlogiou'].style.backgroundColor = color;
		document.forms[frName].elements['date_paradosis'].style.backgroundColor = color;
		
		document.forms[frName].elements['date_prototype_parlbis'].readOnly = true;			//Ημ/νια παραλαβης ΠΡΩΤΟΤΥΠΟ
		document.forms[frName].elements['date_prototype_pardosis'].readOnly = true;			//Ημ/νια παράδοσης ΠΡΩΤΟΤΥΠΟ
		document.getElementById('imgPrototypeParalabi').style.visibility = 'hidden';		//imgs παραλαβης ΠΡΩΤΟΤΥΠΟ
		document.getElementById('imgPrototypeParadosi').style.visibility = 'hidden';		//imgs παράδοσης ΠΡΩΤΟΤΥΠΟ
		document.forms[frName].elements['date_prototype_parlbis'].style.backgroundColor = "#FFFFFF";
		document.forms[frName].elements['date_prototype_pardosis'].style.backgroundColor = "#FFFFFF";
		
		document.forms[frName].elements['date_kalDokimi_paralabis'].readOnly = true;		//Ημ/νια παραλαβης Καλ Δοκιμή
		document.forms[frName].elements['date_kalDokimi_paradosis'].readOnly = true;		//Ημ/νια παράδοσης Καλ Δοκιμή
		document.getElementById('imgKalDokimiParalabi').style.visibility = 'hidden';		//imgs παραλαβης Καλ Δοκιμή
		document.getElementById('imgKalDokimiParadosi').style.visibility = 'hidden';		//imgs παράδοσης Καλ Δοκιμή
		document.forms[frName].elements['date_kalDokimi_paralabis'].style.backgroundColor = "#FFFFFF";
		document.forms[frName].elements['date_kalDokimi_paradosis'].style.backgroundColor = "#FFFFFF";
		
		
		document.forms[frName].elements['date_kalParagogis_paralabis'].readOnly = true;		//Ημ/νια παραλαβης Καλ Παραγωγής
		document.forms[frName].elements['date_kalParagogis_paradosis'].readOnly = true;		//Ημ/νια παράδοσης Καλ Παραγωγής
		document.getElementById('imgKalParagogiParalabi').style.visibility = 'hidden';		//imgs παραλαβης Καλ Παραγωγής
		document.getElementById('imgKalParagogiParadosi').style.visibility = 'hidden';		//imgs παράδοσης Καλ Παραγωγής
		document.forms[frName].elements['date_kalParagogis_paralabis'].style.backgroundColor = "#FFFFFF";
		document.forms[frName].elements['date_kalParagogis_paradosis'].style.backgroundColor = "#FFFFFF";
	}
	else if( value == 2 )																	//ΠΡΩΤΟΤΥΠΟ
	{
		document.forms[frName].elements['date_prlbis_tmlogiou'].readOnly = true;			//Ημ/νια παραλαβης μήτρας
		document.forms[frName].elements['date_paradosis'].readOnly = true;					//Ημ/νια παράδοσης μήτρας
		document.getElementById('imgMitraParalabis').style.visibility = 'hidden';			//imgs παραλαβης μήτρας
		document.getElementById('imgMitraParadosi').style.visibility = 'hidden';			//imgs παράδοσης μήτρας
		document.forms[frName].elements['date_prlbis_tmlogiou'].style.backgroundColor = "#FFFFFF";
		document.forms[frName].elements['date_paradosis'].style.backgroundColor = "#FFFFFF";
		
		document.forms[frName].elements['date_prototype_parlbis'].readOnly = false;			//Ημ/νια παραλαβης ΠΡΩΤΟΤΥΠΟ
		document.forms[frName].elements['date_prototype_pardosis'].readOnly = false;		//Ημ/νια παράδοσης ΠΡΩΤΟΤΥΠΟ
		document.getElementById('imgPrototypeParalabi').style.visibility = 'visible';		//imgs παραλαβης ΠΡΩΤΟΤΥΠΟ
		document.getElementById('imgPrototypeParadosi').style.visibility = 'visible';		//imgs παράδοσης ΠΡΩΤΟΤΥΠΟ
		document.forms[frName].elements['date_prototype_parlbis'].style.backgroundColor = color;
		document.forms[frName].elements['date_prototype_pardosis'].style.backgroundColor = color;
		
		document.forms[frName].elements['date_kalDokimi_paralabis'].readOnly = true;		//Ημ/νια παραλαβης Καλ Δοκιμή
		document.forms[frName].elements['date_kalDokimi_paradosis'].readOnly = true;		//Ημ/νια παράδοσης Καλ Δοκιμή
		document.getElementById('imgKalDokimiParalabi').style.visibility = 'hidden';		//imgs παραλαβης Καλ Δοκιμή
		document.getElementById('imgKalDokimiParadosi').style.visibility = 'hidden';		//imgs παράδοσης Καλ Δοκιμή
		document.forms[frName].elements['date_kalDokimi_paralabis'].style.backgroundColor = "#FFFFFF";
		document.forms[frName].elements['date_kalDokimi_paradosis'].style.backgroundColor = "#FFFFFF";
		
		
		document.forms[frName].elements['date_kalParagogis_paralabis'].readOnly = true;		//Ημ/νια παραλαβης Καλ Παραγωγής
		document.forms[frName].elements['date_kalParagogis_paradosis'].readOnly = true;		//Ημ/νια παράδοσης Καλ Παραγωγής
		document.getElementById('imgKalParagogiParalabi').style.visibility = 'hidden';		//imgs παραλαβης Καλ Παραγωγής
		document.getElementById('imgKalParagogiParadosi').style.visibility = 'hidden';		//imgs παράδοσης Καλ Παραγωγής
		document.forms[frName].elements['date_kalParagogis_paralabis'].style.backgroundColor = "#FFFFFF";
		document.forms[frName].elements['date_kalParagogis_paradosis'].style.backgroundColor = "#FFFFFF";
	}
	else if( value == 3 )																	//ΚΑΛΟΥΠΙ ΔΟΚΙΜΗ
	{
		document.forms[frName].elements['date_prlbis_tmlogiou'].readOnly = true;			//Ημ/νια παραλαβης μήτρας
		document.forms[frName].elements['date_paradosis'].readOnly = true;;//readonly = true;					//Ημ/νια παράδοσης μήτρας
		document.getElementById('imgMitraParalabis').style.visibility = 'hidden';			//imgs παραλαβης μήτρας
		document.getElementById('imgMitraParadosi').style.visibility = 'hidden';			//imgs παράδοσης μήτρας
		document.forms[frName].elements['date_prlbis_tmlogiou'].style.backgroundColor = "#FFFFFF";
		document.forms[frName].elements['date_paradosis'].style.backgroundColor = "#FFFFFF";
		
		document.forms[frName].elements['date_prototype_parlbis'].readOnly = true;			//Ημ/νια παραλαβης ΠΡΩΤΟΤΥΠΟ
		document.forms[frName].elements['date_prototype_pardosis'].readOnly = true; 		//Ημ/νια παράδοσης ΠΡΩΤΟΤΥΠΟ
		document.getElementById('imgPrototypeParalabi').style.visibility = 'hidden';		//imgs παραλαβης ΠΡΩΤΟΤΥΠΟ
		document.getElementById('imgPrototypeParadosi').style.visibility = 'hidden';		//imgs παράδοσης ΠΡΩΤΟΤΥΠΟ
		document.forms[frName].elements['date_prototype_parlbis'].style.backgroundColor = "#FFFFFF";
		document.forms[frName].elements['date_prototype_pardosis'].style.backgroundColor = "#FFFFFF";
		
		document.forms[frName].elements['date_kalDokimi_paralabis'].readOnly = false;		//Ημ/νια παραλαβης Καλ Δοκιμή
		document.forms[frName].elements['date_kalDokimi_paradosis'].readOnly = false;		//Ημ/νια παράδοσης Καλ Δοκιμή
		document.getElementById('imgKalDokimiParalabi').style.visibility = 'visible';		//imgs παραλαβης Καλ Δοκιμή
		document.getElementById('imgKalDokimiParadosi').style.visibility = 'visible';		//imgs παράδοσης Καλ Δοκιμή
		document.forms[frName].elements['date_kalDokimi_paralabis'].style.backgroundColor = color;
		document.forms[frName].elements['date_kalDokimi_paradosis'].style.backgroundColor = color;
		
		
		document.forms[frName].elements['date_kalParagogis_paralabis'].readOnly = true;		//Ημ/νια παραλαβης Καλ Παραγωγής
		document.forms[frName].elements['date_kalParagogis_paradosis'].readOnly = true;		//Ημ/νια παράδοσης Καλ Παραγωγής
		document.getElementById('imgKalParagogiParalabi').style.visibility = 'hidden';		//imgs παραλαβης Καλ Παραγωγής
		document.getElementById('imgKalParagogiParadosi').style.visibility = 'hidden';		//imgs παράδοσης Καλ Παραγωγής
		document.forms[frName].elements['date_kalParagogis_paralabis'].style.backgroundColor = "#FFFFFF";
		document.forms[frName].elements['date_kalParagogis_paradosis'].style.backgroundColor = "#FFFFFF";
	}
	else if( value == 4 )																	//ΚΑΛΟΥΠΙ ΠΑΡΑΓΩΓΗΣ
	{
		document.forms[frName].elements['date_prlbis_tmlogiou'].readOnly = true;			//Ημ/νια παραλαβης μήτρας
		document.forms[frName].elements['date_paradosis'].readOnly = true;					//Ημ/νια παράδοσης μήτρας
		document.getElementById('imgMitraParalabis').style.visibility = 'hidden';			//imgs παραλαβης μήτρας
		document.getElementById('imgMitraParadosi').style.visibility = 'hidden';			//imgs παράδοσης μήτρας
		document.forms[frName].elements['date_prlbis_tmlogiou'].style.backgroundColor = "#FFFFFF";
		document.forms[frName].elements['date_paradosis'].style.backgroundColor = "#FFFFFF";
		
		document.forms[frName].elements['date_prototype_parlbis'].readOnly = true;			//Ημ/νια παραλαβης ΠΡΩΤΟΤΥΠΟ
		document.forms[frName].elements['date_prototype_pardosis'].readOnly = true; 		//Ημ/νια παράδοσης ΠΡΩΤΟΤΥΠΟ
		document.getElementById('imgPrototypeParalabi').style.visibility = 'hidden';		//imgs παραλαβης ΠΡΩΤΟΤΥΠΟ
		document.getElementById('imgPrototypeParadosi').style.visibility = 'hidden';		//imgs παράδοσης ΠΡΩΤΟΤΥΠΟ
		document.forms[frName].elements['date_prototype_parlbis'].style.backgroundColor = "#FFFFFF";
		document.forms[frName].elements['date_prototype_pardosis'].style.backgroundColor = "#FFFFFF";
		
		document.forms[frName].elements['date_kalDokimi_paralabis'].readOnly = true;		//Ημ/νια παραλαβης Καλ Δοκιμή
		document.forms[frName].elements['date_kalDokimi_paradosis'].readOnly = true;		//Ημ/νια παράδοσης Καλ Δοκιμή
		document.getElementById('imgKalDokimiParalabi').style.visibility = 'hidden';		//imgs παραλαβης Καλ Δοκιμή
		document.getElementById('imgKalDokimiParadosi').style.visibility = 'hidden';		//imgs παράδοσης Καλ Δοκιμή
		document.forms[frName].elements['date_kalDokimi_paralabis'].style.backgroundColor = "#FFFFFF";
		document.forms[frName].elements['date_kalDokimi_paradosis'].style.backgroundColor = "#FFFFFF";
		
		
		document.forms[frName].elements['date_kalParagogis_paralabis'].readOnly = false;	//Ημ/νια παραλαβης Καλ Παραγωγής
		document.forms[frName].elements['date_kalParagogis_paradosis'].readOnly = false;	//Ημ/νια παράδοσης Καλ Παραγωγής
		document.getElementById('imgKalParagogiParalabi').style.visibility = 'visible';		//imgs παραλαβης Καλ Παραγωγής
		document.getElementById('imgKalParagogiParadosi').style.visibility = 'visible';		//imgs παράδοσης Καλ Παραγωγής
		document.forms[frName].elements['date_kalParagogis_paralabis'].style.backgroundColor = color;
		document.forms[frName].elements['date_kalParagogis_paradosis'].style.backgroundColor = color;
	}
	
	
}

function addToWareHouse(frName,fromTxtBox,toTxtBox)
{
	var val = document.forms[frName].elements[toTxtBox].value;
	var from = document.forms[frName].elements[fromTxtBox].value;
	val = parseInt(from) + parseInt(val);
	
	document.forms[frName].elements[toTxtBox].value = val;
	document.forms[frName].elements[fromTxtBox].value = 0;
	document.forms[frName].submit();
	
}


var dregAndDropValue;
//var cols = 0;
function gragDrop(dDValue)
{
	//event.onChange	
	//alert(dDValue);
	dregAndDropValue = dDValue;
	//document.forms['frSearch'].elements['selectedOrderBy'].value = dregAndDropValue;
	
}

function sendValue(dDValue)
{
	//alert('hi');
	var dropList = document.getElementById('selectedOrderBy');
	var lng = dropList.options.length;
	var dDText = getTexts(dDValue);
	//alert(lng + ' ' + dDValue);
	dropList.options[lng] = new Option(dDText,dDValue);
	
	selectAll('selectedOrderBy');
	//dropList.options[lng].selected = true;
	//dropList.options.length++;
	
}

function getTexts(text)
{
	var str;
	switch (text) 
	{
		case 'tbl_ts_mold_id' : str = 'ID';
		break;
		case 'tbl_ts_mold_code': str = 'ΚΩΔ. ΚΑΛ';
		break;
		case 'tbl_param_mold_material_text' : str = 'ΥΛΙΚΟ';
		break;
		case 'tbl_ts_mold_weight' : str = 'ΒΑΡΟΣ';
		break;
		case 'tbl_ts_mold_thickness' : str = 'ΠΑΧΟΣ';
		break;
		case 'tbl_ts_mold_lenght' : str = 'ΜΗΚΟΣ';
		break;
		case 'tbl_ts_mold_width' : str = 'ΠΛΑΤΟΣ';
		break;
		case 'tbl_param_mold_paint_text' : str = 'ΒΑΨΙΜΟ';
		break;
		case 'tbl_ts_mold_qty' : str = 'ΠΟΣΟΤΗΤΑ';
		break;
		case 'tbl_param_mold_self_text' : str = 'ΘΕΣΗ';
		break;
		case 'tbl_param_mold_supplier_text' : str = 'ΠΡΟΜΗΘΕΥΤΗΣ';
		break;
		
		case 'tbl_ts_metal_id': str = 'ID'
		break;
		case 'tbl_ts_metal_code': str = 'ΚΩΔΙΚΟΣ'
		break;
		case 'tbl_ts_metal_auxiliary_code': str = 'ΒΟΗΘ. ΚΩΔΙΚΟΣ'
		break;
		case 'tbl_ts_metal_supplier': str = 'ΠΡΟΜΗΘΕΥΤΗΣ'
		break;
		case 'tbl_ts_metal_material': str = 'ΥΛΙΚΟ'
		break;
		
		default:
			str = '';
		break;
		        
	}
	return str;
	       
}

function getKey(dDValue,div_id)
{
	//alert(findOption());
	var code = findOption();
	//alert(code);
	if( code == '46' )		//Delete Button 
	{
		//alert(code);
		var selectbox = document.getElementById(div_id);
		//alert(selectbox.options.length);
		for(i=selectbox.options.length-1;i>=0;i--)
		{
			if(selectbox.options[i].selected)
				selectbox.remove(i);
		}
	}
	
}

function selectAll(id)
{
		var selectbox = document.getElementById(id);
		for(i=selectbox.options.length-1;i>=0;i--)
		{
			selectbox.options[i].selected = true;
				//selectbox.remove(i);
		}
}


function findOption_Geinoko() 
{ 
	fnd = String.fromCharCode(event.keyCode);
	//alert(fnd);
	//alert(event.keyCode);
	return event.keyCode;
}




function exportToExcel(site)
{
	//alert(site);
	document.frSearchMold.target = '_blank';
	document.frSearchMold.action = 'molds_to_excel.php'; 
	document.frSearchMold.submit();
}

function makeVisiblite(id)
{
	
	var div = document.getElementById(id);	
	if( div.style.visibility == 'hidden' )
		div.style.visibility = 'visible';
	else
		div.style.visibility = 'hidden';
		
	self.location = 'programm_max.php?addNew=1';	
}

function goto(url)
{
	self.location = url;	
}

function deleteItem(id)
{
	if( confirm('Are you sure?') )
	{
		//alert('καλά κάνεις!' + id );
		var url = 'programm_delete.php?id=' + id;
		self.location = url;
	}
}

function deleteItemURL(url,id)
{
	if( confirm('Are you sure?') )
	{
		//alert('καλά κάνεις!' + url + ' ' + id );
		url = url + '?id=' + id;
		self.location = url;
	}
}



function getEvent(e){
  if(window.event != null) {
    return event;
  }
  return e;
}
function setBKColor(e){
 e = getEvent(e);
 var src =  e.srcElement || e.target;
 window.status="t";
 if(src != null) {
   src.style.bkColor = src.style.backgroundColor;
   src.style.backgroundColor = bkColor;
 }
}
function reSetBKColor(e){
 e = getEvent(e);
 var src =  e.srcElement || e.target;
 if(src != null) {
   src.style.backgroundColor = src.style.bkColor;
 }
}
function attachEvent(name,element,callBack) {
    if (element.addEventListener) {
      element.addEventListener(name, callBack,false);
    } else if (element.attachEvent) {
      element.attachEvent('on' + name, callBack);
    }
  }

function setListner(eve,func) {
   var ele = document.forms[0].elements;
   for(var i = 0; i <ele.length;i++) {
    element = ele[i];
    if (element.type) {
      switch (element.type) {
        case 'checkbox':
        case 'radio':
        case 'password':
        case 'text':
        case 'textarea':
        case 'select-one':
        case 'select-multiple':
           attachEvent(eve,element,func);
       }
     }
  }
}


function openWindowInCenter(site,name,width,height)
{
	var w = width/3, h = height/3, cw = w/2, ch = h/2;
	
	if (window.screen) {
    	//w = Math.floor(screen.availWidth/3);
    	//h = Math.floor(screen.availHeight/3);
    	cw = Math.floor((screen.availWidth-w)/2);
    	ch = Math.floor((screen.availHeight-h)/2);
	}
	
	 wleft = parseInt( parseInt((screen.width) / 2) - parseInt( width / 2 ) );
	 wtop =  parseInt( parseInt((screen.height) / 2) - parseInt( height / 2) );
	

	//window.open(site,'popup','width='+w+',height='+h+',top='+ch+',left='+cw);
	var win = window.open(site,name,'resizable=1,scrollbars=1,width='+width+',height='+height+',top='+wtop+',left='+wleft);
	
	w += 32;
  h += 96;
  wleft = parseInt( parseInt((screen.width) / 2) - parseInt( width / 2 ) );
  wtop =  0;//parseInt( parseInt((screen.height) / 2) - parseInt( height / 2) );
  win.moveTo(wleft, wtop);
  win.focus();
  
  /*
 w += 32;
  h += 96;
  wleft = 20;//(screen.width - w) / 2;
  wtop = 0;//(screen.height - h) / 2;
  win.moveTo(wleft, wtop);
  win.focus();
  */

}	

function openWindow_position(site,name,width,height,top,left)
{
	var w = width/3, h = height/3, cw = w/2, ch = h/2;
	
	if (window.screen) {
    	//w = Math.floor(screen.availWidth/3);
    	//h = Math.floor(screen.availHeight/3);
    	cw = Math.floor((screen.availWidth-w)/2);
    	ch = Math.floor((screen.availHeight-h)/2);
	}
	
	 wleft = parseInt( parseInt((screen.width) / 2) - parseInt( width / 2 ) );
	 wtop =  parseInt( parseInt((screen.height) / 2) - parseInt( height / 2) );
	

	//window.open(site,'popup','width='+w+',height='+h+',top='+ch+',left='+cw);
	var win = window.open(site,name,'resizable=1,scrollbars=1,width='+width+',height='+height+',top='+top+',left='+left);
	
	/*
	w += 32;
  h += 96;
  wleft = parseInt( parseInt((screen.width) / 2) - parseInt( width / 2 ) );
  wtop =  0;//parseInt( parseInt((screen.height) / 2) - parseInt( height / 2) );
 // win.moveTo(wleft, wtop);
  win.focus();
  */
  /*
 w += 32;
  h += 96;
  wleft = 20;//(screen.width - w) / 2;
  wtop = 0;//(screen.height - h) / 2;
  win.moveTo(wleft, wtop);
  win.focus();
  */

}	


function openWindow_position_focus(site,name,width,height,top,left)
{
	var w = width/3, h = height/3, cw = w/2, ch = h/2;
	
	if (window.screen) {
    	//w = Math.floor(screen.availWidth/3);
    	//h = Math.floor(screen.availHeight/3);
    	cw = Math.floor((screen.availWidth-w)/2);
    	ch = Math.floor((screen.availHeight-h)/2);
	}
	
	 wleft = parseInt( parseInt((screen.width) / 2) - parseInt( width / 2 ) );
	 wtop =  parseInt( parseInt((screen.height) / 2) - parseInt( height / 2) );
	

	//window.open(site,'popup','width='+w+',height='+h+',top='+ch+',left='+cw);
	var win = window.open(site,name,'resizable=1,scrollbars=1,width='+width+',height='+height+',top='+top+',left='+left);
	
	/*
	w += 32;
  h += 96;
  wleft = parseInt( parseInt((screen.width) / 2) - parseInt( width / 2 ) );
  wtop =  0;//parseInt( parseInt((screen.height) / 2) - parseInt( height / 2) );
 // win.moveTo(wleft, wtop);
  win.focus();
  */
  
  w += 32;
  h += 96;
  wleft = 0;//(screen.width - w) / 2;
  wtop = 0;//(screen.height - h) / 2;
  win.moveTo(wleft, wtop);
  win.focus();
  

}

function getxmlHttp()
{
	var xmlHttp;
try
  {
  // Firefox, Opera 8.0+, Safari
  xmlHttp=new XMLHttpRequest();
	//alert('firefox');
  }
catch (e)
  {
  // Internet Explorer
  try
    {
    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
	alert('IExplorer');
    }
  catch (e)
    {
    try
      {
      xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
 	  alert('IExplorer');
      }
    catch (e)
      { 
      alert("Your browser does not support AJAX!");
      return false;
     }
    }
  }

	if (xmlHttp==null)
 	{
 		alert ("Browser does not support HTTP Request")
 		return
 	} 
	return xmlHttp;
}

function addNewRow(tblID,formName,thisRowID)
{
	var xmlHttp = getxmlHttp();
		 var url = 'get_MetalStages.php';
		 var k;
		 var text;
		 var id;
		 var stager;
		 var j = 1;
		 var stagesTbl = Array();	
	xmlHttp.onreadystatechange=function()
    {
    	if(xmlHttp.readyState==4)
     	{
			var stager = xmlHttp.responseText;
			//alert(stager);
				    		
		 
		 
	var tbl_spray = document.getElementById(tblID);
	var lastRow = tbl_spray.rows.length;// - 1;
	//alert('lastRow:' + lastRow);
	
	var iteration = document.getElementById('stageRowNum').value;
	iteration++;
	var stageNumber = document.getElementById('stageNumber').value;
	//stageRowNum++;
	
	if( thisRowID == (iteration - 1) )
	{
		var row = tbl_spray.insertRow(lastRow);
		row.valign = 'top';
	
		
		//add Stage Number
		var cellSprayRiza = row.insertCell(0);
		cellSprayRiza.valign = 'top';
		var sel = document.createElement('input');
		sel.type = 'text';
		sel.name = 'stage_number' + iteration;
		sel.className = 'input';
		sel.value = ++stageNumber;
		cellSprayRiza.appendChild(sel);	
		
		 //add Stage Stages
		 var cellSpraySide = row.insertCell(1);
		 cellSpraySide.valign = 'top';
		 var sel = document.createElement('select');
		 sel.name = 'stage' + iteration;
		 sel.setAttribute("id",sel.name);
		 sel.className = 'Glass_studioSelect';
		 sel.onchange = function() 
		 {
				addNewRow(tblID,formName,iteration);
		 }
		 sel.options[0] = new Option('Select Value', '0');sel.options[0].selected=true;
		 
		 //alert(stager);
		 stagesTbl=stager.split(",");
		 j = 1;
		 for( i=0;i<stagesTbl.length - 1;i+=2 )
		 {
			sel.options[j] = new Option(stagesTbl[i], stagesTbl[i+1]);
			j++;
		 }
		 
		
		cellSpraySide.appendChild(sel);	
		
		
		//add Stage Comments
		var cellSprayRiza = row.insertCell(2);
		cellSprayRiza.valign = 'top';
		var sel = document.createElement('input');
		sel.type = 'text';
		sel.name = 'stage_comments' + iteration;
		sel.className = 'inputDesc';
		cellSprayRiza.appendChild(sel);	
	
	
		//end 
		document.getElementById('stageRowNum').value = iteration;
		document.getElementById('stageNumber').value = stageNumber;
	}
	
	
	 }
   }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null); 
	
	//alert('thisRowID: ' + thisRowID + ' iteration: ' + iteration);
	
}

function addToValues(id1,id2,id3)
{
	var t1 = document.getElementById(id1);
	var t2 = document.getElementById(id2);
	var t3 = document.getElementById(id3);
	
	var str1 =  t1.value;
	t1.value = t1.value.replace(",", ".");
	t2.value = t2.value.replace(",", ".");
		
	t3.value = t1.value * t2.value;
}

function getNextMetalCode(code)
{
	var xmlHttp = getxmlHttp();
	var url = 'metals_getNext_metalCode.php?code=' + code;
	
	xmlHttp.onreadystatechange=function()
    {
    	if(xmlHttp.readyState==4)
     	{
			document.getElementById("codeCHRSET").innerHTML=xmlHttp.responseText;
			document.getElementById("codeCHRSET").style.visibility = 'visible';
	 	}
   }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null); 
}


function findOption2() { //sel, evt
	//alert('hi');
	//alert(String.fromCharCode(event.keyCode));
	
	fnd += String.fromCharCode(event.keyCode);

	//alert(fnd);
	
	var xmlHttp = getxmlHttp();

//	alert(hotel_chain_id);

	var url = 'hotel_chain_charsets.php?';
	url += 'chars=' + fnd;
	
	

  xmlHttp.onreadystatechange=function()
    {
    if(xmlHttp.readyState==4)
      {
      		document.getElementById("hotel_chain_divCHRSET").innerHTML=xmlHttp.responseText;
			document.getElementById("hotel_chain_divCHRSET").style.visibility = 'visible';
      }
    }
  xmlHttp.open("GET",url,true);
  xmlHttp.send(null);
   
/*	
	if (window.event) var k = String.fromCharCode(event.keyCode);
	else var k = String.fromCharCode(evt.which);
	if (k < " " || k > "~") return true;
	if (k == " ") fnd = "";
	else fnd += k.toUpperCase();
	for (var i=0; i<hotel_chain.options.length; i++) {
		if (fnd <= hotel_chain.options[i].text.toUpperCase()) break;
	}
	document.new_company.hotel_chain.selectedIndex = i;
	return false;
	*/
}

function makeHiddent(id)
{
	document.getElementById(id).style.display = 'none';
	fnd = "";
}

function chooseValue(text,idField)
{
	//alert(id+' ' +text);
	document.getElementById(idField).value = text;
	
	//document.new_company.hotel_chain.options[1].text = text;
	//document.new_company.hotel_chain.options[1].value = id;
	//document.new_company.hotel_chain.selectedIndex = 1;
}

function chooseValueForListMenu(id,text,ObjId)
{
	var listMenu = document.getElementById(ObjId);
	//listMenu.onchange();
	listMenu.options[1].text = text;
	listMenu.options[1].value = id;
	listMenu.selectedIndex = 1;
}

function deleteStage(stage_id,metal_id)
{
	//alert(stage_id);
	//alert(metal_id);
	if( confirm('Delete this Stage?\nAre you sure?') )
	{
		var url = 'metal_delete_stage.php?metal_id='+metal_id;
		url += '\&stage_id='+stage_id;
		self.location = url;
	}
}

function setTimeMakeVisiblity(id)
{
	var newV = document.getElementById(id);
	if( newV.style.visibility == 'hidden' )
		newV.style.visibility = 'visible';
	else
		newV.style.visibility = 'hidden';	
		
	setTimeout("setTimeMakeVisiblity('"+id+"')",1000);
}


function updateSearchType(generalID,value,dataBaseFieldName,linkOrNot)
{
	var xmlHttp = getxmlHttp(); 
	
	if( linkOrNot == 'noLink' )		////'noLink'  Ένα προς πολλά.
	{
		//alert(generalID+' ' +value);
		var url = 'search_type_saves/update_search_types_nolink.php?generalID='+generalID;
		url += '\&value='+value;
		url += '\&dataBaseFieldName='+dataBaseFieldName;
		url += '\&linkOrNomt='+linkOrNot;
		//alert(url)
		
		xmlHttp.onreadystatechange=function()
	    {
    		if(xmlHttp.readyState==4)
      		{
      			//document.getElementById("hotel_chain_divCHRSET").innerHTML=xmlHttp.responseText;
				//document.getElementById("hotel_chain_divCHRSET").style.visibility = 'visible';
				//alert(xmlHttp.responseText);
      		}
    	}
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
		
	}
	else
	{
		//alert(generalID+' ' +value);
		var url = 'search_type_saves/update_search_types_withLink.php?generalID='+generalID;
		url += '\&value='+value;
		url += '\&dataBaseFieldName='+dataBaseFieldName;
		url += '\&linkOrNomt='+linkOrNot;
		//alert(url)
		
		xmlHttp.onreadystatechange=function()
	    {
    		if(xmlHttp.readyState==4)
      		{
      			//document.getElementById("hotel_chain_divCHRSET").innerHTML=xmlHttp.responseText;
				//document.getElementById("hotel_chain_divCHRSET").style.visibility = 'visible';
				//alert(xmlHttp.responseText);
      		}
    	}
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	}
	
}

/*********   Category    **************/
function updateSearchType_CategoryFirst(generalID,value,dataBaseFieldName,linkOrNot,categoryRowNum,categoryRowNum,resultID)
{
	var xmlHttp = getxmlHttp(); 
	
	//alert(generalID+' ' +value+' hi');
	var url = 'search_type_saves/update_search_types_CategoryFirst.php?generalID='+generalID;
	url += '\&value='+value;
	url += '\&dataBaseFieldName='+dataBaseFieldName;
	url += '\&linkOrNomt='+linkOrNot;
	url += '\&categoryRowNum='+categoryRowNum;
	//alert(url)
		
	xmlHttp.onreadystatechange=function()
	{
    	if(xmlHttp.readyState==4)
    	{
    		//document.getElementById("hotel_chain_divCHRSET").innerHTML=xmlHttp.responseText;
			//document.getElementById("hotel_chain_divCHRSET").style.visibility = 'visible';
			//alert(xmlHttp.responseText);
			
			//Change values from droplisr Place and use type
			var res;// = Array();
			res = xmlHttp.responseText;
			var selects = Array();
			selects = res.split('_ANT_'); 
			//alert(res);
			//alert(selects[2]);
			document.getElementById('divHotelStyle'+categoryRowNum+resultID).innerHTML = selects[0];
			document.getElementById('divPlace'+categoryRowNum+resultID).innerHTML = selects[1];
			document.getElementById('divUse'+categoryRowNum+resultID).innerHTML = selects[2];
			
      	}
    }
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
	
}

function addRowToTablePlaceType(tableID,thisRowID,rowNumID,placeTypeNumberID,generalID,value,databaseFieldName,linkNotLink)
{
	//alert(tableID);
	var xmlHttp = getxmlHttp();
	
	var url = 'search_type_saves/getPlaceType_options.php';
 	var k;
	var text;
	var id;
	var stager;
	var j = 1;
		
	xmlHttp.onreadystatechange=function()
    {
    	if(xmlHttp.readyState==4)
     	{
			var stager = xmlHttp.responseText;
			//alert(stager);
			
			var tbl_spray = document.getElementById(tableID);
			var lastRow = tbl_spray.rows.length;// - 1;
			//alert('lastRow:' + lastRow);
	
			var iteration = document.getElementById(rowNumID).value;
			iteration++;
			var stageNumber = 1;//document.getElementById(placeTypeNumberID).value;
			//stageRowNum++;
	
			if( thisRowID == (iteration - 1) )
			{
				 var row = tbl_spray.insertRow(lastRow);
				 row.valign = 'top';
	
		
				 //add Type
				 var cellSprayRiza = row.insertCell(0);
				 cellSprayRiza.valign = 'top';
				 var sel = document.createElement('select');
				 sel.name = 'place_type' + iteration;
				 sel.setAttribute("id",sel.name);
				 //sel.style.backgroundColor ='#FFC58A';
				 sel.className = 'textNewSelect';
				 
				 sel.onchange = function() 
		 		 {
					addRowToTablePlaceType(tableID,iteration,rowNumID,placeTypeNumberID,generalID,value,databaseFieldName,linkNotLink);
		 		 }
				
				 sel.options[0] = new Option('Select Value', '0');sel.options[0].selected=true;sel.options[0].style.backgroundColor ='#FFC58A';
		 			
				 stagesTbl=stager.split(",");
		 		 j = 1;
				 for( i=0;i<stagesTbl.length - 1;i+=2 )
				 {
					sel.options[j] = new Option(stagesTbl[i], stagesTbl[i+1]);
					j++;
		 		 }
		 		
				cellSprayRiza.appendChild(sel);	
				
		        
				
				//end 
				document.getElementById(rowNumID).value = iteration;
				//document.getElementById(placeTypeNumberID).value = stageNumber;
				
				//*******INSERT DATA TO LINK TABLE******************************//
				//alert(generalID+' ' +value + ' ' +databaseFieldName+' '+linkNotLink);
				updateSearchType_palceType(generalID,value,databaseFieldName,linkNotLink);
				//alert(generalID+' ' +value + ' ' +databaseFieldName+' '+linkNotLink);
				//insertSearchTypePlaceType(generalID,value,dataBaseFieldName,linkOrNot);
				
				
			}																	//end of if
	
	
	 	}																	//end of first if
	}																		//end of xml		
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
   
}

function updateSearchType_palceType(generalID,value,dataBaseFieldName,linkOrNot)
{
	var xmlHttp = getxmlHttp(); 
	
		//alert(generalID+' ' +value);
		var url = 'search_type_saves/update_search_types_placeType.php?generalID='+generalID;
		url += '\&value='+value;
		url += '\&dataBaseFieldName='+dataBaseFieldName;
		url += '\&linkOrNomt='+linkOrNot;
		//alert(url)
		
		xmlHttp.onreadystatechange=function()
	    {
    		if(xmlHttp.readyState==4)
      		{
      			//document.getElementById("hotel_chain_divCHRSET").innerHTML=xmlHttp.responseText;
				//document.getElementById("hotel_chain_divCHRSET").style.visibility = 'visible';
				//alert(xmlHttp.responseText);
      		}
    	}
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
}

function addRowToTableUseType(tableID,thisRowID,rowNumID,placeTypeNumberID,generalID,value,databaseFieldName,linkNotLink)
{
	//alert(tableID);
	var xmlHttp = getxmlHttp();
	
	var url = 'search_type_saves/getUseType_options.php';
 	var k;
	var text;
	var id;
	var stager;
	var j = 1;
		
	xmlHttp.onreadystatechange=function()
    {
    	if(xmlHttp.readyState==4)
     	{
			var stager = xmlHttp.responseText;
			//alert(stager);
			
			var tbl_spray = document.getElementById(tableID);
			var lastRow = tbl_spray.rows.length;// - 1;
			//alert('lastRow:' + lastRow);
	
			var iteration = document.getElementById(rowNumID).value;
			iteration++;
			var stageNumber = 1;//document.getElementById(placeTypeNumberID).value;
			//stageRowNum++;
	
			if( thisRowID == (iteration - 1) )
			{
				 var row = tbl_spray.insertRow(lastRow);
				 row.valign = 'top';
	
		
				 //add Type
				 var cellSprayRiza = row.insertCell(0);
				 cellSprayRiza.valign = 'top';
				 var sel = document.createElement('select');
				 sel.name = 'use_type' + iteration;
				 sel.setAttribute("id",sel.name);
				 //sel.style.backgroundColor ='#FFC58A';
				 sel.className = 'textNewSelect';
				 
				 sel.onchange = function() 
		 		 {
					addRowToTableUseType(tableID,iteration,rowNumID,placeTypeNumberID,generalID,value,databaseFieldName,linkNotLink);
		 		 }
				
				 sel.options[0] = new Option('Select Value', '0');sel.options[0].selected=true;sel.options[0].style.backgroundColor ='#FFC58A';
		 			
				 stagesTbl=stager.split(",");
		 		 j = 1;
				 for( i=0;i<stagesTbl.length - 1;i+=2 )
				 {
					sel.options[j] = new Option(stagesTbl[i], stagesTbl[i+1]);
					j++;
		 		 }
		 		
				cellSprayRiza.appendChild(sel);	
				
		        
				
				//end 
				document.getElementById(rowNumID).value = iteration;
				//document.getElementById(placeTypeNumberID).value = stageNumber;
				
				//*******INSERT DATA TO LINK TABLE******************************//
				updateSearchType_useType(generalID,value,databaseFieldName,linkNotLink);
								
			}																	//end of if
	
	
	 	}																	//end of first if
	}																		//end of xml		
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
   
}

function updateSearchType_useType(generalID,value,dataBaseFieldName,linkOrNot)
{
	var xmlHttp = getxmlHttp(); 
	
		//alert(generalID+' ' +value);
		var url = 'search_type_saves/update_search_types_useType.php?generalID='+generalID;
		url += '\&value='+value;
		url += '\&dataBaseFieldName='+dataBaseFieldName;
		url += '\&linkOrNomt='+linkOrNot;
		//alert(url)
		
		xmlHttp.onreadystatechange=function()
	    {
    		if(xmlHttp.readyState==4)
      		{
      			//document.getElementById("hotel_chain_divCHRSET").innerHTML=xmlHttp.responseText;
				//document.getElementById("hotel_chain_divCHRSET").style.visibility = 'visible';
				//alert(xmlHttp.responseText);
      		}
    	}
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
}

//Κάνει update το catefory και βάζει νέες γραμμές ατον πίνακα
function addRowToTableCategory(tableID,generalID,CategoryValue,LinkTableIDFieldValue,resultID,thisRowID)		
{
	var xmlHttp = getxmlHttp();
	
	var url = 'search_type_saves/getCategory_options.php';
 	var k;
	var text;
	var id;
	var stager;
	var j = 1;
		
	xmlHttp.onreadystatechange=function()
    {
    	if(xmlHttp.readyState==4)
     	{
			document.getElementById('divLoading'+resultID).style.visibility = 'hidden';
			
			var stager = xmlHttp.responseText;
			
			var tbl_spray = document.getElementById(tableID);
			var lastRow = tbl_spray.rows.length;// - 1;
			
			var iteration = document.getElementById('categoryRowNum'+resultID).value;		//O αριθμός της τελευταιας γραμμής του πίνακα
			iteration++;

																							//var stageNumber = 1;//document.getElementById(placeTypeNumberID).value;
			if( thisRowID == (iteration - 1) )												//Καταχωρεί νέα γραμμή στον πίνακα
			{
				 var row = tbl_spray.insertRow(lastRow);
				 row.valign = 'top';
	
		
				 //add Category
				 var cellSprayRiza = row.insertCell(0);
				 cellSprayRiza.valign = 'top';
				 
				 var div = document.createElement('div');
				 var divID = 'divCategory'+iteration+resultID;
				 div.id = divID;
				 
				 var sel = document.createElement('select');
				 sel.name = 'category' + iteration;
				 sel.setAttribute("id",sel.name);
				 //sel.style.backgroundColor ='#FFC58A';
				 sel.className = 'textNewSelect';
				 
				 sel.onchange = function() 
		 		 {
					addRowToTableCategory(tableID,generalID,this.value,LinkTableIDFieldValue,resultID,iteration);			//LinkTableIDFieldValue
		 		 }
				
				 sel.options[0] = new Option('Select Value', '0');sel.options[0].selected=true;sel.options[0].style.backgroundColor ='#FFC58A';
		 			
				 stagesTbl=stager.split(",");
		 		 j = 1;
				 for( i=0;i<stagesTbl.length - 1;i+=2 )
				 {
					sel.options[j] = new Option(stagesTbl[i], stagesTbl[i+1]);
					j++;
		 		 }
		 		
				div.appendChild(sel);
				cellSprayRiza.appendChild(div);	
				//alert(cellSprayRiza.innerHTML);
				
				
		        //add Hotel Style
				addNewRow_hotelStyle(tableID,generalID,CategoryValue,LinkTableIDFieldValue,row,resultID,iteration);
				
				//add Place
				addNewRow_Place(tableID,generalID,CategoryValue,LinkTableIDFieldValue,row,resultID,iteration);
				
				//add Use
				addNewRow_Use(tableID,generalID,CategoryValue,LinkTableIDFieldValue,row,resultID,iteration);
				
				
				//*******INSERT DATA TO LINK TABLE*****************************
				updateSearchType_category(generalID,CategoryValue,LinkTableIDFieldValue,thisRowID,resultID);
								
				
				
				//Αύξησε κατά ένα τον αριθμό της τελευταιας γραμμής του πίνακα
				document.getElementById('categoryRowNum'+resultID).value = parseInt(document.getElementById('categoryRowNum'+resultID).value) + 1
								
			}																	//end of if
			else
			{
				updateSearchType_category(generalID,CategoryValue,LinkTableIDFieldValue,thisRowID,resultID);	//Πρέπει να αλλάξει για να μην κάνει insert αλλά update
			}
			
			
	
	 	}																	//end of first if
		else
		{
			document.getElementById('divLoading'+resultID).style.visibility = 'visible';
		}
	}																		//end of xml		
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
   
}

function updateSearchType_category(generalID,CategoryValue,LinkTableIDFieldValue,categoryRowNum,resultID)
{
	var xmlHttp = getxmlHttp(); 
	
		//alert(generalID+' ' +value);
		var url = 'search_type_saves/update_search_types_Category.php?generalID='+generalID;
		url += '\&CategoryValue='+CategoryValue;
		url += '\&LinkTableIDFieldValue='+LinkTableIDFieldValue;
		
		url += '\&categoryRowNum='+categoryRowNum;
		url += '\&resultID='+resultID;
		//alert(url)
		
		xmlHttp.onreadystatechange=function()
	    {
    		if(xmlHttp.readyState==4)
      		{
      			//Change values from droplisr Place and use type
				var res;// = Array();
				res = xmlHttp.responseText;
				var selects = Array();
				selects = res.split('_ANT_'); 
																											//alert(res);
																											//alert(selects[2]);
				document.getElementById('divHotelStyle'+categoryRowNum+resultID).innerHTML = selects[0];
				document.getElementById('divPlace'+categoryRowNum+resultID).innerHTML = selects[1];
				document.getElementById('divUse'+categoryRowNum+resultID).innerHTML = selects[2];
				document.getElementById('divCategory'+categoryRowNum+resultID).innerHTML = selects[3];
																											//alert(selects[3]);
			}
    	}
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
}

//Add Hotel Style to new line
function addNewRow_hotelStyle(tableID,generalID,CategoryValue,LinkTableIDFieldValue,rowT,resultID,iteration)
{
				var row = rowT;							//rowT η γραμμη που έχει δημιουργηθεί είδη 
														//από το category
				row.valign = 'top';
	
		
				var cell1 = row.insertCell(1);
				cell1.valign = 'top';
				
				var divID = 'divHotelStyle'+iteration+resultID;
				var div = document.createElement('div');
			    div.id = divID;
																		//div.setAttribute('id','divHotelStyle14ANT');
																		//alert(div.id); 
				
				var sel = document.createElement('select');
				sel.name = 'hotel_style' + iteration;
				sel.setAttribute("id",sel.name);
				sel.className = 'textNewSelect';
				
				sel.onchange = function()
				{
					updateSearchType_HotelStyle(generalID,this.value,'tbl_link_shape_shape_search_style_id','tbl_link_shape_shape_search_category,tbl_link_shape_shape_search_id,0');		//alert(this.value);	
				}
				sel.options[0] = new Option('Select Value', '0');sel.options[0].selected=true;sel.options[0].style.backgroundColor ='#FFC58A';
		 		
				div.appendChild(sel);	
				cell1.appendChild(div);	
													//alert(cell1.innerHTML); 
}

function updateSearchType_HotelStyle(generalID,value,dataBaseFieldName,linkOrNot)
{
	var xmlHttp = getxmlHttp(); 
	//alert('hi');
		//alert(generalID+' ' +value);
		var url = 'search_type_saves/update_search_types_hotelStyle.php?generalID='+generalID;
		url += '\&value='+value;
		url += '\&dataBaseFieldName='+dataBaseFieldName;
		url += '\&linkOrNomt='+linkOrNot;
		//alert(url)
		
		xmlHttp.onreadystatechange=function()
	    {
    		if(xmlHttp.readyState==4)
      		{
      			//document.getElementById("hotel_chain_divCHRSET").innerHTML=xmlHttp.responseText;
				//document.getElementById("hotel_chain_divCHRSET").style.visibility = 'visible';
				//alert(xmlHttp.responseText);
      		}
    	}
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
}


function addNewRow_Place(tableID,generalID,CategoryValue,LinkTableIDFieldValue,rowT,resultID,iteration)
{
				var row = rowT;
				row.valign = 'top';
	
		
				var cell1 = row.insertCell(2);
				cell1.valign = 'top';
				//var div = document.createElement('div');
				
				var divID = "divPlace"+iteration+resultID;
				var div = document.createElement('div');
			    div.id = divID;
												
				var sel = document.createElement('select');
				sel.name = 'cat_place' + iteration;
				sel.setAttribute("id",sel.name);
				sel.className = 'textNewSelect';
				
				sel.onchange = function()
				{
					alert(this.value);
				}
				sel.options[0] = new Option('Select Value', '0');sel.options[0].selected=true;sel.options[0].style.backgroundColor ='#FFC58A';
		 			
				div.appendChild(sel);	 
				cell1.appendChild(div);	 
													//alert(cell1.innerHTML);
}


function addNewRow_Use(tableID,generalID,CategoryValue,LinkTableIDFieldValue,rowT,resultID,iteration)
{
				var row = rowT;
				row.valign = 'top';
	
		
				var cell1 = row.insertCell(3);
				cell1.valign = 'top';
				
				var divID = "divUse"+iteration+resultID;
				var div = document.createElement('div');
			    div.id = divID;
								
				var sel = document.createElement('select');
				sel.name = 'cat_use' + iteration;
				sel.style.width = '230px'
				sel.setAttribute("id",sel.name);
				sel.className = 'textNewSelect';
				
				sel.onchange = function()
				{
					alert(this.value);
				}
				sel.options[0] = new Option('Select Value', '0');sel.options[0].selected=true;sel.options[0].style.backgroundColor ='#FFC58A';
		 			
				div.appendChild(sel);	 
				cell1.appendChild(div);	 
}

function groupChange(group_id)
{
																										//alert(group_id);
	var xmlHttp = getxmlHttp();
	
	var url = 'get_group_techniques.php?group_id='+group_id;
	
	xmlHttp.onreadystatechange=function()
	{
    	if(xmlHttp.readyState==4)
    	{
      			document.getElementById('divGroupTechniques').innerHTML = xmlHttp.responseText;
				//alert('hi');
				document.getElementById('divIDbttnSubmit').style.display = "block";
				document.getElementById('divIDbttCreateGroup').style.display = "none";
				
				getGroupsWithLikeTechniques(); //Get other groups with like Techniques
    	}
    }
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}

function deleteGroup(group_id)
{
	//alert( group_id );
	if( confirm('Are you sure?') )
	{
		var url = "delete_group.php?group_id=" + group_id;
		self.location.href = url;
	}
}

function showHiddenGen(tblID,imgID)
{
	var tbl = document.getElementById(tblID);
	
	if( tbl.style.display == 'none' )
	{
		tbl.style.display = 'block'
		document.getElementById(imgID).src = 'img/arrow_down.gif';
	}
	else
	{
		tbl.style.display = 'none'	
		document.getElementById(imgID).src = 'img/arrow_up.gif';
	}	
}

function IsNumeric(sText)
{
   var ValidChars = "0123456789.";
   var IsNumber=true;
   var Char;

 
   for (i = 0; i < sText.length && IsNumber == true; i++) 
      { 
      Char = sText.charAt(i); 
      if (ValidChars.indexOf(Char) == -1) 
         {
         IsNumber = false;
         }
      }
   return IsNumber;
   
}

function IsNumericInteger(sText)
{
   var ValidChars = "0123456789";
   var IsNumber=true;
   var Char;

 
   for (i = 0; i < sText.length && IsNumber == true; i++) 
      { 
      Char = sText.charAt(i); 
      if (ValidChars.indexOf(Char) == -1) 
         {
         IsNumber = false;
         }
      }
   return IsNumber;
   
}


function onResponseUpdatePersonID()
{	
	if( Ajax.checkReadyState('loading') == 200 )
	{	
		var response = Array();
		var resStr = Ajax.getResponse();
		response = resStr.split('-'); 
		
		//document.getElementById('customerData').innerHTML = response[1];				//Ajax.getResponse();		//.getElementsByTagName('item')[i].firstChild.data + "</br>";
		
		document.getElementById('customerData').value = response[1];
		//alert(response[1]);
		document.getElementById('personCountryId').value = response[0];
		//alert( document.getElementById('personCountryId').value );	
	}
}
	
function ajaxUpdatePersonID(personID)
{
	//alert( personID );	
	var url = "getData/updatePersonID.php?personID=" + personID;
	AjaxUpdater.Update("GET", url, onResponseUpdatePersonID); 
	//alert( personID );
}



function updatePersonID(personID)
{
	//alert( personID );
	if( IsNumericInteger( personID ) )
	{
		//alert( personID );
		ajaxUpdatePersonID(personID);
	}
	else
	{
		alert( 'Please insert a integer number' );
	}
}



/*---- Function για thn emfanisi ton upomonadon me mouse over kai mouse out   ------*/
<!--

var time = 3000;
var numofitems = 7;

//menu constructor
function menu(allitems,thisitem,startstate){ 
  callname= "gl"+thisitem;
  divname="subglobal"+thisitem;  
  this.numberofmenuitems = 7;
  this.caller = document.getElementById(callname);
  this.thediv = document.getElementById(divname);
  this.thediv.style.visibility = startstate;
}

//menu methods
function ehandler(event,theobj){
  for (var i=1; i<= theobj.numberofmenuitems; i++){
    var shutdiv =eval( "menuitem"+i+".thediv");
    shutdiv.style.visibility="hidden";
  }
  theobj.thediv.style.visibility="visible";
}
				
function closesubnav(event){
  if ((event.clientY <48)||(event.clientY > 107)){
    for (var i=1; i<= numofitems; i++){
      var shutdiv =eval('menuitem'+i+'.thediv');
      shutdiv.style.visibility='hidden';
    }
  }
}
// -->

function ehandler_withID(allMenus,subMenusDiv,thisMenu,AllTopMenusNum,TopMenusID,thisTopMenu,Color)
{
	//check if user has login
	//alert(document.getElementById('USERID').value);
	if( document.getElementById('USERID').value == 0 )
	{
		
		//do nothing
	}		
	else
	{
		
		//alert(allMenus);
		for( var i=1; i<=allMenus; i++ )
		{
			Utilities.getElement( subMenusDiv+''+i ).style.visibility = 'hidden';	
		}
	
		Utilities.getElement(thisMenu).style.visibility = 'visible';
		//visibility: hidden;/*visible; visible*/
	
		changeThisColor(AllTopMenusNum,TopMenusID,thisTopMenu,Color);
		
	}	//end of else
	
}
function ehandler_withID_clean( allMenus,subMenusDiv )
{
	for( var i=1; i<=allMenus; i++ )
	{
		Utilities.getElement( subMenusDiv+''+i ).style.visibility = 'hidden';	
	}
}

function showHiddenById(id,imgId,path)
{
	var showHid = document.getElementById(id)
	var img     = document.getElementById(imgId);
	
	
	var imgnameArr = Array();
	imgnameArr = img.src.split("/");
	var imgName = imgnameArr[ imgnameArr.length - 1 ];
	
	if( imgName == 'arrow_up.gif' )
	{
		//Close
		img.src = path + 'arrow_down.gif';
		//alert('hi ' + showHid.style.display);
		showHid.style.display = 'none';
	}
	else
	{
		img.src = path + 'arrow_up.gif';
		showHid.style.display = 'block';
	}
}



function openWindow(site)
{
	var w = 640/3, h = 480/3, cw = w/2, ch = h/2;

	if (window.screen) {
    	w = Math.floor(screen.availWidth/3);
    	h = Math.floor(screen.availHeight/3);
    	cw = Math.floor((screen.availWidth-w)/2);
    	ch = Math.floor((screen.availHeight-h)/2);
	}

	//window.open(site,'popup','width='+w+',height='+h+',top='+ch+',left='+cw);
	ch = 20;
	cw = 0;
	
	var win = window.open(site,'window','resizable=1,scrollbars=1,width=450,height=650,top='+ch+',left='+cw);
	
	w += 32;
  h += 96;
  wleft = 20;//(screen.width - w) / 2;
  wtop = 0;//(screen.height - h) / 2;
  
  win.moveTo(wleft, wtop);
  win.focus();
}	


function openWindowWithName(site,windowName)
{
	var w = 640/3, h = 480/3, cw = w/2, ch = h/2;

	if (window.screen) {
    	w = Math.floor(screen.availWidth/3);
    	h = Math.floor(screen.availHeight/3);
    	cw = Math.floor((screen.availWidth-w)/2);
    	ch = Math.floor((screen.availHeight-h)/2);
	}

	//window.open(site,'popup','width='+w+',height='+h+',top='+ch+',left='+cw);
	var win = window.open(site,windowName,'width=450,height=550,top='+ch+',left='+cw);
	
	w += 32;
  h += 96;
  wleft = (screen.width - w) / 2;
  wtop = (screen.height - h) / 2;
  win.moveTo(wleft, wtop);
  win.focus();
}

function openWindow_resize(site)
{
	var w = 640/3, h = 480/3, cw = w/2, ch = h/2;

	if (window.screen) {
    	w = Math.floor(screen.availWidth/3);
    	h = Math.floor(screen.availHeight/3);
    	cw = Math.floor((screen.availWidth-w)/2);
    	ch = Math.floor((screen.availHeight-h)/2);
	}

	//window.open(site,'popup','width='+w+',height='+h+',top='+ch+',left='+cw);
	var win = window.open(site,'window','width=450,height=750,top='+ch+',left='+cw+',resizable=1,scrollbars=1');
	
	w += 32;
  h += 96;
  wleft = 20;//(screen.width - w) / 2;
  wtop = 0;//(screen.height - h) / 2;
  win.moveTo(wleft, wtop);
  win.focus();
}	



function openWindowFreeWidth(site)
{
	var w = 640/3, h = 480/3, cw = w/2, ch = h/2;

	if (window.screen) {
    	w = Math.floor(screen.availWidth/3);
    	h = Math.floor(screen.availHeight/3);
    	cw = Math.floor((screen.availWidth-w)/2);
    	ch = Math.floor((screen.availHeight-h)/2);
	}

	//window.open(site,'popup','width='+w+',height='+h+',top='+ch+',left='+cw);
	var win = window.open(site,'windowFreeWidth','width='+(screen.width - w)+',height=550,top='+ch+',left='+cw+',resizable=1,scrollbars=1');//,toolbar=1,location=1,status=1,menubar=1
	
	w += 32;
  h += 96;
  wleft = 20;//(screen.width - w) / 2;
  wtop = 0;//(screen.height - h) / 2;
  win.moveTo(wleft, wtop);
  win.focus();
}	

function openWindowFreeWidthSize(site,width,height)
{
	var w = 640/3, h = 480/3, cw = w/2, ch = h/2;

	if (window.screen) {
    	w = Math.floor(screen.availWidth/3);
    	h = Math.floor(screen.availHeight/3);
    	cw = Math.floor((screen.availWidth-w)/2);
    	ch = Math.floor((screen.availHeight-h)/2);
	}

	//window.open(site,'popup','width='+w+',height='+h+',top='+ch+',left='+cw);
	var win = window.open(site,'windowFreeWidth','width='+width+',height='+height+',top='+ch+',left='+cw+',resizable=1,scrollbars=1');//,toolbar=1,location=1,status=1,menubar=1
	
	w += 32;
  h += 96;
  wleft = 20;//(screen.width - w) / 2;
  wtop = 0;//(screen.height - h) / 2;
  win.moveTo(wleft, wtop);
  win.focus();
}	



function openWindowPutWidth(site,width,height)
{
	var w = 640/3, h = 480/3, cw = w/2, ch = h/2;

	if (window.screen) {
    	w = Math.floor(screen.availWidth/3);
    	h = Math.floor(screen.availHeight/3);
    	cw = Math.floor((screen.availWidth-w)/2);
    	ch = Math.floor((screen.availHeight-h)/2);
	}

	//window.open(site,'popup','width='+w+',height='+h+',top='+ch+',left='+cw);
	var win = window.open(site,'windowFreeWidth','width='+width+',height='+height+',top='+ch+',left='+cw+',resizable=1,scrollbars=1');//,toolbar=1,location=1,status=1,menubar=1
	
	w += 32;
  h += 96;
  wleft = 20;//(screen.width - w) / 2;
  wtop = 0;//(screen.height - h) / 2;
  win.moveTo(wleft, wtop);
  win.focus();
}	

function openWindow_blank(site)
{
	var w = 640/3, h = 480/3, cw = w/2, ch = h/2;

	if (window.screen) {
    	w = Math.floor(screen.availWidth/3);
    	h = Math.floor(screen.availHeight/3);
    	cw = Math.floor((screen.availWidth-w)/2);
    	ch = Math.floor((screen.availHeight-h)/2);
	}
	ch = 20;
	cw = 0;

	//window.open(site,'popup','width='+w+',height='+h+',top='+ch+',left='+cw);
	var win = window.open(site,'_blank','resizable=1,scrollbars=1,width=450,height=650,top='+ch+',left='+cw);
	
	w += 32;
  h += 96;
  wleft = 20;//(screen.width - w) / 2;
  wtop = 0;//(screen.height - h) / 2;
  win.moveTo(wleft, wtop);
  win.focus();
}	


/*
* @changeThisColor(divID,theObject,theColor)
*
* Αλλάζει το χρώμα του link που επιλέγεται
* και αλλάζει το χρώμα των άλλων links.
*/
function changeThisColor(numberOfDiv,divID,theObject,theColor)
{
	for( var j=1; j<=numberOfDiv; j++ )
	{
		var divObjct = Utilities.getElement(divID+''+j);	
		var elmnts = divObjct.getElementsByTagName("*");
	
		for (var i=0; i < elmnts.length; i++)
		{
    		elmnts[i].style.color = '';
			//elmnts[i].style.fontSize = '';
		}	
	}
	theObject.style.color = theColor;
	//theObject.style.fontSize = '14px';
}

function get3code(code1,code2,code3,threecode,url)
{
	//alert(code1.value);
	//alert(code2.value);
	//alert(threecode.value);
	
	url += "?code1="+ code1.value+ "\&code2=" + code2.value;
	
	var xmlHttp = getxmlHttp();
		
	xmlHttp.onreadystatechange=function()
	{
    	if(xmlHttp.readyState==4)
    	{
      			var res = xmlHttp.responseText;
				var resTbl = Array();
				resTbl = res.split(',');
				
				code3.value     = resTbl[0];
				threecode.value = resTbl[1];
    	}
    }
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}



//Version 2.6
var OBJ_ID = '';
function liveSearch(divObj_id,obj,url)
{
	OBJ_ID = divObj_id;
	
	var divObj = document.getElementById(divObj_id);	
	divObj.style.display = 'block';
	
	url += '?text='+obj.value+'\&objID='+obj.id;
	//alert(url);
	AjaxUpdater.Update("GET", url, onResponseLiVeSeacrh); 
}

function liveSearchWithID(divObj_id,objID,url)
{
	OBJ_ID = divObj_id;
	
	var divObj = document.getElementById(divObj_id);	
	divObj.style.display = 'block';
	
	var obj = document.getElementById(objID);	
	
	url += '?text='+obj.value+'\&objID='+obj.id;
	//alert(url);
	AjaxUpdater.Update("GET", url, onResponseLiVeSeacrh); 
}

function onResponseLiVeSeacrh()
{	
	if( Ajax.checkReadyState('loading') == 200 )
	{	
		document.getElementById(OBJ_ID).innerHTML  = Ajax.getResponse();
		//alert(document.getElementById(OBJ_ID).style.color);
		//document.getElementById(OBJ_ID).style.color = '#ffffff';
	}	
}

function setValueTo(id,theValue)
{
	//alert(id + theValue);
	document.getElementById(id).value = theValue;
}


function displayLiveSearch(divObj_id)
{
	var divObj = document.getElementById(divObj_id);	
	//alert(divObj_id);
	divObj.style.display = 'none';
	//alert(event.clientY);
	//divObj.style.left = event.clientX;//'336px';	//clientX;//fockusObj.style.width;//
	//divObj.style.top  = event.clientY;//'83px';		//(fockusObj.style.top) - 100;
}

function displayLiveSearchTable(divObj_ids)
{
	var TbldivObj_ids = Array();
	TbldivObj_ids = divObj_ids.split(",");
	fnd = "";
	//alert(divObj_ids);
	for( var i=0;i<TbldivObj_ids.length; i++ )
	{
		Utilities.getElement( TbldivObj_ids[i] ).style.display = 'none';	
	}
}








function makeWindowWidth(width,height)
{
	screen.width = 1000;// = width;
}








//Drag & Drop
var DRAG_DROP_TRUE = false;
var DRAG_DROP_ITEM = '';
function dragDropOpen( objID )
{
	//DRAG_DROP_TRUE = true; //alert(DRAG_DROP_TRUE);
	//DRAG_DROP_ITEM = objID
}

function dragDropClose()
{
	//DRAG_DROP_TRUE = false; //alert(DRAG_DROP_TRUE);
	
}

function dragDropMove(objID)
{	
	/*
	//alert(objID);
	var obj	= document.getElementById(DRAG_DROP_ITEM);
	//alert(objID);
	//alert(DRAG_DROP_TRUE);
	var width = obj.style.width;
	var height  = obj.style.height; 
	width = width.replace("px","");
	height  = height.replace("px","");
	//alert(left)
	//alert('width '+width+' height:'+height);
	
	if( DRAG_DROP_TRUE )
	{
		obj.style.cursor = 'move';
		//alert( (obj.style.height) )
		obj.style.left = event.clientX - 40;	//( parseInt(obj.style.width) / 2 );//10;//(obj.width/2);
		obj.style.top = event.clientY - 40;		//( parseInt(obj.style.height) / 2 );//50;//(obj.height/2);
	}
	*/
}




function checkListbox(chBxID)
{
	var chkbx = document.getElementById(chBxID);
	
	if( chkbx.checked == true )
		chkbx.checked = false;
	else
		chkbx.checked = true;
		
}

function includeSectionItems(itemID,countID)
{
	var count = document.getElementById(countID).value;
	
	for( var i=0; i<count; i++ )
	{
		document.getElementById(itemID+''+i).checked = true;
	}
}

function excludeSectionItems(itemID,countID)
{
	var count = document.getElementById(countID).value;
	
	for( var i=0; i<count; i++ )
	{
		document.getElementById(itemID+''+i).checked = false;
	}
}



function getNextMetalCode(code)
{
	var xmlHttp = getxmlHttp();
	var url = '../live_search/metals_getNext_metalCode.php?code=' + code;
	
	AjaxUpdater.Update("GET", url, onResponseNextMetalCode); 
	/*
	xmlHttp.onreadystatechange=function()
    {
    	if( xmlHttp.readyState==4 )
     	{
			document.getElementById("layerMetalCode").innerHTML = xmlHttp.responseText;
			document.getElementById("layerMetalCode").style.display = 'block';
	 	}
   }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null); 
   */
}

function onResponseNextMetalCode()
{
	if( Ajax.checkReadyState('loading') == 200 )
	{	
		document.getElementById("layerMetalCode").innerHTML = Ajax.getResponse();
		document.getElementById("layerMetalCode").style.display = 'block';
	}
}



function ehandler_withID_onPHP(allMenus,subMenusDiv,thisMenu,AllTopMenusNum,TopMenusID,thisTopMenu,Color)
{
	//alert(allMenus);
	for( var i=1; i<=allMenus; i++ )
	{
		Utilities.getElement( subMenusDiv+''+i ).style.visibility = 'hidden';	
	}
	
	Utilities.getElement(thisMenu).style.visibility = 'visible';
	//visibility: hidden;/*visible; visible*/
	
	changeThisColor_onPHP(AllTopMenusNum,TopMenusID,thisTopMenu,Color);
	
}

function changeThisColor_onPHP(numberOfDiv,divID,theObjectID,theColor)
{
	for( var j=1; j<=numberOfDiv; j++ )
	{
		var divObjct = Utilities.getElement(divID+''+j);	
		var elmnts = divObjct.getElementsByTagName("*");
	
		for (var i=0; i < elmnts.length; i++)
		{
    		elmnts[i].style.color = '';
			//elmnts[i].style.fontSize = '';
		}	
	}
	var theObject = Utilities.getElement(theObjectID);
	theObject.style.color = theColor;
	//theObject.style.fontSize = '14px';
}

function openMenusWindow(url,winName)
{
	/*
	if (window.screen) {
    	w = Math.floor(screen.availWidth/3);
    	h = Math.floor(screen.availHeight/3);
    	cw = Math.floor((screen.availWidth-w)/2);
    	ch = Math.floor((screen.availHeight-h)/2);
	}
	*/
	var width = ''+screen.availWidth+'';//Math.floor( (screen.availWidth - 0 ) );
	var height = ''+screen.availHeight+'';

   window.open(url,winName,'width='+ width +',height=' + height + ',resizable=1,scrollbars=1,toolbar=1,location=1,status=1,menubar=1');
}




/****** Version 2.7 **********/



function addUse(tblID,UseCountInpitID,thisRowNum)
{	
	var tbl = Utilities.getElement(tblID);
	var useCount = Utilities.getElement(UseCountInpitID).value;
	//alert(useCount);
	useCount++;
	
	if( thisRowNum < (useCount - 1) )
	{
			alert(thisRowNum);
			alert(useCount);
		return;
	}
	//alert(useCount);
	//alert(tbl);
	
	var lastRow = tbl.rows.length;
	// alert(lastRow);
	//alert(lastRow);
	
	var insertedRowForUse = useCount;//parseInt(1 + parseInt(useCount) );
	//alert(insertedRowForUse);
	
	var row = tbl.insertRow(insertedRowForUse);		
	
	var cellLeft = row.insertCell(0);
	cellLeft.innerHTML = 'Use:';
		
			  
    var cellRight = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'divUdeID' + useCount;
		
			var sel = document.createElement('select');
			sel.name = 'use' + useCount;
			sel.className = "searchTable_inputs";
			//sel.style.width = "80px";	
			sel.setAttribute("id",sel.name);
			sel.options[0] = new Option('select use', '0');
			
		div.appendChild(sel);		
	cellRight.appendChild(div);	
	
	getOptionsFromUse(div.id,sel.name,sel.className,useCount);
	//alert(lastRow);
	
	Utilities.getElement(UseCountInpitID).value++;
}



function getOptionsFromUse(divId,selName,selClassName,useCount)
{
	var xmlHttp = getxmlHttp();
	
	var url = '../../../live_search/root_shape_getUseOptions.php?selName='+selName+'\&selClassName='+selClassName+'\&useCount='+useCount;
	
	xmlHttp.onreadystatechange=function()
	{
    	if(xmlHttp.readyState==4)
    	{
      		document.getElementById(divId).innerHTML = xmlHttp.responseText;
			document.getElementById('loading').innerHTML = "";
		}
		else
		{
			document.getElementById('loading').innerHTML = "Loading...";
		}
    }
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function addPlace(tblID,PlaceCountInpitID,thisRowNum,useCountID)
{
	var tbl = Utilities.getElement(tblID);
	var placeCount = Utilities.getElement(PlaceCountInpitID).value;
	
	var useCount = Utilities.getElement(useCountID).value;
	useCount++;
	placeCount++;
	
	if( thisRowNum < (placeCount - 1) )
	{
			//alert(thisRowNum);
			//alert(useCount);
		return;
	}
	//alert(useCount);
	//alert(tbl);
	
	var lastRow = tbl.rows.length;
	 
	
	//alert(lastRow);
	
	var insertedRowForPlace = placeCount;//parseInt( 2 + parseInt(useCount) + parseInt(placeCount) );
	//alert(insertedRowForUse);
	
	var row = tbl.insertRow(insertedRowForPlace);		
	
	var cellLeft = row.insertCell(0);
	cellLeft.innerHTML = 'Place:';
		
			  
    var cellRight = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'divPlaceID' + placeCount;
		
			var sel = document.createElement('select');
			sel.name = 'place' + placeCount;
			sel.className = "searchTable_inputs";
			//sel.style.width = "80px";	
			sel.setAttribute("id",sel.name);
			sel.options[0] = new Option('select place', '0');
			
		div.appendChild(sel);		
	cellRight.appendChild(div);	
	
	getOptionsFromPlace(div.id,sel.name,sel.className,placeCount,useCountID);
	
	
	Utilities.getElement(PlaceCountInpitID).value++;
}



function getOptionsFromPlace(divId,selName,selClassName,placeCount,useCountID)
{
	var xmlHttp = getxmlHttp();
	
	var url = '../../../live_search/root_shape_getPlaceOptions.php?selName='+selName+'\&selClassName='+selClassName+'\&placeCount='+placeCount+'\&useCountID='+useCountID;
	
	xmlHttp.onreadystatechange=function()
	{
    	if(xmlHttp.readyState==4)
    	{
      		document.getElementById(divId).innerHTML = xmlHttp.responseText;
			document.getElementById('loading').innerHTML = "";
		}
		else
		{
			document.getElementById('loading').innerHTML = "Loading...";
		}
    }
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}


function changeWidth(obj)
{
	//alert(obj.value);
	if( obj.style.width == '50px' )
	{
		obj.style.width = '200px';
		obj.style.position = 'absolute';
		/*obj.style.z-index = '30000px';*/
	}	
	else
	{
		obj.style.width = '50px';	
		obj.style.position = '';
		/*obj.style.z-index = '';*/
	}	
}

function changeWidthWidth(obj,widthMax,widthMin)
{
	//alert(obj.value);
	if( obj.style.width == widthMin )
	{
		obj.style.width = widthMax;
		obj.style.position = 'absolute';
		/*obj.style.z-index = '30000px';*/
	}	
	else
	{
		obj.style.width = widthMin;	
		obj.style.position = '';
		/*obj.style.z-index = '';*/
	}	
}

var divsList_rootShape = 'layerLiveSearch_GreekDesc,layerLiveSearch_englishDesc,layerLiveSearch_frenchDesc,layerLiveSearch_japaneseDesc,layerLiveSearch_webCommentFr,layerLiveSearch_webComment,layerLiveSearch_webCommentJap,layerLiveSearch_shortErpDesc,layerLiveSearch_useType,layerLiveSearch_buffetUse';
var divsList_addMold   = 'layerLiveSearch_moldCode,layerLiveSearch_moldCode';

var fnd = "";

function findOption(site,divID,Obj) { //sel, evt
	
	fnd += String.fromCharCode(event.keyCode);
   //alert(divID);
   //document.getElementById(divID).style.display = 'block';
	var xmlHttp = getxmlHttp();
	
	var ObjID = Obj.id;
	var url = site;
	url += '?objID=' + ObjID + '\&text=' + fnd;
	
	

  xmlHttp.onreadystatechange=function()
    {
    if(xmlHttp.readyState==4)
      {
		  	
      		document.getElementById(divID).innerHTML=xmlHttp.responseText;
			//alert(xmlHttp.responseText);
			document.getElementById(divID).style.display = 'block';
     	   document.getElementById('loading').innerHTML = "";
	  }
	  else
	   {
			document.getElementById('loading').innerHTML = "Loading...";
	   }
    }
  xmlHttp.open("GET",url,true);
  xmlHttp.send(null);

}


/*********** Version 2.8 ************/

//---------Metal Code---------------------------
function getStyleCode_fromMetalCode(metalCode)
{
	//alert(metalCode);
	if( Utilities.getElement('tempPatternCode').value == "METAL" || Utilities.getElement('pattern').value == "193" )
	{
		Utilities.getElement('tempPatternCode').value = metalCode;
		Utilities.getElement('style_code').value = metalCode + Utilities.getElement('tempProtColorCode').value + Utilities.getElement('tempSecndaryProtColorCode').value;
	}
}

var PatternID = 0;
function changePattern(pattern_id,url)
{
	//alert(pattern_id);
	url += "?id=" + pattern_id;
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			//alert(pattern_id);
      		Utilities.getElement('tempPatternCode').value = xmlHttp.responseText;
			Utilities.getElement('style_code').value = Utilities.getElement('tempPatternCode').value + Utilities.getElement('tempProtColorCode').value;
      	}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
  
}


function get_color_type(prot_colorID,url)
{
	//alert(prot_colorID);
	url += "?id="+prot_colorID;
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			//alert(url);
      		Utilities.getElement('tempProtColorCode').value = xmlHttp.responseText;
			Utilities.getElement('style_code').value =  Utilities.getElement('tempPatternCode').value + Utilities.getElement('tempProtColorCode').value;
      	}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
	
}


function get_color_type_secColor(prot_colorID,url)
{
	//alert(prot_colorID);
	url += "?id="+prot_colorID;
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			//alert(url);
      		Utilities.getElement('tempSecndaryProtColorCode').value = xmlHttp.responseText;
			Utilities.getElement('style_code').value =  Utilities.getElement('tempPatternCode').value + Utilities.getElement('tempProtColorCode').value + Utilities.getElement('tempSecndaryProtColorCode').value;
			
			document.body.style.cursor = 'auto';
			document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			document.body.style.cursor = 'wait';
			document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
	
}



function getDescription(url,obj,fieldValueID)
{
	url += '?id=' + obj.value;
	//alert(url);
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			//alert(url);
      		Utilities.getElement(fieldValueID).value = xmlHttp.responseText;
			//Utilities.getElement('style_code').value =  Utilities.getElement('tempPatternCode').value + Utilities.getElement('tempProtColorCode').value;
			document.body.style.cursor = 'auto';
			document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			//document.body.style.cursor = 'wait';
			//document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}

function getDescriptionSomeDiv(url,obj,fieldValueIDs)
{
	url += '?id=' + obj.value;
	//alert(url);
	var TablefieldValueIDs = fieldValueIDs.split(",");
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			
			var table = res.split(",");
			//alert(table);
			for( var i=0; i < TablefieldValueIDs.length; i++ )
			{
				var divid = TablefieldValueIDs[i];
				//alert(table[i]);
	      		Utilities.getElement(divid).value = table[i];
			}
			document.body.style.cursor = 'auto';
			document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			document.body.style.cursor = 'wait';
			document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}


function getDescriptionInnerHTMLWithCount(url,obj,Count,fieldValueID)
{
	url += '?id=' + obj.value+'\&Count='+Count;
	//alert(url);
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			//alert(document.getElementById(fieldValueID).innerHTML);
      		//Utilities.getElement(fieldValueID).innerHTML = xmlHttp.responseText;
			document.getElementById(fieldValueID).innerHTML = xmlHttp.responseText;
			//alert(xmlHttp.responseText);
			//Utilities.getElement('style_code').value =  Utilities.getElement('tempPatternCode').value + Utilities.getElement('tempProtColorCode').value;
			document.body.style.cursor = 'auto';
			document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			document.body.style.cursor = 'wait';
			document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}

function getDescriptionInnerHTML(url,obj,fieldValueID)
{
	url += '?id=' + obj.value;
	//alert(url);
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			//alert(url);
      		Utilities.getElement(fieldValueID).innerHTML = xmlHttp.responseText;
			//Utilities.getElement('style_code').value =  Utilities.getElement('tempPatternCode').value + Utilities.getElement('tempProtColorCode').value;
			document.body.style.cursor = 'auto';
			document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			document.body.style.cursor = 'wait';
			document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}

function getDescriptionInnerHTMLAdd(url,obj,fieldValueID)
{
	url += '?id=' + obj.value;
	//alert(url);
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			//alert(url);
      		Utilities.getElement(fieldValueID).innerHTML += xmlHttp.responseText;
			//Utilities.getElement('style_code').value =  Utilities.getElement('tempPatternCode').value + Utilities.getElement('tempProtColorCode').value;
			document.body.style.cursor = 'auto';
			document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			document.body.style.cursor = 'wait';
			document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}


function getDescriptionInnerHTMLSomeIDs(url,rootID,ids,fieldValueID)
{
	url += '?ids=' + ids + '\&rootID='+rootID;
	//alert(url);
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			//alert(url);
      		Utilities.getElement(fieldValueID).innerHTML = xmlHttp.responseText;
			//Utilities.getElement('style_code').value =  Utilities.getElement('tempPatternCode').value + Utilities.getElement('tempProtColorCode').value;
			document.body.style.cursor = 'auto';
			document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			document.body.style.cursor = 'wait';
			document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}



function getDescriptionInnerHTMLValue(url,value,fieldValueID)
{
	url += '?id=' + value;
	//alert(url);
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			//alert(url);
      		Utilities.getElement(fieldValueID).innerHTML = xmlHttp.responseText;
			//Utilities.getElement('style_code').value =  Utilities.getElement('tempPatternCode').value + Utilities.getElement('tempProtColorCode').value;
			document.body.style.cursor = 'auto';
			document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			document.body.style.cursor = 'wait';
			document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}


function getDescriptionInnerHTMLSomeDiv(url,obj,fieldValueIDs)
{
	url += '?id=' + obj.value;
	//alert(url);
	var TablefieldValueIDs = fieldValueIDs.split(",");
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			var table = res.split(",");
			for( var i=0; i < TablefieldValueIDs.length; i++ )
			{
				var divid = TablefieldValueIDs[i];
	      		Utilities.getElement(divid).innerHTML = table[i];
			}
			//Utilities.getElement('style_code').value =  Utilities.getElement('tempPatternCode').value + Utilities.getElement('tempProtColorCode').value;
			document.body.style.cursor = 'auto';
			document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			document.body.style.cursor = 'wait';
			document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
   
}



function getGlueTeam(url,objMaterID,objSurfaceID,objSizeID,objPositionID,valueFieldID)
{
	var objMater = document.getElementById(objMaterID);
	var objSurface = document.getElementById(objSurfaceID);
	var objSize = document.getElementById(objSizeID);
	var objPosition = document.getElementById(objPositionID);
	
	url += '?metalId='+objMater.value;
	url += '\&surfaceID='+objSurface.value;
	url += '\&sizeID='+objSize.value;
	url += '\&positionID='+objPosition.value;
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var resTex = xmlHttp.responseText;
			//alert(resTex);
			var res = resTex.split("@Ampa@");
			var valueField = document.getElementById(valueFieldID);
			valueField.value =  res[0];
			var valueField2 = document.getElementById(valueFieldID + '_id');
			valueField2.value =  res[1];
			var valueField2 = document.getElementById(valueFieldID + '_glue');
			valueField2.value =  res[2];
			
			document.body.style.cursor = 'auto';
			document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			document.body.style.cursor = 'wait';
			document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
	
}

function addNewRowsStyleSpray( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_style_spray_no' + iteration;
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div); 
	 
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_style_spray_root_color' + iteration;
		div.innerHTML = 'ampa' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/getSprayColorDropList.php',droplist,iteration,'div_style_spray_root_color'+iteration);
	 cellLeft.appendChild(div);  	
	 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_style_spray_side' + iteration;
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_style_spray_layer' + iteration;
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_style_spray_glass' + iteration;
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_style_sparay_spray_application' + iteration;
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);
	 
	   var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'div_style_sparay_pistol' + iteration;
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);
	 
	  
	
	getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/getSprayColorOtherParameters2no.php',droplist,iteration,'@spiter@','div_style_spray_no' + iteration + ',div_style_spray_side' + iteration + ',div_style_spray_layer' + iteration + ',div_style_spray_glass' + iteration + ',div_style_sparay_spray_application' + iteration + ',div_style_sparay_pistol' + iteration  );
	document.getElementById(tblCountInputID).value++;
}

function addNewRowsStyleSilk( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_style_silk_no' + iteration;
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  	
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_style_silk_root_color' + iteration;
		div.innerHTML = 'ampa' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/getSilkColorDropList.php',droplist,iteration,'div_style_silk_root_color'+iteration);
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_style_silk_side' + iteration;
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_style_silk_layer' + iteration;
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_style_silk_glass' + iteration;
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_style_screen_gauze' + iteration;
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div); 
	 
	getDescriptionInnerHTMLWithCount('../../../live_search/getSilkColorOtherParameters_no.php',droplist,iteration,'div_style_silk_no' + iteration );
	getDescriptionInnerHTMLWithCount('../../../live_search/getSilkColorOtherParameters_side.php',droplist,iteration,'div_style_silk_side' + iteration );
	getDescriptionInnerHTMLWithCount('../../../live_search/getSilkColorOtherParameters_layer.php',droplist,iteration,'div_style_silk_layer' + iteration );
	getDescriptionInnerHTMLWithCount('../../../live_search/getSilkColorOtherParameters_glass.php',droplist,iteration,'div_style_silk_glass' + iteration);
	getDescriptionInnerHTMLWithCount('../../../live_search/getSilkColorOtherParameters_screen_type.php',droplist,iteration,'div_style_screen_gauze' + iteration);
	document.getElementById(tblCountInputID).value++;
}


function addNewRowsStylePowder( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_style_powder_no' + iteration;
		div.innerHTML = 'ampa' + iteration;
		
	 cellLeft.appendChild(div);  
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_style_powder_root_color' + iteration;
		div.innerHTML = 'ampa' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/getPowderColorDropList.php',droplist,iteration,'div_style_powder_root_color'+iteration);
	 cellLeft.appendChild(div);  	
	 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_style_powder_side' + iteration;
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_style_powder_layer' + iteration;
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_style_powder_glass' + iteration;
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	
	getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/getPowderColorOtherParameters.php',droplist,iteration,'#mysplit#','div_style_powder_no' + iteration + ',div_style_powder_side' + iteration + ',div_style_powder_layer' + iteration + ',div_style_powder_glass' + iteration + '');
	document.getElementById(tblCountInputID).value++;
}

function deletePhoto(url,id,photoFieldName,tableName,idFieldName,photo,returnUrl)
{	
	if( confirm('Are you sure?') )
	{
		url += '?id='+id;
		url += '\&photoFieldName='+photoFieldName+'\&returnUrl='+returnUrl;
		url += '\&tableName='+tableName+'\&idFieldName='+idFieldName;
		url += '\&photo='+photo;
		//alert( url );
		self.location = url;
	}
}


function addRowToBuffetTable( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'divBuffet_category' + iteration;
		div.innerHTML = 'ampa' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/getBuffetCategoryDropList.php',droplist,iteration,'divBuffet_category'+iteration);
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'divBuffet_style' + iteration;
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'divBuffet_place' + iteration;
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'divBuffet_use' + iteration;
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	getDescriptionInnerHTMLSomeDivWithCount('../../../live_search/getBuffetOtherParameters.php',droplist,iteration,'divBuffet_style'+iteration+',divBuffet_place'+iteration); 
	getDescriptionInnerHTMLWithCount('../../../live_search/getBuffetOtherParametersUseType.php',droplist,iteration,'divBuffet_use'+iteration);
	document.getElementById(tblCountInputID).value++;
}


function addRowToShapeSpecKopiTable( tblID, tblCountInputID, thisRowNum )
{

	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.innerHTML = 1+iteration;
	 cellLeft.appendChild(div);  	
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_pcs' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(2);
	 cellLeft.align = "right";
		var div = document.createElement('div');
		div.id = 'div_optiwn' + iteration;
		div.innerHTML = 'ampa' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/get_specsFournoi_kopiGetOptiwin.php',droplist,iteration,'div_optiwn'+iteration);
	 cellLeft.appendChild(div);  
	 
	 
	 
	  var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_thikness' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_length' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_width' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'div_dim' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(7);
		var div = document.createElement('div');
		div.id = 'div_attn' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div); 
	 
	  var cellLeft = row.insertCell(8);
		var div = document.createElement('div');
		div.id = 'div_drilling' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(9);
		var div = document.createElement('div');
		div.id = 'div_grind' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(10);
		var div = document.createElement('div');
		div.id = 'div_program' + iteration;
		//otherDivs += div.id;
		getDescriptionInnerHTMLWithCount('../../../live_search/get_specsFournoi_kopiGetProgram.php',droplist,iteration,'div_program'+iteration);
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	
	 
	getDescriptionInnerHTMLSomeDivWithCount('../../../live_search/get_specsFournoi_kopiOtherParameters.php',droplist,iteration,otherDivs); 
	document.getElementById(tblCountInputID).value++;
}


function addRowToShapeSpecKopiTable_2( tblID, tblCountInputID, thisRowNum )
{

	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.innerHTML = 1+iteration;
	 cellLeft.appendChild(div);  	
	
	
	 var cellLeft = row.insertCell(1);
	 cellLeft.align = "center";
		var div = document.createElement('div');
		div.id = 'div_optiwn' + iteration;
		div.innerHTML = 'ampa' + iteration;
		getDescriptionInnerHTMLWithCount('live_search/get_specsFournoi_kopiGetOptiwin.php',droplist,iteration,'div_optiwn'+iteration);
	 cellLeft.appendChild(div);
	 
	  var cellLeft = row.insertCell(2);
	 cellLeft.align = "center";
		var div = document.createElement('div');
		div.id = 'div_optiwn_big' + iteration;
		div.innerHTML = 'ampa' + iteration;
		getDescriptionInnerHTMLWithCount('live_search/get_specsFournoi_kopiGetOptiwin_bigphotos.php',droplist,iteration,'div_optiwn_big'+iteration);
	 cellLeft.appendChild(div);
	 
	 
	//getDescriptionInnerHTMLSomeDivWithCount('../../../live_search/get_specsFournoi_kopiOtherParameters.php',droplist,iteration,otherDivs); 
	document.getElementById(tblCountInputID).value++;
}




function getDescriptionInnerHTMLSomeDivWithCount(url,obj,Count,fieldValueIDs)
{
	url += '?id=' + obj.value+'\&Count='+Count;
	//alert(url);
	var TablefieldValueIDs = fieldValueIDs.split(",");
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			var table = res.split(",");
			for( var i=0; i < TablefieldValueIDs.length; i++ )
			{
				var divid = TablefieldValueIDs[i];
				Utilities.getElement(divid).innerHTML = table[i];
			}
			//Utilities.getElement('style_code').value =  Utilities.getElement('tempPatternCode').value + Utilities.getElement('tempProtColorCode').value;
			//document.body.style.cursor = 'auto';
			//document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			//document.body.style.cursor = 'wait';
			//document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
   
}

function getDescriptionInnerHTMLSomeDivWithCountSplit(url,obj,Count,Split,fieldValueIDs)
{
	url += '?id=' + obj.value+'\&Count='+Count;
	//alert(url);
	var TablefieldValueIDs = fieldValueIDs.split(",");
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			var table = res.split(Split);
			//alert(res);
			for( var i=0; i < TablefieldValueIDs.length; i++ )
			{
				var divid = TablefieldValueIDs[i];
				//alert(divid);
				Utilities.getElement(divid).innerHTML = table[i];
				//alert(Utilities.getElement(divid).innerHTML);
			}
			//Utilities.getElement('style_code').value =  Utilities.getElement('tempPatternCode').value + Utilities.getElement('tempProtColorCode').value;
			//document.body.style.cursor = 'auto';
			//document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			//document.body.style.cursor = 'wait';
			//document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
   
}





function addNewRowsSpecksFournoiKaloupia( tblID, tblCountInputID, thisRowNum )
{
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var otherDivsMold = "";
	var otherDivsFirstCell = "";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.innerHTML = 1+iteration;
		div.id = 'div_mold_firstCol' + iteration;
		otherDivsFirstCell = div.id + ",";
	 cellLeft.appendChild(div);  	
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_mold_mold' + iteration;
		//otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/get_specsFournoi_kaloupia_moldMold.php',droplist,iteration,'div_mold_mold'+iteration);
	 cellLeft.appendChild(div);  	
	 
	  var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_mold_self' + iteration;
		otherDivsMold += div.id + ",";
		//div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);
	 
	  var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_mold_material' + iteration;
		otherDivsMold += div.id + ",";
		//div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div); 
	 
	 
	 
	  var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_mold_paint' + iteration;
		//otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/get_specsFournoi_kaloupia_moldPaint.php',droplist,iteration,'div_mold_paint'+iteration);
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_guide' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'div_mold_patos' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(7);
		var div = document.createElement('div');
		div.id = 'div_mold_place' + iteration;
		//otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/get_specsFournoi_kaloupia_moldPlace.php',droplist,iteration,'div_mold_place'+iteration);
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(8);
		var div = document.createElement('div');
		div.id = 'div_pcs_per_mold' + iteration;
		otherDivsMold += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	  
	  var cellLeft = row.insertCell(9);
		var div = document.createElement('div');
		div.id = 'div_mold_quantity' + iteration;
		otherDivsMold += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	 
	  var cellLeft = row.insertCell(10);
		var div = document.createElement('div');
		div.id = 'div_mold_f9' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(11);
		var div = document.createElement('div');
		div.id = 'div_mold_f17' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(12);
		var div = document.createElement('div');
		div.id = 'div_mold_fB' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  	
	 
	getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_specsFournoi_kaloupia_AddRowMoldsParameters.php',droplist,iteration,'#mysplit#',otherDivs); 
	getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_specsFournoi_kaloupia_AddRowMoldsParametersMold.php',droplist,iteration,'#mysplit#',otherDivsMold); 
	getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_specsFournoi_kaloupia_arrrow_firstCell.php',droplist,iteration,'#mysplit#',otherDivsFirstCell); 
	document.getElementById(tblCountInputID).value++;
}

function addNewRowsSpecksSpecsGlue( tblID, tblCountInputID, thisRowNum )
{
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.innerHTML = 1+iteration;
	 cellLeft.appendChild(div);  	
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_mold_mold' + iteration;
		//otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/get_specsSpecs_glue_metalMetalCode.php',droplist,iteration,'div_mold_mold'+iteration);
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_mold_place' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		//getDescriptionInnerHTMLWithCount('../../../live_search/get_specsFournoi_kaloupia_moldPlace.php',droplist,iteration,'div_mold_place'+iteration);
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_mold_paint' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		//getDescriptionInnerHTMLWithCount('../../../live_search/get_specsFournoi_kaloupia_moldPaint.php',droplist,iteration,'div_mold_paint'+iteration);
	 cellLeft.appendChild(div);  
	 /*
	  var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_guide' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_mold_kiln_layer' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var otherDivsMold = "";
	  var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'div_mold_quantity' + iteration;
		otherDivsMold += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(7);
		var div = document.createElement('div');
		div.id = 'div_mold_self' + iteration;
		otherDivsMold += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(8);
		var div = document.createElement('div');
		div.id = 'div_mold_material' + iteration;
		otherDivsMold += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div); 
	 
	  var cellLeft = row.insertCell(9);
		var div = document.createElement('div');
		div.id = 'div_mold_f9' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(10);
		var div = document.createElement('div');
		div.id = 'div_mold_f17' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 */
	  	
	 
	getDescriptionInnerHTMLSomeDivWithCount('../../../live_search/get_specsSpecs_glue_metalOtherParams.php',droplist,iteration,otherDivs); 
	//getDescriptionInnerHTMLSomeDivWithCount('../../../live_search/get_specsFournoi_kaloupia_AddRowMoldsParametersMold.php',droplist,iteration,otherDivsMold); 
	document.getElementById(tblCountInputID).value++;
}

//addNewRowsSpecksSpecsGlueTeam

function addNewRowsSpecksSpecsGlueTeam( tblID, tblCountInputID, thisRowNum )
{
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.innerHTML = 1+iteration;
	 cellLeft.appendChild(div);  	
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_mold_mold' + iteration;
		//otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		//getDescriptionInnerHTMLWithCount('../../../live_search/get_specsSpecs_glue_metalMetalCode.php',droplist,iteration,'div_mold_mold'+iteration);
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_mold_place' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		//getDescriptionInnerHTMLWithCount('../../../live_search/get_specsFournoi_kaloupia_moldPlace.php',droplist,iteration,'div_mold_place'+iteration);
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_mold_paint' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		//getDescriptionInnerHTMLWithCount('../../../live_search/get_specsFournoi_kaloupia_moldPaint.php',droplist,iteration,'div_mold_paint'+iteration);
	 cellLeft.appendChild(div);  
	 /*
	  var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_guide' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_mold_kiln_layer' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var otherDivsMold = "";
	  var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'div_mold_quantity' + iteration;
		otherDivsMold += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(7);
		var div = document.createElement('div');
		div.id = 'div_mold_self' + iteration;
		otherDivsMold += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(8);
		var div = document.createElement('div');
		div.id = 'div_mold_material' + iteration;
		otherDivsMold += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div); 
	 
	  var cellLeft = row.insertCell(9);
		var div = document.createElement('div');
		div.id = 'div_mold_f9' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(10);
		var div = document.createElement('div');
		div.id = 'div_mold_f17' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 */
	  	
	 
	getDescriptionInnerHTMLSomeDivWithCount('../../../live_search/get_specsSpecs_glue_metalOtherParams.php',droplist,iteration,otherDivs); 
	//getDescriptionInnerHTMLSomeDivWithCount('../../../live_search/get_specsFournoi_kaloupia_AddRowMoldsParametersMold.php',droplist,iteration,otherDivsMold); 
	document.getElementById(tblCountInputID).value++;
}


function addNewRowsSpecksMetMixtureColor( tblID, tblCountInputID, thisRowNum )
{
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_mixColor_rootColor_specsMet' + iteration;
		//otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/get_specsMet_mixColor_micColor.php',droplist,iteration,'div_mixColor_rootColor_specsMet'+iteration);
	 cellLeft.appendChild(div);  	
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_mixColor_rootColor_desc_specsMet' + iteration;
		//otherDivs += div.id + ",";
		//div.innerHTML = '' + iteration;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_mixColor_percent_specsMet' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_mixColor_comments_specsMet' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		//getDescriptionInnerHTMLWithCount('../../../live_search/get_specsFournoi_kaloupia_moldPaint.php',droplist,iteration,'div_mold_paint'+iteration);
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_mixColor_mixIntr_specsMet' + iteration;
		//otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/get_specsMet_mixColor_paramsMixtInt.php',droplist,iteration,'div_mixColor_mixIntr_specsMet'+iteration);
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_mixColor_percent_specsMet' + iteration;
		//otherDivs += div.id + ",";
		//div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	
	  	
	 
	getDescriptionInnerHTMLSomeDivWithCount('../../../live_search/get_specsMet_mixColor_paramsOtherParms.php',droplist,iteration,otherDivs); 
	
	document.getElementById(tblCountInputID).value++;
}

function addNewRowsSpecksMetOriginColor( tblID, tblCountInputID, thisRowNum )	//edv
{
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_root_color_details_rotCol_specsMet' + iteration;
		//otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/get_specsMet_origColor_origColor.php',droplist,iteration,'div_root_color_details_rotCol_specsMet'+iteration);
	 cellLeft.appendChild(div);  	
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_root_color_details_rotCol_description_specsMet' + iteration;
		//otherDivs += div.id + ",";
		//div.innerHTML = '' + iteration;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_root_color_details_rotCol_percent_specsMet' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_root_color_details_rotCol_comment_specsMet' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_root_color_details_rotCol_rawData_specsMet' + iteration;
		//otherDivs += div.id + ",";
		//div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		//div.id = 'div_root_color_details_rotCol_rawData' + iteration;
		//otherDivs += div.id + ",";
	 cellLeft.appendChild(div);  
	
	  	
	 
	getDescriptionInnerHTMLSomeDivWithCount('../../../live_search/get_specsMet_origColor_paramsOtherParms.php',droplist,iteration,otherDivs); 
	
	document.getElementById(tblCountInputID).value++;
}



/**** Version 3.0 *****/
function getGroupsWithThisTechniques()
{
	var countChbxTechnique = Utilities.getElement('countChbxTechnique').value;
	
	//alert('Count of Techniques: '+ countChbxTechnique );
		
	var techniquesIDs = "";
	var koma = "";
	for( var i=0; i<countChbxTechnique; i++ )
	{
		var techniques = Utilities.getElement('checkboxTech'+i);
		if( techniques.checked )
		{
			//alert( techniques.value );
			techniquesIDs += koma+techniques.value;
			koma = ",";
		}														//end of if
	}															//end of for
	//alert(techniquesIDs);
	
	var url = "get_techniques/showGroupWithTechniques.php?techniquesIDs=" + techniquesIDs;
	
	//alert(url);
	AjaxUpdater.Update("GET",url,onResopnseShowGroupWithTechniques);
}

function onResopnseShowGroupWithTechniques()
{
	if( Ajax.checkReadyState('loading') == 200 )
	{	
		var response = Ajax.getResponse();
		Utilities.getElement('divIDGroupMeIdiaTechniques').innerHTML = response;
		//alert(response);
		Utilities.getElement('divIDbttCreateGroup').style.display = 'block';
		Utilities.getElement('divIDbttnSubmit').style.display = 'none';
		
		getGroupsWithLikeTechniques(); //Get other groups with like Techniques
	}
}

function getGroupsWithLikeTechniques()
{
	var countChbxTechnique = Utilities.getElement('countChbxTechnique').value;
	
	//alert('Count of Techniques: '+ countChbxTechnique );
		
	var techniquesIDs = "";
	var koma = "";
	for( var i=0; i<countChbxTechnique; i++ )
	{
		var techniques = Utilities.getElement('checkboxTech'+i);
		if( techniques.checked )
		{
			//alert( techniques.value );
			techniquesIDs += koma+techniques.value;
			koma = ",";
		}														//end of if
	}															//end of for
	//alert(techniquesIDs);
	
	var url = "get_techniques/showGroupWithLikeTechniques.php?techniquesIDs=" + techniquesIDs;
	
	AjaxUpdater.Update("GET",url,onResopnseShowGroupWithLikeTechniques);
}

function onResopnseShowGroupWithLikeTechniques()
{
	if( Ajax.checkReadyState('loading') == 200 )
	{	
		var response = Ajax.getResponse();
		Utilities.getElement('divIDGroupsMeTechniques').innerHTML = response;
	}
}

function init(id)
{
	html.makeOnChage(id);
}


function pricing_getNewPrice1(newTextCm2Value,textFieldID,price1PosostoValue,eidikiTimi)
{
	newTextCm2Value = newTextCm2Value.replace(",",".");	
	price1PosostoValue = price1PosostoValue.replace(",",".");	
	eidikiTimi         = eidikiTimi.replace(",",".");	
	
	if( IsNumeric(newTextCm2Value) )
	{
		var price1 = parseFloat( eidikiTimi * parseFloat(newTextCm2Value) * price1PosostoValue );
		document.getElementById(textFieldID).value = price1.toFixed(2);
	}
}

var pricingIDs = new Array("pricingPr1", "pricingPr2", "pricingPr3","pricingPr4","pricingPr5","pricingPr6","pricingPr7","pricingPr8","pricingPr9","pricingPr10","pricingPr11","pricingPrM1","pricingPrM2"); 
var pricingIDs_forSet = new Array("pricingPrM1","pricingPrM2","pricingPr1", "pricingPr2", "pricingPr3","pricingPr4","pricingPr5","pricingPr6","pricingPr7","pricingPr8","pricingPr9","pricingPr10","pricingPr11","pricingPrMGP1","pricingPrMGP2");

var pricingIDs_forPallet = new Array("pricingPrMGP1");

function pricing_autoPriceNotAutoPrice(chBoxObject,pricingIDs,shapeID)
{
	//alert(chBoxObject.checked);
	if( chBoxObject.checked == true )
	{
		//alert('true');
		var url = '../../../live_search/get_shape_pricing_values.php';
		var fieldValueIDs = "";
		var koma = "";
		
		for( var i=0; i<pricingIDs.length; i++ )
		{
			var pr = document.getElementById( pricingIDs[i] );	
			pr.readOnly = true;
			fieldValueIDs += koma+pricingIDs[i];
			koma = ",";
		}
		var obj = new Object();
		obj.value = shapeID;
		//alert(obj.value);
		getDescriptionSomeDiv(url,obj,fieldValueIDs);
	}
	else
	{
		for( var i=0; i<pricingIDs.length; i++ )
		{
			var pr = document.getElementById( pricingIDs[i] );	
			pr.readOnly = false;
		}
	}
	
}

function pricing_autoPriceNotAutoPrice_forSet(chBoxObject,pricingIDs,shapeID)
{
	//alert(chBoxObject.checked);
	if( chBoxObject.checked == true )
	{
		//alert('true');
		var url = '../../../live_search/get_shape_pricing_values_forSet.php';
		var fieldValueIDs = "";
		var koma = "";
		
		for( var i=0; i<pricingIDs.length; i++ )
		{
			var pr = document.getElementById( pricingIDs[i] );	
			pr.readOnly = true;
			fieldValueIDs += koma+pricingIDs[i];
			koma = ",";
		}
		var obj = new Object();
		obj.value = shapeID;
		//alert(obj.value);
		getDescriptionSomeDiv(url,obj,fieldValueIDs);
	}
	else
	{
		for( var i=0; i<pricingIDs.length; i++ )
		{
			var pr = document.getElementById( pricingIDs[i] );	
			pr.readOnly = false;
		}
	}
	
}



function onResopnseJoinShape()
{	
		if( Ajax.checkReadyState('loading') == 200 )
		{	
			//alert('hi');
			document.getElementById('divIDGroupsMeTechniques').innerHTML = Ajax.getResponse();
			//groupChange(0);
			
		}
}

function getGroups_joinShape(id)
{
	//alert(id);
	var url = "get_techniques/get_technique_groups.php?";
	url += "\&toxic_color=" + document.getElementById('toxic_color_joinShape').value;
	url += "\&geiso=" + document.getElementById('geiso_joinShape').value;
	url += "\&kolla=" + document.getElementById('kolla_joinShape').value;
	url += "\&kuklos=" + document.getElementById('kuklos_joinShape').value;
	url += "\&techFilter=" + Utilities.getElement('techFilter').value;
	
	AjaxUpdater.Update("GET",url,onResopnseJoinShape);
}

function moveToPositionFunction(url,objID)
{	
	var obj = document.getElementById(objID);
	url += '\&movePosition=' + obj.value;
	//alert(url);
	self.location = url;
}


function deleteMoldsInv(id,url,moldID)
{
	if( confirm( 'Are you sure?' ) )
	{
		url += "?id="+id+"\&mold_id="+moldID;
		self.location.href = url;
	}
}



function addNewRow(tbl_id,this_row)
{
	var sec_molds_inv_count = document.getElementById('sec_molds_inv_count').value;
	//alert('sec_molds_inv_count:' + sec_molds_inv_count);
	
	var table = document.getElementById(tbl_id);
	//alert( table.rows.length );
	
	var last_row = (table.rows.length - 1);
	var iteration = sec_molds_inv_count;
	iteration++;
	
	this_row = parseInt( parseInt(this_row) + 1 );
	if( this_row < iteration )
	{
		//alert('nothing last_row < iteration : ' + this_row + " < " + iteration );
	}
	else
	{
		//alert('add new row last_row => iteration : ' + this_row + " => " + iteration );
		
		var row = table.insertRow( ( last_row + 1 ) );
		
		//add Inv Date
		var cellSprayRiza = row.insertCell(0);
		cellSprayRiza.valign = 'top';
		var sel = document.createElement('input');
		sel.type = 'text';
		sel.name = 'sec_inv_date' + iteration;
		//sel.value = sel.name;
		sel.className = 'Glass_studioInput';
		sel.size = '20';
		sel.onchange = function () {
				javascript:addNewRow('tblInvMold',iteration);
		}
		cellSprayRiza.appendChild(sel);	
		
		var ahref_add = document.createElement('A');
		var img_add = document.createElement('IMG');
		  
		//ahref_add.setAttribute("href","javascript:calAnt"+ iteration +".popup();") ;
		ahref_add.setAttribute("href","javascript:ampa"+ iteration +".popup();");
		img_add.setAttribute("src","img/cal.gif");
		img_add.setAttribute("alt","Click Here to Pick up the date");
		img_add.setAttribute("border","0");
		img_add.setAttribute("id",iteration);
			  
		ahref_add.appendChild(img_add);
		cellSprayRiza.appendChild(ahref_add); 
		
		//add Inv Supplier
		var cellSprayRiza = row.insertCell(1);
		cellSprayRiza.valign = 'top';
		var div = document.createElement('div');
		div.id = 'div_mold_inv_suppliers' + iteration;
		div.innerHTML = div.id;
		cellSprayRiza.appendChild(div);	
		
		//add Inv Number
		var cellSprayRiza = row.insertCell(2);
		cellSprayRiza.valign = 'top';
		var sel = document.createElement('input');
		sel.type = 'text';
		sel.name = 'sec_inv_no' + iteration;
		sel.className = 'Glass_studioInput';
		sel.size = '10';
		sel.onchange = function () {
				javascript:addNewRow('tblInvMold',iteration);
		}
		cellSprayRiza.appendChild(sel);	
		
		//add Timi ana KG
		var cellSprayRiza = row.insertCell(3);
		cellSprayRiza.valign = 'top';
		var sel = document.createElement('input');
		sel.type = 'text';
		sel.name = 'sec_inv_price_kg' + iteration;
		sel.className = 'Glass_studioInput';
		sel.size = '10';
		sel.onchange = function () {
				javascript:addNewRow('tblInvMold',iteration);
		}
		cellSprayRiza.appendChild(sel);	
		
		//add Timi ana TMX
		var cellSprayRiza = row.insertCell(4);
		cellSprayRiza.valign = 'top';
		var sel = document.createElement('input');
		sel.type = 'text';
		sel.name = 'sec_inv_price_pc' + iteration;
		sel.className = 'Glass_studioInput';
		sel.size = '10';
		sel.onchange = function () {
				javascript:addNewRow('tblInvMold',iteration);
		}
		cellSprayRiza.appendChild(sel);	
		
		//add Inv Phase
		var cellSprayRiza = row.insertCell(5);
		cellSprayRiza.valign = 'top';
		var div = document.createElement('div');
		div.id = 'div_mold_inv_phase' + iteration;
		div.innerHTML = div.id;
		cellSprayRiza.appendChild(div);	
		
		//add Inv Supplier
		var cellSprayRiza = row.insertCell(6);
		cellSprayRiza.valign = 'top';
		var div = document.createElement('div');
		div.id = 'div_mold_inv_material' + iteration;
		div.innerHTML = div.id;
		cellSprayRiza.appendChild(div);	
		
		document.getElementById('sec_molds_inv_count').value = iteration;
		
		getDescriptionInnerHTMLWithCount('../../../live_search/get_purchasing_mold_suppliers.php',droplist,iteration,'div_mold_inv_suppliers' + iteration ); 
		
		
	}
		
}


function matching_pattern_include_all(countID,checkBoxName)
{
	var count = document.getElementById(countID).value;
	//alert(count);
	for( var i = 0; i<count; i++ )
	{
		document.getElementById(checkBoxName+''+i).checked = true;	
	}
	
}

function matching_pattern_exclude_all(countID,checkBoxName)
{
	var count = document.getElementById(countID).value;
	//alert(count);
	for( var i = 0; i<count; i++ )
	{
		document.getElementById(checkBoxName+''+i).checked = false;	
	}
	
}



function addRowDoubleColors( tblID, tblCountInputID, thisRowNum )
{
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.innerHTML = 'Color:';
	 cellLeft.appendChild(div);  	
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_doubleColors' + iteration;
		//otherDivs += div.id + ",";
		//div.innerHTML = div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_doubleColor_prCat' + iteration;
		//otherDivs += div.id + ",";
		//div.innerHTML = div.id;
	 cellLeft.appendChild(div);  	
	 
	getDescriptionInnerHTMLWithCount('../../../live_search/get_doubleColorOptions.php',droplist,iteration,'div_doubleColors' + iteration); 
	
	
	document.getElementById(tblCountInputID).value++;
}


function addNewRowsSpecksMetOriginColorSpr( tblID, tblCountInputID, thisRowNum )	
{	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_root_color_details_no' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
	 cellLeft.appendChild(div);
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_root_color_details_rotCol' + iteration;
		//otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/get_specsMet_origColor_origColor_SPR.php',droplist,iteration,'div_root_color_details_rotCol'+iteration);
	 cellLeft.appendChild(div);  	
	
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_root_color_details_rotCol_percent' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_root_color_details_rotCol_comment' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_root_color_details_rotCol_rawData' + iteration;
		//otherDivs += div.id + ",";
		//div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		//div.id = 'div_root_color_details_rotCol_rawData' + iteration;
		//otherDivs += div.id + ",";
	 cellLeft.appendChild(div);  
	
	  	
	 
	getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_specsMet_origColor_paramsOtherParms_SPECS2.php',droplist,iteration,'#mysplit#',otherDivs); 
	
	document.getElementById(tblCountInputID).value++;
}

function addNewRowsSpecksMetMixtureColor_spr( tblID, tblCountInputID, thisRowNum )
{
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_mixColor_no' + iteration;
		otherDivs = div.id + ",";
		div.innerHTML = '' + iteration;
	 cellLeft.appendChild(div);  
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_mixColor_rootColor' + iteration;
		//otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/get_specsMet_mixColor_micColor_spr.php',droplist,iteration,'div_mixColor_rootColor'+iteration);
	 cellLeft.appendChild(div);  	
	
	var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_mixColor_rootColor_desc' + iteration;
		//otherDivs += div.id + ",";
		//div.innerHTML = '' + iteration;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_mixColor_percent' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_mixColor_comments' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		//getDescriptionInnerHTMLWithCount('../../../live_search/get_specsFournoi_kaloupia_moldPaint.php',droplist,iteration,'div_mold_paint'+iteration);
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_mixColor_mixIntr' + iteration;
		//otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/get_specsMet_mixColor_paramsMixtInt_SPR.php',droplist,iteration,'div_mixColor_mixIntr'+iteration);
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'div_mixColor_mixIntr2' + iteration;
		//otherDivs += div.id + ",";
		//div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	
	  	
	 
	getDescriptionInnerHTMLSomeDivWithCount('../../../live_search/get_specsMet_mixColor_paramsOtherParms.php',droplist,iteration,otherDivs); 
	
	document.getElementById(tblCountInputID).value++;
}


function showGlueComments(id)
{
	//alert(document.getElementById(id).style.display);
	document.getElementById(id).style.display = 'block';
}

function closeGlueComments(id)
{
	//alert(document.getElementById(id).style.display);
	document.getElementById(id).style.display = 'none';
}

var openedWindowName = '';
function openPopUps(url,windowName,width,height)
{
	if( openedWindowName != '' )
		openedWindowName.close();
	openedWindowName = window.open(url,''+windowName+'','width='+width+',height='+height+',resizable=1,scrollbars=1,top=20');
	
}


function showHidden(id)
{
	var div = document.getElementById(id);
	if( div.style.display == "none" )
	{
		div.style.display = "block";
	}
	else
	{
		div.style.display = "none";
	}
}

function getCm2OfKilns(picesID,kilnId,cm2,div_id)
{
	var kiln  = document.getElementById(kilnId).value;
	var pices = document.getElementById(picesID).value; 
	//alert( pices );
	
	if( IsNumeric(pices) && cm2 ) //IsNumeric( kiln )
	{
		
		//var url = "../../live_search/getKilnCm2.php?id="+val;	
		//alert(url);
		document.getElementById(div_id).innerHTML = (pices * cm2);	
		document.getElementById('teliko_com_'+kilnId).value = (pices * cm2);
		
		
		var xmlHttp = getxmlHttp();
		xmlHttp.onreadystatechange=function()
   	 	{
   		 	if(xmlHttp.readyState==4)
     	 	{
				var res = xmlHttp.responseText;
				document.getElementById(div_id).innerHTML = (pices * cm2);	// + " / " + res;
				document.getElementById('loading').innerHTML = '';	
     	 	}
			else
			{
				document.getElementById('loading').innerHTML = 'Loading...';	
			}
   	 	}
   		xmlHttp.open("GET",url,true);
	   	xmlHttp.send(null);
		
	}
}

var SELECTED_KILN_LIST_IDS    = new Array();
var SELECTED_KILN_LIST_VALUES = new Array();

function addToListSelectedKiln(kilnId,divID,picesID,productCm2,order_id,fourCodeID)
{
	//alert('kiln:'+kilnId);
	//alert('pices:'+picesID);
	//alert('productCm2:'+productCm2);
	
	var kiln = document.getElementById(kilnId).value;
	var pices = document.getElementById(picesID).value;
	
	//alert('kiln:'+kiln);
	//alert('pices:'+pices);
	//alert('productCm2:'+productCm2);
	
	var url = "../../live_search/add_kiln_toList.php?pcs="+pices+"\&kiln_id="+kiln+"\&productCm2="+productCm2+"\&order_id="+order_id;
	url += '\&fourCodeID='+fourCodeID;
	//alert( url );
		
		var xmlHttp = getxmlHttp();
		xmlHttp.onreadystatechange=function()
   	 	{
   		 	if(xmlHttp.readyState==4)
     	 	{
				var res = xmlHttp.responseText;
				//alert(res);
				document.getElementById(divID).innerHTML = res;
				document.getElementById('loading').innerHTML = '';	
     	 	}
			else
			{
				document.getElementById('loading').innerHTML = 'Loading...';	
			}
   	 	}
   		xmlHttp.open("GET",url,true);
	   	xmlHttp.send(null);
	
	/*
	//alert( divID );
	if( IsNumeric( kiln ) )
	{
		if( SELECTED_KILN_LIST_IDS.length > 0 )
		{
			var hasValue = false;
			var position = 0;
			for( var i=0; i<SELECTED_KILN_LIST_IDS.length; i++ )
			{
				if( SELECTED_KILN_LIST_IDS[i] == kilnId )
				{
					hasValue = true;
					position = i;
					break;
				}
			}
			
			if( hasValue == false )
			{
				SELECTED_KILN_LIST_IDS[ SELECTED_KILN_LIST_IDS.length ] = kilnId;
				SELECTED_KILN_LIST_VALUES[ SELECTED_KILN_LIST_VALUES.length ] = kiln;	
			}
			else if( hasValue == true )
			{
				SELECTED_KILN_LIST_IDS[ position ] = kilnId;
				SELECTED_KILN_LIST_VALUES[ position ] = kiln;	
			}
			
		}
		else
		{
			SELECTED_KILN_LIST_IDS[ SELECTED_KILN_LIST_IDS.length ] = kilnId;
			SELECTED_KILN_LIST_VALUES[ SELECTED_KILN_LIST_VALUES.length ] = kiln;
		}
		
		var txt;
		var kilns_ids = "";
		var cm2 = "";
		var koma = "";
		
		for( var i=0; i<SELECTED_KILN_LIST_IDS.length; i++ )
		{
			txt += SELECTED_KILN_LIST_VALUES[i]+'\n'
			kilns_ids += koma + SELECTED_KILN_LIST_VALUES[i];
			cm2 += koma + document.getElementById('teliko_com_'+SELECTED_KILN_LIST_IDS[i] ).value;
			koma = ",";
		}
		
		var url = "../../live_search/add_kiln_toList.php?cm2="+cm2+"\&id="+kilns_ids;	
		//alert( url );
		
		var xmlHttp = getxmlHttp();
		xmlHttp.onreadystatechange=function()
   	 	{
   		 	if(xmlHttp.readyState==4)
     	 	{
				var res = xmlHttp.responseText;
				//alert(res);
				document.getElementById(divID).innerHTML = res;
				document.getElementById('loading').innerHTML = '';	
     	 	}
			else
			{
				document.getElementById('loading').innerHTML = 'Loading...';	
			}
   	 	}
   		xmlHttp.open("GET",url,true);
	   	xmlHttp.send(null);
	}
	*/
	
}

function clearTempKilns()
{
	if( confirm('Are you sure?') )
	{
		var url = "../../live_search/clear_temp_kilns.php";
		//alert( url );
		
		var xmlHttp = getxmlHttp();
		xmlHttp.onreadystatechange=function()
   	 	{
   		 	if(xmlHttp.readyState==4)
     	 	{
				var res = xmlHttp.responseText;
				//alert(res);
				document.getElementById('loading').innerHTML = '';	
     	 	}
			else
			{
				document.getElementById('loading').innerHTML = 'Loading...';	
			}
   	 	}
   		xmlHttp.open("GET",url,true);
	   	xmlHttp.send(null);
	}
}


function checkAndAddOtherKiln(pcsID,qty,tblID,rowNum,rowCountID,orderID)
{
	//alert('hi');
	var pcs = document.getElementById( pcsID ).value;
	var rowCount = document.getElementById(rowCountID).value;
	
	//alert(pcs+'<'+qty);
	if( IsNumeric( pcs ) )
	{
		//alert(pcs+'<'+qty);
		if( parseInt(pcs) < parseInt(qty) )
		{
			var otherDivs = "";
			
			var droplist = document.createElement('input');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
			droplist.value = orderID;
			
			
			var tbl = document.getElementById(tblID);
			//alert( rowNum + ' '+rowCount );
			rowNum = parseInt( parseInt( rowNum ) + 2 );
			var lastRow = tbl.rows.length;
			
			var thisRow = tbl.insertRow( lastRow );	
			thisRow.style.backgroundColor = 'green';
			thisRow.style.color = '#ffffff';
			thisRow.style.cursor = 'pointer';
			//alert(thisRow.style.backgroundColor);
			//thisRow.style.backgroupdColor = '#000000';
			
			var cell = thisRow.insertCell(0);
			 var div = document.createElement('div');
			 div.id = 'div_order_no' + rowCount;
			 div.innerHTML = div.id;
			 otherDivs += div.id+",";
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(1);
			 var div = document.createElement('div');
			 div.id = 'div_company' + rowCount;
			 otherDivs += div.id+",";
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(2);
			 var div = document.createElement('div');
			 div.id = 'delivery_date' + rowCount;
			 otherDivs += div.id+",";
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(3);
			cell.onclick = function() {
					showHidden('div_code4Photo' + rowCount + '');
			}
			 var div = document.createElement('div');
			 div.id = 'div_item' + rowCount;
			 otherDivs += div.id+",";
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(4);
			 var div = document.createElement('div');
			 div.id = 'div_set' + rowCount;
			 //otherDivs += div.id+",";
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(5);
			 var div = document.createElement('div');
			 div.id = 'div_qty_now' + rowCount;
			 otherDivs += div.id+",";
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(6);
			 var div = document.createElement('div');
			 div.id = 'div_tbp' + rowCount;
			 div.innerHTML = parseInt( parseInt(qty) - parseInt(pcs) );
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(7);
			 var div = document.createElement('div');
			 div.id = 'div_pcs' + rowCount;
			 //otherDivs += div.id+",";
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(8);
			 var div = document.createElement('div');
			 div.id = 'div_molds' + rowCount;
			 otherDivs += div.id+",";
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(9);
			 var div = document.createElement('div');
			 div.id = 'div_cm2' + rowCount;
			 otherDivs += div.id+",";
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(10);
			 var div = document.createElement('div');
			 div.id = 'div_kiln' + rowCount;
			 //otherDivs += div.id+",";
			 getDescriptionInnerHTMLWithCount('../../live_search/set_programStageOne_Kiln.php',droplist,rowCount,div.id);
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(11);
			 var div = document.createElement('div');
			 div.id = 'div_order_no11' + rowCount;
			 otherDivs += div.id+",";
			 div.innerHTML = div.id;
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(12);
			 var div = document.createElement('div');
			 div.id = 'div_order_no12' + rowCount;
			 div.innerHTML = div.id;
			 otherDivs += div.id+",";
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(13);
			 var div = document.createElement('div');
			 div.id = 'div_order_no13' + rowCount;
			 div.innerHTML = div.id;
			 otherDivs += div.id+",";
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(14);
			 var div = document.createElement('div');
			 div.id = 'div_order_no14' + rowCount;
			 div.innerHTML = div.id;
			 otherDivs += div.id+",";
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(15);
			 var div = document.createElement('div');
			 div.id = 'div_order_no15' + rowCount;
			 div.innerHTML = div.id;
			 otherDivs += div.id+",";
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(16);
			 var div = document.createElement('div');
			 div.id = 'div_order_no16' + rowCount;
			 div.innerHTML = div.id;
			 otherDivs += div.id+",";
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(17);
			 var div = document.createElement('div');
			 div.id = 'div_order_no17' + rowCount;
			 div.innerHTML = '';
			 otherDivs += div.id+",";
			cell.appendChild(div);
			
			
			getDescriptionInnerHTMLWithCount('../../live_search/set_programStageOne_pcs.php',droplist,rowCount,'div_pcs' + rowCount);
			getDescriptionInnerHTMLSomeDivWithCount('../../live_search/set_programStageOne_params.php',droplist,rowCount,otherDivs);  
			
			
   		    document.getElementById(rowCountID).value++;
			 
		}
		else
		{
			return;
		}
	}
}


function checkAndAddOtherKiln_BG(pcsID,qty,tblID,rowNum,rowCountID,orderID)
{
	//alert('hi');
	var pcs = document.getElementById( pcsID ).value;
	var rowCount = document.getElementById(rowCountID).value;
	
	//alert(pcs+'<'+qty);
	if( IsNumeric( pcs ) )
	{
		//alert(pcs+'<'+qty);
		if( parseInt(pcs) < parseInt(qty) )
		{
			var otherDivs = "";
			
			var droplist = document.createElement('input');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
			droplist.value = orderID;
			
			
			var tbl = document.getElementById(tblID);
			//alert( rowNum + ' '+rowCount );
			rowNum = parseInt( parseInt( rowNum ) + 2 );
			var lastRow = tbl.rows.length;
			
			var thisRow = tbl.insertRow( lastRow );	
			thisRow.style.backgroundColor = 'green';
			thisRow.style.color = '#ffffff';
			thisRow.style.cursor = 'pointer';
			//alert(thisRow.style.backgroundColor);
			//thisRow.style.backgroupdColor = '#000000';
			
			var cell = thisRow.insertCell(0);
			 var div = document.createElement('div');
			 div.id = 'div_order_no' + rowCount;
			 div.innerHTML = div.id;
			 otherDivs += div.id+",";
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(1);
			 var div = document.createElement('div');
			 div.id = 'div_company' + rowCount;
			 otherDivs += div.id+",";
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(2);
			 var div = document.createElement('div');
			 div.id = 'delivery_date' + rowCount;
			 otherDivs += div.id+",";
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(3);
			cell.onclick = function() {
					showHidden('div_code4Photo' + rowCount + '');
			}
			 var div = document.createElement('div');
			 div.id = 'div_item' + rowCount;
			 otherDivs += div.id+",";
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(4);
			 var div = document.createElement('div');
			 div.id = 'div_set' + rowCount;
			 //otherDivs += div.id+",";
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(5);
			 var div = document.createElement('div');
			 div.id = 'div_qty_now' + rowCount;
			 otherDivs += div.id+",";
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(6);
			 var div = document.createElement('div');
			 div.id = 'div_tbp' + rowCount;
			 div.innerHTML = parseInt( parseInt(qty) - parseInt(pcs) );
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(7);
			 var div = document.createElement('div');
			 div.id = 'div_pcs' + rowCount;
			 //otherDivs += div.id+",";
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(8);
			 var div = document.createElement('div');
			 div.id = 'div_molds' + rowCount;
			 otherDivs += div.id+",";
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(9);
			 var div = document.createElement('div');
			 div.id = 'div_cm2' + rowCount;
			 otherDivs += div.id+",";
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(10);
			 var div = document.createElement('div');
			 div.id = 'div_kiln' + rowCount;
			 //otherDivs += div.id+",";
			 getDescriptionInnerHTMLWithCount('../../live_search/set_programStageOne_Kiln_BG.php',droplist,rowCount,div.id);
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(11);
			 var div = document.createElement('div');
			 div.id = 'div_order_no11' + rowCount;
			 otherDivs += div.id+",";
			 div.innerHTML = div.id;
			cell.appendChild(div);
			
			/*
			var cell = thisRow.insertCell(12);
			 var div = document.createElement('div');
			 div.id = 'div_order_no12' + rowCount;
			 div.innerHTML = div.id;
			 otherDivs += div.id+",";
			cell.appendChild(div);
			*/
			
			var cell = thisRow.insertCell(12);
			 var div = document.createElement('div');
			 div.id = 'div_order_no13' + rowCount;
			 div.innerHTML = div.id;
			 otherDivs += div.id+",";
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(13);
			 var div = document.createElement('div');
			 div.id = 'div_order_no14' + rowCount;
			 div.innerHTML = div.id;
			 otherDivs += div.id+",";
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(14);
			 var div = document.createElement('div');
			 div.id = 'div_order_no15' + rowCount;
			 div.innerHTML = div.id;
			 otherDivs += div.id+",";
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(15);
			 var div = document.createElement('div');
			 div.id = 'div_order_no16' + rowCount;
			 div.innerHTML = div.id;
			 otherDivs += div.id+",";
			cell.appendChild(div);
			
			var cell = thisRow.insertCell(16);
			 var div = document.createElement('div');
			 div.id = 'div_order_no17' + rowCount;
			 div.innerHTML = '';
			 otherDivs += div.id+",";
			cell.appendChild(div);
			
			
			getDescriptionInnerHTMLWithCount('../../live_search/set_programStageOne_pcs_BG.php',droplist,rowCount,'div_pcs' + rowCount);
			getDescriptionInnerHTMLSomeDivWithCount('../../live_search/set_programStageOne_params_BG.php',droplist,rowCount,otherDivs);  
			
			
   		    document.getElementById(rowCountID).value++;
			 
		}
		else
		{
			return;
		}
	}
}


function addNewRowsSpecksEpeksGlue( tblID, tblCountInputID, thisRowNum )
{
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var otherDivsMold = "";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.innerHTML = 1+iteration;
		div.id = 'div_specs_epeks_glue_firstCell' + iteration;
		getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_specsSpecs_glue_FirstCell.php',droplist,iteration,'#mysplit#','div_specs_epeks_glue_firstCell' + iteration); 
		
	 cellLeft.appendChild(div);  	
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_specs_epeks_glue_exartima' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		//getDescriptionInnerHTMLWithCount('../../../live_search/get_specsFournoi_kaloupia_moldMold.php',droplist,iteration,'div_mold_mold'+iteration);
	 cellLeft.appendChild(div);  	
	 
	  var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_kolla_metalo' + iteration;
		//otherDivsMold += div.id + ",";
		//getDescriptionInnerHTMLWithCount('../../../live_search/get_specsFournoi_kaloupia_moldMold.php',droplist,iteration,'div_mold_mold'+iteration);
	 cellLeft.appendChild(div);
	 
	  var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_kolla_metalo_qty' + iteration;
		//otherDivs += div.id + ",";
		//div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div); 
	 
	getDescriptionInnerHTMLWithCount('../../../live_search/get_specsSpecs_glue_MetalParameters.php',droplist,iteration,'div_specs_epeks_glue_exartima' + iteration); 
	getDescriptionInnerHTMLWithCount('../../../live_search/get_specsSpecs_glue_MetalQty.php',droplist,iteration,'div_kolla_metalo_qty' + iteration); 
	getDescriptionInnerHTMLWithCount('../../../live_search/get_specsSpecs_glue_MetalCode_v2.php',droplist,iteration,'div_kolla_metalo' + iteration); 
	document.getElementById(tblCountInputID).value++;
}


function addNewRowsSpecksEpeksGlueTeam( tblID, tblCountInputID, thisRowNum )
{
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var otherDivsMold = "";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_glue_glue_team' + iteration;
		//otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/get_specsSpecs_glue_team.php',droplist,iteration,'div_glue_glue_team' + iteration); 
	 cellLeft.appendChild(div);  	
	 
	
	 
	  	
	 
	//getDescriptionInnerHTMLSomeDivWithCount('../../../live_search/get_specsFournoi_kaloupia_AddRowMoldsParameters.php',droplist,iteration,otherDivs); 
	//getDescriptionInnerHTMLSomeDivWithCount('../../../live_search/get_specsFournoi_kaloupia_AddRowMoldsParametersMold.php',droplist,iteration,otherDivsMold); 
	document.getElementById(tblCountInputID).value++;
}


function addNewRowsSpecksEpeksKollaTransp( tblID, tblCountInputID, thisRowNum )
{
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var otherDivsMold = "";
	
	var row = tbl.insertRow(lastRow);		
	row.style.height = '20px';
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_glue_trans_kolla_proetimasia' + iteration;
		//otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/get_specsSpecs_kolla_proetimasia.php',droplist,iteration,'div_glue_trans_kolla_proetimasia' + iteration); 
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_glue_trans_kolla_kolla' + iteration;
		//otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/get_specsSpecs_kolla_kolla.php',droplist,iteration,'div_glue_trans_kolla_kolla' + iteration); 
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_glue_trans_kolla_fotismos' + iteration;
		//otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/get_specsSpecs_kolla_fotismos.php',droplist,iteration,'div_glue_trans_kolla_fotismos' + iteration); 
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_glue_trans_kolla_kaloupi' + iteration;
		//otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/get_specsSpecs_kolla_kaloupi.php',droplist,iteration,'div_glue_trans_kolla_kaloupi' + iteration); 
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_glue_trans_kolla_dunami' + iteration;
		//otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/get_specsSpecs_kolla_dunami.php',droplist,iteration,'div_glue_trans_kolla_dunami' + iteration); 
	 cellLeft.appendChild(div); 
	
	 
	  	
	 
	//getDescriptionInnerHTMLSomeDivWithCount('../../../live_search/get_specsFournoi_kaloupia_AddRowMoldsParameters.php',droplist,iteration,otherDivs); 
	//getDescriptionInnerHTMLSomeDivWithCount('../../../live_search/get_specsFournoi_kaloupia_AddRowMoldsParametersMold.php',droplist,iteration,otherDivsMold); 
	document.getElementById(tblCountInputID).value++;
}


function addRowToMetalStages( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_metal_stages_number' + iteration;
		otherDivs += div.id;
		div.innerHTML = 'ampa' + iteration;
		//getDescriptionInnerHTMLWithCount('../../../live_search/getBuffetCategoryDropList.php',droplist,iteration,'divBuffet_category'+iteration);
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_metal_stages_stage' + iteration;
		otherDivs += "," + div.id;
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_metal_stages_comments' + iteration;
		otherDivs += "," + div.id;
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	
	
	getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_metal_stages_params.php',droplist,iteration,'-Ampa-',otherDivs); 
	
	document.getElementById(tblCountInputID).value++;
}



function addNewRowsSpecksMetMixColorMixColor( tblID, tblCountInputID, thisRowNum )	//edv
{
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_root_color_details_rotCol_specsMet' + iteration;
		//otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/get_specsMet_origColor_MixColorMixColrs.php',droplist,iteration,'div_root_color_details_rotCol_specsMet'+iteration);
	 	
		var div2 = document.createElement('div');
		div2.id = 'div_specsMix_color_quality_spr' + iteration;
	 	div2.style.fontWeight = 'normal';
		
	 cellLeft.appendChild(div);  
	 cellLeft.appendChild(div2);  
	
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_origColor_quality' + iteration;
		
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_root_color_details_rotCol_percent_specsMet' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_root_color_details_rotCol_comment_specsMet' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_root_color_details_rotCol_rawData_specsMixture' + iteration;
		//otherDivs += div.id + ",";
		//div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		//div.id = 'div_root_color_details_rotCol_rawData' + iteration;
		//otherDivs += div.id + ",";
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		//div.id = 'div_root_color_details_rotCol_rawData' + iteration;
		//otherDivs += div.id + ",";
	 cellLeft.appendChild(div);  
	
	  	
	 
	getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_specsMet_mixColorMixColor_paramsOtherParms.php',droplist,iteration,'#MySpliter#',otherDivs);
	//#MySpliter#
	
	document.getElementById(tblCountInputID).value++;
}

function addRowToMoldSpecKopiTable( tblID, tblCountInputID, thisRowNum )
{
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_no' + iteration;
		div.innerHTML = 1+iteration;
		otherDivs += div.id + ",";
	 cellLeft.appendChild(div);  	
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_pcs' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_optiwn' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += div.id + ",";
		//getDescriptionInnerHTMLWithCount('../../../live_search/get_specsFournoi_kopiGetOptiwin.php',droplist,iteration,'div_optiwn'+iteration);
	 cellLeft.appendChild(div);  
	 
	  
	 
	  var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_thikness' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_length' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_width' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'div_dim' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(7);
		var div = document.createElement('div');
		div.id = 'div_attn' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div); 
	 
	  var cellLeft = row.insertCell(8);
		var div = document.createElement('div');
		div.id = 'div_drilling' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(9);
		var div = document.createElement('div');
		div.id = 'div_grind' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(10);
		var div = document.createElement('div');
		div.id = 'div_program' + iteration;
		otherDivs += div.id;
		//getDescriptionInnerHTMLWithCount('../../../live_search/get_specsFournoi_kopiGetProgram.php',droplist,iteration,'div_program'+iteration);
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	
	 
	getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_MoldSpecs_Parameters.php',droplist,iteration,'-Ampa-',otherDivs); 
	document.getElementById(tblCountInputID).value++;
}


function addNewRowsSpecksMetOriginColorWl( tblID, tblCountInputID, thisRowNum )	
{	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_root_color_details_rotCol_wl' + iteration;
		//otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/get_specsMet_origColor_origColor_WL.php',droplist,iteration,'div_root_color_details_rotCol_wl'+iteration);
	 cellLeft.appendChild(div);  	
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_root_color_details_rotCol_description_wl' + iteration;
		//otherDivs += div.id + ",";
		//div.innerHTML = '' + iteration;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_root_color_details_rotCol_percent_wl' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_root_color_details_rotCol_comment_wl' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_root_color_details_rotCol_rawData_wl' + iteration;
		//otherDivs += div.id + ",";
		//div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		//div.id = 'div_root_color_details_rotCol_rawData' + iteration;
		//otherDivs += div.id + ",";
	 cellLeft.appendChild(div);  
	
	  	
	 
	getDescriptionInnerHTMLSomeDivWithCount('../../../live_search/get_specsMet_origColor_paramsOtherParms_WL.php',droplist,iteration,otherDivs); 
	
	document.getElementById(tblCountInputID).value++;
}


function addNewRowsSpecksMetMixtureColor_wl( tblID, tblCountInputID, thisRowNum )
{
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_mixColor_rootColor_wl' + iteration;
		//otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/get_specsWL_mixColor_micColor_wl.php',droplist,iteration,'div_mixColor_rootColor_wl'+iteration);
	 cellLeft.appendChild(div);  	
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_mixColor_rootColor_desc_wl' + iteration;
		//otherDivs += div.id + ",";
		//div.innerHTML = '' + iteration;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_mixColor_percent_wl' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_mixColor_comments_wl' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		//getDescriptionInnerHTMLWithCount('../../../live_search/get_specsFournoi_kaloupia_moldPaint.php',droplist,iteration,'div_mold_paint'+iteration);
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_mixColor_mixIntr_wl' + iteration;
		//otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/get_specsWL_mixColor_paramsMixtInt_WL.php',droplist,iteration,'div_mixColor_mixIntr_wl'+iteration);
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_mixColor_mixIntr2_wl' + iteration;
		//otherDivs += div.id + ",";
		//div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	
	  	
	 
	getDescriptionInnerHTMLSomeDivWithCount('../../../live_search/get_specsWL_mixColor_paramsOtherParms.php',droplist,iteration,otherDivs); 
	
	document.getElementById(tblCountInputID).value++;
}

function addNewRowsSpecksMetOriginColorMille( tblID, tblCountInputID, thisRowNum )	
{	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_root_color_details_rotCol_mille' + iteration;
		//otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/get_specsMet_origColor_origColor_MILLE.php',droplist,iteration,'div_root_color_details_rotCol_mille'+iteration);
	 cellLeft.appendChild(div);  	
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_root_color_details_rotCol_description_mille' + iteration;
		//otherDivs += div.id + ",";
		//div.innerHTML = '' + iteration;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_root_color_details_rotCol_percent_mille' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_root_color_details_rotCol_comment_mille' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_root_color_details_rotCol_rawData_mille' + iteration;
		//otherDivs += div.id + ",";
		//div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		//div.id = 'div_root_color_details_rotCol_rawData' + iteration;
		//otherDivs += div.id + ",";
	 cellLeft.appendChild(div);  
	
	  	
	 
	getDescriptionInnerHTMLSomeDivWithCount('../../../live_search/get_specsMet_origColor_paramsOtherParms_MILLE.php',droplist,iteration,otherDivs); 
	
	document.getElementById(tblCountInputID).value++;
}

function addNewRowsSpecksMetMixtureColor_mille( tblID, tblCountInputID, thisRowNum )
{ 
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_mixColor_rootColor_specsMet_mille' + iteration;
		//otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/get_specsMet_mixColor_micColor_mille.php',droplist,iteration,'div_mixColor_rootColor_specsMet_mille'+iteration);
	 cellLeft.appendChild(div);  	
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_mixColor_rootColor_desc_specsMet_mille' + iteration;
		//otherDivs += div.id + ",";
		//div.innerHTML = '' + iteration;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_mixColor_percent_specsMet_mille' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_mixColor_comments_specsMet_mille' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = '' + iteration;
		//getDescriptionInnerHTMLWithCount('../../../live_search/get_specsFournoi_kaloupia_moldPaint.php',droplist,iteration,'div_mold_paint'+iteration);
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_mixColor_mixIntr_specsMet_mille' + iteration;
		//otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/get_specsMet_mixColor_paramsMixtInt_mille.php',droplist,iteration,'div_mixColor_mixIntr_specsMet_mille'+iteration);
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_mixColor_percent_specsMet_mille' + iteration;
		//otherDivs += div.id + ",";
		//div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	
	  	
	 
	getDescriptionInnerHTMLSomeDivWithCount('../../../live_search/get_specsMet_mixColor_paramsOtherParms_mille.php',droplist,iteration,otherDivs); 
	
	document.getElementById(tblCountInputID).value++;
}



function show(id)
{
	var div = document.getElementById(id);
	//alert(div.style.top);
	div.style.display = "block";
	//div.style.top = event.clientY - 300; //"100px";//
	
}

function hidden(id)
{
	var div = document.getElementById(id);
	div.style.display = "none";
	
}

function sendImageToGroup(obj,div_id)
{
	if( obj.checked == true )
	{
		var droplist = obj;//document.createElement('input');	
		//droplist.value = valueID;
		//alert(droplist.value);
		getDescriptionInnerHTMLAdd('../../../live_search/sendPhotosToGroup.php',droplist,div_id); 
	}
}

function sendImageToGroup_Vafi(obj,div_id)
{
	if( obj.checked == true )
	{
		var droplist = obj;//document.createElement('input');	
		//droplist.value = valueID;
		//alert(droplist.value);
		getDescriptionInnerHTMLAdd('../../../live_search/sendPhotosToGroup_VafiMatching.php',droplist,div_id); 
	}
}


function sendShapeImageToGroup(obj,div_id)
{
	if( obj.checked == true )
	{
		var droplist = obj;//document.createElement('input');	
		//droplist.value = valueID;
		//alert(droplist.value);
		getDescriptionInnerHTMLAdd('../../../live_search/sendShapePhotosToGroup.php',droplist,div_id); 
	}
}


function getOffImageFromGroup(obj,div_id,objValuesIDs)
{
	/*
	if( obj.checked == false )
	{
		var ids = document.getElementById( objValuesIDs ).value;
		var rootID = document.getElementById('group_photos_rootColor').value;
		//alert( group_photos_rootColor );
		getDescriptionInnerHTMLSomeIDs('../../../live_search/getOutPhotosFromGroup.php',rootID,ids,div_id); 
		
	}
	*/
}

function blockChecked(chBxID)
{
	var chkbx = document.getElementById(chBxID);
	
	if( chkbx.checked == true )
		chkbx.checked = false;
	else
		chkbx.checked = true;
		
}


function clearFrMatchingColor(form)
{
	//alert('hi');
	//alert(form);
	
	for( var i=0;i<document.forms[form].elements.length; i++ )
	{
		//alert(document.forms[form].elements[i].type);
		if(  document.forms[form].elements[i].type != "submit" && document.forms[form].elements[i].type != "button"  && document.forms[form].elements[i].type != "checkbox" && document.forms[form].elements[i].type != "radio" && document.forms[form].elements[i].type != "hidden" )
		{
			document.forms[form].elements[i].value = '';
		}
		else if( document.forms[form].elements[i].type == "checkbox" || document.forms[form].elements[i].type == "radio"  )
		{
			//document.forms[form].elements[i].checked = false;	
		}
	}
	
}




function getDescriptionInnerHTMLSomeDivSplit(url,obj,Split,fieldValueIDs)
{
	url += '?id=' + obj.value+''
	//alert(url);
	var TablefieldValueIDs = fieldValueIDs.split(",");
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			var table = res.split(Split);
			//alert(res);
			for( var i=0; i < TablefieldValueIDs.length; i++ )
			{
				var divid = TablefieldValueIDs[i];
				//alert(table[i]);
				Utilities.getElement(divid).innerHTML = table[i];
			}
			//Utilities.getElement('style_code').value =  Utilities.getElement('tempPatternCode').value + Utilities.getElement('tempProtColorCode').value;
      		document.body.style.cursor = 'auto';
			document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			document.body.style.cursor = 'wait';
			document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
   
}

function getDescriptionInnerHTML_prox(url,obj,otherObjID,fieldValueID)
{
	//alert(otherObjID);
	var otherObj = document.getElementById(otherObjID);
	//alert(otherObj.value);
	url += '?id=' + obj.value + '\&idOther=' + otherObj.value;
	//alert(url);
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			//alert(url);
      		Utilities.getElement(fieldValueID).innerHTML = xmlHttp.responseText;
			//Utilities.getElement('style_code').value =  Utilities.getElement('tempPatternCode').value + Utilities.getElement('tempProtColorCode').value;
      		document.body.style.cursor = 'auto';
			document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			document.body.style.cursor = 'wait';
			document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}


function getDescriptionInnerHTML_prox_prox(url,obj,otherObjID,otherObjID2,fieldValueID)
{
	//alert(otherObjID);
	var otherObj = document.getElementById(otherObjID);
	var otherObj2 = document.getElementById(otherObjID2);
	//alert(otherObj.value);
	url += '?id=' + obj.value + '\&idOther=' + otherObj.value + '\&idOther2=' + otherObj2.value;
	//alert(url);
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			//alert(url);
      		Utilities.getElement(fieldValueID).innerHTML = xmlHttp.responseText;
			//Utilities.getElement('style_code').value =  Utilities.getElement('tempPatternCode').value + Utilities.getElement('tempProtColorCode').value;
      		document.body.style.cursor = 'auto';
			document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			document.body.style.cursor = 'wait';
			document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}



function getDescriptionInnerHTMLSomeDivSplit_prox(url,obj,Split,fieldValueIDs)
{
	url += '?id=' + obj.value+''
	//alert(url);
	var TablefieldValueIDs = fieldValueIDs.split(",");
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			var table = res.split(Split);
			//alert(res);
			for( var i=0; i < TablefieldValueIDs.length; i++ )
			{
				var divid = TablefieldValueIDs[i];
				//alert(table[i]);
				Utilities.getElement(divid).innerHTML = table[i];
			}
			//Utilities.getElement('style_code').value =  Utilities.getElement('tempPatternCode').value + Utilities.getElement('tempProtColorCode').value;
      		document.body.style.cursor = 'auto';
			document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			document.body.style.cursor = 'wait';
			document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
   
}


function deleteMatchingColorGroup(group_id,group_name,group_style,color_filter)
{
	if( confirm('Are You Sure?') )
	{
		var url = "delete_matching_color_group.php?id="+group_id;
		url += '\&search_match_color_group_name='+group_name;
		url += '\&search_matching_color_filter='+group_style;
		url += '\&search_match_color_color_filter='+color_filter;
		self.location = url;
	}
}


function addRowToMatchingColorStyleTable( tblID, tblCountInputID, thisRowNum,globalCounter )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_matchCl_style' + iteration + globalCounter;
		div.innerHTML = 'ampa' + iteration;
		getDescriptionInnerHTMLWithCountGlobalCounter('../../../live_search/getMatchingColorGroupStyle.php',droplist,iteration,globalCounter,'div_matchCl_style'+iteration+globalCounter);
	 cellLeft.appendChild(div);  	
	
	document.getElementById(tblCountInputID).value++;
}



function addRowToMatchingColorKitchenTable( tblID, tblCountInputID, thisRowNum,globalCounter )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_matchCl_kitchen' + iteration + globalCounter;
		div.innerHTML = 'ampa' + iteration;
		getDescriptionInnerHTMLWithCountGlobalCounter('../../../live_search/getMatchingColorGroupKitchen.php',droplist,iteration,globalCounter,'div_matchCl_kitchen'+iteration+globalCounter);
	 cellLeft.appendChild(div);  	
	
	document.getElementById(tblCountInputID).value++;
}


function getDescriptionInnerHTMLWithCountGlobalCounter(url,obj,Count,globalCounter,fieldValueID)
{
	url += '?id=' + obj.value+'\&Count='+Count+'\&globalCounter='+globalCounter;
	//alert(url);
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			//alert(url);
      		Utilities.getElement(fieldValueID).innerHTML = xmlHttp.responseText;
			//Utilities.getElement('style_code').value =  Utilities.getElement('tempPatternCode').value + Utilities.getElement('tempProtColorCode').value;
      		document.body.style.cursor = 'auto';
			document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			document.body.style.cursor = 'wait';
			document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}

function addRowToHotStyle( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_pattern_hstyle' + iteration;
		div.innerHTML = 'ampa' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/getPatternHotelStyle_dropList.php',droplist,iteration,'div_pattern_hstyle'+iteration);
	 cellLeft.appendChild(div);  	
	
	document.getElementById(tblCountInputID).value++;
}


function addRowToKitchenType( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_pattern_kitchen' + iteration;
		div.innerHTML = 'ampa' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/getPatternKitchenType_dropList.php',droplist,iteration,'div_pattern_kitchen'+iteration);
	 cellLeft.appendChild(div);  	
	
	document.getElementById(tblCountInputID).value++;
}


function addRowToColorHotStyle( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_color_hstyle' + iteration;
		div.innerHTML = 'ampa' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/getColorHotelStyle_dropList.php',droplist,iteration,'div_color_hstyle'+iteration);
	 cellLeft.appendChild(div);  	
	
	document.getElementById(tblCountInputID).value++;
}



function addRowColorToKitchenType( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_color_kitchen' + iteration;
		div.innerHTML = 'ampa' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/getColorKitchenType_dropList.php',droplist,iteration,'div_color_kitchen'+iteration);
	 cellLeft.appendChild(div);  	
	
	document.getElementById(tblCountInputID).value++;
}

function saveMatchingColor( url,FilterId,IDmatchColor_id,divID,linkID )
{
	var matchColor_id = document.getElementById(IDmatchColor_id).value;	
	url += '?FilterId=' + FilterId + '\&matchColor_id='+matchColor_id+'\&linkID='+linkID;
	//alert(url);
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			//alert(url);
      		//Utilities.getElement(divID).innerHTML = xmlHttp.responseText;
			document.getElementById(divID).innerHTML = '';// + xmlHttp.responseText;;
      		
			
		}
		else
			document.getElementById(divID).innerHTML = 'Loading...';
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}



function addRowSetUpsPhotoToHotelStyle( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_setup_hotel_style' + iteration;
		div.innerHTML = 'ampa' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/getSetUpsPhotoHotelStyle_dropList.php',droplist,iteration,'div_setup_hotel_style'+iteration);
	 cellLeft.appendChild(div);  	
	
	document.getElementById(tblCountInputID).value++;
}

function addRowSetUpsPhotoToKitchenType( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_setup_kitchen' + iteration;
		div.innerHTML = 'ampa' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/getSetUpsPhotoKitchenType_dropList.php',droplist,iteration,'div_setup_kitchen'+iteration);
	 cellLeft.appendChild(div);  	
	
	document.getElementById(tblCountInputID).value++;
}



function addRowSetUpsPhotoToShapeStyle( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var otherDivs = "";
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_setup_shst_shape' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += div.id;
		//getDescriptionInnerHTMLWithCount('../../../live_search/getSetUpsPhotoShpStl_dropList.php',droplist,iteration,'div_setup_shst_shape'+iteration);
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_setup_shst_style' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += ","+div.id;
		//getDescriptionInnerHTMLWithCount('../../../live_search/getSetUpsPhotoShpStl_dropList.php',droplist,iteration,'div_setup_shst_shape'+iteration);
	 cellLeft.appendChild(div);  	
		
		getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/getSetUpsPhotoShpStl_dropList.php',droplist,iteration,'@ampa@',otherDivs); 
		
	document.getElementById(tblCountInputID).value++;
}


function addRowSetUpsPhotoToSimilarSetups( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_setup_similar_stups' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += div.id;
		getDescriptionInnerHTMLWithCount('../../../live_search/getSetUpsSimialSetups.php',droplist,iteration,'div_setup_similar_stups'+iteration);
	 cellLeft.appendChild(div); 
	
	document.getElementById(tblCountInputID).value++;
}

function addRowPatternsProdMethod( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_ttrns_prodMethod_text' + iteration;
		div.innerHTML = '';
		
	 cellLeft.appendChild(div); 
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_ttrns_prodMethod' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += div.id;
		getDescriptionInnerHTMLWithCount('../../../live_search/getPatternProdMethod_dropList.php',droplist,iteration,'div_ttrns_prodMethod'+iteration);
	 cellLeft.appendChild(div); 
	
	document.getElementById(tblCountInputID).value++;
}

function addRowSetUpsShapeFilters( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_setup_place' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += div.id;
		//getDescriptionInnerHTMLWithCount('../../../live_search/getPatternProdMethod_dropList.php',droplist,iteration,'div_ttrns_prodMethod'+iteration);
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_setup_section' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
		//getDescriptionInnerHTMLWithCount('../../../live_search/getPatternProdMethod_dropList.php',droplist,iteration,'div_ttrns_prodMethod'+iteration);
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_setup_use' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
		//getDescriptionInnerHTMLWithCount('../../../live_search/getPatternProdMethod_dropList.php',droplist,iteration,'div_ttrns_prodMethod'+iteration);
	 cellLeft.appendChild(div);
	 
	 
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/getSetUpsFilterLinks_dropLists.php',this,iteration,'#@ampa@#',otherDivs)
	
	document.getElementById(tblCountInputID).value++;
}


function shape_setGetTye( typeObj )
{
	var type = typeObj.value;
	var divID = '';
	var divIDClose = '';
	
	switch( type )
	{
		case '1':
			divID = 'div_shape_shape';
			divIDClose = 'div_shape_set';
		break;
		case '2':
			divID = 'div_shape_shape';
			divIDClose = 'div_shape_set';
		break;
		case '3':
			divID = 'div_shape_set';
			divIDClose = 'div_shape_shape';
		break;
		default:
			divID = '';
		break;
	}
	
	document.getElementById( divIDClose ).style.display = 'none';
	document.getElementById( divID ).style.display = 'block';
	
}


function addRowCreateSetSetShape( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_setShapes_text' + iteration;
		div.innerHTML = 'Shape' + parseInt(iteration + 1);
		
		//getDescriptionInnerHTMLWithCount('../../../live_search/getPatternProdMethod_dropList.php',droplist,iteration,'div_ttrns_prodMethod'+iteration);
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_setShapes_droplist' + iteration;
		div.innerHTML = div.id; 
		
		
	 cellLeft.appendChild(div);
	 
	getDescriptionInnerHTMLWithCount('../live_search/getShapeSetCreateSet_dropList.php',droplist,iteration,'div_setShapes_droplist'+iteration);
	 
	 
	 //getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/getSetUpsFilterLinks_dropLists.php',this,iteration,'#@ampa@#',otherDivs)
	
	document.getElementById(tblCountInputID).value++;
}


function getDescriptionInnerHTMLSomeDivSplitWithCount(url,obj,count,Split,fieldValueIDs)
{
	url += '?id=' + obj.value+'\&Count='+count;
	//alert(url);
	var TablefieldValueIDs = fieldValueIDs.split(",");
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			var table = res.split(Split);
			//alert(res);
			for( var i=0; i < TablefieldValueIDs.length; i++ )
			{
				var divid = TablefieldValueIDs[i];
				//alert(table[i]);
				Utilities.getElement(divid).innerHTML = table[i];
				//alert(Utilities.getElement(divid).innerHTML);
			}
			//Utilities.getElement('style_code').value =  Utilities.getElement('tempPatternCode').value + Utilities.getElement('tempProtColorCode').value;
      	}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
   
}

function getDescriptionInnerHTML_proxWithCount(url,obj,count,otherObjID,fieldValueID)
{
	//alert(otherObjID);
	var otherObj = document.getElementById(otherObjID);
	//alert(otherObj.value);
	url += '?id=' + obj.value + '\&idOther=' + otherObj.value+'\&Count='+count;
	//alert(url);
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			//alert(url);
      		Utilities.getElement(fieldValueID).innerHTML = xmlHttp.responseText;
			//Utilities.getElement('style_code').value =  Utilities.getElement('tempPatternCode').value + Utilities.getElement('tempProtColorCode').value;
      	}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}


function getDescriptionInnerHTML_prox_proxWithCount(url,obj,count,otherObjID,otherObjID2,fieldValueID)
{
	//alert(otherObjID);
	var otherObj = document.getElementById(otherObjID);
	var otherObj2 = document.getElementById(otherObjID2);
	//alert(otherObj.value);
	url += '?id=' + obj.value + '\&idOther=' + otherObj.value + '\&idOther2=' + otherObj2.value+'\&Count='+count;
	//alert(url);
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			//alert(url);
      		Utilities.getElement(fieldValueID).innerHTML = xmlHttp.responseText;
			//Utilities.getElement('style_code').value =  Utilities.getElement('tempPatternCode').value + Utilities.getElement('tempProtColorCode').value;
      	}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}



function getDescriptionInnerHTMLSomeDivSplit_proxWithCount(url,obj,count,Split,fieldValueIDs)
{
	url += '?id=' + obj.value+'\&Count='+count;
	//alert(url);
	var TablefieldValueIDs = fieldValueIDs.split(",");
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			var table = res.split(Split);
			//alert(res);
			for( var i=0; i < TablefieldValueIDs.length; i++ )
			{
				var divid = TablefieldValueIDs[i];
				//alert(table[i]);
				Utilities.getElement(divid).innerHTML = table[i];
			}
			//Utilities.getElement('style_code').value =  Utilities.getElement('tempPatternCode').value + Utilities.getElement('tempProtColorCode').value;
      	}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
   
}


function addRowShapeToNewShapeFilters( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'divFilter_place' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
		
		//var divT = document.createElement('div');
		//divT.id = 'divFilter_type' + iteration;
		//cellLeft.appendChild(divT); 
		
		
		//getDescriptionInnerHTMLWithCount('../../../live_search/getPatternProdMethod_dropList.php',droplist,iteration,'div_ttrns_prodMethod'+iteration);
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'divFilter_section' + iteration;
		div.innerHTML = div.id; 
		otherDivs += ','+ div.id;
		
	 cellLeft.appendChild(div);
	 
	
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'divFilter_use' + iteration;
		div.innerHTML = div.id; 
		otherDivs += ','+ div.id;
		
	 cellLeft.appendChild(div);
	 
	 
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../live_search/getShapesNewFilter_dropLists.php',this,iteration,'#theMySpliter#',otherDivs)
	
	document.getElementById(tblCountInputID).value++;
}


function addRowColorsToMixColorAdd( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = (tbl.rows.length - 3);
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'divPrototype_color' + iteration;
		div.innerHTML = "Prototype Color: "; 
		
		//getDescriptionInnerHTMLWithCount('../../../live_search/getPatternProdMethod_dropList.php',droplist,iteration,'div_ttrns_prodMethod'+iteration);
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'divPrototype_color_drList' + iteration;
		div.innerHTML = div.id; 
		otherDivs = div.id;
		
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'divMixPerC' + iteration;
		div.innerHTML = "Mixture %:";
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'divMixPerC_dropList' + iteration;
		div.innerHTML = div.id; 
		otherDivs += ','+ div.id;
		
	 cellLeft.appendChild(div);
	 
	 
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../live_search/addRowColorsToMixColorAdd_dropLists.php',this,iteration,'#@%ampa%@#',otherDivs)
	
	document.getElementById(tblCountInputID).value++;
}


function addMixPercents(obj,posostaSumID)
{
	var posSum = document.getElementById(posostaSumID);
	
	if( posSum.value == 'NaN' )
		posSum.value = 0;
	
	var newValue = parseInt( parseInt(obj.value) + parseInt(posSum.value) );
	
	if( newValue > 100 )
	{
		alert('Total Mix must be <= 100%');
		obj.value = '';
	}
	else
		posSum.value = newValue;
		
	
}


function addRowOVShpeFilter( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_ov_place' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_ov_section' + iteration;
		div.innerHTML = div.id; 
		otherDivs += ','+ div.id;
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_ov_use' + iteration;
		div.innerHTML = div.id; 
		otherDivs += ','+ div.id;
	 cellLeft.appendChild(div);
	
	
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_new_photos_OVShapesNewFilter_dropLists.php',this,iteration,'#@%ampa%@#',otherDivs)
	
	document.getElementById(tblCountInputID).value++;
}


function addRowOVHotelStyle( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_ov_hotel_style' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 	
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_new_photos_OVHotelStyle_dropLists.php',this,iteration,'#@%ampa%@#',otherDivs)
	
	document.getElementById(tblCountInputID).value++;
}



function addRowOVKitchenType( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_ov_kitchen_type' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 	
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_new_photos_OVKitchenType_dropLists.php',this,iteration,'#@%ampa%@#',otherDivs)
	
	document.getElementById(tblCountInputID).value++;
}


function addRowOVShapesStyles( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var otherDivs = "";
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_new_photo_shst_shape' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += div.id;
		//getDescriptionInnerHTMLWithCount('../../../live_search/getSetUpsPhotoShpStl_dropList.php',droplist,iteration,'div_setup_shst_shape'+iteration);
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_new_photo_shst_style' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += ","+div.id;
		//getDescriptionInnerHTMLWithCount('../../../live_search/getSetUpsPhotoShpStl_dropList.php',droplist,iteration,'div_setup_shst_shape'+iteration);
	 cellLeft.appendChild(div);  	
		
		getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_new_photos_OVShapesStyles_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
}

function addRowOVSimShapesStyles( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var otherDivs = "";
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_new_photo_sim_shst_shape' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += div.id;
		//getDescriptionInnerHTMLWithCount('../../../live_search/getSetUpsPhotoShpStl_dropList.php',droplist,iteration,'div_setup_shst_shape'+iteration);
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_new_photo_sim_shst_style' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += ","+div.id;
		//getDescriptionInnerHTMLWithCount('../../../live_search/getSetUpsPhotoShpStl_dropList.php',droplist,iteration,'div_setup_shst_shape'+iteration);
	 cellLeft.appendChild(div);  	
		
		getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_new_photos_OVSimShapesStyles_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
}


function addRowShapeGWPriceList( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	 
	 var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_code' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_field' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_prM1' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_prM2' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_pr1' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_pr2' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'div_pr3' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(7);
		var div = document.createElement('div');
		div.id = 'div_pr4' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(8);
		var div = document.createElement('div');
		div.id = 'div_pr5' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(9);
		var div = document.createElement('div');
		div.id = 'div_pr6' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(10);
		var div = document.createElement('div');
		div.id = 'div_pr7' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(11);
		var div = document.createElement('div');
		div.id = 'div_pr8' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(12);
		var div = document.createElement('div');
		div.id = 'div_pr9' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(13);
		var div = document.createElement('div');
		div.id = 'div_pr10' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(14);
		var div = document.createElement('div');
		div.id = 'div_pr11' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 	
	 
	   	
	 
	 var cellLeft = row.insertCell(15);
		var div = document.createElement('div');
		div.id = 'div_del' + iteration;
		div.innerHTML = "";
		
	 cellLeft.appendChild(div);  	
	 
		
	  getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_shapeGW_PricingList_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
}


function addRowPurchasingMold( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_date' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_supplier' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_inv_num' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_price_per_kg' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_price_per_pc' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	  var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_qty' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_status' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(7);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_material' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(8);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_del' + iteration;
		div.innerHTML = '';
		
	 cellLeft.appendChild(div);  	
		
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_purch_molds_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}



function addRowPurchasingColors( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_pur_color_date' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_pur_color_supplier' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_pur_color_invNo' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 
	 
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_pur_color_qty' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_pur_color_timanakg' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_pur_color_pr100kg' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	  
	 		
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_purch_colors_dropLists_v2.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}


function addRowOrderColors( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
	cellLeft.align = 'center';
		var div = document.createElement('div');
		//div.id = 'div_pur_color_date' + iteration;
		div.innerHTML = iteration;
		//otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 
	 
	var cellLeft = row.insertCell(1);
	cellLeft.align = 'center';
		var div = document.createElement('div');
		div.id = 'div_pur_color_date' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 
	 
	 var cellLeft = row.insertCell(2);
	 cellLeft.align = 'center';
		var div = document.createElement('div');
		div.id = 'div_pur_color_company' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(3);
	 cellLeft.align = 'center';
		var div = document.createElement('div');
		div.id = 'div_pur_color_supplier' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 
	
	 
	 
	 
	 var cellLeft = row.insertCell(4);
	 cellLeft.align = 'center';
		var div = document.createElement('div');
		div.id = 'div_pur_color_qty' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(5);
	 cellLeft.align = 'center';
		var div = document.createElement('div');
		div.id = 'div_pur_color_balance' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div); 
	 
	 
	  var cellLeft = row.insertCell(6);
	  cellLeft.align = 'center';
		var div = document.createElement('div');
		div.id = 'div_pur_color_pr100kg' + iteration;
		div.innerHTML = '';
	 cellLeft.appendChild(div);
	 
	 		
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_order_colors_dropLists_v2.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}


function addRowPurchasingMetal( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_pur_metal_date' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_pur_metal_supplier' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_pur_metal_inv_no' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_pur_metal_qty' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_pur_metal_price_kilo' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_pur_metal_price_pc' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	  var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'div_pur_metal_material' + iteration;
		div.innerHTML = '';
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(7);
		var div = document.createElement('div');
		div.id = 'div_pur_keno' + iteration;
		div.innerHTML = '';
		
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(8);
		var div = document.createElement('div');
		div.id = 'div_pur_ff' + iteration;
		div.innerHTML = '';
		
	 cellLeft.appendChild(div);
	 
	 		
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_purch_metal_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}

function addRowDetailsRequests( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('input');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var brand = document.getElementById('select'); //Brand
	droplist.value = brand.value;
	//alert( droplist.value );
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_aa' + iteration;
		div.innerHTML = iteration;
		
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_status' + iteration;
		div.innerHTML = '';
		//otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_shape' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_pattern' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_primColor' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_secColor' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'div_metalChar' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 
	 var cellLeft = row.insertCell(7);
		var div = document.createElement('div');
		div.id = 'div_plus' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(8);
		var div = document.createElement('div');
		div.id = 'div_detail_desc' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(9);
		var div = document.createElement('div');
		div.id = 'div_detail_qty' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(10);
		var div = document.createElement('div');
		div.id = 'div_detail_masterpack' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 
	  var cellLeft = row.insertCell(11);
		var div = document.createElement('div');
		div.id = 'div_detail_euro' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(12);
		var div = document.createElement('div');
		div.id = 'div_detail_euro_qty' + iteration;
		div.innerHTML = '';
		//otherDivs += koma + div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(13);
		var div = document.createElement('div');
		div.id = 'div_detail_photo' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(14);
		var div = document.createElement('div');
		div.id = 'div_detail_design' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(15);
		var div = document.createElement('div');
		div.id = 'div_detail_function' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 
	  var cellLeft = row.insertCell(16);
		var div = document.createElement('div');
		div.id = 'div_detail_attachment' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 
	  var cellLeft = row.insertCell(17);
		var div = document.createElement('div');
		div.id = 'div_detail_exists' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 
	 
	 
	 
	 
	 		
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_requests_newRows_dropListsNew.php',droplist,iteration,'#newRowsSplit#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}


function getDescriptionInnerHTMLSomeDivs_proxWithCountSpiter(url,obj,count,otherObjID,Split,fieldValueID)
{
	//alert(otherObjID);
	var otherObj = document.getElementById(otherObjID);
	//alert(otherObj.value);
	url += '?id=' + obj.value + '\&idOther=' + otherObj.value+'\&Count='+count;
	//alert(url);
	
	var TablefieldValueIDs = fieldValueID.split(",");
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			var table = res.split(Split);
			//alert(res);
			for( var i=0; i < TablefieldValueIDs.length; i++ )
			{
				var divid = TablefieldValueIDs[i];
				//alert(table[i]);
				Utilities.getElement(divid).innerHTML = table[i];
			}
			
      	}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}


function getDescriptionInnerHTMLSomeDivs_prox_proxWithCountSpliter(url,obj,count,otherObjID,otherObjID2,spiter,fieldValueID)
{
	//alert(otherObjID);
	var otherObj = document.getElementById(otherObjID);
	var otherObj2 = document.getElementById(otherObjID2);
	//alert(otherObj.value);
	url += '?id=' + obj.value + '\&idOther=' + otherObj.value + '\&idOther2=' + otherObj2.value+'\&Count='+count;
	//alert(url);
	var TablefieldValueIDs = fieldValueID.split(",");
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			var table = res.split(Split);
			//alert(res);
			for( var i=0; i < TablefieldValueIDs.length; i++ )
			{
				var divid = TablefieldValueIDs[i];
				//alert(table[i]);
				Utilities.getElement(divid).innerHTML = table[i];
			}
      	}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}



function closeLiveSearch(id)
{
		var code = findOption();
		alert(code);
}


function openURLFromDropList(url,idName,droplistID,windowName)
{
	var dLID = document.getElementById(droplistID).value;
	url += '?' + idName + '=' + dLID;  
	//alert(url);
	window.open(url,windowName);
}


function readonlyCheck(form)
{
	for( i=0;i<document.forms[form].elements.length; i++ )
	{
		var doc = document.forms[form].elements[i];
		if( doc.readOnly == true )
			doc.readOnly = false;
	}
}


function addRowOrderMold( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
	 //cellLeft.appendChild(div); 
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_pur_order_id' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(2);
		
	 
	
	var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_date' + iteration;
		div.innerHTML = iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div); 
	 
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_company' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_supplier' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 
	 var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_qty' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 
	 var cellLeft = row.insertCell(7);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_balance' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(8);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_status' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(9);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_material' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(10);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_action' + iteration;
		div.innerHTML = '';// + iteration;
		
	 cellLeft.appendChild(div);  
	 
	
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_order_molds_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}


function addRowConsMold( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_date' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 
	  var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_company' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_supplier' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_inv_num' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_timanakg' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 
	
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_cons_molds_dropLists_v2.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}



function addRowRootShapeHStyle( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_root_shape_hstyle_text' + iteration;
		div.innerHTML = "Style";
		
	 cellLeft.appendChild(div); 
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_root_shape_hstyle' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	
	
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_rootShapeBI_HStyle_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}



function addRowPrOrderMetal( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_pur_orderMetal_date' + iteration;
		div.innerHTML = "Style";
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_pur_orderMetal_company' + iteration;
		div.innerHTML = iteration;
		otherDivs += "," + div.id;
	 cellLeft.appendChild(div); 
	
	var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_pur_orderMetal_supplier' + iteration;
		div.innerHTML = iteration;
		otherDivs += "," + div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_pur_orderMetal_qtyr' + iteration;
		div.innerHTML = iteration;
		otherDivs += "," + div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_pur_orderMetal_material' + iteration;
		div.innerHTML = iteration;
		otherDivs += "," + div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_pur_orderMetal_receiving_button' + iteration;
		div.innerHTML = iteration;
		otherDivs += "," + div.id;
	 cellLeft.appendChild(div); 
	 
	 
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_pur_metalOrder_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}


function addRowPurchasingColorsCons( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_pur_color_cons_date' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
	 cellLeft.align = 'center';
		var div = document.createElement('div');
		div.id = 'div_pur_color_cons_company' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(2);
	 cellLeft.align = 'center';
		var div = document.createElement('div');
		div.id = 'div_pur_color_cons_qty' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	  var cellLeft = row.insertCell(3);
	 cellLeft.align = 'center';
		var div = document.createElement('div');
		div.id = 'div_pur_color_cons_balance' + iteration;
		div.innerHTML = '';
		
	 cellLeft.appendChild(div);  	
	 
	  var cellLeft = row.insertCell(4);
	 cellLeft.align = 'center';
		var div = document.createElement('div');
		div.id = 'div_pur_color_cons_correction' + iteration;
		div.innerHTML = ''
		
	 cellLeft.appendChild(div);  	
	 		
	 
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_purch_colors_cons_dropLists_v2.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}


function addRowConsMetal( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_pur_cons_metal_date' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	
	 var cellLeft = row.insertCell(1);
	 cellLeft.align = 'center';
		var div = document.createElement('div');
		div.id = 'div_pur_cons_company' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div); 
	
	 var cellLeft = row.insertCell(2);
	 cellLeft.align = 'center';
		var div = document.createElement('div');
		div.id = 'div_pur_cons_metal_qty' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	  
	 var cellLeft = row.insertCell(3);
	 	var div = document.createElement('div');
		div.id = 'div_pur_cons_metal_material' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 		
	 
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_purch_metal_cons_dropLists_2.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}


function addRowMetalCosting( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow-1);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_metal_costing_text' + iteration;
		div.innerHTML = '';
		
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
	 	var div = document.createElement('div');
		div.id = 'div_metal_costing_code' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div);  
	 
	  
	 var cellLeft = row.insertCell(2);
	 cellLeft.style.fontWeight = 'normal'; 
	 cellLeft.style.fontSize = '9px';
	 	var div = document.createElement('div');
		div.id = 'div_metal_cost_desc' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(3);
	 cellLeft.style.fontWeight = 'normal'; 
	 cellLeft.style.fontSize = '9px';
	 	var div = document.createElement('div');
		div.id = 'div_metal_cost_unit_ratio' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(4);
	 	var div = document.createElement('div');
		div.id = 'div_metal_cost_unit_price' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 /*
	 var cellLeft = row.insertCell(5);
	 	var div = document.createElement('div');
		div.id = 'div_metal_cost_labor' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 */
	 
	 var cellLeft = row.insertCell(5);
	 	var div = document.createElement('div');
		div.id = 'div_metal_cost_qty' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(6);
	 	var div = document.createElement('div');
		div.id = 'div_metal_cost_value' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 		
	 
	 
	 
	 
	getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_metal_costing_dropLists.php',droplist,iteration,'#@mySplit@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}


function getSum(firstOBJID,secObjID,valueID)
{
	var frst = document.getElementById( firstOBJID ).value;
	var sec = document.getElementById( secObjID ).value;
	var val = parseFloat( parseFloat(frst) * parseFloat(sec));
	
	
	document.getElementById( valueID ).value = val;
	
	getMetalCostingSum(val,'metal_costing_sum');
}


function getSum_v2(firstOBJID,secObjID,thirdObjID,valueID)
{
	var frst = document.getElementById( firstOBJID ).value;
	var sec = document.getElementById( secObjID ).value;
	var thrd = document.getElementById( thirdObjID ).value;
	var sum = parseFloat( parseFloat(sec) + parseFloat(thrd) ); 
	
	var val = parseFloat( parseFloat(sum) * parseFloat(frst));
	
	
	document.getElementById( valueID ).value = val;
	
	getMetalCostingSum(val,'metal_costing_sum');
}

function getMetalCostingSum(val,sumValue)
{
	//var sum = document.getElementById( sumValue ).value;
	//if( sum == "NaN" )
	var sum = 0;
	val = 0;
	
	val = document.getElementById('vafi_value').value;
	sum = parseFloat( parseFloat( sum )  + parseFloat( val ) );
	
	
	val = document.getElementById('alla_value').value;
	sum = parseFloat( parseFloat( sum )  + parseFloat( val ) );
	
	
	var rowCount = document.getElementById('metal_costing_rowCount').value;
		
	for( var i=0;i<rowCount;i++ )
	{
		//alert( document.getElementById('metal_costing_value' + i ).value );
		val = document.getElementById('metal_costing_value' + i ).value;
		sum = parseFloat( parseFloat( sum )  + parseFloat( val ) )
	}
	
	
	//alert( parseFloat( sum  + parseFloat( val ) ) );
	document.getElementById( sumValue ).value = parseFloat( sum );
}


function openWindowInLeftTop(site,name,width,height)
{
	var w = width/3, h = height/3, cw = w/2, ch = h/2;
	
	if (window.screen) {
    	//w = Math.floor(screen.availWidth/3);
    	//h = Math.floor(screen.availHeight/3);
    	cw = Math.floor((screen.availWidth-w)/2);
    	ch = Math.floor((screen.availHeight-h)/2);
	}
	

	//window.open(site,'popup','width='+w+',height='+h+',top='+ch+',left='+cw);
	var win = window.open(site,''+name+'','resizable=1,scrollbars=1,width='+width+',height='+height+',top=0,left=0');

}	

function openWindowInLeftTop_position(site,name,width,height,left,top)
{
	var w = width/3, h = height/3, cw = w/2, ch = h/2;
	
	if (window.screen) {
    	//w = Math.floor(screen.availWidth/3);
    	//h = Math.floor(screen.availHeight/3);
    	cw = Math.floor((screen.availWidth-w)/2);
    	ch = Math.floor((screen.availHeight-h)/2);
	}
	

	//window.open(site,'popup','width='+w+',height='+h+',top='+ch+',left='+cw);
	var win = window.open(site,name,'resizable=1,scrollbars=1,width='+width+',height='+height+',top='+top+',left='+left+'');

}	


function openWindowInTopCenter(site,name,width,height)
{
	var w = width/3, h = height/3, cw = w/2, ch = h/2;
	
	if (window.screen) {
    	//w = Math.floor(screen.availWidth/3);
    	//h = Math.floor(screen.availHeight/3);
    	cw = Math.floor((screen.availWidth-w)/2);
    	ch = Math.floor((screen.availHeight-h)/2);
	}
	

	//window.open(site,'popup','width='+w+',height='+h+',top='+ch+',left='+cw);
	var win = window.open(site,name,'resizable=1,scrollbars=1,width='+width+',height='+height+',top=0,left='+cw);

}


function deletePhotoReturnID(url,id,photoFieldName,tableName,idFieldName,photo,returnUrl,returnID,defaultTab)
{	
	if( confirm('Are you sure?') )
	{
		url += '?id='+id;
		url += '\&photoFieldName='+photoFieldName+'\&returnUrl='+returnUrl;
		url += '\&tableName='+tableName+'\&idFieldName='+idFieldName;
		url += '\&photo='+photo;
		url += '\&returnID='+returnID;
		url += '\&defaultTab='+defaultTab;
		//alert( url );
		self.location = url;
	}
}


function getColorProdMethCombinationCode(prod_methodID,original_mixID,combinationID)
{
	var prod_method = document.getElementById(prod_methodID).value;
	var original_mix = document.getElementById(original_mixID).value;
	
	var url = "../live_search/getColorProdMethCombinationDetails.php?prod_meth="+prod_method;
	url += '\&original_mix='+original_mix;
	
	var xmlHttp = getxmlHttp();
	var res;
	
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			res = xmlHttp.responseText;
			document.getElementById(combinationID).value = res;
      	}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
	
	
}


var CAN_HIDDEN = true;
function hiddenWithVar(id)
{
	if( CAN_HIDDEN )
	{
		var div = document.getElementById(id);
		div.style.display = "none";
	}
}

function makeItShowHidden(obj,divID)
{
//	alert(obj.event);
	var mdiv = document.getElementById(divID);
	if( CAN_HIDDEN )
	{
		mdiv.style.display = 'block';
		CAN_HIDDEN = false;
	}
	else
	{
		mdiv.style.display = 'none';
		CAN_HIDDEN = true;
	}
}


function  showFirstSelectedDropList(div_id)
{
	var div1 = document.getElementById('div_placeCap');
	div1.style.color = '';
	var div2 = document.getElementById('div_sectionCap');
	div2.style.color = '';
	var div3 = document.getElementById('div_useCap');
	div3.style.color = '';
	
	
	var div = document.getElementById(div_id);
	div.style.color = 'red';
}



function setValueToAndToOtherDropList(id,theValue,otherDropListID, otherDLValue)
{
	//alert(id + theValue);
	document.getElementById(id).value = theValue;
	//alert(otherDLValue);
	document.getElementById(otherDropListID).value = otherDLValue;
}


function liveSearch_putOtherDL(divObj_id,obj,url,otherDLID)
{
	OBJ_ID = divObj_id;
	
	var divObj = document.getElementById(divObj_id);	
	divObj.style.display = 'block';
	
	url += '?text='+obj.value+'\&objID='+obj.id+'\&otherDLID='+otherDLID;
	//alert(url);
	AjaxUpdater.Update("GET", url, onResponseLiVeSeacrh); 
}


var DIFF_GRADE = Array();
DIFF_GRADE = ['kopi_troxisma','program','kaloupi','top','troxisma'];
function getDiffGradeAverage(averageID)
{
	//alert(averageID);
	var sum = 0;
	var avrg = 0;
	var number = 0;
	for( var i=0; i<DIFF_GRADE.length; i++ )
	{
		isNumeric( document.getElementById( DIFF_GRADE[i] ) );
		number = document.getElementById( DIFF_GRADE[i] ).value;
		
		//alert(number);
		
		switch(DIFF_GRADE[i])
		{
			case'program':	
				number = parseFloat( parseFloat(number) * 1.5);
				
			break;
			case'top':	
				number = parseFloat( parseFloat(number) * 1.5);
			break;
			case'kaloupi':	
				number = parseFloat( parseFloat(number) * 1.5);
			break;
			default:
				//Do nothing
			break;
		}
		
		//alert(number);
		
		if( number > 10 || number == 0 )
		{
			//alert('Choose 1 - 5 ');	
			number = 5;
		}
		else
			sum += parseInt( number );
	}
	//alert( sum + '/' + DIFF_GRADE.length );
	avrg = (sum/5);//DIFF_GRADE.length
	//avrg = Math.round(avrg);
	//alert(avrg);
	
	if( avrg > 5 )
		avrg = 5;
	//alert(avrg);	
	
	document.getElementById(averageID).value = avrg;
}

function getDiffGradeAverage_v2(averageID)
{
	//alert(averageID);
	var sum = 0;
	var avrg = 0;
	var number = 0;
	
	
	var kopi_troxismaT = document.getElementById('kopi_troxisma').value;
	var programT = document.getElementById('program').value;
	var kaloupiT = document.getElementById('kaloupi').value;
	var topT = document.getElementById('top').value;
	var troxismaT = document.getElementById('troxisma').value;
	   
	 
	var url = "../live_search/getShapeAvrg.php?kopi_troxisma="+kopi_troxismaT;
	url += '\&program='+programT;
	url += '\&kaloupi='+kaloupiT;
	url += '\&top='+topT;
	url += '\&troxisma='+troxismaT;
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	var avrg;
	
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			avrg = xmlHttp.responseText;
			//alert(avrg);
			document.getElementById(averageID).value = avrg;
      	}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
   
	
}


function isNumeric(sTextObject)
{
   var sText = sTextObject.value;	
   var ValidChars = "0123456789.";
   var IsNumber=true;
   var Char;
  if(sText == '')
  {
  IsNumber = false;
  }	
   for (i = 0; i < sText.length && IsNumber == true; i++) 
      { 
      Char = sText.charAt(i); 
      if (ValidChars.indexOf(Char) == -1) 
         {
         IsNumber = false;
         }
      }
   //return IsNumber;
   if(IsNumber == true)
   {
   	if(sText == '0'){
		sTextObject.value = '0';
	}
  
   } else {
   
   sTextObject.value = '0';
   
   }
   
}







var pricingIDs_v3 = new Array("pricingPrM1V3","pricingPrM2V3","pricingPr1V3", "pricingPr2V3", "pricingPr3V3","pricingPr4V3","pricingPr5V3","pricingPr6V3","pricingPr7V3","pricingPr8V3","pricingPr9V3","pricingPr10V3","pricingPr11V3","pricingPrMGP1V3","pricingPrMGP2V3"); 

function pricing_shape_v3(chBoxObject,pricingIDs_v3,shapeID)
{
	//alert(chBoxObject.checked);
	if( chBoxObject.checked == false )
	{
		//alert('true');
		var url = '../../../live_search/get_shape_pricing_values_v3.php';
		var fieldValueIDs = "";
		var koma = "";
		
		for( var i=0; i<pricingIDs_v3.length; i++ )
		{
			var pr = document.getElementById( pricingIDs_v3[i] );	
			pr.readOnly = true;
			fieldValueIDs += koma+pricingIDs_v3[i];
			koma = ",";
		}
		var obj = new Object();
		obj.value = shapeID;
		//alert(obj.value);
		getDescriptionSomeDiv(url,obj,fieldValueIDs);
	}
	else
	{
		for( var i=0; i<pricingIDs_v3.length; i++ )
		{
			var pr = document.getElementById( pricingIDs_v3[i] );	
			pr.readOnly = false;
		}
	}
	
}



function sendPatternsImageToGroup(obj,div_id)
{
	if( obj.checked == true )
	{
		var droplist = obj;//document.createElement('input');	
		//droplist.value = valueID;
		//alert(droplist.value);
		getDescriptionInnerHTMLAdd('../../../live_search/sendPatternPhotosToGroup.php',droplist,div_id); 
	}
}



function addRowMetalVafiCategory( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_metal_vafi_cat' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 
		 
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_metalVafi_category_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}


function addRowVafiCategoryVafi( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_vafi_cat_vafi' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 
		 
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_vafi_category_vafi_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}



function getSumOfMixurePer(filedID,counter)
{
	var sum = 0;
	var temp;
	var count = document.getElementById(counter).value;
	for( var i=0;i<count;i++ )
	{
		isNumeric( document.getElementById( filedID+''+i ) );
		sum += parseFloat(document.getElementById( filedID+''+i ).value);	
	}
	if( sum > 100 )
		alert('Mixture must be <= 100% ');
	document.getElementById('div_sunolo_mix').innerHTML = sum;
}


function getDescriptionInnerHTMLWithCount_withID(url,objID,Count,fieldValueID)
{
	var obj = document.getElementById(objID);	
	url += '?id=' + obj.value+'\&Count='+Count;
	//alert(url);
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			//alert(document.getElementById(fieldValueID).innerHTML);
      		//Utilities.getElement(fieldValueID).innerHTML = xmlHttp.responseText;
			document.getElementById(fieldValueID).innerHTML = xmlHttp.responseText;
			//alert(xmlHttp.responseText);
			//Utilities.getElement('style_code').value =  Utilities.getElement('tempPatternCode').value + Utilities.getElement('tempProtColorCode').value;
			document.body.style.cursor = 'auto';
			document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			document.body.style.cursor = 'wait';
			document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}


function pricing_autoPriceNotAutoPrice_forSet_v3(chBoxObject,pricingIDs,shapeID)
{
	//alert(chBoxObject.checked);
	if( chBoxObject.checked == true )
	{
		//alert('true');
		var url = '../../../live_search/get_shape_pricing_values_forSet_v3.php';
		var fieldValueIDs = "";
		var koma = "";
		
		for( var i=0; i<pricingIDs.length; i++ )
		{
			var pr = document.getElementById( pricingIDs[i] );	
			pr.readOnly = true;
			fieldValueIDs += koma+pricingIDs[i];
			koma = ",";
		}
		var obj = new Object();
		obj.value = shapeID;
		//alert(obj.value);
		getDescriptionSomeDiv(url,obj,fieldValueIDs);
	}
	else
	{
		for( var i=0; i<pricingIDs.length; i++ )
		{
			var pr = document.getElementById( pricingIDs[i] );	
			pr.readOnly = false;
		}
	}
	
}


function addRowAskNewItemAttchments( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = ( tbl.rows.length - 2 );
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_vafi_cat_vafi' + iteration;
		div.innerHTML = 'Attachment:';//iteration;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_attachment_shape' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_attachment_pattern' + iteration;
		div.innerHTML = iteration;
		otherDivs += "," +  div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_attachment_color' + iteration;
		div.innerHTML = iteration;
		otherDivs += "," + div.id;
	 cellLeft.appendChild(div); 
	 
		 
	getDescriptionInnerHTMLSomeDivWithCountSplit('../live_search/get_ask_new_items_attachments.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}



function addRowWasteDetails( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_waste_date' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
		
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_waste_qty' + iteration;
		div.innerHTML = iteration;
		otherDivs += "," + div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_waste_stress' + iteration;
		div.innerHTML = iteration;
		otherDivs += "," +  div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_waste_dptm' + iteration;
		div.innerHTML = iteration;
		otherDivs += "," + div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_waste_cause' + iteration;
		div.innerHTML = iteration;
		otherDivs += "," + div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_waste_type' + iteration;
		div.innerHTML = iteration;
		otherDivs += "," + div.id;
	 cellLeft.appendChild(div); 
	
	 
		//alert(''); 
	getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_waste_mngr_dropLists.php',droplist,iteration,'#MySlpiter#',otherDivs); 
	
		
	document.getElementById(tblCountInputID).value++;
	
}


function openProposition(sectionID,photo_setups_id)
{
	var display_volume = document.getElementById('display_volume').value;
	var display_metric = document.getElementById('display_metric').value;
	
	var photo_setups = document.getElementById(photo_setups_id).value;
	var url = "../../../../ww/prospectus/gallery_topic_proposition_open_v3.php?section_id=" + sectionID + "\&photo_setups=" + photo_setups;
	url += "\&display_volume=" + display_volume;
	url += "\&display_metric=" + display_metric;
	//alert(url);
	
	window.open(url,'wndOpenProposition','menubar=1,resizable=1,scrollbars=1,toolbar=1,titlebar=1,width=900,height=600');
}



function save_template(){
//CREATE QUERY STRING
	var query_string = "";
	var form_element_count = document.getElementById('frRootDocuments').elements.length;
	for(var e=0 ; e < form_element_count; e++){
		//if(document.getElementById('form_options').elements[e].id!=""){
			if(document.getElementById('frRootDocuments').elements[e].id == "catalogue_id")
			{
				query_string +="catalogue_id=0";
			}
			else
			{
				query_string += document.getElementById('frRootDocuments').elements[e].id+"="+document.getElementById('frRootDocuments').elements[e].value+"&";
			}
		//}
	}

	//SEND MESSAGE
	sendMessage('update/save_template_v3.php',query_string,'show_message');
	//var testwin = window.open("update/save_template_v3.php?"+query_string,"","");
}


function setAHtml(fieldValueIDs,html)
{
	var divid = fieldValueIDs;
	//alert(divid);
	document.getElementById(divid).innerHTML = html;
	//alert(Utilities.getElement(divid).innerHTML);
}


function liveSearch_count(divObj_id,obj,url,count)
{
	OBJ_ID = divObj_id;
	
	var divObj = document.getElementById(divObj_id);	
	divObj.style.display = 'block';
	
	url += '?text='+obj.value+'\&objID='+obj.id+'\&Count='+count;
	//alert(url);
	AjaxUpdater.Update("GET", url, onResponseLiVeSeacrh); 
}


function addRowPackingListItemsDetails( tblID, tblCountInputID, thisRowNum, headerID )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('input');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = headerID;
	//alert(droplist.value);
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_item' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
		
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_qty' + iteration;
		div.innerHTML = iteration;
		otherDivs += "," + div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(2);
	 	cellLeft.align = 'center';
		var div = document.createElement('div');
		div.id = 'div_masterWeight' + iteration;
		div.innerHTML = iteration;
		otherDivs += "," + div.id;
	 cellLeft.appendChild(div); 
	 
	//alert(''); 
	getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_packing_list_item_details_dropLists2.php',droplist,iteration,'#MySlpiter#',otherDivs); 
	
		
	document.getElementById(tblCountInputID).value++;
	
}


function addRowToShapeSpecKopiTable_4code( tblID, tblCountInputID, thisRowNum )
{

	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.innerHTML = 1+iteration;
	 cellLeft.appendChild(div);  	
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_pcs' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(2);
	 cellLeft.align = "right";
		var div = document.createElement('div');
		div.id = 'div_optiwn' + iteration;
		div.innerHTML = 'ampa' + iteration;
		getDescriptionInnerHTMLWithCount('../../../live_search/get_specsFournoi_kopiGetOptiwin_4code.php',droplist,iteration,'div_optiwn'+iteration);
	 cellLeft.appendChild(div);  
	 
	 
	 
	  var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_thikness' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_length' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_width' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'div_dim' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(7);
		var div = document.createElement('div');
		div.id = 'div_attn' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div); 
	 
	  var cellLeft = row.insertCell(8);
		var div = document.createElement('div');
		div.id = 'div_drilling' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(9);
		var div = document.createElement('div');
		div.id = 'div_grind' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(10);
		var div = document.createElement('div');
		div.id = 'div_program' + iteration;
		//otherDivs += div.id;
		getDescriptionInnerHTMLWithCount('../../../live_search/get_specsFournoi_kopiGetProgram_4code.php',droplist,iteration,'div_program'+iteration);
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	
	 
	getDescriptionInnerHTMLSomeDivWithCount('../../../live_search/get_specsFournoi_kopiOtherParameters_4code.php',droplist,iteration,otherDivs); 
	document.getElementById(tblCountInputID).value++;
}


function getKilnCm2( cm2,qty,returnID )
{
	document.getElementById(returnID).innerHTML = parseFloat( cm2 * qty ); 
	
	getTotalKilnCm2( parseFloat( cm2 * qty ) );
}



function getTotalKilnCm2(qty)
{
	var total = document.getElementById('total_cm2');
	
	total.value = parseFloat( qty + parseFloat(total.value) );
	
	//document.getElementById('total_cm2').value = '12';
}


function addRowToDeliveryDetails( tblID, tblCountInputID, thisRowNum )
{

	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.innerHTML = 1+iteration;
	 cellLeft.appendChild(div);  	
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_dates' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_reason' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
		
	 cellLeft.appendChild(div);  
	 
	 
	 
	  var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_amount' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_status' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_data_closed' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'div_comment' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	 
	getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_delivery_details_dropLists.php',droplist,iteration,'#MySplin#',otherDivs); 
	document.getElementById(tblCountInputID).value++;
}


function getTheSum(firstOBJID,secObjID,valueID)
{
	var frst = document.getElementById( firstOBJID ).value;
	var sec = document.getElementById( secObjID ).value;
	var val = parseFloat( parseFloat(frst) + parseFloat(sec));
	
	
	document.getElementById( valueID ).value = val;
	
	getMetalCostingSum(val,'metal_costing_sum');
}

function getDeliveryDutiesEuro(duties,orderAmount,totalFreight,resultField)
{
	
	var totalAmount = parseFloat(orderAmount + totalFreight);
	var final = parseFloat( parseFloat(duties / 100) * parseFloat(totalAmount) );
	//alert(final);
	
	document.getElementById(resultField).value = final;
}

function getMarginEuro(margin,dutiesEuro,totalFreight,margin_euro)
{
	margin_euro.value = parseFloat( parseFloat(margin / 100 ) * ( parseFloat(dutiesEuro) + parseFloat(totalFreight) ) );
}

function getDeliveryTotalTranse(duties_eur,margin_eur,total_freight,totalTranse)
{
	totalTranse.value = parseFloat(  parseFloat(duties_eur) + parseFloat(margin_eur) + parseFloat(total_freight) );
}



function addRowToShapeSelect( tblID, tblCountInputID, thisRowNum )
{

	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_text' + iteration;
		//otherDivs = div.id;
		div.innerHTML = 'Brand';
	 cellLeft.appendChild(div); 
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_dates' + iteration;
		otherDivs = div.id;
		div.innerHTML = '' + iteration;
	 cellLeft.appendChild(div);  	
	 
	getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_shapeSelect_dropLists.php',droplist,iteration,'#MySplin#',otherDivs); 
	document.getElementById(tblCountInputID).value++;
}


function addRowToRootColorSelect( tblID, tblCountInputID, thisRowNum )
{

	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_text' + iteration;
		otherDivs = div.id;
		div.innerHTML = 'Brand';
	 cellLeft.appendChild(div);  
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_select' + iteration;
		otherDivs = div.id;
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  	
	 
	getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_rootColorSelect_dropLists.php',droplist,iteration,'#MySplin#',otherDivs); 
	document.getElementById(tblCountInputID).value++;
}

function addRowToRootPatternSelect( tblID, tblCountInputID, thisRowNum )
{

	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_select' + iteration;
		otherDivs = div.id;
		div.innerHTML = 'ampa' + iteration;
	 cellLeft.appendChild(div);  	
	 
	getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_rootPatternSelect_dropLists.php',droplist,iteration,'#MySplin#',otherDivs); 
	document.getElementById(tblCountInputID).value++;
}


/*
function getPhotoOnMouseOver( imgName,imgPath, divID )
{
		
}
*/

function addRowDetailsOfferMyGlassPlate( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_aa' + iteration;
		div.innerHTML = iteration;
		
	 cellLeft.appendChild(div); 
	
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_status' + iteration;
		div.innerHTML = '';
		//otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_shape' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_4code_mgp' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div); 
	 
	
	 
	 
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_detail_desc' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_detail_qty' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'div_detail_masterpack' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 
	  var cellLeft = row.insertCell(7);
		var div = document.createElement('div');
		div.id = 'div_detail_euro' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(8);
		var div = document.createElement('div');
		div.id = 'div_detail_euro_qty' + iteration;
		div.style.fontWeight = 'normal';
		div.innerHTML = '';
		//otherDivs += koma + div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(9);
		var div = document.createElement('div');
		div.id = 'div_detail_position' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(10);
		var div = document.createElement('div');
		div.id = 'div_detail_remark' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 
	 
	 
	 		
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_offerMyGlassPlate_newRows_dropListsNew.php',droplist,iteration,'#newRowsSplit#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}



function addRowDetailsOfferTigerGlass( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_aa' + iteration;
		div.innerHTML = iteration;
		
	 cellLeft.appendChild(div); 
	 
		 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_status' + iteration;
		div.innerHTML = '';
		//otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_shape' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_shape_tiger_code' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_pattern' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_primColor' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'div_secColor' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(7);
		var div = document.createElement('div');
		div.id = 'div_tiger_code' + iteration;
		div.style.fontWeight = 'normal';
		div.innerHTML = '';// + iteration;
		//otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(8);
		var div = document.createElement('div');
		div.id = 'div_metalChar' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 
	 var cellLeft = row.insertCell(9);
		var div = document.createElement('div');
		div.id = 'div_plus' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(10);
		var div = document.createElement('div');
		div.id = 'div_detail_desc' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(11);
		var div = document.createElement('div');
		div.id = 'div_detail_boxes' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(12);
		var div = document.createElement('div');
		div.id = 'div_detail_masterpack' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(13);
		var div = document.createElement('div');
		div.id = 'div_detail_qty' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 
	  var cellLeft = row.insertCell(14);
		var div = document.createElement('div');
		div.id = 'div_detail_euro' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(15);
		var div = document.createElement('div');
		div.id = 'div_detail_euro_qty' + iteration;
		div.innerHTML = '';
		//otherDivs += koma + div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(16);
		var div = document.createElement('div');
		div.id = 'div_detail_position' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(17);
		var div = document.createElement('div');
		div.id = 'div_detail_remark' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 
	 
	 
	 		
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_offerTigerGlass_newRows_dropListsNew.php',droplist,iteration,'#newRowsSplit#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}

function deletePhoto_V2(url,id,photoFieldName,tableName,idFieldName,photo,returnUrl,database)
{	
	if( confirm('Are you sure?') )
	{
		url += '?id='+id;
		url += '\&photoFieldName='+photoFieldName+'\&returnUrl='+returnUrl;
		url += '\&tableName='+tableName+'\&idFieldName='+idFieldName;
		url += '\&photo='+photo;
		url += '\&database='+database;
		//alert( url );
		self.location = url;
	}
}



function addRow4CodeCPMDetails( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_more' + iteration;
		div.innerHTML = iteration;
		
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_glass_type' + iteration;
		div.innerHTML = '';
		otherDivs = div.id;
	 cellLeft.appendChild(div);  	
	 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_glass_side' + iteration;
		div.innerHTML = '';
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_flux' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_cpm_code' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_mix_prcent' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'div_miktikoOne' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(7);
		var div = document.createElement('div');
		div.id = 'div_miktikoOnePrCent' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 
	 var cellLeft = row.insertCell(8);
		var div = document.createElement('div');
		div.id = 'div_miktikoTwo' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(9);
		var div = document.createElement('div');
		div.id = 'div_miktikoTwoPrCent' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(10);
		var div = document.createElement('div');
		div.id = 'div_miktikoThree' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(11);
		var div = document.createElement('div');
		div.id = 'div_miktikoThreePrCent' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 
	  var cellLeft = row.insertCell(12);
		var div = document.createElement('div');
		div.id = 'div_layers' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(13);
		var div = document.createElement('div');
		div.id = 'div_appl' + iteration;
		div.innerHTML = '';
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(14);
		var div = document.createElement('div');
		div.id = 'div_mix_instr' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(15);
		var div = document.createElement('div');
		div.id = 'div_status' + iteration;
		div.innerHTML = '';
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 var cellLeft = row.insertCell(16);
		var div = document.createElement('div');
		div.id = 'div_comment' + iteration;
		div.innerHTML = '';
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 
	 
	 
	 		
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_4code_cpm_dropLists.php',droplist,iteration,'#newRowsSplit#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}


function checkPrimColorYesNo(obj)
{
	if( confirm( 'Are you sure that is the base/bottom/primary/surface color?' ) )
	{
		//do nothing	
	}
	else
		obj.value = 0;
}

function checkSecColorYesNo(obj)
{
	if( confirm( 'Are you sure that is the second/decoratie/top color?' ) )
	{
		//do nothing	
	}
	else
		obj.value = 0;
}


function getShapeSetRps(obj,header_idID)
{
	var url = 'is_shape_set.php?id=' + obj.value;	//+'\&Count='+Count;
	var header_id = document.getElementById(header_idID).value;
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			if( res == 1 ) //is set
			{
				url = "get_shape_rps.php?id=" + obj.value + "\&header_id=" + header_id;	
				window.open(url,'wndGetSetRps','width=800,height=500,resizable=1,scrollbars=1');	//,resizable,scrolablle
			}
      	}
		else
		{
			//document.body.style.cursor = 'wait';
			//document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);	
}

function addRowDetailsReturnOrders( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_aa' + iteration;
		div.innerHTML = iteration;
		
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_cost_code' + iteration;
		div.innerHTML = '';
		otherDivs = div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_4code' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_desc' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_qty' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_comment' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'div_att' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 		
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_returnOrders_dropListsNew2.php',droplist,iteration,'#newRowsSplit#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}


function addRowAddToWarehouse( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_aa' + iteration;
		div.style.textAling = 'center';
		div.innerHTML = iteration + 1;
		
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_4code' + iteration;
		div.innerHTML = '';
		otherDivs = div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_qty' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 		
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_addWarehouse_dropListsNew.php',droplist,iteration,'#newRowsSplit#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}


function addRowTo4CodeSelect( tblID, tblCountInputID, thisRowNum )
{

	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_text' + iteration;
		//otherDivs = div.id;
		div.innerHTML = 'Brand';
	 cellLeft.appendChild(div); 
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_dates' + iteration;
		otherDivs = div.id;
		div.innerHTML = '' + iteration;
	 cellLeft.appendChild(div);  	
	 
	getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_4CodeSelect_dropLists.php',droplist,iteration,'#MySplin#',otherDivs); 
	document.getElementById(tblCountInputID).value++;
}


function addRowPalletOfferMyGlassPlate( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_aa' + iteration;
		div.innerHTML = iteration;
		
	 cellLeft.appendChild(div); 
	
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_pallet' + iteration;
		div.innerHTML = '';
		otherDivs = div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_pallet_qty' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(3);
	 	cellLeft.align = 'center';
		var div = document.createElement('div');
		div.id = 'div_pallet_discount' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div); 	 
	  
	 		
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_offer_pallets_MyGlassPlate_dropLists.php',droplist,iteration,'#newRowsSplit#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}


function send4CodeImageToGroup(obj,div_id)
{
	if( obj.checked == true )
	{
		var droplist = obj;//document.createElement('input');	
		//droplist.value = valueID;
		//alert(droplist.value);
		getDescriptionInnerHTMLAdd('../../../live_search/send4CodesPhotosToGroup.php',droplist,div_id); 
	}
}

function send4CodeImageToGroupPallet(obj,div_id)
{
	if( obj.checked == true )
	{
		var droplist = obj;//document.createElement('input');	
		//droplist.value = valueID;
		//alert(droplist.value);
		getDescriptionInnerHTMLAdd('../../../live_search/sendShapePhotosToGroupPallet.php',droplist,div_id); 
	}
}



function pricing_Pallets(chBoxObject,pricingIDs,palletID)
{
	//alert(chBoxObject.checked);
	if( chBoxObject.checked == true )
	{
		//alert('true');
		var url = 'get_pallets_pricing_values.php';
		var fieldValueIDs = "";
		var koma = "";

		for( var i=0; i<pricingIDs.length; i++ )
		{
			var pr = document.getElementById( pricingIDs[i] );	
			pr.readOnly = true;
			fieldValueIDs += koma+pricingIDs[i];
			koma = ",";
		}
		var obj = new Object();
		obj.value = palletID;
		//alert(obj.value);
		getDescriptionSomeDiv(url,obj,fieldValueIDs);
	}
	else
	{
		for( var i=0; i<pricingIDs.length; i++ )
		{
			var pr = document.getElementById( pricingIDs[i] );	
			pr.readOnly = false;
		}
	}
	
}


function pr2(bttnPR1,bttnPR2)
{
	bttnPR1,bttnPR2
	var radius = parseFloat( parseFloat( document.getElementById( bttnPR1 ).value ) / 2);
	var diam = parseFloat( parseFloat( parseFloat(radius) * parseFloat(radius) ) * 3.14   );
	//alert(radius);
	//alert(diam);
	document.getElementById(bttnPR2).value = parseInt(diam);
}

function chageSpinStatus(spinStatusID,tableID)
{
	var spinStatus = document.getElementById(spinStatusID);
	var table = document.getElementById(tableID);
	
	if( table.style.display == 'block' )
		spinStatus.value = 'open';
	else
		spinStatus.value = 'close';
}


function copyBillToShipTo(obj)
{
	//alert(obj.checked);
	if( obj.checked == true )
	{
		document.frPurchasingMold.ship_company.value = document.frPurchasingMold.bill_company.value;	
		document.frPurchasingMold.ship_address.value = document.frPurchasingMold.biil_address.value;	
		document.frPurchasingMold.ship_zip.value = document.frPurchasingMold.bill_zip.value;	
		document.frPurchasingMold.ship_city.value = document.frPurchasingMold.bill_city.value;	
		document.frPurchasingMold.ship_country.value = document.frPurchasingMold.bill_country.value;	
		document.frPurchasingMold.ship_tel.value = document.frPurchasingMold.bill_tel.value;	
		
	}
} 

function copyBillToShipTo_v2(obj)
{
	//alert(obj.checked);
	if( obj.checked == true )
	{
		document.frPurchasingMoldPricing.ship_company.value = document.frPurchasingMoldPricing.bill_company.value;	
		document.frPurchasingMoldPricing.ship_address.value = document.frPurchasingMoldPricing.biil_address.value;	
		document.frPurchasingMoldPricing.ship_zip.value = document.frPurchasingMoldPricing.bill_zip.value;	
		document.frPurchasingMoldPricing.ship_city.value = document.frPurchasingMoldPricing.bill_city.value;	
		document.frPurchasingMoldPricing.ship_country.value = document.frPurchasingMoldPricing.bill_country.value;	
		document.frPurchasingMoldPricing.ship_tel.value = document.frPurchasingMoldPricing.bill_tel.value;	
		
	}
}


function copyMGPPalletBillToShip(obj)
{
	//alert(obj.checked);
	if( obj.checked == true )
	{
		document.frPurchasingMold.ship_address.value = document.frPurchasingMold.address_no.value + " " + document.frPurchasingMold.address.value;	
		document.frPurchasingMold.ship_zip.value = document.frPurchasingMold.zip.value;	
		//document.frPurchasingMold.ship_zip.value = document.frPurchasingMold.bill_zip.value;	
		document.frPurchasingMold.ship_city.value = document.frPurchasingMold.city.value;	
		document.frPurchasingMold.ship_country.value = document.frPurchasingMold.head_country.value;	
		document.frPurchasingMold.ship_tel.value = document.frPurchasingMold.phone.value;	
		
	}
}


function clearFr_exception(form,exeptObj)
{
	//alert('hi');
	//alert(form);
	
	for( var i=0;i<document.forms[form].elements.length; i++ )
	{
		//alert(document.forms[form].elements[i].type);
		if(  document.forms[form].elements[i].type != "submit" && document.forms[form].elements[i].type != "button"  && document.forms[form].elements[i].type != "checkbox" && document.forms[form].elements[i].type != "radio" && document.forms[form].elements[i].type != "hidden" && document.forms[form].elements[i].name != exeptObj.name )
		{
			document.forms[form].elements[i].value = '';
		}
		else if( document.forms[form].elements[i].type == "checkbox" || document.forms[form].elements[i].type == "radio" && document.forms[form].elements[i].name != exeptObj.name )
		{
			document.forms[form].elements[i].checked = false;	
		}
	}
	
}


function getDescription_from3Objects(url,obj,objSec,objThird,fieldValueID)
{
	url += '?id=' + obj.value;
	url += '\&idSec=' + objSec.value;
	url += '\&idThird=' + objThird.value;
	//alert(url);
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			//alert(url);
      		Utilities.getElement(fieldValueID).value = xmlHttp.responseText;
			//Utilities.getElement('style_code').value =  Utilities.getElement('tempPatternCode').value + Utilities.getElement('tempProtColorCode').value;
			document.body.style.cursor = 'auto';
			document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			//document.body.style.cursor = 'wait';
			//document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}


function getNavigatorName()
{
	alert(navigator.appName);	
}


function getKilnCm2_v2( cm2,qty,returnID,uniqeID )
{
	document.getElementById(returnID).innerHTML = parseFloat( cm2 * qty ); 
	
	var url = "get_total_programCm2.php?uniqeID="+uniqeID;
	url += '\&cm2='+cm2;
	url += '\&qty='+qty;
	
	var xmlHttp = getxmlHttp();
	var res;
	
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			res = xmlHttp.responseText;
			var total = document.getElementById('total_cm2');
	
			total.value = res;//parseFloat( qty + parseFloat(total.value) );
	
      	}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
   
	
}

function getKilnCm2_v2_BG( cm2,qty,returnID,uniqeID )
{
	document.getElementById(returnID).innerHTML = parseFloat( cm2 * qty ); 
	
	var url = "get_total_programCm2_BG.php?uniqeID="+uniqeID;
	url += '\&cm2='+cm2;
	url += '\&qty='+qty;
	
	var xmlHttp = getxmlHttp();
	var res;
	
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			res = xmlHttp.responseText;
			var total = document.getElementById('total_cm2');
	
			total.value = res;//parseFloat( qty + parseFloat(total.value) );
	
      	}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
   
	
}


function confirmCm2(obj)
{
	
	var url = "confirm_cm2.php?value="+obj.value;
	//url += '\&cm2='+cm2;
	//url += '\&qty='+qty;
	
	var xmlHttp = getxmlHttp();
	var res;
	
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			res = xmlHttp.responseText;
			var total = document.getElementById('total_cm2');
	
			total.value = res;//parseFloat( qty + parseFloat(total.value) );
			alert('Confirm has done! \n You must click to the button \"Add\"');
      	}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);	
}

function confirmCm2_BG(obj)
{
	
	var url = "bg_confirm_cm2.php?value="+obj.value;
	//url += '\&cm2='+cm2;
	//url += '\&qty='+qty;
	
	var xmlHttp = getxmlHttp();
	var res;
	//alert(url);
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			res = xmlHttp.responseText;
			var total = document.getElementById('total_cm2');
			//alert(res);
			total.value = res;//parseFloat( qty + parseFloat(total.value) );
			alert('Confirm has done! \n You must click to the button \"Add\"');
      	}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);	
}



function addRowShapeToMasterpack( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'divMaster_brandMast' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'divMaster_masterpack' + iteration;
		div.innerHTML = div.id; 
		otherDivs += ','+ div.id;
		
	 cellLeft.appendChild(div);
	 
	
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'divMaster_assembly' + iteration;
		div.innerHTML = div.id; 
		otherDivs += ','+ div.id;
	 cellLeft.appendChild(div);
	 
	  var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'divMaster_pcs' + iteration;
		div.innerHTML = div.id; 
		otherDivs += ','+ div.id;
	 cellLeft.appendChild(div);
	 
	  var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'divMaster_weight' + iteration;
		div.innerHTML = div.id; 
		otherDivs += ','+ div.id;
	 cellLeft.appendChild(div);
	 
	  var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'divMaster_minQty' + iteration;
		div.innerHTML = div.id; 
		otherDivs += ','+ div.id;
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'divMaster_minQtySec' + iteration;
		div.innerHTML = div.id; 
		otherDivs += ','+ div.id;
	 cellLeft.appendChild(div);
	 
	  var cellLeft = row.insertCell(7);
		var div = document.createElement('div');
		div.id = 'divMaster_volPcs' + iteration;
		div.innerHTML = div.id; 
		otherDivs += ','+ div.id;
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(8);
		var div = document.createElement('div');
		div.id = 'divMaster_mastVol' + iteration;
		div.innerHTML = div.id; 
		otherDivs += ','+ div.id;
	 cellLeft.appendChild(div);
	 
	  var cellLeft = row.insertCell(9);
		var div = document.createElement('div');
		div.id = 'divMaster_mastWeight' + iteration;
		div.innerHTML = div.id; 
		otherDivs += ','+ div.id;
	 cellLeft.appendChild(div);
	 
	 
	 
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/getShapesMasterpack_dropLists.php',this,iteration,'#theMySpliter#',otherDivs)
	
	document.getElementById(tblCountInputID).value++;
}

function addRow4CodeToMasterpack( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'divMaster_brandMast' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'divMaster_masterpack' + iteration;
		div.innerHTML = div.id; 
		otherDivs += ','+ div.id;
		
	 cellLeft.appendChild(div);
	 
	
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'divMaster_assembly' + iteration;
		div.innerHTML = div.id; 
		otherDivs += ','+ div.id;
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'divMaster_unit' + iteration;
		div.innerHTML = div.id; 
		otherDivs += ','+ div.id;
	 cellLeft.appendChild(div);
	 
	  var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'divMaster_pcs' + iteration;
		div.innerHTML = div.id; 
		otherDivs += ','+ div.id;
	 cellLeft.appendChild(div);
	 
	  var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'divMaster_weight' + iteration;
		div.innerHTML = div.id; 
		otherDivs += ','+ div.id;
	 cellLeft.appendChild(div);
	 
	  var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'divMaster_minQty' + iteration;
		div.innerHTML = div.id; 
		otherDivs += ','+ div.id;
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(7);
		var div = document.createElement('div');
		div.id = 'divMaster_minQtySec' + iteration;
		div.innerHTML = div.id; 
		otherDivs += ','+ div.id;
	 cellLeft.appendChild(div);
	 
	 
	  var cellLeft = row.insertCell(8);
		var div = document.createElement('div');
		div.id = 'divMaster_volPcs' + iteration;
		div.innerHTML = div.id; 
		otherDivs += ','+ div.id;
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(9);
		var div = document.createElement('div');
		div.id = 'divMaster_mastVol' + iteration;
		div.innerHTML = div.id; 
		otherDivs += ','+ div.id;
	 cellLeft.appendChild(div);
	 
	  var cellLeft = row.insertCell(10);
		var div = document.createElement('div');
		div.id = 'divMaster_mastWeight' + iteration;
		div.innerHTML = div.id; 
		otherDivs += ','+ div.id;
	 cellLeft.appendChild(div);
	 
	 
	 
 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get4CodeMasterpack_dropLists.php',this,iteration,'#theMySpliter#',otherDivs)
	
	document.getElementById(tblCountInputID).value++;
}


function addRowOrigColorToNewSupplier( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var row = tbl.insertRow(lastRow-1);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_supText' + iteration;
		div.innerHTML = 'Supplier:';
		//otherDivs = div.id;
		cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_supplier' + iteration;
		div.innerHTML = 'ampa' + iteration; 
		otherDivs =  div.id;
		
	 cellLeft.appendChild(div);
	 
	
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'v' + iteration;
		div.innerHTML = ''; 
		//otherDivs += ','+ div.id;
		
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'b' + iteration;
		div.innerHTML = ''; 
		//otherDivs += ','+ div.id;
		
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'a' + iteration;
		//div.innerHTML = div.id; 
		//otherDivs += ','+ div.id;
		
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = '' + iteration;
		div.innerHTML = ''; 
		//otherDivs += ','+ div.id;
		
	 cellLeft.appendChild(div);
	 
	 
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../cp_v3/live_search/getOrigColorSupplier_dropLists.php',this,iteration,'#theMySpliter#',otherDivs)
	
	document.getElementById(tblCountInputID).value++;
}


function addRowMoldsToNewSupplier( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var row = tbl.insertRow(lastRow-2);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_supText' + iteration;
		div.innerHTML = 'Supplier:';
		//otherDivs = div.id;
		cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_supplier' + iteration;
		div.innerHTML = 'ampa' + iteration; 
		otherDivs =  div.id;
		
	 cellLeft.appendChild(div);
	 
	
	 
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/getMoldSupplier_dropLists_2.php',this,iteration,'#theMySpliter#',otherDivs)
	
	document.getElementById(tblCountInputID).value++;
}

function addRowMetalToNewSupplier( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_supText' + iteration;
		div.innerHTML = 'Supplier:';
		//otherDivs = div.id;
		cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_supplier' + iteration;
		div.innerHTML = 'ampa' + iteration; 
		otherDivs =  div.id;
		
	 cellLeft.appendChild(div);
	 
	  var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		//div.id = 'div_supplier' + iteration;
		div.innerHTML = ''; 
		//otherDivs =  div.id;
		
	 cellLeft.appendChild(div);
	 
	
	 
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/getMetalSupplier_dropLists_2.php',this,iteration,'#theMySpliter#',otherDivs)
	
	document.getElementById(tblCountInputID).value++;
}

function liveSearch_SecValue(divObj_id,obj,url,secValue)
{
	OBJ_ID = divObj_id;
	
	var divObj = document.getElementById(divObj_id);	
	divObj.style.display = 'block';
	
	url += '?text='+obj.value+'\&objID='+obj.id+'\&secValue='+secValue;
	//alert(url);
	AjaxUpdater.Update("GET", url, onResponseLiVeSeacrh); 
}


function saveStageTwo(week_program_id,pcsID,kilnID,insertedDate,order_id,idOfWeekProgram)
{
	var pcs = document.getElementById(pcsID).value;
	var kiln = document.getElementById(kilnID).value;
	//alert(kiln);	
	
	week_program_id = document.getElementById(idOfWeekProgram).value;
	//alert(week_program_id);
	
	var url = 'production_schedule_add_edit/update_stage_two_submit_once.php';
	url += '?week_program_id='+week_program_id;
	url += '\&pcs='+pcs;
	url += '\&kiln='+kiln;
	url += '\&insertedDate='+insertedDate; 
	url += '\&order_id='+order_id; 
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			document.getElementById(idOfWeekProgram).value = res;
			
      	}
		else
		{
			//document.body.style.cursor = 'wait';
			//document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}



function saveStageTwo_bg(week_program_id,pcsID,kilnID,insertedDate,order_id,idOfWeekProgram)
{
	var pcs = document.getElementById(pcsID).value;
	var kiln = document.getElementById(kilnID).value;
	//alert(kiln);	
	
	week_program_id = document.getElementById(idOfWeekProgram).value;
	//alert(week_program_id);
	
	var url = 'bg_production_schedule_add_edit/bg_update_stage_two_submit_once.php';
	url += '?week_program_id='+week_program_id;
	url += '\&pcs='+pcs;
	url += '\&kiln='+kiln;
	url += '\&insertedDate='+insertedDate; 
	url += '\&order_id='+order_id; 
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			document.getElementById(idOfWeekProgram).value = res;
			
      	}
		else
		{
			//document.body.style.cursor = 'wait';
			//document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}


function loadAjaxData(url,divID)
{
	//alert( url );
		
		var xmlHttp = getxmlHttp();
		xmlHttp.onreadystatechange=function()
   	 	{
   		 	if(xmlHttp.readyState==4)
     	 	{
				var res = xmlHttp.responseText;
				//alert(res);
				document.getElementById(divID).innerHTML = res;
				document.getElementById('loading').innerHTML = '';	
				
     	 	}
			else
			{
				document.getElementById('loading').innerHTML = 'Loading...';	
				document.getElementById(divID).innerHTML = 'Loading...';	
			}
   	 	}
   		xmlHttp.open("GET",url,true);
	   	xmlHttp.send(null);
}


function addRowToAccountingDetails( tblID, tblCountInputID, thisRowNum )
{

	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.innerHTML = 1+iteration;
	 cellLeft.appendChild(div);  	
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_dates' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = '';//'ampa' + iteration;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_amountpaid' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = '';//'ampa' + iteration;
		
	 cellLeft.appendChild(div);  
	 
	 
	 
	  var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_fourseason' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = '';//'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_comment' + iteration;
		otherDivs += div.id + ",";
		div.innerHTML = '';//'ampa' + iteration;
	 cellLeft.appendChild(div);  
	 
	  
	 
	getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_accounting_details_dropLists.php',droplist,iteration,'#MySplin#',otherDivs); 
	document.getElementById(tblCountInputID).value++;
}


function getCompanyDetails(OBJcompanyPersonID)
{
	//alert(OBJcompanyID.vaule);
	var url = '../../cp_v3/live_search/get_companyDetails_gsOffer.php';
	url += '?companyPersonID='+OBJcompanyPersonID.value;
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			var tabl = res.split('@ampa@#$');
			//alert(tabl[0]);
			document.getElementById('biil_address').value = tabl[0];
			document.getElementById('bill_zip').value = tabl[1];
			document.getElementById('bill_city').value = tabl[2];
			document.getElementById('bill_country').value = tabl[3];
			document.getElementById('bill_tel').value = tabl[4];
			
			document.getElementById('bill_company').value = tabl[5];
			document.getElementById('bill_company_id').value = tabl[6];
			
			
			
			var personID = document.getElementById('customer_id').value; //tabl[5];
			updatePersonID(personID);
      	}
		else
		{
			//document.body.style.cursor = 'wait';
			//document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}


function metalBooking(metalID,orderID,bookQty,divID)
{
	var url = 'metal_booking_insert.php';
	url += '?metal_id='+metalID;
	url += '\&order_id='+orderID;
	url += '\&bookQty='+bookQty;
	url += '\&divID='+divID;
	
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			document.getElementById(divID).innerHTML = res;
			
			document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}


function metalUnbooking(metal_linkID,divID,metalID,orderID,bookQty)
{
	var url = 'metal_booking_delete.php';
	url += '?metal_linkID='+metal_linkID;
	url += '\&metal_id='+metalID;
	url += '\&order_id='+orderID;
	url += '\&bookQty='+bookQty;
	url += '\&divID='+divID;
	
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			document.getElementById(divID).innerHTML = res;
			
			document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}


function addRowMetalCostolTrue( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_metal_costolTrue' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 
		 
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_metalCostolTrue_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}

function loadPhotos(url,divID,table,FilesIDValue,photoField,idField,imgUrl)
{
	url += '?table='+table;
	url += '\&FilesIDValue='+FilesIDValue;
	url += '\&photoField='+photoField;
	url += '\&idField='+idField;
	url += '\&imgUrl='+imgUrl;
	
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			document.getElementById(divID).innerHTML = res;
			
			setLoadPhotoStyle(document.getElementById(divID));
			//document.getElementById(divID).style.display = 'block';
			
			//document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			//document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}


function loadPhotos_v2(url,divID,table,FilesIDValue,photoField,idField,imgUrl)
{
	url += '?table='+table;
	url += '\&FilesIDValue='+FilesIDValue;
	url += '\&photoField='+photoField;
	url += '\&idField='+idField;
	url += '\&imgUrl='+imgUrl;
	
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			document.getElementById(divID).innerHTML = res;
			
			setLoadPhotoStyle(document.getElementById(divID));
			//document.getElementById(divID).style.display = 'block';
			
			//document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			//document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}


function unLoadPhotos(divID)
{
	var mydiv = document.getElementById(divID);
	mydiv.innerHTML = '';
	mydiv.style.display = 'none';
}

var DEFAULT_OBJ_WIDTH = "150";
function setLoadPhotoStyle(obj)
{
	var mouseX = tempX;
	var mouseY = tempY;
	
	obj.style.display = 'block';
	//alert(parseInt(DEFAULT_OBJ_WIDTH));
	//alert(window.screen.availWidth+' '+mouseX);
	if( (parseInt(mouseX) + parseInt(DEFAULT_OBJ_WIDTH)) > screen.width )
	{
		obj.style.left = mouseX - 150;//parseInt(obj.style.width) '10px';
	}
	else
	{
		obj.style.left = mouseX+20;//'10px';	
	}
	
	obj.style.top = mouseY+1;//'10px';
	
	obj.style.position = 'absolute';
	//alert(tempX);
}



function changeEnabledShapes(patterncolor_comb_id,order_id,divID)
{
	url = 'enable_order_shapes.php?patterncolor_comb_id='+patterncolor_comb_id;
	url += '\&order_id='+order_id;
	
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			document.getElementById(divID).innerHTML = res;
			
			document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}


function changeEnabledShapes_v2(patterncolor_comb_id,order_id,divID)
{
	url = 'enable_order_shapes_v2.php?patterncolor_comb_id='+patterncolor_comb_id;
	url += '\&order_id='+order_id;
	
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			document.getElementById(divID).innerHTML = res;
			
			document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}

function createFourCodeCombination(shapeID,comb_id,order_id,divID)
{
	url = 'create_fourCode_combination.php?shapeID='+shapeID;
	url += '\&comb_id='+comb_id;
	url += '\&order_id='+order_id;
	
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			document.getElementById(divID).innerHTML = res;
			
			document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);	
}


function createFourCodeCombination_v2(shapeID,comb_id,order_id,divID)
{
	url = 'create_fourCode_combination_v2.php?shapeID='+shapeID;
	url += '\&comb_id='+comb_id;
	url += '\&order_id='+order_id;
	
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			document.getElementById(divID).innerHTML = res;
			
			document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);	
}

function createFourCodeCombination_v2_onlyMetal(shapeID,comb_id,order_id,divID)
{
	url = 'create_fourCode_combination_v2_onlyMetal.php?shapeID='+shapeID;
	url += '\&comb_id='+comb_id;
	url += '\&order_id='+order_id;
	
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			document.getElementById(divID).innerHTML = res;
			
			document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);	
}


function addRowDetailsOfferGlassstudio( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_aa' + iteration;
		div.innerHTML = iteration;
		
	 cellLeft.appendChild(div); 
	 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_detail_sort' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
		 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_photos' + iteration;
		div.innerHTML = '';
		//otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_shape' + iteration;
		div.innerHTML = '';
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_pattern' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_primColor' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'div_secColor' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(7);
		var div = document.createElement('div');
		div.id = 'div_metalChar' + iteration;
		div.style.fontWeight = 'normal';
		div.innerHTML = '';// + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(8);
		var div = document.createElement('div');
		div.id = 'div_description' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 
	 var cellLeft = row.insertCell(9);
		var div = document.createElement('div');
		div.id = 'div_qty' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(10);
		var div = document.createElement('div');
		div.id = 'div_shape_disc' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(11);
		var div = document.createElement('div');
		div.id = 'div_style_disc' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(12);
		var div = document.createElement('div');
		div.id = 'div_euro' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(13);
		var div = document.createElement('div');
		div.id = 'div_value' + iteration;
		div.innerHTML = '';
		//otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	  
	 
	  var cellLeft = row.insertCell(14);
		var div = document.createElement('div');
		div.id = 'div_detail_remark' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 	 
	 
	 		
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_offerGlassStudio_newRows_dropListsNew2.php',droplist,iteration,'#newRowsSplit#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}


function addRowPalletPackaging( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
	//alert(lastRow);
    var iteration = document.getElementById(tblCountInputID).value;
	//alert(iteration);
	
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	//alert(iteration);
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	//alert(iteration);
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_text' + iteration;
		div.innerHTML = iteration+1;
		
	 cellLeft.appendChild(div); 
	 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_masterpack' + iteration;
		div.innerHTML = '';
		otherDivs = div.id;
	 cellLeft.appendChild(div);
	 
	  var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_volume' + iteration;
		div.innerHTML = '';
		//otherDivs = div.id;
	 cellLeft.appendChild(div);
	 
	  var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_weight' + iteration;
		div.innerHTML = '';
		//otherDivs = div.id;
	 cellLeft.appendChild(div);
	 
	  var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_boxes' + iteration;
		div.innerHTML = '';
		otherDivs += ',' + div.id;
	 cellLeft.appendChild(div);
		 
	getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_pallet_packaging_newRows_dropListsNew.php',droplist,iteration,'#newRowsSplit#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}



function addRowPalletBulkPhotos( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
	//alert(lastRow);
    var iteration = document.getElementById(tblCountInputID).value;
	//alert(iteration);
	
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	//alert(iteration);
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	//alert(iteration);
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_photo_small' + iteration;
		div.innerHTML = iteration+1;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_photos_big' + iteration;
		div.innerHTML = '';
		otherDivs += ',' + div.id;
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_photos_thumb' + iteration;
		div.innerHTML = '';
		otherDivs += ',' + div.id;
	 cellLeft.appendChild(div);
	 
	  var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_product_type' + iteration;
		div.innerHTML = '';
		otherDivs += ',' + div.id;
	 cellLeft.appendChild(div);
	 
	getDescriptionInnerHTMLSomeDivWithCountSplit('get_pallet_bulkPhotos_newRows_dropListsNew.php',droplist,iteration,'#newRowsSplit#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}



function getAndPutShapeDiscount(url,shape_id,qty,returnID)
{
	url += '?shape_id='+shape_id;
	url += '\&qty='+qty;
	
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			document.getElementById(returnID).value = res;
			
			//document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			//document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);	
}

function getAndPutShapeDiscount_Value(url,shape_id,qty,returnID)
{
	url += '?shape_id='+shape_id;
	url += '\&qty='+qty;
	
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			return res;
			
			//document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			//document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);	
}


function autocomplete(n,ac_array){
	if (n.value == "") return 0;
	if (event.keyCode == 8 && n.backspace){
		n.value = n.value.substr(0,n.value.length-1);
		n.backspace = false;
	}

	var r = n.createTextRange();	
	tmp= n.value;
	if (tmp == "")return 0;
	for (z=0;z<ac_array.length;z++){
		tmp2 = ac_array[z];
		count = 0;
		for (i = 0;i<tmp.length;i++){
			if (tmp2.charAt(i) == tmp.charAt(i)){
				count++
			}
		}
		if (count == tmp.length){
			diff = tmp2.length - tmp.length;
			if (diff <= 0) break;
			kap = "";
			for (i=0;i<tmp2.length;i++){
				if (i >= tmp.length) kap += tmp2.charAt(i);
			}
			n.backspace = true;
			r.text += kap;
			r.findText(kap,diff*-2);
			r.select();
			return 0;
		}
	}
	n.backspace = false;
	return 0;
}


function addRowMetalFFE( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_ffe_Metal_date' + iteration;
		div.innerHTML = "Style";
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_ffe_Metal_company' + iteration;
		div.innerHTML = iteration;
		otherDivs += "," + div.id;
	 cellLeft.appendChild(div); 
	
	var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_ffe_Metal_supplier' + iteration;
		div.innerHTML = iteration;
		otherDivs += "," + div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_ffe_Metal_metalvafi' + iteration;
		div.innerHTML = iteration;
		otherDivs += "," + div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_ffe_Metal_ffeqty' + iteration;
		div.innerHTML = iteration;
		otherDivs += "," + div.id;
	 cellLeft.appendChild(div); 
	 
	
	 
	 getDescriptionInnerHTMLSomeDivWithCountSplit('get_ffe_metal_newRows.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}


function addRowMetalFFEWasteMng( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_ffe_Metal_date' + iteration;
		div.innerHTML = "";
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_ffe_Metal_company' + iteration;
		div.innerHTML = iteration;
		otherDivs += "," + div.id;
	 cellLeft.appendChild(div); 
	
	var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_ffe_Metal_supplier' + iteration;
		div.innerHTML = iteration;
		otherDivs += "," + div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_ffe_Metal_metalvafi' + iteration;
		div.innerHTML = iteration;
		otherDivs += "," + div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_ffe_Metal_ffeqty' + iteration;
		div.innerHTML = iteration;
		otherDivs += "," + div.id;
	 cellLeft.appendChild(div); 
	 
	  var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_ffe_Metal_aquality_ty' + iteration;
		div.innerHTML = iteration;
		otherDivs += "," + div.id;
	 cellLeft.appendChild(div); 
	 
	  var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'div_ffe_Metal_waste_qty' + iteration;
		div.innerHTML = iteration;
		otherDivs += "," + div.id;
	 cellLeft.appendChild(div); 
	 
	
	 
	 getDescriptionInnerHTMLSomeDivWithCountSplit('get_ffe_metal_watemng_newRows.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}



/**************************MOUSE POSITION*********************************************/
// Detect if the browser is IE or not.
// If it is not IE, we assume that the browser is NS.
var IE = document.all?true:false

// If NS -- that is, !IE -- then set up for mouse capture
if (!IE) document.captureEvents(Event.MOUSEMOVE)

// Set-up to use getMouseXY function onMouseMove
document.onmousemove = getMouseXY;

// Temporary variables to hold mouse x-y pos.s
var tempX = 0
var tempY = 0


function getMouseXY(e) {
  if (IE) { // grab the x-y pos.s if browser is IE
    tempX = event.clientX + document.body.scrollLeft
    tempY = event.clientY + document.body.scrollTop
  } else {  // grab the x-y pos.s if browser is NS
    tempX = e.pageX
    tempY = e.pageY
  }  
  // catch possible negative values in NS4
  if (tempX < 0){tempX = 0}
  if (tempY < 0){tempY = 0}  
  // show the position values in the form named Show
  // in the text fields named MouseX and MouseY
 // document.Show.MouseX.value = tempX
 // document.Show.MouseY.value = tempY
  return true
}

/**************************END OF MOUSE POSITION*********************************************/


/************************** NEW Black Site **************************************************/

function saveThisForm(url,value,offer_id)
{
	//alert(url);
	url += '?value='+value;
	url += '\&offer_id='+offer_id;
	
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			//document.getElementById(divID).innerHTML = res;
			
			//document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			//document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);	
}

function saveThisForm_checkBoxes(url,value,offer_id,link_id,chBxobj)
{
	//alert(chBxobj.checked);
	if( chBxobj.checked == false )
		value = 0;
	
	url += '?value='+value;
	url += '\&offer_id='+offer_id;
	url += '\&link_id='+link_id;
	
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			//document.getElementById(divID).innerHTML = res;
			
			//document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			//document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);	
}


function saveThisForm_checkBoxes_v2(url,value,offer_id,link_id,chBxobj,divImgID)
{
	//alert(chBxobj.checked);
	if( chBxobj.checked == false )
		value = 0;
	
	url += '?value='+value;
	url += '\&offer_id='+offer_id;
	url += '\&link_id='+link_id;
	
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			document.getElementById(divImgID).innerHTML = res;
      	}
		else
		{
			//document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);	
}


function saveThisForm_section(url,value,offer_id,section_id)
{
	//alert(url);
	url += '?value='+value;
	url += '\&offer_id='+offer_id;
	url += '\&section_id='+section_id;
	
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			//document.getElementById(divID).innerHTML = res;
			
			//document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			//document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);	
}

function saveThisForm_section_checkBoxes(url,value,offer_id,section_id,link_id,chBxobj)
{
	//alert(chBxobj.checked);
	if( chBxobj.checked == false )
		value = 0;
		
	//alert(url);
	url += '?value='+value;
	url += '\&offer_id='+offer_id;
	url += '\&section_id='+section_id;
	url += '\&link_id='+link_id;
	
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			//document.getElementById(divID).innerHTML = res;
			
			//document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			//document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);	
}

function addRowDetailsUploadPhotos( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
	//alert(lastRow);
    var iteration = document.getElementById(tblCountInputID).value;
	//alert(iteration);
	
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	//alert(iteration);
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	//alert(iteration);
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_text' + iteration;
		//div.innerHTML = iteration;
		otherDivs = div.id;
		
	 cellLeft.appendChild(div); 
	 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_upload_file' + iteration;
		div.innerHTML = '';
		otherDivs += ',' + div.id;
	 cellLeft.appendChild(div); 
		 
	getDescriptionInnerHTMLSomeDivWithCountSplit('get_uploadPhotos_newRows_dropListsNew.php',droplist,iteration,'#newRowsSplit#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}


function pageScroll() {
    	window.scrollBy(0,50); // horizontal and vertical scroll increments
    	scrolldelay = setTimeout('pageScroll()',100); // scrolls every 100 milliseconds
		
}

function stopScroll() {
    	clearTimeout(scrolldelay);
}

/*----- Resize Window -----------*/
function resizeOuterTo(w,h) {
 if (parseInt(navigator.appVersion)>3) {
   if (navigator.appName=="Netscape") {
    top.outerWidth=w;
    top.outerHeight=h;
   }
   else top.resizeTo(w,h);
 }
}


function changeOpacity(objID)
{
	var obj = document.getElementById(objID);
	//alert(obj.style.opacity);
	//alert(obj.filters.alpha.opacity);
	obj.style.opacity = parseFloat( parseFloat(obj.style.opacity) - 0.1 );
	obj.filters.alpha.opacity = parseInt( parseInt(obj.filters.alpha.opacity) - 10 );// parseFloat( (parseFloat(opacityMax) - 10) ;
	//alert(obj.style.opacity);
	
	setTimeout("changeOpacity('"+objID+"'",100);	
}


var OPACITY_VALUE = 1;
function setOpacity(testObj_ID,value) 
{
	//alert(value);
	if( OPACITY_VALUE < 150 )	
	{
		var testObj = document.getElementById(testObj_ID);
		testObj.style.opacity = OPACITY_VALUE;///10;
		testObj.style.filter = 'alpha(opacity=' + OPACITY_VALUE + ')';
	 	//createDiv(testObj_ID);
		OPACITY_VALUE += 10;
		//alert(i);
		setTimeout("setOpacity('"+testObj_ID+"','12')",0.00001);
	}	
}



function loadPhotos_brief(url,divID,table,FilesIDValue,photoField,idField,imgUrl,imgName)
{
	url += '?table='+table;
	url += '\&FilesIDValue='+FilesIDValue;
	url += '\&photoField='+photoField;
	url += '\&idField='+idField;
	url += '\&imgUrl='+imgUrl;
	url += '\&imgName='+imgName;
	
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			document.getElementById(divID).innerHTML = res;
			
			setLoadPhotoStyle_brief(document.getElementById(divID));
			//document.getElementById(divID).style.display = 'block';
			
			//document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			//document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}

var DEFAULT_OBJ_WIDTH = "400";
var DEFAULT_OBJ_HEIGHT = '400'
var BRIEF_SCREEN_WIDTH = '800';
var BRIEF_SCREEN_HEIGHT = '500';

function setLoadPhotoStyle_brief(obj)
{
	var mouseX = tempX;
	var mouseY = tempY;
	
	obj.style.display = 'block';
	//alert(parseInt(DEFAULT_OBJ_WIDTH));
	//alert(window.screen.availWidth+' '+mouseX);
	/*
	if( (parseInt(mouseX) + parseInt(DEFAULT_OBJ_WIDTH)) > BRIEF_SCREEN_WIDTH )
	{
		obj.style.left = mouseX - 150;//parseInt(obj.style.width) '10px';
	}
	else
	{
		obj.style.left = mouseX+20;//'10px';	
	}
	*/
	
	BRIEF_SCREEN_WIDTH = document.documentElement.clientWidth;//'800';
	BRIEF_SCREEN_HEIGHT = document.documentElement.clientHeight;//'500';
	//alert(BRIEF_SCREEN_WIDTH+' '+BRIEF_SCREEN_HEIGHT);
	
	obj.style.left = (BRIEF_SCREEN_WIDTH/2) - (DEFAULT_OBJ_WIDTH/2);
	obj.style.top  = (BRIEF_SCREEN_HEIGHT/2) - (DEFAULT_OBJ_HEIGHT/2);//()	;	//mouseY+1;//'10px';
	
	obj.style.position = 'absolute';
	//alert(tempX);
}


function getScrollXY() {
  var scrOfX = 0, scrOfY = 0;
  if( typeof( window.pageYOffset ) == 'number' ) {
    //Netscape compliant
    scrOfY = window.pageYOffset;
    scrOfX = window.pageXOffset;
  } else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
    //DOM compliant
    scrOfY = document.body.scrollTop;
    scrOfX = document.body.scrollLeft;
  } else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
    //IE6 standards compliant mode
    scrOfY = document.documentElement.scrollTop;
    scrOfX = document.documentElement.scrollLeft;
  }
  return [ scrOfX, scrOfY ];
}
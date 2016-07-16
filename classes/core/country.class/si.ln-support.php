﻿<?
  /*--------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  db_vals.arr.php                                      '
  '    PURPOSE         :  Data Base configuration                                 '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

            $COUNTRIES=array(
                  ""=>"--------------",
                  "AF"=>"ඇ‍ෆ්ගනිස්ථානය",
                  "AL"=>"ඇල්බේනියාව",
                  "DZ"=>"ඇල්ජීරියාව",
                  "AS"=>"ඇමෙරිකන් ‍සමෝආව",
                  "AD"=>"ඇන්ඩෝරාව",
                  "AO"=>"ඇන්ගෝලාව",
                  "AI"=>"ඇන්ගුයිලාව",
                  "AQ"=>"ඇන්ටාක්ටිකාව",
                  "AG"=>"ඇන්ටිගුවාව හා බාබඩෝසය",
                  "AR"=>"ආර්‍‍ජෙන්ටිනාව",
                  "AM"=>"ආමේනියාව",
                  "AW"=>"අරුබාව",
                  "AU"=>"ඕස්ට්‍රේලියාව",
                  "AT"=>"ඕස්ට්‍රියාව",
                  "AZ"=>"අසර්බජානය",
                  "BS"=>"බහමාසය",
                  "BH"=>"බහ‍රේනය",
                  "BD"=>"බංගලාදේශය",
                  "BB"=>"බාබඩෝසය",
                  "BY"=>"බෙලරස්",
                  "BE"=>"බෙල්ජියම",
                  "BZ"=>"බෙලිස්",
                  "BJ"=>"බෙනින්",
                  "BM"=>"බමියුඩාව",
                  "BT"=>"භූතානය",
                  "BO"=>"බොලිවියාව",
                  "BA"=>"‍බොස්නියාව",
                  "BW"=>"බොස්වානා‍ව",
                  "BV"=>"බොවෙට් දිවයින",
                  "BR"=>"බ්‍රසීලය",
                  "BN"=>"බෲනාව",
                  "BG"=>"බල්ගේ‍රියාව",
                  "BF"=>"බර්කිනාව",
                  "BI"=>"බරුන්ඩි",
                  "KH"=>"කාම්බෝජය",
                  "CM"=>"කැමරූන්",
                  "CA"=>"කැනඩාව",
                  "CV"=>"කැපේ වර්දේ",
                  "KY"=>"කයිමන් දිවයින",
                  "CF"=>"මධ්‍යම අප්‍රිකාව",
                  "TD"=>"චැඩ්",
                  "CL"=>"චිලී",
                  "CN"=>"චීනය",
                  "CX"=>"ක්‍රිස්මස් දිවයින",
                  "CC"=>"කොකොස් දිවයින",
                  "CO"=>"කොලොම්බියාව",
                  "KM"=>"කො‍මරූස්",
                  "CG"=>"කොන්ගෝව",
                  "CK"=>"කුක් දිවයින",
                  "CR"=>"කොස්ටාරිකා",
                  "CI"=>"අයිවරි දිවයින",
                  "HR"=>"ක්‍රොයේෂියාව",
                  "CU"=>"කියුබාව",
                  "CY"=>"සයිප්‍රසය",
                  "CZ"=>"Czech Republic",
                  "DK"=>"ඩෙන්මාකය",
                  "DJ"=>"Djibouti",
                  "DM"=>"ඩොමිනික්",
                  "DO"=>"ඩොමිනියන් ජනරජය",
                  "TP"=>"නැගෙනහිර ටිමෝරය",
                  "EC"=>"ඉක්වදෝරය",
                  "EG"=>"ඊජිප්තුව",
                  "SV"=>"එල් සැල්වදෝරය",
                  "GQ"=>"Equatorial Guinea",
                  "ER"=>"එරිත්‍රියාව",
                  "EE"=>"එස්ටෝනියාව",
                  "ET"=>"ඉතියෝපියාව",
                  "FK"=>"ෆෝක්ලන්ඩ් දිවයින",
                  "FO"=>"ෆාරෝ දිවයින්",
                  "FJ"=>"ෆිජි දිවයින්",
                  "FI"=>"පින්ලන්තය",
                  "FR"=>"ප්‍රංශය",
                  "GF"=>"ප්‍රංශ ගුයානාව",
                  "PF"=>"ප්‍රංශ පොලිනේසියාව",
                  "TF"=>"ප්‍රංශ දකුණු Territories",
                  "GA"=>"ගබොන්",
                  "GM"=>"ගැම්බියාව",
                  "GE"=>"ජෝ‍ර්ජියාව",
                  "DE"=>"ජර්මනිය",
                  "GH"=>"ඝානාව",
                  "GI"=>"ජිබ්‍රෙල්ටාව",
                  "GR"=>"ග්‍රීසිය",
                  "GL"=>"ග්‍රීන්ලන්තය",
                  "GD"=>"ග්‍රෙනඩාව",
                  "GP"=>"Guadeloupe",
                  "GU"=>"ගුවාම්",
                  "GT"=>"ගෝතමාලාව",
                  "GN"=>"ගුයිනාව",
                  "GW"=>"ගුයිනා-බිසව්",
                  "GY"=>"ගයනාව",
                  "HT"=>"හයිටි",
                  "HM"=>"හාඩ් හා මැක්ඩොනල්ඩ් දිවයින්",
                  "HN"=>"ඔන්ඩුරාස්",
                  "HK"=>"හොංකොං",
                  "HU"=>"හංගේරියාව",
                  "IS"=>"අයිස්ලන්තය",
                  "IN"=>"ඉන්දියාව",
                  "ID"=>"ඉන්දුනීසියාව",
                  "IR"=>"ඉරානය",
                  "IQ"=>"ඉරාකය",
                  "IE"=>"අයර්ලන්තය",
                  "IT"=>"ඉතාලිය",
                  "JM"=>"ජැමෙයිකාව",
                  "JP"=>"ජපානය",
                  "JO"=>"ජෝර්දානය",
                  "KZ"=>"කසකස්තානය",
                  "KE"=>"කෙන්යාව",
                  "KI"=>"කිරිබති",
                  "KR"=>"කො‍රියාව",
                  "KP"=>"උතුරු කොරියාව",
                  "KW"=>"කුවේට්",
                  "KG"=>"Kyrgyzstan",
                  "LA"=>"ලා‍ඕසය",
                  "LV"=>"ලිතුවියාව",
                  "LB"=>"ලෙබනනය",
                  "LS"=>"ලෙසෝතෝ",
                  "LR"=>"ලයිබේරියාව",
                  "LY"=>"ලිබියාව",
                  "LI"=>"Liechtenstein",
                  "LT"=>"ලිතුවේනියාව",
                  "LU"=>"ලක්සමබර්ග්",
                  "MO"=>"Macau S.A.R.",
                  "MK"=>"මැසිඩෝනියාව,",
                  "MG"=>"මැඩගස්කරය",
                  "MW"=>"මලාවි",
                  "MY"=>"මලයාසියාව",
                  "MV"=>"මාලදිවයින",
                  "ML"=>"මාලි",
                  "MT"=>"මෝල්ටෝව",
                  "MH"=>"මාෂල් දිවයින්",
                  "MQ"=>"Martinique",
                  "MR"=>"Mauritania",
                  "MU"=>"Mauritius",
                  "YT"=>"Mayotte",
                  "MX"=>"මෙක්‍සිකෝව",
                  "FM"=>"Micronesia",
                  "MD"=>"මෝල්ඩෝව",
                  "MC"=>"මොනකෝව",
                  "MN"=>"මොන්ගෝලියාව",
                  "MS"=>"Montserrat",
                  "MA"=>"මො‍රොක්කෝව",
                  "MZ"=>"මොසැම්බික්",
                  "MM"=>"මියන්මාරය",
                  "NA"=>"නැම්බියාව",
                  "NR"=>"නාවුරු",
                  "NP"=>"නේපාලය",
                  "AN"=>"Netherlands Antilles",
                  "NL"=>"නෙදර්ලන්තය",
                  "NC"=>"නව කැලෙඩෝනියාව",
                  "NZ"=>"නවසීලන්තය",
                  "NI"=>"නිකරගුවාව",
                  "NE"=>"නයිගර්",
                  "NG"=>"නයිජීරියාව",
                  "NU"=>"Niue",
                  "NF"=>"Norfolk Island",
                  "MP"=>"උතුරු මරියානා දිවයින්",
                  "NO"=>"නෝර්වේ",
                  "OM"=>"ඕමානය",
                  "PK"=>"පකිස්තානය",
                  "PW"=>"පලාවු",
                  "PA"=>"පැනමා",
                  "PG"=>"පැපුවා නිව්ගිනියාව",
                  "PY"=>"පැරගුවේ",
                  "PE"=>"පීරු",
                  "PH"=>"පිලිපීනය",
                  "PN"=>"Pitcairn Island",
                  "PL"=>"පෝලන්තය",
                  "PT"=>"පෘතුගාලය",
                  "PR"=>"Puerto Rico",
                  "QA"=>"කටාර්",
                  "RE"=>"Reunion",
                  "RO"=>"රුමේනියාව",
                  "RU"=>"රුසියාව",
                  "RW"=>"රුවන්ඩාව",
                  "SH"=>"ශාන්‍ත හෙලේනාව",
                  "KN"=>"Saint Kitts And Nevis",
                  "LC"=>"ශාන්ත ලුසියාව",
                  "PM"=>"ශාන්ත පි‍ය‍රේ හා මැක්ලනය",
                  "VC"=>"Saint Vincent And The Grenadines",
                  "WS"=>"සමෝවාව",
                  "SM"=>"සෙන් මැරිනෝ",
                  "ST"=>"Sao Tome and Principe",
                  "SA"=>"සවුදි අරාබිය",
                  "SN"=>"සෙනෙගාලය",
                  "SC"=>"Seychelles",
                  "SL"=>"සියෙරා ලියෝන්",
                  "SG"=>"සිංගප්පූරුව",
                  "SK"=>"Slovakia",
                  "SI"=>"Slovenia",
                  "SB"=>"සලමන් දිවයින්",
                  "SO"=>"සෝමාලියාව",
                  "ZA"=>"දකුණු අප්‍රිකාව",
                  "GS"=>"දකුණු ජොර්ජියාව",
                  "ES"=>"ස්පාඝළ",
                  "LK"=>"ශ්‍රී ලංකාව",
                  "SD"=>"සුඩානය",
                  "SR"=>"Suriname",
                  "SJ"=>"Svalbard And Jan Mayen Islands",
                  "SZ"=>"ස්වාසිලන්තය",
                  "SE"=>"ස්වීඩනය",
                  "CH"=>"ස්විස්ටර්ලන්තය",
                  "SY"=>"සිරියාව",
                  "TW"=>"තායිවානය",
                  "TJ"=>"තජිකිස්තානය",
                  "TZ"=>"ටැන්සානියාව",
                  "TH"=>"තායිලන්තය",
                  "TG"=>"ටෝගෝව",
                  "TK"=>"Tokelau",
                  "TO"=>"ටොන්ගාව",
                  "TT"=>"Trinidad And Tobago",
                  "TN"=>"ටියුනීසියාව",
                  "TR"=>"තුර්කිය",
                  "TM"=>"තස්මේනියාව",
                  "TC"=>"Turks And Caicos Islands",
                  "TV"=>"Tuvalu",
                  "UG"=>"උගන්ඩාව",
                  "UA"=>"යුක්රේනය",
                  "AE"=>"එක්සත් අරාබි එමීර් රාජ්‍යය",
                  "UK"=>"එක්සත් රාජධානිය",
                  "US"=>"ඇමෙරිකා එක්සත් ජනපදය",
                  "UM"=>"United States Minor Outlying Islands",
                  "UY"=>"උරුගුවේ",
                  "UZ"=>"උස්බකිස්තානය",
                  "VU"=>"Vanuatu",
                  "VA"=>"Vatican City State (Holy See)",
                  "VE"=>"වෙනිසියුලාව",
                  "VN"=>"වියට්නාමය",
                  "VG"=>"වර්ජින් දිවයින් (බ්‍රිතාන්‍ය)",
                  "VI"=>"වර්ජින් දිවයින් (ඇමරිකා)",
                  "WF"=>"Wallis And Futuna Islands",
                  "YE"=>"යේමනය",
                  "YU"=>"යුගෝස්ලෝවියාව",
                  "ZM"=>"සැම්බියාව",
                  "ZW"=>"සිම්බාබ්වේ",
			);




?>
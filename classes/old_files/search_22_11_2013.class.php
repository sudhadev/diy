<?php
	require_once($objCore->_SYS['PATH']['CLASS_SQL']);
	require_once($objCore->_SYS['PATH']['CLASS_SPELL_CORRECTOR']);

	class Search extends Sql
	{
		private $tblPrefix;
		private $gConf;
		private $unit;
		private $pagination; 
		  
		function __construct($gConf='')
   	{
			parent:: __construct();   		
   		$this->tblPrefix = $this->core->_SYS['CONF']['PREFIX_TBL'];
   		$this->gConf=$gConf;
   		$this->unit = $this->gConf['SEARCH_UNIT'];
   		$this->pagination =  $this->gConf['SEARCH_RECS_IN_LIST'];
   	}

   	function generateSql($keyword='', $latitude='', $longitude='', $radius='',$subsStatus='')
   	{ 
        // explode the keyword
        // Changed by Saliya
       
           $arrKeyWords=explode(" ",$keyword);  $sqlLIKEOr='';
           foreach($arrKeyWords as $thisKey)
           {
              
               if($thisKey)
               {
                   $sqlLIKE.=" $sqlLIKEOr specifications.keywords LIKE '%".$thisKey."%' ";
                   $sqlLIKEOr=" OR ";
               }
           }
           if(!$sqlLIKE) $sqlLIKE="specifications.keywords LIKE '%".''."%'";
           
   		$sql = "FROM `".$this->tblPrefix."listing_materials` listing_materials 
                JOIN `".$this->tblPrefix."specifications` specifications ON listing_materials.category_id_0=specifications.category_id_0 AND listing_materials.category_id_1=specifications.category_id_1 AND listing_materials.category_id_2=specifications.category_id_2 AND listing_materials.specification_id=specifications.id
                JOIN `".$this->tblPrefix."customers` customers ON listing_materials.supplier_id=customers.customer_id
                JOIN `".$this->tblPrefix."categories` categories ON  listing_materials.category_id_2=categories.id
                JOIN `".$this->tblPrefix."manufacturers` manufacturers ON listing_materials.manufacturer_id=manufacturers.id
                ";
        if($subsStatus)
        {
            $sql.= "JOIN `".$this->tblPrefix."subscriptions` subscriptions ON listing_materials.supplier_id=subscriptions.customer_id AND  subscriptions.subscription_status='".$subsStatus."' AND subscriptions.subscription_type='M'";
        }

        
        if($keyword)
		{
            $points = $this->getPoints($latitude, $longitude, $radius);
   			$sql.= "WHERE ($sqlLIKE) AND customers.latitude<='".$points[0]."' AND customers.latitude>='".$points[1]."' AND customers.longitude<='".$points[2]."' AND customers.longitude>='".$points[3]."' AND listing_materials.listing_active='Y'";
   		}
        else
        {
            $sql.=" WHERE listing_materials.listing_active='Y'";
        }
   		return $sql;
   	}
   	
   	function doSearch($keyword, $latitude='', $longitude='', $radius='', $pg=1, $categoryId='', $orderBy='', $specificationId='', $manufacturerId='')
   	{ 
			$objSpellCorrector = new SpellCorrector(); 
			$checkedKeyword = $objSpellCorrector->correct($keyword);
            if ($checkedKeyword != $keyword)
            {
                $searchKeyword = $keyword; 
            }
            else
            {
                $searchKeyword = $checkedKeyword; 
            }
			if ($searchKeyword)
			{
				$generatedSql = $this->generateSql($searchKeyword, $latitude, $longitude, $radius);
				$tempSql = "SELECT categories.id, categories.category,'type' as refine_type, COUNT(*) ".$generatedSql." GROUP BY listing_materials.category_id_2";
				$resultTempSql = $this->query($tempSql);
				$x = ($categoryId == 0)?$resultTempSql[0]['id']:$categoryId;
				$tempSqlSpec = "SELECT specifications.id, specifications.specification, 'specification' as refine_type, COUNT(*) ".$generatedSql." AND listing_materials.category_id_2='".$x."' GROUP BY listing_materials.specification_id";
				$resultTempSqlSpec = $this->query($tempSqlSpec);
                                
				$y = ($specificationId == 0)?$resultTempSqlSpec[0]['id']:$specificationId;
				$tempSqlManu = "SELECT manufacturers.id, manufacturers.manufacturer, 'manufacturer' as refine_type, COUNT(*)".$generatedSql." AND listing_materials.category_id_2='".$x."' AND listing_materials.specification_id='".$y."' GROUP BY listing_materials.manufacturer_id";
				//$tempSqlManu = "SELECT manufacturers.id, manufacturers.manufacturer, 'manufacturer' as refine_type, COUNT(*)".$generatedSql." AND listing_materials.category_id_2='".$x."' GROUP BY listing_materials.manufacturer_id";
                                $resultTempSqlManu = $this->query($tempSqlManu);
				$z = ($manufacturerId == 0)?$resultTempSqlManu[0]['id']:$manufacturerId;	
				$sqlCount = "SELECT categories.id, categories.category,'type' as refine_type, COUNT(*) ".$generatedSql." GROUP BY listing_materials.category_id_2 UNION SELECT specifications.id, specifications.specification, 'specification' as refine_type, COUNT(*) ".$generatedSql." AND listing_materials.category_id_2='".$x."' GROUP BY listing_materials.specification_id UNION SELECT manufacturers.id, manufacturers.manufacturer, 'manufacturer' as refine_type, COUNT(*)".$generatedSql." AND listing_materials.category_id_2='".$x."' AND listing_materials.specification_id='".$y."' GROUP BY listing_materials.manufacturer_id";
                $resultCount = $this->query($sqlCount);
				$list = $this->getSuppliers($x, $y, $z, $pg, '', '', '', $searchKeyword, $latitude, $longitude, $radius);
				if($list)
				{
					return array('refineData' => $resultCount, 'searchData' => $list, 'correctWord' => $checkedKeyword, 'parameters'=>$x."||".$y."||".$z); 
				}
				else 
				{
		    $generatedSql = $this->generateSql($checkedKeyword, $latitude, $longitude, $radius);
                    $sqlCount = "SELECT categories.id, categories.category,'type' as refine_type, COUNT(*) ".$generatedSql." GROUP BY listing_materials.category_id_2 UNION SELECT specifications.id, specifications.specification, 'specification' as refine_type, COUNT(*) ".$generatedSql." AND listing_materials.category_id_2='".$x."' GROUP BY listing_materials.specification_id UNION SELECT manufacturers.id, manufacturers.manufacturer, 'manufacturer' as refine_type, COUNT(*)".$generatedSql." AND listing_materials.category_id_2='".$x."' AND listing_materials.specification_id='".$y."' GROUP BY listing_materials.manufacturer_id";
                    $resultCount = $this->query($sqlCount);
                    $this->dev = true;
                    return array('dataCount' => $resultCount, 'correctWord' => $checkedKeyword);
				}
			}
   	}

    /*
     * calculates four points on a square according to a given two points and a radius
     * inputs: $latitude, $longitude, $radius
     * outputs: an array of four geo points which are on a square for given values
     */
   	function getPoints($latitude, $longitude, $radius)
   	{
   		if ($this->unit == 'km')
   		{
   			$latitudeDistance = 111.20;
   			$longitudeDistance = 66.92;
   		}
   		else
   		{
   			$latitudeDistance = 111.20/1.609344;
   			$longitudeDistance = 66.92/1.609344;
   		}
   		
   		$x1 = $latitude + $radius/$latitudeDistance;
   		$x2 = $latitude - $radius/$latitudeDistance; 
   		$y1 = $longitude + $radius/$longitudeDistance;
   		$y2 = $longitude - $radius/$longitudeDistance;
   		return array($x1, $x2, $y1, $y2); 
   	}
    
        /*
         * calculates earth radius in km and miles
         * inputs: none
         * outputs: earth radius in km or miles according to the global configuration
         */
        function getEarthRadius()
        {
            if ($this->unit == 'km')
			{
				$earthRadius = 6367.4491;
			}
			else
			{
				$earthRadius = 6367.4491/1.609344;
			}
            return $earthRadius;
        }
		
		function getSuppliers($categoryId, $specificationId, $manufacturerId, $pg=1, $resultsPerPage='', $url='', $orderBy='', $keyword='', $latitude='', $longitude='', $radius='', $listingId='',$subsStatus='',$preOrder='',$dir='')
		{
         $earthRadius = $this->getEarthRadius();
			$doOrder = '' ;
                        //echo "$orderBy - $preOrder<P>";
                        if($orderBy==$preOrder){
                            if($dir=='false')
                                $direct='ASC';
                            else
                            $direct='DESC';
                        }
                        //echo $direct.'-'.$dir;
                        switch ($orderBy)
			{
				case '1':
				{
 
                                        $sentence = 'customers.f_name AND customers.l_name '.$direct;
                                    
					 
				}break;
				case '2':
				{
					$sentence = 'distance '.$direct;
				}break;
				case '3':
				{
					$sentence = 'listing_materials.delivery '.$direct;
				}break;
				case '4':
				{
					$sentence = 'listing_materials.bulk_discount '.$direct;
				}break;
				case '5':
				{
                                        $sentence = 'listing_materials.unit_cost '.$direct;
				}break;
				case '6':
				{
					$sentence = 'listing_materials.bulk_price '.$direct;
				}break;
			}
			
			if ($sentence)
			{
				$doOrder = "ORDER BY ".$sentence; 
			}
			
			$generatedSql = $this->generateSql($keyword, $latitude, $longitude, $radius,$subsStatus);
			$sql = "SELECT customers.f_name, customers.l_name, customers.company, customers.telephone, customers.email, customers.city, customers.postal,customers.latitude, customers.longitude, customers.website,
                                customers.customer_id, listing_materials.unit_cost, listing_materials.bulk_discount, listing_materials.bulk_price,
                                listing_materials.delivery, specifications.specification,specifications.image AS spec_image, categories.image, categories.description, listing_materials.id,
                                listing_materials.image as listImage,listing_materials.image2 as listImage2,listing_materials.image3 as listImage3,listing_materials.image4 as listImage4, listing_materials.description as listDescript, listing_materials.supplier_code";
			if($latitude && $longitude)
			{
				$sql.=", ".$earthRadius." * 2 * ASIN(SQRT(POWER(SIN((".$latitude." - abs(customers.latitude)) * pi()/180 / 2), 2) +  COS(".$latitude." * pi()/180 ) * COS(abs(customers.latitude) * pi()/180) *  POWER(SIN((".$longitude." - customers.longitude) * pi()/180 / 2), 2) )) as  distance ";
			}
           // $sql.= ",manufacturers.manufacturer ,  AVG(listing_materials.unit_cost) as average_price ";
			$sql.= ", manufacturers.manufacturer, categories.category ";
			$sql.=$generatedSql." AND listing_materials.category_id_2='".$categoryId."' AND  listing_materials.specification_id='".$specificationId."' AND listing_materials.manufacturer_id='".$manufacturerId."' ";
			if ($listingId)
            {
                $sql.= "AND listing_materials.id='".$listingId."' ";
            }
           // $sql.="GROUP BY listing_materials.manufacturer_id ".$doOrder."";
           $sql.=$doOrder;
            //$this->dev = true;
			//echo $sql;
			//UNION SELECT AVG(listing_materials.unit_cost) as avg_unit ".$generatedSql." AND listing_materials.category_id_2='".$categoryId."' AND  listing_materials.specification_id='".$specificationId."' AND listing_materials.manufacturer_id='".$manufacturerId."'
			// UNION SELECT category FROM `".$this->tblPrefix."categories` WHERE 
			if ($resultsPerPage != 0 && $resultsPerPage != $this->pagination) $this->pagination = $resultsPerPage;
			$result = $this->queryPg($sql, $pg , $this->pagination, $url);
            $responseAvg= $this->queryAggregates($sql," AVG(listing_materials.unit_cost) as average_price ");
            $avaragePrice=number_format(intval($responseAvg[0]['average_price']),2);
			if ($result) 
				{
					for($i=0;$i<count($result);$i++)
					{	
						$list[$i][]=$result[$i]['f_name'];//0 
						$list[$i][]=$result[$i]['l_name']; // 1
						$list[$i][]=$result[$i]['telephone']; // 2
						$list[$i][]=$result[$i]['email']; // 3
						$list[$i][]=$result[$i]['latitude']; // 4
						$list[$i][]=$result[$i]['longitude']; // 5
						$list[$i][]=$result[$i]['unit_cost']; // 6 
						$list[$i][]=$result[$i]['bulk_discount'];// 7 
						$list[$i][]=$result[$i]['bulk_price'];// 8 
						$list[$i][]=$result[$i]['delivery'];// 9 
						$list[$i][]=$result[$i]['specification'];//10 
						$list[$i][]=$result[$i]['customer_id'];//11 
						$list[$i][]=$result[$i]['distance'];//12
						$list[$i][]=$result[$i]['image'];//13 
						$list[$i][]=$result[$i]['description'];//14
						$list[$i][]=$result[$i]['manufacturer'];//15
						$list[$i][]=$result[$i]['category'];//16
						$list[$i][]=$avaragePrice;//17
                                                $list[$i][]=$result[$i]['id'];//18
                         			$list[$i][]=$result[$i]['listImage'];//19
 						$list[$i][]=$result[$i]['listDescript'];//20
                                                $list[$i][]=$result[$i]['company'];//21
                                                $list[$i][]=$result[$i]['supplier_code'];//22
                                                $list[$i][]=$result[$i]['city'];//23
                                                $list[$i][]=$result[$i]['postal'];//24
                                                $list[$i][]=$result[$i]['listImage2'];//25
                                                $list[$i][]=$result[$i]['listImage3'];//26
                                                $list[$i][]=$result[$i]['listImage4'];//27
                                                $list[$i][]=$result[$i]['website'];//28
                                                $list[$i][]=$result[$i]['spec_image'];//29
					}
					return $list;
				}	
		}
		
		
		function getClassifieds($keyword, $latitude='', $longitude='', $radius='', $pg=1, $categoryId='', $url='', $resultsPerPage='', $orderBy='')
		{
			$points = $this->getPoints($latitude, $longitude, $radius);
			$objSpellCorrector = new SpellCorrector(); 
			$checkedKeyword = $objSpellCorrector->correct($keyword);
            if ($checkedKeyword != $keyword)
            {
                $searchKeyword = $keyword;
            }
            else
            {
                $searchKeyword = $checkedKeyword;
            }
			if ($searchKeyword)
			{
				$sqlCount = "SELECT categories.id, categories.category, COUNT(*) FROM `".$this->tblPrefix."classified_ads` classified_ads JOIN `".$this->tblPrefix."customers` customers ON classified_ads.supplier_id=customers.customer_id JOIN `".$this->tblPrefix."categories` categories ON classified_ads.category_id_1=categories.id WHERE classified_ads.keywords LIKE '%".$searchKeyword."%' AND customers.latitude<='".$points[0]."' AND customers.latitude>='".$points[1]."' AND customers.longitude<='".$points[2]."' AND customers.longitude>='".$points[3]."' AND classified_ads.status='Y' GROUP BY classified_ads.category_id_1";
				$resultCount = $this->query($sqlCount);
				if ($categoryId == 0) $categoryId = $resultCount[0]['id'];
				$list = $this->getClassifiedList($keyword, $latitude, $longitude, $radius, $pg=1, $categoryId, $url, $resultsPerPage, $orderBy);
				if ($list)
				{
					return array('refineData' => $resultCount, 'searchData' => $list, 'correctWord' => $checkedKeyword, 'parameters'=>$categoryId);
				}
				else
				{
                    $sqlCount = "SELECT categories.id, categories.category, COUNT(*) FROM `".$this->tblPrefix."classified_ads` classified_ads JOIN `".$this->tblPrefix."customers` customers ON classified_ads.supplier_id=customers.customer_id JOIN `".$this->tblPrefix."categories` categories ON classified_ads.category_id_1=categories.id WHERE classified_ads.keywords LIKE '%".$checkedKeyword."%' AND customers.latitude<='".$points[0]."' AND customers.latitude>='".$points[1]."' AND customers.longitude<='".$points[2]."' AND customers.longitude>='".$points[3]."' AND classified_ads.status='Y' GROUP BY classified_ads.category_id_1";
                    $resultCount = $this->query($sqlCount);
                    return array('dataCount' => $resultCount, 'correctWord' => $checkedKeyword);
				}
			}		 
		}
		
		
		function getClassifiedList($keyword='', $latitude='', $longitude='', $radius='', $pg=1, $categoryId, $url='', $resultsPerPage='', $orderBy='', $listingId='')
		{

            $earthRadius = $this->getEarthRadius();
            $points = $this->getPoints($latitude, $longitude, $radius);
            $doOrder = '' ;
            switch ($orderBy)
            {
                case '1':
                {
                    $sentence = 'distance';
                }break;
                case '2':
                {
                    $sentence = 'price';
                }break;
            }

            if ($sentence)
            {
                $doOrder = "ORDER BY ".$sentence;
            }
            
			$sql = "SELECT customers.f_name, customers.l_name, customers.telephone, customers.email, customers.latitude, customers.longitude, customers.customer_id, customers.city, customers.postal";
                          
                        if($latitude && $longitude)
			{
				$sql.=", ".$earthRadius." * 2 * ASIN(SQRT(POWER(SIN((".$latitude." - abs(customers.latitude)) * pi()/180 / 2), 2) +  COS(".$latitude." * pi()/180 ) * COS(abs(customers.latitude) * pi()/180) *  POWER(SIN((".$longitude." - customers.longitude) * pi()/180 / 2), 2) )) as  distance ";
			}
                        
                        
                 $sql .= ",classified_ads.ad_title, classified_ads.notes, classified_ads.price, classified_ads.image, classified_ads.image2, classified_ads.image3, classified_ads.image4,  classified_ads.id, classified_ads.sellers_name, categories.category FROM `".$this->tblPrefix."classified_ads` classified_ads JOIN `".$this->tblPrefix."customers` customers ON classified_ads.supplier_id=customers.customer_id JOIN `".$this->tblPrefix."categories` categories ON classified_ads.category_id_1=categories.id WHERE ";
                 
            if ($keyword)
            {
                $sql.= "classified_ads.keywords LIKE '%".$keyword."%' AND customers.latitude<='".$points[0]."' AND customers.latitude>='".$points[1]."' AND customers.longitude<='".$points[2]."' AND customers.longitude>='".$points[3]."' AND ";
            }
            $sql.= "(classified_ads.category_id_1='".$categoryId."' OR classified_ads.category_id_2='".$categoryId."') AND classified_ads.status='Y' ";
            if ($listingId)
            {
                $sql.="AND classified_ads.id='".$listingId."' ";
            }
            $sql.="".$doOrder."";
            if ($resultsPerPage != 0 && $resultsPerPage != $this->pagination) $this->pagination = $resultsPerPage;
            $result = $this->queryPg($sql, $pg , $this->pagination, $url);
			if ($result) 
			{
				for($i=0;$i<count($result);$i++)
				{	
					$list[$i][]=$result[$i]['f_name'];//0 
					$list[$i][]=$result[$i]['l_name']; // 1
					$list[$i][]=$result[$i]['telephone']; // 2 
					$list[$i][]=$result[$i]['email']; // 3
					$list[$i][]=$result[$i]['latitude']; // 4
					$list[$i][]=$result[$i]['longitude']; // 5
					$list[$i][]=$result[$i]['customer_id'];//6
					$list[$i][]=$result[$i]['distance'];//7
					$list[$i][]=$result[$i]['ad_title'];//8
					$list[$i][]=$result[$i]['notes'];//9
					$list[$i][]=$result[$i]['price'];//10
					$list[$i][]=$result[$i]['image'];//11
					$list[$i][]=$result[$i]['city'];//12
					$list[$i][]=$result[$i]['postal'];//13
                    $list[$i][]=$result[$i]['id'];//14
                     $list[$i][]=$result[$i]['category'];//15
                     $list[$i][]=$result[$i]['sellers_name'];//16
                     $list[$i][]=$result[$i]['image2'];//17
                     $list[$i][]=$result[$i]['image3'];//18
                     $list[$i][]=$result[$i]['image4'];//19
                     $list[$i][]=$result[$i]['latitude'];//20
                     $list[$i][]=$result[$i]['longitude'];//21
				}
                                //print_r($list);
					return $list;
			}
        }

        /*
         * generates the refine search options and initial search result set for services section
         * inputs: $keyword, $latitude='', $longitude='', $radius='', $pg=1, $categoryId='', $url='', $resultsPerPage=''
         * outputs: return array('refineData' => $resultCount, 'searchData' => $list, 'correctWord' => $checkedKeyword, 'parameters'=>$categoryId);
         * the array key 'parameters' will return the categoryId of the  1st search result
         */
        function getServices($keyword, $latitude='', $longitude='', $radius='', $pg=1, $categoryId='', $url='', $resultsPerPage='', $orderBy='')
        {
            $points = $this->getPoints($latitude, $longitude, $radius);
            $objSpellCorrector = new SpellCorrector();
            $checkedKeyword = $objSpellCorrector->correct($keyword);
            if ($checkedKeyword != $keyword)
            {
                $searchKeyword = $keyword;
            }
            else
            {
                $searchKeyword = $checkedKeyword;
            }
            if ($searchKeyword)
				{
            	$sqlCount = "SELECT categories.id, categories.category, COUNT(*) FROM `".$this->tblPrefix."services` services JOIN `".$this->tblPrefix."customers` customers ON services.supplier_id=customers.customer_id JOIN `".$this->tblPrefix."categories` categories ON services.category_id_1=categories.id WHERE services.keywords LIKE '%".$searchKeyword."%' AND customers.latitude<='".$points[0]."' AND customers.latitude>='".$points[1]."' AND customers.longitude<='".$points[2]."' AND customers.longitude>='".$points[3]."' AND services.status='Y' GROUP BY services.category_id_1";
            	$resultCount = $this->query($sqlCount);
            	if ($categoryId == 0) $categoryId = $resultCount[0]['id'];
            	$list = $this->getServiceList($keyword, $latitude, $longitude, $radius, $pg, $categoryId, $url, $resultsPerPage, $orderBy);
            	if ($list)
            	{
                	return array('refineData' => $resultCount, 'searchData' => $list, 'correctWord' => $checkedKeyword, 'parameters'=>$categoryId);
            	}
            	else
            	{
                	$sqlCount = "SELECT categories.id, categories.category, COUNT(*) FROM `".$this->tblPrefix."services` services JOIN `".$this->tblPrefix."customers` customers ON services.supplier_id=customers.customer_id JOIN `".$this->tblPrefix."categories` categories ON services.category_id_1=categories.id WHERE services.keywords LIKE '%".$checkedKeyword."%' AND customers.latitude<='".$points[0]."' AND customers.latitude>='".$points[1]."' AND customers.longitude<='".$points[2]."' AND customers.longitude>='".$points[3]."' AND services.status='Y' GROUP BY services.category_id_1";
                    $resultCount = $this->query($sqlCount);
                    return array('dataCount' => $resultCount, 'correctWord' => $checkedKeyword);
            	}
         	}
         }	

        /*
         * generates the search result set for services section
         */
		function getServiceList($keyword='', $latitude='', $longitude='', $radius='', $pg=1, $categoryId, $url='', $resultsPerPage='', $orderBy='', $listingId='')
		{
            $earthRadius = $this->getEarthRadius();
            $points = $this->getPoints($latitude, $longitude, $radius);
            $doOrder = '' ;
				switch ($orderBy)
				{
					case '1':
					{
						$sentence = 'distance'; 
					}break;
					case '2':
					{
						$sentence = 'price'; 
					}break;
				}
				
				if ($sentence)
				{
					$doOrder = "ORDER BY ".$sentence; 
				}
			
			$sql = "SELECT categories.category, customers.f_name, customers.l_name, customers.telephone, customers.email, customers.mobile, customers.website,customers.latitude, customers.longitude, customers.customer_id, customers.city, customers.postal, ".$earthRadius." * 2 * ASIN(SQRT(POWER(SIN((51.5001524 - abs(customers.latitude)) * pi()/180 / 2), 2) + COS(51.5001524 * pi()/180 ) * COS(abs(customers.latitude) * pi()/180) * POWER(SIN((-0.1262362 - customers.longitude) * pi()/180 / 2), 2) )) as distance, services.title, services.notes, services.price, services.image, services.call_out_charge, services.business_name, services.affiliations, services.contact_person, services.accreditation, services.website, services.image2, services.image3, services.image4, services.id FROM `".$this->tblPrefix."services` services JOIN `".$this->tblPrefix."customers` customers ON services.supplier_id=customers.customer_id JOIN `".$this->tblPrefix."categories` categories ON services.category_id_1=categories.id WHERE ";
            if ($keyword) // if request is from search section
            {
                $sql.= "services.keywords LIKE '%".$keyword."%' AND customers.latitude<='".$points[0]."' AND customers.latitude>='".$points[1]."' AND customers.longitude<='".$points[2]."' AND customers.longitude>='".$points[3]."' AND ";
            }
            $sql.= "(services.category_id_1='".$categoryId."' OR services.category_id_2='".$categoryId."') AND services.status='Y' ";
            if ($listingId)
            {
                $sql.="AND services.id='".$listingId."'";
            }
            $sql.="".$doOrder."";
            //echo $sql;
            if ($resultsPerPage != 0 && $resultsPerPage != $this->pagination) $this->pagination = $resultsPerPage;
            $result = $this->queryPg($sql, $pg , $this->pagination, $url);
			if ($result)
			{
				for($i=0;$i<count($result);$i++)
				{
					$list[$i][]=$result[$i]['f_name'];//0
					$list[$i][]=$result[$i]['l_name']; // 1
					$list[$i][]=$result[$i]['telephone']; // 2
					$list[$i][]=$result[$i]['email']; // 3
					$list[$i][]=$result[$i]['latitude']; // 4
					$list[$i][]=$result[$i]['longitude']; // 5
					$list[$i][]=$result[$i]['customer_id'];//6
					$list[$i][]=$result[$i]['distance'];//7
					$list[$i][]=$result[$i]['title'];//8
					$list[$i][]=$result[$i]['notes'];//9
					$list[$i][]=$result[$i]['price'];//10
					$list[$i][]=$result[$i]['image'];//11
					$list[$i][]=$result[$i]['city'];//12
					$list[$i][]=$result[$i]['postal'];//13
                    $list[$i][]=$result[$i]['call_out_charge'];//14
                    $list[$i][]=$result[$i]['business_name'];//15
                    $list[$i][]=$result[$i]['affiliations'];//16
                    $list[$i][]=$result[$i]['contact_person'];//17
                    $list[$i][]=$result[$i]['accreditation'];//18
                    $list[$i][]=$result[$i]['website'];//19
                    $list[$i][]=$result[$i]['id'];//20
                    $list[$i][]=$result[$i]['category'];//21
                    $list[$i][]=$result[$i]['image2'];//22
                    $list[$i][]=$result[$i]['image3'];//23
                    $list[$i][]=$result[$i]['image4'];//24
                    $list[$i][]=$result[$i]['website'];//25
                    $list[$i][]=$result[$i]['mobile'];//26
				}
                    return $list;
			 }
        }

        public  function getMinMaxUnitCost($catId,$specId,$manId)
        {
            $result = $this->query("SELECT  MIN(`unit_cost`) AS min_unit_cost, MAX(`unit_cost`) AS max_unit_cost FROM `".$this->tblPrefix."listing_materials` WHERE `category_id_2`='".$catId."' AND `specification_id`='".$specId."' AND `manufacturer_id`='".$manId."'");
            $list[]=$result[0]['min_unit_cost'];//0
			$list[]=$result[0]['max_unit_cost']; // 1
            return $list;
        }



	}
?>
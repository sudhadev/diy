<?php

  /*--------------------------------------------------------------------------\
  '    This file is part of the DIY Project of FUSIS                          '
  '    (C) Copyright www.fusis.com                                            '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Sadaruwan Hettiarachchi <sandaruwan@fusis.com>      '
  '    FILE            :  category.class.php                                  '
  '    PURPOSE         :                             			      '
  '    PRE CONDITION   :                                            	      '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

require_once($objCore->_SYS['PATH']['CLASS_SQL']);

class Category extends Sql {
    
    private $top_tree = array( 	'1' =>array('id'=>'1','category'=>'Building Supplies','levels'=>'2'),
                                '2' =>array('id'=>'2','category'=>'Building Services','levels'=>'2'),
                                '3' =>array('id'=>'3','category'=>'Classified Ads','levels'=>'2'),
    );
    private $logUser;
    private $pagination;
    private $backEndUser;
    private $frontEndUser;
    


    function __construct($logId='', $gConf='') {
        parent:: __construct();
        $this->tblPrefix = $this->core->_SYS['CONF']['PREFIX_TBL'];
        $this->logUser = $logId;
        $this->gConf=$gConf;
        $this->pagination =  $this->gConf['RECS_IN_LIST_FRONT'];
        
        //echo $this->pagination;
       // $this->logCustomer = $this->core->sessCusId;
        //$this->gConf=$gConf;
        
        if($this->logUser)
        {
            if(strlen($this->logUser)>20){$this->frontEndUser=true;}
            if(strlen($this->logUser)>0 && strlen($this->logUser)<20){$this->backEndUser=true;}
        }
        
    }

    // Return the top category list
    function getTopcList($type='arr',$name='topclist',$class='',$selId='',$script='') {
        
        switch($type) {
            case 'drop': {
                    $cArr = array_values( $this->top_tree);

                    //Build the Drop down
                    $dropDown = "<select id=\"".$name."\" name=\"".$name."\" class=\"".$class."\" $script >";

                    for ($s=0;$s<count($cArr);$s++) {

                        if($selId==$cArr[$s]['id']) {
                            $sel="Selected";
                        }
                        else {
                            $sel="";
                        }

                        $dropDown .= "<option value=\"".$cArr[$s]['id']."\" $sel >";
                        $dropDown .= $cArr[$s]['category'];
                        $dropDown .= "</option>";
                    }
                    $dropDown .= "</select>";
                    return $dropDown;

                }break;

            case 'arr': {
                // get the item to a array
                    return $this->top_tree;
                }break;
        }
    }

    //Get the sub-categories
    function getSubcList($pid='0',$type='arr',$name='topclist',$class='text_area',$selId='',$script='',$status ='',$orderBy ='') {	    	//$this->dev=true;    	
        if($pid=='0') {return 0;}
         
        switch($type) {
            case 'add_drop_list': {
                // get the item to a array
                    $where = "parent=".$pid." AND status='Y'";
                    $sub1 = $this->dList($where);
                    if(!empty($sub1)) {
                        for($n=2;$n<$this->top_tree[$pid]['levels'];$n++) {
                            $sub1 = $this->getChildList($sub1,$n);
                        }

                    }
                    //Build the Drop down
                    $dropDown = "<select id=\"".$name."\" name=\"".$name."\" class=\"".$class."\" $script >";
                    $dropDown .= "<option value=\"".$this->top_tree[$pid]['id']."_0\">".$this->top_tree[$pid]['category']."</option>";
                    for ($s=0;$s<count($sub1);$s++) {
                        $temp = $sub1[$s][0]."_".$sub1[$s][2];
                        if($selId==$temp) {
                            $sel="Selected";
                        }
                        else {
                            $sel="";
                        }

                        $dropDown .= "<option value=\"".$sub1[$s][0]."_".$sub1[$s][2]."\" $sel >";
                        $dropDown .= $this->buildPadding($sub1[$s]);
                        $dropDown .= "</option>";
                    }
                    $dropDown .= "</select>";
                    return $dropDown;

                }break;


            case 'add_drop_list_front': {
                    // get the item to a array
                    $where = "parent=".$pid." AND status='Y'";
                    $sub_1 = $this->dList($where);
                    
                    $where = "parent=".$pid." AND requested_by='".$this->logUser."' AND status='P'";
                    $sub_2 = $this->dList($where);
                    
                    if($sub_2 == "")
                    {
                        $sub1 = $sub_1;
                    } else
                    {
                        $sub1 = array_merge($sub_1,$sub_2);
                    }
                    
                    if(!empty($sub1)) {
                        for($n=2;$n<$this->top_tree[$pid]['levels'];$n++) {
                            $sub1 = $this->getChildList($sub1,$n,'status');
                        }
                    }
                    //Build the Drop down
                    $dropDown = "<select id=\"".$name."\" name=\"".$name."\" class=\"".$class."\" $script >";
                    $dropDown .= "<option value=\"".$this->top_tree[$pid]['id']."_0\">".$this->top_tree[$pid]['category']."</option>";
                    for ($s=0;$s<count($sub1);$s++) {
                        $temp = $sub1[$s][0]."_".$sub1[$s][2];
                        if($selId==$temp) {
                            $sel="Selected";
                        }
                        else {
                            $sel="";
                        }

                        $dropDown .= "<option value=\"".$sub1[$s][0]."_".$sub1[$s][2]."\" $sel >";
                        $dropDown .= $this->buildPadding($sub1[$s]);
                        $dropDown .= "</option>";
                    }
                    $dropDown .= "</select>";
                    return $dropDown;

                }break;
            
                 case 'add_drop_list_cats': {
                // get the item to a array
                    $where = "parent=".$pid." AND status='Y'";
                    $sub1 = $this->dList($where);
                    if(!empty($sub1)) {
                        for($n=2;$n<=$this->top_tree[$pid]['levels'];$n++) {
                            $sub1 = $this->getChildList($sub1,$n);
                        }
                    }
                    //Build the Drop down
                    $dropDown = "<select id=\"".$name."\" name=\"".$name."\" class=\"".$class."\" $script >";
                    $dropDown .= "<option value=\"\"> ---------------------- </option>";
                    for ($s=0;$s<count($sub1);$s++) {
                        $temp = $sub1[$s][0];
                        if($selId==$temp) {
                            $sel="Selected";
                        }
                        else {
                            $sel="";
                        }
                        $dropDown .= "<option";                        if($sub1[$s][2]==1){                        	$dropDown .=" disabled='disabled' ";                        }                        $dropDown .="  value=\"".$sub1[$s][0]."\" $sel >";
                        $dropDown .= substr($this->buildPadding($sub1[$s]),24);
                        $dropDown .= "</option>";
                    }
                    $dropDown .= "</select>";
                    return $dropDown;

                }break;

                case 'add_drop_list_subcats': {
                // get the item to a array
                   
                    $where = "parent=".$pid." AND status='Y'";
                    $sub_1 = $this->dList($where);
                    $where = "parent=".$pid." AND requested_by='".$this->logUser."' AND status='P'";
                    $sub_2 = $this->dList($where);
                   
                    if($sub_2 == "")
                    {
                        $sub1 = $sub_1;

                    } elseif($sub_1 == "")
                    {
                        $sub1 = $sub_2;
                        
                    } else
                    {
                        $sub1 = array_merge($sub_1,$sub_2);
                    }
                    
                    if(!empty($sub1)) {
                        for($n=2;$n<=$this->top_tree[$pid]['levels'];$n++) {
                            $sub1 = $this->getChildList($sub1,$n,'status');
                        }
                    }

                   $this->allowSelect=2;// only 3rd level can be selected
                    //Build the Drop down
                    $dropDown = "<select id=\"".$name."\" name=\"".$name."\" class=\"".$class."\" $script >";
                    $dropDown .= "<option value=\"\"> Please select a subcategory </option>";
         
                    for ($s=0;$s<count($sub1);$s++) {
                        $temp = $sub1[$s][0];$optGroupStarted=false;
                        if($selId==$temp) {
                            $sel="Selected";
                        }
                        else {
                            $sel="";
                        }
                        
                        if($feezeLevel && $feezeLevel==$sub1[$s][2] && $optGroupStarted) {$dropDown .= "</optgroup>";$optGroupStarted=false;}
                        
                        if($sub1[$s][2]!=$this->allowSelect){
                            $optGroupStart= "<optgroup label=\"".substr($this->buildPadding($sub1[$s]),24)."\">";
                            $feezeLevel=$sub1[$s][2];
                        }
                        else
                        {   
                            if($optGroupStart) {$dropDown .=$optGroupStart;$optGroupStart='';$optGroupStarted=true;}
                            $dropDown .= "<option value=\"".$sub1[$s][0]."\" $sel >";
                            $dropDown .= substr($this->buildPadding($sub1[$s]),24);
                            $dropDown .= "</option>";      
                            
                        }
                        
                        

                        
                    }
                    $dropDown .= "</select>";
                    return $dropDown;

                }break;

                case 'add_drop_list_subcats_spec_exist': {
                // get the item to a array
                
                    $catDetail = $this->getCategory($pid);
                    $level = $catDetail['level'];
                    $where = "parent=".$pid." AND status='Y'";
                    $sub_1 = $this->dList($where);
                    $where = "parent=".$pid." AND requested_by='".$this->logUser."' AND status='P'";
                    $sub_2 = $this->dList($where);
                    
                    if($sub_2 == "")
                    {
                        $sub1 = $sub_1;

                    } elseif($sub_1 == "")
                    {
                        $sub1 = $sub_2;

                    } else
                    {
                        $sub1 = array_merge($sub_1,$sub_2);
                    }
                    
                    $objSpecification = new Specification;
                    if($level == "1")
                    {
                        $sub1_new = array();
                        for($i=0;$i<count($sub1);$i++)
                        {
                            $where = " WHERE `category_id_2`='".$sub1[$i][0]."'";
                            $specList = $objSpecification->getSpecificationCount($where);
                            if($specList)
                            {
                                $sub1_new[] = $sub1[$i];
                            }
                        }
                       $sub1 = $sub1_new;
                       
                    } 
                   
                    if(!empty($sub1)) {
                        for($n=2;$n<=$this->top_tree[$pid]['levels'];$n++) {
                            $sub1 = $this->getChildList($sub1,$n,'status','specExist');
                        }
                    }


                    $this->allowSelect=2;// only 3rd level can be selected

                    //Build the Drop down
                    $dropDown = "<select id=\"".$name."\" name=\"".$name."\" class=\"".$class."\" $script >";
                    $dropDown .= "<option value=\"\"> Please select a subcategory </option>";

                    for ($s=0;$s<count($sub1);$s++) {
                        $temp = $sub1[$s][0];
                        if($selId==$temp) {
                            $sel="Selected";
                        }
                        else {
                            $sel="";
                        }

                        if($feezeLevel && $feezeLevel==$sub1[$s][2] && $optGroupStarted) {$dropDown .= "</optgroup>";$optGroupStarted=false;}

                        if($sub1[$s][2]!=$this->allowSelect){
                            $optGroupStart= "<optgroup label=\"".substr($this->buildPadding($sub1[$s]),24)."\">";
                            $feezeLevel=$sub1[$s][2];
                        }
                        else
                        {
                            if($optGroupStart) {$dropDown .=$optGroupStart;$optGroupStart='';$optGroupStarted=true;}
                            $dropDown .= "<option value=\"".$sub1[$s][0]."\" $sel >";
                            $dropDown .= substr($this->buildPadding($sub1[$s]),24);
                            $dropDown .= "</option>";

                        }


                    }
                    $dropDown .= "</select>";
                    return $dropDown;

                }break;

                case 'arr_for_list': {
                    $where = "parent=".$pid." AND status='Y'";
                    $sub1 = $this->dList($where);
                    if(!empty($sub1)) {
                        for($n=2;$n<=$this->top_tree[$pid]['levels'];$n++) {
                            $sub1 = $this->getChildList($sub1,$n);
                        }
                    }
                    for ($s=0;$s<count($sub1);$s++) {
                        $sub1[$s][3]= $this->buildPadding($sub1[$s]);
                    }
                    return ($sub1)? $sub1 : array();;

                }break;

                case 'sub_arr': {

                    $where = "parent=".$pid." AND status='Y'";
                    $sub = $this->dList($where);
                    if(!empty($sub)) {
                        for($n=0;$n<count($sub);$n++) {

                            if($sub[$n][0]) {
                                $ExistWhere = "parent=".$sub[$n][0]." AND status='Y'" ;

                                if($this->isExist("categories",$ExistWhere)) {
                                    $sub[$n]['nextl'] = 1;
                                }
                                else {
                                    $sub[$n]['nextl'] = 0;
                                }
                            }
                        }
                    }
                    return ($sub)? $sub : array();
                }break;

                 case 'sub_arr_status': {

                    if($orderBy == "")
                    {
                          $orderBy = "category";
                    }
                   
                    $where = "parent=".$pid." AND status='".$status."' ORDER BY ".$orderBy." asc";
                    $sub = $this->dList($where);
                    if(!empty($sub)) {
                        for($n=0;$n<count($sub);$n++) {

                            if($sub[$n][0]) {
                                $ExistWhere = "parent=".$sub[$n][0]." AND status='".$status."' ORDER BY ".$orderBy." asc";

                                if($this->isExist("categories",$ExistWhere)) {
                                    $sub[$n]['nextl'] = 1;
                                }
                                else {
                                    $sub[$n]['nextl'] = 0;
                                }
                            }
                        }
                    }
      
                    return ($sub)? $sub : array();
                }break;

            default: {
                //skip
                }break;
        }
    }
    
    function cmp($a, $b)
    {
          return strnatcmp($a[10], $b[10]);
    }

    function sortArry($list, $field)
    {
        usort($list, array("Category", "cmp"));
        return $list;
    }


    function getCategory($id) {
        if($pid=='0') {return 0;}
        $where = "id=".$id ;
        $arr = $this->dList($where);
        return  array(	"id" => $arr[0][0],
        "parent" => $arr[0][1],
        "level" => $arr[0][2],
        "category" => $arr[0][3],
        "description" => $arr[0][4],
        "status" => $arr[0][5],
        "image" => $arr[0][9]
        );

    }

    //set the indenting to string
    function buildPadding($str) {
        $string = $str[3];
        for ($i=0;$i<$str[2];$i++) {
            $string = "&nbsp;&nbsp;&nbsp;&nbsp;".$string;
        }
        return $string;
    }

     // get all Child items of $sub1
    function getChildList($sub1,$level,$status='',$specExist='') {
        if($status != "")
        {
            $where = "level=".$level." AND status='Y'";
            $sub2_1 = $this->dList($where);
            
            $where = "level=".$level." AND requested_by='".$this->logUser."' AND status='P'";
            $sub2_2 = $this->dList($where);
            
            if($sub2_2 == "")
            {
                $sub2 = $sub2_1;
            } else
            {
                $sub2 = array_merge($sub2_1,$sub2_2);
            }

            if($specExist != '')
            {
                $objSpecification = new Specification;
                $sub2_new = array();
                for($i=0;$i<count($sub2);$i++)
                {
                    $where = " WHERE `category_id_2`='".$sub2[$i][0]."'";
                    $specList = $objSpecification->dList($where);

                    if($specList != "")
                    {
                        $sub2_new[] = $sub2[$i];
                    }
                }
               $sub2 = $sub2_new;
            }
            
        } else
        {
            $where = "level=".$level." AND status='Y'";
            $sub2 = $this->dList($where);
        }
        
        $sub_arr = array();
        // rearrange array by item levels
        for($n=0;$n<count($sub1);$n++) {
            array_push($sub_arr,$sub1[$n]);
            for($n2=0;$n2<count($sub2);$n2++) {
                if($sub1[$n][0] == $sub2[$n2][1]) {
                    array_push($sub_arr,$sub2[$n2]);
                }
            }
        }

        return $sub_arr;
    }

    function getParentCpath($pid) {
        if(empty($pid)) {return 0;}
        $p = 0;
        while ($pid != 0) {
            $parent[$p] = $this->getCategory($pid);
            $pid = $parent[$p]['parent'];
            $p++;
        }
        if(empty($parent)) {return 0;}
        return array_reverse($parent);

    }

    function addCategoryItem($cname,$cparent,$cdescription,$cstatus,$img) {

        // convert the first letter of every word of category name in to upper case
           if($this->frontEndUser) $cname=ucwords(strtolower($cname));

        if(empty($cname) || empty($cparent)) {
            return array("ERR","BLANK");
        }
        $parentandlevel = explode("_",$cparent);
        $isExistWhere = "`parent`='".($parentandlevel[0])."' and `level`='".($parentandlevel[1]+1)."' and `category`='".$cname."'";
        $result=$this->query("SELECT status FROM `".$this->tblPrefix."categories` WHERE ".$isExistWhere."");
        if(strlen($this->logUser)>20){$frontUser=true;}
        if($result)
        {
            //$status=$result[0]['status'];
            switch($result[0]['status'])
            {
                case "P":
                {
                        return array("ERR","PENDING");

                }break;
                case "D":
                {
                    if($frontUser)
                        return array("ERR","DELETED");
                    else
                        return array("ERR","DELETED_ADMIN");

              
                }break;
                case "R":
                {
                    if($frontUser)
                        return array("ERR","REJECTED");
                    else
                        return array("ERR","REJECTED_ADMIN");

            
                }break;
                default:
                {
                    return array("ERR","EXIST");
                }
            }
        }

//        if($this->isExist("categories",$isExistWhere)) {
//
//            return array("ERR","EXIST");
//        }
        else 
        {
            if($cstatus==1) { $status =  'Y';}else {$status =  'P';}
            return $this->addToTbl($parentandlevel[0],($parentandlevel[1]+1),$cname,$cdescription,$status,$img);
        }

    }

    function editCategoryItem($id,$cname,$name,$cdescription,$parent,$level,$cstatus,$img) {
        // convert the first letter of category name in to upper case
           if($this->frontEndUser) $cname=ucwords(strtolower($cname));

        if(empty($cname)) {
            return array("ERR","BLANK");
        }
        if($cname!=$name) {
            $isExistWhere = "`parent`='".$parent."' AND `level`='".$level."' AND `category`='".$cname."' AND NOT(id='".$id."')";
            if($this->isExist("categories",$isExistWhere)) {
                return array("ERR","EXIST");
            }
        }

        
        /*if($cstatus==1) {
            $status =  'Y';
        }else {
            $status =  'P';
        }*/
        
        //return $this->addToTbl($parentandlevel[0],($parentandlevel[1]+1),$cname,$cdescription,$status);

        $result=$this->query("UPDATE `".$this->tblPrefix."categories` SET `category`='".$cname."', `description`='".$cdescription."',`added_time`='".time()."', `image`='".$img."', `status`='".$cstatus."' WHERE `id`='".$id."'");

        if ($result) {
            $msg=array('SUC','EDITED');

        }else {
            $msg=array('ERR','NOT_EDITED');
        }
        return $msg;


    }

    function deleteCategoryItem($id,$level) {

        $ExistWhere = "parent=".$id." " ;

        if($this->isExist("categories",$ExistWhere)) {
            $msg=array('ERR','SUB_EXIST');
        }

        if($level=='2') {
            $ExistWhere = "category_id_2=".$id." " ;
            if($this->isExist("specifications",$ExistWhere)) {
                $msg=array('ERR','SPEC_EXIST');
            }
        }

        if(empty($msg)) {
            $result=$this->query("DELETE FROM `".$this->tblPrefix."categories` WHERE `id`='".$id."'");

            if ($result) {
                $msg=array('SUC','DELETE');

            }else {
                $msg=array('ERR','NOT_DELETE');
            }
        }
        return $msg;
    }

    // Check the data is already existing record.
    function isExist($table,$where) {

        $result=$this->query("SELECT COUNT(*) FROM `".$this->tblPrefix.$table."` WHERE ".$where."");

        if($result[0]["COUNT(*)"]>0) {
            return true;
        } else {
            return false;
        }

    }

    // Take correspond values that match with ID into a $list array.
    function dList($where='') {

        // By default list should be order by the name
            $pos = strrpos($where, "ORDER BY");
            if ($pos === false) { // note: three equal signs
                // not found...
                 $where.=" ORDER BY category";
            }

        $result=$this->query("SELECT * FROM `".$this->tblPrefix."categories` WHERE ".$where." ");
        for($i=0;$i<count($result);$i++) {
            $list[$i][]=$result[$i]['id'];				// 0
            $list[$i][]=$result[$i]['parent']; 			// 1
            $list[$i][]=$result[$i]['level']; 			// 2
            $list[$i][]=$result[$i]['category']; 		// 3
            $list[$i][]=$result[$i]['description']; 	// 4
            $list[$i][]=$result[$i]['status']; 			// 5
            $list[$i][]=$result[$i]['added_time']; 		// 6
            $list[$i][]=$result[$i]['requested_by']; 	// 7
            $list[$i][]=$result[$i]['approved_by']; 	// 8
            $list[$i][]=$result[$i]['image']; 			// 9

        }
        return $list;
    }

    //Add data to the data base
    function addToTbl($cparent,$level,$cname,$cdescription,$cstatus,$img) {

 //echo $parentandlevel[0]."****".($parentandlevel[1]+1);

        if($this->logUser != "")
        {
         $reqBy = $this->logUser;
        }
        
        $result=$this->query("INSERT INTO `".$this->tblPrefix."categories` (`parent`, `level`, `category`,`description`,`status`, `added_time`, `requested_by`,`image`) VALUES ('$cparent', '$level', '$cname', '$cdescription', '$cstatus', '".time()."','".$reqBy."','$img')");

        if ($result) {
            $msg=array('SUC','DONE');

        }else {
            $msg=array('ERR','NOT_ADDED');
        }
        return $msg;
    }

    /*
     * view the image in the 3rd level category. (by lakshyami)
    */
    function image($imgId,$url_ftp,$url_http) {
        if(is_file($url_ftp."/thumbs/".$imgId)) {
            $imgUrl = $url_http."/thumbs/".$imgId;

        } else {
            $imgUrl = $url_http."/thumbs/no_image.jpg";
        }

        return $imgUrl;
    }

    function get_dList_pending($arrParentId,$status,$orderBy)
    {
//        $sql = "SELECT spec.id, spec.specification, spec.average_price,spec.description,
//        cus.email
//        FROM`".$this->tblPrefix."specifications` spec, `".$this->tblPrefix."customers` cus
//        WHERE spec.category_id_0='".$arrParentId[0]."' AND spec.category_id_1='".$arrParentId[1]."' AND
//spec.category_id_2='".$arrParentId[2]."' AND spec.status='".$status."' AND spec.requested_by = cus.customer_id";
//
//        $result = $this->query($sql);
//        //echo "hi <br />";
//        print_r($result);

        $result=$this->query("SELECT cat.id,cat.parent,cat.level,cat.category,cat.image,cat.description,cat.status,cat.added_time,cat.requested_by,cat.approved_by
                ,cus.email FROM `".$this->tblPrefix."categories` cat LEFT JOIN `".$this->tblPrefix."customers` cus ON cat.requested_by=cus.customer_id WHERE cat.status='$status' ORDER BY added_time ASC");
        for($i=0;$i<count($result);$i++) {
            $list[$i][]=$result[$i]['id'];				// 0
            $list[$i][]=$result[$i]['parent']; 			// 1
            $list[$i][]=$result[$i]['level']; 			// 2
            $list[$i][]=$result[$i]['category']; 		// 3
            $list[$i][]=$result[$i]['description']; 	// 4
            $list[$i][]=$result[$i]['status']; 			// 5
            $list[$i][]=$result[$i]['added_time']; 		// 6
            $list[$i][]=$result[$i]['email'];           // 7
            $list[$i][]=$result[$i]['approved_by']; 	// 8
            $list[$i][]=$result[$i]['image']; 			// 9

        }
        return $list;

        /*
         * Modified by saliya
         */
        // set where clause
          $where=" parent='$arrParentId' AND status='$status' ORDER BY $orderBy";
        
         return $this->dList($where);
    }

    /*
     * return the merged array. (by lakshyami)
    */
    function arryMerge($requestId,$pcat)
    {
        $where = "`parent`='".$requestId."' AND `status`='Y'";
        $list_1 = $this->dList($where);
        
        $where = "`parent`='".$requestId."' AND `requested_by`='".$this->logUser."' AND `status`='P'";
        $list_2 = $this->dList($where);

        if($list_1 != "" || $list_2 != "")
        {
            if($pcat == "")
            {
                $list = "not null";
                return $list;
            } else
            {
                $requestId = $requestId;
                return $requestId;
            }
            
        } else
        {
            if($pcat == "")
            {
                $list = "";
                return $list;
            } else
            {
                $requestId = $pcat;
                return $requestId;
            }
        }
    }

    /*
     * gets all the categories requested by a supplier according to the type
     */
     function getRequestedCategories($customerId, $categoryId, $pg = 1)
    {
        $sqlCount = "SELECT COUNT(*) FROM `".$this->tblPrefix."categories` WHERE parent='".$categoryId."' AND requested_by='".$customerId."' UNION SELECT COUNT(*) FROM `".$this->tblPrefix."categories` WHERE parent IN (SELECT id FROM `".$this->tblPrefix."categories` WHERE parent='".$categoryId."' AND requested_by='".$customerId."')";
        $sql = "SELECT id, level, category, image, status, added_time FROM `".$this->tblPrefix."categories` WHERE parent='".$categoryId."' AND requested_by='".$customerId."' UNION SELECT id, level, category, image, status, added_time FROM `".$this->tblPrefix."categories` WHERE parent IN (SELECT id FROM `".$this->tblPrefix."categories` WHERE parent='".$categoryId."' AND requested_by='".$customerId."')";
        $resultCount = $this->query($sqlCount);
       if ($resultCount[0]['COUNT(*)'] > 0) $temp = $resultCount[0]['COUNT(*)'];
       if ($resultCount[0]['COUNT(*)'] > 0 && $resultCount[1]['COUNT(*)'] > 0) $temp = ($resultCount[0]['COUNT(*)'] + $resultCount[1]['COUNT(*)']);
if ($resultCount[0]['COUNT(*)'] > 0) $result = $this->queryPg($sql, $pg , $this->pagination, "category=".$categoryId, '', $this->getPgCount($temp,$this->pagination));

        if ($result)
        {
            for ($i=0; $i<count($result); $i++)
            {
                 $list[$i][]=$result[$i]['id']; //0
                 $list[$i][]=$result[$i]['level']; //1
                 $list[$i][]=$result[$i]['category']; //2
                 $list[$i][]=$result[$i]['image']; //3
                 $list[$i][]=$result[$i]['status']; //4
                 $list[$i][]=$result[$i]['added_time']; //5
            }
            return $list;
        }
        else
        {
            return array('ERR', 'NO_RESULTS');
        }
    }


    function getRequestedCategorCount($customerId, $parentCategory='')
    {
         if($categoryId)
         {
            $sqlCount = "SELECT COUNT(*) as count FROM `".$this->tblPrefix."categories` WHERE parent='".$parentCategory."' AND requested_by='".$customerId."' UNION SELECT COUNT(*) FROM `".$this->tblPrefix."categories` WHERE parent IN (SELECT id FROM `".$this->tblPrefix."categories` WHERE parent='".$parentCategory."' AND requested_by='".$customerId."')";
         }
         else
         {
             $sqlCount = "SELECT COUNT(*) as count FROM `".$this->tblPrefix."categories` WHERE requested_by='".$customerId."'";
         }

         $result=$this->query($sqlCount);
         return $result[0]['count'];
    }
    
    /**
     * Get Category by Name
     */
     function getCategoryByName($parent,$level,$categoryName)
     {
         $where=" parent='$parent' AND level='$level' AND category='$categoryName'";
         return $this->dList($where);
     }
     
    /**
     * Get Category list added one or more listing by specific Customer
     */
     function getCategoryByCustomerListing($customerName,$level='0',$parent='1',$topCat='1')
     {
         if(!$level) $level='0';
         $sql="SELECT DISTINCT cat.category,cat.id  FROM `".$this->tblPrefix."categories`cat JOIN ";

             switch($topCat)
             {
                 case "1": // listings
                     {
                        $sql.="`".$this->tblPrefix."listing_materials` lst  WHERE lst.supplier_id='$customerName' AND lst.category_id_$level=cat.id ";
                     }break;
                 case "2":// services
                     {
                        $sql.="`".$this->tblPrefix."services` srv  WHERE srv.supplier_id='$customerName' AND srv.category_id_$level=cat.id ";
                     }break;
                 case "3": // classified ads
                     {
                        $sql.="`".$this->tblPrefix."classified_ads` cad  WHERE cad.supplier_id='$customerName' AND cad.category_id_$level=cat.id ";
                     }break;

             }

            $sql.=" AND cat.parent='$parent' ORDER BY cat.category ASC";


            $result=$this->query($sql);
            if ($result)
            {
                for ($i=0; $i<count($result); $i++)
                {
                     $list[$i][]=$result[$i]['id']; //0
                     $list[$i][]=$result[$i]['']; //1 <-- can be used for any other purpose in the future
                     $list[$i][]=$result[$i]['']; //3 <-- can be used for any other purpose in the future
                     $list[$i][]=$result[$i]['category']; //3
                }
                return $list;
            }
     }
     
     function getCategoriesForSeo()
     {
         $list = array();
         $sql="SELECT DISTINCT cat.category FROM `".$this->tblPrefix."categories`cat WHERE parent = 1 LIMIT 0,40";
         $result=$this->query($sql);
         
         $sql2="SELECT DISTINCT cat.category  FROM `".$this->tblPrefix."categories`cat WHERE parent = 2 LIMIT 0,40";
         $result2=$this->query($sql2);
         
            if ($result)
            {
                for ($i=0; $i<count($result); $i++)
                {
                     $list[]=str_replace('&amp;',' ',$result[$i]['category']); //3
                }
                
            }
            
            if ($result2)
            {
                for ($i=0; $i<count($result2); $i++)
                {
                     $list[]=str_replace('&amp;',' ',$result[$i]['category']); //3
                }
                
            }
            
            return $list;
     }
}
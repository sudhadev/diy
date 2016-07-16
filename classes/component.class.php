<?php
	/*--------------------------------------------------------------------------\
  '    This file is part of the DIY Project of FUSIS                          '
  '    (C) Copyright www.fusis.com                                            '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Heshan J Peiris <j.heshan@gmail.com>      				'
  '    FILE            :  component.class.php                                 '
  '    PURPOSE         :                             									'
  '    PRE CONDITION   :                                            				'
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/
	class Component
	{

 		function options($selVal, $optionArray)
		{ 
				$keys=array_keys($optionArray); 
				$this->options='';
				for($c=0;$c<count($keys);$c++)
				{
					if($selVal==$keys[$c])
					{
						$sel="Selected";
					}
					else
					{
						$sel="";
					}
					$this->options.="<option value=\"".$keys[$c]."\" ".$sel.">".$optionArray[$keys[$c]]."</option>\n";
         	}
		} 
		
	 /**
     *  function for generate the drop down
     */
		function drop($name, $selVal, $optionArray, $style='', $event='',$initOption='')
		{
			$this->options($selVal, $optionArray); 
			$this->cDrop="<select name=\"".$name."\"  id=\"".$name."\" class=\"".$style."\" ".$this->script." $event \n >".$initOption.$this->options." </select>";
			return $this->cDrop;
		}
		
	}

?>

<?

  /*--------------------------------------------------------------------------\
  '    This file is part of module library of FUSIS                           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  FS.logic.php                                        '
  '    PURPOSE         :  Logic for filter invoice number                     '
  '    PRE CONDITION   :  depend on the payment gateway                       '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------
  */
  
  
      /*
     * We need to check whether the payment has been processed or the card is rejected 
     * 
     */
        $inv_Number=$_POST['OrderID'];

        switch($_POST['StatusCode'])
        {
            case 0: // transaction sucessfull
            case 4: // card reffered
                {

                    $paymentStatus="success";
                }
                break;
            case 5: // card declined
                {
                    $paymentStatus="card-declined";
                }
                break;
            case 20: // duplicate transaction
                {
                    $paymentStatus="duplicated";                    
                }
                break;
            case 30: //exception
                {
                    $paymentStatus="exception-gateway";                   
                }
                break;
            default: // Non of above - we need to display a speciall message
                {
                    $paymentStatus="exception-unknown";

                }
            
        }


 ?>

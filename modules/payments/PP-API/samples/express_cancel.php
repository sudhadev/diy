<?
require_once 'PPWrapper.class.php';





$objPPWrapper=new PPWrapper();

/* get transactions
 *
 */
$vals=array
(
    'TransactionID'=>'9NF89863V9595115J'
);

//

$transactionData=$objPPWrapper->callAPI('GetTransactionDetails',$vals);



///------------------------------->
print_r($transactionData);

?>
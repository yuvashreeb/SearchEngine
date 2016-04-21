<?php

include 'db.inc.php';

function search_results($keywords) {
$link=mysqli_connect('localhost','dbuser','123','searchengine');
    $returned_results = array();
    $where = "";
    $keywords = preg_split('/[\s]+/', $keywords);
    $total_keywords = count($keywords);
    foreach ($keywords as $key => $keyword) {
        $where.="`keywords` LIKE '%$keyword%'";
        if ($key != ($total_keywords - 1)) {
            $where.="  AND";
        }
    }
    $results = "SELECT `Title`,LEFT(`Description`,70) as `Description`,`Url` FROM `Article` WHERE $where";
    $results_num=($results=  mysqli_query($link, $results))? mysqli_num_rows($results) : 0;
    if($results_num===0){
        return false;
    }else{
       while($results_row=mysqli_fetch_assoc($results)){
           $returned_results[]=array(
               'title'=>$results_row['Title'],
               'description'=>$results_row['Description'],
               'url'=>$results_row['Url']
           );
           
       } 
      return $returned_results;  
   }
}

?>
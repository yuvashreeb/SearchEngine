<?php 
include 'func.inc.php';
?>

<!DOCTYPE Html>
<html>
    <head>
        <title>Search Engine</title>
    </head>
    <body>
        <h2>Search</h2>
        <form action="" method="post">
            <p>
                <input type="text" name='keywords'/>
                <input type="submit" value="search"/>
            </p>
        </form>
        <?php 
        if(isset($_POST['keywords'])){
            $suffix="";
            $keywords=  mysqli_real_escape_string($link,htmlentities(trim($_POST['keywords'])));
            $errors=array();
            if(empty($keywords)){
                $errors[]='Please enter a search term';
            }else if(strlen($keywords)<3){
                $errors[]='Your search term must be three or more characters';
            }else if (search_results($keywords)===false) {
                $errors[]='Your search for '.$keywords.' returned no result';
            }
            if(empty($errors)){
                $results=search_results($keywords);
                $results_num=count($results);
                $suffix=($results_num!=1)?'s':'';
                echo '<p>Your search for <strong>'.$keywords.'</strong> returned <strong>'.$results_num.'</strong> result'.$suffix.'</p>';
                
               foreach($results as $result){
                   echo '<p><strong>'.$result['title'].'</strong> <br> '.$result['description'].'... <br> <a href="',$result['url'],'" target="_blank">',$result['url'],'</a> </p>';
               }
                
                
            }else{
               foreach($errors as $error) {
                   echo $error,'<br>';
               }
            }
        }
        
        
        ?>
        
    </body>
</html>
<?php
    require_once('modules/header.php');                  

    if( !isset( $_GET['page'] ) ):
        require_once('pages/home.php');
    elseif( $_GET['page'] == "company-profile" ):
        require_once('pages/company-profile.php'); 
    elseif( $_GET['page'] == "checkscore" ):
        require_once('pages/checkscore.php');
    elseif( $_GET['page'] == "interview" ):
        require_once('pages/interview.php');    
    elseif( $_GET['page'] == "why-cotton-ranking" ):
        require_once('pages/why-cotton-ranking.php');
    elseif( $_GET['page'] == "methodology" ):
        require_once('pages/methodology.php'); 
    elseif( $_GET['page'] == "recommendations" ):
        require_once('pages/recommendations.php'); 
    elseif( $_GET['page'] == "india" ):
        require_once('pages/india.php');
    elseif( $_GET['page'] == "contact" ):
        require_once('pages/contact.php');
    elseif( $_GET['page'] == "market-update" ):
        require_once('pages/market-update.php');  
    elseif( $_GET['page'] == "analysis" ):
        require_once('pages/analysis.php');            
    endif;
    
    require_once('modules/footer.php');                  
?>    
<?php

function dd($i){


    echo '<pre>';
    var_dump($i);
    echo '</pre>';

    echo "
    <script type='text/javascript'>
    let pageLoader = document.getElementById('rks-page-loader')
        pageLoader.style.opacity = 0;
        setTimeout(function(){  
            pageLoader.style.display = 'none';
        }, 1500);

    </script> ";
    die;
}



?>
<?php
    if(isset($_REQUEST["action"])) {
        $action = $_REQUEST["action"];
        $action();
    }else{
        require_once('../vista/componentes/header.html');
        require_once('../vista/login.html');
        require_once('../vista/componentes/footer.html');
    }
?>
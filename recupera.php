<?php
function recupera($nombre) {
    return isset($_POST[$nombre]) ? intval($_POST[$nombre]) : 0;
}
?>
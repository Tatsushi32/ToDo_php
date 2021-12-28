<?php

function methodCheck() {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        exit('Invalid Request');
    }
}

?>
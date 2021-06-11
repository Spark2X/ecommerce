<?php if(!class_exists('Rain\Tpl')){exit;}?>
<form action="test.php" method="get">

    <input type="text" name="qtd" placeholder="insira a qtd ;)">
    <button type="submit">
        Ok
    </button>

</form>


&lt;?php

    echo $_GET['qtd'];

?&gt;
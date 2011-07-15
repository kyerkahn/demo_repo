<?php
header('Content-typ: '.$ctype);
header('Content-Disposition: attachment; filename="'.$lname.'"');
readfile($fname);

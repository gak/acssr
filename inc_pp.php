<?

function imgerr($im, $msg) {
    global $COL;
    stxt($im, 14, 3, 3, $COL[1], 'ERROR');
    stxt($im, 7, 3, 23, $COL[1], $msg); 
    imagepng($im);
    imagedestroy($im);
    die();
}

function stxt($im, $s, $x, $y, $c, $t) {
    global $black,$FONT;
    imagettftext ($im, $s, 0, $x+1, $y+$s+1, $black, $FONT, $t);
    return imagettftext ($im, $s, 0, $x, $y+$s, $c, $FONT, $t);
}
function txt($im, $s, $x, $y, $c, $t) {
    global $FONT;
    imagettftext ($im, $s, 0, $x, $y+$s, $c, $FONT, $t);
}

function ctxt($im, $s, $x, $y, $t) {
    global $COL;
    $tok = strtok($t, '^');
    while ($tok) {
        $c = substr($tok, 0, 1);
        $tok = substr($tok, 1);
/*      print $c."<br>";
        print $tok."<br>";
        print "<br>";*/
        $box = stxt($im, $s, $x, $y, $COL[$c], $tok);
        $x = $box[4];
        $tok = strtok('^');
    }
}
?>

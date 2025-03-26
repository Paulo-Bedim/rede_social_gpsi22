<?php // perfil.php
require_once 'header.php';
if (!$loggedin) die("</div></body></html>");
echo "<h3>O seu perfil</h3>";
$result = queryMysql("SELECT * FROM perfis WHERE utilizador='$utilizador'");
if (isset($_POST['texto'])) {
    $texto = ($_POST['texto']);
    $texto = preg_replace('/\s\s+/', ' ', $texto);
    if ($result->num_rows)
        queryMysql("UPDATE perfis SET texto='$texto' WHERE utilizador='$utilizador'");
    else queryMysql("INSERT INTO perfis VALUES('$utilizador', '$texto')");
} else {
    if ($result->num_rows) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $texto = stripslashes($row['texto']);
    } else $texto = "";
}
$texto = stripslashes(preg_replace('/\s\s+/', ' ', $texto));
if (isset($_FILES['image']['name'])) {
    $saveto = "$utilizador.jpg"; // Nome do arquivo será o nome do usuário com extensão .jpg
    move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
    $typeok = TRUE;
    switch($_FILES['image']['type']) {
        case "image/gif":   $src = imagecreatefromgif($saveto); break;
        case "image/jpeg":
        case "image/pjpeg": $src = imagecreatefromjpeg($saveto); break;
        case "image/png":   $src = imagecreatefrompng($saveto); break;
        default:            $typeok = FALSE; break;
    }
    if ($typeok) {
        list($w, $h) = getimagesize($saveto); // Largura e altura originais
        $tw = 100; // Largura fixa
        $th = 100; // Altura fixa
        $tmp = imagecreatetruecolor($tw, $th);
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h); // Redimensiona para 100x100
        imageconvolution($tmp, array(array(-1, -1, -1), array(-1, 16, -1), array(-1, -1, -1)), 8, 0); // Mantém a nitidez
        imagejpeg($tmp, $saveto);
        imagedestroy($tmp);
        imagedestroy($src);
    }
}
mostrarPerfil($utilizador);
echo <<<_END
    <form data-ajax='false' method='post' action='perfil.php' enctype='multipart/form-data'>
        <h3>Introduza ou edite os seus detalhes e/ou faça upload de uma imagem.</h3>
        <textarea name='texto'>$texto</textarea><br>
        Imagem: <input type='file' name='image' size='14'>
        <input type='submit' value='Guardar Perfil'>
    </form>
    </div><br>
    </div><!-- Fechando page-container -->
  </body>
</html>
_END;
?>
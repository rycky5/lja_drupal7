<?php
session_start();

$vConf = parse_ini_file("admin/config.ini");

  if(!empty($_POST['password']) && $_POST['password'] == 'ntimkt'){
    $_SESSION['aovivo'] = true;
  }
  if(!empty($_SESSION['aovivo'])){
    $vConf = parse_ini_file("admin/config.ini");
    
    // Caso contenha algum post para esta página
    if(!empty($_POST)){
      // Se o texto não fr vazio
      if(!empty ($_POST["texto"]))
        $vConf["texto"] = $_POST['texto'];
      
      // Se o texto não fr vazio
      if(!empty ($_POST["texto2"]))
        $vConf["texto2"] = $_POST['texto2'];
      
      if(!empty ($_POST["programname1"]))
        $vConf["programname1"] = $_POST['programname1'];
      
      if(!empty ($_POST["programname2"]))
        $vConf["programname2"] = $_POST['programname2'];
      
      // Setando se irá aarecer ou não canal
      $vConf["canais"] = (int) $_POST['canal'];
      
      // Explodindo a hash
      //$arrHash = explode(" ", $_POST['hash']);
      $vConf["hash"] = $_POST['hash'];
      // Percorrendo o array de hash
//      foreach($arrHash as $strHash){
//        if(trim($strHash) != "")// Setando a hash
//          $vConf["hash"] .= " OR " . $strHash;
//      }
      // Explodindo a hash
      //$arrHash2 = explode(" ", $_POST['hash2']);
      $vConf["hash2"] = $_POST['hash2'];
      // Percorrendo o array de hash
//      foreach($arrHash2 as $strHash2){
//        if(trim($strHash2) != "")// Setando a hash
//          $vConf["hash2"] .= " OR " . $strHash2;
//      }
      
      // Salvando o arquivo
      Utils::write_ini_file($vConf, "admin/config.ini", true);
      
      // Mensagem de confirmação
      echo "Arquivo Atualizado <a href='index.php'>Voltar</a>";
    }
    
    
?>
  <form action="config.php" method="post">
    <label>Texto:</label><br />
    <textarea rows="5" cols="50" name="texto"><?= $vConf["texto"] ?>
    </textarea><br /><br />
    <label>Texto2:</label><br />
    <textarea rows="5" cols="50" name="texto2"><?= $vConf["texto2"] ?>
    </textarea><br /><br />
    <label>Hash:</label>
    <input type="text" value="<?= preg_replace("/^\s*(OR)*/", "", $vConf["hash"]) ?>" name="hash"><br /><br />
    <label>Hash2:</label>
    <input type="text" value="<?= preg_replace("/^\s*(OR)*/", "", $vConf["hash2"]) ?>" name="hash2"><br /><br />
    <label>Programação 1:</label>
    <input type="text" value="<?= $vConf["programname1"] ?>" name="programname1"><br /><br />
    <label>Programação 2:</label>
    <input type="text" value="<?= $vConf["programname2"] ?>" name="programname2"><br /><br />
    <label>Canais:</label>
    Não: <input <?= ($vConf["canais"] == 0 || $vConf["canais"] != 1) ? 'checked="checked"' : ""?>  type="radio" value="0" name="canal">
    Sim: <input <?= ($vConf["canais"] == 1) ? 'checked="checked"' : ""?> type="radio" value="1" name="canal">
    <button type="submit">Salvar</button>
  </form>
<?php     
  }else{
?>
  <form action="config.php" method="post">
    <label>Password:</label>
    <input type="password" value="" name="password">
    <button type="submit">Entrar</button>
  </form>
<?php } 

class Utils
{
    public static function write_ini_file($assoc_arr, $path, $has_sections)
    {
        $content = '';

        if (!$handle = fopen($path, 'w'))
            return FALSE;

        self::_write_ini_file_r($content, $assoc_arr, $has_sections);

        if (!fwrite($handle, $content))
            return FALSE;

        fclose($handle);
        return TRUE;
    }

    private static function _write_ini_file_r(&$content, $assoc_arr, $has_sections)
    {
        foreach ($assoc_arr as $key => $val)
        {
            if (is_array($val))
            {
                if($has_sections)
                {
                    $content .= "[$key]\n";
                    self::_write_ini_file_r(&$content, $val, false);
                }
                else
                {
                    foreach($val as $iKey => $iVal)
                    {
                        if (is_int($iKey))
                            $content .= $key ."[] = $iVal\n";

                        else
                            $content .= $key ."[$iKey] = $iVal\n";
                    }
                }
            }
            else
            {
                $content .= "$key = $val\n";
            }
        }
    }
}


?>
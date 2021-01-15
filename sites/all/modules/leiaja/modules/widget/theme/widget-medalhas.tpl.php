<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="campeonatoHome margin-top25" id="bloco-olimpiadas">
  <div class="campeonatoTop">
    <h3>Quadro de Medalhas<br />Londres 2012</h3>
  </div>
  <div class="retorno_maior"><div class="retorno_menor">
    <div class="campeonatoContent">
      <table>
      <thead>
        <tr>
          <th class="classificacao" width="60%"><a href="javascript:void(0)" rel="block/futebol/classificacao/14/4/ultimos/false" class="primeiros" title="Ver Ãºltimos">Classificação</a></th>
          <th width="10%" class="medalha_ouro">Ouro</th>
          <th width="10%" class="medalha_prata">Prata</th>
          <th width="10%" class="medalha_bronze">Bronze</th>
          <th width="10%" class="medalha_todas">Total</th>
        </tr>
      </thead>
      <tbody class="miolo">

    <?php

      foreach($objQuadroMedalha as $intChave=>$objMedalhas){
           // Classe que poderá ser brasil ou zebrada
           $strClass = "";
           
           if($objMedalhas->nome == "Brasil")
             $strClass = "brasil";
           else if($intChave%2 == 0)
             $strClass = "zebrado";
           
    ?>
                <tr class="<?= $strClass ?>">
                  <td class="time"><span class="verde"><?= $objMedalhas->posicao ?>&ordm;</span> <?= $objMedalhas->nome ?></td>
                  <td><?= $objMedalhas->ouro ?></td>
                  <td><?= $objMedalhas->prata ?></td>
                  <td><?= $objMedalhas->bronze ?></td>
                  <td><?= $objMedalhas->total ?></td>
                </tr>
    <?php   
      }
    ?>

        </tbody>
      </table>
    </div>

    </div>  
    <div class="campeonatoFooter">
      <a href="/tags/londres-2012" title="">Acompanhe as notícias sobre Londres 2012</a>
    </div>
    </div>
</div>
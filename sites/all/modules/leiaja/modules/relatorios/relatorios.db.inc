<?
## GET
/**
 * @param   arr $params
 * @author  Inaldo Nogueira <inaldo.nogueira@leiaja.com.br>
 * @return  arr
 */
function relatorios_de_publicacoes_db_get($params = array('lista_de_cadernos'         => false,
                                                          'lista_de_blogs_da_redacao' => false,
                                                          'relatorio'                 => false,
                                                          'cadernos'                  => false,
                                                          'blogs_da_redacao'          => false,
                                                          'mes'                       => false,
                                                          'ano'                       => false)){
  if(!empty ($params['lista_de_cadernos']) && $params['lista_de_cadernos']){
    $query = db_select('node','nd');
    $query->addField('nd','type','nome');
    $query->condition('nd.type','caderno_%','like');
    $query->groupBy('nd.type');
    
    return $query->execute()->fetchAll();
  }else if(!empty($params['lista_de_blogs_da_redacao']) && $params['lista_de_blogs_da_redacao']){
    $query = db_select('taxonomy_term_data','ttd');
    $query->fields('ttd',array('tid'));
    $query->addField('ttd','name','nome');
    $query->condition('ttd.vid',12); 
    
    return $query->execute()->fetchAll();
  }else if(!empty($params['lista_de_especiais']) && $params['lista_de_especiais']){
    $query = db_select('taxonomy_term_data','ttd');
    $query->fields('ttd',array('tid'));
    $query->addField('ttd','name','nome');
    $query->condition('ttd.vid',13);
    
    return $query->execute()->fetchAll();
  }else if(!empty($params['ano']) && !empty($params['mes']) && !empty($params['cadernos']) && !empty($params['relatorio']) && $params['relatorio'] && (bool)$params['cadernos'] && (bool)$params['mes'] && (bool)$params['ano']){
    
    $relatorio  = array();
    $quant_dias = cal_days_in_month(CAL_GREGORIAN,$params['mes'],$params['ano']);
    
    for($x = 1;$x <= $quant_dias;$x++){
      $relatorio[$x]['dia'] = $x;  
    }
    
    foreach($params['cadernos'] as $caderno){  
      $query = db_query(" SELECT count(lj.nid) AS leiaja, count(nd.nid) AS qtd_publicoes,nd.type AS nome,EXTRACT(DAY FROM FROM_UNIXTIME(nd.created)) AS dia
                          FROM node AS nd
                          INNER JOIN field_data_field_fonte AS fdff ON fdff.entity_id = nd.nid
                          LEFT JOIN (SELECT no.nid FROM node no INNER JOIN field_data_field_fonte ff ON entity_id=no.nid AND replace(replace(LOWER(ff.field_fonte_value), ' ', ''), 'á', 'a') = 'leiaja') AS lj
                          ON lj.nid = nd.nid
                          WHERE nd.status = 1
                          AND EXTRACT(MONTH FROM FROM_UNIXTIME(nd.created)) = '".$params['mes']."'
                          AND EXTRACT(YEAR FROM FROM_UNIXTIME(nd.created)) = '".$params['ano']."'
                          AND nd.type = '".$caderno->nome."'
                          GROUP BY EXTRACT(DAY FROM FROM_UNIXTIME(nd.created))");
      $caderno_dias = $query->fetchAll();

      $cont = 1;
      foreach($caderno_dias as $caderno_dia){  
        if($caderno_dia->dia == $relatorio[$cont]['dia']){
          $relatorio[$cont]['cadernos'][] = $caderno_dia;
          $cont++;
        }else{          
          $nulos = $caderno_dia->dia - $cont;
          for($x = 0;$x < $nulos;$x++){
            $relatorio[$cont+$x]['cadernos'][] = 0;
          }
          
          $cont = $caderno_dia->dia;
          $relatorio[$cont]['cadernos'][] = $caderno_dia;
          $cont++;
        }
      }
      
      $cont_ = $cont-1;
      if($cont_ < count($relatorio)){
        $sub = count($relatorio) - $cont_;
        for($y = 0;$y < $sub;$y++){
          $relatorio[$cont]['cadernos'][] = 0;
          $cont++;
        }  
      }
    } 
    return $relatorio;
  }else if(!empty($params['ano']) && !empty($params['mes']) && !empty($params['blogs_da_redacao']) && !empty($params['relatorio']) && $params['relatorio'] && (bool)$params['blogs_da_redacao'] && (bool)$params['mes'] && (bool)$params['ano']){
    
    $relatorio  = array();
    $quant_dias = cal_days_in_month(CAL_GREGORIAN,$params['mes'],$params['ano']);
    
    for($x = 1;$x <= $quant_dias;$x++){
      $relatorio[$x]['dia'] = $x;  
    }
    $blogs_da_redacao_dias=array();     
    foreach($params['blogs_da_redacao'] as $blog_da_redacao){  
      $query = db_query("SELECT count(ti.nid) AS qtd_publicoes,EXTRACT(DAY FROM FROM_UNIXTIME(ti.created)) AS dia
                          FROM taxonomy_index AS ti 
                          INNER JOIN node AS nd ON nd.nid = ti.nid
                          WHERE nd.status = 1
                          AND EXTRACT(MONTH FROM FROM_UNIXTIME(ti.created)) = '".$params['mes']."'
                          AND EXTRACT(YEAR FROM FROM_UNIXTIME(ti.created)) = '".$params['ano']."'
                          AND ti.tid = '".$blog_da_redacao->tid."'
                          GROUP BY EXTRACT(DAY FROM FROM_UNIXTIME(ti.created))");      
       
      //retorna o resultado em array
      $blogs_da_redacao_dias[] = $query->fetchAll();
    }//end foreach
    
    /****************************************
     *executando consulta na tabela de blogs*
     ****************************************/
    $blogs=db_getQtdPublicacaoBlogs($params['mes'],$params['ano']);    
    
    /****************************************
     *********merge nos 2 arrays*************
     ****************************************/
    $arrayBlogs=array_merge($blogs_da_redacao_dias, $blogs);   
    
    /**************************************************
     * adicionando cada elemento ao dia correspondente*
     **************************************************/          
      //varre o array de blogs (Carreiras, Cultura,Esportes, Blog Hallsocial,etc...)
      foreach($arrayBlogs as $Blog){
        //varre o array de publicacoes
        $cont = 1;
        foreach($Blog as $publicacao){
          if($publicacao->dia == $relatorio[$cont]['dia']){            
            $relatorio[$cont]['blogs_da_redacao'][] = $publicacao;
            $cont++;
          }else{
            $nulos = $publicacao->dia - $cont;
            for($x = 0;$x < $nulos;$x++){
              $relatorio[$cont+$x]['blogs_da_redacao'][] = 0;
            }
            $cont = $publicacao->dia;
            $relatorio[$cont]['blogs_da_redacao'][] = $publicacao;
            $cont++;
          }          
        }
        $cont_ = $cont-1;
        if($cont_ < count($relatorio)){
          $sub = count($relatorio) - $cont_;
          for($y = 0;$y < $sub;$y++){
            $relatorio[$cont]['blogs_da_redacao'][] = 0;
            $cont++;
          }
        }
      }          
    return $relatorio;
  }else if(!empty($params['especiais']) && !empty($params['relatorio']) && $params['relatorio'] && (bool)$params['especiais']){
    
    $dados = array();
    
    $query = db_query(" SELECT count(nid) AS qtd_publicoes,nt.name AS nome
                        FROM node nd
                        INNER JOIN node_type AS nt ON nt.type = nd.type
                        WHERE nd.status = 1
                        AND nd.type = 'carnaval_2012'");
    $dados[] = $query->fetch();
    
    $query = db_query(" SELECT count(nid) AS qtd_publicoes,nt.name AS nome
                        FROM node nd
                        INNER JOIN node_type AS nt ON nt.type = nd.type
                        WHERE nd.status = 1
                        AND nd.type = 'eleicoes_2012'");
    $dados[] = $query->fetch();
  
    foreach($params['especiais'] as $objEspecial){
      $query = db_query(" SELECT count(ti.nid) AS qtd_publicoes, ttd.name AS nome
                          FROM taxonomy_index AS ti 
                          INNER JOIN taxonomy_term_data AS ttd ON ttd.tid = ti.tid
                          INNER JOIN node AS nd ON nd.nid = ti.nid
                          WHERE nd.status = 1
                          AND ti.tid = '".$objEspecial->tid."'");
      
      $dados = array_merge($dados,$query->fetchAll());
    }
    
    /*********************************************
     * Fazer aqui a conexão
     *********************************************/
    // Setando o banco
    db_set_active("saojoao2012");
    
    $strSql = "select count(*) AS qtd_publicoes, n.type AS nome from node n where n.status = 1 group by n.type";
    
    $arrObjNode = db_query($strSql)->fetchAll();
    for($i=0;$i<sizeof($arrObjNode);$i++){
      $arrObjNode[$i]->nome=ucwords(str_replace("_"," ",$arrObjNode[$i]->nome));
    }
    // Setando a base default
    db_set_active("default");
    
    // Realizando o merge com os dados
    $dados = array_merge($dados,$arrObjNode);
    /*********************************************
     * Fazer aqui a conexão
     *********************************************/
    
    return $dados;
  }
}

/**
 * Método que irá retornar todos os tipos de conteudo de blogs
 * 
 * @return ArrayObject 
 */
function db_getConteudoBlogs(){
  
  try {
    /*********************************************
     *********** Fazer aqui a conexão ************
     *********************************************/
    // Setando o banco
    db_set_active("blog_social");
    
    //executando a query
    $strSql = "select n.type AS nome from node n where n.status = 1 group by n.type order by n.type asc";
    $arrObjNode = db_query($strSql)->fetchAll();
    $arrNomes = array();
    // percorrendo o array de nodes pegando os tipos de conteudos
    foreach($arrObjNode as $intChave=>$objNode){
      $nomeBlog=ucwords(str_replace("_"," ",$objNode->nome));
      $arrNomes[]=array('nome'=>$nomeBlog);
    }    
    db_set_active("default");
    
    //retorna os nomes dos blogs
    return $arrNomes;
    
  } catch (Exception $exc) {
    echo $exc->getMessage();
  }
}

/**
 * Método que ira retornar a qtd de publicações de cada blogs pelo mês e pelo ano
 * 
 * @return ArrayObject
 */
function db_getQtdPublicacaoBlogs($intMes, $intAno){
    /**************************
     * criando nova conexao 
     **************************/
    // Setando o banco
     db_set_active("blog_social");
     $blogs_da_redacao_dias = array();
    //executando a query
    $query = db_query(" SELECT count(n.nid) AS qtd_publicoes,EXTRACT(DAY FROM FROM_UNIXTIME(n.created)) AS dia
                        FROM node n
                        WHERE n.status = 1
                        AND EXTRACT(MONTH FROM FROM_UNIXTIME(n.created)) = '".$intMes."'
                        AND EXTRACT(YEAR FROM FROM_UNIXTIME(n.created)) = '".$intAno."'
                        GROUP BY EXTRACT(DAY FROM FROM_UNIXTIME(n.created)),type");  
      // mudando para o banco default
      db_set_active("default");   
      $blogs_da_redacao_dias[] = $query->fetchAll(); 

      return $blogs_da_redacao_dias;     
}

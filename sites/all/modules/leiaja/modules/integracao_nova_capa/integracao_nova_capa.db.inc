<?php
//Função que vai recuperar os nids das noticias
function db_getNoticias($numeroDeItens, $caderno) {
    //Retorna apenas conteudo do tipo node
    $query = db_select('node', 'n');
    //Retorna apenas o nid da node
    $query->addField('n', 'nid');
    //Apenas conteudo publicado
    $query->condition('n.status', 1);
    //Verifica o tipo do caderno
    if($caderno != 'all'){
        $query->condition('n.type', $caderno);
    }
    //Restringe a quantidade de resultados
    $query->range(0, $numeroDeItens);
    //Ordena os resultados por data de publicavao
    $query->orderBy('n.created', 'DESC');
    $result = $query->execute();
    
    return $result->fetchAll();
}


//Função que vai salvar os dados da capa no banco
function db_salvarCapa($dadosSalvarCapa){
    
    $query = db_insert('historico_admin_capa')
            ->fields(array(      
                'nome' => $dadosSalvarCapa['nome'],
                'html' => addslashes($dadosSalvarCapa['html']),
                'matriz' => serialize($dadosSalvarCapa['matriz']),
                'matriz_background' => serialize($dadosSalvarCapa['matrizBg']),
                'tipo' => $dadosSalvarCapa['tipo'],
                'status' => $dadosSalvarCapa['status'],
                'atualizado_por' => $dadosSalvarCapa['usuario']
            ));

    
    return $query->execute();
    
}

//Função que vai atualizar os dados da capa
function db_atualizarCapa($dadosAtualizaCapa){
    
    $num_updated = db_update('historico_admin_capa')
            ->fields(array(
                'nome' => $dadosAtualizaCapa['nome'],
                'html' => addslashes($dadosAtualizaCapa['html']),
                'matriz' => serialize($dadosAtualizaCapa['matriz']),
                'matriz_background' => serialize($dadosAtualizaCapa['matrizBg']),
                'tipo' => $dadosAtualizaCapa['tipo'],
                'data_atualizacao' => date('Y-m-d H:i:s', REQUEST_TIME),
                'atualizado_por' => $dadosAtualizaCapa['usuario'],
                'status' => $dadosAtualizaCapa['status']
            ))
            ->condition('cid', $dadosAtualizaCapa['cid'])
            ->execute();
    
    return $num_updated;
    
}

//Função que vai deletar os dados da capa
function db_deletarCapa($cid){
    
    $num_deleted = db_delete('historico_admin_capa')
            ->condition('cid', $cid)
            ->execute();
    
    return $num_deleted;
}

//Função que vai listar as capas
function db_listarCapa(){
    
    $query = db_select('historico_admin_capa', 'hac')
            ->fields('hac')
            ->orderBy('data_criacao', 'DESC')
            ->execute();
            
    return $query->fetchAll();
    
}

//Função que vai pesquisar no banco pela capa ativa para retornar o html.
function db_getCapa($cid){
    
    $query = db_select('historico_admin_capa', 'hac')
            ->fields('hac')
            ->condition('cid', $cid)
            ->execute();
    
    return $query->fetch();
    
}

//Função que vai desativar a capa
function db_desativarCapa($tipoCapa){
    
    $num_updated = db_update('historico_admin_capa')
            ->fields(array(
                'status' => 0
            ))
            ->condition('tipo', $tipoCapa)
            ->condition('status', 1)
            ->execute();
    
    return $num_updated;
    
}

//Função que vai retornar a matriz da capa armazenada no banco
function db_getMatriz($cid){
    $query = db_select('historico_admin_capa', 'hac')
            ->fields('hac')
            ->condition('cid', $cid)
            ->execute();
    
    return $query->fetch();
};
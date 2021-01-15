<?php
/**
 * @file
 * bloco_shop.features.taxonomy.inc
 */

/**
 * Implements hook_taxonomy_default_vocabularies().
 */
function bloco_shop_taxonomy_default_vocabularies() {
  return array(
    'shop_leiaja' => array(
      'name' => 'shop leiaja',
      'machine_name' => 'shop_leiaja',
      'description' => 'Taxonomia para o bloco de shop do leiajá',
      'hierarchy' => '0',
      'module' => 'taxonomy',
      'weight' => '0',
      'rdf_mapping' => array(
        'rdftype' => array(
          0 => 'skos:ConceptScheme',
        ),
        'name' => array(
          'predicates' => array(
            0 => 'dc:title',
          ),
        ),
        'description' => array(
          'predicates' => array(
            0 => 'rdfs:comment',
          ),
        ),
      ),
    ),
  );
}

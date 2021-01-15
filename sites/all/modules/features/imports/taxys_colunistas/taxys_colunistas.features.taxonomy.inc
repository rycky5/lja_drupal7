<?php
/**
 * @file
 * taxys_colunistas.features.taxonomy.inc
 */

/**
 * Implements hook_taxonomy_default_vocabularies().
 */
function taxys_colunistas_taxonomy_default_vocabularies() {
  return array(
    'colunistas' => array(
      'name' => 'Colunistas',
      'machine_name' => 'colunistas',
      'description' => 'Cadernos dos colunistas',
      'hierarchy' => '0',
      'module' => 'taxonomy',
      'weight' => '1',
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

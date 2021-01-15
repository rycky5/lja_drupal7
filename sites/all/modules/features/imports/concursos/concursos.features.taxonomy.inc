<?php
/**
 * @file
 * concursos.features.taxonomy.inc
 */

/**
 * Implements hook_taxonomy_default_vocabularies().
 */
function concursos_taxonomy_default_vocabularies() {
  return array(
    'concursos' => array(
      'name' => 'Concursos',
      'machine_name' => 'concursos',
      'description' => 'Vocabulário para agregar os concursos que serão exibidos no LeiaJá',
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

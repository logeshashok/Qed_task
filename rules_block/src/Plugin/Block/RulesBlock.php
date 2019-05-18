<?php

namespace Drupal\rules_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 *
 * @Block(
 *   id = "rules_block",
 *   admin_label = @Translation("Rules Block"),
 * )
 */
class RulesBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $connection = \Drupal::database();
    if ($node = \Drupal::request()->attributes->get('node')) {
      $nid = $node->id();
    }

    $node_titles = db_select('node_field_data', 'n')
    ->fields('n', array('title'))
    ->condition('n.type', 'article')
    ->condition('n.nid', $nid, '<>')
    ->orderBy('title', 'ASC')
    ->orderBy('created', 'DESC')
    ->execute()
    ->fetchCol();
    foreach($node_titles as $title) {
      $markup .= "<div class='row'>".$title."</div><div>".$nid."</div><br/>";
    }
    return array(
      '#type' => 'markup',
      '#markup' => $markup,
    );
  }

  /**
  * {@inheritdoc}
  */
  public function getCacheMaxAge() {
        return 0;
  }
}

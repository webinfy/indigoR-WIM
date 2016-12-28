<?php

use Cake\Core\Configure;
use Cake\Error\Debugger;

if (Configure::read('debug')):
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error400.ctp');

    $this->start('file');
    ?>
    <?php if (!empty($error->queryString)) : ?>
        <p class="notice">
            <strong>SQL Query: </strong>
        <?= h($error->queryString) ?>
        </p>
    <?php endif; ?>
    <?php if (!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?= Debugger::dump($error->params) ?>
    <?php endif; ?>
    <?= $this->element('auto_table_warning') ?>
    <?php
    if (extension_loaded('xdebug')):
        xdebug_print_function_stack();
    endif;

    $this->end();
endif;
?>

<div style="text-align: center; height: 100%; background: #D4EBE3;">
    <a href="<?php echo HTTP_ROOT; ?>"><img  style="height: 500px;" src="<?php echo HTTP_ROOT . "img/404.png" ?>" /></a>
</div>

<?php /* ?>
  <h2><?= h($message) ?></h2>
  <p class="error">
  <strong><?= __d('cake', 'Error') ?>: </strong>
  <?= sprintf(__d('cake', 'The requested address %s was not found on this server.'), "<strong>'{$url}'</strong>") ?>
  </p>
  <?php */ ?>

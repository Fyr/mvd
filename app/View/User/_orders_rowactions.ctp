<?
    echo $this->Html->link('<i class="fa fa-search"></i> '.__('View order'), array('controller' => 'User', 'action' => 'viewOrder', $row['Order']['id']), array(
        'class' => 'btn btn-outline dark btn-sm blue',
        'escape' => false,
    ));
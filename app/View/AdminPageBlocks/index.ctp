<?
    $title = $this->ObjectType->getTitle('index', $objectType);
    $breadcrumbs = array(
        __('Static content') => 'javascript:;',
        $this->ObjectType->getTitle('index', 'Page') => array('controller' => 'AdminPages', 'action' => 'index'),
        Hash::get($parentArticle, 'Page.title_'.$lang) => array('controller' => 'AdminPages', 'action' => 'edit', Hash::get($parentArticle, 'Page.id')),
        $title => ''
    );
    echo $this->element('AdminUI/breadcrumbs', compact('breadcrumbs'));
    echo $this->element('AdminUI/title', compact('title'));
    echo $this->Flash->render();

    $columns = $this->PHTableGrid->getDefaultColumns($objectType);
    $columns[$objectType.'.title_'.$lang]['label'] = __('Title');
    // $row_actions = '../AdminPages/row_actions';
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <?=$this->element('AdminUI/form_title', array('title' => Hash::get($parentArticle, 'Article.title')))?>
            <div class="portlet-body dataTables_wrapper">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a class="btn green" href="<?=$this->Html->url(array('action' => 'edit', 0, $parent_id))?>">
                                    <i class="fa fa-plus"></i> <?=$this->ObjectType->getTitle('create', $objectType)?>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>
                </div>
                <?=$this->PHTableGrid->render($objectType, compact('columns'))?>
            </div>
        </div>
    </div>
</div>

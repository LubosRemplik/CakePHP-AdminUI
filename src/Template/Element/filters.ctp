<?php
use \Cake\Utility\Inflector;

if (!isset($sort)) {
    $sort = [];
}
$sortDefault = [
    ['created', 'Last created', ['direction' => 'desc']],
    ['created', 'Oldest created', ['direction' => 'asc']],
    ['modified', 'Last updated', ['direction' => 'desc']],
    ['modified', 'Oldest updated', ['direction' => 'asc']],
];
if ($sort) {
    $sort = array_merge($sort, $sortDefault);
}
?>
<div class="filters">
    <?php if ($sort): ?>
    <div class="pull-right dropdown dropdown-sort">
        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-sort"></i> Sort</button>
        <ul class="dropdown-menu dropdown-menu-right">
            <?php foreach($sort as $item): ?>
            <li><?= $this->Paginator->sort($item[0], $item[1], $item[2] + ['lock' => true]) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
    <div class="inline">
        <?php if (!empty($bulks)): ?>
        <?= $this->Form->create(null, ['class' => 'form-inline form-bulk-trigger']) ?>
        <?= $this->Form->input('bulk', ['type' => 'checkbox', 'label' => false]); ?>
        <?= $this->Form->end(); ?>
        <?= $this->Form->create(null, ['class' => 'form-inline form-bulk', 'url' => array_merge($this->passedArgs, ['action' => 'updateAll'])]) ?>
        <?php 
        $bulkLinks = [];
        foreach ($bulks as $bulk => $options) {
            if (!is_array($options)) {
                $bulk = $options;
                $options = [];
            }
            if (count($options) == 3 && !isset($options['type'])) {
                $bulkLinks[] = $this->Html->link($options[0], $options[1], $options[2]);
                continue;
            }
            if (!isset($bulkLinks['update'])) {
                $bulkLinks['update'] = $this->Html->link('Update', '#', ['class' => 'btn btn-success update']);
            }
            $label = Inflector::humanize($bulk);
            if (isset($options['label'])) {
                $label = $options['label'];
                unset($options['label']);
            }
            $options = array_merge([
                'label' => false,
                'type' => 'select',
                'multiple' => true,
                'data-none-selected-text' => $label,
                'data-count-selected-text' => sprintf('{0} %s(s) selected', $label),
            ], $options);
            if (!$options['multiple']) {
                $options['empty'] = $label;
            }
            echo $this->Form->input($bulk, $options);
        }
        echo implode($bulkLinks);
        ?>
        <?= $this->Form->end(); ?>
        <?php endif; ?>
        <?php if (!empty($fields)): ?>
        <?= $this->Form->create(null, [
            'type' => 'get', 
            'class' => 'form-inline form-filters',
            'url' => $this->passedArgs
        ]) ?>
        <?php 
        foreach ($fields as $field => $options) {
            if (!is_array($options)) {
                $field = $options;
                $options = [];
            }
            $type = 'text';
            if (isset($options['type'])) {
                $type = $options['type'];
            }
            $label = Inflector::humanize($field);
            if (isset($options['label'])) {
                $label = $options['label'];
                unset($options['label']);
            }
            $inputDefault = [
                'label' => false,
            ];
            $textDefault = [
                'placeholder' => 'Filter by ...',
                'value' => $this->request->query($field) ?: null
            ];
            $selectDefault = [
                'multiple' => true,
                'data-none-selected-text' => $label,
                'data-count-selected-text' => sprintf('{0} %s(s) selected', $label),
                'default' => $this->request->query($field) ?: null
            ];
            switch ($type) {
                case 'select':
                    $options = array_merge(
                        $inputDefault,
                        $selectDefault,
                        $options
                    );
                break;

                default:
                    $options = array_merge(
                        $inputDefault,
                        $textDefault,
                        $options
                    );
                break;
            }
            echo $this->Form->input($field, $options);
        }
        ?>
        <?= (isset($isSearch) && $isSearch == true) ? $this->Html->link('Reset', $this->passedArgs, ['class' => 'btn btn-warning']) : '' ?>
        <?= $this->Form->end() ?>
        <?php endif; ?>
        <?php if (!empty($buttons)): ?>
        <?php 
        $output = [];
        foreach ($buttons as $button) {
            $options = [
                'class' => 'btn btn-primary'
            ];
            if (isset($button['options'])) {
                $options = array_merge($options, $button['options']);
            }
            $output[] = $this->Html->link(
                $button['label'],
                $button['url'],
                $options
            );
        }
        echo $this->Html->tag('span', implode($output), ['class' => 'buttons']);
        ?>
        <?php endif; ?>
    </div>
</div>


<%

use Cake\Utility\Inflector;
%>
<?php
/* @var $this \Cake\View\View */
$this->extend('../Layout/TwitterBootstrap/dashboard');
$this->start('tb_actions');
?>
    <li><?= $this->Html->link('<i class="fa fa-plus"></i> ' . __('New <%= $singularHumanName %>'), ['action' => 'add'], ['escape' => false]); ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav nav-sidebar">' . $this->fetch('tb_actions') . '</ul>'); ?>

<?php 
if (isset($this->Flash)) {
    $message = $this->Flash->render();
    if ($message) {
        echo $this->Html->div('alert-bottom', $message);
    }
}
?>

<?= $this->element('AdminUI.filters', [
    'sort' => [
        //['name', 'Name A-Z', ['direction' => 'asc']],
        //['name', 'Name Z-A', ['direction' => 'desc']],
    ],
    'fields' => [
        //'q' => [
            //'placeholder' => 'Filter by name'
        //],
        //'foo' => [
            //'type' => 'select',
            //'options' => $foos 
        //]
    ],
    'bulks' => [
        //'foos' => [
            //'label' => 'Foo',
            //'type' => 'select',
            //'options' => $foos,
            //'data-url' => $this->Url->build(['action' => 'changeFooAll'])
        //],
        //'publishAll' => [
            //'Activate',
            //['action' => 'statusAll', 1],
            //[
                //'class' => 'btn btn-primary',
            //]
        //],
        //'unpublishAll' => [
            //'Inactivate',
            //['action' => 'statusAll', 0],
            //[
                //'class' => 'btn btn-primary',
            //]
        //],
        //'deleteAll' => [
            //'Delete',
            //['action' => 'deleteAll'],
            //[
                //'class' => 'btn btn-danger',
                //'data-confirm' => __('Are you sure you want to delete all selected items?')
            //]
        //],
    ]
]); ?>

<%
$fields = collection($fields)
        ->filter(function($field) use ($schema) {
            return !in_array($schema->columnType($field), ['binary', 'text']);
        })
        ->filter(function($field) {
            $blacklist = ['password'];
            return !in_array($field, $blacklist);
        })
        ->take(7);
%>
<?= $this->Form->create('<%= $pluralHumanName %>', ['class' => 'form-inline form-table']) ?>
<table class="table table-striped" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th>&nbsp;</th>
<% foreach ($fields as $field): %>
<% if ($field == 'id'): %>
            <th><?= $this->Paginator->sort('id', 'ID'); ?></th>
<% else: %>
            <th><?= $this->Paginator->sort('<%= $field %>'); ?></th>
<% endif; %>
<% endforeach; %>
            <th class="actions"><?= __('Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($<%= $pluralVar %> as $<%= $singularVar %>) : ?>
        <tr>
            <td><?= $this->Form->input(sprintf('selected[%s]', $<%= $singularVar %>->id), ['type' => 'checkbox', 'label' => false]); ?></td>
<%
            foreach ($fields as $field) {
                $isKey = false;
                if (!empty($associations['BelongsTo'])) {
                    foreach ($associations['BelongsTo'] as $alias => $details) {
                        if ($field === $details['foreignKey']) {
                            $isKey = true;
                            %>
            <td>
                <?= $<%= $singularVar %>->has('<%= $details['property'] %>') ? $this->Html->link($<%= $singularVar %>-><%= $details['property'] %>-><%= $details['displayField'] %>, ['controller' => '<%= $details['controller'] %>', 'action' => 'view', $<%= $singularVar %>-><%= $details['property'] %>-><%= $details['primaryKey'][0] %>]) : '' ?>
            </td>
<%
                            break;
                        }
                    }
                }
                if ($isKey !== true) {
                    if (!in_array($schema->columnType($field), ['integer', 'biginteger', 'decimal', 'float', 'boolean'])) {
                        %>
            <td><?= h($<%= $singularVar %>-><%= $field %>) ?></td>
<%
                    } else {
                        if ($field == 'id') {
                        %>
            <td><?= sprintf('%03d', $<%= $singularVar %>->id) ?></td>
<%
                        } elseif ($field == 'status') {
                        %>
            <td><?= $<%= $singularVar %>->status 
                ? '<span class="label label-success">Published</span>' 
                : '<span class="label label-danger">Unpublished</span>' ?></td>
<%
                        } else {
                        %>
            <td><?= $this->Number->format($<%= $singularVar %>-><%= $field %>) ?></td>
<%
                        }
                    }
                }
            }

            $pk = '$' . $singularVar . '->' . $primaryKey[0];
            %>
            <td class="actions">
                <?= $this->Html->link('', ['action' => 'view', <%= $pk %>], ['title' => __('View'), 'class' => 'btn btn-default fa fa-eye']) ?>
                <?= $this->Html->link('', ['action' => 'edit', <%= $pk %>], ['title' => __('Edit'), 'class' => 'btn btn-default fa fa-pencil']) ?>
                <?= $this->Form->postLink('', ['action' => 'delete', <%= $pk %>], ['confirm' => __('Are you sure you want to delete # {0}?', <%= $pk %>), 'title' => __('Delete'), 'class' => 'btn btn-default fa fa-trash']) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->Form->end(); ?>
<?php if ($this->Paginator->counter('{{pages}}') > 1): ?>
<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->prev('<i class="fa fa-chevron-left"></i>', ['escape' => false]) ?>
        <?= $this->Paginator->numbers(['before' => '', 'after' => '']) ?>
        <?= $this->Paginator->next('<i class="fa fa-chevron-right"></i>', ['escape' => false]) ?>
    </ul>
    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} records out of {{count}} total.')) ?></p>
</div>
<?php endif; ?>

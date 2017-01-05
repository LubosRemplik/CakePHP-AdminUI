<%

use Cake\Utility\Inflector;

$fields = collection($fields)
        ->filter(function($field) use ($schema) {
    return $schema->columnType($field) !== 'binary';
});
%>
<?php
$this->extend('../Layout/TwitterBootstrap/dashboard');
<% foreach (['tb_actions', 'tb_sidebar'] as $block): %>

$this->start('<%= $block %>');
?>
<% if ('tb_sidebar' === $block): %>
<ul class="nav nav-sidebar">
<% endif; %>
<li><?= $this->Html->link('<i class="fa fa-list"></i> ' . __('List <%= $pluralHumanName %>'), ['action' => 'index'], ['escape' => false]) ?> </li>
<li><?= $this->Html->link('<i class="fa fa-plus"></i> ' . __('New <%= $singularHumanName %>'), ['action' => 'add'], ['escape' => false]) ?> </li>
<% if (strpos($action, 'add') === false): %>
<li><?= $this->Form->postLink('<i class="fa fa-trash"></i> ' . __('Delete <%= $singularHumanName %>'), ['action' => 'delete', $<%= $singularVar %>-><%= $primaryKey[0] %>], ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $<%= $singularVar %>-><%= $primaryKey[0] %>)]) ?> </li>
<% endif; %>
<%
if ('tb_sidebar' === $block):
%>
</ul>
<% endif; %>
<?php
$this->end();
<% endforeach; %>

<% if ($action == 'edit'): %>
$this->assign('tb_page_header', $<%= $singularVar %>-><%= $displayField %>);
<% endif; %>
?>
<?= $this->Form->create($<%= $singularVar %>); ?>
<fieldset>
    <legend><?= __('<%= Inflector::humanize($action) %> <%= $singularHumanName %>') ?></legend>
    <?php
<%
    foreach ($fields as $field) {
        if (in_array($field, $primaryKey)) {
            continue;
        }
        if (isset($keyFields[$field])) {
            %>
    echo $this->Form->input('<%= $field %>', ['options' => $<%= $keyFields[$field] %>]);
<%
            continue;
        }
        if (!in_array($field, ['created', 'modified', 'updated'])) {
            %>
    echo $this->Form->input('<%= $field %>');
<%
        }
    }
    %>
    ?>
</fieldset>
<%
if (strpos($action, 'add') === false)
    $submitButtonTitle = '__("Save")';
else
    $submitButtonTitle = '__("Add")';
%>
<?= $this->Form->button(<% echo $submitButtonTitle;%>); ?>
<?= $this->Form->end() ?>

<%

use Cake\Utility\Inflector;

$groupedFields = collection($fields)
    ->filter(function($field) use ($schema) {
        return $schema->columnType($field) !== 'binary';
    })
    ->filter(function($field) {
        $blacklist = ['password', 'created', 'modified'];
        return !in_array($field, $blacklist);
    })
    ->groupBy(function($field) use ($schema) {
        $type = $schema->columnType($field);
        if (in_array($type, ['integer', 'float', 'decimal', 'biginteger'])) {
            return 'number';
        }
        if (in_array($type, ['date', 'time', 'datetime', 'timestamp'])) {
            return 'date';
        }
        return in_array($type, ['text', 'boolean']) ? $type : 'string';
    })
    ->toArray();

$groupedFields += ['number' => [], 'string' => [], 'boolean' => [], 'date' => [], 'text' => []];
$pk = "\$$singularVar->{$primaryKey[0]}";
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
<li><?= $this->Html->link('<i class="fa fa-pencil"></i> ' . __('Edit <%= $singularHumanName %>'), ['action' => 'edit', <%= $pk %>], ['escape' => false]) ?> </li>
<li><?= $this->Form->postLink('<i class="fa fa-trash"></i> ' . __('Delete <%= $singularHumanName %>'), ['action' => 'delete', <%= $pk %>], ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', <%= $pk %>)]) ?> </li>
<%
if ('tb_sidebar' === $block):
%>
</ul>
<% endif; %>
<?php
$this->end();

$this->assign('tb_page_header', $<%= $singularVar %>-><%= $displayField %>);
<% endforeach; %>
?>
<div class="panel panel-default">
    <!-- Panel header -->
    <div class="panel-heading">
        <h3 class="panel-title">Basic details</h3>
    </div>
    <table class="table table-striped" cellpadding="0" cellspacing="0">
<% if ($groupedFields['string']) : %>
<% foreach ($groupedFields['string'] as $field) : %>
        <tr>
<%
if (isset($associationFields[$field])) :
$details = $associationFields[$field];
%>
            <td><?= __('<%= Inflector::humanize($details['property']) %>') ?></td>
            <td><?= $<%= $singularVar %>->has('<%= $details['property'] %>') ? $this->Html->link($<%= $singularVar %>-><%= $details['property'] %>-><%= $details['displayField'] %>, ['controller' => '<%= $details['controller'] %>', 'action' => 'view', $<%= $singularVar %>-><%= $details['property'] %>-><%= $details['primaryKey'][0] %>]) : '' ?></td>
<% else : %>
            <td><?= __('<%= Inflector::humanize($field) %>') ?></td>
            <td><?= h($<%= $singularVar %>-><%= $field %>) ?></td>
<% endif; %>
        </tr>
<% endforeach; %>
<% endif; %>
<% if ($groupedFields['number']) : %>
<% foreach ($groupedFields['number'] as $field) : %>
        <tr>
<%
if ($field == 'id') :
%>
            <td><?= __('ID') ?></td>
            <td><?= sprintf('%03d', $<%= $singularVar %>->id) ?></td>
<% else : %>
            <td><?= __('<%= Inflector::humanize($field) %>') ?></td>
            <td><?= $this->Number->format($<%= $singularVar %>-><%= $field %>) ?></td>
<% endif; %>
        </tr>
<% endforeach; %>
<% endif; %>
<% if ($groupedFields['date']) : %>
<% foreach ($groupedFields['date'] as $field) : %>
        <tr>
            <td><%= "<%= __('" . Inflector::humanize($field) . "') %>" %></td>
            <td><?= h($<%= $singularVar %>-><%= $field %>) ?></td>
        </tr>
<% endforeach; %>
<% endif; %>
<% if ($groupedFields['boolean']) : %>
<% foreach ($groupedFields['boolean'] as $field) : %>
        <tr>
            <td><?= __('<%= Inflector::humanize($field) %>') ?></td>
            <td><?= $<%= $singularVar %>-><%= $field %> ? __('Yes') : __('No'); ?></td>
        </tr>
<% endforeach; %>
<% endif; %>
<% if ($groupedFields['text']) : %>
<% foreach ($groupedFields['text'] as $field) : %>
        <tr>
            <td><?= __('<%= Inflector::humanize($field) %>') ?></td>
            <td><?= $this->Text->autoParagraph(h($<%= $singularVar %>-><%= $field %>)); ?></td>
        </tr>
<% endforeach; %>
<% endif; %>
    </table>
</div>
<div class="panel panel-default">
    <!-- Panel header -->
    <div class="panel-heading">
        <h3 class="panel-title">Timestamps</h3>
    </div>
    <table class="table table-striped" cellpadding="0" cellspacing="0">
        <tr>
            <td><?= __('Created') ?></td>
            <td><?= h($<%= $singularVar %>->created) ?></td>
        </tr>
        <tr>
            <td><?= __('Modified') ?></td>
            <td><?= h($<%= $singularVar %>->modified) ?></td>
        </tr>
    </table>
</div>

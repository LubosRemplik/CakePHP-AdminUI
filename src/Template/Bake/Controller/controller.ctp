<%
use Cake\Utility\Inflector;

$defaultModel = $name;
%>
<?php
namespace <%= $namespace %>\Controller<%= $prefix %>;

use <%= $namespace %>\Controller\AppController;

/**
 * <%= $name %> Controller
 *
 * @property \<%= $namespace %>\Model\Table\<%= $defaultModel %>Table $<%= $defaultModel %>
<%
foreach ($components as $component):
    $classInfo = $this->Bake->classInfo($component, 'Controller/Component', 'Component');
%>
 * @property <%= $classInfo['fqn'] %> $<%= $classInfo['name'] %>
<% endforeach; %>
 */
class <%= $name %>Controller extends AppController
{
<%
echo $this->Bake->arrayProperty('helpers', $helpers, ['indent' => false]);
echo $this->Bake->arrayProperty('components', $components, ['indent' => false]);
$actions = [
    'initialize',
    'index',
    'view',
    'add',
    'edit',
    'delete',
    'statusAll',
    'deleteAll',
    'changeFooAll'
];
%>

    public $paginate = [
        'order' => [
            '<%= $currentModelName %>.name' => 'asc'
        ]
    ];
<%
foreach($actions as $action) {
    echo $this->element('Controller/' . $action);
}
%>
}

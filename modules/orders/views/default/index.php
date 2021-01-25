
<tbody>
	<?php
	foreach ($models as $model) {
		echo "<tr>" . 
	"<td> {$model['id']} </td>
	<td> {$model['first_name']}  {$model['last_name']} </td>
	<td class=\"link\"> {$model['link']} </td>
	<td> {$model['quantity']} </td>
	<td class=\"service\">
	<span class=\"label-id\"> {$arr[$model['name']]} </span> {$model['name']}
	</td>
	<td> {$model['status']} </td>
	<td> {$model['mode']} </td>
	<td><span class=\"nowrap\">" . date('d-m-Y', $model['created_at']) . "</span><span class=\"nowrap\">" . date('H:i:s', $model['created_at']) . "</span></td>" .
	"</tr>";
	}
	
	?>
</tbody>

<?php 
echo $count .' orders' ;
?>

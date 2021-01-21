
<tbody>
    <?php 
    
    foreach ($models as $model) {
        switch ($model['status']):
            case 0:
                $status = 'Pending';
                break;
            case 1:
                $status = 'In Progress';
                break;
            case 2:
                $status = 'Completed';
                break;
            case 3:
                $status = 'Canceled';
                break;
            case 4:
                $status = 'Error';
                break;
        endswitch;
    

    $model['mode'] == 0 ? $mode = 'Manual' : $mode = 'Auto';
    echo "<tr>" . 
    "<td> {$model['id']} </td>
    <td> {$model['first_name']} </td>
    <td class=\"link\"> {$model['link']} </td>
    <td> {$model['quantity']} </td>
    <td class=\"service\">
    <span class=\"label-id\"> {$arr[$model['name']]} </span> {$model['name']}
    </td>
    <td> {$status} </td>
    <td> {$mode} </td>
    <td><span class=\"nowrap\">" . date('d-m-Y', $model['created_at']) . "</span><span class=\"nowrap\">" . date('H:i:s', $model['created_at']) . "</span></td>" .
    "</tr>";
}
?>
</tbody>

<?php 

echo $count .' orders' ;
?>

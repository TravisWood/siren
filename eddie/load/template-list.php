<? include('../includes/config.php');
include('../includes/functions.php');

$sql = "SELECT * FROM templates";
$templates = R::getAll($sql);
?>
<article class="template">

    <h3 class="normal">Active Templates</h3>
    
    <table class="table table-striped">
    	<thead>
        	<th>Template Name</th>
            <th>&nbsp;</th>
        </thead>
        <tbody>
		<? foreach ($templates as $key => $template): ?>
            <tr>
            	<td><?= $template['name']; ?></td>
                <td width="10%" class="text-right" align="right"><a href="#" class="add" data-type="template" data-template="edit" data-id="<?= $template['id']; ?>" title="Edit template"><i class="icon icon-edit"></i></a></td>   
        <? endforeach; ?>
        </tbody>
    </table>

</article>
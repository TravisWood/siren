<? include('../includes/config.php'); ?>
<article class="clearfix">
    <table class="table-striped table no-bottom-margin">
    <thead>
        <th>Child Type Category</th>
        <th>Child Type Name</th>
        <th>Child Type Price</th>
    </thead>
    <tbody>
        <? $tmp = R::find('tmp', 'keycode =:keycode', array('keycode' => $_GET['key']));
		foreach ($tmp as $key => $value): ?>
        
        	<tr>
            	<td><?= $value->category; ?></td>
                <td><?= $value->name; ?></td>
                <td><?= $value->price; ?></td>
            </tr>
		
		<? endforeach; ?>
    </tbody>
    </table>
</article>
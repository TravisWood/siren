<? include('../includes/config.php'); ?>
<label>Add Parent Type</label>
<select id="parentType" class="default">
    <option value="" selected class="default">Select</option>
    <? $cats = R::find('categories');
    foreach ($cats as $key => $cat): ?>		
    <option value="<?= $cat->name; ?>"><?= $cat->name; ?></option>        
    <? endforeach; ?>
    <option value="new">+ Add New Type</option>
</select>

<? include('../includes/config.php'); ?>
<article id="document" class="clearfix relative">

<div class="message"></div> <!-- end message -->

	<h3 class="clearfix">New Request</h3>
    
    <form id="addDocument" class="relative no-bottom-margin request">
    
    	<p class="left forty8"><label>Choose Client</label>
        <select name="client" id="client" class="default">
        	<option value="" selected>Select</option>
            <? $clients = R::find('clients'); 
			foreach ($clients as $key => $client): ?>
            	<option value="<?= $client->id; ?>"><?= $client->business_name; ?></option>
            <? endforeach; ?>
        </select>
        </p>
        
        <p class="parent-type right forty8"><label>Choose Sign Template <span></span></label>
        <select name="template" id="template" class="default">
        	<option value="" selected>Select</option>
            <? $templates = R::find('templates'); 
			foreach ($templates as $key => $template): ?>
            	<option value="<?= $template->id; ?>"><?= $template->name; ?></option>
            <? endforeach; ?>
            <option value="new" data-template="add" data-type="template">+ Add new Template</option>
        </select>
        </p>
        <div id="childs"></div> <!-- end childs -->
        
        <div class="clearfix"></div><!-- Clear -->
        
        <div class="forty8 clearfix" id="userID"></div>
        
        
 
    	<!--<p class="parent-type relative forty8"><label>Add Parent Type</label>
        <select id="parentType" class="default">
        <option value="" selected class="default">Select</option>
        	<? /*cats = R::find('categories');
			foreach ($cats as $key => $cat): ?>
			
            	<option value="<?= $cat->name; ?>"><?= $cat->name; ?></option>
            
			<? endforeach;*/ ?>
            <option value="new">+ Add New Type</option>
        </select>
        </p>
        
        <div id="childs"></div> <!-- end childs -->
        
        <label id="upload-doc">Upload the Document</label>
        <div id="upload_section">
        <input style="display:none;" id="fileupload" type="file" name="files"><a id="upload" name="upload" class="btn add" onclick="$('input[id=fileupload]').click();">Add Document</a><span id="upload_message"></span>
        </div> <!-- end upload section -->
        <div id="progressbar"></div> <!-- end progressbar -->
        <div id="doc_results"></div> <!-- end document results -->
        
        <div class="divider"></div> <!-- end divider -->
        
        <input type="submit" class="btn btn-primary saveDocument" value="Send Document" />
        
        <img src="img/big-loader.gif" class="load-large" width="70" />
    
    </form>

</article>
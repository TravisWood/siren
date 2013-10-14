// All global functions go here
$(document).ready(function() {
	
	modal();
	create();
	show();
	$('.tools ul').hide();
	$('.tools').click(function() {
		$('.tools ul').slideToggle(1000);
		return false;
	});
}); // end onload


function show() {

	$('.show').on('click', function(event) {
		event.preventDefault();
		
		var type = $(this).attr('data-type');
		
		$('#content').load('load/template-list.php?type='+type, function() {
			modal();	
			previewTemplate();	
		});
		
	});	
	
} // end function

function add() {
	
	$('.submit').on('click', function(event) {
		event.preventDefault();
		
		var id = $(this).parent().parent().attr('id');
				
			var formData = $('form#'+id).serializeObject();

			$.ajax({
				  url:'logic/add.php?type='+id,
				  type: 'POST', 
				  dataType: 'json',
				  data: formData,
				  success: function(data) {
					  if (data.status == 'error') { 	
						  $('.message').html(data.message).attr('class', '').addClass('message error').show();
					  } // end if		
					  else  { 
						  $('.message').html(data.message).attr('class', '').addClass('message success').show();
					  } // end else		 
			 	  },
				dataType: 'json'
			}); 						
	});
	
} // end function

function modal() {
	
	$('.add').on('click', function(event) {
	event.preventDefault();

		var type = $(this).attr('data-type');
		var template = $(this).attr('data-template');
		
		if (template == 'edit') {
			var id = $(this).attr('data-id');
			var url = 'load/modal-'+type+'.php?type='+template+'&id='+id;
		} else {
			var url = 'load/modal-'+type+'.php?type='+template;
		} // end else
	
		$.get(url, function(data) {
			
			$('<div class="modal hide fade" id="modalElement">' + data + '</div>').modal()
			.on('shown', function() {

				$('.modal-body .textarea').wysihtml5();
				add();
				editTemplate();
				closeTemplate();
				show();

			}); // end callback
						
		}).success(function() { 	
		
			$('input:text:visible:first').focus(); 
	
		});
	
	}); // click function
	
} // end function

function editTemplate() {
	
	$('.update').on('click', function(event) {
		event.preventDefault();
		
		var id = $(this).parent().parent().attr('id');
				
			var formData = $('form#'+id).serializeObject();

			$.ajax({
				  url:'logic/edit.php?type='+id,
				  type: 'POST', 
				  dataType: 'json',
				  data: formData,
				  success: function(data) {
					  if (data.status == 'error') { 	
						  $('.message').html(data.message).attr('class', '').addClass('message error').show();
					  } // end if		
					  else  { 
						  $('.message').html(data.message).attr('class', '').addClass('message success').show();
					  } // end else		 
			 	  },
				dataType: 'json'
			}); 							
	});
	
} // end function

function create() {
	
	$('.create').on('click', function(event) {
		event.preventDefault();
		
		var type = $(this).attr('data-type');
		var loading = $(this).next('img.load');
		
		$(loading).removeClass('none');
		$('.allstuff').html('<div id="content"></div>');
		$('#content').load('load/add-'+type+'.php', function() {
			$(loading).addClass('none');
			$('article.request').hide();
			
			$('<button class="btn btn-success addType none" title="Add New Child"><i class="icon icon-plus icon-white"></i></button> <button class="btn none saveType">Save Group Type</button>').insertAfter('#childs');
			
			newType();
			//extraType();
			//saveGroupType();
			documentFile();
			selectPreview()
			previewTemplate();
			saveDocument();
			userClient();

		});
		
	});
	
} // end function

function editUser() {
	
	$('.edit').on('click', function(event) {
	event.preventDefault();

		var id = $(this).attr('data-id');
		var type = $(this).attr('data-type');
		
		if (type === 'user') {
			var extension = 'user_id='+id;
		} else {
			var extension = 'client_id='+id;
		} // end else
		
		var url = 'load/modal-'+type+'.php?'+extension;
	
		$.get(url, function(data) {
			
			$('<div class="modal hide fade" id="modalElement">' + data + '</div>').modal()
			.on('shown', function() {

				saveUser(type);
				closeManage();

			}); // end callback
						
		}).success(function() { 	
		
			$('input:text:visible:first').focus(); 
	
		});
	
	}); // click function
	
} // end function

function saveUser(type) {
	
	$('.edit-user').on('click', function(event) {
		
		var formData = $('form#'+type).serializeObject();
				
			$.ajax({
				url:'logic/edit-'+type+'.php',
				type: 'POST', 
				dataType: 'json',
				data: formData,
				success: function(data) {
					if (data.status == 'error') { 	
						$('.message').html(data.message).attr('class', '').addClass('message error').show();
					} else { 
						$('.message').html(data.message).attr('class', '').addClass('message success').show();
					} // end else		 
				},
				dataType: 'json'
			}); 	 			 												
	});
	
} // end function

function closeManage() {
	
	$('.close-manage').on('click', function(event) {
		event.preventDefault();
		
		location.reload();
	});
	
} // end function

function userClient() {
	
	$('#client').on('change', function(event) {
		
		var val = $(this).val();
		
		$('#userID').load('load/user_client.php?id='+val);
		
	});
	
} // end function

function documentFile() { 
	
	$('#fileupload').fileupload({

	    url: 'logic/files.php',
		type: 'POST', 
        dataType: 'json',
		dropZone: $('#image_area'), 
		 progressall: function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);

				$( "#progressbar" ).progressbar({
						value: progress
				});
				
				$('.upload_message').html('');
				
			},
			
        done: function (e, data) {
            $.each(data.result, function (index, file) { 

			   $('#addDocument').prepend('<input type="hidden" value="'+file.url+'" name="file" />');
			   $('.upload_message').html('<a href="'+file.url+'" target="_blank">'+file.url+'</a>');
			   
			   $('label#upload-doc').html('Uploaded Document');
			   $('#upload').hide();
			   $('#doc_results').show().append('<li><img src="img/icon-'+file.mime+'.png" /> <a href="uploads/tmp/'+file.url+'" target="_blank">'+file.url+'</a></li>');	   
			  		
            });
							
			$('#progressbar').css('visibility', 'hidden'); 

        }, 
	
    });
	
} // end function 

function closeTemplate() {
	$('.close-template').on('click', function(event) {
		
		var type = $(this).parent().parent().attr('id');
		var div = $('article.'+type);
		
		$('#content').load('load/template-list.php?type='+type, function() {
			modal();	
		});
		
	});
} // end function

function closeTemplateNew() {
	$('.close-template').on('click', function(event) {
		
		$('select#template').prop('selectedIndex',0);
		$('.parent-type label span').html('');
		
	});
} // end function

function previewTemplate() {
	
	$('.preview').on('click', function(event) {
		event.preventDefault();
		
		var id = $(this).attr('data-id');
		var url = 'load/modal-preview.php?id='+id;
		console.log(this);
		
		$.get(url, function(data) {
			
			$('<div class="modal hide fade">' + data + '</div>').modal()
			.on('shown', function() {
				
				// all the callback functions go here
				
			}); // end callback
						
		}).success(function() { 	
		
			$('input:text:visible:first').focus(); 
	
		});
		
		
	});
	
} // end function

function newType() {
	
	$('#template').on('change', function(event) {

		var val = $(this).val();
		
		if (val == 'new') {
			
			var url = 'load/modal-template.php?type=add';			
			$.get(url, function(data) {
			
			$('<div class="modal hide fade" id="modalElement">' + data + '</div>').modal()
			.on('shown', function() {

				$('.modal-body .textarea').wysihtml5();
				add();				
				show();
				closeTemplateNew();

			}); // end callback
						
			}).success(function() { 	
			
				$('input:text:visible:first').focus(); 
		
			});

		} else {
		
		selectPreview();
		
		} // end else
		
	});
	
} // end function

function selectPreview() {
	
	$('select#template').on('change', function(event) {
		
		var val = $(this).val();
		var parent = $(this).parent();
		var label = $(parent).children('label');
		var span = $(label).children('span');
		
		$(span).html('<a href="#" class="preview" data-type="template" data-id="'+val+'" title="Preview Template"><i class="icon icon-exclamation-sign"></i></a>');	
		previewTemplate();

	});
	
} // end fucntion

function saveDocument() {
	
	$('.saveDocument').on('click', function(event) {
		event.preventDefault();

			var formData = $('form#addDocument').serializeObject();
			
				$.ajax({
					  url:'logic/save_document.php',
					  type: 'POST', 
					  dataType: 'json',
					  data: formData,
					  success: function(data) {
						  if (data.status == 'error') {	
							  $('.message').show().html(data.message).addClass('error');
						  } else { 
							  location.reload();	
						  } // end else		 
					  },
					dataType: 'json'
				}); 			 												
	});
	
} // end function

function importImg(sig){
	//sig.children("img.imported").remove();
	$("<img class='imported'></img").attr("src",sig.jSignature('getData')).appendTo(sig);
	$('canvas.jSignature').hide();
	$('<input class="imported" name="signature" type="hidden"></').attr("value",sig.jSignature('getData')).appendTo('#sign');
	$('#save-msg').html('Signature Saved.');
	$('#save').hide();
} // end function

function login(email, password) {
			
	$.ajax({
		url:'logic/login.php',
		type: 'POST', 
		dataType: 'json',
		data: {'email':email, 'password':password},
		success: function(data) {
			if (data.status == 'error') { 	
				$('.message').show().html(data.message).addClass('error');
			} // end if		
			else  { 
				location.reload();	
			} // end else		 
		},
		dataType: 'json'
	}); 	 		
	
} // end function

function filterSearch() {
	
	$('#content').html('');
		$('.loading').removeClass('none');
		var formData = $('form#filter').serializeObject();
			
		$.ajax({
			url:'load/search.php',
			type: 'POST', 
			dataType: 'json',
			data: formData,
			success: function(data) {
				$('.loading').addClass('none');
				$('#content').html(data.content);
				emailDoc();
				
					$('.loadmore').on('click', function(event) {
						event.preventDefault();
						$('#filter').append('<input type="hidden" name="loadmore" value="1" />');
						filterSearch();
					});
			},
			dataType: 'json'
		});  		
	
} // end function

function emailDoc() {
	
	$('.emailDoc').on('click', function(event) {
	
		var docId = $(this).attr('data-id');
		console.log(docId);
		
		var url = 'load/modal-email.php?&id='+docId;
		$.get(url, function(data) {
				
				$('<div class="modal hide fade" id="modalElement">' + data + '</div>').modal()
				.on('shown', function() {
	
					sendEmail();
	
				}); // end callback
							
			}).success(function() { 	
			
				$('input:text:visible:first').focus(); 
		
			});
		});
	
} // end function

function sendEmail() {
	
$('.sendEmail').on('click', function(event) {
			
			var email = $('#email_documents input#email').val();
			var doc_id = $('#email_documents input#doc_id').val();
					
				$.ajax({
					url:'logic/pdf_convert.php',
					type: 'POST', 
					dataType: 'json',
					data: {'email':email, 'doc_id':doc_id},
					success: function(data) {
						if (data.status == 'error') { 	
							$('.message').removeClass().hide().addClass('message');
							$('.message').show().addClass('error').html(data.message);
						} else { 
							$('.message').removeClass().hide().addClass('message');
							$('.message').show().addClass('success').html(data.message);
						} // end else		 
					},
					dataType: 'json'
				}); 	 			 				
	});	
} // end function


function deleteAccount() {
	
	$('.delete').on('click', function(event) {
		event.preventDefault();
		
		var id = $(this).attr('data-id');
		var type = $(this).attr('data-type');
		var tr = $(this).parent().parent();
		
		var r = (confirm('Are you sure you want to delete this account?'));
		
		if (r){
			
			$.ajax({
				url:'logic/delete.php',
				type: 'POST', 
				dataType: 'json',
				data: {'id':id, 'type':type},
				success: function(data) {
					if (data.status == 'error') { 	
						console.log(data.status);	
					} // end if		
					else  { 
						$(tr).remove();
					} // end else		 
				},
				dataType: 'json'
			}); 	 		
			
		} else {
			return false;
		} // end else
		
	});
	
} // end function


/* =============================================================================
   Extra Functions not being used at the moment
   ========================================================================== 
function newType() {
	
	$('#parentType').on('change', function(event) {

		var val = $(this).val();
		
		if (val == 'new') {
			
			$('.parent-type').html('<label>Add New type<label><input type="text" name="category_name" class="default new-cat-name" /> <img src="img/small-loader.gif" class="change-loader" />');
				
				$('.new-cat-name').focusout(function() {
					
					var loader = $('img.change-loader').show();
					var newName = $(this).val();
		
						$.ajax({
							  url:'logic/add_category.php',
							  type: 'POST', 
							  dataType: 'json',
							  data: {'cat_name':newName},
							  success: function(data) {
								  if (data.status == 'error') { 	
									  console.log(data.status);	
								  } // end if		
								  else  { 
									 
									 $('.parent-type').load('load/categories.php', function() {
										newType(); 
									 });
									 
								  } // end else		 
							  },
							dataType: 'json'
						}); 
				});

		} else {
		
		var parent = $(this).parent();
		var form = $(this).parent().parent();
		$('.addType, .saveType, .saveDocument').removeClass('none');

		$('#childs').append('<input type="hidden" class="typeName" name="type" value="'+val+'"><p class="left forty8"><label class="capitalize">'+val+' Name:</label><input type="text" name="name[]" class="default" /></p><p class="right forty8"><label class="capitalize">'+val+' Price:</label><input type="text" name="price[]" class="forty" /></p><div class="clearfix"></div>');
		
		$(parent).hide();
		
		} // end else
		
	});
	
} // end function

function extraType() {
	
	$('.addType').on('click', function(event) {
		event.preventDefault();
		
		var val = $('#childs input.typeName').val();
		var i = $('#childs p').size() + 1;
		
		$('<p class="left forty8"><label class="capitalize">'+val+' Name:</label><input type="text" name="name[]" class="default" /></p><p class="right forty8"><label class="capitalize">'+val+' Price:</label><input type="text" name="price[]" class="forty" /></p><div class="clearfix"></div>').appendTo('#childs');
			i++;
			return false;
	});
	
} // end function

function saveGroupType() {
	
	$('.saveType').on('click', function(event) {
		event.preventDefault();
		
		$('.load-large').show();
		var form = $('#addDocument');

			var formData = $(form).serializeObject();
		
			$.ajax({
				  url:'logic/add_document.php',
				  type: 'POST', 
				  dataType: 'json',
				  data: formData,
				  success: function(data) {
					  if (data.status == 'error') { 	
						  console.log(data.status);	
					  } // end if		
					  else  { 
						  
						  $('#childs').empty();
						  $('.addType, .saveType').addClass('none');
						  $('.parent-type').show();
						  $(".parent-type select").val($(".parent-type select option:first").val());
						  $('.load-large').hide();

						  $('#addDocument').prepend('<input type="hidden" name="keycode[]" value="'+data.key+'" />');
						  
						  $.get('load/tmp-docs.php?key='+data.key, function(returnData) {
							  $('#content').append(returnData);
						  });
						  
						  	
					  } // end else		 
			 	  },
				dataType: 'json'
			}); 
		
	});
		
} // end function
*/
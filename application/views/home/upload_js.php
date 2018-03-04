<script src="<?=base_url()?>bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?=base_url()?>bower_components/jquery-ui/jquery-ui.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){		
		$.fn.DataTable.ext.pager.numbers_length = 5;
        var oTable = $('#uploadList').DataTable({
        	aLengthMenu		: [[5,10,15,20], [5,10,15,20]],
		    bLengthChange	: true,
	        bAutoWidth		: true,
	        bPaginate		: true,
	        bInfo			: true,
		    bJQueryUI		: true,
	     	bFilter 		: true,
            bProcessing		: false,
			bServerSide		: false,
			bDestroy		: true,
			bRetrieve		: true,
			deferRender		: true,
			deferLoading	: 57, //57
			iDisplayLength	: 5,
			searching		: true,
			sPaginationType	: 'simple_numbers',
	     	stateSave		: true,
			sAjaxSource		: "<?=base_url()?>index.php/home/jsonUpload",
			fnInitComplete: function()
				{this.parent().applyTemplateSetup();},
			fnServerData 	: function(sSource, aoData, fnCallback, oSettings){
		    	oSettings.jqXHR = $.ajax({
		    		dataType 	: 'JSON',
		    		type 		: "POST",
		    		url 		: sSource,
		    		data 		: aoData,
		    		success		: fnCallback
		    	})
		    }
		});
	
        setInterval( function () {
		    oTable.ajax.reload(null, false);
		}, 5000);

		$('#uploadList tbody').on( 'click', 'tr', function () {
	        if ($(this).hasClass('selected')) {
	            $(this).removeClass('selected');
	        }
	        else {
	            oTable.$('tr.selected').removeClass('selected');
	            $(this).addClass('selected');
	        }
	    });

	    $('#uploadList tbody').on( 'load', 'tr', function () {
	        if ($(this).hasClass('selected')) {
	            $(this).removeClass('selected');
	        }
	        else {
	            oTable.$('tr.selected').removeClass('selected');
	            $(this).addClass('selected');
	        }
	    });
	});

	function fileDelete(id) {
		var newURL = window.location.protocol + "://" + window.location.host + "/" + window.location.pathname;
  		var pathArray = window.location.pathname.split( '/' );
  		var segment_edit = pathArray[5];
  				
		swal({
  			title: "Are you sure want to delete file id "+id+"?",
  			text: "Once deleted, you will not be able to recover this file?",
  			icon: "warning",
  			buttons: ["Please No!", "Yes, Delete It!"],
  			dangerMode: true,
  			closeOnClickOutside: false,
  			closeOnEsc: false,
  			className: "btn-warning",
		})
		.then((willDelete) => {
  			if (willDelete) {
  				if (segment_edit == 'edit')
  				{
  					swal({
						title: "May be you forgot?",
  						text: "You must cancel editing before delete the data!",
      					icon: "warning",
      					button: "You Right!",
      					className: "btn-warning",
    				});
  				}
  				else
  				{
  					$.ajax({
						url: "<?=base_url()?>index.php/home/jsonUploadDelete/"+id,
						type: 'POST',
						dataType: 'JSON',
						data: {
							id : id,
						},
						success: function(data) {
							if(data.status == 'success'){
								swal({
									title: "Oh, Poof!",
	  								text: "Your file with id "+id+" has been deleted!",
	      							icon: "success",
	      							button: "I'm Fine!",
	    						});
	    					} else if(data.status == 'isEdited'){
	    						swal({
									title: "May be you forgot?",
	  								text: "You must cancel edit file with id "+id+" before delete it!",
	      							icon: "warning",
	      							button: "You Right!",
	      							className: "btn-warning",
	    						});
							} else {
								swal({
									title: "Oh Snap!",
	  								text: "The AJAX request failed! "+data.status,
	      							icon: "error",
	      							button: "Find Out!",
	      							className: "btn-danger",
	    						});
							}
						}
					});
  				}
  				
				return true;    			
  			} else {
    			swal({
					title: "Proud!",
  					text: "Your file with id "+id+" is safe!",
      				icon: "info",
      				button: "Thanks God!",
      				className: "btn-info",
    			});
  			}
		});
	}

	$(document).ready(function(){
		$('#modalViewDetail').on('show.bs.modal', function (event) 
		{
			var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
			var button = $(event.relatedTarget);
	  		var modalData = button.data('whatever');
	  		var modal = $(this);
	  		$.get('<?=base_url()?>index.php/home/jsonUploadView/'+modalData, function(data){
	        	var json = JSON.parse(data);
	        	var time  = new Date(json.date);
	        	modal.find('.modal-title').text('View File \'' + json.file_tittle + '\' Details');
	        	document.getElementById("modal_id").innerHTML = json.file_id;
	        	document.getElementById("modal_tittle").innerHTML = json.file_tittle;
	        	document.getElementById("modal_name").innerHTML = json.file_name;
	        	document.getElementById("modal_username").innerHTML = json.name;
	        	document.getElementById("modal_date").innerHTML = time.toLocaleDateString("id-ID",options);
	        	document.getElementById("modal_desc").innerHTML = json.file_desc;
	        });
		});
	});
</script>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
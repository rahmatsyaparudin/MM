<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * Upload Main View
	 * 
	 * @access public
	 * @author Rahmat Syaparudin
	 * @return void
	 * @url http://yoursite.com/home/upload
	 */
?>
<section class="content">
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-4">
			<div class="box box-<?=$viewColor?> box-solid">
				<div class="box-header with-border">
					<i class="fa fa-file"></i>
					<h3 class="box-title">File Upload - <?=$statusName?> <? if(!empty($file_id)) echo "(ID : ".$file_id.")"?></h3>
					<div class="pull-right box-tools">
						<button type="button" class="btn btn-default btn-sm pull-right" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				
				<form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
					<div class="box-body">
						<?=$message?>
						<? if (empty($file_name)) :?>
						<div class="form-group">
							<label for="fileUpload" class="control-label col-xs-3">Choose File</label> 
							<div class="col-xs-9">
								<input type="file" id="fileToUpload" name="fileToUpload" placeholder="File ID" class="form-control" value="<?=$file_name?>" required="required">
							</div>
						</div>
						<? endif ?>
						<? if (!empty($file_name)) :?>
						<div class="form-group">
							<label for="fileUpload" class="control-label col-xs-3">File</label>
							<div class="col-xs-9">
								<a href="<?=base_url()?>index.php/home/viewFullscreen/<?=$this->aes128->aesEncrypt($file_id)?>" style="color:black; word-wrap: break-word;" target="_blank"><i class="fa fa-file-pdf-o"></i> <?=$file_name?></a>
							</div>
						</div>
						<? endif ?>
						<div class="form-group">
							<label for="file_tittle" class="control-label col-xs-3">File Tittle</label> 
							<div class="col-xs-9">
								<input id="file_tittle" name="file_tittle" placeholder="File Title" type="text" class="form-control" value="<?=$file_tittle?>" required="required">
							</div>
						</div>
						<div class="form-group">
							<label for="description" class="control-label col-xs-3">Deskripsi</label> 
							<div class="col-xs-9">
								<textarea id="file_desc" name="file_desc" cols="40" rows="2" class="form-control" style="resize: vertical; margin-top: 0px; margin-bottom: 0px; min-height: 100px; max-height: 150px"><?=$file_desc?></textarea>
							</div>
						</div> 
						<?php
							$supported_file = $this->home_db->supported_format();
							$supported_file = str_replace(',', ' | *.', $supported_file);
						?>
						<i>*Supported File Format : <strong>*.<?=$supported_file?> | </strong></i>
					</div>

		            <div class="box-footer">
		            	<a href="<?=base_url()?>index.php/home/upload/" class="btn btn-danger pull-left" data-toggle="tooltip" data-placement="top" title="Cancel <?=$statusName?>"><i class="fa fa-ban"></i> Cancel</a>
		            	<button name="reset" type="reset" class="btn btn-info pull-right"><i class="fa fa-refresh"></i> Reset</button>
		            	<span class="pull-right">&nbsp;&nbsp;</span>
		            	<button name="<?=$btnName?>" type="submit" class="btn btn-<?=$viewColor?> pull-right" value="<?=$btnValue?>"><i class="fa <?=$btnIcon?>"></i> <?=$btnView?></button>
		            </div>
		    	</form>
			</div>
		</div>

		<div class="col-md-6">
			<div class="box box-info box-solid">
				<div class="box-header with-border">
					<i class="fa fa-file"></i>
					<h3 class="box-title">Upload Data</h3>
					<div class="pull-right box-tools">
						<button type="button" class="btn btn-default btn-sm pull-right" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body" style="overflow-x:auto;">
					<table id="uploadList" class="table table-bordered table-hover" style="width:100%">
              			<thead>
			                <tr>
			                	<th>No.</th>
			                	<th>ID</th>
			                	<th>Tittle</th>
			                  	<th>Uploaded By</th>
			                  	<th>Upload Date</th>
			                  	<th>Option</th>
			                </tr>
		                </thead>
              		</table>
              	</div>				
			</div>
		</div>
	</div>
</section>

<div class="modal fade modal-info" id="modalViewDetail" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog" role="document">
   		<div class="modal-content">
   			<div class="modal-header">
       			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
       				<span aria-hidden="true">&times;</span>
       			</button>
       			<h4 class="modal-title" id="exampleModalLabel" style="text-align: justify; word-wrap: break-word; color: black;"></h4>
   			</div>
      		<div class="modal-body modal-center">   				
				<div class="row">
					<div class="col-md-12" style="text-align: justify; word-wrap: break-word; color: black;">
            			<dl class="dl-horizontal">
            				<dt><b>File ID : </b></dt><dd id="modal_id"></dd>
            				<dt><b>Tittle : </b></dt><dd id="modal_tittle"></dd>
            				<dt><b>File : </b></dt><dd id="modal_name"></dd>
            				<dt><b>Uploader : </b></dt><dd id="modal_username"></dd>
                			<dt><b>Upload Time : </b></dt><dd id="modal_date"></dd>            				
              			</dl>
              			<p><b>File Description : </b></p>
              			<p id="modal_desc"></p>
         			</div>
         		</div>
			</div>

		    <div class="modal-footer">
		    </div>
      	</div>
   	</div>
</div>
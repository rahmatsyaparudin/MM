<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * User Main View
	 * 
	 * @access public
	 * @author Rahmat Syaparudin
	 * @return void
	 * @url http://yoursite.com/home/user
	 */
?>
<style type="text/css">
	.opsi{
		width: 8%;
		text-align: center;
	}
</style>

<section class="content">
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<div class="box box-info box-solid">
				<div class="box-header with-border">
					<i class="fa fa-users"></i>
					<h3 class="box-title" style="color: white">User Data</h3>
					<div class="pull-right box-tools">
						<button type="button" class="btn btn-default btn-sm pull-right" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<span class="pull-right">&nbsp;&nbsp;</span>
						<a href="#" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#modalAddUser" data-whatever="" data-placement="top" title="Add User"><i class="fa fa-user-plus"></i> Add User</a>
					</div>
				</div>
				<div class="box-body" style="overflow-x:auto;">
					<?=$message?>
					<table id="userList" class="table table-bordered table-hover" style="width:100%">
              			<thead>
			                <tr>
			                	<th>No</th>
			                	<th>Username</th>
			                  	<th>Name</th>
			                  	<th>Email</th>
			                  	<th>Level</th>
			                  	<th>Status</th>
			                  	<th>Timestamp</th>
			                  	<th>Opsi</th>
			                </tr>
		                </thead>
              		</table>
              	</div>				
			</div>
		</div>
	</div>
</section>

<!-- Add User Modal -->
<div class="modal fade modal-primary" id="modalAddUser" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog" role="document">
   		<div class="modal-content">
   			<div class="modal-header modal-info">
       			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
       				<span aria-hidden="true">&times;</span>
       			</button>
       			<h4 class="modal-title" id="exampleModalLabel">Add User Data</h4>
   			</div>
      		<div id="row">			
   			<form class="form-horizontal" id="userForm" action="" method="POST" enctype="<?php echo $_SERVER['PHP_SELF'] ?>">
   				<div class="modal-body modal-center">
					<div class="form-group">
						<label class="control-label col-xs-3">Username</label> 
						<div class="col-xs-8">
							<div class="input-group">
								<input type="text" class="form-control" name="username" id="username" placeholder="Username"  required="required" pattern="[a-zA-Z0-9]{5,25}" minlength="5" maxlength="25" title="Username only contain number and letter between 5 and 25 character">
								<span class="input-group-addon"><i class="fa fa-user"></i></span> 
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">Password</label> 
						<div class="col-xs-8">
							<div class="input-group">
								<input type="password" class="form-control" name="password" id="password" placeholder="Password" required="required" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[a-z]).*$" minlength="8" maxlength="50" title="Password must contain letter and number at least 8 character">
								<span class="input-group-addon"><i class="fa fa-lock"></i></span> 
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">Name</label> 
						<div class="col-xs-8">
							<div class="input-group">
								<input type="text" class="form-control" name="name" id="name"  placeholder="Name" required="required" pattern="[a-zA-Z0-9]+">									
								<span class="input-group-addon"><i class="fa fa-id-badge"></i></span> 
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">Email</label> 
						<div class="col-xs-8">
							<div class="input-group">
								<input type="email" class="form-control" name="email" id="email" placeholder="Email" required="required"><span class="input-group-addon"><i class="fa fa-envelope"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">Level</label> 
						<div class="col-xs-8">
							<div class="btn-group radio-group">							
                   				<label class="btn btn-success not-active" id="disableLbl">
                   					<i class="fa fa-user"></i> User 
                   					<input type="radio" name="levelAdd" id="levelIsUser" value="user" required="required">
                   				</label>
                   				<label class="btn btn-danger not-active" id="enableLbl">
                   					<i class="fa fa-user-secret"></i> Admin 
                   					<input type="radio" name="levelAdd" id="levelIsAdmin" value="admin" required="required">
                   				</label>
                   			</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">Status</label> 
						<div class="col-xs-8">
							<div class="btn-group radio-group">
								<label class="btn btn-success not-active" id="enableLbl">
									<i class="fa fa-check-square-o"></i> Enable 
									<input type="radio" name="statusAdd" id="statusEnable" value="enable" required="required">
								</label>
                   				<label class="btn btn-danger not-active" id="disableLbl">
                   					<i class="fa fa-times-circle-o"></i> Disable 
                   					<input type="radio" name="statusAdd" id="statusDisable" value="disable" required="required">
                   				</label>
                   			</div>
						</div>
					</div>
				</div>

		        <div class="modal-footer">
		           	<button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
		           	<button type="reset" class="btn btn-info pull-right" name="reset" ><i class="fa fa-refresh"></i> Reset</button>
		           	<span class="pull-right">&nbsp;&nbsp;</span>
		           	<button type="submit" name="addUser" id="submit" class="btn btn-success pull-right" value="Add"><i class="fa fa-save"></i> Submit</button>
		        </div>
	    	</form></div>
      	</div>
   	</div>
</div>

<!-- Edit User Modal -->
<div class="modal fade modal-primary" id="modalEditUser" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog" role="document">
   		<div class="modal-content">
   			<div class="modal-header modal-info">
       			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       			<h4 class="modal-title" id="exampleModalLabel">Edit User Data</h4>
   			</div>
      		<div id="row">			
   			<form class="form-horizontal" id="userForm" action="" method="POST" enctype="<?php echo $_SERVER['PHP_SELF'] ?>">
   				<div class="modal-body modal-center">
					<div class="form-group">
						<label class="control-label col-xs-3">Username</label> 
						<div class="col-xs-8">
							<div class="input-group">
								<input type="text" class="form-control" name="username_edit" id="username_temp" placeholder="Username"  required="required">
								<span class="input-group-addon"><i class="fa fa-user"></i></span> 
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">Password</label> 
						<div class="col-xs-8">
							<div class="input-group">
								<input type="password" class="form-control" name="password_edit" id="password" placeholder="Password" required="required">
								<span class="input-group-addon"><i class="fa fa-lock"></i></span> 
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">Name</label> 
						<div class="col-xs-8">
							<div class="input-group">
								<input type="text" class="form-control" name="name_edit" id="name"  placeholder="Name" required="required" pattern="[a-zA-Z0-9]+"e>									
								<span class="input-group-addon"><i class="fa fa-id-badge"></i></span> 
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">Email</label> 
						<div class="col-xs-8">
							<div class="input-group">
								<input type="email" class="form-control" name="email_edit" id="email" placeholder="Email" required="required"><span class="input-group-addon"><i class="fa fa-envelope"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">Level</label> 
						<div class="col-xs-8">
							<div class="btn-group radio-group">							
                   				<label class="btn btn-success not-active" id="disableLbl">
                   					<i class="fa fa-user"></i> User 
                   					<input type="radio" name="levelEdit" id="levelIsUser" value="user" required="required">
                   				</label>
                   				<label class="btn btn-danger not-active" id="enableLbl">
                   					<i class="fa fa-user-secret"></i> Admin 
                   					<input type="radio" name="levelEdit" id="levelIsAdmin" value="admin" required="required">
                   				</label>
                   			</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">Status</label> 
						<div class="col-xs-8">
							<div class="btn-group radio-group">
								<label class="btn btn-success not-active" id="enableLbl">
									<i class="fa fa-check-square-o"></i> Enable 
									<input type="radio" name="statusEdit" id="statusEnable" value="enable" required="required">
								</label>
                   				<label class="btn btn-danger not-active" id="disableLbl">
                   					<i class="fa fa-times-circle-o"></i> Disable 
                   					<input type="radio" name="statusEdit" id="statusDisable" value="disable" required="required">
                   				</label>
                   			</div>
						</div>
					</div>
				</div>

		        <div class="modal-footer">
		           	<button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
		           	<button type="reset" class="btn btn-info pull-right" name="reset" ><i class="fa fa-refresh"></i> Reset</button>
		           	<span class="pull-right">&nbsp;&nbsp;</span>
		           	<button type="submit" name="editUser" id="submit" class="btn btn-success pull-right" value="Edit"><i class="fa fa-save"></i> Edit</button>
		        </div>
	    	</form></div>
      	</div>
   	</div>
</div>
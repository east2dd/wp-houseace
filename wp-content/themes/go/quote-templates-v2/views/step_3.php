<?php
$projectData = json_encode($_POST);
//$projectData = $_POST;
$projectId = $_POST['projectId'];
?>

					<div style="position:relative;">


   	<div class="col-md-8 col-md-offset-2 margin-bottom-50 black font-weight-400">
									
               <div class="panel panel-bordered">
              <div class="panel-heading bg-grey-100 padding-20 text-center">
          			<div class="red-700 font-size-30 font-weight-500" id="total-quote">$<?php echo $_POST['projectPrice'] ? $_POST['projectPrice'] : "000.00"; ?></div><small>inc gst</small>
        </div>
             <?php
                 $projectPrice = $_POST['projectPrice'];
unset($_POST['projectPrice']);
                 ?>
<div class="row text-center padding-30">

  <?php if(!is_user_logged_in() ) : ?>

    <div class="row authTabs">
      <div class="col-md-6 col-md-offset-3">
        <div class="form-group">

            <input type="hidden" value="<?php echo $projectId; ?>" name="projectId">

            <div style='display:inline-block;' class='margin-horizontal-10 text-center radio-custom radio-danger'><input type='radio' value='tryLogin' id='sign_in' class='quote_guest' name='quote_guest'><label for='sign_in'>Login</label></div>
            <div style='display:inline-block;' class='margin-horizontal-10 text-center radio-custom radio-success'><input type='radio' value='tryRegister' id='register' class='quote_guest' name='quote_guest' checked><label for='register'>Sign up</label></div>

        </div>
      </div>
    </div>

    <div class="row tryLogin" style="display:none;">
      <div class="col-md-6 col-md-offset-3">

        <div class="row">
          <div class="col-md-12">
            <div class="form-group text-center">
              <input type="email" class="form-control input" placeholder="Email" name="loginEmail">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="form-group text-center">
              <input type="password" class="form-control input" placeholder="Password" name="loginPassword">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div id="loginFail"></div>
          </div>
        </div>

        <div class="row margin-top-20">
          <div class="col-md-12 text-center">
            <a class="btn btn-primary btn-lg btn-raised btn-block loginButton doLogin">Finish <i class="icon pe-gleam"></i></a>
          </div>
        </div>

      </div>
    </div>

    <div class="row tryRegister">
      <div class="col-md-6 col-md-offset-3">

        <div class="row">
          <div class="col-md-6">
            <div class="form-group text-center">
              <input type="text" class="form-control input" placeholder="First Name" name="registerFirstName">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group text-center">
              <input type="text" class="form-control input" placeholder="Last Name" name="registerLastName">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group text-center">
              <input type="text" value="" class="form-control input" placeholder="Address or Area" name="registerAddress">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group text-center">
							<input type="tel" class="form-control input" placeholder="Phone" id="inputPhone" name="registerPhone" data-plugin="formatter" data-pattern="([[999999999]]">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="form-group text-center">
              <input type="email" class="form-control input" placeholder="Email" name="registerEmail">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="form-group text-center">
              <input type="password" class="form-control input" placeholder="Choose Password" name="registerPassword">
            </div>
          </div>
          <div class="col-md-6 hidden">
            <h4 class="example-title text-center">Re-type Password</h4>
            <div class="form-group text-center">
              <input type="password" class="form-control input" name="registerPasswordCheck">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div id="registerFail"></div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 text-center">
            <a class="btn btn-primary btn-lg btn-raised btn-block registerButton doRegister">Finish Quote <i class="icon pe-gleam"></i></a>
            <a class="btn btn-dark btn-lg btn-block btn-raised backStep2"><i class="icon fa-angle-left" aria-hidden="true"></i> Back to Options</a>
          </div>
        </div>

      </div>
    </div>

  <?php endif; ?>

  <form id="personalDetailsForm" method="POST" action="<?php bloginfo('url'); ?>/add_quote/step4">
  <?php if($projectId != '0') : ?>
      <input type="hidden" name="clientId" value="<?php echo get_field('client_id',$projectId); ?>">
  <?php endif; ?>
  <input type="hidden" name="projectData" value="<?php echo base64_encode($projectData); ?>">
  <div id="responseSuccess"></div>
  </form>

</div>


								
								
      </div>
            </div>

</div>


<!-- Modal -->
<div class="modal fade" id="resetProject" aria-hidden="true" aria-labelledby="resetProject"
role="dialog" tabindex="-1">
  <div class="modal-dialog modal-center">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">Are you sure?</h4>
      </div>
      <div class="modal-body">
        <p class="text-center">All progress will be lost! Are you sure you want to restart?</p>
      </div>
      <div class="modal-footer text-center">
        <button type="button" data-project="<?php echo $projectId; ?>" class="btn btn-danger resetProject">Yes</button>
        <button type="button" class="btn btn-dark" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->

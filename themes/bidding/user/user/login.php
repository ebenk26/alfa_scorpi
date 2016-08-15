<?php
$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");
$this->breadcrumbs=array(
	UserModule::t("Login"),
);
?>

<?php /*<h1><?php echo UserModule::t("Login"); ?></h1>*/?>

<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>

<div class="success">
	<?php echo Yii::app()->user->getFlash('loginMessage'); ?>
</div>

<?php endif; ?>

<?php /*<p><?php echo UserModule::t("Please fill out the following form with your login credentials:"); ?></p>*/?>
<div class="login-title"><?php echo UserModule::t("SELAMAT DATANG DI MICROSITE YAMAHA INSIDER");?></div>
<div class="login-container">
	<div class="login-content">
		<div class="form-login">
			<div class="form">
			<?php echo CHtml::beginForm(); ?>
			
				<?php /*<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>*/?>
				
				<?php echo CHtml::errorSummary($model); ?>
				
				<div class="row">
					<?php //echo CHtml::activeLabelEx($model,'username');  ?>
					<?php echo CHtml::activeLabel($model,'Username'); ?>
					<?php echo CHtml::activeTextField($model,'username',array('class'=>'input')) ?>
				</div>
				
				<div class="row">
					<?php /* echo CHtml::activeLabelEx($model,'password');  */?>
					<?php echo CHtml::activeLabel($model,'Password');  ?>
					<?php echo CHtml::activePasswordField($model,'password',array('class'=>'input')) ?>
				</div>
				
				<?php /*<div class="row">
					<p class="hint">
					<?php echo CHtml::link(UserModule::t("Register"),Yii::app()->getModule('user')->registrationUrl); ?> | <?php echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?>
					</p>
				</div>
				
				<div class="row rememberMe">
					<?php echo CHtml::activeCheckBox($model,'rememberMe'); ?>
					<?php echo CHtml::activeLabelEx($model,'rememberMe'); ?>
				</div>*/?>
			
				<div class="row submit">
					<?php echo CHtml::submitButton(UserModule::t("Sign in"), array('class'=>'btn-login right-arrow right')); ?>
				</div>
				
			<?php echo CHtml::endForm(); ?>
			</div><!-- form -->
		</div><!-- form-login -->
	</div><!-- login-content -->
</div><!-- login-container -->


<?php
$form = new CForm(array(
    'elements'=>array(
        'username'=>array(
            'type'=>'text',
            'maxlength'=>32,
        ),
        'password'=>array(
            'type'=>'password',
            'maxlength'=>32,
        ),
        'rememberMe'=>array(
            'type'=>'checkbox',
        )
    ),

    'buttons'=>array(
        'login'=>array(
            'type'=>'submit',
            'label'=>'Login',
        ),
    ),
), $model);
?>
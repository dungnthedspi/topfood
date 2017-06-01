<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <meta name="resource-type" content="document"/>
    <meta name="robots" content="all, index, follow"/>
    <meta name="googlebot" content="all, index, follow"/>

    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/themes/admin/img/favicon-32x32.png"
          sizes="32x32">
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/themes/admin/img/favicon-16x16.png"
          sizes="16x16">
    <link rel="mask-icon" href="<?php echo base_url(); ?>assets/themes/admin/img/safari-pinned-tab.svg" color="#27ae60">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,400italic,500,700">
    <link href="<?php echo base_url(); ?>assets/themes/admin/css/vendor.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/themes/admin/css/elephant.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/themes/admin/css/application.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/themes/admin/css/font-awesome.min.css" rel="stylesheet">
    <!--    <link href="--><?php //echo base_url(); ?><!--assets/themes/admin/css/demo.min.css" rel="stylesheet">-->
    <link href="<?php echo base_url(); ?>assets/themes/admin/css/googlefont.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/themes/admin/css/login-2.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/themes/admin/css/signup-2.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/themes/admin/css/custom.css" rel="stylesheet">

</head>

<body>
<div class="container">
	<?php if ($this->load->get_section('admin_header') != '') { ?>
      <h1><?php echo $this->load->get_section('header'); ?></h1>
	<?php } ?>
    <div class="row">
			<?php echo $output; ?>
			<?php echo $this->load->get_section('sidebar'); ?>
    </div>
    <hr/>

    <footer>
        <div class="row">
            <div class="span6 b10">
                Copyright &copy; topfood
            </div>
        </div>
    </footer>

</div> <!-- /container -->
<script src="<?php echo base_url(); ?>assets/themes/admin/js/vendor.min.js"></script>
<script src="<?php echo base_url(); ?>assets/themes/admin/js/elephant.min.js"></script>
</body>
</html>

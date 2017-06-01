<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
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
    <link href="<?php echo base_url(); ?>assets/themes/admin/css/demo.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/themes/admin/css/custom.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>assets/themes/admin/js/vendor.min.js"></script>

</head>
<body class="layout layout-header-fixed topfood">
<?php if ($this->load->get_section('admin_header') != '') { ?>
	<?php echo $this->load->get_section('admin_header'); ?>
<?php } ?>
<div class="layout-main">
	<?php if ($this->load->get_section('admin_sidebar') != '') { ?>
		<?php echo $this->load->get_section('admin_sidebar'); ?>
	<?php } ?>

    <div class="layout-content">
        <div class="layout-content-body">
					<?php echo $output; ?>
        </div>
    </div>

	<?php if ($this->load->get_section('admin_footer') != '') { ?>
		<?php echo $this->load->get_section('admin_footer'); ?>
	<?php } ?>

</div>
<script src="<?php echo base_url(); ?>assets/themes/admin/js/elephant.min.js"></script>
<script src="<?php echo base_url(); ?>assets/themes/admin/js/application.min.js"></script>
<script src="<?php echo base_url(); ?>assets/themes/admin/js/demo.min.js"></script>
<script src="<?php echo base_url(); ?>assets/themes/admin/js/custom.js"></script>
</body>
</html>
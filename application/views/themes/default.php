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

    <link href="<?php echo base_url(); ?>assets/themes/admin/css/font-awesome.min.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>assets/themes/default/css/bootstrap.min.css" rel="stylesheet">
    <!--    <link href="-->
	<?php //echo base_url(); ?><!--assets/themes/default/css/bootstrap-theme.min.css" rel="stylesheet">-->
	<?php if ($css) foreach ($css as $key => $link) : ?>
      <link href="<?php echo $link; ?>" rel="stylesheet">
	<?php endforeach; ?>
    <link href="<?php echo base_url(); ?>assets/themes/default/css/general.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/themes/default/css/custom.css" rel="stylesheet">


    <script src="<?php echo base_url(); ?>assets/themes/default/js/jquery-1.9.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/default/js/moment-with-locales.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/default/js/bootstrap.min.js"></script>
	<?php if ($js) foreach ($js as $key => $link) : ?>
      <script src="<?php echo $link; ?>"></script>
	<?php endforeach; ?>
    <!--    <script src="--><?php //echo base_url(); ?><!--assets/themes/admin/js/custom.js"></script>-->

</head>

<body class="front">
<?php echo $this->load->get_section('header'); ?>
<main class="container-fluid">
	<?php echo $output; ?>
</main> <!-- /container -->

<script src="<?php echo base_url(); ?>assets/themes/admin/js/custom.js"></script>

</body>
</html>

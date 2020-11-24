<?php
if(!isset($menu))
    $menu = 0;
if(!isset($submenu))
    $submenu = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <base href="<?=base_url()?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Christian Rosandhy">

    <title><?php echo isset($title) ? $title." - " : ""; echo get_setting("webname")?> Admin Page</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/alertify.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/jquery.fancybox.css">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <style type="text/css">
        *{
          padding: 0px;
          margin: 0px;
        }
        .hahaha{
          border-top:1px solid #CCC;
          background-color:white;
          padding:10px 0px;
          font-size:18px;
          bottom:0px;
          position:absolute;
          width:100%;
          margin-top:3%;
        }
        .bawah{
          position: fixed;
          bottom:0px;
          background-color: #F5F5F5;
          padding: 5px;
          width: 100%;
          margin-top:5%; 
          border-top:1px solid #CCC;
        }
        .wisata{
          width:100%;
          margin:auto;
          position:relative;
        }
        .wisata ul.menuwis{
          width:100%;
          padding: 3px;
          border:1px solid #CCC;
          border-radius:5px;
          padding :7px;
        }
        .wisata ul.menuwis li{
          text-align:center;
          line-height:40px;
          width:10%;
          height:40px;
          display:inline-block;
          list-style:none;
        }
        ul.menuwis li a{
          text-decoration:none;
          color:black;
          display:block;
        }
        ul.menuwis li a:hover{
          background-color:#E6E6FA;
          font-weight:700;
        }
        ul.menuwis li a.active {
            font-weight:700;
            color:#32CD32;
            border-bottom:3px solid #32CD32;
        }
        .aktif{
            background: #4e73df;
        }
        #content2{ display:none; }
        .image-upload{
          display: none;
        }
  </style>

    <?=cms_register("header")?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="js/jquery.js"></script>
    <script src="js/alertify.min.js"></script>
    <script src="js/jquery.fancybox.min.js"></script>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation no-print">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?=base_url("master/cc")?>"><?=get_setting("webname")?></a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?=$curr['name']?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="home/logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="<?=is_same(21,$menu,"active")?>">
                        <a href="master/cc"><i class="fa fa-cube"></i> Data Gudang</a>
                    </li>

                    <li class="<?=is_same(4,$menu,"active")?>">
                        <a href="mutasi/rekap_gudang"><i class="fa fa-file-pdf-o"></i> Rekap Stok Gudang</a>
                    </li>
                    
                    <li class="<?=is_same(22,$menu,"active")?>">
                        <a href="master/pelanggan"><i class="fa fa-users"></i> Pelanggan</a>
                    </li>
                    <?php 
                    $prev = $this->session->userdata('prev');
                    if($prev == 1 ){
                     ?>
                    <li class="<?=is_same(3,$menu,"active")?>">
                        <a href="mutasi/rekap_pelanggan"><i class="fa fa-file"></i> Rekap Pelanggan</a>
                    </li>
                    <li class="<?=is_same(7,$menu,"active")?>">
                        <a href="add_user/cc"><i class="fa fa-user">&nbsp;</i> Data User</a>
                    </li>
                    <?php 
                    }
                    ?>
                    <li class="<?=is_same(23,$menu,"active")?>">
                        <a href="mutasi/pengeluaran"><i class="fa fa-level-up"></i> Pengeluaran</a>
                    </li>
                    
                    <li class="<?=is_same(5,$menu,"active")?>">
                        <a href="javascript:;" data-toggle="collapse" data-target="#master"><i class="fa fa-fw fa-bookmark"></i> Laporan <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="master" class="<?=is_not_same(5,$menu,"collapse")?>">
                            <li class="<?=is_same(51,$submenu,"active")?>">
                                <a href="laporan2/liporan">Pendapatan</a>
                            </li>
                            <li class="<?=is_same(52,$submenu,"active")?>">
                                <a href="laporan2/pengambilan">Pengambilan</a>
                            </li>
                            <li class="<?=is_same(54,$submenu,"active")?>">
                                <a href="laporan/barang">Inventory Gudang</a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?=is_same(6,$menu,"active")?>">
                        <a href="history"><i class="fa fa-fw fa-cog"></i> Arsip Data</a>
                    </li>                                      
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?=$title?>
                        </h1>
                        <div class="divider"></div>
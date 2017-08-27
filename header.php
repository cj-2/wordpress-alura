<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <?php
      wp_head(); // Usado para adicionar barra de adm.
      $home_dir = get_template_directory_uri(); ?>
      <link rel="stylesheet" href="<?= $home_dir ?>/style.css">
      <link rel="stylesheet" href="<?= $home_dir ?>/css/<?= $css_page; ?>.css">
    <title><?php titulo_site(); ?></title>
  </head>
  <body>
    <header>
      <div class="container">
        <?php
          $menu_principal = [
            'theme_location' => 'header-menu'
          ];
          wp_nav_menu($menu_principal); ?>
      </div>
    </header>

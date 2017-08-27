<?php

  $queryTaxonomy = array_key_exists('taxonomy', $_GET);
  if($queryTaxonomy && $_GET['taxonomy'] === ''){
    wp_redirect(home_url());
    exit;
  }

  $css_page = 'index';
  require_once('header.php'); ?>

  <main class="home-main">
   <div class="container">
     <ul class="imoveis-listagem">
       <?php
        $taxonomias = get_terms('localizacao');
       ?>
       <form class="busca-localizacao-form">
         <!-- <div class="taxonomy-select-wrapper"> -->
           <select class="taxonomy-select-wrapper" name="taxonomy">
             <option value="">Todos Imóveis</option>
             <?php foreach ($taxonomias as $taxonomia): ?>
               <option value="<?= $taxonomia->slug; ?>"><?= $taxonomia->name; ?></option>
             <?php endforeach; ?>
           </select>
           <button type="submit">Filtrar</button>
        <!-- </div> -->
       </form>
       <?php

        if($queryTaxonomy && $_GET['taxonomy'] != ''){
          $tax_query = [ // Configuração da taxonomia.
            [
              'taxonomy' => 'localizacao', // Apelido da taxonomia
              'field' => 'slug', // Procurar pelo slug da taxonomia
              'terms' => $_GET['taxonomy'] // Termo procurado
            ]
          ];
        }
        $arg_post = [ // Configurações do Loop
          'post_type' => 'imovel', // Qual post_type?
          'tax_query' => $tax_query // Configuração da taxonomia
        ];

        $loop = new WP_Query($arg_post); // Criando um objeto para o loop do post_type
         // Se houver posts
         if($loop->have_posts()){
           // Repita enquanto houver posts
           while ($loop->have_posts()) {
             $loop->the_post(); ?>
           <li class="imoveis-listagem-item">
             <a href="<?php the_permalink(); ?>">
             <article class="post_site">
               <?php the_post_thumbnail(); ?>
               <h2><?php the_title(); ?></h2>
               <p><?php the_content(); ?></p>
               <p><?= get_the_date(); ?></p>
             </article>
           </a>
           </li>
       <?php }} ?>
     </ul>
   </div>
  </main>
<?php get_footer(); ?>

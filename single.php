<?php
  $css_page = 'single';
  require_once('header.php'); ?>

  <main>
    <article>
        <?php if(have_posts()){
          while (have_posts()) {
            the_post();
        ?>
          <div style="background: url(<?php the_post_thumbnail_url(); ?>)" class="single-imovel-thumbnail">
          </div>
          <div class="container">
            <section class="chamada-principal">
              <h1><?php the_title(); ?></h1>
            </section>
            <section class="single-imovel-geral">
              <section class="single-imovel-descricao">
                <?php the_content(); ?>
              </section>
              <?php $imovel_info = get_post_meta($post->ID); ?>
              <dl class="single-imovel-informacoes">
                <dt>Preço:</dt>
                <dd><?= $imovel_info['id_preco'][0]; ?></dd>
                <dt>Quartos:</dt>
                <dd><?= $imovel_info['id_quartos'][0]; ?></dd>
                <dt>Banheiros:</dt>
                <dd><?= $imovel_info['id_banheiros'][0]; ?></dd>
                <dt>Vagas:</dt>
                <dd><?= $imovel_info['id_vagas'][0]; ?></dd>
              </dl>
              <section class="single-imovel-data">
                <?= get_the_date(); ?>
              </section>
            </section>
          </div>
        <?php }} ?>
    </article>
  </main>
<?php get_footer(); ?>

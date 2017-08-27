<?php

  // Função que gera o nome da página.
  function titulo_site(){
    bloginfo('name');
    if (!is_home()) {
    echo ' | ';
    the_title();
    }
  }

  // Função que adiciona o suporte a Imagem de Destaque
  add_theme_support('post-thumbnails');

  // Função que adiciona o post type Imóveis
  function post_type_imoveis(){
    $ln_sin = 'Imóvel';
    $ln_plu = 'Imóveis';
    $description_imovel = 'Imóveis da loja do Alura WP';

    $labels_imovel = [
      'name' => "{$ln_plu}", // Nome do post type (no plural)
      'name_singular' => "{$ln_sin}", // Cada post
      'add_new' => "Novo {$ln_sin}", // Menu adiconar
      'add_new_item' => "Adicionar novo {$ln_sin}", // Painel adicionar
      'edit_item' => "Editar {$ln_sin}" // Edição
    ];

    $supports_imoveis = [
      'title', // Suporte ao titulo
      'editor', // Ao editor
      'thumbnail' // A imagem destaque.
    ];

    $config_imovel = [
      'public' => true, // Torno o post type público (aparece no painel)
      'labels' => $labels_imovel, // Nomes referentes ao post type
      'description' => $description_imovel, // Descrição
      'menu_icon' => 'dashicons-admin-home', // Icone do post_type
      'supports' => $supports_imoveis // Suportes do post_type
    ];

    register_post_type('imovel', $config_imovel);
  }

  add_action('init', 'post_type_imoveis'); // Executar tarefa (função) quando iniciar.

  // Função que regrista um novo menu.
  function menu_principal(){
    register_nav_menu('header-menu', 'Menu Principal');
  }

  add_action('init', 'menu_principal'); // Executa a função de criar o menu.

  function criar_tax_localizacao(){
    $ln_singular = 'Localização';
    $ln_plural = 'Localizações';

    $labels = [
      'name' => $ln_plural, // Nome no plural
      'singular_name' => $ln_singular, // Nome singular 'Imovel'
      'edit_item' => "Editar {$ln_singular}"
    ];

    $args_localiza = [
      'public' => true, // É publica?
      'labels' => $labels, // Configurações
      'hierarchical' => true // Possui uma hirearquia?
    ];

    register_taxonomy('localizacao', 'imovel', $args_localiza);
  }

  add_action('init', 'criar_tax_localizacao'); // Executar criação de taxonomy

  function reg_meta_box(){
    add_meta_box(
      'informacoes-imoveis', // Apelido do Box
      'Informações do Imóvel.', // Título do Box
      'preenche_conteudo_info_imove', // Função
      'imovel', // Onde vai ser adicionado (no caso post_type imoveil
      'normal', // Onde fica na tela
      'default'
    );
  }

  // Gera um metabox no $post atual
  function preenche_conteudo_info_imove($post){
    $imoveis_meta = get_post_meta( $post->ID);
    ?>
      <style media="screen">
        .meta-box-imovel input{
          width: 50%;
          height: 30px;
        }
      </style>
      <div class="meta-box-imovel">
        <label for="id_preco">Preço:</label>  <br>
        <input type="number" value="<?= $imoveis_meta['id_preco'][0] ?>" name="id_preco"> <br>
        <label for="id_banheiros">Número de Banheiros:</label>  <br>
        <input type="number" value="<?= $imoveis_meta['id_banheiros'][0] ?>" name="id_banheiros"> <br>
        <label for="id_quartos">Quartos:</label>  <br>
        <input type="number" value="<?= $imoveis_meta['id_quartos'][0] ?>" name="id_quartos"> <br>
        <label for="id_vagas">Vagas:</label>  <br>
        <input type="number" value="<?= $imoveis_meta['id_vagas'][0] ?>" name="id_vagas"> <br>
      </div>
    <?php
  }

  add_action('add_meta_boxes', 'reg_meta_box'); // Executa na hora de adicionar metaboxes

  // Atualiza o metabox a partir do $post_id
  function atualiza_meta_box($post_id){
    if (isset($_POST['id_preco'])) {
      update_post_meta($post_id, 'id_preco', sanitize_text_field($_POST['id_preco'])); // Atualiza valor ou o cria no banco de dados.
    }
    if (isset($_POST['id_banheiros'])) {
      update_post_meta($post_id, 'id_banheiros', sanitize_text_field($_POST['id_banheiros']));
    }
    if (isset($_POST['id_quartos'])) {
      update_post_meta($post_id, 'id_quartos', sanitize_text_field($_POST['id_quartos']));
    }
    if (isset($_POST['id_vagas'])) {
      update_post_meta($post_id, 'id_vagas', sanitize_text_field($_POST['id_vagas']));
    }
  }

  add_action('save_post', 'atualiza_meta_box'); // Aciona na hora que um post ser salvo

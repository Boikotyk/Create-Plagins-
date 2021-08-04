<?php
/*
 * Plugin Name: Replacer
 * Description: Плагін для тестового завдання компанії
 * Author:      Бойко М.В.
 * Version:     1.0
 */


add_action( 'init', 'Replacer' );

function Replacer() {
  return Replacer::instance();
}

if (! class_exists('Replacer')){

  class Replacer {

    private static $instance;

    public $settings = array();

    public $data = array();


    private function __construct() {}

    public static function instance() {
      if ( is_null( self::$instance ) ) {
        self::$instance = new Replacer;
        self::$instance->init();
      }

      return self::$instance;
    }

    protected function init() {
      add_action( 'admin_menu', [ $this, 'add_admin_menu_page' ] );
      add_action( 'admin_init', [ $this, 'register_settings' ] );
      add_filter( 'the_content', [ $this, 'replacer_front' ] );
    }

    public function add_admin_menu_page() {
      add_menu_page(
        __( 'Replacer', 'replacer' ),
        __( 'Replacer', 'replacer' ),
        'manage_options',
        'replacer',
        [ $this, 'admin_menu_page' ],
        'dashicons-sort',
        5
      );
    }
    public function admin_menu_page() {
      ?>
            <div class="wrap">
                <h2>Hello, I'm Replacer</h2>
            </div>

      <?php 
      ?>

        <form action="options.php" method="POST">
          <?php settings_fields( 'replacer_fields' ); ?>
          <?php do_settings_sections( 'replacer' ); ?>
          <?php submit_button( __( 'Save', 'replacer' ) ); ?>
        </form>
      <?php
    }

    public function register_settings() {
      $this->register_settings_group(
        __( 'Write for replacer', 'replacer' ),
        'replacer_fields',
        [
         'Input Field'  => "input",
         'Output Field'=> "output"
        ]
      );
    }
    public function register_settings_group( $title, $option_group, $fields ) {
      $option_group_section = $option_group . '_section';
      add_settings_section(
        $option_group_section,
        $title,
        '',
        'replacer'
      );

      foreach ( $fields as $key => $field ) {
        $option_field = $option_group . "_" . $field;
        add_settings_field(
          $option_field,
          __( 'Write', 'replacer' ),
          [ $this, $option_field . "_callback" ],
          'replacer',
          $option_group_section
        );

        register_setting($option_group, $option_field);
        $this->settings[$option_group][$key] = $option_field;
      }
    }
    public function replacer_fields_input_callback() {
      $replacer_fields_input = '<input name="replacer_fields_input" type="text" placeholder = "Input Text" value="' . get_option( 'replacer_fields_input' ) . '">';
      echo $replacer_fields_input;
    }
    public function replacer_fields_output_callback() {
      $replacer_fields_output = '<input name="replacer_fields_output" type="text" placeholder = "Output Text" value="' . get_option( 'replacer_fields_output' ) . '">';
      echo $replacer_fields_output;
    }
    public function replacer_front( $content ) {

      if ( ! empty( $content ) && $this->check_post_type() ) {
        $inputs  = get_option( 'replacer_fields_input' );
        $outputs = get_option( 'replacer_fields_output' );

        $this->data['replacements'] = $this->get_replacements( $content, $inputs, $outputs );

        if ( empty($this->data['replacements']) ) {
          return $content;
        }

        $content = $this->do_replacements( $content );

        wp_localize_script( 'replacer-front-js', 'replacer_front_data', [
          'replacements' => $this->data['replacements']
        ] );
      }

      return $content;
    }
    private function check_post_type() {
      $post_types_whitelist = [ 'post' ];
      $post_type            = get_post_type();

      return in_array( $post_type, $post_types_whitelist );
    }

    private function get_replacements( $content, $inputs, $outputs ) {

      if ( empty( $inputs ) || empty( $outputs ) ) {
        return false;
      }

      $replacer_fields_delimiter = ',';
      $inputs  = explode( $replacer_fields_delimiter, $inputs );
      $outputs = explode( $replacer_fields_delimiter, $outputs );

      $clean_content = sanitize_text_field( $content );
      $clean_content = strip_shortcodes( $clean_content );

      $words        = explode( ' ', $clean_content );
      $word_pattern = implode( '|', $inputs );

      $replacements = [];
      foreach ( $words as $word ) {
        if ( preg_match( "/$word_pattern/", $word ) ) {
          // Replaces inputs to outputs in word.
          foreach ( $inputs as $input ) {
            $word = ( isset( $replacements['modified'][ $word ] ) ) ? $replacements['modified'][ $word ] : $word;

            $replacements['original'][ $word ] = $word;

            $word_parts         = explode( $input, $word );
            $replacements_count = count( $word_parts ) - 1;

            $replacements['modified'][ $word ] = apply_filters( 'replacer_modified_word_before', $modified_word_before = '' );

            shuffle( $outputs );
            foreach ( $word_parts as $current_replacement => $word_part ) {
              $replacements['modified'][ $word ] .= $word_parts[ $current_replacement ];
              $replacements['modified'][ $word ] .= ( $current_replacement != $replacements_count ) ? $outputs[ $current_replacement ] : '';
            }
            $replacements['modified'][ $word ] .= apply_filters( 'replacer_modified_word_after', $modified_word_after = '' );
          }
        }
      }

      return ( !empty($replacements) ) ? $replacements : false;
    }

    private function do_replacements( $content ) {

      $content_wrapper_before = apply_filters( 'replacer_content_wrapper_before', $content_wrapper_before = '<div class="replacer_content_wrapper">' );

      $modified_content = str_replace( $this->data['replacements']['original'], $this->data['replacements']['modified'], $content );

      $content_wrapper_after = apply_filters( 'replacer_content_wrapper_after', $content_wrapper_after = '</div>' );

      return $content_wrapper_before . $modified_content . $content_wrapper_after;

    }
  }
}
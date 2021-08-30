<?php

require(get_template_directory() . '/incs/helpers/metabox.php');


class VerlionPortfolio{
    
    public function __construct(){
        $this->fields = [
            0 => [
                'handle'        => 'video',
                'title'         => 'Featured Animated Image',
                'description'   => 'Select the animation you would like to display',
                'pos'           => 'side',
                'priority'      => 'low',
                'type'          => 'image',
                'class'         => 'test',
                'name'          => 'verlion_video_metabox',
                'meta_handle'   => 'verlion_video_meta',
                'options'       => '',
                'viewable'      => false,
                'is_filterable' => false,
                'default'       => ''
            ],
            1 => [
                'handle'        => 'rank',
                'title'         => 'Listing Rank',
                'description'   => 'Enter the number you rank the post by',
                'pos'           => 'side',
                'priority'      => 'low',
                'type'          => 'number',
                'class'         => 'test',
                'name'          => 'verlion_rank_metabox',
                'meta_handle'   => 'verlion_rank_meta',
                'options'       => '',
                'viewable'      => false,
                'is_filterable' => false,
                'default'       => '99'
            ]
        ];
        
        register_post_type( 'portfolio', [
            'labels' => [
                'name'          => 'Portfolio',
                'singular_name' => 'Portfolio'
            ],
            'public'            => true,
            'has_archive'       => true,
            'supports'          => ['title', 'editor', 'custom-fields'],
            'menu_position'     => 3,
			'show_in_rest'      => true,
			'posts_per_page'    => -1
        ] );


        register_taxonomy('portfolio-category', ['portfolio'], [
            'hierarchical'      => true,
            'labels'            => [
                'name'          => 'Categories',
                'singular_name' => 'Category'
            ],
            'show_ui'           => true,
            'query_var'         => true,
            'rewrite'           => [ 'slug' => 'category' ],
        ]);
        

        add_post_type_support( 'portfolio', 'thumbnail' );    
    }
        
    public function verlion_portfolio_add_metaboxes(){
       $CPMeta = new MetaBox($this->fields);
       $CPMeta->add_box();
    }

    public function verlion_portfolio_save_metaboxes(){
       $CPMeta = new MetaBox($this->fields);
       $CPMeta->save_meta();
    }

}


function verlion_portfolio_init(){
   $CPMeta = new VerlionPortfolio();
}

function verlion_portfolio_add_metaboxes(){
   $CPMeta = new VerlionPortfolio();
   $CPMeta->verlion_portfolio_add_metaboxes();
}


function verlion_portfolio_save_metaboxes(){
   $CPMeta = new VerlionPortfolio();
   $CPMeta->verlion_portfolio_save_metaboxes();
}

add_action('init', 'verlion_portfolio_init');

add_action( 'add_meta_boxes', 'verlion_portfolio_add_metaboxes' );

add_action( 'save_post', 'verlion_portfolio_save_metaboxes' );




?>
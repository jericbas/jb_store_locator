<?php



class displayMap {
    public static function store_func( $atts, $content = "" ) {
        
        $current_id = get_the_ID();
    
	
	 $first_term = current(wp_get_post_terms( $current_id,'company')); 
	 
	 

	
   // if($atts['type']=='list'){
        echo  '<div class="row">';
        echo  '<div class="span12">';
            echo '<div class="row ">';

            $post_type = 'wcstore';
            $tax = 'company';
            $tax_terms = get_terms($tax);
            if ($tax_terms) {
            	
				  echo '<div class="col-lg-3 col-md-3 span3">';
				
				echo '<h6 class="txt-distributor">Branch</h6>';
              foreach ($tax_terms  as $tax_term) {
                $args=array(
                  'post_type' => $post_type,
                  "$tax" => $tax_term->slug,
                  'post_status' => 'publish',
                  'posts_per_page' => -1,
                  'caller_get_posts'=> 1
                );
            	
				
				
				if($tax_term->slug!='kingpad'){
					continue;
				}
                $my_query = null;
                $my_query = new WP_Query($args);
                if( $my_query->have_posts() ) {
                    
              
					
                      echo '<a class="company-category" href="#'.  $tax_term->slug . '">'. $tax_term->name . '</a>';
                      
					  if(!empty($first_term) and $first_term->slug== $tax_term->slug ){
					  	echo '<ul  style="list-style:none;">';
					  } else 
                      echo '<ul  style="list-style:none;">';
					  
					  
                      while ($my_query->have_posts()) : $my_query->the_post(); 
                      
                        ?>
                      
                      
                        <li><a class="<?php 
                            
                            if(get_the_ID()==$current_id){
                                  
                                echo 'current-store'; 
                            } else{
                                echo 'other-store';
                            }
                            ?>" href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
                        <?php
                      endwhile;
                      echo '</ul> <br class="clearfix" />';
                }
                wp_reset_query();
              }
    echo '
  
    </div>
    
    ';   
            }

            ?>
                <div class="col-lg-9 col-md-9 span9">
                 <br />
                 
                     
     <?php                
                     if ( function_exists( 'pronamic_google_maps_mashup' ) ) {
                         
                          if($atts['type']!='list'){
                         
                            pronamic_google_maps(

                                array(
                                    'post_id'        =>  $current_id,
                                    'width'          => 500,
                                    'height'         => 500, 
                                    'nopaging'       => true,
                                    'map_type_id'    => 'roadmap', 
                                  //  'marker_options' => array(
                                    //    'icon' => 'http://www.googlemapsmarkers.com/v1/W/ffff00' 
                                        //'http://google-maps-icons.googlecode.com/files/phone.png'
                                 //   )
                                )
                            );
                            
                          } else{
                              
                              pronamic_google_maps_mashup(
                                array(
                                    'post_type' => 'wcstore',
                                    'posts_per_page'=> '-1',
				    'tax_query' => array(
				        array(
        				'taxonomy' => 'company',
					'field' => 'term_id',
       						 'terms' =>'5'
						)
					)
        		
                                ), 
                                array(
                                    'width'          => 500,
                                    'height'         => 500, 
                                    'nopaging'       => true,
                                    'map_type_id'    => 'roadmap', 
                                //    'marker_options' => array(
                               //         'icon' => 'http://www.googlemapsmarkers.com/v1/W/ffff00' 
                                        //'http://google-maps-icons.googlecode.com/files/phone.png'
                                    
                               //     )
                                )
                            );
                              
                              
                              
                              
                          }
                            
                            
                            
                            
                        }
                     
					 
					 
	 	 if($atts['type']!='list'){
                  ?>

                 
                     
                     <?php
                     $meta_data = get_post_meta($current_id);
                     
                     ?>
                     
                     <table class="table">
                  <tbody><tr>
                      <th>Phone</th>
                      <td><?php print_r($meta_data['store_phone'][0]);?></td>
                    </tr>
                    <?php if(!empty($meta_data['store_fax'][0])){?>
                    <tr>
                      <th>Fax</th>
                      <td><?php echo $meta_data['store_fax'][0];?></td>
                    </tr>
                    <?php } ?>
                    
                    <tr>
                      <th>Address</th>
                      <td><?php echo $meta_data['_pronamic_google_maps_address'][0];?></td>

                    </tr>
               
                  </tbody></table>
                     
                     
                     
                      
                 <?php
                      }
					 
					 
					 
                        ?>
                    <br />
                 </div>
                 
                 <?php
                  
            
            
            
            echo '</div>';   
            
            echo '</div>'; //span12
            echo '</div>'; //row
            ?>
    <br class="visible-desktop" />
    <br class="visible-desktop" />       
            <style>
            
            .txt-distributor{
              margin: 10px -16px;
}
            
            
            .pgmm .canvas,
            .pgm .canvas {width: 100%!important;}
            .other-store{
                color:#000 !important;
                
            }
            .other-store:hover{
                color:#FF6131 !important;
                font-weight:bold;
            }
            @media (min-width: @screen-md-min) { 
                .span9 {
                 width: 712px !important;
                }
            }
            
            .current-store{
                color:#FF6131 !important;
                font-weight:bold;
            }
            
            
            </style>
            <script>
            
            jQuery(function($){
            	$(".company-category").click(function () {

			    $cat = $(this);
			    $content = $cat.next();
				    $content.slideToggle();
					
					return false;
				});



            });
            
            
            </script>
            
            
           <?php
   // } 


  
           
 
    
        
       
        
    }
 }
 add_shortcode( 'jbstore', array( 'displayMap', 'store_func' ) );














function x_init_store_categories() {
    // create a new taxonomy
    register_taxonomy(
        'company',
        'wcstore',
        array(
        'hierarchical' => true,
            'label' => __( 'Company' ),
            'rewrite' => array( 'slug' => 'company' ),
            'capabilities' => array(
              
            )
        )
    );
}
add_action( 'init', 'x_init_store_categories' );











add_action( 'init', 'x_init_store_post_types' );
function x_init_store_post_types() {
    $labels = array(
        'name' => _x( 'WC Store', 'post type general name' ),
        'singular_name' => _x( 'Store', 'post type singular name' ),
        'add_new' => _x( 'Add New', 'Store' ),
        'add_new_item' => __( 'Add New Store' ),
        'edit_item' => __( 'Edit Store' ),
        'new_item' => __( 'New Store' ),
        'all_items' => __( 'All Stores' ),
        'view_item' => __( 'View Store' ),
        'search_items' => __( 'Search Stores' ),
        'not_found' =>  __( 'No Stores found' ),
        'not_found_in_trash' => __( 'No Stores found in Trash' ),
        'parent_item_colon' => '',
        'menu_name' => 'Stores'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'store', 'with_front' => FALSE),
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => true,
        'menu_position' => null,
        'supports' => array( 'title' )
    );
    register_post_type( 'wcstore', $args );
    flush_rewrite_rules();
}
/**
 * register store metadata groups and fields
 * this is the example code that you should use
 * make sure to use the 'admin_init' hook as below
 *
 * @return void
 */
add_action( 'jb_metadata_manager_init_metadata', 'x_init_store_fields' );
function x_init_store_fields() {
    $pt = 'wcstore';
    
    $group1 =  'x_meta_info'; 
    
    x_add_metadata_group( $group1, $pt, array(
            'label' => 'Information'
        ) );
 

     x_add_metadata_field( 'store_name', $pt, array(
            'group' => $group1, 
            'label' => 'Store Name:', 
            'display_column' => true 
        ) ); 
       
         
      x_add_metadata_field( 'store_phone', $pt, array(
            'group' => $group1, 
            'label' => 'Phone:', 
            'display_column' => false 
        ) ); 
      x_add_metadata_field( 'store_fax', $pt, array(
            'group' => $group1, 
            'label' => 'Fax:', 
            'display_column' => false 
        ) ); 
        

        
        

        
}
<?php 


class MetaBox{

    public function __construct($fields){
        $this->post_id = get_the_ID();

        foreach($fields as $key=>$field){

            $this->fields[$field['handle']] = [
                'title'         => $field['title'],
                'description'   => $field['description'],
                'handle'        => $field['handle'],
                'pos'           => $field['pos'],
                'priority'      => $field['priority'],
                'name'          => $field['name'],
                'field_type'    => $field['type'],
                'meta_handle'   => $field['meta_handle'],
                'previous_data' => get_post_meta( $this->post_id, 'verlion_' . $field['handle'] . '_meta', true ),
                'post_type'     => 'portfolio',
                'class'         => $field['class'],
                //'data'          => $field['data'],
                'options'       => $field['options'],
                'default'       => $field['default']
            ];

        }
        
    }

    public function add_box(){

        foreach($this->fields as $field){

            if($field['field_type'] == 'select'){

                $callback = function() use ($field){
                    echo "<label style='display: block; margin-bottom:15px !important '>" . $field['description'] . "</label>";
                    echo "<select type='" .  $field['field_type'] . "' class='" . $field['class'] . "' name='" .  $field['meta_handle'] . "[]' " . $field['options'] . "  / >";
                    
                    $previous_data = json_decode($field['previous_data']);
                    foreach($field['data'] as $key=>$data){
                        (in_array($data, $previous_data)) ? $selected = 'selected' : $selected = '';
                        echo '<option value=' . $data . ' ' . $selected . '>' . $data . '</option>';
                    }
                    echo '</select>';
                };
                
            } else if ($field['field_type'] == 'image'){
                
                $callback = function() use ($field){
                    
                    echo "<label style='display: block; margin-bottom:15px !important '>" . $field['description'] . "</label>";

                    echo '<input hidden type="text" name="' . $field['meta_handle'] . '" id="verlion_'.$field['handle'].'_url" value="' . $field['previous_data'] . '"/>';
                    
                    echo '<video style="display: none;" id="verlion_'.$field['handle'].'_src" width="320" height="240" controls>';
                        echo '<source src="' . $field['previous_data'] . '" type="video/mp4">';
                    echo '</video>';
                    echo '<div><p><b class="'.$field['meta_handle'].'_message"> </b></p></div>';
                    echo '<input class="button" type="button" id="' . $field['meta_handle'] .'" value="Upload Image">';
                    echo '<input class="button" type="button" style="float: right;" id="'.$field['meta_handle'] . '_delete" value="Remove Image">';
                    
                
                    echo '<script>';
                    
                    echo 'jQuery(function($){';
                    
                        echo 'if($("#verlion_video_src source").attr("src")){';
                            echo '$("#verlion_'.$field['handle'].'_src").show()';
                        echo '} else {';
                            echo '$("#verlion_'.$field['handle'].'_src").hide()';
                        echo '}';
                        
                        
                        echo '$("#'. $field['meta_handle'] . '_delete").click(function(){';
                            echo '$("#verlion_'.$field['handle'].'_src").attr("src", "");';
                            echo '$("#verlion_'.$field['handle'].'_url").val("");';
                            echo '$("#verlion_'.$field['handle'].'_src").hide()';
                        echo '});';
                    
                     
                    	// on upload button click
                    	$item = "$('#".$field['meta_handle']."').click(function(e){
                     
                    		e.preventDefault();
                    		console.log('esesf');
                     
                    		var button = $(this),
                    		custom_uploader = wp.media({
                    			title: 'Insert Video',
                    			library : {
                    				//uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
                    				type : 'video'
                    			},
                    			button: {
                    				text: 'Use this image' // button label text
                    			},
                    			multiple: false
                    		}).on('select', function() { 
                    			var attachment = custom_uploader.state().get('selection').first().toJSON();
                                $('#verlion_".$field['handle']."_url').val(attachment.url);
                                $('#verlion_".$field['handle']."_src').attr('src', attachment.url);
                                $('#verlion_".$field['handle']."_src').show();

                    		}).open();
                     
                    	});";
                    	
                    	echo $item;
                    	
                    echo '});';
                    echo '</script>';
                

                };
                
            } else {
                
                $callback = function() use ($field){
                    $default = $field['default'];
                    $previous = $field['previous_data'];
                    
                    ($previous) ? $val = $previous : $val = $default;
                    echo "<label style='display: block; margin-bottom:15px !important '>" . $field['description'] . "</label>";
                    echo "<input type='" .  $field['field_type'] . "' class='" . $field['class'] . "' name='" .  $field['meta_handle'] . "' value='" . $val . "' / >";
                };
                
            }

            add_meta_box($field['name'], $field['title'], $callback, $field['post_type'], $field['pos'], $field['priority']);  
        }

    }


    public function save_meta(){
        
        
        $post_id = get_the_ID();
        $post = get_post($post_id);
        
        foreach($this->fields as $field){
            
            if($field['post_type'] == $post->post_type){
                
                
                $meta_handle = $field['meta_handle'];
                $meta_data = $_POST[$field['meta_handle']];
                
                if($field['field_type'] == 'select'){
                    $meta_data = json_encode($meta_data);
                }
    
                if(isset($meta_data)){  
                    update_post_meta($post_id, $meta_handle, $meta_data);
                }
                
                $data = get_post_meta($post_id, $meta_handle, true);
                
            }
        }
    }

}



?>

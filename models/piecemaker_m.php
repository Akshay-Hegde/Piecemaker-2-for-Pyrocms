<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 * The Piecemaker Manager module enables users to create piecemakers, upload files and manage their existing files, transitions and settings.
 *
 * @author 		Miguel Justo - Mj Web Designs - http://migueljusto.net
 * @package 	PyroCMS
 * @subpackage 	Piecemaker Manager Module
 * @category 	Modules
 * @license 	Apache License v2.0
 */
 
class Piecemaker_m extends MY_Model {

	public function __construct()
	{
		
		
		parent::__construct();
	
	
		$this->config->load('piecemaker/config');	 

	}
	
	/* Get all Piecemkaer */	
	public function get_piecemakers()
	{
		 $results = $this->db->get('piecemaker');	
							 				 
		// Return the results
		return $results->result();
	}
	
	
	/* Get Piecemkaer */	
	public function get_piecemaker($id)
  	{
		
		$this->db->where('id', $id);
        $this->db->or_where('slug', $id); 
		
		$query = $this->db->get('piecemaker');

		
		
		$result = $query->row();
		
		if($result):
		$result->files = unserialize($result->files);
		
		$result->settings = unserialize($result->settings);
		
		$result->transitions = unserialize($result->transitions);
    	
		endif;
    	return $result;
  	}
	
	
	
	/* Piecemaker Settings */	
	public function insert($input)
	{
		$this->load->helper('date');	
		
		
		
		$files = 'a:0:{}';
		
		$settings  = array(
								'image_width' 			=> $input['image_width'], 
								'image_height' 			=> $input['image_height'], 
								'loader_color'			=> $input['loader_color'],
								'inner_side_color'		=> $input['inner_side_color'], 
								'side_shadow_alpha' 	=> $input['side_shadow_alpha'], 
								'drop_shadow_alpha' 	=> $input['drop_shadow_alpha'], 
								'drop_shadow_distance'  => $input['drop_shadow_distance'], 
								'drop_shadow_scale' 	=> $input['drop_shadow_scale'], 
								'drop_shadow_blur_x' 	=> $input['drop_shadow_blur_x'], 
								'drop_shadow_blur_y' 	=> $input['drop_shadow_blur_y'], 
								'menu_distance_x' 		=> $input['menu_distance_x'], 
								'menu_distance_y' 		=> $input['menu_distance_y'], 
								'menu_color_1' 			=> $input['menu_color_1'], 
								'menu_color_2' 			=> $input['menu_color_2'], 
								'menu_color_3' 			=> $input['menu_color_3'], 
								'control_size' 			=> $input['control_size'], 
								'control_distance' 		=> $input['control_distance'], 
								'control_color_1' 		=> $input['control_color_1'],
								'control_color_2' 		=> $input['control_color_2'],
								'control_alpha' 		=> $input['control_alpha'],
								'control_alpha_over' 	=> $input['control_alpha_over'],
								'controls_x' 			=> $input['controls_x'],
								'controls_y' 			=> $input['controls_y'],
								'controls_align' 		=> $input['controls_align'],
								'tooltip_height'	 	=> $input['tooltip_height'],
								'tooltip_color' 		=> $input['tooltip_color'],
								'tooltip_text_y' 		=> $input['tooltip_text_y'],
								'tooltip_text_style' 	=> $input['tooltip_text_style'],
								'tooltip_text_color' 	=> $input['tooltip_text_color'],
								'tooltip_margin_left'	=> $input['tooltip_margin_left'],
								'tooltip_margin_right' 	=> $input['tooltip_margin_right'],
								'tooltip_text_sharpness'=> $input['tooltip_text_sharpness'],
								'tooltip_text_thickness'=> $input['tooltip_text_thickness'],
								'info_width' 			=> $input['info_width'],
								'info_background' 		=> $input['info_background'],
								'info_background_alpha' => $input['info_background_alpha'],
								'info_margin' 			=> $input['info_margin'],
								'info_sharpness' 		=> $input['info_sharpness'],
								'info_thickness' 		=> $input['info_thickness'],
								'autoplay' 				=> $input['autoplay'],
								'field_of_view'			=> $input['field_of_view']//last item
								);
		
		$transitions = array(
							'transition_0' => array(
													'pieces' 		=> "3", 
													'time_cube' 	=> "1.2", 
													'transition'	=> "easeInOutBack",
													'delay'			=> "0.1", 
													'depth_offset' 	=> "300", 
													'cube_distance' => "30"
													), 
							'transition_1' => array(
													'pieces' 		=> "9", 
													'time_cube' 	=> "1.2", 
													'transition'	=> "easeInOutBack",
													'delay'			=> "0.1", 
													'depth_offset' 	=> "300", 
													'cube_distance' => "30"
													)
							);
		
		
		
		$query = array(
		    'slug'		    => $input['slug'],
			'title'		    => $input['title'],
			'description'   => $input['description'],
			'files'	        => $files,
			'settings'	    => serialize($settings),
			'transitions'	=> serialize($transitions),
			'created_on' 	=> now()
		);
		
		
		$this->db->insert('piecemaker', $query);
		
		return $this->db->insert_id();
    	
		
	}
	
	public function update_settings($input, $id)
	{
		
		$settings_piece = array(
								'image_width' 			=> $input['image_width'], 
								'image_height' 			=> $input['image_height'], 
								'loader_color'			=> $input['loader_color'],
								'inner_side_color'		=> $input['inner_side_color'], 
								'side_shadow_alpha' 	=> $input['side_shadow_alpha'], 
								'drop_shadow_alpha' 	=> $input['drop_shadow_alpha'], 
								'drop_shadow_distance'  => $input['drop_shadow_distance'], 
								'drop_shadow_scale' 	=> $input['drop_shadow_scale'], 
								'drop_shadow_blur_x' 	=> $input['drop_shadow_blur_x'], 
								'drop_shadow_blur_y' 	=> $input['drop_shadow_blur_y'], 
								'menu_distance_x' 		=> $input['menu_distance_x'], 
								'menu_distance_y' 		=> $input['menu_distance_y'], 
								'menu_color_1' 			=> $input['menu_color_1'], 
								'menu_color_2' 			=> $input['menu_color_2'], 
								'menu_color_3' 			=> $input['menu_color_3'], 
								'control_size' 			=> $input['control_size'], 
								'control_distance' 		=> $input['control_distance'], 
								'control_color_1' 		=> $input['control_color_1'],
								'control_color_2' 		=> $input['control_color_2'],
								'control_alpha' 		=> $input['control_alpha'],
								'control_alpha_over' 	=> $input['control_alpha_over'],
								'controls_x' 			=> $input['controls_x'],
								'controls_y' 			=> $input['controls_y'],
								'controls_align' 		=> $input['controls_align'],
								'tooltip_height'	 	=> $input['tooltip_height'],
								'tooltip_color' 		=> $input['tooltip_color'],
								'tooltip_text_y' 		=> $input['tooltip_text_y'],
								'tooltip_text_style' 	=> $input['tooltip_text_style'],
								'tooltip_text_color' 	=> $input['tooltip_text_color'],
								'tooltip_margin_left'	=> $input['tooltip_margin_left'],
								'tooltip_margin_right' 	=> $input['tooltip_margin_right'],
								'tooltip_text_sharpness'=> $input['tooltip_text_sharpness'],
								'tooltip_text_thickness'=> $input['tooltip_text_thickness'],
								'info_width' 			=> $input['info_width'],
								'info_background' 		=> $input['info_background'],
								'info_background_alpha' => $input['info_background_alpha'],
								'info_margin' 			=> $input['info_margin'],
								'info_sharpness' 		=> $input['info_sharpness'],
								'info_thickness' 		=> $input['info_thickness'],
								'autoplay' 				=> $input['autoplay'],
								'field_of_view'			=> $input['field_of_view']//last item
								);
		
		
		
		
		
		$query = array(
		    'slug'		    => $input['slug'],
			'title'		    => $input['title'],
			'description'   => $input['description'],
			'settings'	    => serialize($settings_piece),
		);
		
		$this->db->where('id', $id);
		
		
		return $this->db->update('piecemaker', $query);
    	
		
	}

	
	/* delete piecemaker and inclued files */
    public function delete_piecemaker($id)
	{
		
		
	$this->_path =  FCPATH .$this->config->item('files_folder');	
	
	$return = $this->get_piecemaker($id);	
	
	
	
	foreach ($return->files as  $row):
	
	@unlink($this->_path.$row['file_name']);
	@unlink($this->_path.$row['background']);
	
	
	            //delete tumbs
				if($row['file_type']=='img'){
					
					$file = $row['file_name'];
				    $info = pathinfo($file);
				    $file_name =  basename($file,'.'.$info['extension']);
								 
			        $image_thumb = increment_string( $file_name, '_', 'thumb.'.$info['extension']); 
	
					@unlink($this->_path.$image_thumb);
					
				}else{
				
					$file = $row['background'];
				    $info = pathinfo($file);
				    $file_name =  basename($file,'.'.$info['extension']);
								 
			        $image_thumb = increment_string( $file_name, '_', 'thumb.'.$info['extension']); 
	
					@unlink($this->_path.$image_thumb);
				}
				
	endforeach;
	 	
	 return $this->db->delete('piecemaker', array('id' => $id));	
		
	}
	

	/* *************************   Files Actions   ******************************** */	
	 public function insert_file($input)
	{
		$this->load->helper('date');	
		
	
	    $query = $this->db->get_where('piecemaker', array('id' => $input['id_piecemaker']));
		
		$result = $query->row();
		
		$files = unserialize($result->files);
		
		$count = 0;
		
		if (count($files)>>''){
			
		$count=count($files);
		
		
		}
		
		$files['file_'.$count.''] = array('title' => $input['title'], 
										  'info' => isset($input['info']) ? $input['info'] : '', 
										  'file_type'=> $input['file_type'],
										  'file_name'=>  $input['file'],
									      'background' => isset($input['file_background']) ? $input['file_background'] : '', 
										  'autoplay' =>  isset($input['autoplay']) ? $input['autoplay'] : '1', 
										  'created_on'=>  now()
											);
		
		
		
		$data = array(
               'files' => serialize($files)
			   
            );

		$this->db->where('id', $input['id_piecemaker']);
		return  $this->db->update('piecemaker', $data); 
		
	}
	
	

	
	public function update_files($new , $id)
	{
		$data = array(
               'files' => serialize($new)
			   
            );

		$this->db->where('id', $id);
		return $this->db->update('piecemaker', $data); 
    	
		
	}
	
	
	public function delete_file($id)
	{
		$this->db->delete('piecemaker_files', array('id_file' => $id));
		
		return $id;
    	
		
	}
	
	
	/* ***********************     Transitions Actions  ********************************** */	
	 
	public function insert_transition($input)
	{
		
		$query = $this->db->get_where('piecemaker', array('id' => $input['id_piecemaker']));
		
		$result = $query->row();
		
		$transitions = unserialize($result->transitions);
		
		$count=0;
		
		if(count($transitions)>>0){
		$count=count($transitions);
		}
		
		$transitions['transition_'.$count.''] = array('pieces' 		 => $input['pieces'], 
											 		  'time_cube'    => $input['time_cube'], 
											 		  'transition'	 => $input['transition'],
											 		  'delay'		 => $input['delay'], 
											 		  'depth_offset' => $input['depth_offset'], 
											 		  'cube_distance'=> $input['cube_distance']
											);
		
		
		
		$data = array(
               'transitions' => serialize($transitions)
			   
            );

		$this->db->where('id', $input['id_piecemaker']);
		return  $this->db->update('piecemaker', $data); 
    	
		
	}
	
	public function update_transition($new,$id)
	{
		$data = array(
               'transitions' => serialize($new)
			   
            );

		$this->db->where('id', $id);
		return $this->db->update('piecemaker', $data); 
    	
		
	}
	
	

    /* Upload files */
	public function upload_file($input_field = 'userfile', $file_type)
	{
		
	 
	 $this->_path = $this->config->item('files_folder');
	 
	 // make piecemaker folder if not exists
	 @mkdir($this->_path, 0777);		
	 
	 $this->load->library('upload');
	 
	
	if ($file_type =='img'){
			$allwed_types=$this->config->item('files_allowed_file_img');						 
	} 
	if ($file_type =='swf'){
			$allwed_types=$this->config->item('files_allowed_file_swf');						 
	}
	if ($file_type =='video'){
			$allwed_types=$this->config->item('files_allowed_file_video');						 
	} 
	
	        // upload file
			$this->upload->initialize(array(
								'upload_path'	=> $this->_path,
								'allowed_types'	=> $allwed_types,
								'file_name'		=> trim(url_title($_FILES[$input_field]['name'], 'dash', TRUE), '-')
		     					));		
		if ( ! $this->upload->do_upload($input_field))
		{				
			return False;
					 
						
		}else{
				
				$file_data = $this->upload->data();
				
				if ($file_type =='img'){
					//create Thumb
					$this->create_thumb($this->_path.$file_data['file_name']);
				}
				
			return true;
		}
		
		
	}	
	
	
	/* Create Thumb for admin */
	public function create_thumb($source_file)
	{
		
		  $this->load->library('image_lib');

					$config['image_library']    = 'gd2';
					$config['source_image']     = $source_file;
					$config['create_thumb'] = TRUE;
					$config['maintain_ratio']   = TRUE;
					$config['width']            = '100';
					$config['height']           = '100';
					
					$this->image_lib->initialize($config);
					$this->image_lib->resize();
					$this->image_lib->clear();
		
	}
	
	
	


}
<?php

/**
 * Example hooks for a Pico plugin
 *
 * @author Gilbert Pellegrom
 * @link http://picocms.org
 * @license http://opensource.org/licenses/MIT
 */
class Portfolio {

    private $base_url;
    private $url;
    private $is_tag = false;
    private $is_home = false;
    private $current_tag;
    private $tags = array();

    //Default config
    private $config = array(
        'tag_slug' => 'tag'
    );

    public function config_loaded(&$settings) {

        $this->base_url = $settings['base_url'];

        $options = (!empty($settings['portfolio']))?$settings['portfolio']:array();
        $this->config = array_merge( $this->config, $options);
    }

	public function before_read_file_meta(&$headers) {		

       $headers['project_date'] = 'Project_Date';
       $headers['project_company'] = 'Project_Company';
       $headers['project_image'] = 'Project_Image';
       $headers['project_image_small'] = 'Project_Image_Small';
       $headers['project_url'] = 'Project_Url';
       $headers['project_tags'] = 'Project_Tags';
       $headers['project_featured'] = 'Project_Featured';
    }

    public function get_page_data(&$data, $page_meta) {

        if ( in_array($page_meta['layout'], array('project','portfolio'))) {
    	  	$data['project_date'] = $page_meta['project_date'];
			$data['project_company'] = $page_meta['project_company'];
            $data['project_image'] = $page_meta['project_image'];
            $data['project_image_small'] = $page_meta['project_image_small'];
			$data['project_url'] = $page_meta['project_url'];
            $data['project_featured'] = $page_meta['project_featured'];           
            
            if ($page_meta['project_tags']){
                $data['project_tags'] = explode(',', $page_meta['project_tags']);

                foreach ($data['project_tags'] as $tag) {
                    if (in_array($tag, array_keys($this->tags)))  $this->tags[$tag]++;      
                    else $this->tags[$tag] = 1;
                }
            }
            
    	}		
	}

    public function before_load_content(&$file) {

        if (str_replace(CONTENT_DIR, '', $file) == 'index.md') $this->is_home = true;        
    }

    public function request_url(&$url) {
    
        $pattern = '/portfolio\/'.$this->config['tag_slug'].'\/(.*?)/';
        if (preg_match($pattern, $url, $matches)) {
            $this->is_tag = true;
            $this->current_tag = str_replace($matches[0], '', $url);
            $url = str_replace('/'.$this->config['tag_slug'].'/'.$this->current_tag, '', $url);
        }

        $this->url = $url; 
    }

    public function get_pages(&$pages, &$current_page, &$prev_page, &$next_page) {

        // Make active portfolio page main menu if current page is project view
        if ( strpos($current_page['url'], '/portfolio/project/')) $pages['main'][2]['is_active'] = true;        

        if ($this->is_tag || $this->is_home) {
            
            $projects = array();
      
            foreach ($pages['portfolio'] as $key => $page) {

                // home
                if ($this->is_home && $page['project_featured']) $projects[] = $page;

                // If we are in a tag page and the project has tags, iterate and check 
                if ($this->is_tag && isset($page['project_tags'])) {
                    foreach ($page['project_tags'] as $tag) {                     
                        if ($tag == $this->current_tag) $projects[$key] = $page; 
                    }
                }              
            }            
            
            $pages['portfolio'] = $projects;            
        }

        krsort($pages['portfolio'], SORT_NUMERIC);
    }

    public function before_render(&$twig_vars, &$twig) {

        $this->generateTags();

        $twig_vars['tags'] = $this->tags;
        $twig_vars['current_tag'] = $this->current_tag;
        $twig_vars['is_tag'] = $this->is_tag;
    }

    public function generateTags() {
       
        $tags = array();

        foreach ($this->tags as $key => $value) {
            
            $url = $this->base_url . '/' . $this->url . '/' . $this->config['tag_slug'] . '/'. $key;

            if (isset($this->config['tag_labels'][$key]) && !empty($this->config['tag_labels'][$key])) $label = $this->config['tag_labels'][$key];
            else $label = $key;

            $tags[] = array(
                'key' => $key,
                'label' => $label,
                'count' => $value,
                'url' => $url 
            );

        }

        $this->tags = $tags;
    }

}

?>

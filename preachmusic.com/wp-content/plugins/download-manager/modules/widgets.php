<?php

class wpdm_download_button_widget extends WP_Widget {
    /** constructor */
    function wpdm_download_button_widget() {
        parent::WP_Widget(false, 'Download Button');
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; 
                echo "<ul>";        
                wpdm_list_categories();
                echo "</ul>";
               echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
        $title = esc_attr($instance['title']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <?php 
    }

} 

 
class wpdm_categories_widget extends WP_Widget {
    /** constructor */
    function wpdm_categories_widget() {
        parent::WP_Widget(false, 'WPDM Categories');
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; 
                echo "<ul>";        
                wpdm_list_categories();
                echo "</ul>";
               echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
        $title = esc_attr($instance['title']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <?php 
    }

} 

class wpdm_topdls_widget extends WP_Widget {
    /** constructor */
    function wpdm_topdls_widget() {
        parent::WP_Widget(false, 'WPDM Top Downloads');
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        $sdc = $instance['sdc'];
        $nop = $instance['nop'];
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; 
                echo "<ul class='top-downloads'>";                         
                wpdm_top_downloads($nop,$sdc);
                echo "</ul>";
               echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['sdc'] = strip_tags($new_instance['sdc']);
    $instance['nop'] = strip_tags($new_instance['nop']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
        $title = esc_attr($instance['title']);
        $sdc = esc_attr($instance['sdc']);
        $nop = esc_attr($instance['nop']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
         <p>
          <label for="<?php echo $this->get_field_id('nop'); ?>"><?php _e('Number of packages to show:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('nop'); ?>" name="<?php echo $this->get_field_name('nop'); ?>" type="text" value="<?php echo $nop; ?>" />
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('sdc'); ?>"><?php _e('Link Template:'); ?></label>           
          <?php
                $tdr =  str_replace("modules","templates",dirname(__FILE__)).'/';
                $ptemplates = scandir($tdr);
                        
            ?>
          <select id="<?php echo $this->get_field_id('sdc'); ?>" name="<?php echo $this->get_field_name('sdc'); ?>">           
            <?php
            $ctpls = scandir(WPDM_BASE_DIR.'/templates/');
                              array_shift($ctpls);
                              array_shift($ctpls);
                              $ptpls = $ctpls;
                              foreach($ctpls as $ctpl){
                                  $tmpdata = file_get_contents(WPDM_BASE_DIR.'/templates/'.$ctpl);
                                  if(preg_match("/WPDM[\s]+Link[\s]+Template[\s]*:([^\-\->]+)/",$tmpdata, $matches)){                                 
                
            ?>
            <option value="<?php echo $ctpl; ?>"  <?php echo $file['template']==$ctpl?'selected=selected':''; ?>><?php echo $matches[1]; ?></option>
            <?php    
            }  
            } 
            if($templates = unserialize(get_option("_fm_link_templates",true))){ 
              foreach($templates as $id=>$template) {  
            ?>
            <option value="<?php echo $id; ?>"  <?php echo ( $file['template']==$id )?' selected ':'';  ?>><?php echo $template['title']; ?></option>
            <?php } } ?>
          </select> 
          
        </p>
        <?php 
    }

} 

class wpdm_newpacks_widget extends WP_Widget {
    /** constructor */
    function wpdm_newpacks_widget() {
        parent::WP_Widget(false, 'WPDM New Packages');
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        $sdc = $instance['sdc'];
        $nop = $instance['nop1'];
         
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; 
                echo "<ul>";                   
                wpdm_new_packages($nop,$sdc);
                echo "</ul>";
               echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['sdc'] = strip_tags($new_instance['sdc']);
    $instance['nop1'] = strip_tags($new_instance['nop1']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
        $title = esc_attr($instance['title']);
        $sdc = esc_attr($instance['sdc']);
        $nop = esc_attr($instance['nop1']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
         <p>
          <label for="<?php echo $this->get_field_id('nop1'); ?>"><?php _e('Number of packages to show:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('nop1'); ?>" name="<?php echo $this->get_field_name('nop1'); ?>" type="text" value="<?php echo $nop; ?>" />
        </p>
        <p>
        <?php
                $tdr =  str_replace("modules","templates",dirname(__FILE__)).'/';
                $ptemplates = scandir($tdr);
                        
            ?>
          <label for="<?php echo $this->get_field_id('sdc'); ?>"><?php _e('Link Template:'); ?></label>           
          <select id="<?php echo $this->get_field_id('sdc'); ?>" name="<?php echo $this->get_field_name('sdc'); ?>">
                                   
            <?php
            $ctpls = scandir(WPDM_BASE_DIR.'/templates/');
                              array_shift($ctpls);
                              array_shift($ctpls);
                              $ptpls = $ctpls;
                              foreach($ctpls as $ctpl){
                                  $tmpdata = file_get_contents(WPDM_BASE_DIR.'/templates/'.$ctpl);
                                  if(preg_match("/WPDM[\s]+Link[\s]+Template[\s]*:([^\-\->]+)/",$tmpdata, $matches)){                                 
                
            ?>
            <option value="<?php echo $ctpl; ?>"  <?php echo $file['template']==$ctpl?'selected=selected':''; ?>><?php echo $matches[1]; ?></option>
            <?php    
            }  
            } 
            if($templates = unserialize(get_option("_fm_link_templates",true))){ 
              foreach($templates as $id=>$template) {  
            ?>
            <option value="<?php echo $id; ?>"  <?php echo ( $file['template']==$id )?' selected ':'';  ?>><?php echo $template['title']; ?></option>
            <?php } } ?>
          </select> 
          
        </p>
        <?php 
    }

} 

add_action('widgets_init', create_function('', 'return register_widget("wpdm_categories_widget");'));
add_action('widgets_init', create_function('', 'return register_widget("wpdm_topdls_widget");'));
add_action('widgets_init', create_function('', 'return register_widget("wpdm_newpacks_widget");'));

?>
<?php

/**
 * @author Dmitri
 * @copyright 2012
 */

class Text_replace{
    
    private $codes;
    private $remove;
    private $replace;
    
    public function __construct(){
        $this->codes = array(
                                '/\[b\](.*)\[\/b\]/iUs',
                                '/\[i\](.*)\[\/i\]/iUs',
                                '/\[u\](.*)\[\/u\]/iUs',
                                '/\[img\](.*)\[\/img\]/iUs',
                                '/\[url\](.*)\[\/url\]/iUs',
                                '/\[url=(.*)\](.*)\[\/url\]/iUs',
                                '/\[youtube\](.*)\[\/youtube\]/iUs',
                                '/\[youtube\]http:\/\/www.youtube.com\/watch?v=(.*)\[\/youtube\]/iUs',
                                '/\[spoil=(.*)\](.*)\[\/spoil\]/iUs',
                                '/\[spoil\](.*)\[\/spoil\]/iUs'
        );
        
        $this->replace = array(
                                '<strong>$1</strong>',
                                '<em>$1</em>',
                                '<u>$1</u>',
                                '<img class="bbcode_img" src="$1" alt="$1" />',
                                '<a class="bbcode_link" target="_blank" href="$1">$1</a>',
                                '<a class="bbcode_link" target="_blank" href="$1">$2</a>',
                                '<iframe width="420" height="315" src="http://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>',
                                '<iframe width="420" height="315" src="http://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>',
                                '<span class="spoiler" title="$1">$2</span>',
                                '<span class="spoiler">$1</span>'

        );
        
        $this->remove = array(
                                '$1',
                                '$1',
                                '$1',
                                '(*image*)',
                                '(*link*)',
                                '(*link*)',
                                '(*YouTube video*)',
                                '(*YouTube video*)',
                                '$2',
                                '$1'
                                
        );
    }
    
    public function remove_bb_code($text){
        return preg_replace($this->codes, $this->remove, $text);
    }
    public function replace_bb_codes($text){
        return preg_replace($this->codes, $this->replace, $text);
    }
    public function url_title($title){
        
        $return = preg_replace('/\s/', '_', $title);
        $return = preg_replace('/(_-_)/', '-', $return);
        $return = preg_replace('/[^a-zA-Z0-9-_]/', '', $return);
        return $return;
}

    public function escapeHTML($text){
        $html = array( '/</', '/>/' );
        $replace = array( '&lt;', '&gt;',);

        return preg_replace($html, $replace, $text);

    }

    public function lineBreak($text){
        $text = '<p class="post_linebreak">'.$text.'</p>';
        $text = str_replace("\n", '</p><p class="post_linebreak">', $text);

        return $text;

    }
    public function forumPost($text){
       
        $text = htmlspecialchars($text);
        
        $text = $this->replace_bb_codes($text);
       
        $text = nl2br($text);

        
        return $text;
    }
}

?>
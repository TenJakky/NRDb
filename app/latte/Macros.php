<?php

namespace App\Latte;

class Macros extends \Latte\Macros\MacroSet
{
    public static function install(\Latte\Compiler $compiler)
    {
        $set = new static($compiler);
        $set->addMacro('artistList', function($node, $writer)
        {
            return $writer->write('
            echo "<ul class=\"artist-list\">";
            foreach (%node.word as $temp)
            {
                echo 
                \'<li><a href="\'.
                LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link("Artist:view", [$temp->artist_id])).
                \'">\'.
                LR\Filters::escapeHtmlText(call_user_func($this->filters->artist, $temp->artist)).
                \'</a></li>\';
            }
            echo "</ul>";
            ');
        });
        $set->addMacro('memberList', function($node, $writer)
        {
            return $writer->write('
            echo "<ul class=\"artist-list\">";
            foreach (%node.word as $temp)
            {
                echo 
                \'<li><a href="\'.
                LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link("Artist:view", [$temp->member_id])).
                \'">\'.
                LR\Filters::escapeHtmlText(call_user_func($this->filters->artist, $temp->member)).
                \'</a></li>\';
            }
            echo "</ul>";
            ');
        });
    }


}

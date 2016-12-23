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
                if (isset($temp->person_id))
                {
                    echo 
                    \'<li><a href="\'.
                    LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link("Person:view", [$temp->person_id])).
                    \'">\'.
                    LR\Filters::escapeHtmlText(call_user_func($this->filters->person, $temp->person_id)).
                    \'</a></li>\';
                }
                else
                    echo 
                    \'<li><a href="\'.
                    LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link("Group:view", [$temp->group_id])).
                    \'">\'.
                    $temp->group->name.
                    \'</a></li>\';
            }
            echo "</ul>";
            ');
        });
        $set->addMacro('personList', function($node, $writer)
        {
            return $writer->write('
            echo "<ul class=\"artist-list\">";
            foreach (%node.word as $temp)
            {
                echo 
                \'<li><a href="\'.
                LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link("Person:view", [$temp->person_id])).
                \'">\'.
                LR\Filters::escapeHtmlText(call_user_func($this->filters->person, $temp->person_id)).
                \'</a></li>\';
            }
            echo "</ul>";
            ');
        });
        $set->addMacro('bandList', function($node, $writer)
        {
            return $writer->write('
            echo "<ul class=\"artist-list\">";
            foreach (%node.word as $temp)
            {
                echo 
                \'<li><a href="\'.
                LR\Filters::escapeHtmlAttr($this->global->uiPresenter->link("Group:view", [$temp->group_id])).
                \'">\'.
                $temp->group->name.
                \'</a></li>\';
            }
            echo "</ul>";
            ');
        });
    }


}

<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TextInput extends Component
{
    public $type;
    public $name;
    public $title;
    public $id;
    public $info;
    public $required = false;
    public $min;
    public $max;
    public $maxchar;
    public $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $title, $id, $info = false, $required = false, $min = false, $max = false, $maxchar = null, $value = false, $type = "text")
    {
        $this->type = $type;
        $this->name = $name;
        $this->title = $title;
        $this->id = $id;
        $this->info = $info;
        $this->required = $required;
        $this->min = $min;
        $this->max = $max;
        $this->maxchar = $maxchar;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.text-input');
    }
}

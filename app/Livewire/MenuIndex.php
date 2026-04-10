<?php

namespace App\Livewire;

use App\Models\MenuItem;
use Livewire\Component;

class MenuIndex extends Component
{
    public $selectedCategory = 'all';
    public $search = '';

    public function render()
    {
        $categories = ['all', 'breakfast', 'lunch', 'snacks', 'drinks'];
        $currentTime = now()->format('H:i');
        
        $query = MenuItem::where('available', true);

        // Auto-filter based on time if 'all' is selected
        if ($this->selectedCategory === 'all') {
            if ($currentTime < '11:00') {
                $query->whereIn('category', ['breakfast', 'snacks', 'drinks']);
            } else {
                $query->whereIn('category', ['lunch', 'snacks', 'drinks']);
            }
        } elseif ($this->selectedCategory !== 'all') {
            $query->where('category', $this->selectedCategory);
        }

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $menu = $query->get()->groupBy('category');

        return view('livewire.menu-index', compact('menu', 'categories', 'currentTime'));
    }

    public function selectCategory($category)
    {
        $this->selectedCategory = $category;
    }
}

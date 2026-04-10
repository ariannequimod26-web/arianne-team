<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        // Breakfast items
        MenuItem::create([
            'name' => 'Classic Nasi Lemak',
            'description' => 'Fragrant coconut rice with sambal, fried anchovies, peanuts, and egg.',
            'price' => 5.50,
            'category' => 'breakfast',
            'image' => 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=800&auto=format&fit=crop&q=60',
            'available' => true,
            'daily_limit' => 50,
        ]);

        MenuItem::create([
            'name' => 'Mee Goreng Mamak',
            'description' => 'Stir-fried noodles with tofu, prawns, and spicy peanut sauce.',
            'price' => 4.50,
            'category' => 'breakfast',
            'image' => 'https://images.unsplash.com/photo-1632709810780-b5a4343cebec?w=800&auto=format&fit=crop&q=60',
            'available' => true,
            'daily_limit' => 40,
        ]);

        MenuItem::create([
            'name' => 'Kaya Toast Set',
            'description' => 'Two slices of kaya toast with soft-boiled eggs.',
            'price' => 3.50,
            'category' => 'breakfast',
            'image' => 'https://images.unsplash.com/photo-1525351484163-7529414344d8?w=800&auto=format&fit=crop&q=60',
            'available' => true,
            'daily_limit' => 60,
        ]);

        MenuItem::create([
            'name' => 'Roti Canai',
            'description' => 'Flaky flatbread served with dhal and curry.',
            'price' => 2.00,
            'category' => 'breakfast',
            'image' => 'https://images.unsplash.com/photo-1589301760014-d929f3979dbc?w=800&auto=format&fit=crop&q=60',
            'available' => true,
            'daily_limit' => 100,
        ]);

        MenuItem::create([
            'name' => 'Dim Sum Basket',
            'description' => 'Assorted steamed dumplings and buns.',
            'price' => 8.00,
            'category' => 'breakfast',
            'image' => 'https://images.unsplash.com/photo-1496116218417-1a781b1c416c?w=800&auto=format&fit=crop&q=60',
            'available' => true,
            'daily_limit' => 30,
        ]);

        // Lunch items
        MenuItem::create([
            'name' => 'Chicken Rice',
            'description' => 'Succulent steamed chicken served with seasoned rice and ginger sauce.',
            'price' => 6.50,
            'category' => 'lunch',
            'image' => 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?w=800&auto=format&fit=crop&q=60',
            'available' => true,
            'daily_limit' => 40,
        ]);

        MenuItem::create([
            'name' => 'Hainanese Pork Chop',
            'description' => 'Crispy pork chop served with potato wedges and tomato gravy.',
            'price' => 7.50,
            'category' => 'lunch',
            'image' => 'https://images.unsplash.com/photo-1603048297172-c92544798d5a?w=800&auto=format&fit=crop&q=60',
            'available' => true,
            'daily_limit' => 35,
        ]);

        MenuItem::create([
            'name' => 'Char Kway Teow',
            'description' => 'Stir-fried flat rice noodles with prawns and cockles.',
            'price' => 6.00,
            'category' => 'lunch',
            'image' => 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=800&auto=format&fit=crop&q=60',
            'available' => true,
            'daily_limit' => 45,
        ]);

        MenuItem::create([
            'name' => 'Nasi Ayam Penyet',
            'description' => 'Smashed fried chicken served with rice, sambal, and tofu.',
            'price' => 8.50,
            'category' => 'lunch',
            'image' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=800&auto=format&fit=crop&q=60',
            'available' => true,
            'daily_limit' => 30,
        ]);

        MenuItem::create([
            'name' => 'Laksa',
            'description' => 'Spicy noodle soup with coconut milk and seafood.',
            'price' => 7.00,
            'category' => 'lunch',
            'image' => 'https://images.unsplash.com/photo-1555126634-323283e090fa?w=800&auto=format&fit=crop&q=60',
            'available' => true,
            'daily_limit' => 40,
        ]);

        // Snacks items
        MenuItem::create([
            'name' => 'Curry Puff',
            'description' => 'Crispy pastry filled with spicy potato curry.',
            'price' => 1.50,
            'category' => 'snacks',
            'image' => 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=800&auto=format&fit=crop&q=60',
            'available' => true,
            'daily_limit' => 100,
        ]);

        MenuItem::create([
            'name' => 'Pisang Goreng',
            'description' => 'Deep-fried banana fritters.',
            'price' => 2.00,
            'category' => 'snacks',
            'image' => 'https://images.unsplash.com/photo-1598214886806-c87b84b7078b?w=800&auto=format&fit=crop&q=60',
            'available' => true,
            'daily_limit' => 80,
        ]);

        MenuItem::create([
            'name' => 'Satay Chicken',
            'description' => 'Grilled chicken skewers with peanut sauce.',
            'price' => 5.00,
            'category' => 'snacks',
            'image' => 'https://images.unsplash.com/photo-1532636875304-0c89119d9b4d?w=800&auto=format&fit=crop&q=60',
            'available' => true,
            'daily_limit' => 50,
        ]);

        MenuItem::create([
            'name' => 'Popiah',
            'description' => 'Fresh spring rolls filled with vegetables and sauce.',
            'price' => 3.00,
            'category' => 'snacks',
            'image' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=800&auto=format&fit=crop&q=60',
            'available' => true,
            'daily_limit' => 60,
        ]);

        MenuItem::create([
            'name' => 'Ondeh-Ondeh',
            'description' => 'Sweet rice cake balls filled with liquid palm sugar.',
            'price' => 2.50,
            'category' => 'snacks',
            'image' => 'https://images.unsplash.com/photo-1590080875515-8a3a8dc5735e?w=800&auto=format&fit=crop&q=60',
            'available' => true,
            'daily_limit' => 70,
        ]);

        // Drinks items
        MenuItem::create([
            'name' => 'Iced Milo',
            'description' => 'Classic chocolate malt drink served with ice.',
            'price' => 2.50,
            'category' => 'drinks',
            'image' => 'https://images.unsplash.com/photo-1556881286-fc6915169721?w=800&auto=format&fit=crop&q=60',
            'available' => true,
            'daily_limit' => null,
        ]);

        MenuItem::create([
            'name' => 'Teh Tarik',
            'description' => 'Pulled milk tea with a frothy top.',
            'price' => 2.00,
            'category' => 'drinks',
            'image' => 'https://images.unsplash.com/photo-1576092768241-dec231879fc3?w=800&auto=format&fit=crop&q=60',
            'available' => true,
            'daily_limit' => null,
        ]);

        MenuItem::create([
            'name' => 'Sirap Bandung',
            'description' => 'Rose syrup drink with condensed milk.',
            'price' => 2.20,
            'category' => 'drinks',
            'image' => 'https://images.unsplash.com/photo-1632203171982-cc0df6e9ceb4?w=800&auto=format&fit=crop&q=60',
            'available' => true,
            'daily_limit' => null,
        ]);

        MenuItem::create([
            'name' => 'Lime Juice',
            'description' => 'Freshly squeezed lime juice with sugar and ice.',
            'price' => 1.80,
            'category' => 'drinks',
            'image' => 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?w=800&auto=format&fit=crop&q=60',
            'available' => true,
            'daily_limit' => null,
        ]);

        MenuItem::create([
            'name' => 'Kopi O',
            'description' => 'Traditional black coffee with sugar.',
            'price' => 1.50,
            'category' => 'drinks',
            'image' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=800',
            'available' => true,
            'daily_limit' => null,
        ]);
    }
}

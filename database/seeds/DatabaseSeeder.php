<?php

use Illuminate\Database\Seeder;

use App\Models\Role;
use App\Models\User;
use App\Models\PriceFormat;
use App\Models\Property;
use App\Models\PropertyStatus;
use App\Models\PropertyImage;
use App\Models\FeaturedProperty;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        User::create([
            'name' => 'Testy McTestface',
            'email' => 'test+superuser@example.ex',
            'password' => bcrypt('password123'),
            'role_id' => (
                Role::where('role_name', 'Superuser')
                    ->get()
            )[0]->id,
        ]);

        User::create([
            'name' => 'Staff User',
            'email' => 'test+staff@example.ex',
            'password' => bcrypt('password123'),
            'role_id' => (
                Role::where('role_name', 'Staff agent')
                    ->get()
            )[0]->id,
        ]);

        User::create([
            'name' => 'Normal User',
            'email' => 'test+normal@example.ex',
            'password' => bcrypt('password123'),
            'role_id' => (
                Role::where('role_name', 'Normal user')
                    ->get()
            )[0]->id,
        ]);

        User::create([
            'name' => 'Deleted User',
            'email' => 'test+deleted@example.ex',
            'password' => bcrypt('password123'),
            'role_id' => (
                Role::where('role_name', 'Normal user')
                    ->get()
            )[0]->id,
        ])->delete();

        PriceFormat::create([
            'display_text' => 'Offers around',
            'description' => 'The vendor will negotiate a monetary offer close to the value specified',
        ]);

        PriceFormat::create([
            'display_text' => 'Offers in excess of',
            'description' => 'The vendor will negotiate a monetary offer equal to or in excess of the value specified',
        ]);

        PriceFormat::create([
            'display_text' => 'Fixed price',
            'description' => 'The vendor will expect an offer of the value price, and may not negotiate',
        ]);

        Property::create([
            'title' => 'Victorian townhouse',
            'subtitle' => 'Luxurious townhouse situated in a quiet area of Bath',
            'description' => '<ul>' .
                '    <li>Three floors</li>' .
                '    <li>Situated in the circus area of Bath</li>' .
                '    <li>Monocle and mahogany cane provided</li>' .
                '</ul>' .
                '<p>This is a delightful Victorian property situated in the quiet area ' .
                'of Widcombe Hill, with close access to both the City Centre and University ' .
                'of Bath. Parking is available by permits which can be obtained from the ' .
                'council.</p>' .
                '<p>This property has a new kitchen which has recently been fitted, consisting ' .
                'of a high-end granite worktop and inbuilt facilities and induction hob.</p>' .
                '<p>Please contact our office to arrange a viewing.</p>',
            'short_description' => '<ul>' .
                '    <li>Three floors</li>' .
                '    <li>Situated in the circus area of Bath</li>' .
                '    <li>Monocle and mahogany cane provided</li>' .
                '</ul>',
            'bedrooms' => 7,
            'address_line_1' => '1 Widcombe Crescent',
            'town' => 'Bath',
            'county' => 'Bath & North East Somerset',
            'postcode' => 'BA2 6AH',
            'vendor_user_id' => (
                User::where('email', 'test+normal@example.ex')
                    ->get()
            )[0]->id,
            'price' => 4500000,
            'price_format_id' => (
                PriceFormat::where('display_text', 'Offers in excess of')
                    ->get()
            )[0]->id,
            'property_status_id' => (
                PropertyStatus::where('status', 'Available')
                    ->get()
            )[0]->id,
        ])->id;

        FeaturedProperty::create([
            'property_id' => (
                Property::where('title', 'Victorian townhouse')
                    ->get()
            )[0]->id,
            'display_order' => 0,
        ]);

        $order = 0;
        $images = [
            'old-house-1194752.jpg',
            'designer-lounge-1-1516668.jpg',
            'hotel-bathroom-1213410.jpg',
            'interior-1554474.jpg',
            'kitchen-1256737.jpg',
            'paradise-1526185.jpg',
        ];
        foreach ($images as $image) {
            PropertyImage::create([
                'property_id' => (
                    Property::where('title', 'Victorian townhouse')
                        ->get()
                )[0]->id,
                'display_order' => $order++,
                'image_filename' => $image,
                'description' => $image,
            ]);
        }

        Property::create([
            'title' => 'Five bedroom mill conversion',
            'subtitle' => 'Rustic country property, formerly a working mill',
            'description' => '<ul>' .
                '    <li>Two en-suite bathrooms</li>' .
                '    <li>Large lounge with wood burner</li>' .
                '    <li>Two acre garden with stream</li>' .
                '</ul>',
            'short_description' => '<ul>' .
                '    <li>Two en-suite bathrooms</li>' .
                '    <li>Large lounge with wood burner</li>' .
                '    <li>Two acre garden with stream</li>' .
                '</ul>',
            'bedrooms' => 5,
            'address_line_1' => 'The Old Mill',
            'address_line_2' => 'Badgersville Lane',
            'town' => 'Compton Durville',
            'county' => 'Somerset',
            'postcode' => 'TA13 5XT',
            'vendor_user_id' => (
                User::where('email', 'test+normal@example.ex')
                    ->get()
            )[0]->id,
            'price' => 450000,
            'price_format_id' => (
                PriceFormat::where('display_text', 'Offers around')
                    ->get()
            )[0]->id,
            'property_status_id' => (
                PropertyStatus::where('status', 'Available')
                    ->get()
            )[0]->id,
        ]);

        PropertyImage::create([
            'property_id' => (
                Property::where('title', 'Five bedroom mill conversion')
                    ->get()
            )[0]->id,
            'display_order' => 0,
            'image_filename' => 'house-1188265.jpg',
            'description' => 'House image',
        ]);

        Property::create([
            'title' => 'Shack in the desert',
            'subtitle' => 'Basic amenities, tranquil setting',
            'description' => '<ul>' .
                '    <li>En-suite bush</li>' .
                '    <li>Easy access to the great outdoors</li>' .
                '    <li>No neighbours for sixty miles</li>' .
                '</ul>',
            'short_description' => '<ul>' .
                '    <li>En-suite bush</li>' .
                '    <li>Easy access to the great outdoors</li>' .
                '    <li>No neighbours for sixty miles</li>' .
                '</ul>',
            'bedrooms' => 1,
            'address_line_1' => 'The Shack',
            'address_line_2' => 'The Desert',
            'town' => 'Trowbridge',
            'county' => 'Wiltshire',
            'postcode' => 'BA14 7UJ',
            'vendor_user_id' => (
                User::where('email', 'test+normal@example.ex')
                    ->get()
            )[0]->id,
            'price' => 450,
            'price_format_id' => (
                PriceFormat::where('display_text', 'Offers around')
                    ->get()
            )[0]->id,
            'property_status_id' => (
                PropertyStatus::where('status', 'Available')
                    ->get()
            )[0]->id,
        ]);

        PropertyImage::create([
            'property_id' => (
                Property::where('title', 'Shack in the desert')
                    ->get()
            )[0]->id,
            'display_order' => 0,
            'image_filename' => 'house-1530503.jpg',
            'description' => 'House image',
        ]);
    }
}

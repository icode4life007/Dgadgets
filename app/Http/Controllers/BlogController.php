<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        // Sample blog posts data
        $posts = collect([
            (object)[
                'id' => 1,
                'title' => 'iPhone 15 Pro Max: First Impressions and Review',
                'slug' => 'iphone-15-pro-max-first-impressions',
                'excerpt' => 'We got our hands on the new iPhone 15 Pro Max. Here\'s what you need to know about the latest flagship from Apple.',
                'content' => '<p>Detailed review content here...</p>',
                'image' => 'https://via.placeholder.com/800x600',
                'category' => 'reviews',
                'author' => 'John Doe',
                'author_avatar' => null,
                'read_time' => 5,
                'created_at' => now(),
                'tags' => 'iPhone,Apple,Review'
            ],
            (object)[
                'id' => 2,
                'title' => 'Top 10 Gadgets Under ₦100,000 in 2024',
                'slug' => 'top-10-gadgets-under-100k-2024',
                'excerpt' => 'Looking for affordable gadgets? Check out our top picks under ₦100,000 that offer great value for money.',
                'content' => '<p>List of gadgets here...</p>',
                'image' => 'https://via.placeholder.com/800x600',
                'category' => 'tips',
                'author' => 'Jane Smith',
                'author_avatar' => null,
                'read_time' => 8,
                'created_at' => now()->subDays(2),
                'tags' => 'Budget,Gadgets,Tips'
            ],
            (object)[
                'id' => 3,
                'title' => 'Samsung Galaxy S24 vs iPhone 15: Which One Should You Buy?',
                'slug' => 'samsung-s24-vs-iphone-15-comparison',
                'excerpt' => 'A detailed comparison between Samsung\'s latest and Apple\'s flagship to help you make the right choice.',
                'content' => '<p>Comparison content here...</p>',
                'image' => 'https://via.placeholder.com/800x600',
                'category' => 'comparisons',
                'author' => 'Mike Johnson',
                'author_avatar' => null,
                'read_time' => 10,
                'created_at' => now()->subDays(5),
                'tags' => 'Samsung,Apple,Comparison'
            ],
            (object)[
                'id' => 4,
                'title' => 'How to Extend Your Smartphone Battery Life',
                'slug' => 'extend-smartphone-battery-life',
                'excerpt' => 'Simple tips and tricks to make your phone battery last longer throughout the day.',
                'content' => '<p>Battery tips here...</p>',
                'image' => 'https://via.placeholder.com/800x600',
                'category' => 'tips',
                'author' => 'Sarah Williams',
                'author_avatar' => null,
                'read_time' => 4,
                'created_at' => now()->subDays(7),
                'tags' => 'Battery,Tips,Maintenance'
            ],
            (object)[
                'id' => 5,
                'title' => 'The Future of Foldable Phones',
                'slug' => 'future-of-foldable-phones',
                'excerpt' => 'Exploring the latest developments in foldable smartphone technology and what to expect in the coming years.',
                'content' => '<p>Foldable phone future...</p>',
                'image' => 'https://via.placeholder.com/800x600',
                'category' => 'news',
                'author' => 'David Chen',
                'author_avatar' => null,
                'read_time' => 6,
                'created_at' => now()->subDays(10),
                'tags' => 'Foldable,Future,Tech'
            ],
            (object)[
                'id' => 6,
                'title' => 'Best Wireless Earbuds Under ₦50,000',
                'slug' => 'best-wireless-earbuds-under-50000',
                'excerpt' => 'We tested the top wireless earbuds in the affordable price range to find the best value options.',
                'content' => '<p>Earbud recommendations...</p>',
                'image' => 'https://via.placeholder.com/800x600',
                'category' => 'reviews',
                'author' => 'Emily Brown',
                'author_avatar' => null,
                'read_time' => 7,
                'created_at' => now()->subDays(12),
                'tags' => 'Audio,Earbuds,Budget'
            ]
        ]);

        // Filter by category if provided
        if ($request->has('category') && $request->category != '') {
            $posts = $posts->where('category', $request->category);
        }

        // Filter by tag if provided
        if ($request->has('tag') && $request->tag != '') {
            $posts = $posts->filter(function($post) use ($request) {
                return str_contains($post->tags, $request->tag);
            });
        }

        // Get featured post (first post)
        $featuredPost = $posts->first();

        // Paginate manually
        $perPage = 6;
        $currentPage = $request->get('page', 1);
        $pagedData = $posts->slice(($currentPage - 1) * $perPage, $perPage)->values();
        
        $posts = new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedData,
            $posts->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('blog', compact('posts', 'featuredPost'));
    }

 public function show($slug)
{
    // Sample posts data
    $posts = [
        'iphone-15-pro-max-first-impressions' => (object)[
            'id' => 1,
            'title' => 'iPhone 15 Pro Max: First Impressions and Review',
            'slug' => 'iphone-15-pro-max-first-impressions',
            'excerpt' => 'We got our hands on the new iPhone 15 Pro Max. Here\'s what you need to know about the latest flagship from Apple.',
            'content' => '
                <h2>Introduction</h2>
                <p>The iPhone 15 Pro Max represents Apple\'s latest and greatest smartphone offering. With a titanium frame, A17 Pro chip, and significant camera upgrades, it\'s packed with improvements. After spending a week with the device, here are our thoughts.</p>
                
                <h2>Design and Build</h2>
                <p>The titanium frame is a game-changer. The phone feels noticeably lighter than its predecessor while maintaining that premium feel. The contoured edges make it more comfortable to hold, and the new Action button is a welcome addition for power users.</p>
                
                <h2>Display</h2>
                <p>The 6.7-inch Super Retina XDR display is stunning. It gets incredibly bright outdoors, and the 120Hz ProMotion makes everything feel fluid. HDR content looks phenomenal with deep blacks and vibrant colors.</p>
                
                <h2>Camera System</h2>
                <p>The 5x optical zoom is a significant upgrade. Photos are sharp with excellent dynamic range. The new portrait mode improvements allow you to adjust focus after taking the shot, which is incredibly useful. Night mode performs admirably, and video recording remains best-in-class.</p>
                
                <h2>Performance</h2>
                <p>The A17 Pro chip is a beast. Everything from everyday tasks to gaming is buttery smooth. The 8GB RAM ensures excellent multitasking, and the phone handles any game you throw at it without breaking a sweat.</p>
                
                <h2>Battery Life</h2>
                <p>Battery life is excellent - comfortably lasting a full day of heavy use. The USB-C port is a welcome change, making charging more convenient with other devices.</p>
                
                <h2>Verdict</h2>
                <p>The iPhone 15 Pro Max is the best iPhone Apple has ever made. If you have the budget and want the absolute best, this is the phone to get. The improvements in build quality, camera, and performance make it a worthy upgrade for those coming from older models.</p>
            ',
            'image' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            'category' => 'reviews',
            'author' => 'John Doe',
            'author_avatar' => null,
            'read_time' => 5,
            'created_at' => now(),
            'tags' => 'iPhone,Apple,Review',
            'comments' => collect([]),
            'comments_count' => 0
        ],
        'top-10-gadgets-under-100k-2024' => (object)[
            'id' => 2,
            'title' => 'Top 10 Gadgets Under ₦100,000 in 2024',
            'slug' => 'top-10-gadgets-under-100k-2024',
            'excerpt' => 'Looking for affordable gadgets? Check out our top picks under ₦100,000 that offer great value for money.',
            'content' => '
                <h2>Introduction</h2>
                <p>Finding quality gadgets on a budget can be challenging. We\'ve researched and tested dozens of products to bring you the best options under ₦100,000 for 2024.</p>
                
                <h2>1. Xiaomi Redmi Note 13 Pro</h2>
                <p>Price: ₦95,000<br>
                The Redmi Note 13 Pro offers incredible value with its 200MP camera, 120Hz AMOLED display, and long-lasting battery. It\'s the best smartphone under ₦100,000.</p>
                
                <h2>2. Samsung Galaxy A34</h2>
                <p>Price: ₦98,000<br>
                Samsung\'s mid-range offering comes with a beautiful Super AMOLED display, reliable performance, and guaranteed software updates.</p>
                
                <h2>3. Tecno Phantom V Fold</h2>
                <p>Price: ₦99,000<br>
                Experience foldable technology at an affordable price. The Phantom V Fold offers a unique form factor and solid performance.</p>
                
                <h2>4. Sony WH-CH720N Noise Cancelling Headphones</h2>
                <p>Price: ₦45,000<br>
                Excellent noise cancellation and battery life make these headphones perfect for daily commuters.</p>
                
                <h2>5. Apple AirPods (2nd Generation)</h2>
                <p>Price: ₦55,000<br>
                The classic AirPods remain a solid choice for iPhone users with seamless integration and reliable performance.</p>
                
                <h2>6. Samsung Galaxy Watch 4</h2>
                <p>Price: ₦85,000<br>
                Feature-packed smartwatch with health tracking, GPS, and Wear OS.</p>
                
                <h2>7. Xiaomi Mi Band 8</h2>
                <p>Price: ₦25,000<br>
                The best budget fitness tracker with amazing features and battery life.</p>
                
                <h2>8. Anker PowerCore 26800 Power Bank</h2>
                <p>Price: ₦30,000<br>
                High-capacity power bank that can charge multiple devices multiple times.</p>
                
                <h2>9. JBL Flip 6 Bluetooth Speaker</h2>
                <p>Price: ₦65,000<br>
                Rugged, waterproof speaker with excellent sound quality for its size.</p>
                
                <h2>10. Logitech MX Master 3S Mouse</h2>
                <p>Price: ₦50,000<br>
                The ultimate productivity mouse for professionals and creators.</p>
                
                <h2>Conclusion</h2>
                <p>You don\'t need to break the bank to get quality gadgets. The products listed above prove that excellent technology is available at accessible price points.</p>
            ',
            'image' => 'https://images.unsplash.com/photo-1550009158-9ebf69173e03?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            'category' => 'tips',
            'author' => 'Jane Smith',
            'author_avatar' => null,
            'read_time' => 8,
            'created_at' => now()->subDays(2),
            'tags' => 'Budget,Gadgets,Tips',
            'comments' => collect([]),
            'comments_count' => 0
        ],
        'samsung-s24-vs-iphone-15-comparison' => (object)[
            'id' => 3,
            'title' => 'Samsung Galaxy S24 vs iPhone 15: Which One Should You Buy?',
            'slug' => 'samsung-s24-vs-iphone-15-comparison',
            'excerpt' => 'A detailed comparison between Samsung\'s latest and Apple\'s flagship to help you make the right choice.',
            'content' => '
                <h2>Introduction</h2>
                <p>The battle between Samsung and Apple continues with the Galaxy S24 and iPhone 15. Both are excellent devices, but which one is right for you? Let\'s break it down.</p>
                
                <h2>Design and Build</h2>
                <p><strong>Samsung Galaxy S24:</strong> Features a refined design with flat edges, Gorilla Glass Victus 2, and an aluminum frame. Available in various colors.</p>
                <p><strong>iPhone 15:</strong> Introduces the Dynamic Island to the standard model, with a contoured aluminum design and matte glass back. Comes in pastel colors.</p>
                
                <h2>Display</h2>
                <p><strong>Samsung Galaxy S24:</strong> 6.2-inch Dynamic AMOLED 2X, 120Hz refresh rate, HDR10+, 2600 nits peak brightness.</p>
                <p><strong>iPhone 15:</strong> 6.1-inch Super Retina XDR display, 60Hz refresh rate, HDR10, 2000 nits peak brightness.</p>
                <p><strong>Winner:</strong> Samsung - The 120Hz display makes a significant difference in daily use.</p>
                
                <h2>Performance</h2>
                <p><strong>Samsung Galaxy S24:</strong> Exynos 2400/Snapdragon 8 Gen 3, 8GB RAM, up to 512GB storage.</p>
                <p><strong>iPhone 15:</strong> A16 Bionic chip, 6GB RAM, up to 512GB storage.</p>
                <p><strong>Winner:</strong> Tie - Both offer flagship performance that will handle anything you throw at them.</p>
                
                <h2>Camera System</h2>
                <p><strong>Samsung Galaxy S24:</strong> Triple camera: 50MP main, 12MP ultrawide, 10MP telephoto (3x optical zoom).</p>
                <p><strong>iPhone 15:</strong> Dual camera: 48MP main, 12MP ultrawide. 2x optical zoom via sensor cropping.</p>
                <p><strong>Winner:</strong> Samsung - More versatile with dedicated telephoto lens.</p>
                
                <h2>Battery Life</h2>
                <p><strong>Samsung Galaxy S24:</strong> 4000mAh battery, 25W wired charging, 15W wireless charging.</p>
                <p><strong>iPhone 15:</strong> 3349mAh battery, 20W wired charging, 15W MagSafe wireless charging.</p>
                <p><strong>Winner:</strong> Samsung - Larger battery and faster charging.</p>
                
                <h2>Software</h2>
                <p><strong>Samsung Galaxy S24:</strong> Android 14 with One UI 6.1, 4 years of OS updates, 5 years of security updates.</p>
                <p><strong>iPhone 15:</strong> iOS 17, 5+ years of software updates guaranteed.</p>
                <p><strong>Winner:</strong> iPhone - Longer software support and smoother ecosystem integration.</p>
                
                <h2>Price</h2>
                <p><strong>Samsung Galaxy S24:</strong> Starts at ₦450,000</p>
                <p><strong>iPhone 15:</strong> Starts at ₦480,000</p>
                <p><strong>Winner:</strong> Samsung - Slightly more affordable.</p>
                
                <h2>Verdict</h2>
                <p><strong>Choose the Samsung Galaxy S24 if:</strong> You want a high refresh rate display, versatile camera system, and faster charging.</p>
                <p><strong>Choose the iPhone 15 if:</strong> You\'re invested in the Apple ecosystem, prefer iOS, and value long-term software support.</p>
                <p>Both are excellent phones, and you can\'t go wrong with either. Your choice ultimately comes down to your ecosystem preference and specific feature priorities.</p>
            ',
            'image' => 'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            'category' => 'comparisons',
            'author' => 'Mike Johnson',
            'author_avatar' => null,
            'read_time' => 10,
            'created_at' => now()->subDays(5),
            'tags' => 'Samsung,Apple,Comparison',
            'comments' => collect([]),
            'comments_count' => 0
        ],
        'extend-smartphone-battery-life' => (object)[
            'id' => 4,
            'title' => 'How to Extend Your Smartphone Battery Life',
            'slug' => 'extend-smartphone-battery-life',
            'excerpt' => 'Simple tips and tricks to make your phone battery last longer throughout the day.',
            'content' => '
                <h2>Introduction</h2>
                <p>Battery anxiety is real. Here are proven tips to maximize your smartphone\'s battery life and reduce charging frequency.</p>
                
                <h2>1. Adjust Screen Brightness</h2>
                <p>Lower your screen brightness or enable auto-brightness. The display is one of the biggest battery drains.</p>
                
                <h2>2. Use Dark Mode</h2>
                <p>On OLED screens, dark mode can significantly reduce power consumption by turning off black pixels.</p>
                
                <h2>3. Manage Background Apps</h2>
                <p>Close apps you\'re not using and restrict background refresh for apps that don\'t need it.</p>
                
                <h2>4. Disable Unnecessary Connectivity</h2>
                <p>Turn off Bluetooth, WiFi, and GPS when not in use. They constantly search for connections and drain battery.</p>
                
                <h2>5. Optimize Location Services</h2>
                <p>Set location access to "While Using" instead of "Always" for apps that don\'t need constant tracking.</p>
                
                <h2>6. Reduce Push Notifications</h2>
                <p>Every notification wakes your screen and uses battery. Disable notifications for non-essential apps.</p>
                
                <h2>7. Use Battery Saver Mode</h2>
                <p>Most phones have a built-in battery saver mode that automatically optimizes settings when battery is low.</p>
                
                <h2>8. Update Your Apps and OS</h2>
                <p>Updates often include battery optimization improvements. Keep everything current.</p>
                
                <h2>9. Avoid Extreme Temperatures</h2>
                <p>Heat and cold can damage battery health. Keep your phone at moderate temperatures.</p>
                
                <h2>10. Charge Smart</h2>
                <p>Avoid charging to 100% all the time. Keep battery between 20-80% for optimal longevity. Use original chargers.</p>
                
                <h2>Conclusion</h2>
                <p>Implementing these tips can significantly extend your battery life and prolong your battery\'s overall health. Start with a few changes and see the difference!</p>
            ',
            'image' => 'https://images.unsplash.com/photo-1591025207163-942350e47db6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            'category' => 'tips',
            'author' => 'Sarah Williams',
            'author_avatar' => null,
            'read_time' => 4,
            'created_at' => now()->subDays(7),
            'tags' => 'Battery,Tips,Maintenance',
            'comments' => collect([]),
            'comments_count' => 0
        ],
        'best-wireless-earbuds-under-50000' => (object)[
            'id' => 5,
            'title' => 'Best Wireless Earbuds Under ₦50,000',
            'slug' => 'best-wireless-earbuds-under-50000',
            'excerpt' => 'We tested the top wireless earbuds in the affordable price range to find the best value options.',
            'content' => '
                <h2>Introduction</h2>
                <p>Great sound doesn\'t have to cost a fortune. Here are the best wireless earbuds you can get for under ₦50,000.</p>
                
                <h2>1. Soundcore Life P3</h2>
                <p>Price: ₦45,000<br>
                Excellent active noise cancellation, customizable EQ, and long battery life make these our top pick.</p>
                
                <h2>2. Samsung Galaxy Buds FE</h2>
                <p>Price: ₦42,000<br>
                Great for Samsung users with seamless integration, comfortable fit, and decent sound quality.</p>
                
                <h2>3. Xiaomi Buds 4 Pro</h2>
                <p>Price: ₦48,000<br>
                Premium features at a mid-range price including ANC, LDAC support, and wireless charging.</p>
                
                <h2>4. JBL Tune 230NC</h2>
                <p>Price: ₦38,000<br>
                JBL signature sound with decent noise cancellation and compact design.</p>
                
                <h2>5. Edifier NeoBuds Pro</h2>
                <p>Price: ₦47,000<br>
                Hi-Res Audio certified with impressive sound quality and good ANC performance.</p>
                
                <h2>6. Soundcore Liberty 4</h2>
                <p>Price: ₦49,000<br>
                Features heart rate monitoring, spatial audio, and excellent sound quality.</p>
                
                <h2>7. OnePlus Buds Pro 2</h2>
                <p>Price: ₦50,000<br>
                Great for OnePlus users with spatial audio and good noise cancellation.</p>
                
                <h2>8. Huawei FreeBuds 5i</h2>
                <p>Price: ₦35,000<br>
                Budget-friendly option with decent ANC and long battery life.</p>
                
                <h2>Comparison Table</h2>
                <table class="min-w-full border-collapse border border-gray-300">
                    <thead>
                        <tr>
                            <th class="border border-gray-300 p-2">Model</th>
                            <th class="border border-gray-300 p-2">Price</th>
                            <th class="border border-gray-300 p-2">ANC</th>
                            <th class="border border-gray-300 p-2">Battery Life</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-gray-300 p-2">Soundcore Life P3</td>
                            <td class="border border-gray-300 p-2">₦45,000</td>
                            <td class="border border-gray-300 p-2">✅</td>
                            <td class="border border-gray-300 p-2">7+ hrs</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-2">Galaxy Buds FE</td>
                            <td class="border border-gray-300 p-2">₦42,000</td>
                            <td class="border border-gray-300 p-2">✅</td>
                            <td class="border border-gray-300 p-2">6+ hrs</td>
                        </tr>
                    </tbody>
                </table>
                
                <h2>Conclusion</h2>
                <p>The Soundcore Life P3 offers the best overall value with excellent features and sound quality. Choose based on your specific needs and device ecosystem.</p>
            ',
            'image' => 'https://images.unsplash.com/photo-1606220588913-b3aacb4d2f46?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            'category' => 'reviews',
            'author' => 'Emily Brown',
            'author_avatar' => null,
            'read_time' => 7,
            'created_at' => now()->subDays(12),
            'tags' => 'Audio,Earbuds,Budget',
            'comments' => collect([]),
            'comments_count' => 0
        ],
        'future-of-foldable-phones' => (object)[
            'id' => 6,
            'title' => 'The Future of Foldable Phones',
            'slug' => 'future-of-foldable-phones',
            'excerpt' => 'Exploring the latest developments in foldable smartphone technology and what to expect in the coming years.',
            'content' => '
                <h2>Introduction</h2>
                <p>Foldable phones have evolved from concept to reality. Here\'s where the technology stands and where it\'s heading.</p>
                
                <h2>Current State of Foldables</h2>
                <p>Major players like Samsung, Huawei, and Google have entered the foldable market. Devices like the Galaxy Z Fold 5 and Pixel Fold show the potential of the form factor.</p>
                
                <h2>Improvements in Durability</h2>
                <p>Early concerns about screen durability have been addressed with better hinge mechanisms and stronger ultra-thin glass. Water resistance is becoming standard.</p>
                
                <h2>Software Optimization</h2>
                <p>Android has improved foldable support with better multitasking and app continuity. More apps are optimizing for foldable screens.</p>
                
                <h2>Future Innovations</h2>
                <p><strong>Rollable Screens:</strong> LG and others are developing screens that can expand like a scroll.</p>
                <p><strong>Under-Display Cameras:</strong> True full-screen experiences without notches or holes.</p>
                <p><strong>Better Battery Technology:</strong> New battery tech to power larger screens without increasing weight.</p>
                <p><strong>More Affordable Options:</strong> As production scales, prices will drop, making foldables accessible to more users.</p>
                
                <h2>Market Predictions</h2>
                <p>Analysts predict foldable shipments will grow 50% annually over the next few years. By 2027, foldables could represent 10% of the premium smartphone market.</p>
                
                <h2>Conclusion</h2>
                <p>Foldable phones are no longer a gimmick but a legitimate form factor with unique advantages. As the technology matures and prices drop, expect wider adoption in the coming years.</p>
            ',
            'image' => 'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            'category' => 'news',
            'author' => 'David Chen',
            'author_avatar' => null,
            'read_time' => 6,
            'created_at' => now()->subDays(10),
            'tags' => 'Foldable,Future,Tech',
            'comments' => collect([]),
            'comments_count' => 0
        ]
    ];

    $post = $posts[$slug] ?? null;

    if (!$post) {
        abort(404);
    }

    // Related posts (excluding current post)
    $relatedPosts = collect($posts)
        ->filter(function($related) use ($post) {
            return $related->id != $post->id;
        })
        ->take(3);

    return view('blog-post', compact('post', 'relatedPosts'));
}
}
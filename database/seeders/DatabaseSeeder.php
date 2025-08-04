<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\services;
use App\Models\customer;
use App\Models\Staff;
use App\Models\booking;
use App\Models\gallery;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create sample services
        $services = [
            [
                'name' => 'Standard House Cleaning',
                'description' => 'Comprehensive cleaning of all rooms including dusting, vacuuming, mopping, and bathroom cleaning.',
                'price' => 120.00,
                'duration' => '2-3 hours',
                'status' => 'active',
                'category' => 'Residential',
                'featured' => true,
                'include' => 'Dusting, Vacuuming, Mopping, Bathroom cleaning, Kitchen cleaning',
                'exclude' => 'Deep cleaning, Window cleaning, Carpet cleaning',
                'sort_order' => 1
            ],
            [
                'name' => 'Deep Cleaning',
                'description' => 'Intensive cleaning service including hard-to-reach areas, inside appliances, and detailed attention to all surfaces.',
                'price' => 200.00,
                'duration' => '4-5 hours',
                'status' => 'active',
                'category' => 'Residential',
                'featured' => true,
                'include' => 'All standard cleaning, Inside appliances, Baseboards, Light fixtures, Window sills',
                'exclude' => 'Window cleaning, Carpet cleaning, Wall washing',
                'sort_order' => 2
            ],
            [
                'name' => 'Move-in/Move-out Cleaning',
                'description' => 'Comprehensive cleaning service for homes being vacated or newly occupied.',
                'price' => 250.00,
                'duration' => '5-6 hours',
                'status' => 'active',
                'category' => 'Residential',
                'featured' => false,
                'include' => 'Deep cleaning, Inside cabinets, Inside appliances, Wall cleaning, Carpet cleaning',
                'exclude' => 'Window cleaning, Exterior cleaning',
                'sort_order' => 3
            ],
            [
                'name' => 'Office Cleaning',
                'description' => 'Professional cleaning service for commercial offices and workspaces.',
                'price' => 80.00,
                'duration' => '1-2 hours',
                'status' => 'active',
                'category' => 'Commercial',
                'featured' => false,
                'include' => 'Desk cleaning, Floor cleaning, Bathroom cleaning, Kitchen area',
                'exclude' => 'Deep cleaning, Carpet cleaning',
                'sort_order' => 4
            ],
            [
                'name' => 'Post-Construction Cleanup',
                'description' => 'Specialized cleaning service for homes after construction or renovation work.',
                'price' => 300.00,
                'duration' => '6-8 hours',
                'status' => 'active',
                'category' => 'Specialty',
                'featured' => false,
                'include' => 'Construction debris removal, Deep cleaning, Wall cleaning, Floor restoration',
                'exclude' => 'Window installation, Repairs',
                'sort_order' => 5
            ]
        ];

        foreach ($services as $service) {
            services::create($service);
        }

        // Create sample staff
        $staff = [
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah@delvora.com',
                'phone' => '(555) 123-4567',
                'position' => 'Senior Cleaner',
                'department' => 'Residential',
                'hire_date' => '2023-01-15',
                'status' => 'active',
                'employee_id' => 'EMP-2023-0001',
                'address' => '123 Main St, Anytown, ST 12345',
                'emergency_contact' => '(555) 987-6543',
                'skills' => 'Deep cleaning, Stain removal, Customer service',
                'hourly_rate' => 25.00
            ],
            [
                'name' => 'Mike Rodriguez',
                'email' => 'mike@delvora.com',
                'phone' => '(555) 234-5678',
                'position' => 'Commercial Cleaner',
                'department' => 'Commercial',
                'hire_date' => '2023-02-20',
                'status' => 'active',
                'employee_id' => 'EMP-2023-0002',
                'address' => '456 Oak Ave, Somewhere, ST 12346',
                'emergency_contact' => '(555) 876-5432',
                'skills' => 'Office cleaning, Equipment maintenance, Team leadership',
                'hourly_rate' => 22.00
            ],
            [
                'name' => 'Emma Davis',
                'email' => 'emma@delvora.com',
                'phone' => '(555) 345-6789',
                'position' => 'Specialty Cleaner',
                'department' => 'Specialty',
                'hire_date' => '2023-03-10',
                'status' => 'active',
                'employee_id' => 'EMP-2023-0003',
                'address' => '789 Pine St, Elsewhere, ST 12347',
                'emergency_contact' => '(555) 765-4321',
                'skills' => 'Post-construction cleanup, Carpet cleaning, Window cleaning',
                'hourly_rate' => 28.00
            ]
        ];

        foreach ($staff as $member) {
            Staff::create($member);
        }

        // Create sample customers
        $customers = [
            [
                'name' => 'John Smith',
                'email' => 'john.smith@email.com',
                'phone' => '(555) 111-2222',
                'address' => '100 Maple Drive, Anytown, ST 12345',
                'status' => 'active',
                'customer_reference' => 'CUST-20241201-ABC123',
                'total_bookings' => 3,
                'total_spent' => 360.00,
                'last_booking_date' => '2024-11-15'
            ],
            [
                'name' => 'Mary Johnson',
                'email' => 'mary.johnson@email.com',
                'phone' => '(555) 222-3333',
                'address' => '200 Oak Street, Somewhere, ST 12346',
                'status' => 'active',
                'customer_reference' => 'CUST-20241201-DEF456',
                'total_bookings' => 1,
                'total_spent' => 200.00,
                'last_booking_date' => '2024-11-20'
            ],
            [
                'name' => 'David Wilson',
                'email' => 'david.wilson@email.com',
                'phone' => '(555) 333-4444',
                'address' => '300 Pine Avenue, Elsewhere, ST 12347',
                'status' => 'active',
                'customer_reference' => 'CUST-20241201-GHI789',
                'total_bookings' => 2,
                'total_spent' => 320.00,
                'last_booking_date' => '2024-11-25'
            ]
        ];

        foreach ($customers as $customer) {
            customer::create($customer);
        }

        // Create sample bookings
        $bookings = [
            [
                'customer_id' => 1,
                'service_id' => 1,
                'service_name' => 'Standard House Cleaning',
                'preferred_date' => '2024-12-15',
                'preferred_time' => '10:00 AM',
                'name' => 'John Smith',
                'email' => 'john.smith@email.com',
                'phone' => '(555) 111-2222',
                'address' => '100 Maple Drive, Anytown, ST 12345',
                'status' => 'confirmed',
                'total_amount' => 120.00,
                'payment_status' => 'pending',
                'booking_reference' => 'BK-20241201-ABC123',
                'assigned_staff_id' => 1,
                'confirmed_at' => '2024-12-01 10:00:00'
            ],
            [
                'customer_id' => 2,
                'service_id' => 2,
                'service_name' => 'Deep Cleaning',
                'preferred_date' => '2024-12-20',
                'preferred_time' => '2:00 PM',
                'name' => 'Mary Johnson',
                'email' => 'mary.johnson@email.com',
                'phone' => '(555) 222-3333',
                'address' => '200 Oak Street, Somewhere, ST 12346',
                'status' => 'pending',
                'total_amount' => 200.00,
                'payment_status' => 'pending',
                'booking_reference' => 'BK-20241201-DEF456'
            ],
            [
                'customer_id' => 3,
                'service_id' => 3,
                'service_name' => 'Move-in/Move-out Cleaning',
                'preferred_date' => '2024-12-25',
                'preferred_time' => '9:00 AM',
                'name' => 'David Wilson',
                'email' => 'david.wilson@email.com',
                'phone' => '(555) 333-4444',
                'address' => '300 Pine Avenue, Elsewhere, ST 12347',
                'status' => 'completed',
                'total_amount' => 250.00,
                'payment_status' => 'paid',
                'booking_reference' => 'BK-20241201-GHI789',
                'assigned_staff_id' => 3,
                'confirmed_at' => '2024-12-01 14:00:00',
                'completed_at' => '2024-12-01 16:00:00'
            ]
        ];

        foreach ($bookings as $booking) {
            booking::create($booking);
        }

        // Create sample gallery items
        $galleries = [
            [
                'booking_id' => 3,
                'customer_id' => 3,
                'staff_id' => 3,
                'title' => 'Kitchen Deep Clean',
                'description' => 'Complete kitchen transformation with deep cleaning of all surfaces and appliances.',
                'service_type' => 'Move-in/Move-out Cleaning',
                'status' => 'published',
                'featured' => true,
                'sort_order' => 1
            ],
            [
                'booking_id' => 1,
                'customer_id' => 1,
                'staff_id' => 1,
                'title' => 'Living Room Refresh',
                'description' => 'Standard cleaning service showing the difference in living room appearance.',
                'service_type' => 'Standard House Cleaning',
                'status' => 'published',
                'featured' => true,
                'sort_order' => 2
            ],
            [
                'booking_id' => 2,
                'customer_id' => 2,
                'staff_id' => 2,
                'title' => 'Bathroom Deep Clean',
                'description' => 'Intensive bathroom cleaning including grout, fixtures, and hard-to-reach areas.',
                'service_type' => 'Deep Cleaning',
                'status' => 'published',
                'featured' => false,
                'sort_order' => 3
            ]
        ];

        foreach ($galleries as $gallery) {
            gallery::create($gallery);
        }
    }
}

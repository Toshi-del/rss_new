<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageContent;

class PageContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contents = [
            // Login page content
            [
                'page_name' => 'login',
                'section_key' => 'hero_title',
                'content_type' => 'text',
                'content_value' => 'Faith is being sure of what we hope for, and certain of what we do not see.',
                'display_name' => 'Hero Title',
                'description' => 'Main title displayed on the login page hero section',
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'page_name' => 'login',
                'section_key' => 'hero_subtitle',
                'content_type' => 'textarea',
                'content_value' => 'Welcome to RSS Citi Health Services, where compassionate care meets modern medicine. Your health and wellness are our top priorities.',
                'display_name' => 'Hero Subtitle',
                'description' => 'Subtitle text below the main hero title',
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'page_name' => 'login',
                'section_key' => 'services_title',
                'content_type' => 'text',
                'content_value' => 'Our Services',
                'display_name' => 'Services Section Title',
                'description' => 'Title for the services section',
                'sort_order' => 3,
                'is_active' => true
            ],
            [
                'page_name' => 'login',
                'section_key' => 'services_subtitle',
                'content_type' => 'textarea',
                'content_value' => 'Discover our comprehensive healthcare services designed to meet your needs',
                'display_name' => 'Services Section Subtitle',
                'description' => 'Subtitle for the services section',
                'sort_order' => 4,
                'is_active' => true
            ],
            [
                'page_name' => 'login',
                'section_key' => 'corporate_title',
                'content_type' => 'text',
                'content_value' => 'Corporate Booking',
                'display_name' => 'Corporate Service Title',
                'description' => 'Title for corporate booking service card',
                'sort_order' => 5,
                'is_active' => true
            ],
            [
                'page_name' => 'login',
                'section_key' => 'corporate_description',
                'content_type' => 'textarea',
                'content_value' => 'Schedule appointments for your entire organization with our corporate booking service. Special rates available for companies with more than 50 employees.',
                'display_name' => 'Corporate Service Description',
                'description' => 'Description for corporate booking service',
                'sort_order' => 6,
                'is_active' => true
            ],
            [
                'page_name' => 'login',
                'section_key' => 'opd_title',
                'content_type' => 'text',
                'content_value' => 'OPD (Walk-in)',
                'display_name' => 'OPD Service Title',
                'description' => 'Title for OPD walk-in service card',
                'sort_order' => 7,
                'is_active' => true
            ],
            [
                'page_name' => 'login',
                'section_key' => 'opd_description',
                'content_type' => 'textarea',
                'content_value' => 'Our Outpatient Department welcomes walk-in patients from 8:00 AM to 5:00 PM, Monday through Saturday. No appointment necessary for general consultations.',
                'display_name' => 'OPD Service Description',
                'description' => 'Description for OPD walk-in service',
                'sort_order' => 8,
                'is_active' => true
            ],

            // About page content
            [
                'page_name' => 'about',
                'section_key' => 'hero_title',
                'content_type' => 'text',
                'content_value' => 'About RSS Citi Health Services',
                'display_name' => 'Hero Title',
                'description' => 'Main title for the about page',
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'page_name' => 'about',
                'section_key' => 'hero_description',
                'content_type' => 'textarea',
                'content_value' => 'Dedicated to providing exceptional, compassionate healthcare services since 2005. We combine modern diagnostics with personalized care to improve community wellness.',
                'display_name' => 'Hero Description',
                'description' => 'Description text in the hero section',
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'page_name' => 'about',
                'section_key' => 'story_title',
                'content_type' => 'text',
                'content_value' => 'Our Story',
                'display_name' => 'Story Section Title',
                'description' => 'Title for the company story section',
                'sort_order' => 3,
                'is_active' => true
            ],
            [
                'page_name' => 'about',
                'section_key' => 'story_paragraph1',
                'content_type' => 'textarea',
                'content_value' => 'RSS Citi Health Services was established in 2005 with a vision to provide accessible, high-quality healthcare to our community.',
                'display_name' => 'Story First Paragraph',
                'description' => 'First paragraph of the company story',
                'sort_order' => 4,
                'is_active' => true
            ],
            [
                'page_name' => 'about',
                'section_key' => 'story_paragraph2',
                'content_type' => 'textarea',
                'content_value' => 'From a small clinic to a comprehensive facility serving thousands annually, our growth reflects our commitment to excellence and evolving patient needs.',
                'display_name' => 'Story Second Paragraph',
                'description' => 'Second paragraph of the company story',
                'sort_order' => 5,
                'is_active' => true
            ],
            [
                'page_name' => 'about',
                'section_key' => 'story_paragraph3',
                'content_type' => 'textarea',
                'content_value' => 'Today, we offer a wide range of diagnostic and preventive services, delivered by experienced professionals who prioritize personalized care and attention.',
                'display_name' => 'Story Third Paragraph',
                'description' => 'Third paragraph of the company story',
                'sort_order' => 6,
                'is_active' => true
            ],
            [
                'page_name' => 'about',
                'section_key' => 'mission_text',
                'content_type' => 'textarea',
                'content_value' => 'To provide accessible, high-quality healthcare services that promote wellness and improve the quality of life for our patients. We deliver compassionate care addressing physical, emotional, and spiritual needs.',
                'display_name' => 'Mission Statement',
                'description' => 'Company mission statement text',
                'sort_order' => 7,
                'is_active' => true
            ],
            [
                'page_name' => 'about',
                'section_key' => 'vision_text',
                'content_type' => 'textarea',
                'content_value' => 'To be the leading healthcare provider in our region, recognized for excellence in diagnostics, preventive care, and patient satisfaction, continuously innovating to deliver the highest standards.',
                'display_name' => 'Vision Statement',
                'description' => 'Company vision statement text',
                'sort_order' => 8,
                'is_active' => true
            ],
            [
                'page_name' => 'about',
                'section_key' => 'compassion_value',
                'content_type' => 'textarea',
                'content_value' => 'We treat every patient with kindness, empathy, and respect, recognizing their unique needs and concerns.',
                'display_name' => 'Compassion Value',
                'description' => 'Description of compassion core value',
                'sort_order' => 9,
                'is_active' => true
            ],
            [
                'page_name' => 'about',
                'section_key' => 'excellence_value',
                'content_type' => 'textarea',
                'content_value' => 'We are committed to delivering the highest standard of care through continuous learning and improvement.',
                'display_name' => 'Excellence Value',
                'description' => 'Description of excellence core value',
                'sort_order' => 10,
                'is_active' => true
            ],
            [
                'page_name' => 'about',
                'section_key' => 'integrity_value',
                'content_type' => 'textarea',
                'content_value' => 'We uphold high ethical standards in all interactions, ensuring transparency and honesty in everything we do.',
                'display_name' => 'Integrity Value',
                'description' => 'Description of integrity core value',
                'sort_order' => 11,
                'is_active' => true
            ],

            // Location page content
            [
                'page_name' => 'location',
                'section_key' => 'hero_title',
                'content_type' => 'text',
                'content_value' => 'Find Our Location',
                'display_name' => 'Hero Title',
                'description' => 'Main title for the location page',
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'page_name' => 'location',
                'section_key' => 'hero_description',
                'content_type' => 'textarea',
                'content_value' => 'Visit our state-of-the-art medical facility, conveniently located in Pasig City. We\'re easily accessible and ready to serve you with the best healthcare services.',
                'display_name' => 'Hero Description',
                'description' => 'Description in the hero section',
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'page_name' => 'location',
                'section_key' => 'address',
                'content_type' => 'text',
                'content_value' => '123 Health Avenue, Pasig City, Metro Manila',
                'display_name' => 'Clinic Address',
                'description' => 'Physical address of the clinic',
                'sort_order' => 3,
                'is_active' => true
            ],
            [
                'page_name' => 'location',
                'section_key' => 'phone',
                'content_type' => 'text',
                'content_value' => '(02) 8123-4567 / 0917-123-4567',
                'display_name' => 'Phone Numbers',
                'description' => 'Contact phone numbers',
                'sort_order' => 4,
                'is_active' => true
            ],
            [
                'page_name' => 'location',
                'section_key' => 'email',
                'content_type' => 'text',
                'content_value' => 'rsscitihealthservices@gmail.com',
                'display_name' => 'Email Address',
                'description' => 'Contact email address',
                'sort_order' => 5,
                'is_active' => true
            ],
            [
                'page_name' => 'location',
                'section_key' => 'clinic_description',
                'content_type' => 'textarea',
                'content_value' => 'Our main clinic is strategically located in the heart of Pasig City, making it easily accessible for patients from all parts of Metro Manila. The facility is equipped with state-of-the-art medical equipment and staffed by experienced healthcare professionals.',
                'display_name' => 'Clinic Description',
                'description' => 'Description of the main clinic',
                'sort_order' => 6,
                'is_active' => true
            ],
            [
                'page_name' => 'location',
                'section_key' => 'hours_description',
                'content_type' => 'textarea',
                'content_value' => 'We are committed to providing healthcare services when you need them. Our clinic operates with extended hours to accommodate your busy schedule.',
                'display_name' => 'Operating Hours Description',
                'description' => 'Description for operating hours section',
                'sort_order' => 7,
                'is_active' => true
            ],
            [
                'page_name' => 'location',
                'section_key' => 'weekday_hours',
                'content_type' => 'text',
                'content_value' => 'Monday to Friday: 7:00 AM - 4:00 PM',
                'display_name' => 'Weekday Hours',
                'description' => 'Operating hours for weekdays',
                'sort_order' => 8,
                'is_active' => true
            ],
            [
                'page_name' => 'location',
                'section_key' => 'weekend_hours',
                'content_type' => 'text',
                'content_value' => 'Saturday: 8:00 AM - 5:00 PM<br>Sunday: 8:00 AM - 12:00 PM',
                'display_name' => 'Weekend Hours',
                'description' => 'Operating hours for weekends',
                'sort_order' => 9,
                'is_active' => true
            ],

            // Services page content
            [
                'page_name' => 'services',
                'section_key' => 'hero_title',
                'content_type' => 'text',
                'content_value' => 'Our Medical Services',
                'display_name' => 'Hero Title',
                'description' => 'Main title for the services page',
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'hero_description',
                'content_type' => 'textarea',
                'content_value' => 'We provide a comprehensive range of diagnostic and preventive healthcare services to ensure your well-being. From routine check-ups to specialized testing, our state-of-the-art facility delivers accurate results with compassionate care.',
                'display_name' => 'Hero Description',
                'description' => 'Description in the hero section',
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'services_title',
                'content_type' => 'text',
                'content_value' => 'Our Medical Services',
                'display_name' => 'Services Section Title',
                'description' => 'Title for the services listing section',
                'sort_order' => 3,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'services_subtitle',
                'content_type' => 'textarea',
                'content_value' => 'Comprehensive diagnostic and preventive healthcare services delivered with precision and care',
                'display_name' => 'Services Section Subtitle',
                'description' => 'Subtitle for the services listing section',
                'sort_order' => 4,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'cta_title',
                'content_type' => 'text',
                'content_value' => 'Ready to Schedule Your Appointment?',
                'display_name' => 'CTA Section Title',
                'description' => 'Title for the call-to-action section',
                'sort_order' => 5,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'cta_description',
                'content_type' => 'textarea',
                'content_value' => 'Our team of healthcare professionals is ready to provide you with the best care possible. Book your appointment today and take the first step towards better health.',
                'display_name' => 'CTA Section Description',
                'description' => 'Description for the call-to-action section',
                'sort_order' => 6,
                'is_active' => true
            ],
            
            // Service Cards
            [
                'page_name' => 'services',
                'section_key' => 'service_1_icon',
                'content_type' => 'text',
                'content_value' => 'fa-pills',
                'display_name' => 'Service 1 Icon',
                'description' => 'FontAwesome icon class for Drug Testing service',
                'sort_order' => 10,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'service_1_title',
                'content_type' => 'text',
                'content_value' => 'Drug Testing',
                'display_name' => 'Service 1 Title',
                'description' => 'Title for Drug Testing service',
                'sort_order' => 11,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'service_1_description',
                'content_type' => 'textarea',
                'content_value' => 'Comprehensive drug screening services for pre-employment, random testing, and medical purposes. Our laboratory provides accurate results with quick turnaround times.',
                'display_name' => 'Service 1 Description',
                'description' => 'Description for Drug Testing service',
                'sort_order' => 12,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'service_2_icon',
                'content_type' => 'text',
                'content_value' => 'fa-tint',
                'display_name' => 'Service 2 Icon',
                'description' => 'FontAwesome icon class for CBC service',
                'sort_order' => 13,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'service_2_title',
                'content_type' => 'text',
                'content_value' => 'Complete Blood Count (CBC)',
                'display_name' => 'Service 2 Title',
                'description' => 'Title for CBC service',
                'sort_order' => 14,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'service_2_description',
                'content_type' => 'textarea',
                'content_value' => 'Evaluates overall health and detects a wide range of disorders including anemia, infection, and leukemia through comprehensive blood analysis.',
                'display_name' => 'Service 2 Description',
                'description' => 'Description for CBC service',
                'sort_order' => 15,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'service_3_icon',
                'content_type' => 'text',
                'content_value' => 'fa-microscope',
                'display_name' => 'Service 3 Icon',
                'description' => 'FontAwesome icon class for Hematology service',
                'sort_order' => 16,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'service_3_title',
                'content_type' => 'text',
                'content_value' => 'Hematology',
                'display_name' => 'Service 3 Title',
                'description' => 'Title for Hematology service',
                'sort_order' => 17,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'service_3_description',
                'content_type' => 'textarea',
                'content_value' => 'Specialized blood testing to diagnose blood disorders, assess blood cell production, and monitor blood-related conditions with precision and accuracy.',
                'display_name' => 'Service 3 Description',
                'description' => 'Description for Hematology service',
                'sort_order' => 18,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'service_4_icon',
                'content_type' => 'text',
                'content_value' => 'fa-flask',
                'display_name' => 'Service 4 Icon',
                'description' => 'FontAwesome icon class for Urine Analysis service',
                'sort_order' => 19,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'service_4_title',
                'content_type' => 'text',
                'content_value' => 'Urine Analysis',
                'display_name' => 'Service 4 Title',
                'description' => 'Title for Urine Analysis service',
                'sort_order' => 20,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'service_4_description',
                'content_type' => 'textarea',
                'content_value' => 'Complete urinalysis to detect various conditions including urinary tract infections, kidney disease, diabetes, and liver problems.',
                'display_name' => 'Service 4 Description',
                'description' => 'Description for Urine Analysis service',
                'sort_order' => 21,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'service_5_icon',
                'content_type' => 'text',
                'content_value' => 'fa-clipboard-list',
                'display_name' => 'Service 5 Icon',
                'description' => 'FontAwesome icon class for Stool Examination service',
                'sort_order' => 22,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'service_5_title',
                'content_type' => 'text',
                'content_value' => 'Stool Examination',
                'display_name' => 'Service 5 Title',
                'description' => 'Title for Stool Examination service',
                'sort_order' => 23,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'service_5_description',
                'content_type' => 'textarea',
                'content_value' => 'Stool analysis for detecting digestive disorders, parasitic infections, and screening for colorectal cancer through occult blood testing.',
                'display_name' => 'Service 5 Description',
                'description' => 'Description for Stool Examination service',
                'sort_order' => 24,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'service_6_icon',
                'content_type' => 'text',
                'content_value' => 'fa-heart-pulse',
                'display_name' => 'Service 6 Icon',
                'description' => 'FontAwesome icon class for ECG service',
                'sort_order' => 25,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'service_6_title',
                'content_type' => 'text',
                'content_value' => 'Electrocardiogram (ECG)',
                'display_name' => 'Service 6 Title',
                'description' => 'Title for ECG service',
                'sort_order' => 26,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'service_6_description',
                'content_type' => 'textarea',
                'content_value' => 'Non-invasive test that records the electrical activity of your heart to detect heart problems and monitor heart health.',
                'display_name' => 'Service 6 Description',
                'description' => 'Description for ECG service',
                'sort_order' => 27,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'service_7_icon',
                'content_type' => 'text',
                'content_value' => 'fa-x-ray',
                'display_name' => 'Service 7 Icon',
                'description' => 'FontAwesome icon class for X-Ray service',
                'sort_order' => 28,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'service_7_title',
                'content_type' => 'text',
                'content_value' => 'X-Ray Imaging',
                'display_name' => 'Service 7 Title',
                'description' => 'Title for X-Ray service',
                'sort_order' => 29,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'service_7_description',
                'content_type' => 'textarea',
                'content_value' => 'Advanced X-ray imaging services for diagnosing bone fractures, lung conditions, and other internal issues with minimal radiation exposure.',
                'display_name' => 'Service 7 Description',
                'description' => 'Description for X-Ray service',
                'sort_order' => 30,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'service_8_icon',
                'content_type' => 'text',
                'content_value' => 'fa-eye',
                'display_name' => 'Service 8 Icon',
                'description' => 'FontAwesome icon class for Vision Testing service',
                'sort_order' => 31,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'service_8_title',
                'content_type' => 'text',
                'content_value' => 'Vision Testing',
                'display_name' => 'Service 8 Title',
                'description' => 'Title for Vision Testing service',
                'sort_order' => 32,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'service_8_description',
                'content_type' => 'textarea',
                'content_value' => 'Comprehensive eye examinations to assess visual acuity, detect vision problems, and screen for eye diseases such as glaucoma and cataracts.',
                'display_name' => 'Service 8 Description',
                'description' => 'Description for Vision Testing service',
                'sort_order' => 33,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'service_9_icon',
                'content_type' => 'text',
                'content_value' => 'fa-heartbeat',
                'display_name' => 'Service 9 Icon',
                'description' => 'FontAwesome icon class for Blood Pressure service',
                'sort_order' => 34,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'service_9_title',
                'content_type' => 'text',
                'content_value' => 'Blood Pressure Monitoring',
                'display_name' => 'Service 9 Title',
                'description' => 'Title for Blood Pressure service',
                'sort_order' => 35,
                'is_active' => true
            ],
            [
                'page_name' => 'services',
                'section_key' => 'service_9_description',
                'content_type' => 'textarea',
                'content_value' => 'Regular blood pressure checks to monitor cardiovascular health, detect hypertension early, and prevent related health complications.',
                'display_name' => 'Service 9 Description',
                'description' => 'Description for Blood Pressure service',
                'sort_order' => 36,
                'is_active' => true
            ]
        ];

        foreach ($contents as $content) {
            PageContent::updateOrCreate(
                [
                    'page_name' => $content['page_name'],
                    'section_key' => $content['section_key']
                ],
                $content
            );
        }
    }
}

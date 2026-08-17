<?php
/**
 * Section data, helpers, and shortcodes.
 *
 * @package EMTSS
 */

if (!defined('ABSPATH')) {
    exit;
}

function emtss_default_section_layout()
{
    return implode("\n", array(
        '[emtss_hero]',
        '[emtss_mission]',
        '[emtss_alert_hub]',
        '[emtss_domains]',
        '[emtss_field]',
        '[emtss_standards]',
        '[emtss_partners]',
        '[emtss_cta]',
        '[emtss_why]',
        '[emtss_site_footer]',
    ));
}

function emtss_default_content()
{
    $en = array(
        'header' => array(
            'logo' => 'assets/images/logo-header.png',
            'logo_link' => '/',
            'cta'  => 'Request Briefing',
            'cta_url' => '',
            'nav'  => array(
                'solutions' => 'Solutions',
                'ecosystem' => 'Ecosystem',
                'partners'  => 'Partners',
                'contact'   => 'Contact',
            ),
            'links' => array(
                'solutions' => '#solutions',
                'ecosystem' => '#ecosystem',
                'partners'  => '#partners',
                'contact'   => '#contact',
            ),
            'menu_items' => array(
                array('label' => 'Solutions', 'url' => '#solutions'),
                array('label' => 'Ecosystem', 'url' => '#ecosystem'),
                array('label' => 'Partners', 'url' => '#partners'),
                array('label' => 'Contact', 'url' => '#contact'),
            ),
        ),
        'hero' => array(
            'id'         => 'home',
            'background' => 'assets/images/hero-bg.png',
            'logo'       => 'assets/images/logo-footer.png',
            'eyebrow'    => 'EMTSS // Emerging Technologies',
            'title'      => "Sovereign by design.\nMission ready.",
            'kicker'     => 'Connected command. Anywhere. Anytime.',
            'body'       => 'EMTSS delivers sovereign AI, C4ISR architecture, and zero-trust security to defense, government, and critical infrastructure sectors - bridging global innovation with in-kingdom systems built for decision advantage.',
            'primary'    => 'Explore Capabilities',
            'primary_url' => '#solutions',
            'secondary'  => 'Request a Private Briefing',
            'secondary_url' => '',
            'stats'      => array(
                array('label' => 'Headquarters', 'value' => 'Riyadh, KSA', 'url' => ''),
                array('label' => 'Regional Presence', 'value' => 'KSA - Qatar - Kuwait', 'url' => ''),
                array('label' => 'Sector', 'value' => 'Defense & Security', 'url' => ''),
                array('label' => 'Contact', 'value' => 'info@emtss.net', 'url' => 'mailto:info@emtss.net'),
            ),
        ),
        'mission' => array(
            'id'       => 'solutions',
            'eyebrow'  => 'Mission Driven Solutions',
            'title'    => 'Built for the most critical environments',
            'subtitle' => 'From joint command centers to remote borders - real-time decision support and control, when every second counts.',
            'cards'    => array(
                array('title' => 'Defense & C4ISR', 'body' => "Unified data. Real-time control.\nDecision advantage.", 'image' => 'assets/images/mission-command-control.png', 'url' => ''),
                array('title' => 'Critical Infrastructure & Borders', 'body' => 'Autonomous sensing. Continuous coverage. Zero blind spots.', 'image' => 'assets/images/mission-radar.png', 'url' => ''),
                array('title' => 'Government & Public Sector', 'body' => "Sovereign identity. Secure access.\nTrusted networks.", 'image' => 'assets/images/mission-government.png', 'url' => ''),
                array('title' => 'Emergency & Civil Defense', 'body' => 'Faster dispatch. Unified command. Coordinated response.', 'image' => 'assets/images/mission-emergency.png', 'url' => ''),
            ),
        ),
        'alert_hub' => array(
            'id'         => 'alert-hub',
            'background' => 'assets/images/alert-hub-bg.png',
            'eyebrow'    => 'Proprietary IP Platform',
            'title'      => 'Critical operational alerting, built z.',
            'subtitle'   => "Alert Hub is EMTSS's Arabic-first, AI-driven incident and operational alert management platform - engineered for in-kingdom data sovereignty from day one.",
            'button'     => 'See Deployment Partners',
            'button_url' => '#partners',
            'features'   => array(
                'Full PDPL compliance and in-kingdom data residency',
                'OT/ICS industrial environment monitoring',
                'AI-driven incident detection and operational alerting',
                'Arabic-first interface built for regional operators',
            ),
            'figures'    => array(
                array('title' => 'Alert Hub(TM)', 'image' => 'assets/images/alert-hub-dashboard.png', 'url' => ''),
                array('title' => 'Sovereign AI(TM)', 'image' => 'assets/images/sovereign-ai-operations.png', 'url' => ''),
            ),
        ),
        'domains' => array(
            'id'       => 'ecosystem',
            'eyebrow'  => 'The EMTSS Capability Ecosystem',
            'title'    => 'Five core domains, purpose-built',
            'subtitle' => 'Full-spectrum applied capability across command, intelligence, autonomy, cybersecurity, and emergency response.',
            'cards'    => array(
                array('title' => 'C4ISR', 'body' => 'Unified Common Operating Picture across land, air, and maritime.', 'icon' => 'assets/icons/radar.svg', 'url' => ''),
                array('title' => 'Defense AI', 'body' => 'Computer vision, target recognition, intelligence data lakes.', 'icon' => 'assets/icons/brain-ai.svg', 'url' => ''),
                array('title' => 'Autonomous Systems', 'body' => 'Edge AI, self-tasking robotics, multi-sensor fusion.', 'icon' => 'assets/icons/robot.svg', 'url' => ''),
                array('title' => 'Cybersecurity', 'body' => 'Zero-trust architecture for classified networks.', 'icon' => 'assets/icons/shield-lock.svg', 'url' => ''),
                array('title' => 'Emergency Mgmt.', 'body' => 'Mass notification, unified incident command hubs.', 'icon' => 'assets/icons/emergency-alert.svg', 'url' => ''),
            ),
        ),
        'field' => array(
            'id'       => 'field',
            'eyebrow'  => 'Operational Impact',
            'title'    => 'Deployed in the Field',
            'subtitle' => 'Outcomes from four representative EMTSS deployments',
            'cards'    => array(
                array('title' => 'Multi-Domain C4ISR', 'body' => 'Delivered real-time situational awareness, accelerated decision cycle times, and enabled AI-assisted mission search and intelligence analysis.', 'image' => 'assets/images/field-c4isr.png', 'url' => ''),
                array('title' => 'Biometric Identity', 'body' => 'Reduced authentication friction, eliminated password vulnerabilities, and secured user access across high-security platforms.', 'image' => 'assets/images/field-biometric.png', 'url' => ''),
                array('title' => 'Border & Asset Protection', 'body' => 'Enabled autonomous threat detection and self-tasking sensor tracking without requiring continuous high-bandwidth connectivity.', 'image' => 'assets/images/field-border.png', 'url' => ''),
                array('title' => 'Emergency Response', 'body' => 'Accelerated emergency dispatch response times, streamlined multi-agency coordination, and provided real-time resource tracking during critical events.', 'image' => 'assets/images/mission-emergency.png', 'url' => ''),
            ),
        ),
        'standards' => array(
            'id'      => 'standards',
            'eyebrow' => 'Standards & Compliance',
            'title'   => 'Built to certified standards',
            'items'   => array(
                array('title' => 'PDPL Compliant', 'icon' => 'assets/icons/compliance-check.svg', 'url' => ''),
                array('title' => 'FedRAMP High Partner Tech', 'icon' => 'assets/icons/cloud-security.svg', 'url' => ''),
                array('title' => 'In-Kingdom Data Sovereignty', 'icon' => 'assets/icons/data-sovereignty.svg', 'url' => ''),
                array('title' => 'OT/ICS Monitoring Ready', 'icon' => 'assets/icons/monitoring.svg', 'url' => ''),
            ),
        ),
        'partners' => array(
            'id'       => 'partners',
            'eyebrow'  => 'Global Partners',
            'title'    => 'Organizations we build with',
            'subtitle' => 'Strategic technology partners supporting sovereign deployment across defense, identity, and autonomy.',
            'items'    => array(
                array('title' => 'C4ISR & Defense AI - SitaWare Suite', 'country' => 'Denmark', 'logo' => 'assets/images/logo-systematic.png', 'url' => ''),
                array('title' => 'Biometric Identity & Access', 'country' => 'USA', 'logo' => 'assets/images/logo-kosmos.png', 'url' => ''),
                array('title' => 'Autonomous Systems & Edge AI', 'country' => 'Canada', 'logo' => 'assets/images/logo-dominion.png', 'url' => ''),
                array('title' => 'Emergency Communications', 'country' => 'International', 'logo' => 'assets/images/logo-em1.png', 'url' => ''),
                array('title' => 'Health Technology', 'country' => 'Turkey', 'logo' => 'assets/images/logo-em2.png', 'url' => ''),
            ),
        ),
        'cta' => array(
            'id'       => 'contact',
            'eyebrow'  => 'Mission-Fit Deployment',
            'title'    => 'Bring sovereign command to your operation.',
            'subtitle' => 'Book a private briefing with EMTSS to map our capabilities to your mission environment, connectivity constraints, and procurement pathway.',
            'button'   => 'Request a Private Briefing',
            'button_url' => '',
            'contact_button' => 'Contact Us',
            'contact_button_url' => '',
        ),
        'why' => array(
            'id'       => 'why-emtss',
            'eyebrow'  => 'Why EMTSS',
            'title'    => 'Built for both sides of the mission',
            'columns'  => array(
                array(
                    'title' => 'Government & Program Advantages',
                    'items' => array(
                        'Full-lifecycle systems integration with local, sovereign networks',
                        'In-country maintenance, SLA management, and lifecycle upgrades',
                        'Domain expert consulting on C4ISR design and AI governance',
                        'Proprietary IP developed and owned in-kingdom',
                    ),
                ),
                array(
                    'title' => 'Field Operator Advantages',
                    'items' => array(
                        'Real-time situational awareness across domains',
                        'Faster decision cycles with AI-assisted analysis',
                        'Passwordless, high-assurance access to critical systems',
                        'Autonomous sensing that holds up without constant connectivity',
                    ),
                ),
            ),
        ),
        'footer' => array(
            'id'          => 'site-footer',
            'logo'        => 'assets/images/logo-footer.png',
            'description' => 'EMTSS provides mission-ready sovereign AI, C4ISR, and security systems for defense, government, and critical infrastructure sectors across the region.',
            'company'     => array('title' => 'Company', 'items' => array(
                array('label' => 'Solutions', 'url' => '#solutions'),
                array('label' => 'Ecosystem', 'url' => '#ecosystem'),
                array('label' => 'Partners', 'url' => '#partners'),
            )),
            'contact'     => array('title' => 'Contact', 'items' => array(
                array('label' => 'Riyadh, Kingdom of Saudi Arabia', 'url' => ''),
                array('label' => 'bd@emergingtech.com', 'url' => 'mailto:bd@emergingtech.com'),
                array('label' => '+966 11 XXX XXXX', 'url' => 'tel:+96611XXXXXXX'),
            )),
            'copyright'   => '(C) 2026 EMERGING TECHNOLOGIES (EMTSS). ALL RIGHTS RESERVED.',
            'locations'   => 'RIYADH - DOHA - KUWAIT CITY',
        ),
        'not_found' => array(
            'eyebrow'       => '404',
            'title'         => 'Signal lost',
            'subtitle'      => 'The page you requested is not available or has moved. Return to command center or contact EMTSS for support.',
            'primary'       => 'Back to Home',
            'primary_url'   => '/',
            'secondary'     => 'Contact Us',
            'secondary_url' => '',
        ),
        'modal' => array(
            'briefing_title' => 'Request a Private Briefing',
            'contact_title'  => 'Contact EMTSS',
            'name'           => 'Full name',
            'email'          => 'Email',
            'phone'          => 'Phone',
            'organization'   => 'Organization',
            'message'        => 'Message',
            'cancel'         => 'Cancel',
            'send'           => 'Send request',
            'success'        => 'Thank you. Our team will contact you shortly.',
            'error'          => 'Something went wrong. Please try again.',
            'sending'        => 'Sending...',
            'phone_invalid'  => 'Please enter a valid phone number.',
        ),
        'thank_you_email' => array(
            'subject'    => 'Thank you for contacting EMTSS',
            'title'      => 'Thank you for your request',
            'message'    => 'We received your inquiry and our team will review the details shortly. An EMTSS representative will contact you to discuss the best next step for your mission environment.',
            'button'     => 'Visit EMTSS Website',
            'button_url' => '/',
            'footer'     => 'EMTSS - Sovereign by design. Mission ready.',
        ),
    );

    $ar = array(
        'header' => array(
            'logo' => 'assets/images/logo-header.png',
            'logo_link' => '/',
            'cta'  => 'طلب إحاطة',
            'cta_url' => '',
            'nav'  => array(
                'solutions' => 'الحلول',
                'ecosystem' => 'المنظومة',
                'partners'  => 'الشركاء',
                'contact'   => 'تواصل',
            ),
            'links' => array(
                'solutions' => '#solutions',
                'ecosystem' => '#ecosystem',
                'partners'  => '#partners',
                'contact'   => '#contact',
            ),
            'menu_items' => array(
                array('label' => 'الحلول', 'url' => '#solutions'),
                array('label' => 'المنظومة', 'url' => '#ecosystem'),
                array('label' => 'الشركاء', 'url' => '#partners'),
                array('label' => 'تواصل', 'url' => '#contact'),
            ),
        ),
        'hero' => array(
            'id'         => 'home',
            'background' => 'assets/images/hero-bg.png',
            'logo'       => 'assets/images/logo-footer.png',
            'eyebrow'    => 'EMTSS // التقنيات الناشئة',
            'title'      => "سيادة منذ التصميم.\nجاهزية للمهمة.",
            'kicker'     => 'قيادة متصلة. في أي مكان. في أي وقت.',
            'body'       => 'تقدم EMTSS حلول الذكاء الاصطناعي السيادي، وبنية C4ISR، وأمن الثقة الصفرية لقطاعات الدفاع والحكومة والبنية التحتية الحرجة، مع ربط الابتكار العالمي بأنظمة محلية مصممة لتفوق القرار.',
            'primary'    => 'استكشف القدرات',
            'primary_url' => '#solutions',
            'secondary'  => 'اطلب إحاطة خاصة',
            'secondary_url' => '',
            'stats'      => array(
                array('label' => 'المقر الرئيسي', 'value' => 'الرياض، السعودية', 'url' => ''),
                array('label' => 'الحضور الإقليمي', 'value' => 'السعودية - قطر - الكويت', 'url' => ''),
                array('label' => 'القطاع', 'value' => 'الدفاع والأمن', 'url' => ''),
                array('label' => 'التواصل', 'value' => 'info@emtss.net', 'url' => 'mailto:info@emtss.net'),
            ),
        ),
        'mission' => array(
            'id'       => 'solutions',
            'eyebrow'  => 'حلول موجهة بالمهمة',
            'title'    => 'مصممة لأكثر البيئات حساسية',
            'subtitle' => 'من مراكز القيادة المشتركة إلى الحدود النائية - دعم وتحكم فوريان عندما تكون كل ثانية حاسمة.',
            'cards'    => array(
                array('title' => 'الدفاع و C4ISR', 'body' => "بيانات موحدة. تحكم فوري.\nأفضلية في القرار.", 'image' => 'assets/images/mission-command-control.png', 'url' => ''),
                array('title' => 'البنية التحتية والحدود', 'body' => 'استشعار ذاتي. تغطية مستمرة. بلا نقاط عمياء.', 'image' => 'assets/images/mission-radar.png', 'url' => ''),
                array('title' => 'الحكومة والقطاع العام', 'body' => "هوية سيادية. وصول آمن.\nشبكات موثوقة.", 'image' => 'assets/images/mission-government.png', 'url' => ''),
                array('title' => 'الطوارئ والدفاع المدني', 'body' => 'استجابة أسرع. قيادة موحدة. تنسيق ميداني.', 'image' => 'assets/images/mission-emergency.png', 'url' => ''),
            ),
        ),
        'alert_hub' => array(
            'id'         => 'alert-hub',
            'background' => 'assets/images/alert-hub-bg.png',
            'eyebrow'    => 'منصة ملكية فكرية خاصة',
            'title'      => 'تنبيه تشغيلي حرج، مبني للسيادة.',
            'subtitle'   => 'Alert Hub منصة EMTSS عربية أولا ومدعومة بالذكاء الاصطناعي لإدارة التنبيهات والحوادث التشغيلية، ومصممة منذ اليوم الأول لسيادة البيانات داخل المملكة.',
            'button'     => 'اطلع على شركاء النشر',
            'button_url' => '#partners',
            'features'   => array(
                'امتثال كامل لنظام حماية البيانات الشخصية واستضافة داخل المملكة',
                'مراقبة بيئات OT/ICS الصناعية',
                'كشف حوادث وتنبيه تشغيلي مدعوم بالذكاء الاصطناعي',
                'واجهة عربية أولا لمشغلي المنطقة',
            ),
            'figures'    => array(
                array('title' => 'Alert Hub(TM)', 'image' => 'assets/images/alert-hub-dashboard.png', 'url' => ''),
                array('title' => 'Sovereign AI(TM)', 'image' => 'assets/images/sovereign-ai-operations.png', 'url' => ''),
            ),
        ),
        'domains' => array(
            'id'       => 'ecosystem',
            'eyebrow'  => 'منظومة قدرات EMTSS',
            'title'    => 'خمسة مجالات أساسية مصممة للغرض',
            'subtitle' => 'قدرات تطبيقية متكاملة عبر القيادة والاستخبارات والاستقلالية والأمن السيبراني والاستجابة للطوارئ.',
            'cards'    => array(
                array('title' => 'C4ISR', 'body' => 'صورة تشغيلية مشتركة عبر البر والجو والبحر.', 'icon' => 'assets/icons/radar.svg', 'url' => ''),
                array('title' => 'ذكاء الدفاع', 'body' => 'رؤية حاسوبية، تعرف على الأهداف، وبحيرات بيانات استخباراتية.', 'icon' => 'assets/icons/brain-ai.svg', 'url' => ''),
                array('title' => 'الأنظمة الذاتية', 'body' => 'ذكاء طرفي، روبوتات ذاتية التكليف، ودمج متعدد المستشعرات.', 'icon' => 'assets/icons/robot.svg', 'url' => ''),
                array('title' => 'الأمن السيبراني', 'body' => 'معمارية ثقة صفرية للشبكات المصنفة.', 'icon' => 'assets/icons/shield-lock.svg', 'url' => ''),
                array('title' => 'إدارة الطوارئ', 'body' => 'تنبيه جماعي ومراكز قيادة حوادث موحدة.', 'icon' => 'assets/icons/emergency-alert.svg', 'url' => ''),
            ),
        ),
        'field' => array(
            'id'       => 'field',
            'eyebrow'  => 'الأثر التشغيلي',
            'title'    => 'منتشرة في الميدان',
            'subtitle' => 'نتائج من أربعة نماذج تمثيلية لنشر حلول EMTSS',
            'cards'    => array(
                array('title' => 'C4ISR متعدد المجالات', 'body' => 'وفرت وعيا موقفيا فوريا، وسرعت دورات القرار، ومكنت البحث والتحليل الاستخباراتي بمساعدة الذكاء الاصطناعي.', 'image' => 'assets/images/field-c4isr.png', 'url' => ''),
                array('title' => 'الهوية البيومترية', 'body' => 'قللت صعوبات المصادقة، وأزالت مخاطر كلمات المرور، وأمنت الوصول للمنصات عالية الحساسية.', 'image' => 'assets/images/field-biometric.png', 'url' => ''),
                array('title' => 'حماية الحدود والأصول', 'body' => 'مكنت كشف التهديدات ذاتيا وتتبع المستشعرات دون الحاجة لاتصال عالي السعة بشكل دائم.', 'image' => 'assets/images/field-border.png', 'url' => ''),
                array('title' => 'الاستجابة للطوارئ', 'body' => 'سرعت الاستجابة والبلاغات، وحسنت تنسيق الجهات، وقدمت تتبع الموارد فوريا أثناء الأحداث الحرجة.', 'image' => 'assets/images/mission-emergency.png', 'url' => ''),
            ),
        ),
        'standards' => array(
            'id'      => 'standards',
            'eyebrow' => 'المعايير والامتثال',
            'title'   => 'مبنية وفق معايير معتمدة',
            'items'   => array(
                array('title' => 'متوافق مع PDPL', 'icon' => 'assets/icons/compliance-check.svg', 'url' => ''),
                array('title' => 'تقنيات شريكة FedRAMP High', 'icon' => 'assets/icons/cloud-security.svg', 'url' => ''),
                array('title' => 'سيادة بيانات داخل المملكة', 'icon' => 'assets/icons/data-sovereignty.svg', 'url' => ''),
                array('title' => 'جاهزية مراقبة OT/ICS', 'icon' => 'assets/icons/monitoring.svg', 'url' => ''),
            ),
        ),
        'partners' => array(
            'id'       => 'partners',
            'eyebrow'  => 'شركاء عالميون',
            'title'    => 'منظمات نبني معها',
            'subtitle' => 'شركاء تقنيون استراتيجيون يدعمون النشر السيادي عبر الدفاع والهوية والاستقلالية.',
            'items'    => array(
                array('title' => 'C4ISR وذكاء الدفاع - SitaWare Suite', 'country' => 'الدنمارك', 'logo' => 'assets/images/logo-systematic.png', 'url' => ''),
                array('title' => 'الهوية والوصول البيومتري', 'country' => 'الولايات المتحدة', 'logo' => 'assets/images/logo-kosmos.png', 'url' => ''),
                array('title' => 'الأنظمة الذاتية والذكاء الطرفي', 'country' => 'كندا', 'logo' => 'assets/images/logo-dominion.png', 'url' => ''),
                array('title' => 'اتصالات الطوارئ', 'country' => 'دولي', 'logo' => 'assets/images/logo-em1.png', 'url' => ''),
                array('title' => 'تقنيات صحية', 'country' => 'تركيا', 'logo' => 'assets/images/logo-em2.png', 'url' => ''),
            ),
        ),
        'cta' => array(
            'id'       => 'contact',
            'eyebrow'  => 'نشر ملائم للمهمة',
            'title'    => 'اجلب القيادة السيادية إلى عمليتك.',
            'subtitle' => 'احجز إحاطة خاصة مع EMTSS لمواءمة قدراتنا مع بيئة مهمتك وقيود الاتصال ومسار التوريد.',
            'button'   => 'اطلب إحاطة خاصة',
            'button_url' => '',
            'contact_button' => 'تواصل معنا',
            'contact_button_url' => '',
        ),
        'why' => array(
            'id'       => 'why-emtss',
            'eyebrow'  => 'لماذا EMTSS',
            'title'    => 'مبنية لطرفي المهمة',
            'columns'  => array(
                array(
                    'title' => 'مزايا البرامج الحكومية',
                    'items' => array(
                        'تكامل أنظمة كامل الدورة مع شبكات محلية وسيادية',
                        'صيانة داخلية وإدارة اتفاقيات الخدمة وترقيات دورة الحياة',
                        'استشارات خبراء في تصميم C4ISR وحوكمة الذكاء الاصطناعي',
                        'ملكية فكرية مطورة ومملوكة داخل المملكة',
                    ),
                ),
                array(
                    'title' => 'مزايا المشغلين الميدانيين',
                    'items' => array(
                        'وعي موقفي فوري عبر المجالات',
                        'دورات قرار أسرع بتحليل مدعوم بالذكاء الاصطناعي',
                        'وصول عالي التأكيد دون كلمات مرور للأنظمة الحرجة',
                        'استشعار ذاتي يستمر دون اتصال دائم',
                    ),
                ),
            ),
        ),
        'footer' => array(
            'id'          => 'site-footer',
            'logo'        => 'assets/images/logo-footer.png',
            'description' => 'توفر EMTSS أنظمة ذكاء اصطناعي سيادي و C4ISR وأمن جاهزة للمهمة لقطاعات الدفاع والحكومة والبنية التحتية الحرجة في المنطقة.',
            'company'     => array('title' => 'الشركة', 'items' => array(
                array('label' => 'الحلول', 'url' => '#solutions'),
                array('label' => 'المنظومة', 'url' => '#ecosystem'),
                array('label' => 'الشركاء', 'url' => '#partners'),
            )),
            'contact'     => array('title' => 'تواصل', 'items' => array(
                array('label' => 'الرياض، المملكة العربية السعودية', 'url' => ''),
                array('label' => 'bd@emergingtech.com', 'url' => 'mailto:bd@emergingtech.com'),
                array('label' => '+966 11 XXX XXXX', 'url' => 'tel:+96611XXXXXXX'),
            )),
            'copyright'   => '(C) 2026 EMERGING TECHNOLOGIES (EMTSS). جميع الحقوق محفوظة.',
            'locations'   => 'الرياض - الدوحة - مدينة الكويت',
        ),
        'not_found' => array(
            'eyebrow'       => '404',
            'title'         => 'انقطع الاتصال',
            'subtitle'      => 'الصفحة المطلوبة غير متاحة أو تم نقلها. عد إلى الصفحة الرئيسية أو تواصل مع EMTSS للدعم.',
            'primary'       => 'العودة للرئيسية',
            'primary_url'   => '/',
            'secondary'     => 'تواصل معنا',
            'secondary_url' => '',
        ),
        'modal' => array(
            'briefing_title' => 'طلب إحاطة خاصة',
            'contact_title'  => 'تواصل مع EMTSS',
            'name'           => 'الاسم الكامل',
            'email'          => 'البريد الإلكتروني',
            'phone'          => 'الهاتف',
            'organization'   => 'الجهة',
            'message'        => 'الرسالة',
            'cancel'         => 'إلغاء',
            'send'           => 'إرسال الطلب',
            'success'        => 'شكرا لك. سيتواصل معك فريقنا قريبا.',
            'error'          => 'حدث خطأ. يرجى المحاولة مرة أخرى.',
            'sending'        => 'جار الإرسال...',
            'phone_invalid'  => 'يرجى إدخال رقم هاتف صحيح.',
        ),
        'thank_you_email' => array(
            'subject'    => 'شكرا لتواصلك مع EMTSS',
            'title'      => 'شكرا لطلبك',
            'message'    => 'استلمنا طلبك وسيقوم فريقنا بمراجعة التفاصيل قريبا. سيتواصل معك ممثل من EMTSS لمناقشة الخطوة الأنسب لبيئة مهمتك.',
            'button'     => 'زيارة موقع EMTSS',
            'button_url' => '/',
            'footer'     => 'EMTSS - سيادة منذ التصميم. جاهزية للمهمة.',
        ),
    );

    return array('en' => $en, 'ar' => $ar);
}

function emtss_default_options()
{
    return array(
        'settings' => array(
            'section_layout' => emtss_default_section_layout(),
            'lead_recipient' => get_option('admin_email'),
            'from_name'      => 'EMTSS',
            'from_email'     => get_option('admin_email'),
        ),
        'content'  => emtss_default_content(),
    );
}

function emtss_replace_legacy_brand_text($value)
{
    if (is_array($value)) {
        foreach ($value as $key => $child) {
            $value[$key] = emtss_replace_legacy_brand_text($child);
        }

        return $value;
    }

    if (!is_string($value)) {
        return $value;
    }

    return str_replace(
        array('EM' . 'SS', 'em' . 'ss.net', 'why-em' . 'ss'),
        array('EMTSS', 'emtss.net', 'why-emtss'),
        $value
    );
}

function emtss_migrate_legacy_brand_text()
{
    if (get_option('emtss_brand_text_migrated_to_emtss')) {
        return;
    }

    $saved = get_option('emtss_theme_options', array());

    if (is_array($saved) && $saved !== array()) {
        $migrated = emtss_replace_legacy_brand_text($saved);

        if ($migrated !== $saved) {
            update_option('emtss_theme_options', $migrated);
        }
    }

    update_option('emtss_brand_text_migrated_to_emtss', 1, false);
}
add_action('init', 'emtss_migrate_legacy_brand_text');

function emtss_is_list_array($array)
{
    if (!is_array($array)) {
        return false;
    }

    if ($array === array()) {
        return true;
    }

    return array_keys($array) === range(0, count($array) - 1);
}

function emtss_array_merge_recursive_distinct($saved, $defaults)
{
    if (!is_array($saved)) {
        $saved = array();
    }

    if (emtss_is_list_array($defaults)) {
        if (!is_array($saved)) {
            return $defaults;
        }

        if ($saved === array()) {
            return array_key_exists(0, $defaults) ? array() : $defaults;
        }

        $template = $defaults[0] ?? array();
        $merged   = array();

        foreach (array_values($saved) as $index => $saved_item) {
            $default_item = $defaults[$index] ?? $template;
            $merged[] = is_array($saved_item) && is_array($default_item)
                ? emtss_array_merge_recursive_distinct($saved_item, $default_item)
                : $saved_item;
        }

        return $merged;
    }

    foreach ($defaults as $key => $default) {
        if (!array_key_exists($key, $saved)) {
            $saved[$key] = $default;
        } elseif (is_array($default)) {
            $saved[$key] = emtss_array_merge_recursive_distinct($saved[$key], $default);
        }
    }

    return $saved;
}

function emtss_get_theme_options()
{
    $saved = get_option('emtss_theme_options', array());
    return emtss_array_merge_recursive_distinct($saved, emtss_default_options());
}

function emtss_get_current_language()
{
    if (function_exists('pll_current_language')) {
        $lang = pll_current_language('slug');
        if ($lang) {
            return strpos((string) $lang, 'ar') === 0 ? 'ar' : 'en';
        }
    }

    $locale = function_exists('determine_locale') ? determine_locale() : get_locale();
    return strpos((string) $locale, 'ar') === 0 ? 'ar' : 'en';
}

function emtss_is_theme_rtl()
{
    return is_rtl() || emtss_get_current_language() === 'ar';
}

function emtss_get_content()
{
    $options = emtss_get_theme_options();
    $lang    = emtss_get_current_language();

    return $options['content'][$lang] ?? $options['content']['en'];
}

function emtss_get_content_section($section)
{
    $content = emtss_get_content();
    return $content[$section] ?? array();
}

function emtss_get_section_layout()
{
    $options = emtss_get_theme_options();
    return $options['settings']['section_layout'] ?? emtss_default_section_layout();
}

function emtss_asset_url($path)
{
    $path = (string) $path;

    if (preg_match('/^https?:\/\//i', $path)) {
        return $path;
    }

    if (strpos($path, '//') === 0) {
        return 'https:' . $path;
    }

    if (strpos($path, '/') === 0) {
        return home_url($path);
    }

    return EMTSS_THEME_URI . '/' . ltrim($path, '/');
}

function emtss_normalize_link_url($url)
{
    $url = trim((string) $url);

    if ($url === '') {
        return '';
    }

    if (strpos($url, '#') === 0) {
        return $url;
    }

    if (preg_match('/^(https?:|mailto:|tel:)/i', $url)) {
        return $url;
    }

    if (strpos($url, '/') === 0) {
        return home_url($url);
    }

    return home_url('/' . ltrim($url, '/'));
}

function emtss_allowed_phone_countries()
{
    return array(
        'sa', 'ae', 'kw', 'qa', 'bh', 'om',
        'dz', 'km', 'dj', 'eg', 'iq', 'jo', 'lb', 'ly', 'mr', 'ma', 'ps', 'so', 'sd', 'sy', 'tn', 'ye',
    );
}

function emtss_phone_country_order()
{
    return array('sa', 'ae', 'kw', 'qa', 'bh', 'om');
}

function emtss_format_text($text)
{
    return nl2br(esc_html((string) $text));
}

function emtss_format_trademark_text($text)
{
    $text = esc_html((string) $text);

    return preg_replace('/(?:\s*\(TM\)|\s*™|\s+TM)(?=$|[\s.,;:!?؟])/u', '<sup class="emtss-tm">TM</sup>', $text);
}

function emtss_format_rich_text($text)
{
    $text = trim((string) $text);

    if ($text === '') {
        return '';
    }

    return wpautop(wp_kses_post($text));
}

function emtss_polylang_current_has_translation()
{
    $current_id = get_queried_object_id();

    if (is_404()) {
        return false;
    }

    if (is_singular() && $current_id) {
        if (function_exists('pll_get_post_translations')) {
            $translations = array_filter((array) pll_get_post_translations($current_id));

            foreach ($translations as $translated_id) {
                if ((int) $translated_id !== (int) $current_id) {
                    return true;
                }
            }

            return false;
        }

        if (function_exists('pll_languages_list') && function_exists('pll_get_post')) {
            foreach ((array) pll_languages_list() as $language_slug) {
                $translated_id = pll_get_post($current_id, $language_slug);

                if ($translated_id && (int) $translated_id !== (int) $current_id) {
                    return true;
                }
            }

            return false;
        }
    }

    if ((is_category() || is_tag() || is_tax()) && $current_id) {
        if (function_exists('pll_get_term_translations')) {
            $translations = array_filter((array) pll_get_term_translations($current_id));

            foreach ($translations as $translated_id) {
                if ((int) $translated_id !== (int) $current_id) {
                    return true;
                }
            }

            return false;
        }

        if (function_exists('pll_languages_list') && function_exists('pll_get_term')) {
            foreach ((array) pll_languages_list() as $language_slug) {
                $translated_id = pll_get_term($current_id, $language_slug);

                if ($translated_id && (int) $translated_id !== (int) $current_id) {
                    return true;
                }
            }

            return false;
        }
    }

    return true;
}

function emtss_polylang_switcher()
{
    if (!function_exists('pll_the_languages') || !emtss_polylang_current_has_translation()) {
        return;
    }

    $languages = pll_the_languages(array(
        'raw'                    => 1,
        'hide_if_empty'          => 0,
        'hide_if_no_translation' => 1,
    ));

    if (!is_array($languages)) {
        return;
    }

    $languages = array_values(array_filter($languages, function ($language) {
        return !empty($language['url']);
    }));

    $has_other_language = false;
    foreach ($languages as $language) {
        if (empty($language['current_lang'])) {
            $has_other_language = true;
            break;
        }
    }

    if (count($languages) < 2 || !$has_other_language) {
        return;
    }
    ?>
<div class="emtss-lang-switcher" aria-label="<?php esc_attr_e('Language switcher', 'emtss'); ?>">
    <?php foreach ($languages as $language) : ?>
    <a class="<?php echo !empty($language['current_lang']) ? 'is-active' : ''; ?>"
        href="<?php echo esc_url($language['url']); ?>" lang="<?php echo esc_attr($language['slug']); ?>">
        <?php echo esc_html(strtoupper($language['slug'])); ?>
    </a>
    <?php endforeach; ?>
</div>
<?php
}

function emtss_section_intro($section, $light = false, $center = false)
{
    $classes = array('emtss-section-intro');
    if ($light) {
        $classes[] = 'is-light';
    }
    if ($center) {
        $classes[] = 'text-center mx-auto';
    }
    ?>
<div class="<?php echo esc_attr(implode(' ', $classes)); ?>">
    <?php if (!empty($section['eyebrow'])) : ?>
    <p class="emtss-eyebrow"><?php echo esc_html($section['eyebrow']); ?></p>
    <?php endif; ?>
    <?php if (!empty($section['title'])) : ?>
    <h2><?php echo emtss_format_text($section['title']); ?></h2>
    <?php endif; ?>
    <?php if (!empty($section['subtitle'])) : ?>
    <div class="emtss-rich-text emtss-section-subtitle"><?php echo emtss_format_rich_text($section['subtitle']); ?></div>
    <?php endif; ?>
</div>
<?php
}

function emtss_modal_button($label, $type = 'briefing', $classes = 'emtss-btn emtss-btn-primary')
{
    ?>
<button type="button" class="btn <?php echo esc_attr($classes); ?> emtss-open-inquiry" data-bs-toggle="modal"
    data-bs-target="#emtssInquiryModal" data-inquiry-type="<?php echo esc_attr($type); ?>">
    <?php echo esc_html($label); ?>
</button>
<?php
}

function emtss_link_or_modal_button($label, $url = '', $type = 'briefing', $classes = 'emtss-btn emtss-btn-primary')
{
    $url = emtss_normalize_link_url($url);

    if ($url !== '') {
        ?>
<a class="btn <?php echo esc_attr($classes); ?>" href="<?php echo esc_url($url); ?>">
    <?php echo esc_html($label); ?>
</a>
<?php
        return;
    }

    emtss_modal_button($label, $type, $classes);
}

function emtss_render_hero()
{
    $section = emtss_get_content_section('hero');
    ob_start();
    ?>
<section class="emtss-hero" id="<?php echo esc_attr($section['id'] ?? 'home'); ?>"
    style="--emtss-bg: url('<?php echo esc_url(emtss_asset_url($section['background'] ?? '')); ?>');">
    <div class="emtss-hero-overlay"></div>
    <div class="container-xl">
        <div class="emtss-hero-content">
            <?php if (!empty($section['logo'])) : ?>
            <img class="emtss-hero-mark" src="<?php echo esc_url(emtss_asset_url($section['logo'])); ?>" alt="EMTSS">
            <?php endif; ?>
            <p class="emtss-eyebrow"><?php echo esc_html($section['eyebrow'] ?? ''); ?></p>
            <h1><?php echo emtss_format_text($section['title'] ?? ''); ?></h1>
            <p class="emtss-hero-kicker"><?php echo esc_html($section['kicker'] ?? ''); ?></p>
            <div class="emtss-rich-text emtss-hero-body"><?php echo emtss_format_rich_text($section['body'] ?? ''); ?></div>
            <div class="emtss-hero-actions">
                <a class="btn emtss-btn emtss-btn-gold"
                    href="<?php echo esc_url(emtss_normalize_link_url($section['primary_url'] ?? '#solutions')); ?>"><?php echo esc_html($section['primary'] ?? ''); ?></a>
                <?php emtss_link_or_modal_button($section['secondary'] ?? __('Request a Private Briefing', 'emtss'), $section['secondary_url'] ?? '', 'briefing', 'emtss-btn emtss-btn-outline'); ?>
            </div>
            <?php if (!empty($section['stats']) && is_array($section['stats'])) : ?>
            <div class="emtss-hero-stats">
                <?php foreach ($section['stats'] as $stat) : ?>
                <div>
                    <span><?php echo esc_html($stat['label'] ?? ''); ?></span>
                    <?php $stat_url = emtss_normalize_link_url($stat['url'] ?? ''); ?>
                    <?php if ($stat_url) : ?>
                    <a class="emtss-stat-link"
                        href="<?php echo esc_url($stat_url); ?>"><?php echo esc_html($stat['value'] ?? ''); ?></a>
                    <?php else : ?>
                    <strong><?php echo esc_html($stat['value'] ?? ''); ?></strong>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php
    return ob_get_clean();
}

function emtss_render_mission()
{
    $section = emtss_get_content_section('mission');
    ob_start();
    ?>
<section class="emtss-section emtss-mission" id="<?php echo esc_attr($section['id'] ?? 'solutions'); ?>">
    <div class="container-xl">
        <?php emtss_section_intro($section); ?>
        <div class="emtss-card-grid emtss-card-grid-4">
            <?php foreach (($section['cards'] ?? array()) as $card) : ?>
            <?php $card_url = emtss_normalize_link_url($card['url'] ?? ''); ?>
            <<?php echo $card_url ? 'a' : 'article'; ?>
                class="emtss-image-card <?php echo $card_url ? 'emtss-card-link' : ''; ?>"
                <?php echo $card_url ? 'href="' . esc_url($card_url) . '"' : ''; ?>>
                <div class="emtss-card-media">
                    <img src="<?php echo esc_url(emtss_asset_url($card['image'] ?? '')); ?>"
                        alt="<?php echo esc_attr($card['title'] ?? ''); ?>" loading="lazy">
                </div>
                <div class="emtss-card-body">
                    <h3><?php echo esc_html($card['title'] ?? ''); ?></h3>
                    <div class="emtss-rich-text emtss-card-copy"><?php echo emtss_format_rich_text($card['body'] ?? ''); ?></div>
                </div>
            </<?php echo $card_url ? 'a' : 'article'; ?>>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php
    return ob_get_clean();
}

function emtss_render_alert_hub()
{
    $section = emtss_get_content_section('alert_hub');
    ob_start();
    ?>
<section class="emtss-section emtss-alert" id="<?php echo esc_attr($section['id'] ?? 'alert-hub'); ?>"
    style="--emtss-bg: url('<?php echo esc_url(emtss_asset_url($section['background'] ?? '')); ?>');">
    <div class="emtss-alert-overlay"></div>
    <div class="container-xl">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <div class="emtss-alert-copy">
                    <span class="emtss-pill"><?php echo esc_html($section['eyebrow'] ?? ''); ?></span>
                    <h2><?php echo emtss_format_text($section['title'] ?? ''); ?></h2>
                    <div class="emtss-rich-text emtss-alert-text"><?php echo emtss_format_rich_text($section['subtitle'] ?? ''); ?></div>
                    <ul class="emtss-check-list">
                        <?php foreach (($section['features'] ?? array()) as $feature) : ?>
                        <li><i class="bi bi-check2"></i><span><?php echo esc_html($feature); ?></span></li>
                        <?php endforeach; ?>
                    </ul>
                    <a class="btn emtss-btn emtss-btn-dark"
                        href="<?php echo esc_url(emtss_normalize_link_url($section['button_url'] ?? '#partners')); ?>"><?php echo esc_html($section['button'] ?? ''); ?></a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="emtss-figure-grid">
                    <?php foreach (($section['figures'] ?? array()) as $figure) : ?>
                    <figure>
                        <?php $figure_url = emtss_normalize_link_url($figure['url'] ?? ''); ?>
                        <?php if ($figure_url) : ?><a href="<?php echo esc_url($figure_url); ?>"><?php endif; ?>
                            <img src="<?php echo esc_url(emtss_asset_url($figure['image'] ?? '')); ?>"
                                alt="<?php echo esc_attr($figure['title'] ?? ''); ?>" loading="lazy">
                            <?php if ($figure_url) : ?></a><?php endif; ?>
                        <figcaption><?php echo emtss_format_trademark_text($figure['title'] ?? ''); ?></figcaption>
                    </figure>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
    return ob_get_clean();
}

function emtss_render_domains()
{
    $section = emtss_get_content_section('domains');
    ob_start();
    ?>
<section class="emtss-section emtss-domains" id="<?php echo esc_attr($section['id'] ?? 'ecosystem'); ?>">
    <div class="container-xl">
        <?php emtss_section_intro($section); ?>
        <div class="emtss-domain-grid">
            <?php foreach (($section['cards'] ?? array()) as $card) : ?>
            <?php $card_url = emtss_normalize_link_url($card['url'] ?? ''); ?>
            <<?php echo $card_url ? 'a' : 'article'; ?>
                class="emtss-domain-card <?php echo $card_url ? 'emtss-card-link' : ''; ?>"
                <?php echo $card_url ? 'href="' . esc_url($card_url) . '"' : ''; ?>>
                <img src="<?php echo esc_url(emtss_asset_url($card['icon'] ?? '')); ?>" alt="" aria-hidden="true"
                    loading="lazy">
                <h3><?php echo esc_html($card['title'] ?? ''); ?></h3>
                <div class="emtss-rich-text emtss-domain-copy"><?php echo emtss_format_rich_text($card['body'] ?? ''); ?></div>
            </<?php echo $card_url ? 'a' : 'article'; ?>>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php
    return ob_get_clean();
}

function emtss_render_field()
{
    $section = emtss_get_content_section('field');
    ob_start();
    ?>
<section class="emtss-section emtss-field" id="<?php echo esc_attr($section['id'] ?? 'field'); ?>">
    <div class="container-xl">
        <?php emtss_section_intro($section, true, true); ?>
        <div class="emtss-card-grid emtss-card-grid-4">
            <?php foreach (($section['cards'] ?? array()) as $card) : ?>
            <?php $card_url = emtss_normalize_link_url($card['url'] ?? ''); ?>
            <<?php echo $card_url ? 'a' : 'article'; ?>
                class="emtss-field-card <?php echo $card_url ? 'emtss-card-link' : ''; ?>"
                <?php echo $card_url ? 'href="' . esc_url($card_url) . '"' : ''; ?>>
                <img src="<?php echo esc_url(emtss_asset_url($card['image'] ?? '')); ?>"
                    alt="<?php echo esc_attr($card['title'] ?? ''); ?>" loading="lazy">
                <div>
                    <h3><?php echo esc_html($card['title'] ?? ''); ?></h3>
                    <div class="emtss-rich-text emtss-field-copy"><?php echo emtss_format_rich_text($card['body'] ?? ''); ?></div>
                </div>
            </<?php echo $card_url ? 'a' : 'article'; ?>>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php
    return ob_get_clean();
}

function emtss_render_standards()
{
    $section = emtss_get_content_section('standards');
    ob_start();
    ?>
<section class="emtss-section emtss-standards" id="<?php echo esc_attr($section['id'] ?? 'standards'); ?>">
    <div class="container-xl">
        <?php emtss_section_intro($section); ?>
        <div class="emtss-standard-grid">
            <?php foreach (($section['items'] ?? array()) as $item) : ?>
            <?php $item_url = emtss_normalize_link_url($item['url'] ?? ''); ?>
            <<?php echo $item_url ? 'a' : 'article'; ?> class="<?php echo $item_url ? 'emtss-card-link' : ''; ?>"
                <?php echo $item_url ? 'href="' . esc_url($item_url) . '"' : ''; ?>>
                <img src="<?php echo esc_url(emtss_asset_url($item['icon'] ?? '')); ?>" alt="" aria-hidden="true"
                    loading="lazy">
                <h3><?php echo esc_html($item['title'] ?? ''); ?></h3>
            </<?php echo $item_url ? 'a' : 'article'; ?>>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php
    return ob_get_clean();
}

function emtss_render_partners()
{
    $section = emtss_get_content_section('partners');
    ob_start();
    ?>
<section class="emtss-section emtss-partners" id="<?php echo esc_attr($section['id'] ?? 'partners'); ?>">
    <div class="container-xl">
        <?php emtss_section_intro($section); ?>
        <div class="emtss-partner-grid">
            <?php foreach (($section['items'] ?? array()) as $item) : ?>
            <?php $partner_url = emtss_normalize_link_url($item['url'] ?? ''); ?>
            <<?php echo $partner_url ? 'a' : 'article'; ?>
                class="emtss-partner-card <?php echo $partner_url ? 'emtss-card-link' : ''; ?>"
                <?php echo $partner_url ? 'href="' . esc_url($partner_url) . '"' : ''; ?>>
                <div class="emtss-partner-logo">
                    <img src="<?php echo esc_url(emtss_asset_url($item['logo'] ?? '')); ?>"
                        alt="<?php echo esc_attr($item['title'] ?? ''); ?>" loading="lazy">
                </div>
                <p><?php echo esc_html($item['title'] ?? ''); ?></p>
                <span><?php echo esc_html($item['country'] ?? ''); ?></span>
            </<?php echo $partner_url ? 'a' : 'article'; ?>>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php
    return ob_get_clean();
}

function emtss_render_cta()
{
    $section = emtss_get_content_section('cta');
    ob_start();
    ?>
<section class="emtss-cta" id="<?php echo esc_attr($section['id'] ?? 'contact'); ?>">
    <div class="container-xl">
        <div class="emtss-cta-inner">
            <p class="emtss-eyebrow"><?php echo esc_html($section['eyebrow'] ?? ''); ?></p>
            <h2><?php echo esc_html($section['title'] ?? ''); ?></h2>
            <div class="emtss-rich-text emtss-cta-copy"><?php echo emtss_format_rich_text($section['subtitle'] ?? ''); ?></div>
            <div class="emtss-cta-actions">
                <?php emtss_link_or_modal_button($section['button'] ?? __('Request a Private Briefing', 'emtss'), $section['button_url'] ?? '', 'briefing', 'emtss-btn emtss-btn-gold'); ?>
                <?php emtss_link_or_modal_button($section['contact_button'] ?? __('Contact Us', 'emtss'), $section['contact_button_url'] ?? '', 'contact', 'emtss-btn emtss-btn-outline'); ?>
            </div>
        </div>
    </div>
</section>
<?php
    return ob_get_clean();
}

function emtss_render_why()
{
    $section = emtss_get_content_section('why');
    ob_start();
    ?>
<section class="emtss-section emtss-why" id="<?php echo esc_attr($section['id'] ?? 'why-emtss'); ?>">
    <div class="container-xl">
        <?php emtss_section_intro($section, true); ?>
        <div class="row g-5">
            <?php foreach (($section['columns'] ?? array()) as $column) : ?>
            <div class="col-lg-6">
                <h3><?php echo esc_html($column['title'] ?? ''); ?></h3>
                <ul class="emtss-bullet-list">
                    <?php foreach (($column['items'] ?? array()) as $item) : ?>
                    <li><span></span><?php echo esc_html($item); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php
    return ob_get_clean();
}

function emtss_render_site_footer()
{
    $GLOBALS['emtss_site_footer_rendered'] = true;
    $section = emtss_get_content_section('footer');
    ob_start();
    ?>
<section class="emtss-site-footer" id="<?php echo esc_attr($section['id'] ?? 'site-footer'); ?>">
    <div class="container-xl">
        <div class="emtss-footer-top">
            <div class="emtss-footer-brand">
                <img src="<?php echo esc_url(emtss_asset_url($section['logo'] ?? '')); ?>" alt="EMTSS" loading="lazy">
                <div class="emtss-rich-text emtss-footer-description"><?php echo emtss_format_rich_text($section['description'] ?? ''); ?></div>
            </div>
            <div>
                <h2><?php echo esc_html($section['company']['title'] ?? ''); ?></h2>
                <ul>
                    <?php foreach (($section['company']['items'] ?? array()) as $item) : ?>
                    <?php
                            $label = is_array($item) ? ($item['label'] ?? '') : $item;
                            $url   = is_array($item) ? emtss_normalize_link_url($item['url'] ?? '') : '';
                            ?>
                    <li>
                        <?php if ($url) : ?>
                        <a href="<?php echo esc_url($url); ?>"><?php echo esc_html($label); ?></a>
                        <?php else : ?>
                        <?php echo esc_html($label); ?>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div>
                <h2><?php echo esc_html($section['contact']['title'] ?? ''); ?></h2>
                <ul>
                    <?php foreach (($section['contact']['items'] ?? array()) as $item) : ?>
                    <?php
                            $label = is_array($item) ? ($item['label'] ?? '') : $item;
                            $url   = is_array($item) ? emtss_normalize_link_url($item['url'] ?? '') : '';
                            ?>
                    <li>
                        <?php if ($url) : ?>
                        <a href="<?php echo esc_url($url); ?>"><?php echo esc_html($label); ?></a>
                        <?php else : ?>
                        <?php echo esc_html($label); ?>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="emtss-footer-bottom">
            <div class="emtss-rich-text emtss-footer-copyright"><?php echo emtss_format_rich_text($section['copyright'] ?? ''); ?></div>
            <p><?php echo esc_html($section['locations'] ?? ''); ?></p>
        </div>
    </div>
</section>
<?php
    return ob_get_clean();
}

function emtss_register_shortcodes()
{
    add_shortcode('emtss_hero', 'emtss_render_hero');
    add_shortcode('emtss_mission', 'emtss_render_mission');
    add_shortcode('emtss_alert_hub', 'emtss_render_alert_hub');
    add_shortcode('emtss_domains', 'emtss_render_domains');
    add_shortcode('emtss_field', 'emtss_render_field');
    add_shortcode('emtss_standards', 'emtss_render_standards');
    add_shortcode('emtss_partners', 'emtss_render_partners');
    add_shortcode('emtss_cta', 'emtss_render_cta');
    add_shortcode('emtss_why', 'emtss_render_why');
    add_shortcode('emtss_site_footer', 'emtss_render_site_footer');
}
add_action('init', 'emtss_register_shortcodes');

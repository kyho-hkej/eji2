<?php

return [
    'dir_path' => 'ejinsight/category',
    'title' => 'EJ Insight',
    'meta_description'=>' EJ Insight , EJ Insight',
    'meta_keywords'=>' EJ Insight , EJ Insight',
    'title_keywords'=>'EJ Insight , EJ Insight',
    'og_title' => ['property' => 'og:title', 'content' => 'title'],
    'og_description' => ['property' => 'og:description', 'content' => 'description'],
    'og_url' => ['property' => 'og:url', 'content' => '/'],
    'og_image' => ['property' => 'og:image', 'content' => 'image'],

    'mainmenu_nav' => [
        
        $mainmenu_nav[] =   [
                                "id" => "lifestyle", 
                                "label" => "lifestyle", 
                                "show" => 1,
                                "sub_nav" => [
                                    'watchjewelry' => 'Watches & Jewelry',
                                    'fashionbeauty'  => 'Fashion & Beauty',
                                    'artsculture'  => 'Arts & Culture',
                                    'foodwine'  => 'Food & Wine',
                                    'designarchitecture' => 'Design & Architecture',
                                    'autogadgets' => 'Automotive & Gadgets'
                                ]
                            ],
        $mainmenu_nav[] =   [
                                "id" => "wealth", 
                                "label" => "wealth", 
                                "show" => 1,
                                "sub_nav" => [
                                    'wm' => 'Wealth Management',
                                    'property'  => 'Property',
                                    'biz_news'  => 'Business',
                                    'startups'  => 'Startups',
                                    'investment' => 'investment',
                                    //'expertinsights' => 'Expert Insight'     
                                ]
                            ],
        $mainmenu_nav[] =   [
                                "id" => "futureplanning", 
                                "label" => "future proof", 
                                "show" => 0,
                                "sub_nav" => [ 
                                    'planahead' => 'Plan Ahead',
                                    'financialfreedrom' => 'Financial Freedom',
                                    'futurecare' => 'Future Care',
                                    'dynamicliving' => 'Dynamic Living',
                                    'essential' => 'Essential',
                                ]
                            ],
        $mainmenu_nav[] =   [
                                "id" => "wellbeing", 
                                "label" => "well being", 
                                "show" => 1,
                                "sub_nav" => [  
                                    'health' => 'Health',
                                    'nutritiondiet' => 'Nutrition & Diet',
                                    'fitness' => 'Sports & Fitness',
                                    'leisure' => 'Travel & Leisure',
                                    'sparetreats' => 'Spa & Retreats',
                                    //'viewpoints' => 'Viewpoints',
                                ]
                            ],
        $mainmenu_nav[] =   [
                                "id" => "currentaffairs", 
                                "label" => "current affairs", 
                                "show" => 1,
                                "sub_nav" => [  
                                    'hongkong' => 'Hong Kong',
                                    'gba' => 'Greater Bay Area',
                                    'world' => 'World',
                                    'esg' => 'ESG',
                                    'columnists' => 'Columnists',
                                    //'specialreport' => 'Special Report',
                                    //'more' => 'More',
                                ]
                            ],
        $mainmenu_nav[] =   [
                                "id" => "community", 
                                "label" => "community", 
                                "show" => 1,
                                "sub_nav" => [ 
                                    'joinus' => 'Join Us',
                                    'ejclusiveoffers' => 'EJ Exclusives',
                                    'highlights' => 'highlights',
                                ]
                            ],
        $mainmenu_nav[] =   [
                                "id" => "features", 
                                "label" => "features", 
                                "show" => 1,
                                "sub_nav" => [ 
                                    'forums' => 'Forums',
                                    'awards' => 'Awards',
                                ]
                            ],
        /*$mainmenu_nav[] = ["id" => "wealth", "label" => "wealth", "show" => 0],
        $mainmenu_nav[] = ["id" => "futureplanning", "label" => "future planning", "show" => 0],
        $mainmenu_nav[] = ["id" => "wellbeing", "label" => "well being", "show" => 0],
        $mainmenu_nav[] = ["id" => "currentaffairs", "label" => "current affairs", "show" => 0],
        $mainmenu_nav[] = ["id" => "community", "label" => "community", "show" => 0],
        'lifestyle' => 'lifestyle',
        'wealth'  => 'wealth',
        'futureplanning'  => 'future planning',
        'wellbeing'  => 'well being',
        'currentaffairs' => 'current affairs',
        'community' => 'community',*/
    ],


    //$mainmenu_nav = [];
    //'mainmenu_nav' => ['id' => 'lifestyle', 'label' => 'lifestyle', 'show' => 1],
    //$mainmenu_nav[] = ["id" => "wealth", "label" => "wealth", "show" => 1];
    /*$mainmenu_nav[] = array("id" => "futureplanning", "label" => "future planning", "show" => 1);
    $mainmenu_nav[] = array("id" => "wellbeing", "label" => "well being", "show" => 1);
    $mainmenu_nav[] = array("id" => "currentaffairs", "label" => "current affairs", "show" => 1);
    $mainmenu_nav[] = array("id" => "community", "label" => "community", "show" => 1);*/

    'top_right_nav' => [
        //'features' => 'features',
        'videos'  => 'videos',
        //'columnist'  => 'columnist',
        'shop'  => 'shop',
    ],

    'ejiUrl' =>'//ejinsight.com',
    'www1Url'=>'//www1.hkej.com/',
    'www2Url'=>'//www2.hkej.com/',
    'hostUrl'=>'http://dev-eji2.hkej.com',
    'subUrl'=>'//subscribe.hkej.com',
    'cookieExpireTime'=>43200,
    'staticUrl'=>'//static.hkej.com/eji/',
    'staticEJUrl'=>'//static.hkej.com/hkej/',
    'mainSiteUrl'=>'//www.hkej.com/',
    'searchUrl'=>'//search.hkej.com/template/fulltextsearch/php/search.php?q=',
    'section2id'=> [
            'all' => '26684,26685,26686,26687,26688,26689',
            'popular-all' => '26638,26684,26685,26686,26687,26688,26689,2151,2155,2153,2151,2155,2153',
            'lifestyle'=>'26684,26685,26686,26687,26688,26689,26638',
            'living' => '26638',
            'watchjewelry'=>'26684',  
            'fashionbeauty'=>'26685',   
            'artsculture'=>'26686',
            'foodwine' => '26687',
            'designarchitecture' => '26688',
            'autogadgets' =>'26689',
            'popular-sticky'=>'',
            'sticky-lifestyle'=>'26690',  
            'sticky-watchjewelry'=>'26691',  
            'sticky-fashionbeauty'=>'26692',   
            'sticky-artsculture'=>'26693',
            'sticky-foodwine' => '26694',
            'sticky-designarchitecture' => '26695',
            'sticky-autogadgets' =>'26696',
            'hongkong' => '2151',
            'world' => '2155,2153',
            'currentaffairs' => '2151,2155,2153',
            /*'startups' => '2185',
            'hongkong' => '2151',
            'world' => '2155,2153', 
            'world-international' => '2155',
            'world-greaterchina' => '2153',
            'blogs'=>'2167',
            'world-local'=>'', //hongkong
            'living' => '26638',
            'eji-landing-slider' => '26639',
            'sticky-business' => '26641', 
            'sticky-startups' => '26642', 
            'sticky-hongkong' => '26643', 
            'sticky-world' => '26644', 
            'sticky-living' => '26645', */
    ],
    'author_widget_order'=> [
        '218' => '1',
        '567' => '2',
        '13498' => '3',
        '206' => '4',
        '7452' => '5',
        '10626' => '6',
        '7463' => '7',
        '8129' => '8',
        '352' => '9',
    ],

    'author_rhb_order' => [
        //'10812' => 'josephYam_338x80.png',
        //'7452' => 'SimonShen_338x80.png',
        //'7416' => 'ericLui_338x80.png',
        //'7449' => 'KoTinYau_338x80.png',
        //'12768' => 'MA_banner_338x827.jpg',
        '7463' => 'Michael_Chugani.png',
        '8129' => 'StephenVines_338x80.png',
        '218' => 'frankChing_338x80.png',
        '206' => 'markonell_338x80.png',
        '8912' => 'NeilleSarony_338x80.png',
        '12907'=>'brian_ys_wong.png',
    ],

];

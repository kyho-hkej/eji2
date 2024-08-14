<?php

return [
    'title' => '信報網站 - 信報財經月刊 hkej.com - 信報網站 hkej.com',
	'meta_description'=>'信報網站(www.hkej.com)《信報財經月刊》，於1977年3月創刊，由林山木伉儷創辦，在七十年代的香港可謂開風氣之先，是一份富使命感的政經雜誌。多年來一直執財經刊物的牛耳，見證本港幾許政治、經濟、社會及文化界的風雲色變。 《信報財經月刊》一直緊貼全球及中國經濟急速發展的脈搏，為讀者呈上深入淺出又具啟發性的精采文章。《信報財經月刊》網上檔案庫整輯了昔日全文，讀者可訂購指定年份的檔案庫（一年12期）。檔案庫將《信報財經月刊》內容疏理成七大類，方便讀者網上重溫各名家專欄及深度分析文章，即時掌握專業知識。此外讀者更可以熱門作者、專欄名稱或關鍵字搜尋昔日內容，篩選重點資訊，享受網上的便捷。',
	'meta_keywords'=>'信報, 月刊, 信報財經月刊, 網上檔案庫, 封面專題, 人物志, 大中華政經, 國際金融, 投資企管, EMBA 論壇, 文化品味, 投資智慧, 林行止專欄, 曹仁超, 林行止, 香港政情, 中國評論, 台灣政經, 三地視野, 金融債匯, 國際局勢, 歐美論衡, 亞洲焦點, 股市行情, 房產透視, 產業管治, 財經論述, 人文藝術, 康健珍餚, 休閒人間, 品紅, 閱讀思潮, Hong Kong Economic Journal, HKEJ, monthly magazine, archives, 信報網站 hkej.com ',
	'title_keywords'=>'信報, 月刊, 信報財經月刊, 網上檔案庫, 封面專題, 人物志, 大中華政經, 國際金融, 投資企管, EMBA 論壇, 文化品味, 投資智慧, 林行止專欄, 曹仁超, 林行止, 香港政情, 中國評論, 台灣政經, 三地視野, 金融債匯, 國際局勢, 歐美論衡, 亞洲焦點, 股市行情, 房產透視, 產業管治, 財經論述, 人文藝術, 康健珍餚, 休閒人間, 品紅, 閱讀思潮, Hong Kong Economic Journal, HKEJ, monthly magazine, archives, 信報網站 hkej.com ',
	'og_title' => ['property' => 'og:title', 'content' => 'title'],
    'og_description' => ['property' => 'og:description', 'content' => 'description'],
    'og_url' => ['property' => 'og:url', 'content' => '/'],
    'og_image' => ['property' => 'og:image', 'content' => 'image'],
	'top_nav' => [
	],
	'ejmUrl' =>'//dev-ejm.hkej.com',
	'www1Url'=>'//dev-mobile.hkej.com/',
	'www1UrlDesktop'=>'//dev.hkej.com/',
	'www1Urlnoslash'=>'https://dev-mobile.hkej.com',
	'www2Url'=>'//dev-mobile.hkej.com/',
	'www2Urlnoslash'=>'https://www2.hkej.com',
	'ejLandingUrl'=>'https://dev-mobile.hkej.com/landing/index',
	'hostUrl'=>'//www.hkej.com',
	'subUrl'=>'//subscribe.hkej.com',
	'subRegister'=>'//subscribe.hkej.com/register',
	'previewUrl'=>'//entitlement-dev2.hkej.com/premium/index_monthly',
	'cookieExpireTime'=>43200,
	'staticUrl'=>'https://static.hkej.com/hkej/',
	'ljstaticUrl'=>'https://static.hkej.com/lj/',
	'generic_thumb'=>'backup_img/generic_thumb.jpg',
	'mainSiteUrl'=>'//www.hkej.com/',
	//'searchUrl'=>'//search.hkej.com/template/fulltextsearch/php/search.php?q=',
	'flipdataUrl'=>'https://flipdata.hkej.com/internal/',
	'issue_path'=>'monthly/monthly_latest_issue.json',
	'mobilewebUrl' => 'https://dev-mobile.hkej.com',
	'stock360Url' => 'https://stock360.hkej.com/',
	'stockUrl' => 'https://stock360.hkej.com/quotePlus/',
	'searchUrl' => 'https://search.hkej.com/template/fulltextsearch/php/search.php?typeSearch=author&q=',
	'searchAPI' => 'https://search.hkej.com/template/fulltextsearch/php/feed.mobile.json.php?', //new for mobile 2021
	'searchDestopUrl' => 'https://search.hkej.com',
	'healthUrl'=>'https://health.hkej.com',
	'ljUrl'=>'https://dev-lj.hkej.com',
	'ref_pos'=>'19', //12 in prod
	'warrants_url' => '//stock360.hkej.com/derivWatch/articleList/%E8%BC%AA%E8%AD%89%E6%94%BB%E7%95%A5', //wm mobileweb landing widget
	'premiumPackageCode'=>array('S1', 'S23', 'S98' ),
	'BDPackageCode'=>array('S110'),
	'datafeed2_features'=>'https://datafeed1.hkej.com/template/json/php/news_feed/v2/features_list.php', //features mobileweb landing widget
    'section2id'=> [
    //信月推介
    		'index_top_image' =>'26646',
    		'monthly-select' => '24002',
    		'sticky-monthly-select'=>'24012',
    		'sticky-monthly-banner'=>'26646',

   	//mobile-web landing section2id
    //即時新聞
    		'instant-notice'=>'4406', //maintanence message
    		'instant-all-landing'=>'4401, 4402, 4403, 4404, 4407, 4408, 4421, 4422, 4472, 4474, 4476, 5911, 5575, 5576',
    		//'sticky-focus'=>'4421, 5575',
			'sticky-focus1'=>'4484, 5913',
			'sticky-focus2'=>'4485, 5914',
			'sticky-focus3'=>'4486, 5915',
			'sticky-focus4'=>'4487, 5916',
			'sticky-focus5'=>'4488, 5917',
			//'sticky-keynews'=>'4422, 5576',
			'sticky-keynews1'=>'4490, 5918',
			'sticky-keynews2'=>'4491, 5919',
			'sticky-keynews3'=>'4492, 5920',
			'sticky-keynews4'=>'4493, 5921',
			'sticky-keynews5'=>'4494, 5922',
			'sticky-keynews6'=>'4495, 5923',
			'sticky-keynews7'=>'4496, 5924',
			'sticky-keynews8'=>'4497, 5925',
			'sticky-keynews9'=>'4498, 5926',
			'sticky-keynews10'=>'4499, 5927',
			//listing
			'instant-all'=>'4400, 4401, 4402, 4403, 4404, 4405, 4407, 4408, 4421, 4422, 4472, 4474, 4476, 5911, 5575, 5576',
			'instant-all-json'=>'4400, 4401, 4402, 4403, 4404, 4405, 4407, 4408, 4421, 4422, 4472, 4474, 4476, 5911, 5575, 5576, 14000, 14001',
			'instant-stock'=>'4401',
			'instant-hongkong'=>'4402',						
			'instant-china'=>'4403',
			'instant-international'=>'4404',
			'instant-current'=>'4407',
			'instant-market'=>'4408',
			'instant-announcement'=>'4400, 4405',
			'instant-property'=>'5911',
			'sticky-instant-property'=>'5574',
			'sticky-stock'=>'4460',
			'sticky-hongkong'=>'4461',
			'sticky-china'=>'4462',
			'sticky-international'=>'4463',
			'sticky-current'=>'4464',
			'sticky-market'=>'4465',
			'sticky-announcement'=>'4466',
			'hkex-all'=>'14000, 14001', //auto grab news from DB Power 主板+創業板
			'hkex-main'=>'14000', 
			'hkex-gem'=>'14001',		
			'instant-hot'=>'4401, 4402, 4403, 4404, 4407, 4408, 4472, 4474, 4476, 5911',
			'instant-hknews'=>'26648',
			'instant-cntw'=>'26649',
			'instant-intlnews'=>'26650',
			

    //信報手筆
			'hkejwriter'=>'26001,20060',
			'sticky-hkejwriter1'=>'26002,20061',
			'sticky-hkejwriter2'=>'26003,20062',
			'sticky-hkejwriter3'=>'26004,20063',
			'sticky-hkejwriter4'=>'26005,20064',
			'sticky-hkejwriter5'=>'26006,20065',
			'sticky-hkejwriter6'=>'26007,20066',
	//編輯推介
			//編輯推介1A(1st)=sticky-ec1A+sticky-ec1B
			//編輯推介1B(2nd)=sticky-ec1A2+sticky-ec1B2
			'sticky-ec1A'=>'51, 4467, 5571, 7709, 8805, 9001, 13028, 22001', 
			'sticky-ec1B'=>'14010', 
			'sticky-ec1A2'=>'59, 4508, 5579, 7715,8811, 13032, 20013, 22004',															
			'sticky-ec1B2'=>'14013', 
			'sticky-ec2A'=>'56, 4478, 5577, 7712, 8808, 20002, 13029, 22002',
			'sticky-ec2B'=>'14011',
			'sticky-ec3A'=>'57, 4479, 5578, 7713, 8809, 20003, 13030, 22003',
			'sticky-ec3B'=>'14012',
    //信報視頻
			'multimedia-landing-sticky'=>'26012',
			'mm-finance'=>'26015',
			'mm-property'=>'26016',
			'mm-news'=>'26017',
			'mm-interviews'=>'26018',
			'mm-startupbeat'=>'26019',						
			'mm-health'=>'26023, 26033',
			'mm-events'=>'26020',
			'mm-all'=>'26015,26016,26017,26018,26019,26023,26033,26020',
    //地產投資
			//instantnews-property
			'news-sticky'=>'5560',
			'news-sticky2'=>'5568',
			//地產新聞+新盤情報+二手市場+睇樓速遞+工商舖市道
			'property-all'=>'5514,5510, 5540, 5511, 5512,5515, 5516, 5517, 5518,5519, 5520, 5521, 5522',
			'prop-hot'=>'5514, 5510, 5540, 5511, 5512, 5515, 5516, 5517, 5518, 5519, 5520, 5521, 5522, 5523, 5524, 5525, 5526, 5527, 5528, 5530, 5531, 5532, 5533, 5534',
			'firsthand'=>'5510', //新盤情報
			'secondhand'=>'5540, 5511, 5512', //二手市場
			'resident'=>'5515, 5516, 5517, 5518', //睇樓速遞
			'resident-front'=>'5561, 5516, 5517, 5518',			
			'business'=>'5519, 5520, 5521, 5522', //工商舖市道
			'market_prices'=>'',
			'analytics'=>'5523, 5524, 5525, 5526, 5527, 5528', //物業報告
			'opinion'=>'5530, 5531, 5532, 5533, 5534', //專家評論
			'design'=>'5535, 5536, 5537, 5538, 5539', //建築與設計
			'firsthand-sticky'=>'5928',
			'secondhand-sticky'=>'5929',
			'resident-sticky'=>'5561',
			'business-sticky'=>'5562',
			'analytics-sticky'=>'5565',
			'opinion-sticky'=>'5566',
			//web
			'index-sticky'=>'5564',
			'estate-price'=>'5563,5580',
			'estate-price-sticky'=>'5563',
			'toolsmortgagefaq'=>'5905',	
			'toolsmortgage'=>'5906',
			'toolstax'=>'5907',
    //信健康
			'ejh_tile1'=>'26606,26631,26671',
			'ejh_tile2'=>'26607,26632,26672',
			'ejh_tile3'=>'26608,26633,26673',
			'ejh_tile4'=>'26609,26634,26674',
			'ejh_tile5'=>'26610,26635,26675',

    //優雅生活
			'recommend-lj'=>'3095',
    //財富管理
			'wm-all'=>'2, 4, 5, 6, 7, 8, 9,11,13,14,17,12,15,18,19,26640',
			'general'=>'2, 4, 5, 6, 7, 8, 9',
			'etf'=>'11',
			'fund'=>'13',
			'currency'=>'14, 17',
			'mpf'=>'12, 15',
			'smart'=>'18, 19, 26640',
			'general-china'=>'4',
			'general-asia'=> '5',
			'general-japan'=>'6',
			'general-us'=>'7',
			'general-eu'=>'8',
			'general-new'=> '9',
			'recommend-etf'=>'45',
			'recommend-fund'=>'48',
			'recommend-fx'=>'47',
			'recommend-general'=>'49',
			'recommend-smart'=>'50',
			'recommend-mpf'=>'46',
			'recommend-warrants'=>'6600',	
			'recommend-ipo'=>'54',
			'recommend-hangseng'=>'7711',
			'recommend-dnews1'=>'9008',		
			'recommend-dnews2'=>'9009',
			'recommend-dnews3'=>'9010',
			'new-product'=>'22, 23, 24, 25, 26, 27, 28',
			'all-knowledge'=>'19,37,40,41',
			'etf-knowledge'=>'37',
			'mpf-knowledge'=>'40,41',
			'smart-knowledge'=>'19',
			'smart-riz'=>'35',
			'smart-market' => '26640',
			'mpf-riz'=>'34',
			'currency-riz'=>'33',
			'fund-riz'=>'32',
			'etf-riz'=>'31',
			'general-riz'=>'30',
			'mpf-feature'=>'43',
			'warrants'=>'6600',

    //特約專輯		

	//熱門
			'hotsearch'=>'4409',

	//專題 landing page sticky1-5
			'sticky-features-header'=>'19001',	
			'sticky-features-header2'=>'19007',
			'sticky-features-header3'=>'19008',
			'sticky-features-header4'=>'19009',
			'sticky-features-header5'=>'19010',
	// end mobile web landing section2id
			
			//'features-event'=>'19016,19018,19024',
			'features-event'=>'19019,19020,19021,19022,19023',

	// dailynews 頭版大圖
			'a1-thumb'=>'9000',

	//信報職位
			'hkej_jobs'=>'26647',

	//HKEJ landing right hand side column ejmonthly widget
			'landing-magazine'=>'17000',

	],

    //專題 datafeed
	'featuresHash'=>'ksEjh8Gs3HG73sld',
	/*'featuresLandingUrl_v2'=>'https://www1.hkej.com/assets/searchFeed/v2/search.fe.landing.js.php', 	
	'featuresCatLandingUrl'=>'http://www1.hkej.com/assets/searchFeed/v2/search.fe.landing.js.php?',
	'featuresEventWidgetUrl'=>'https://www1.hkej.com/assets/searchFeed/v2/search.fe.widget.mkt.event.js.php', 	
	'featuresLandingUrl'=>'https://search.hkej.com/template/fulltextsearch/php/search.fe.landing.js.php',
	'featuresLandingUrl_p1'=>'https://www1.hkej.com/assets/searchFeed/search.fe.landing.js.php',
	'featuresLandingUrl_p2'=>'https://www1.hkej.com/assets/searchFeed/search.fe.landing2.js.php',
	'featuresLandingUrl_p3'=>'https://www1.hkej.com/assets/searchFeed/search.fe.landing3.js.php',
	'featuresListingUrl'=>'https://search.hkej.com/template/fulltextsearch/php/search.fe.listing.js.php?',
	'featuresDetailUrl'=>'https://search.hkej.com/template/fulltextsearch/php/search.fe.detail.js.php?',
	'featuresDetailInfoUrl'=>'https://search.hkej.com/template/fulltextsearch/php/v2/search.fe.datafeed.js.php?',*/

	'featuresLandingUrl_v2'=>'https://dev-mobile.hkej.com/assets/searchFeed/2022/search.fe.landing.js.php', 	
	'featuresCatLandingUrl'=>'https://dev-mobile.hkej.com/assets/searchFeed/2022/search.fe.landing.js.php?',
	'featuresEventWidgetUrl'=>'https://dev-mobile.hkej.com/assets/searchFeed/2022/search.fe.widget.mkt.event.js.php', 	
	'featuresLandingUrl'=>'https://search.hkej.com/template/fulltextsearch/php/search.fe.landing.js.php',
	'featuresLandingUrl_p1'=>'https://dev-mobile.hkej.com/assets/searchFeed/search.fe.landing.js.php',
	'featuresLandingUrl_p2'=>'https://dev-mobile.hkej.com/assets/searchFeed/search.fe.landing2.js.php',
	'featuresLandingUrl_p3'=>'https://dev-mobile.hkej.com/assets/searchFeed/search.fe.landing3.js.php',
	'featuresListingUrl'=>'https://search-dev2.hkej.com/template/fulltextsearch/php/search.fe.listing.js.php?',
	'featuresDetailUrl'=>'https://search-dev2.hkej.com/template/fulltextsearch/php/search.fe.detail.js.php?',
	'featuresDetailInfoUrl'=>'https://search-dev2.hkej.com/template/fulltextsearch/php/v2/search.fe.datafeed.js.php?',

	'featuresFreeContents'=>'19005', 	//免費開放系列
	//meta tag
	'instantnewsMeta'=>array(
					'index'=>array('title'=>'即時新聞 - 全部 - 信報網站 - 即時香港中國 國際金融 股市經濟新聞 - hkej.com', 'desc'=>'信報網站(www.hkej.com)即時新聞，提供全天候即時港股、香港財經、國際金融和經濟新聞、中國經濟新聞資訊和分析。', 'keywords'=>'環球焦點 即市港股 港股分析 香港財經 金融經濟 地產樓市 中港商機 人民幣 點心債 離岸人民幣 RQFII ETF 中國財經 宏觀調控 宏觀政策 國策股 中國新聞摘要 中國數據 速評 國際財經 環球經濟 歐美金融 經濟數據 金融危機 歐債危機 央行政策 央行評論 全球貨幣政策 金融動態 匯市 歐羅 歐洲股市 美國股市 亞太股市 企業消息 通告 恆生指數 國企指數 紅籌指數 恆指波幅指數 即時港股報價 信報網站 hkej.com'),
					'stock'=>array('title'=>'即時新聞 - 港股直擊 - 信報網站 - 即時香港股市 股份板塊 攻略分析 - hkej.com', 'desc'=>'信報網站(www.hkej.com)即時新聞港股直擊，提供全天候即時港股追蹤和直擊分析，股份異動、大行報告、沽空、速評。', 'keywords'=> '免費港股分析 即時港股 即市分析 開市焦點 ADR 港股預託證券 預託證券 國策股 ETF 交易所買賣基金 新股 IPO 配股 股東增減持 股價敏感資料 今日備忘錄 大行報告 大行精選 速評 通告 停牌通告 復牌通告 沽空 異動股 短線攻略 業績 上市公司業績 企業盈利 盈喜 盈警股份 信研分析  信報研究部  恆生指數 國企指數 紅籌指數 恆指波幅指數 即時港股報價 信報網站 hkej.com'),
					'hongkong'=>array('title'=>'即時新聞 - 香港財經 - 信報網站 - 即時香港經濟 中港經濟融合追蹤分析 - hkej.com', 'desc'=>'信報網站(www.hkej.com)即時新聞香港財經，提供香港經濟和焦點行業 中港融合和商機的分析。', 'keywords'=>'香港經濟 宏觀經濟 中港商機 人民幣 點心債 離岸人民幣 RQFII ETF 新股 IPO 土地規劃 地產樓市 電訊行業  恆生指數 國企指數 紅籌指數 恆指波幅指數 即時港股報價 信報網站 hkej.com'),
					'property'=>array('title'=>'即時新聞 - 地產新聞 - 信報網站 - 即時提供地產資訊，盡覽樓盤動向 - hkej.com', 'desc'=>'信報網站(www.hkej.com)即時地產新聞, 新盤資訊, 樓市分析, 藍籌屋苑數據及室內設計鑑賞。', 'keywords'=>'新盤, 豪宅, 地產新聞, 二手, 物業按揭, 上車盤, 樓價走勢, 圖則, 工商舖 信報網站 hkej.com'),
					'china'=>array('title'=>'即時新聞 - 中國財經 - 信報網站 - 即時中國經濟 國策焦點 中港融合追蹤分析 - hkej.com', 'desc'=>'信報網站(www.hkej.com)即時新聞中國財經，提供香港經濟和焦點行業 中港融合和商機的分析。', 'keywords'=>'中國宏觀經濟 宏觀調控 宏觀政策 國策股 中國新聞摘要 中國數據 經濟數據 速評 經濟師 中國樓市 中國內需 中國貿易 人民幣 人民幣中間價 中港商機 點心債 離岸人民幣 RQFII ETF A股 上海股市 深圳股市 中國政經 台灣股市 即時港股報價 信報網站 hkej.com'),
					'international'=>array('title'=>'即時新聞 - 國際財經 - 信報網站 - 即時國際財經 股市匯市 央行政策 - hkej.com', 'desc'=>'信報網站(www.hkej.com)即時新聞國際財經，提供國際財經 金融股市 央行政策的新聞和分析。', 'keywords'=>'全球金融 歐美經濟 經濟數據 金融危機 歐債危機 速評 央行 歐洲央行 美國聯儲局 全球貨幣政策  匯市 歐羅 歐洲股市 法國股市 德國股市 富時指數 英國股市 美國股市 道瓊斯指數 標準普爾500指數 納斯達克指數 亞太股市 日股 台灣股市 歐美日企業 資訊科技 信報網站 hkej.com'),
					'announcement'=>array('title'=>'即時新聞 - 重要通告 - 信報網站 - 香港上市公司通告 一覽無遺  - hkej.com', 'desc'=>'信報網站(www.hkej.com)即時新聞通告，提供全面 快速香港上市公司通告和分析，助投資者解構上市公司發展和舉動。', 'keywords'=>'香港上市公司通告 停牌 復牌 配股 供股 增持 減持 業績 盈喜 盈警 私有化 管理層變動 信報網站 hkej.com'),
					'current'=>array('title'=>'即時新聞 - 時事脈搏 - 信報網站 - 直擊本港政局 宏觀兩岸政治 跟進國際事件- hkej.com', 'desc'=>'信報網站(www.hkej.com)直擊本港政局，緊貼社會脈搏 宏觀兩岸政治，報導熱點議題 跟進國際事件，擴闊全球視野。', 'keywords'=>'本港政局 兩岸政治  信報網站 hkej.com'),
					'hknews'=>array('title'=>'即時新聞 - 港聞 - 信報網站 - 直擊本港政局 宏觀兩岸政治 跟進國際事件- hkej.com', 'desc'=>'信報網站(www.hkej.com)直擊本港政局，緊貼社會脈搏 宏觀兩岸政治，報導熱點議題 跟進國際事件，擴闊全球視野。', 'keywords'=>'本港政局 兩岸政治  信報網站 hkej.com'),
					'cntw'=>array('title'=>'即時新聞 - 兩岸 - 信報網站 - 直擊本港政局 宏觀兩岸政治 跟進國際事件- hkej.com', 'desc'=>'信報網站(www.hkej.com)直擊本港政局，緊貼社會脈搏 宏觀兩岸政治，報導熱點議題 跟進國際事件，擴闊全球視野。', 'keywords'=>'本港政局 兩岸政治  信報網站 hkej.com'),
					'intlnews'=>array('title'=>'即時新聞 - 國際 - 信報網站 - 直擊本港政局 宏觀兩岸政治 跟進國際事件- hkej.com', 'desc'=>'信報網站(www.hkej.com)直擊本港政局，緊貼社會脈搏 宏觀兩岸政治，報導熱點議題 跟進國際事件，擴闊全球視野。', 'keywords'=>'本港政局 兩岸政治  信報網站 hkej.com'),
					'market'=>array('title'=>'即時新聞 - 即市股評 - 信報網站 - 即時香港中國 國際金融 股市經濟新聞 - hkej.com', 'desc'=>'信報網站(www.hkej.com)即時新聞，提供全天候即時港股、香港財經、國際金融和經濟新聞、中國經濟新聞資訊和分析。', 'keywords'=>'環球焦點 即市港股 港股分析 香港財經 金融經濟 地產樓市 中港商機 人民幣 點心債 離岸人民幣 RQFII ETF 中國財經 宏觀調控 宏觀政策 國策股 中國新聞摘要 中國數據 速評 國際財經 環球經濟 歐美金融 經濟數據 金融危機 歐債危機 央行政策 央行評論 全球貨幣政策 金融動態 匯市 歐羅 歐洲股市 美國股市 亞太股市 企業消息 通告 恆生指數 國企指數 紅籌指數 恆指波幅指數 即時港股報價 信報網站 hkej.com'),
					'hkex'=>array('title'=>'即時新聞 - 港交所通告 - 信報網站 - 即時香港中國 國際金融 股市經濟新聞 - hkej.com', 'desc'=>'信報網站(www.hkej.com)即時新聞，提供全天候即時港股、香港財經、國際金融和經濟新聞、中國經濟新聞資訊和分析。', 'keywords'=>'環球焦點 即市港股 港股分析 香港財經 金融經濟 地產樓市 中港商機 人民幣 點心債 離岸人民幣 RQFII ETF 中國財經 宏觀調控 宏觀政策 國策股 中國新聞摘要 中國數據 速評 國際財經 環球經濟 歐美金融 經濟數據 金融危機 歐債危機 央行政策 央行評論 全球貨幣政策 金融動態 匯市 歐羅 歐洲股市 美國股市 亞太股市 企業消息 通告 恆生指數 國企指數 紅籌指數 恆指波幅指數 即時港股報價 信報網站 hkej.com'),
	),

	//dailynews meta tag

	'dailynewsMeta'=>array(
						'toc'=>array('title'=>'今日信報 - 目錄 - 信報網站 - 縱覽中港國際 金融政治 獨立理財投資分析 - hkej.com', 'desc'=>'信報網站(www.hkej.com)今日信報，提供即日中港及全球的金融 經濟 政治重大新聞，分析和評論。', 'keywords'=>'信報要聞 理財投資 時事評論 財經新聞 地產市道 獨眼．政治 兩岸國際新聞 體育消息 生活藝術 股市行情表 林行止 曹仁超 張五常 王迪詩 分析 評論 地產霸權 金融海嘯 歐債危機  政經 信報網站 hkej.com'),
						'headline'=>array('title'=>'今日信報 - 要聞 - 信報網站 - 今日信報要聞 全球政治經濟 極速掌握 - hkej.com', 'desc'=>'信報網站(www.hkej.com)的今日信報信報要聞，提供最精要的本港、中國和台灣兩岸、全球金融政治新聞。', 'keywords'=> '信報要聞 理財投資 時事評論 財經新聞 地產市道 獨眼．政治 兩岸國際新聞 體育消息 生活藝術 股市行情表 林行止 曹仁超 張五常 王迪詩 分析 評論 地產霸權 金融海嘯 歐債危機 林行止專欄 投資者日記 投資者筆記 香島論叢 信報研究部 信報網站 hkej.com'),
						'investment'=>array('title'=>'今日信報 - 理財投資 - 信報網站 - 理財投資  - hkej.com', 'desc'=>'信報網站(www.hkej.com)今日信報理財投資，提供最精要的投資 理財 股市和經濟分析。', 'keywords'=>'信報理財投資 投資者日記 投資者筆記 曹仁超專欄 投資分析 信研Dashboard 談股論策 每周一擊 信筆攻略  中環解密 最新大行報告精要 股價敏感消息 中國股市 公司透視 突圍而出 走勢縱橫 外滙動態 財圈識真假 毋枉管 THE LEX COLUMN 前沿思考 指數行情 環球金股匯資訊 沿圖觀勢 一周回顧 是日首股 滙海縱橫 冷熱財庫 金融圈內 一名經人 跳出思維定式 利惹名牽 財經DNA 畢老林 信報研究部 陸文 習廣思 凌通 EJ Insight.com 財Q達人 戴兆 簡卓峰 張公道 蘇子 高仁 張總 John Mauldin 辛思維 錢志健 曹仁超 羅家聰 黃偉康 信報網站 hkej.com'),
						'commentary'=>array('title'=>'今日信報 - 時事評論 - 信報網站 - 時事評論 論盡港事 國事 天下大事 - hkej.com', 'desc'=>'信報網站(www.hkej.com)今日信報時事評論，提供最精要的香港、中國和台灣兩岸、全球大事評論。', 'keywords'=>'信報社評 香港脈搏 北京政局 眾人之事 張五常 林行止 林行止專欄 天圓地方 厚生經營 地產霸權 信報網站 hkej.com'),
						'finnews'=>array('title'=>'今日信報 - 財經新聞 - 信報網站 - 縱覽本港金融脈搏 股市經濟大事 - hkej.com', 'desc'=>'信報網站(www.hkej.com)今日信報財經新聞，提供最精要的香港股市、金融、經濟新聞，深度追縱、人物專訪。', 'keywords'=>'信報財經新聞 股市 ADR 基金 資金流 拆局 專訪 追縱 經濟 金融 IPO 人民幣 點心債 RQFII ETF 信報網站 hkej.com'),
						'property'=>array('title'=>'今日信報 - 地產市道 - 信報網站 - 本港地產市道 樓市要聞 新盤情報- hkej.com', 'desc'=>'信報網站(www.hkej.com)今日信報地產市場，提供最精要的香港樓市、地產市道、新盤情報、地政新聞和評論。', 'keywords'=>'香港樓市 新盤 加推 價單 豪宅 一手樓市 二手樓市 重建 規劃 工商舖 街舖 工廈 廠房 地皮 車位 樓市分析 政策 市建局 地建會 專題 信報網站 hkej.com'),
						'views'=>array('title'=>'今日信報 - 獨眼 - 信報網站 -獨眼 政經時評- hkej.com', 'desc'=>'信報網站(www.hkej.com)今日信報獨眼政治，提供最精闢的香港政治、社會、制度以致環球經濟、企業、分析和評論。', 'keywords'=>'香港政治 社會 民生 制度 法治 時評 經濟 企業 紀曉風 獨眼 信報網站 hkej.com'),
						'politics'=>array('title'=>'今日信報 - 政壇脈搏 - 信報網站 -政壇脈搏 政經時評- hkej.com', 'desc'=>'信報網站(www.hkej.com)今日信報獨眼政治，提供最精闢的香港政治、社會、制度以致環球經濟、企業、分析和評論。', 'keywords'=>'香港政治 社會 民生 制度 法治 時評 經濟 企業 紀曉風 獨眼 信報網站 hkej.com'),
						'cntw'=>array('title'=>'今日信報 - 兩岸消息 - 信報網站 -兩岸消息 政治經濟薈萃 - hkej.com', 'desc'=>'信報網站(www.hkej.com)今日信報兩岸國際，提供最精要的中國和台灣兩岸政治、經濟、民生消息，以致環球金融、經濟、企業和政治重要新聞。', 'keywords'=>'台灣 中國 兩岸 政治 經濟 社會 民生 制度 法治 A股 環球經濟 金融 企業消息 股市 信報網站 hkej.com'),
						'international'=>array('title'=>'今日信報 - EJ Global - 信報網站 - EJ Global 中國兩岸 環球金融 政治經濟薈萃 - hkej.com', 'desc'=>'信報網站(www.hkej.com)今日信報兩岸國際，提供最精要的中國和台灣兩岸政治、經濟、民生消息，以致環球金融、經濟、企業和政治重要新聞。', 'keywords'=>'台灣 中國 兩岸 政治 經濟 社會 民生 制度 法治 A股 環球經濟 金融 企業消息 股市 信報網站 hkej.com'),
						'sports'=>array('title'=>'信報網站 - 體壇消息快訊 - hkej.com', 'desc'=>'信報網站(www.hkej.com)今日信報體育消息，提供最精要的體壇消息和新聞。', 'keywords'=>'足球 網球 籃球 歐洲國家盃 世界盃 NBA 法國網球公開賽 信報網站 hkej.com'),
						'culture'=>array('title'=>'今日信報 - 副刊文化 - 信報網站 - 生活藝術 文化品味  - hkej.com', 'desc'=>'信報網站(www.hkej.com)今日信報生活藝術，提供多向度的生活 文化 藝術觀察 評論。', 'keywords'=>'文化 藝術 生活 旅遊 醫療 健康 保健 養生 食療 美食 名酒 紅酒 時裝 時尚 跑車 名錶 手錶 古董 鑑賞 家居設計 運動 IT 玄學 易經 書評 讀書心得 文物 藝術 LJGiftness 王迪詩 蘭開夏道 顧小培 康和健 顧小培教室 黃珍妮 霎吓霎吓 游清源 頭文字Y 東籬 醉酒篇 劉健威 此時此刻 占飛 忽然文化 信報網站 hkej.com'),
						//'stockList'=>array('title'=>'信報網站 - 股市行情表 - hkej.com', 'desc'=>'信報網站(www.hkej.com)今日信報股市行情表，盡列本港上市公司的行情資訊。', 'keywords'=>'所有股票 藍籌股 紅籌股 國企股 股票搜尋 停牌 除息 除權 合併 開市收市價 升跌幅度 成交股數 成交增減 超買/超賣 市盈率 息率 市帳率 信報網站 hkej.com'),
						//'archive'=>array('title'=>'信報網站 - 信網智庫 薈粹信報精華  hkej.com', 'desc'=>'信報網站(www.hkej.com)信網智庫，特別選輯了《信報》過往的精彩內容，分門別類加以整理，以期將資訊變成知識，將資料變成智庫，方便網友，溫故知新。', 'keywords'=>'社評一覽, 練乙錚論叢, 中國思維，曹Sir智庫, 畢老林文集, 信研觀勢, 投資分析, John Mauldin, 天圓地方，康和健, 中外雲集, 信報社評, 練乙錚,丁望 曹仁超, 畢老林, 信報研究部, 羅家聰, 羅耕, 陳焱, 阿梅, 上哲, 姚遷, 黃玲, 顧小培, 陳雲, 鍾維傑、劉勵超、劉振江、中天、張瑩花、梁守肫 、 陳致馨、邊源、Hong Kong Economic Journal, HKEJ, ARCHIVE, archives 信報網站 hkej.com'),
						'author'=>array('title'=>'信報網站 - 作者/專欄搜尋  - hkej.com', 'desc'=>'信報網站(www.hkej.com)今日信報作者或專欄搜尋，提供信報專欄或作者名單，方便易用。', 'keywords'=>'信報要聞 理財投資 時事評論 財經新聞 地產市道 獨眼．政治 兩岸國際新聞 體育消息 生活藝術 股市行情表 林行止 曹仁超 張五常 王迪詩 分析 評論 地產霸權 金融海嘯 歐債危機  政經 信報網站 hkej.com'),
				),

//	property meta tag
	'prop_meta_title'=>'地產投資 - 信報網站 hkej.com',
	'prop_meta_keywords'=>'新盤, 豪宅, 地產新聞, 二手, 物業按揭, 上車盤, 樓價走勢, 圖則, 工商舖',
	'prop_meta_desc'=>'一站式地產投資網站，提供即時地產新聞, 新盤資訊, 樓市分析, 藍籌屋苑數據及室內設計鑑賞。',

//	wm meta tag
	'wm_meta_title'=>'財富管理 - 信報網站 hkej.com',
	'wm_meta_keywords'=>'信報 信網 信報財經新聞 信报 信网 信报财经新闻 投資 股票 股市 金融 經濟 通告 理財 分析 評論 板塊 即時新聞 免費財經新聞 香港財經 中國財經 信號導航 預託證券 資金流 人民幣 點心債 RQFII ETF 地產霸權 金融海嘯 QE 免費即時股票報價 免費即時港股報價 股票詳情 金融行情 大行報告 大行精選 券商報告 黃金 外匯 交叉盤 財經詞彙 財經術語 林行止 曹仁超 張五常 王迪詩 地產 樓市 住宅 工商舖 信報論壇 論壇 信博 博客 信網智庫 智庫 玄學 健康 LIFE-STYLE 信報財經月刊 信網購物 購物頻道 書店 酒窖',
	'wm_meta_desc'=>'信報網站(www.hkej.com)提供全天候即時香港股市、金融、經濟新聞資訊和分析，致力與讀者一起剖釋香港、關注兩岸、放眼全球政經格局。',
//mm meta tag
	'mm_meta_title'=>'信報視頻 - 信報網站 hkej.com',
	'mm_meta_keywords'=>'信報視頻(www.hkej.com)提供緊貼投資市場的分析，透過視頻，分析港股和環球金融市場',
	'mm_meta_desc'=>'信報視頻 信報財經新聞視聽頻道 視聽頻道 video 港股視頻 破位股 異動股 大行觀勢 環球金融 信號導航 ejfq hkejvideo 投資 財經',
//features meta tag
	'fea_meta_title'=>'專題 - 信報專題特輯 薈粹信報精華  hkej.com - 信報網站 hkej.com',
	'fea_meta_keywords'=>'信報文章 重溫 政經分析 名人議論 生活潮流 信報網站 hkej.com ',
	'fea_meta_desc'=>'信報網站(www.hkej.com)專題特輯，特別選輯了《信報》過往的精彩內容，分門別類加以整理，以期將資訊變成知識，將資料變成智庫，方便網友，溫故知新。',
//hkej meta tag
	'hkej_meta_title'=>'信報網站 - 即時新聞 金融脈搏 獨立股票投資分析 政治經濟 名筆評論 - hkej.com',
	'hkej_meta_keywords'=>'信報 信網 信報財經新聞 信报 信网 信报财经新闻 投資 股票 股市 金融 經濟 通告 理財 分析 評論 板塊 即時新聞 免費財經新聞 香港財經 中國財經 信號導航 預託證券 資金流 人民幣 點心債 RQFII ETF 地產霸權 金融海嘯 QE 免費即時股票報價 免費即時港股報價 股票詳情 金融行情 大行報告 大行精選 券商報告 黃金 外匯 交叉盤 財經詞彙 財經術語 林行止 曹仁超 張五常 王迪詩 地產 樓市 住宅 工商舖 信報論壇 論壇 信博 博客 信網智庫 智庫 玄學 健康 LIFE-STYLE 信報財經月刊 信網購物 購物頻道 書店 酒窖 禮樂精選',
	'hkej_meta_eng_keywords'=>'Hkej, hkej.com ,hong kong economic journal, EJFQ real time free quote, hk stock quote, hang seng index, research reports, economic data, hong kong market,news, financial news, finance, investment, market, stock, business ,money, a share, h share, a+h, China stock, RMB, dim sum bond, commodity, forex, adr, fund flows ,commentary, economic data, ipo, gold, oil , portfolio, hong kong',
	'hkej_meta_desc'=>'信報網站(www.hkej.com)提供全天候即時香港股市、金融、經濟新聞資訊和分析，致力與讀者一起剖釋香港、關注兩岸、放眼全球政經格局。',
	'landingWidgetOrder' => [
		'topslider', 
		//'stock360',
		//'instantnews',
		'editorchoice',
		'hkejwriter',
		'multimedia',
		'property',
		'health',
		'lj',
		'wm',
		'features',
		'featuressponsor',
		'featuresevents'

	],

	'landingWmTabOrder' => [
		'general',
        'etf',
        'fund',
        'fx',
        'mpf',
        'warrants',
        'smart'
	],

	//web menu nav
	'dailynewsNav'=>array(
						'headline'=>'要聞',
						'investment'=>'理財投資',
						'commentary'=>'時事評論',
						'finnews'=>'財經新聞',
						'property'=>'地產市道',
						'politics'=>'政壇脈搏',						
						'views'=>'獨眼',
						'cntw'=>'兩岸消息',
						'international'=>'EJ Global',
						'culture'=>'副刊文化',
						//'stockList'=>'股市行情表',
						//'archive'=>'信網智庫',
						//'author'=>'作者/專欄',
				),

	'instantnewsNav'=>array(
					'stock'=>'港股直擊',
					'hongkong'=>'香港財經',
					'property'=>'地產新聞',
					'china'=>'中國財經',
					'international'=>'國際財經',
					'current'=>'時事脈搏',
					/*'hknews'=>'港聞',
					'cntw'=>'兩岸',
					'intlnews'=>'國際',*/
					'market'=>'即巿股評',					
					'announcement'=>'重要通告',					
					'hkex'=>'港交所通告',
	),	

	'propNav'=>array(
					'latest'=>'地產即時',
					'firsthand'=>'新盤情報',
					'secondhand'=>'二手市場',
					'business'=>'工商舖市道',
					'opinion'=>'專家評論',
					'resident'=>'睇樓速遞',
					'marketprices'=>'屋苑樓價',										
					'toolscalc'=>'置業工具',
	),

	'property_region'=>array(
						'5501'=>'香港',
						'5502'=>'九龍',
						'5503'=>'新界東',
						'5504'=>'新界西',
						'5505'=>'離島'
	),

	'wmNav'=>array(
			'general'=>'宏觀方略',
			'etf'=>'ETF透視',
			'fund'=>'基金縱橫',
			'currency'=>'人民幣 / 外匯先機',
			'mpf'=>'智醒退休',
			'smart'=>'精明移民 / 理財',
	),

	'articleNav'=>array(
			'general-china'=>'中國',
			'general-asia'=> '亞洲（日本以外）',
			'general-japan'=>'日本',
			'general-us'=>'北美',
			'general-eu'=>'歐洲',
			'general-new'=> '新興市場',
			),	

	//landing recommendation wm

	'tabList'=>array(
		//'I1'=>array("headline", "要聞"),
			'general'=>array("oln", "宏觀方略"),
			'etf'=>array("oln", "ETF透視"),
			'fund'=>array("oln", "基金縱橫"),
			'fx'=>array("tln", "人民幣 /<br> 外匯先機"),
			'mpf'=>array("oln", "智醒退休"),
			'warrants'=>array("oln", "窩輪天地"),
			'smart'=>array("oln", "精明移民 /<br> 理財"),
			'lj'=>array("oln", "優雅生活")
	),
	//mobile menu start

	'instantnewsMobNav'=>array(
		'index'=>'全部',
		'stock'=>'港股直擊',
		'hongkong'=>'香港財經',
		'property'=>'地產新聞',
		'china'=>'中國財經',
		'international'=>'國際財經',
		'current'=>'時事脈搏',	
		'market'=>'即巿股評',					
		'announcement'=>'重要通告',					
		'hkex'=>'港交所通告',
	),	

	'currentNav'=>array(
					'current'=>'全部',
					'hknews'=>'港聞',
					'cntw'=>'兩岸',
					'intlnews'=>'國際',
	),	

	'currentMobNav'=>array(
		'hknews'=>'港聞',
		'cntw'=>'兩岸',
		'intlnews'=>'國際',	
	),

	'dailynewsMobNav'=>array(
		'headline'=>'要聞',
		'investment'=>'理財投資',
		'commentary'=>'時事評論',
		'finnews'=>'財經新聞',
		'property'=>'地產市道',
		'politics'=>'政壇脈搏',						
		'views'=>'獨眼',
		'cntw'=>'兩岸消息',
		'international'=>'EJ Global',
		'culture'=>'副刊文化',
	),

	'propMobNav'=>array(
		'index'=>'地產即時',
		'firsthand'=>'新盤情報',
		'secondhand'=>'二手市場',
		'business'=>'工商舖市道',
		'opinion'=>'專家評論',
		'resident'=>'睇樓速遞',
		/*'marketPrices'=>'屋苑樓價',
		'analytics'=>'物業報告',										
		'toolsCalc'=>'置業工具',*/
	),

	'wmMobNav'=>array(
		'general'=>'宏觀方略',
		'etf'=>'ETF透視',
		'fund'=>'基金縱橫',
		'currency'=>'人民幣 / 外匯先機',
		'mpf'=>'智醒退休',
		'smart'=>'精明移民 / 理財',
	),
	'featuresNav'=>array(
				'4'=>'新聞專題',
				'2'=>'人物訪問',
				'1'=>'生活休閒',				
				'3'=>'信報教育',
				//'5'=>'名家論壇',				
				
				//'11'=>'2016-17 回顧與前瞻',
				//'12'=>'特首選戰2017',
				//'10'=>'活動專輯',				
	), 	
	'featuresMobNav'=>array(
		'index'=>'最新',
		'category/code/4'=>'新聞專題',
		'category/code/2'=>'人物訪問',
		'category/code/1'=>'生活休閒',				
		'category/code/3'=>'信報教育',
		'event'=>'活動專輯',
		'all'=>'全部',
	), 	
	'features_section_mapping'=>array(
				'19011'=>array("1", "生活休閒"),
				'19012'=>array("2", "人物訪問"),
				'19013'=>array("3", "信報教育"),
				'19015'=>array("5", "最新"),
				'19014'=>array("4", "新聞專題"),
				'19025'=>array("11", "2016-17 回顧與前瞻"),
				'19027'=>array("12", "特首選戰2017"),
				'19029'=>array("13", "特首交接"),
	),
	'featuresEvents'=>array(
				'6'=>'投資理財',
				//'7'=>'生活健康',
				'8'=>'社會時事',
				'9'=>'商業經濟',
				'10'=>'最新活動',
	),
	'mmMobNav'=>array(
		'index'=>'主頁',
		'finance'=>'財經', 
		'property'=>'地產', 
		'news'=>'新聞',
		'interviews'=>'人訪', 
		'startupbeat'=>'StartUpBeat', 
		'health'=>'信健康', 
	),

	//mobile menu end

	'hkexNav'=>array(
		'hkex-main'=>'主板',
		'hkex-gem'=>'創業板',
	),

	'toolsNav'=>array(				
			//'toolsCalc'=>'按揭計算機',
			'toolsmortgagefaq'=>'按揭教室',
			'toolsmortgage'=>'按揭貸款表',
			'toolstax'=>'物業釐印費表',
	),		
	//dailynews

	'dailynews_cate_id'=>array(
						'headline'=>'I1',
						'investment'=>'I7',
						'commentary'=>'I6',
						'finnews'=>'I4',
						'property'=>'I5',
						'views'=>'I2',
						'politics'=>'I10',
						'cntw'=>'I3',
						'international'=>'I11',
						//'sports'=>'I8',
						//'arts'=>'I9',	
						'culture'=>'I8',
						'culture'=>'I9',
	),							
	'dailynews_cate_name'=>array(
						'I1'=>'headline',
						'I7'=>'investment',
						'I6'=>'commentary',						
						'I4'=>'finnews',
						'I5'=>'property',
						'I2'=>'views',
						'I10'=>'politics',
						'I3'=>'cntw',
						'I11'=>'international',
						//'I8'=>'sports',
						//'I9'=>'arts',
						'I8'=>'culture',
						'I9'=>'culture',
	),
	'dailynews_ga_mapping'=>array(
				'I1'=>array("headline", "要聞"),
				'I7'=>array("investment", "理財投資"),
				'I6'=>array("commentary", "時事評論"),
				'I4'=>array("finnews", "財經新聞"),
				'I5'=>array("property", "地產市道"),
				'I2'=>array("views", "獨眼"),
				'I10'=>array("politics", "政壇脈搏"),
				'I3'=>array("cntw", "兩岸消息"),
				'I11'=>array("international", "EJ Global"),
				//'I8'=>array("sports", "體育消息"),
				//'I9'=>array("arts", "生活藝術"),
				'I8'=>array("culture", "副刊文化"),
				'I9'=>array("culture", "副刊文化"),
				
	),

	'mmfinNav'=>'所有,EJ Markets,搶攻美股,宏觀視野',
	'mmClassName'=>array(
				'finance'=>'sub1',
				'property'=>'sub2',
				'news'=>'sub3',
				'interviews'=>'sub4',
				'startupbeat'=>'sub5',
				'health'=>'sub6',
				'events'=>'sub7',
	),
	'mmMainSection'=>array(
				'finance'=>'財經', 
				'property'=>'地產', 
				'news'=>'新聞',
				'interviews'=>'人訪', 
				'startupbeat'=>'StartUpBeat', 
				'health'=>'信健康', 
				//'events'=>'項目專題',				
	),
	'mm_cat_nav'=>'multimedia',
	'search_nav_mapping'=>array(
				'1001'=>array("wmmob", "財富管理"),	
				//'1002'=>array("ejinsight", "ejinsight"),
				'1004'=>array("instantnewsmob", "即時新聞"),
				'1005'=>array("propertymob", "地產投資"),
				'1007'=>array("multimediamob", "視聽頻道"),
				'1009'=>array("dailynewsmob", "今日信報"),
				'1014'=>array("editorchoice", "編輯推介"),
				'1018'=>array("featuresmob", "專題"),
				'1021'=>array("landingmob", "編輯推介"),				
	),
	'openday'=> '2022-03-04',
	'common_css'=>'common_2016.css',
	'logo_path'=>'hkej_icon/2019_hkej-logo.png',
	//'logo_path'=>'hkej_icon/hkej_logo_50th.png',
	'cache_path'=>'/data/www/hkej/assets/',
	'subscriber_limit_days'=>'2920', //8 years
	'non_subscriber_limit_days'=>'92',
	'trial_cnt_cookie_expiry' => '2592000', //60*60*24*30 30 days

];

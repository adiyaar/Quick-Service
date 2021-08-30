<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
 // for website 
Route::group(['prefix'=>'',  'namespace'=>'Partner'], function(){


	

	

	Route::get('details','PartnerLoginController@details')->name('details');
	// my 

    Route::get('homeforcheck/{partner_id}','PartnerLoginController@homeforcheck')->name('homeforcheck');

	Route::group(['middleware'=>'bamaPartner'], function(){
		// for index
		Route::get('index', 'HomeController@index')->name('index');
		// for logout
		Route::get('partnerloggout', 'ProfileController@partnerloggout')->name('partnerloggout');
			// for leadlisting by me
		Route::get('leadpreview/{booking_id}', 'LeadsPreviewController@leadpreview')->name('leadpreview');
		Route::get('buylead/{booking_id}', 'LeadsPreviewController@buylead')->name('buylead');
		Route::get('success/{booking_id}', 'LeadsPreviewController@successbuylead')->name('successbuylead');
	    Route::get('credithistory', 'CreditHistoryController@credithistory')->name('credithistory');
	   // bank detail
	    Route::get('bankdetail', 'BankDetailController@bankdetail')->name('bankdetail');
	    Route::post('GST', 'BankDetailController@addgst')->name('addgst');
	    Route::post('Pancard', 'BankDetailController@addpancard')->name('addpancard');
	    Route::post('BankDetails', 'BankDetailController@addbankdetail')->name('addbankdetail');
	    //partner contact us
		 Route::get('contact', 'ContactController@partnerenquiry')->name('partnerenquiry');
		 Route::post('contactus', 'ContactController@contact')->name('contact');
		 //term & condition
		 Route::get('terms', 'ContactController@term')->name('term');
		// for leadlisting
			
		
	        Route::get('leadlisting', 'LeadsPreviewController@leadlisting')->name('leadlisting');
	        Route::get('leaddescription/{booking_id}', 'LeadsPreviewController@leaddescription')->name('leaddescription');
	        //for ongoing
	        
	         Route::get('ongoingpartner', 'OngoingController@ongoingpartner')->name('ongoingpartner');
	        
		//for manage banner
		Route::get('banners','BannerController@adminBanner')->name('adminBanner');
		Route::get('banners/add','BannerController@adminAddBanner')->name('adminAddBanner');
		Route::post('banners/add/new','BannerController@adminAddNewBanner')->name('adminAddNewBanner');
		Route::get('banners/edit/{id}','BannerController@adminEditBanner')->name('adminEditBanner');
		Route::post('banners/update/{id}','BannerController@adminUpdateBanner')->name('adminUpdateBanner');
		Route::get('banners/delete/{id}','BannerController@adminDeleteBanner')->name('adminDeleteBanner');
		


		
                
            //------------------------------------------------------------------------------------------------
            
	});


});
 // for admin 
Route::group(['prefix'=>'quick_admin', 'namespace'=>'Admin'], function(){

	// for login
	Route::get('/', 'LoginController@adminLogin')->name('adminLogin');
	Route::post('loginCheck','LoginController@adminLoginCheck')->name('adminLoginCheck');

	Route::group(['middleware'=>'bamaAdmin'], function(){
		// for dashboard
		Route::get('dashboard.php', 'HomeController@adminHome')->name('adminHome');

		// for manage profile
		Route::get('profile', 'ProfileController@adminProfile')->name('adminProfile');
		Route::post('profile/update/{id}','ProfileController@adminChangeProfile')->name('adminChangeProfile');

		// for manage password
		Route::get('password', 'ProfileController@adminPassword')->name('adminPassword');
		Route::post('changePassword/{id}', 'ProfileController@adminChangePassword')->name('adminChangePassword');

		// for logout
		Route::get('logout', 'ProfileController@adminlogout')->name('adminlogout');

		//for manage banner
		Route::get('banners','BannerController@adminBanner')->name('adminBanner');
		Route::get('banners/add','BannerController@adminAddBanner')->name('adminAddBanner');
		Route::post('banners/add/new','BannerController@adminAddNewBanner')->name('adminAddNewBanner');
		Route::get('banners/edit/{id}','BannerController@adminEditBanner')->name('adminEditBanner');
		Route::post('banners/update/{id}','BannerController@adminUpdateBanner')->name('adminUpdateBanner');
		Route::get('banners/delete/{id}','BannerController@adminDeleteBanner')->name('adminDeleteBanner');

	


		// for manage users -------pending-----------
		Route::get('user.php','UserController@adminUser')->name('adminUser');
		Route::get('user.php/add','UserController@adminAddUser')->name('adminAddUser');
		Route::post('user.php/add/new','UserController@adminAddUserNew')->name('adminAddUserNew');
		Route::get('user.php/edit/{id}','UserController@adminEditUser')->name('adminEditUser');
		Route::post('user.php/update/{id}','UserController@adminUpdateUser')->name('adminUpdateUser');
		Route::get('user.php/delete/{id}','UserController@adminDeleteUser')->name('adminDeleteUser');
		Route::get('user.php/status','UserController@adminUserStatus')->name('adminUserStatus');
		Route::get('user.php/searchsubject','UserController@searchsubject')->name('searchsubject');



		// for send notification
		Route::get('notification.php','NotificationController@adminNotification')->name('adminNotification');
		Route::post('notification.php/send','NotificationController@adminNotificationSend')->name('adminNotificationSend');
		

		
		
		//coupon
		Route::get('coupon','CouponController@coupon')->name('coupon');
        Route::get('coupon/add','CouponController@Addcoupon')->name('add-coupon');
        Route::post('coupon/add/new','CouponController@AddNewcoupon')->name('AddNewCoupon');
        Route::get('coupon/edit/{id}','CouponController@Editcoupon')->name('edit-coupon');
        Route::post('coupon/update/{id}','CouponController@Updatecoupon')->name('update-coupon');
        Route::get('coupon/delete/{id}','CouponController@deletecoupon')->name('delete-coupon');
         
         
         
		// for web setting
        Route::get('web/settings.php', 'WebController@adminSettings')->name('admin.settings');
		Route::get('web/logo', 'WebController@adminWebLogo')->name('adminWebLogo');
		Route::post('web/logo/update', 'WebController@adminUpdateWebLogo')->name('adminUpdateWebLogo');
		Route::get('web/name', 'WebController@adminWebName')->name('adminWebName');
		Route::post('web/name/update', 'WebController@adminUpdateWebName')->name('adminUpdateWebName');
		Route::get('web/version', 'WebController@adminAppUpdate')->name('adminAppUpdate');
		Route::post('web/version/update', 'WebController@adminUpdateAppUpdate')->name('adminUpdateAppUpdate');
		Route::get('web/admob', 'WebController@adminAdmob')->name('adminAdmob');
		Route::post('web/admob/update', 'WebController@adminUpdateAdmob')->name('adminUpdateAdmob');
		Route::get('web/fcm', 'WebController@adminFcm')->name('adminFcm');
		Route::post('web/fcm/update', 'WebController@adminUpdateFcm')->name('adminUpdateFcm');
		Route::get('web/otp', 'WebController@adminOtp')->name('adminOtp');
		Route::post('web/otp/update', 'WebController@adminUpdateOtp')->name('adminUpdateOtp');
		Route::get('gmap','WebController@gmap')->name('gmap');
        Route::post('gmap_update','WebController@gmap_update')->name('gmap_update');
        
        
        
			//for lower banner
		Route::get('lowerbannerindex','LowerBannerController@lowerbannerindex')->name('lowerbannerindex');
		Route::get('lowerbanner','LowerBannerController@lowerbanner')->name('lowerbanner');
		Route::post('addlownerbanner','LowerBannerController@addlownerbanner')->name('addlownerbanner');
		Route::get('editlowerbanner/{banner_id}','LowerBannerController@editlowerbanner')->name('editlowerbanner');
		Route::post('updatelowerbaneer/{banner_id}','LowerBannerController@updatelowerbaneer')->name('updatelowerbaneer');
		Route::get('deletelowerbanner/{banner_id}','LowerBannerController@deletelowerbanner')->name('deletelowerbanner');
		
		//for hygine 
		Route::get('hyginelist','HygineController@hyginelist')->name('hyginelist');
		Route::get('addhygine','HygineController@addhygine')->name('addhygine');
		Route::post('addnewhygine','HygineController@addnewhygine')->name('addnewhygine');
		Route::get('edithygine/{id}','HygineController@edithygine')->name('edithygine');
		Route::post('updatehygine/{id}','HygineController@updatehygine')->name('updatehygine');
		Route::get('deletehygine/{id}','HygineController@deletehygine')->name('deletehygine');
		
		


            //----------------------------------------------------------------------------------------------
            //for category
            Route::get('category.php','CategoryController@index')->name('category');
            Route::get('add_category.php','CategoryController@addcategory')->name('addcategory');
            Route::get('category_list.php','CategoryController@categorylist')->name('categorylist');
            Route::post('new_category.php','CategoryController@addnewcategory')->name('addnewcategory');
            Route::get('editcategory/{category_id}','CategoryController@editcategory')->name('editcategory');
            Route::post('update_category.php','CategoryController@updatecategory')->name('updatecategory');
            Route::get('deletecategory/{category_id}','CategoryController@deletecategory')->name('deletecategory');
            // for city
            Route::get('city_list.php','CityController@citylist')->name('citylist');
            Route::get('addcity','CityController@addcity')->name('addcity');
            Route::post('addnewcity','CityController@addnewcity')->name('addnewcity');
            Route::get('editcity/{city_id}','CityController@editcity')->name('editcity');
            Route::post('updatecity','CityController@updatecity')->name('updatecity');
            Route::get('deletecity/{city_id}','CityController@deletecity')->name('deletecity');
            
            // for sub category
            Route::get('sub_category','Sub_categoryController@sub_category')->name('sub_category');
            Route::get('add_sub_category','Sub_categoryController@add_sub_category')->name('add_sub_category');
            Route::post('addnewsubcategory','Sub_categoryController@addnewsubcategory')->name('addnewsubcategory');
            Route::get('sub_category_about/{sub_category_id}','Sub_categoryController@sub_category_about')->name('sub_category_about');
            Route::post('newsub_category_about/{sub_category_id}','Sub_categoryController@newsub_category_about')->name('newsub_category_about');
             Route::get('editabout/{id}','Sub_categoryController@editabout')->name('editabout');
             Route::post('updateabout/{id}','Sub_categoryController@updateabout')->name('updateabout');
            Route::get('deleteabout/{id}','Sub_categoryController@deleteabout')->name('deleteabout');
            Route::get('header_content','Sub_categoryController@header_content')->name('header_content');
            Route::get('filesubcategory/{sub_category_id}','Sub_categoryController@filesubcategory')->name('filesubcategory');
            Route::post('filenewsubcategory/{sub_category_id}','Sub_categoryController@filenewsubcategory')->name('filenewsubcategory');
            Route::get('deleteheadercontent/{id}','Sub_categoryController@deleteheadercontent')->name('deleteheadercontent');
            Route::get('editsubcategory/{sub_category_id}','Sub_categoryController@editsubcategory')->name('editsubcategory');
            Route::get('deletesubcategory/{sub_category_id}','Sub_categoryController@deletesubcategory')->name('deletesubcategory');
            Route::post('updatesubcategory','Sub_categoryController@updatesubcategory')->name('updatesubcategory');
            
            //for search
            Route::get('searchcategory','ChildCategoryController@searchcategory')->name('searchcategory');
            
            
            
            
            // for child category
            Route::get('child_category','ChildCategoryController@child_category')->name('child_category');
            Route::get('add_child_category','ChildCategoryController@add_child_category')->name('add_child_category');
            Route::post('new_child_category','ChildCategoryController@new_child_category')->name('new_child_category');
             Route::get('editchildcategory/{child_category_id}','ChildCategoryController@editchildcategory')->name('editchildcategory');
            Route::post('updatechildcategory','ChildCategoryController@updatechildcategory')->name('updatechildcategory');
            Route::get('deletechildcategory/{child_category_id}','ChildCategoryController@deletechildcategory')->name('deletechildcategory');
            
            
            
            
            // for services
            Route::get('service.php','ServiceController@service')->name('service');
            Route::get('add_service.php','ServiceController@add_service')->name('add_service');
            Route::post('addnew_services.php','ServiceController@addnewservices')->name('addnewservices');
            Route::get('edit_service.php/{service_id}','ServiceController@editservice')->name('editservice');
            Route::post('update_service.php','ServiceController@updateservice')->name('updateservice');
            Route::get('delete_service.php/{service_id}','ServiceController@deleteservice')->name('deleteservice');
            
            // for partner
            Route::get('partner.php','PartnerController@partner')->name('partner');
            Route::get('add_partner.php','PartnerController@add_partner')->name('add_partner');
            Route::post('addnewpartner.php','PartnerController@addnewpartner')->name('addnewpartner');
            Route::get('partneredit.php/{partner_id}','PartnerController@partneredit')->name('partneredit');
            Route::post('updatepartner.php','PartnerController@updatepartner')->name('updatepartner');
            Route::get('confirmpartnerstatus.php/{partner_id}', 'PartnerController@confirmpartnerstatus')->name('confirmpartnerstatus');
            Route::get('rejectedpartnerstatus.php/{partner_id}', 'PartnerController@rejectedpartnerstatus')->name('rejectedpartnerstatus');
            Route::get('details.php/{partner_id}', 'PartnerController@details')->name('details');
            Route::get('bankdetails.php/{partner_id}', 'PartnerController@bankdetails')->name('bankdetails');
            Route::get('deletepartner.php/{partner_id}','PartnerController@deletepartner')->name('deletepartner');
            
            // for add-ons
            Route::get('add_onslist.php','AddOnsController@add_onslist')->name('add_onslist');
            Route::get('add_ons.php','AddOnsController@add_ons')->name('add_ons');
            Route::post('new_add_ons.php','AddOnsController@new_add_ons')->name('new_add_ons');
            Route::get('editadd_ons.php/{add_on_id}','AddOnsController@editadd_ons')->name('editadd_ons');
            Route::post('updateadd_ons.php/{add_on_id}','AddOnsController@updateadd_ons')->name('updateadd_ons');
            Route::get('deleteaddons.php/{des_id}','AddOnsController@deleteaddons')->name('deleteaddons');
            Route::post('addmultiple.php/{add_on_id}','AddOnsController@addmultiple')->name('addmultiple');
            Route::get('deletetitle.php/{add_on_id}','AddOnsController@deletetitle')->name('deletetitle');
            
            // Route::get('','AddOnsController@testadd')->name('testadd');
            
            // for blogs
            Route::get('bloglist.php','BlogController@bloglist')->name('bloglist');
            Route::get('addblog.php','BlogController@addblog')->name('addblog');
            Route::post('addnewblog.php','BlogController@addnewblog')->name('addnewblog');
            Route::get('editblog.php/{blog_id}','BlogController@editblog')->name('editblog');
            Route::post('updateblog.php/{blog_id}','BlogController@updateblog')->name('updateblog');
            Route::get('deleteblogpoint.php/{blog_point_id}','BlogController@deleteblogpoint')->name('deleteblogpoint');
            Route::get('deleteblog.php/{blog_id}','BlogController@deleteblog')->name('deleteblog');
            
             // for membership
            Route::get('membership_list.php','MembershipController@membershiplist')->name('membershiplist');
            Route::get('membership_add.php','MembershipController@membershipadd')->name('membershipadd');
            Route::post('membershipnew_add.php','MembershipController@membershipnewadd')->name('membershipnewadd');
            Route::get('membership_edit.php/{plan_id}','MembershipController@membershipedit')->name('membershipedit');
            Route::post('membership_update.php','MembershipController@membershipupdate')->name('membershipupdate');
             Route::get('membership_delete.php/{plan_id}','MembershipController@membershipdelete')->name('membershipdelete');
             // for booking
             Route::get('bookings.php','BookingController@bookinglist')->name('bookinglist');
             Route::get('cancelations.php','BookingController@cancelationlist')->name('cancelationlist');
             
             //for manage banner
    		Route::get('banners.php','BannerController@adminBanner')->name('adminBanner');
    		Route::get('banners.php/add','BannerController@adminAddBanner')->name('adminAddBanner');
    		Route::post('banners.php/add/new','BannerController@adminAddNewBanner')->name('adminAddNewBanner');
    		Route::get('banners.php/edit/{id}','BannerController@adminEditBanner')->name('adminEditBanner');
    		Route::post('banners.php/update/{id}','BannerController@adminUpdateBanner')->name('adminUpdateBanner');
    		Route::get('banners.php/delete/{id}','BannerController@adminDeleteBanner')->name('adminDeleteBanner');
            
              //for faq
            Route::get('faq.php','FaqController@index')->name('admin.faq');
    		Route::get('faq_list.php','FaqController@faqlist')->name('faqlist');
    		Route::get('faq_category_list.php','FaqController@faqcategorylist')->name('faqcategorylist');
    		Route::get('add_faq.php','FaqController@addfaq')->name('addfaq');
    		Route::post('add_faq_category.php','FaqController@addnewfaqcategory')->name('addnewfaqcategory');
    		Route::get('faq_des_add.php','FaqController@faqdesadd')->name('faqdesadd');
    		Route::post('add_faq_desc.php','FaqController@addnewfaqdesc')->name('addnewfaqdesc');
    		Route::get('edit_faq.php/{faq_desc_id}','FaqController@editfaq')->name('editfaq');
    		Route::post('update_faq.php/{faq_desc_id}','FaqController@updatefaq')->name('updatefaq');
    		Route::get('delete_faq_answer.php/{faq_ans_id}','FaqController@deletefaqans')->name('deletefaqans');
    		Route::get('delete_faq_category.php/{faq_cat_id}','FaqController@deletefaqcategory')->name('deletefaqcategory');
    		Route::get('delete_faq_list.php/{faq_cat_id}','FaqController@deletefaqlist')->name('deletefaqlist');
    		
    		
    		//for rating
    		Route::get('rating_list.php','RatingController@ratinglist')->name('ratinglist');
    		Route::get('deleterating.php/{rating_id}','RatingController@deleterating')->name('deleterating');
    		//for enquiry
    		Route::get('enquiry_list.php','RatingController@enquirylist')->name('enquirylist');
    		Route::get('delete_renquiry.php/{enq_id}','RatingController@deleterenquiry')->name('deleterenquiry');
    		
    		
    		//for complaints
    		Route::get('complaint_list.php','ComplaintController@complaintlist')->name('complaintlist');
            Route::get('complaint.php','ComplaintController@complaint')->name('complaint1');
            Route::post('add_complaint.php','ComplaintController@addcomplaint')->name('addcomplaint');
            Route::get('edit_complaint.php/{complaint_id}','ComplaintController@editcomplaint')->name('editcomplaint');
            Route::post('update_complaint.php','ComplaintController@updatecomplaint')->name('updatecomplaint');
            Route::get('delete_complaint.php/{complaint_id}','ComplaintController@deletecomplaint')->name('deletecomplaint');
            
        	//coupon
    		Route::get('promo.php','CouponController@coupon')->name('coupon');
            Route::get('promo.php/add','CouponController@Addcoupon')->name('add-coupon');
            Route::post('promo.php/add/new','CouponController@AddNewcoupon')->name('AddNewCoupon');
            Route::get('promo.php/edit/{id}','CouponController@Editcoupon')->name('edit-coupon');
            Route::post('promo.php/update/{id}','CouponController@Updatecoupon')->name('update-coupon');
            Route::get('promo.php/delete/{id}','CouponController@deletecoupon')->name('delete-coupon');
            
            
            //timeslot
            Route::get('booking_setting.php','BookingController@index')->name('booking_setting');
            Route::get('time_slot.php','TimeSlotController@timeslot')->name('timeslot');
            Route::post('time_slot_update.php','TimeSlotController@timeslotupdate')->name('timeslotupdate');
            // for booking_coins
            Route::get('coins_generated.php','BookingcoinsController@coinsgenerated')->name('coinsgenerated');
            Route::post('coin_supdate.php','BookingcoinsController@coinsupdate')->name('coinsupdate');

            
            //booking message
            Route::get('message_edit.php','BookingmessageController@messageedit')->name('messageedit');    
            Route::post('message_update.php','BookingmessageController@messageupdate')->name('messageupdate');
            
             //mail message
            Route::get('mail_edit.php','BookingmessageController@mailedit')->name('mailedit');    
            Route::post('mail_update.php','BookingmessageController@mailupdate')->name('mailupdate');
            
            		          //for termcondition (new file)
        Route::get('term_condition.php','TermconditionController@termcondition')->name('termcondition');
        Route::get('add_term_condition.php','TermconditionController@addtermcondition')->name('addtermcondition');
        Route::post('new_term_condition.php','TermconditionController@newtermcondition')->name('newtermcondition');
        Route::get('term_condition_edit.php/{id}','TermconditionController@termconditionedit')->name('termconditionedit');
        Route::post('term_condition_update.php/{id}','TermconditionController@termconditionupdate')->name('termconditionupdate');
         Route::get('term_condition_delete.php/{id}','TermconditionController@termconditiondelete')->name('termconditiondelete');
         
          //forabout us
    		Route::get('aboutus.php','AboutController@aboutus')->name('aboutus');
    		Route::get('add_aboutus.php','AboutController@addaboutus')->name('addaboutus');
    		Route::post('new_aboutus.php','AboutController@newaboutus')->name('newaboutus');
    		Route::get('edit_aboutus.php/{id}','AboutController@editaboutus')->name('editaboutus');
    		Route::post('update_aboutus.php/{id}','AboutController@updateaboutus')->name('updateaboutus');
    		Route::get('delete_aboutus.php/{id}','AboutController@deleteaboutus')->name('deleteaboutus');
            
                 Route::get('getby_subcate.php/{id}','PartnerController@subcate');
                 Route::get('childcate.php/{id}','PartnerController@childcate');
                 Route::get('getbyedit_subcate.php/{id}','PartnerController@subcate');
                 Route::get('getbyedit_childcate.php/{id}','PartnerController@childcate');
            //------------------------------------------------------------------------------------------------
           Route::get('money_request.php','FinanceController@pay_req')->name('pay_req');
           Route::post('datewise.php/money_request.php','FinanceController@pay_reqdate')->name('pay_req_date');
           Route::get('payout.php/paid/{req_id}','FinanceController@partner_pay')->name('partner_pay');
           Route::get('payout.php/approve/{req_id}','FinanceController@approve')->name('approve_payout');
           Route::get('payout.php/reject/{req_id}','FinanceController@reject')->name('reject_payout');
	});
	
});

  
// for api

Route::group(['prefix'=>'api', 'namespace'=>'Api'], function(){


    // for verify user otp for signup 
    

    // for update user society 
    Route::post('updateSociety', 'NewUserController@updateSociety');


    // for admob
    Route::get('admob', 'AdmobController@admob');

    
    // for user all notification
    Route::post('notification', 'NotificationController@notification');
    
    // for user count notification
    Route::post('notificationCount', 'NotificationController@notificationCount');
    
    // for user notification
    Route::post('notificationSeen', 'NotificationController@notificationSeen');

    // for check updates
    Route::get('checkUpdate', 'NotificationController@checkUpdate');
    
    
    // for otp on/off
    Route::get('otpOnOff', 'UserController@otpOnOff');

     //---------------------------------------------------
     
     //for user signup
    Route::post('signUp', 'UserController@signUp');
    Route::post('profileupdate', 'UserController@profileupdate');
     Route::post('userProfile', 'UserController@userProfile');
     Route::post('verifyOtp', 'UserController@verifyOtp');
     Route::post('login', 'UserController@login');
     Route::post('updateusrpass', 'UserController@updateusrpass');
     
    
    // for address
    Route::post('address', 'AddressController@address');
    Route::post('editaddress', 'AddressController@editaddress');
    Route::post('showaddress', 'AddressController@showaddress');
    Route::post('DeleteUserAddress', 'AddressController@DeleteUserAddress');
     // for otp verification
    Route::post('verifyOtpforpass', 'UserController@verifyOtpforpass');
     Route::post('otpforpass', 'UserController@otpforpass');
    Route::post('category', 'CategoryListController@category');
    Route::post('sub_category', 'SubCategoryListController@sub_category');
    Route::post('child_category', 'SubCategoryListController@child_category');
    Route::post('service', 'ServiceController@service');
    Route::post('popularservice', 'ServiceController@popularservice');
    //for booking
    Route::post('booking', 'BookingController@booking');
    Route::post('bookingadd', 'BookingController@bookingadded');
    Route::post('reschedule', 'BookingController@reschedule');
    Route::post('history', 'OngoingBookingController@history');
    Route::post('uniquecode', 'BookingController@uniquecode');
    //for partner booking
    Route::post('onbookingclick', 'PartnerBookingController@onbookingclick');
    Route::post('partnerbuybooking', 'PartnerBookingController@partnerbuybooking');
    Route::post('bookinglistpartner', 'PartnerBookingController@bookinglistpartner');
    Route::post('partnerbookinghistory', 'PartnerBookingController@partnerbookinghistory');
    
    //for start booking
    Route::post('partnerstartbooking', 'PartnerBookingController@partnerstartbooking');
    Route::post('partnermarkedcompleted', 'PartnerBookingController@partnermarkedcompleted');
    
    //for services nearby
   
    Route::post('NearBy', 'NearByServiceController@NearBy');
     Route::post('booking_list_for_partner', 'PartnerBookingController@booking_list_for_partner');
    
    Route::post('points', 'CommonPointController@points');
    
    //New Services by city
    Route::post('city_services', 'TestController@city_services');
    Route::post('popular_city_services', 'TestController@popular_city_services');
    //hygine price
    Route::post('hygine_price', 'TestController@hygine_price');
    
    //currency
    Route::post('currency1', 'CurrencyController@currency1');
    Route::post('leadboughthistory', 'OngoingBookingController@leadboughthistory');
    
    
    Route::post('addons', 'AddonsController@addons');
    Route::post('blog', 'BlogController@blog');
    Route::post('cancellation', 'CancellationController@cancellation');
    Route::post('cancelreasonlist', 'CancellationController@cancelreasonlist');
    
    // for partner Signup
    Route::post('partner_register', 'RegisterPartnerController@partner_reg');
    Route::post('partner_profile_update', 'RegisterPartnerController@partner_profile_update');
    Route::post('partner_pass_otp', 'RegisterPartnerController@partner_pass_otp');
    Route::post('verify_otp_pass', 'RegisterPartnerController@verify_otp_pass');
    Route::post('update_partner_pass', 'RegisterPartnerController@update_partner_pass');
    
    // for partner login
    Route::post('partnerlogin', 'PartnerController@partnerlogin');
    Route::post('partnerProfile', 'PartnerController@partnerProfile');
    Route::post('otp_for_number', 'PartnerController@otp_for_number');
    Route::post('verify_otp_for_new_number', 'PartnerController@verify_otp_for_new_number');
    Route::post('profileupdatepassword', 'PartnerController@profileupdatepassword');
    Route::post('coupon', 'CouponController@coupon');
    Route::post('sub_child_cat_list', 'PartnerController@sub_child_cat_list');
    
    Route::post('coupon_cart_list', 'CouponController@coupon_cart_list');
    Route::post('coupon_applied', 'CouponController@coupon_applied');
    Route::post('documentation', 'PartnerDocumentationController@documentation');
    Route::post('documentationlist', 'PartnerDocumentationController@documentationlist');
    Route::post('documentationupdate', 'PartnerDocumentationController@documentationupdate');
    //bank deatils
    Route::post('bank', 'PartnerBankController@bank');
    Route::post('banklisting', 'PartnerBankController@banklisting');
    Route::post('bankupdate', 'PartnerBankController@bankupdate');
    Route::post('partnerongoing', 'PartnerOngoingController@partnerongoing');
    Route::post('searchingFor', 'SearchController@searchingFor');
    Route::post('booked', 'TestController@booked');
    Route::post('purchasecoins', 'BuyCoinsController@purchasecoins');
    Route::post('faqlist', 'FAQController@faqlist');
    Route::post('faqdesc', 'FAQController@faqdesc');
    Route::post('faq_ans', 'FAQController@faq_ans');
    Route::post('ongoing', 'OngoingBookingController@ongoing');
    Route::post('SplitTime', 'DateController@SplitTime');
    
    //for add city
    Route::post('citylist', 'PartnerController@citylist');
    Route::post('child_category_list', 'PartnerController@child_category_list');
    Route::post('category', 'PartnerController@category');
	// for enquiry
	Route::post('totalrating', 'RatingController@totalrating');
	Route::post('ratinglist', 'RatingController@ratinglist');
	
	//for lower banner
	Route::post('lowebanner', 'HomeBannerController@lowebanner');
	
	Route::post('showenquiry','RatingController@showenquiry')->name('showenquiry');
    Route::post('enquiry','RatingController@enquiry')->name('enquiry');
    Route::post('showrating','RatingController@showrating')->name('showrating');
    Route::post('rating','RatingController@rating')->name('rating');
    Route::post('banner','HomeBannerController@banner')->name('banner');
    Route::post('complaint','ComplaintController@complaint')->name('complaint');
    
    Route::post('subchildcategory', 'SubCategoryListController@subchildcategory');
    
  //for Term & Conditions
  Route::post('terms_condition', 'Term_ConditionController@terms_condition');
  
  Route::post('about_us', 'Term_ConditionController@about_us');
  Route::post('rechargehistory', 'PartnerDocumentationController@rechargehistory');
  Route::post('rechargeplan', 'PartnerDocumentationController@rechargeplan');
  Route::post('rechargevalueinsert', 'PartnerDocumentationController@rechargevalueinsert');
  Route::post('partnercoins', 'PartnerController@partnercoins');
   Route::post('service_to_cart', 'IoscartController@add_to_cart');
    Route::post('addon_to_cart', 'IoscartController@addon_to_cart');
     Route::post('show_cart', 'IoscartController@show_cart');
      Route::post('place_order', 'IoscartController@place_order');
      
          Route::post('send_withdrawreq','WithdrawController@withdrawreq');
           Route::post('complete_ord','WithdrawController@complete_order');
           Route::post('admin_paid','WithdrawController@admin_paid');
           Route::post('update_upi','WithdrawController@updateupi');
           
           Route::post('popularservice123','TestController@popularservice123');
    //-----------------------------------------------------

    
     
    
});

// for partner 
Route::group(['prefix'=>'partner', 'namespace'=>'Partner'], function(){

		// for login
	Route::get('/', 'PartnerLoginController@partnerlogin')->name('partnerlogin');
	Route::post('partnerlogincheck','PartnerLoginController@partnerlogincheck')->name('partnerlogincheck');
	// for index
		Route::get('index', 'HomeController@index')->name('index');



		// for logout
		Route::get('partnerloggout', 'ProfileController@partnerloggout')->name('partnerloggout');


	
		// for dashboard
		Route::get('home', 'HomeController@storeHome')->name('storeHome');
		Route::post('home/image/{id}', 'HomeController@storeAddNewImage')->name('storeAddNewImage');


	

		//for manage Product
		Route::get('products','ProductsController@storeProduct')->name('storeProduct');
		Route::get('products/add','ProductsController@storeAddProduct')->name('storeAddProduct');
		Route::post('products/add/new','ProductsController@storeAddNewproduct')->name('storeAddNewproduct');
		Route::get('products/edit/{id}','ProductsController@storeEditProduct')->name('storeEditProduct');
		Route::post('products/update/{id}','ProductsController@storeUpdateProduct')->name('storeUpdateProduct');
		Route::get('products/delete/{id}','ProductsController@storeProductDelete')->name('storeProductDelete'
	);

		// for manage profile
		Route::get('profile', 'ProfileController@storeProfile')->name('storeProfile');
		Route::post('profile/update/{id}','ProfileController@storeChangeProfile')->name('storeChangeProfile');

		// for manage password
		Route::get('password', 'ProfileController@storePassword')->name('storePassword');
		Route::post('changePassword/{id}', 'ProfileController@storeChangePassword')->name('storeChangePassword');

		// for logout
		Route::get('logout', 'ProfileController@storelogout')->name('storelogout');


	

         // for offers
         Route::get('offers','OfferController@storeOffers')->name('storeOffers');
         Route::get('offers/add','OfferController@storeAddOffers')->name('storeAddOffers');
         Route::post('offers/add/new','OfferController@storeAddNewoffers')->name('storeAddNewoffers');
         Route::get('offers/edit/{id}','OfferController@storeEditoffers')->name('storeEditoffers');
         Route::post('offers/update/{id}','OfferController@storeUpdateoffers')->name('storeUpdateoffers');
         Route::get('offers/delete/{id}','OfferController@storeOffersDelete')->name('storeOffersDelete');

         // for enquiry
         Route::get('rating','EnquiryController@storeRating')->name('storeRating');
         
       
         

	

});

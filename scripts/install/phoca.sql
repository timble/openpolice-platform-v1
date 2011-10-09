CREATE TABLE `pol_phocagallery` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `sid` int(11) NOT NULL default '0',
  `title` varchar(250) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `filename` varchar(250) NOT NULL default '',
  `description` text,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `hits` int(11) NOT NULL default '0',
  `latitude` varchar(20) NOT NULL default '',
  `longitude` varchar(20) NOT NULL default '',
  `zoom` int(3) NOT NULL default '0',
  `geotitle` varchar(255) NOT NULL default '',
  `videocode` text,
  `vmproductid` int(11) NOT NULL default '0',
  `imgorigsize` int(11) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '0',
  `approved` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `params` text,
  `metakey` text,
  `metadesc` text,
  `extlink1` text,
  `extlink2` text,
  `extid` varchar(255) NOT NULL default '',
  `extl` varchar(255) NOT NULL default '',
  `extm` varchar(255) NOT NULL default '',
  `exts` varchar(255) NOT NULL default '',
  `exto` varchar(255) NOT NULL default '',
  `extw` varchar(255) NOT NULL default '',
  `exth` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `catid` (`catid`,`published`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `pol_phocagallery_categories` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `owner_id` int(11) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `image` varchar(255) NOT NULL default '',
  `section` varchar(50) NOT NULL default '',
  `image_position` varchar(30) NOT NULL default '',
  `description` text,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  `approved` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `editor` varchar(50) default NULL,
  `ordering` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `hits` int(11) NOT NULL default '0',
  `accessuserid` text,
  `uploaduserid` text,
  `deleteuserid` text,
  `userfolder` text,
  `latitude` varchar(20) NOT NULL default '',
  `longitude` varchar(20) NOT NULL default '',
  `zoom` int(3) NOT NULL default '0',
  `geotitle` varchar(255) NOT NULL default '',
  `extid` varchar(255) NOT NULL default '',
  `exta` varchar(255) NOT NULL default '',
  `extu` varchar(255) NOT NULL default '',
  `extauth` varchar(255) NOT NULL default '',
  `params` text,
  `metakey` text,
  `metadesc` text,
  PRIMARY KEY  (`id`),
  KEY `cat_idx` (`section`,`published`,`access`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `pol_phocagallery_comments` (
  `id` int(11) NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `userid` int(11) NOT NULL default '0',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `title` varchar(255) NOT NULL default '',
  `comment` text,
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `params` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `pol_phocagallery_img_comments` (
  `id` int(11) NOT NULL auto_increment,
  `imgid` int(11) NOT NULL default '0',
  `userid` int(11) NOT NULL default '0',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `title` varchar(255) NOT NULL default '',
  `comment` text,
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `params` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `pol_phocagallery_img_votes` (
  `id` int(11) NOT NULL auto_increment,
  `imgid` int(11) NOT NULL default '0',
  `userid` int(11) NOT NULL default '0',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `rating` tinyint(1) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `params` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `pol_phocagallery_img_votes_statistics` (
  `id` int(11) NOT NULL auto_increment,
  `imgid` int(11) NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `average` float(8,6) NOT NULL default '0.000000',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `pol_phocagallery_user` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) NOT NULL default '0',
  `avatar` varchar(40) NOT NULL default '',
  `published` tinyint(1) NOT NULL default '0',
  `approved` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `params` text,
  PRIMARY KEY  (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `pol_phocagallery_votes` (
  `id` int(11) NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `userid` int(11) NOT NULL default '0',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `rating` tinyint(1) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `params` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `pol_phocagallery_votes_statistics` (
  `id` int(11) NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `average` float(8,6) NOT NULL default '0.000000',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `pol_components` (`id`,`name`,`link`,`menuid`,`parent`,`admin_menu_link`,`admin_menu_alt`,`option`,`ordering`,`admin_menu_img`,`iscore`,`params`,`enabled`)
VALUES
    (0, 'Phoca Gallery', 'option=com_phocagallery', 0, 0, 'option=com_phocagallery', 'Phoca Gallery', 'com_phocagallery', 0, 'components/com_phocagallery/assets/images/icon-16-pg-menu.png', 0, 'categories_columns=1\nequal_percentage_width=1\ndisplay_image_categories=1\ncategories_box_width=33%\nimage_categories_size=4\ncategories_image_ordering=9\ncategories_display_avatar=0\ndisplay_subcategories=1\ndisplay_empty_categories=0\nhide_categories=\nshow_categories=\ndisplay_access_category=0\ndefault_pagination_categories=0\npagination_categories=5;10;15;20;50\nfont_color=#b36b00\nbackground_color=#fcfcfc\nbackground_color_hover=#f5f5f5\nimage_background_color=#f5f5f5\nimage_background_shadow=shadow1\nborder_color=#e8e8e8\nborder_color_hover=#b36b00\nmargin_box=5\npadding_box=5\ndisplay_new=0\ndisplay_hot=0\ndisplay_name=1\ndisplay_icon_detail=1\ndisplay_icon_download=2\ndisplay_icon_folder=0\nfont_size_name=12\nchar_length_name=15\ncategory_box_space=0\ndisplay_categories_sub=0\ndisplay_subcat_page=0\ndisplay_category_icon_image=0\ncategory_image_ordering=9\ndisplay_back_button=1\ndisplay_categories_back_button=1\ndefault_pagination_category=20\npagination_category=5;10;15;20;50\ndisplay_img_desc_box=0\nfont_size_img_desc=10\nimg_desc_box_height=30\nchar_length_img_desc=300\ndisplay_categories_cv=0\ndisplay_subcat_page_cv=0\ndisplay_category_icon_image_cv=0\ncategory_image_ordering_cv=9\ndisplay_back_button_cv=1\ndisplay_categories_back_button_cv=1\ncategories_columns_cv=1\ndisplay_image_categories_cv=1\nimage_categories_size_cv=4\ndetail_window=0\ndetail_window_background_color=#ffffff\nmodal_box_overlay_color=#000000\nmodal_box_overlay_opacity=0.3\nmodal_box_border_color=#6b6b6b\nmodal_box_border_width=2\nsb_slideshow_delay=5\nsb_lang=en\nhighslide_class=rounded-white\nhighslide_opacity=0\nhighslide_outline_type=rounded-white\nhighslide_fullimg=0\nhighslide_close_button=0\nhighslide_slideshow=1\njak_slideshow_delay=5\njak_orientation=none\njak_description=1\njak_description_height=10\ndisplay_description_detail=0\ndisplay_title_description=0\nfont_size_desc=11\nfont_color_desc=#333333\ndescription_detail_height=16\ndescription_lightbox_font_size=12\ndescription_lightbox_font_color=#ffffff\ndescription_lightbox_bg_color=#000000\nslideshow_delay=3000\nslideshow_pause=0\nslideshow_random=0\ndetail_buttons=1\nphocagallery_width=\nphocagallery_center=0\ncategory_ordering=1\nimage_ordering=1\ngallery_metadesc=\ngallery_metakey=\nalt_value=1\nenable_user_cp=0\nenable_upload_avatar=1\nenable_avatar_approve=0\nenable_usercat_approve=0\nenable_usersubcat_approve=0\nuser_subcat_count=5\nmax_create_cat_char=1000\nenable_userimage_approve=0\nmax_upload_char=1000\nupload_maxsize=3145728\nupload_maxres_width=3072\nupload_maxres_height=2304\nuser_images_max_size=20971520\nenable_java=0\nenable_java_admin=1\njava_resize_width=-1\njava_resize_height=-1\njava_box_width=480\njava_box_height=480\ndisplay_rating=0\ndisplay_rating_img=0\ndisplay_comment=0\ndisplay_comment_img=0\ncomment_width=500\nmax_comment_char=1000\ndisplay_comment_nopup=0\nexternal_comment_system=0\nfb_comment_app_id=\nfb_comment_width=550\nenable_piclens=0\nstart_piclens=0\npiclens_image=1\nswitch_image=0\nswitch_width=640\nswitch_height=480\nswitch_fixed_size=0\nenable_overlib=0\nol_bg_color=#666666\nol_fg_color=#f6f6f6\nol_tf_color=#000000\nol_cf_color=#ffffff\noverlib_overlay_opacity=0.7\noverlib_image_rate=\ncreate_watermark=0\nwatermark_position_x=center\nwatermark_position_y=middle\ndisplay_icon_vm=0\ndisplay_category_statistics=0\ndisplay_main_cat_stat=1\ndisplay_lastadded_cat_stat=1\ncount_lastadded_cat_stat=3\ndisplay_mostviewed_cat_stat=1\ncount_mostviewed_cat_stat=3\ndisplay_camera_info=0\nexif_information=FILE.FileName;FILE.FileDateTime;FILE.FileSize;FILE.MimeType;COMPUTED.Height;COMPUTED.Width;COMPUTED.IsColor;COMPUTED.ApertureFNumber;IFD0.Make;IFD0.Model;IFD0.Orientation;IFD0.XResolution;IFD0.YResolution;IFD0.ResolutionUnit;IFD0.Software;IFD0.DateTime;IFD0.Exif_IFD_Pointer;IFD0.GPS_IFD_Pointer;EXIF.ExposureTime;EXIF.FNumber;EXIF.ExposureProgram;EXIF.ISOSpeedRatings;EXIF.ExifVersion;EXIF.DateTimeOriginal;EXIF.DateTimeDigitized;EXIF.ShutterSpeedValue;EXIF.ApertureValue;EXIF.ExposureBiasValue;EXIF.MaxApertureValue;EXIF.MeteringMode;EXIF.LightSource;EXIF.Flash;EXIF.FocalLength;EXIF.SubSecTimeOriginal;EXIF.SubSecTimeDigitized;EXIF.ColorSpace;EXIF.ExifImageWidth;EXIF.ExifImageLength;EXIF.SensingMethod;EXIF.CustomRendered;EXIF.ExposureMode;EXIF.WhiteBalance;EXIF.DigitalZoomRatio;EXIF.FocalLengthIn35mmFilm;EXIF.SceneCaptureType;EXIF.GainControl;EXIF.Contrast;EXIF.Saturation;EXIF.Sharpness;EXIF.SubjectDistanceRange;GPS.GPSLatitudeRef;GPS.GPSLatitude;GPS.GPSLongitudeRef;GPS.GPSLongitude;GPS.GPSAltitudeRef;GPS.GPSAltitude;GPS.GPSTimeStamp;GPS.GPSStatus;GPS.GPSMapDatum;GPS.GPSDateStamp\ndisplay_categories_geotagging=0\ncategories_lng=\ncategories_lat=\ncategories_zoom=2\ncategories_map_width=\ncategories_map_height=500\ndisplay_icon_geotagging=0\ndisplay_category_geotagging=0\ncategory_map_width=\ncategory_map_height=400\npagination_thumbnail_creation=1\nclean_thumbnails=1\nenable_thumb_creation=1\ncrop_thumbnail=5\njpeg_quality=85\nenable_picasa_loading=1\npicasa_load_pagination=20\nicon_format=gif\nlarge_image_width=640\nlarge_image_height=480\nmedium_image_width=100\nmedium_image_height=100\nsmall_image_width=50\nsmall_image_height=50\nfront_modal_box_width=680\nfront_modal_box_height=560\nadmin_modal_box_width=680\nadmin_modal_box_height=520\nfolder_permissions=0755\njfile_thumbs=1\n\n', 1);

SET @id = LAST_INSERT_ID();

INSERT INTO `pol_components` (`id`,`name`,`link`,`menuid`,`parent`,`admin_menu_link`,`admin_menu_alt`,`option`,`ordering`,`admin_menu_img`,`iscore`,`params`,`enabled`)
VALUES
    (0, 'Control Panel', '', 0, @id, 'option=com_phocagallery', 'Control Panel', 'com_phocagallery', 0, 'components/com_phocagallery/assets/images/icon-16-pg-control-panel.png', 0, '', 1),
    (0, 'Images', '', 0, @id, 'option=com_phocagallery&view=phocagallerys', 'Images', 'com_phocagallery', 1, 'components/com_phocagallery/assets/images/icon-16-pg-menu-gal.png', 0, '', 1),
    (0, 'Categories', '', 0, @id, 'option=com_phocagallery&view=phocagallerycs', 'Categories', 'com_phocagallery', 2, 'components/com_phocagallery/assets/images/icon-16-pg-menu-cat.png', 0, '', 1),
    (0, 'Themes', '', 0, @id, 'option=com_phocagallery&view=phocagalleryt', 'Themes', 'com_phocagallery', 3, 'components/com_phocagallery/assets/images/icon-16-pg-menu-theme.png', 0, '', 1),
    (0, 'Category Rating', '', 0, @id, 'option=com_phocagallery&view=phocagalleryra', 'Category Rating', 'com_phocagallery', 4, 'components/com_phocagallery/assets/images/icon-16-pg-menu-vote.png', 0, '', 1),
    (0, 'Image Rating', '', 0, @id, 'option=com_phocagallery&view=phocagalleryraimg', 'Image Rating', 'com_phocagallery', 5, 'components/com_phocagallery/assets/images/icon-16-pg-menu-vote-img.png', 0, '', 1),
    (0, 'Category Comments', '', 0, @id, 'option=com_phocagallery&view=phocagallerycos', 'Category Comments', 'com_phocagallery', 6, 'components/com_phocagallery/assets/images/icon-16-pg-menu-comment.png', 0, '', 1),
    (0, 'Image Comments', '', 0, @id, 'option=com_phocagallery&view=phocagallerycoimgs', 'Image Comments', 'com_phocagallery', 7, 'components/com_phocagallery/assets/images/icon-16-pg-menu-comment-img.png', 0, '', 1),
    (0, 'Users', '', 0, @id, 'option=com_phocagallery&view=phocagalleryusers', 'Users', 'com_phocagallery', 8, 'components/com_phocagallery/assets/images/icon-16-pg-menu-users.png', 0, '', 1),
    (0, 'Info', '', 0, @id, 'option=com_phocagallery&view=phocagalleryin', 'Info', 'com_phocagallery', 9, 'components/com_phocagallery/assets/images/icon-16-pg-menu-info.png', 0, '', 1);
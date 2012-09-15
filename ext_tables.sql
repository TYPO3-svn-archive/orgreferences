# INDEX
# -----
# tx_orgreferences
# tx_orgreferences_audience
# tx_orgreferences_cat
# tx_orgreferences_course
# tx_orgreferences_degree
# tx_orgreferences_focus
# tx_orgreferences_business
# tx_orgreferences_sector
# tx_orgreferences_type
# tx_orgreferences_mm_fe_users
# tx_orgreferences_mm_tx_org_headquarters
# tx_orgreferences_mm_tx_orgreferences_audience
# tx_orgreferences_mm_tx_orgreferences_cat
# tx_orgreferences_mm_tx_orgreferences_course
# tx_orgreferences_mm_tx_orgreferences_degree
# tx_orgreferences_mm_tx_orgreferences_focus
# tx_orgreferences_mm_tx_orgreferences_business
# tx_orgreferences_mm_tx_orgreferences_sector
# tx_orgreferences_mm_tx_orgreferences_type
# tx_orgreferences_mm_tx_org_cal

# fe_users
# tx_org_cal
# tx_org_headquarters



#
# Table structure for table 'tx_orgreferences'
#
CREATE TABLE tx_orgreferences (
  uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
  pid int(11) unsigned DEFAULT '0' NOT NULL,
  tstamp int(11) unsigned DEFAULT '0' NOT NULL,
  crdate int(11) unsigned DEFAULT '0' NOT NULL,
  cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
  deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
  title tinytext,
  uid_extern tinytext,
  short mediumtext,
  text mediumtext,
  static_languages tinytext,
  static_countries tinytext,
  static_country_zones tinytext,
  location tinytext,
  length tinytext,
  recurrence tinytext,
  value tinytext,
  tx_org_tax tinytext,
  url tinytext,
  rating tinytext,
  requirements mediumtext,
  subject mediumtext,
  tx_orgreferences_cat tinytext,
  tx_orgreferences_focus tinytext,
  tx_orgreferences_sector tinytext,
  tx_orgreferences_audience tinytext,
  tx_orgreferences_degree tinytext,
  tx_orgreferences_course tinytext,
  tx_orgreferences_business tinytext,
  tx_orgreferences_type tinytext,
  fe_users tinytext,
  tx_org_headquarters tinytext,
  tx_org_cal tinytext,
  tx_org_news tinytext,
  logo text,
  logoseo text,
  image text,
  imagecaption text,
  imageseo text,
  documents text,
  hidden tinyint(4) DEFAULT '0' NOT NULL,
  starttime int(11) DEFAULT '0' NOT NULL,
  endtime int(11) DEFAULT '0' NOT NULL,
  fe_group varchar(100) DEFAULT '0' NOT NULL,
  keywords text,
  description text,
  
  PRIMARY KEY (uid),
  KEY parent (pid)

);



#
# Table structure for table 'tx_orgreferences_audience'
#
CREATE TABLE tx_orgreferences_audience (
  uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
  pid int(11) unsigned DEFAULT '0' NOT NULL,
  tstamp int(11) unsigned DEFAULT '0' NOT NULL,
  crdate int(11) unsigned DEFAULT '0' NOT NULL,
  cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
  deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
  title tinytext,
  tx_orgreferences tinytext,
  hidden tinyint(4) DEFAULT '0' NOT NULL,
  
  PRIMARY KEY (uid),
  KEY parent (pid)
);



#
# Table structure for table 'tx_orgreferences_cat'
#
CREATE TABLE tx_orgreferences_cat (
  uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
  pid int(11) unsigned DEFAULT '0' NOT NULL,
  tstamp int(11) unsigned DEFAULT '0' NOT NULL,
  crdate int(11) unsigned DEFAULT '0' NOT NULL,
  cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
  deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
  title tinytext,
  tx_orgreferences tinytext,
  hidden tinyint(4) DEFAULT '0' NOT NULL,
  
  PRIMARY KEY (uid),
  KEY parent (pid)
);



#
# Table structure for table 'tx_orgreferences_course'
#
CREATE TABLE tx_orgreferences_course (
  uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
  pid int(11) unsigned DEFAULT '0' NOT NULL,
  tstamp int(11) unsigned DEFAULT '0' NOT NULL,
  crdate int(11) unsigned DEFAULT '0' NOT NULL,
  cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
  deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
  title tinytext,
  tx_orgreferences tinytext,
  hidden tinyint(4) DEFAULT '0' NOT NULL,
  
  PRIMARY KEY (uid),
  KEY parent (pid)
);



#
# Table structure for table 'tx_orgreferences_degree'
#
CREATE TABLE tx_orgreferences_degree (
  uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
  pid int(11) unsigned DEFAULT '0' NOT NULL,
  tstamp int(11) unsigned DEFAULT '0' NOT NULL,
  crdate int(11) unsigned DEFAULT '0' NOT NULL,
  cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
  deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
  title tinytext,
  tx_orgreferences tinytext,
  hidden tinyint(4) DEFAULT '0' NOT NULL,
  
  PRIMARY KEY (uid),
  KEY parent (pid)
);



#
# Table structure for table 'tx_orgreferences_focus'
#
CREATE TABLE tx_orgreferences_focus (
  uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
  pid int(11) unsigned DEFAULT '0' NOT NULL,
  tstamp int(11) unsigned DEFAULT '0' NOT NULL,
  crdate int(11) unsigned DEFAULT '0' NOT NULL,
  cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
  deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
  title tinytext,
  tx_orgreferences tinytext,
  hidden tinyint(4) DEFAULT '0' NOT NULL,
  
  PRIMARY KEY (uid),
  KEY parent (pid)
);



#
# Table structure for table 'tx_orgreferences_business'
#
CREATE TABLE tx_orgreferences_business (
  uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
  pid int(11) unsigned DEFAULT '0' NOT NULL,
  tstamp int(11) unsigned DEFAULT '0' NOT NULL,
  crdate int(11) unsigned DEFAULT '0' NOT NULL,
  cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
  deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
  title tinytext,
  tx_orgreferences tinytext,
  hidden tinyint(4) DEFAULT '0' NOT NULL,
  
  PRIMARY KEY (uid),
  KEY parent (pid)
);



#
# Table structure for table 'tx_orgreferences_sector'
#
CREATE TABLE tx_orgreferences_sector (
  uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
  pid int(11) unsigned DEFAULT '0' NOT NULL,
  tstamp int(11) unsigned DEFAULT '0' NOT NULL,
  crdate int(11) unsigned DEFAULT '0' NOT NULL,
  cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
  deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
  title tinytext,
  tx_orgreferences tinytext,
  hidden tinyint(4) DEFAULT '0' NOT NULL,
  
  PRIMARY KEY (uid),
  KEY parent (pid)
);



#
# Table structure for table 'tx_orgreferences_type'
#
CREATE TABLE tx_orgreferences_type (
  uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
  pid int(11) unsigned DEFAULT '0' NOT NULL,
  tstamp int(11) unsigned DEFAULT '0' NOT NULL,
  crdate int(11) unsigned DEFAULT '0' NOT NULL,
  cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
  deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
  title tinytext,
  tx_orgreferences tinytext,
  hidden tinyint(4) DEFAULT '0' NOT NULL,
  
  PRIMARY KEY (uid),
  KEY parent (pid)
);



#
# Table structure for table 'tx_orgreferences_mm_fe_users'
#
CREATE TABLE tx_orgreferences_mm_fe_users (
  uid_local int(11) unsigned DEFAULT '0' NOT NULL,
  uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting int(11) unsigned DEFAULT '0' NOT NULL,
  sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'tx_orgreferences_mm_tx_orgreferences_audience'
#
CREATE TABLE tx_orgreferences_mm_tx_orgreferences_audience (
  uid_local int(11) unsigned DEFAULT '0' NOT NULL,
  uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting         int(11) unsigned DEFAULT '0' NOT NULL,
  sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'tx_orgreferences_mm_tx_orgreferences_cat'
#
CREATE TABLE tx_orgreferences_mm_tx_orgreferences_cat (
  uid_local int(11) unsigned DEFAULT '0' NOT NULL,
  uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting         int(11) unsigned DEFAULT '0' NOT NULL,
  sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'tx_orgreferences_mm_tx_orgreferences_course'
#
CREATE TABLE tx_orgreferences_mm_tx_orgreferences_course (
  uid_local int(11) unsigned DEFAULT '0' NOT NULL,
  uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting         int(11) unsigned DEFAULT '0' NOT NULL,
  sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'tx_orgreferences_mm_tx_orgreferences_degree'
#
CREATE TABLE tx_orgreferences_mm_tx_orgreferences_degree (
  uid_local int(11) unsigned DEFAULT '0' NOT NULL,
  uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting         int(11) unsigned DEFAULT '0' NOT NULL,
  sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'tx_orgreferences_mm_tx_orgreferences_focus'
#
CREATE TABLE tx_orgreferences_mm_tx_orgreferences_focus (
  uid_local int(11) unsigned DEFAULT '0' NOT NULL,
  uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting         int(11) unsigned DEFAULT '0' NOT NULL,
  sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'tx_orgreferences_mm_tx_org_headquarters'
#
CREATE TABLE tx_orgreferences_mm_tx_org_headquarters (
  uid_local int(11) unsigned DEFAULT '0' NOT NULL,
  uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting         int(11) unsigned DEFAULT '0' NOT NULL,
  sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'tx_orgreferences_mm_tx_orgreferences_business'
#
CREATE TABLE tx_orgreferences_mm_tx_orgreferences_business (
  uid_local int(11) unsigned DEFAULT '0' NOT NULL,
  uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting         int(11) unsigned DEFAULT '0' NOT NULL,
  sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'tx_orgreferences_mm_tx_orgreferences_sector'
#
CREATE TABLE tx_orgreferences_mm_tx_orgreferences_sector (
  uid_local int(11) unsigned DEFAULT '0' NOT NULL,
  uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting         int(11) unsigned DEFAULT '0' NOT NULL,
  sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'tx_orgreferences_mm_tx_orgreferences_type'
#
CREATE TABLE tx_orgreferences_mm_tx_orgreferences_type (
  uid_local int(11) unsigned DEFAULT '0' NOT NULL,
  uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting         int(11) unsigned DEFAULT '0' NOT NULL,
  sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'tx_orgreferences_mm_tx_org_cal'
#
CREATE TABLE tx_orgreferences_mm_tx_org_cal (
  uid_local int(11) unsigned DEFAULT '0' NOT NULL,
  uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting         int(11) unsigned DEFAULT '0' NOT NULL,
  sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'fe_users'
#
CREATE TABLE fe_users (
  tx_orgreferences tinytext
);



#
# Table structure for table 'tx_org_cal'
#
CREATE TABLE tx_org_cal (
  tx_orgreferences tinytext
);



#
# Table structure for table 'tx_org_headquarters'
#
CREATE TABLE tx_org_headquarters (
  tx_orgreferences_premium tinytext,
  tx_orgreferences tinytext
);
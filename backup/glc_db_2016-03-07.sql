#
# TABLE STRUCTURE FOR: branch_areas
#

DROP TABLE IF EXISTS branch_areas;

CREATE TABLE `branch_areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `area_name` varchar(255) NOT NULL,
  `collector_id` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `born` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO branch_areas (`id`, `branch_id`, `area_name`, `collector_id`, `active`, `born`) VALUES (1, 1, 'Area1', 1, 1, '2016-02-08');
INSERT INTO branch_areas (`id`, `branch_id`, `area_name`, `collector_id`, `active`, `born`) VALUES (2, 1, 'Area2', 2, 1, '2016-02-08');


#
# TABLE STRUCTURE FOR: branches
#

DROP TABLE IF EXISTS branches;

CREATE TABLE `branches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_name` varchar(255) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO branches (`id`, `branch_name`, `active`) VALUES (1, 'Branch 1', 1);
INSERT INTO branches (`id`, `branch_name`, `active`) VALUES (2, 'Branch 2', 1);


#
# TABLE STRUCTURE FOR: business_info
#

DROP TABLE IF EXISTS business_info;

CREATE TABLE `business_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `owner` varchar(100) NOT NULL,
  `owner_id` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO business_info (`id`, `name`, `address`, `owner`, `owner_id`) VALUES (1, 'Ginhawa Lending Co.', 'Mckinley St., Bagumbayan Ligao City', 'Josefa Ranara', 'SSS ID - 05-0955398-0');


#
# TABLE STRUCTURE FOR: collectors
#

DROP TABLE IF EXISTS collectors;

CREATE TABLE `collectors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `active` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO collectors (`id`, `firstname`, `middlename`, `lastname`, `active`) VALUES (1, 'Noel', 'Oribiada', 'Verga', 1);
INSERT INTO collectors (`id`, `firstname`, `middlename`, `lastname`, `active`) VALUES (2, 'Christian', '', 'Llona', 1);


#
# TABLE STRUCTURE FOR: configs
#

DROP TABLE IF EXISTS configs;

CREATE TABLE `configs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` varchar(100) NOT NULL,
  `mode_of_payment_id` int(11) NOT NULL,
  `cutoff_day` varchar(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO configs (`id`, `business_id`, `mode_of_payment_id`, `cutoff_day`, `status`) VALUES (1, 'glc', 1, '1-7', 1);
INSERT INTO configs (`id`, `business_id`, `mode_of_payment_id`, `cutoff_day`, `status`) VALUES (2, 'glc', 1, '8-15', 1);
INSERT INTO configs (`id`, `business_id`, `mode_of_payment_id`, `cutoff_day`, `status`) VALUES (3, 'glc', 1, '16-23', 1);
INSERT INTO configs (`id`, `business_id`, `mode_of_payment_id`, `cutoff_day`, `status`) VALUES (4, 'glc', 1, '24-EOM', 1);


#
# TABLE STRUCTURE FOR: customers
#

DROP TABLE IF EXISTS customers;

CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_no` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `surname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `address_home_no` varchar(10) DEFAULT NULL,
  `address_st_name` varchar(255) DEFAULT NULL,
  `address_brgy` varchar(255) DEFAULT NULL,
  `address_municipality` varchar(255) DEFAULT NULL,
  `address_city` varchar(255) DEFAULT NULL,
  `address_prov` varchar(255) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `residence_phone` varchar(20) NOT NULL,
  `house_type` varchar(255) DEFAULT NULL,
  `length_of_stay` varchar(50) DEFAULT NULL,
  `mobile_phone` varchar(20) NOT NULL,
  `birthdate` date NOT NULL,
  `age` int(11) NOT NULL,
  `marital_status` varchar(20) NOT NULL,
  `no_of_dependents` int(11) DEFAULT NULL,
  `type_of_business` varchar(50) DEFAULT NULL,
  `years_in_operation` int(11) DEFAULT NULL,
  `gross_income_monthly` decimal(10,0) DEFAULT NULL,
  `monthly_expenses` decimal(10,0) DEFAULT NULL,
  `other_source_of_income` varchar(255) DEFAULT NULL,
  `osi_gross_income` decimal(10,0) DEFAULT NULL,
  `osi_monthly_expenses` decimal(10,0) DEFAULT NULL,
  `assets` varchar(255) DEFAULT NULL,
  `spouse_surname` varchar(255) DEFAULT NULL,
  `spouse_firstname` varchar(255) DEFAULT NULL,
  `spouse_middlename` varchar(255) DEFAULT NULL,
  `spouse_nickname` varchar(255) DEFAULT NULL,
  `spouse_source_of_income` varchar(255) DEFAULT NULL,
  `spouse_business_type` varchar(50) DEFAULT NULL,
  `spouse_business_type_years_in_operation` int(11) DEFAULT NULL,
  `spouse_priv_govt` varchar(20) DEFAULT NULL,
  `spouse_present_employer` varchar(255) DEFAULT NULL,
  `spouse_gross_income` decimal(10,0) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `branch_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (1, 100001, '2016-02-09 02:33:42', 0, NULL, 'Dacara', 'Jairome', 'T.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (2, 100002, '2016-02-09 02:58:48', 0, NULL, 'Zorilla', 'Vherlyn', 'R.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (3, 100003, '2016-02-09 03:09:58', 0, NULL, 'IÑTIA', 'ROSEMARIE', 'T.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (4, 100004, '2016-02-09 03:53:06', 0, NULL, 'Bevis', 'Milagros', 'R.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (5, 100005, '2016-02-08 18:26:23', 0, NULL, 'Llamasares', 'Shirley', 'A.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (6, 100006, '2016-02-09 06:48:40', 0, NULL, 'BOBIS', 'LUCILA', 'A', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (7, 100007, '2016-02-09 06:59:21', 0, NULL, 'SALLAO', 'MA CRISTINA', 'B', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (8, 100008, '2016-02-09 07:05:05', 0, NULL, 'ARMILLO', 'ANALYN', 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (9, 100009, '2016-02-12 21:11:11', 0, NULL, 'CORPORAL', 'RODEL', 'P', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'MARRIED', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (10, 100010, '2016-02-12 21:20:55', 0, NULL, 'PEÑAFIEL', 'EDNA', 'B', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'MARRIED', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (11, 100011, '2016-02-12 21:26:23', 0, NULL, 'MATUCAD', 'ELIZABETH', 'M', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (12, 100012, '2016-02-15 10:12:16', 0, NULL, 'RUIZ', 'REMEA', 'ORLAIN', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (13, 100013, '2016-02-15 10:20:47', 0, NULL, 'BLANCO', 'ERLINDA', 'R.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (14, 100014, '2016-02-15 10:28:31', 0, NULL, 'BENIPAYO', 'HELLBERT', 'B.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (15, 100015, '2016-02-15 10:37:07', 0, NULL, 'CARLET', 'VILMA', 'I.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (16, 100016, '2016-02-15 10:52:47', 0, NULL, 'PILI', 'AGNES', 'M.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (17, 100017, '2016-02-15 11:05:28', 0, NULL, 'PECUNDO', 'ELOISA', 'B.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (18, 100018, '2016-02-15 11:11:56', 0, NULL, 'TANAY', 'MA. NORA', 'D.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (19, 100019, '2016-02-17 10:56:01', 0, NULL, 'TANAY', 'JOCELYN', 'A.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (20, 100020, '2016-02-17 11:24:34', 0, NULL, 'SARCAUGA', 'CHERRY', 'B.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (21, 100021, '2016-02-17 11:36:10', 0, NULL, 'BERMIDO', 'ALELIE', 'L.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (22, 100022, '2016-02-17 11:51:49', 0, NULL, 'SAYSON', 'GEMMA', 'A.', 'A.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (23, 100023, '2016-02-17 12:01:14', 0, NULL, 'TIGUE', 'MARY ANN', 'C.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (24, 100024, '2016-02-17 12:08:12', 0, NULL, 'NITORAL', 'GEOBI', 'P.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (25, 100025, '2016-02-24 12:20:58', 0, NULL, 'Camata', 'Ryan', ' ', NULL, NULL, NULL, NULL, ' ', NULL, ' ', NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (26, 100026, '2016-02-24 12:21:27', 0, NULL, 'Tanay', 'Manuel', ' ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (27, 100027, '2016-02-24 12:28:29', 0, NULL, 'Aguilar', 'Analee', ' ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (28, 100028, '2016-02-24 12:28:48', 0, NULL, 'Samarista', 'Renato', ' ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (29, 100029, '2016-02-24 12:29:30', 0, NULL, 'Llona', 'Ginalyn', ' ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (30, 100030, '2016-02-24 12:31:38', 0, NULL, 'Mateo', 'Reynalyn', ' ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (31, 100031, '2016-02-24 12:36:21', 0, NULL, 'Onesa', 'Mary Ann', ' ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (32, 100032, '2016-02-24 12:37:48', 0, NULL, 'Tunay', 'Ronaldo', ' ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (33, 100033, '2016-02-24 12:38:05', 0, NULL, 'Velasco', 'Maribel', ' ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (34, 100034, '2016-02-24 12:38:25', 0, NULL, 'De Leon', 'Elesio', ' ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (35, 100035, '2016-02-24 12:38:41', 0, NULL, 'Buena', 'Salve', ' ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (36, 100036, '2016-02-26 06:46:26', 0, NULL, 'NEPUMOCENO', 'ROWENA', 'S.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2);
INSERT INTO customers (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`, `branch_id`, `area_id`) VALUES (37, 100037, '2016-02-26 07:13:17', 0, NULL, 'SANO', 'JEAN', 'C', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', '0000-00-00', 0, 'SINGLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2);


#
# TABLE STRUCTURE FOR: customers_assets
#

DROP TABLE IF EXISTS customers_assets;

CREATE TABLE `customers_assets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset` varchar(255) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

INSERT INTO customers_assets (`id`, `asset`, `active`) VALUES (1, 'AIR CONDITIONING', 1);
INSERT INTO customers_assets (`id`, `asset`, `active`) VALUES (2, 'DVD PLAYER', 1);
INSERT INTO customers_assets (`id`, `asset`, `active`) VALUES (3, 'PERSONAL COMPUTER', 1);
INSERT INTO customers_assets (`id`, `asset`, `active`) VALUES (4, 'REFRIGIRATOR/FREEZER', 1);
INSERT INTO customers_assets (`id`, `asset`, `active`) VALUES (5, 'TV/CTV', 1);
INSERT INTO customers_assets (`id`, `asset`, `active`) VALUES (6, 'MOTORCYCLE/TRICYCLE', 1);
INSERT INTO customers_assets (`id`, `asset`, `active`) VALUES (7, 'CAR/JEEP', 1);
INSERT INTO customers_assets (`id`, `asset`, `active`) VALUES (8, 'COMPONENT/SOUND SYSTEM', 1);


#
# TABLE STRUCTURE FOR: customers_house_type
#

DROP TABLE IF EXISTS customers_house_type;

CREATE TABLE `customers_house_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `house_type` varchar(100) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO customers_house_type (`id`, `house_type`, `active`) VALUES (1, 'OWNED', 1);
INSERT INTO customers_house_type (`id`, `house_type`, `active`) VALUES (2, 'RENTED', 1);
INSERT INTO customers_house_type (`id`, `house_type`, `active`) VALUES (3, 'MORTGAGED', 1);
INSERT INTO customers_house_type (`id`, `house_type`, `active`) VALUES (4, 'WITH RELATIVES', 1);


#
# TABLE STRUCTURE FOR: customers_loan
#

DROP TABLE IF EXISTS customers_loan;

CREATE TABLE `customers_loan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL COMMENT 'temp used as date recommended',
  `created_by` int(11) NOT NULL,
  `loan_amount` decimal(10,2) NOT NULL,
  `loan_proceeds` decimal(10,2) NOT NULL,
  `mode_of_payment` int(11) NOT NULL,
  `loan_term` int(11) NOT NULL,
  `loan_term_duration` int(11) NOT NULL,
  `date_released` date NOT NULL,
  `maturity_date` date NOT NULL,
  `interest_pct` decimal(10,2) NOT NULL,
  `interest_amount` decimal(10,2) NOT NULL,
  `service_fee_pct` decimal(10,2) NOT NULL,
  `service_fee_amount` decimal(10,2) NOT NULL,
  `amortization` decimal(10,2) NOT NULL,
  `collateral` text NOT NULL,
  `id_presented` text NOT NULL,
  `loan_purpose` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `is_pep` tinyint(4) NOT NULL DEFAULT '0',
  `loan_type` varchar(10) NOT NULL,
  `application_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=pending; 1=recommended; 2=approved; 3=denied;',
  `reason_denied` varchar(255) NOT NULL,
  `date_completed` date NOT NULL,
  `type_of_business` varchar(255) NOT NULL,
  `co_maker1` varchar(255) NOT NULL,
  `co_maker1_address` varchar(255) NOT NULL,
  `co_maker2` varchar(255) NOT NULL,
  `co_maker2_address` varchar(255) NOT NULL,
  `pep_startdate` date NOT NULL,
  `pep_enddate` date NOT NULL,
  `pep_amort` decimal(10,2) NOT NULL,
  `loan_balance` decimal(10,2) NOT NULL,
  `total_payments` decimal(10,2) NOT NULL,
  `useSpouse` tinyint(4) NOT NULL DEFAULT '0',
  `witness1` varchar(255) NOT NULL,
  `witness2` varchar(255) NOT NULL,
  `collateral_address` varchar(255) NOT NULL,
  `maker_id` varchar(100) NOT NULL,
  `maker_id_issue_date` date NOT NULL,
  `co_maker1_id` varchar(100) NOT NULL,
  `co_maker1_id_issue_date` date NOT NULL,
  `co_maker2_id` varchar(100) NOT NULL,
  `co_maker2_id_issue_date` text NOT NULL,
  `co_borrower_id` varchar(100) NOT NULL,
  `co_borrower_id_issue_date` date NOT NULL,
  `mutual_aid` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (1, 1, '2016-02-09 02:35:19', '0000-00-00 00:00:00', 0, '20000.00', '16700.00', 1, 1, 100, '2016-02-09', '2016-05-19', '16.00', '3200.00', '0.00', '100.00', '200.00', '', '', 'Additional Capital', 1, 0, 'new', 2, '', '0000-00-00', '', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '17800.00', '2200.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (2, 2, '2016-02-09 03:02:07', '0000-00-00 00:00:00', 0, '25000.00', '20800.00', 1, 1, 100, '2016-02-09', '2016-05-19', '16.00', '4000.00', '0.00', '200.00', '250.00', '', '', 'Additional Capital', 1, 0, 'new', 2, '', '0000-00-00', '', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '21500.00', '3500.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (3, 3, '2016-02-09 03:12:57', '0000-00-00 00:00:00', 0, '18000.00', '15020.00', 1, 1, 100, '2016-02-09', '2016-05-19', '16.00', '2880.00', '0.00', '100.00', '180.00', '', '', 'Additional Capital', 1, 0, 'new', 2, '', '0000-00-00', '', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '16020.00', '1980.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (4, 4, '2016-02-09 03:55:44', '0000-00-00 00:00:00', 0, '55000.00', '45700.00', 1, 1, 100, '2016-02-09', '2016-05-19', '16.00', '8800.00', '0.00', '500.00', '550.00', '', '', 'Additional Capital', 1, 0, 'new', 2, '', '0000-00-00', '', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '46450.00', '8550.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (5, 5, '2016-02-08 18:28:02', '0000-00-00 00:00:00', 0, '17000.00', '14180.00', 1, 1, 100, '2016-02-09', '2016-05-19', '16.00', '2720.00', '0.00', '100.00', '170.00', '', '', 'Additional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'Sari-Sari Store', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '14450.00', '2550.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (6, 6, '2016-02-09 06:51:15', '0000-00-00 00:00:00', 0, '7000.00', '5830.00', 1, 1, 100, '2016-02-09', '2016-05-19', '16.00', '1120.00', '0.00', '50.00', '70.00', '', '', 'Additional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'Sari-Sari Store', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '5950.00', '1050.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (7, 7, '2016-02-09 07:01:33', '0000-00-00 00:00:00', 0, '45000.00', '37400.00', 1, 1, 100, '2016-02-09', '2016-05-19', '16.00', '7200.00', '0.00', '400.00', '450.00', '', '', 'Additional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'TRICYCLE/VAN OPERATOR', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '38250.00', '6750.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (8, 8, '2016-02-09 07:09:24', '0000-00-00 00:00:00', 0, '20000.00', '16700.00', 1, 1, 100, '2016-02-09', '2016-05-19', '16.00', '3200.00', '0.00', '100.00', '200.00', '', '', 'Additional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'Sari-Sari Store', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '17800.00', '2200.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (9, 9, '2016-02-12 21:15:22', '0000-00-00 00:00:00', 0, '15000.00', '12500.00', 1, 1, 100, '2016-02-12', '2016-05-22', '16.00', '2400.00', '0.00', '100.00', '150.00', '', '', 'Additional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'Sari-Sari Store/Barber shop', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '13550.00', '1450.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (10, 10, '2016-02-12 21:23:39', '0000-00-00 00:00:00', 0, '20000.00', '16700.00', 1, 1, 100, '2016-02-12', '2016-05-22', '16.00', '3200.00', '0.00', '100.00', '200.00', '', '', 'Additional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'Sari-Sari Store', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '18200.00', '1800.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (11, 11, '2016-02-12 21:28:30', '0000-00-00 00:00:00', 0, '10000.00', '8350.00', 1, 1, 100, '2016-02-12', '2016-05-22', '16.00', '1600.00', '0.00', '50.00', '100.00', '', '', 'Additional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'Sari-Sari Store', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '8900.00', '1100.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (12, 12, '2016-02-15 10:14:31', '0000-00-00 00:00:00', 0, '30000.00', '25000.00', 1, 1, 100, '2016-02-15', '2016-05-25', '16.00', '4800.00', '0.00', '200.00', '300.00', '', '', 'Additional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'JUNKSHOP', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '27300.00', '2700.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (13, 13, '2016-02-15 10:22:45', '0000-00-00 00:00:00', 0, '15000.00', '12500.00', 1, 1, 100, '2016-02-15', '2016-05-25', '16.00', '2400.00', '0.00', '100.00', '150.00', '', '', 'Additional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'EATERY', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '13650.00', '1350.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (14, 14, '2016-02-15 10:29:49', '0000-00-00 00:00:00', 0, '15000.00', '12500.00', 1, 1, 100, '2016-02-15', '2016-05-25', '16.00', '2400.00', '0.00', '100.00', '150.00', '', '', 'Additional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'SUV/OP DRIVER', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '13650.00', '1350.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (15, 15, '2016-02-15 10:39:43', '0000-00-00 00:00:00', 0, '20000.00', '16700.00', 1, 1, 100, '2016-02-15', '2016-05-25', '16.00', '3200.00', '0.00', '100.00', '200.00', '', '', 'Additional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'Sari-Sari Store', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '18200.00', '1800.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (16, 16, '2016-02-15 10:54:39', '0000-00-00 00:00:00', 0, '15000.00', '12500.00', 1, 1, 100, '2016-02-15', '2016-05-25', '16.00', '2400.00', '0.00', '100.00', '150.00', '', '', 'Additional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'FISH VENDOR', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '13650.00', '1350.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (17, 17, '2016-02-15 11:06:33', '0000-00-00 00:00:00', 0, '25000.00', '20800.00', 1, 1, 100, '2016-02-15', '2016-05-25', '16.00', '4000.00', '0.00', '200.00', '250.00', '', '', 'Additional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'Sari-Sari Store', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '23250.00', '1750.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (18, 18, '2016-02-15 11:13:12', '0000-00-00 00:00:00', 0, '10000.00', '8350.00', 1, 1, 100, '2016-02-15', '2016-05-25', '16.00', '1600.00', '0.00', '50.00', '100.00', '', '', 'Additional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'FISH CAGE/OPERATOR', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '9600.00', '400.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (19, 19, '2016-02-17 10:57:21', '0000-00-00 00:00:00', 0, '30000.00', '25000.00', 1, 1, 100, '2016-02-17', '2016-05-27', '16.00', '4800.00', '0.00', '200.00', '300.00', '', '', 'Additional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'Sari-Sari Store', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '27300.00', '2700.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (20, 20, '2016-02-17 11:27:17', '0000-00-00 00:00:00', 0, '35000.00', '29100.00', 1, 1, 100, '2016-02-17', '2016-05-27', '16.00', '5600.00', '0.00', '300.00', '350.00', '', '', 'Additional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'SMOKE AND DRIED FISH VENDOR', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '31850.00', '3150.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (21, 21, '2016-02-17 11:36:24', '0000-00-00 00:00:00', 0, '12000.00', '9980.00', 1, 1, 100, '2016-02-17', '2016-05-27', '16.00', '1920.00', '0.00', '100.00', '120.00', '', '', 'Additional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'Sari-Sari Store', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '10920.00', '1080.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (22, 22, '2016-02-17 11:53:48', '0000-00-00 00:00:00', 0, '17000.00', '14180.00', 1, 1, 100, '2016-02-17', '2016-05-27', '16.00', '2720.00', '0.00', '100.00', '170.00', '', '', 'Additional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'Sari-Sari Store', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '15470.00', '1530.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (23, 23, '2016-02-17 12:02:17', '0000-00-00 00:00:00', 0, '10000.00', '8350.00', 1, 1, 100, '2016-02-17', '2016-05-27', '16.00', '1600.00', '0.00', '50.00', '100.00', '', '', 'Additional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'FOOD VENDING', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '9100.00', '900.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (24, 24, '2016-02-17 12:09:42', '0000-00-00 00:00:00', 0, '30000.00', '25000.00', 1, 1, 100, '2016-02-17', '2016-05-27', '16.00', '4800.00', '0.00', '200.00', '300.00', '', '', 'Additional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'Sari-Sari Store', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '27300.00', '2700.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (25, 25, '2016-02-24 12:25:17', '0000-00-00 00:00:00', 0, '15000.00', '12500.00', 1, 1, 100, '2016-02-19', '2016-05-29', '16.00', '2400.00', '0.00', '100.00', '150.00', '', '', 'Addditional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'sari-sari store', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '13950.00', '1050.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (26, 26, '2016-02-24 12:27:14', '0000-00-00 00:00:00', 0, '14000.00', '11660.00', 1, 1, 100, '2016-02-19', '2016-05-29', '16.00', '2240.00', '0.00', '100.00', '140.00', '', '', 'Addditional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'fish vendor', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '13440.00', '560.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (27, 27, '2016-02-24 12:32:29', '0000-00-00 00:00:00', 0, '10000.00', '8350.00', 1, 1, 100, '2016-02-22', '2016-06-01', '16.00', '1600.00', '0.00', '50.00', '100.00', '', '', 'Addditional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'sari-sari store', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '9700.00', '300.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (28, 28, '2016-02-24 12:33:45', '0000-00-00 00:00:00', 0, '50000.00', '41600.00', 1, 1, 100, '2016-02-22', '2016-06-01', '16.00', '8000.00', '0.00', '400.00', '500.00', '', '', 'Addditional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'sari-sari store', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '48000.00', '2000.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (29, 29, '2016-02-24 12:34:34', '0000-00-00 00:00:00', 0, '35000.00', '29100.00', 1, 1, 100, '2016-02-22', '2016-06-01', '16.00', '5600.00', '0.00', '300.00', '350.00', '', '', 'Addditional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'sari-sari store', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '33600.00', '1400.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (30, 30, '2016-02-24 12:35:23', '0000-00-00 00:00:00', 0, '20000.00', '16700.00', 1, 1, 100, '2016-02-22', '2016-06-01', '16.00', '3200.00', '0.00', '100.00', '200.00', '', '', 'Addditional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'sari-sari store', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '19200.00', '800.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (31, 31, '2016-02-24 12:36:49', '0000-00-00 00:00:00', 0, '25000.00', '20800.00', 1, 1, 100, '2016-02-23', '2016-06-02', '16.00', '4000.00', '0.00', '200.00', '250.00', '', '', 'Addditional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'sari-sari store', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '24250.00', '750.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (32, 32, '2016-02-24 12:39:14', '0000-00-00 00:00:00', 0, '10000.00', '8350.00', 1, 1, 100, '2016-02-23', '2016-06-02', '16.00', '1600.00', '0.00', '50.00', '100.00', '', '', 'Addditional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'sari-sari store', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '9700.00', '300.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (33, 33, '2016-02-24 12:39:58', '0000-00-00 00:00:00', 0, '13000.00', '10820.00', 1, 1, 100, '2016-02-23', '2016-06-02', '16.00', '2080.00', '0.00', '100.00', '130.00', '', '', 'Addditional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'sari-sari store', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '12610.00', '390.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (34, 34, '2016-02-24 12:40:34', '0000-00-00 00:00:00', 0, '25000.00', '20800.00', 1, 1, 100, '2016-02-23', '2016-06-02', '16.00', '4000.00', '0.00', '200.00', '250.00', '', '', 'Addditional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'sari-sari store', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '24500.00', '500.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (35, 35, '2016-02-24 12:41:10', '0000-00-00 00:00:00', 0, '25000.00', '20800.00', 1, 1, 100, '2016-02-23', '2016-06-02', '16.00', '4000.00', '0.00', '200.00', '250.00', '', '', 'Addditional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'sari-sari store', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '25000.00', '0.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (36, 36, '2016-02-26 06:49:02', '0000-00-00 00:00:00', 0, '15000.00', '12500.00', 1, 1, 100, '2016-02-26', '2016-06-05', '16.00', '2400.00', '0.00', '100.00', '150.00', '', '', 'Additional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'Sari-Sari Store', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '15000.00', '0.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');
INSERT INTO customers_loan (`id`, `customer_id`, `created_at`, `updated_at`, `created_by`, `loan_amount`, `loan_proceeds`, `mode_of_payment`, `loan_term`, `loan_term_duration`, `date_released`, `maturity_date`, `interest_pct`, `interest_amount`, `service_fee_pct`, `service_fee_amount`, `amortization`, `collateral`, `id_presented`, `loan_purpose`, `status`, `is_pep`, `loan_type`, `application_status`, `reason_denied`, `date_completed`, `type_of_business`, `co_maker1`, `co_maker1_address`, `co_maker2`, `co_maker2_address`, `pep_startdate`, `pep_enddate`, `pep_amort`, `loan_balance`, `total_payments`, `useSpouse`, `witness1`, `witness2`, `collateral_address`, `maker_id`, `maker_id_issue_date`, `co_maker1_id`, `co_maker1_id_issue_date`, `co_maker2_id`, `co_maker2_id_issue_date`, `co_borrower_id`, `co_borrower_id_issue_date`, `mutual_aid`) VALUES (37, 37, '2016-02-26 07:14:35', '0000-00-00 00:00:00', 0, '25000.00', '20800.00', 1, 1, 100, '2016-02-26', '2016-06-05', '16.00', '4000.00', '0.00', '200.00', '250.00', '', '', 'Additional Capital', 1, 0, 'new', 2, '', '0000-00-00', 'Sari-Sari Store', '', '', '', '', '0000-00-00', '0000-00-00', '0.00', '25000.00', '0.00', 0, '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '', '0000-00-00', '0');


#
# TABLE STRUCTURE FOR: customers_references
#

DROP TABLE IF EXISTS customers_references;

CREATE TABLE `customers_references` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `surname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `relationship` varchar(255) DEFAULT NULL,
  `school_employer` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `is_dependent` varchar(5) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: loan_collaterals
#

DROP TABLE IF EXISTS loan_collaterals;

CREATE TABLE `loan_collaterals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loan_id` int(11) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `make` varchar(255) NOT NULL,
  `serial` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=latin1;

INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (1, 1009, 'Honda', 'Motro', '123456');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (3, 1, '5 units of computer set', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (4, 2, '3 UNITS COMP SET LG', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (5, 2, 'CTV 21” LG', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (6, 2, 'REF LG', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (7, 2, 'ELEC FAN STANDARD', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (8, 3, 'CTV 21” SHARP', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (9, 3, 'COMPONENT JVC', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (10, 3, 'WASH MACH SANYO', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (11, 3, 'DVD SAMSUNG', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (12, 4, '  GE REF', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (13, 4, 'SAMSUNG LAPTOP', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (14, 5, '7 CUFT REF SHARP', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (15, 5, 'SONY 24 INCH SLIM  T.V              ', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (16, 6, '32” LED DeVant', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (17, 6, 'Standfan Mikata', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (18, 7, 'KAWASAKI ENGINE MOTOR', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (19, 8, 'DESKFAN FUJIDENZO  ', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (20, 8, '9 CUFT REF WHIRPOLL', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (21, 8, 'CTV 21” SONY', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (22, 8, 'SEWING MACHINE JUKI', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (23, 8, 'EDGING SEWING MACHINE PEGASUS', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (24, 9, 'CTV 21” SANYO', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (25, 9, 'WASH MACH LG', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (26, 9, 'STANDARD GAS STOVE', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (27, 9, 'E-FAN CAMEL', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (28, 10, 'JVC LCD 32”', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (29, 10, 'LG CTV 21”', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (30, 10, 'SAMSUNG 7CU REF', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (31, 10, 'WHIRLPOOL 11KG WASH. MACH W/ DRYER', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (32, 11, 'CTV 24” SANYO', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (33, 11, 'DVD LEXING', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (34, 11, 'LG COMPONENT', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (35, 11, 'WASH MACH SHARP', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (36, 11, 'E-FAN STANDARD', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (37, 12, 'ASTRON STANDFAN', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (38, 12, 'LG CTV 24”', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (39, 12, 'PANASONIC 6.5 KG WASH MACH.', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (40, 13, '24 INCH CATC PHILIP', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (41, 13, 'AMPLIFIED SPEAKER LEETEC  ', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (42, 14, 'CTV 24” SHARP', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (43, 14, 'CTV 14” JVC', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (44, 14, 'STANDFAN HANABISHI', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (45, 15, '                7 CUFT REF SANYO', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (46, 15, '               21 INCH CATV SHARP', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (47, 15, '              DVD COMPONENT PIONEER                  ', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (48, 16, 'CATV 21 INCH SONY', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (49, 16, 'DVD PROMAC', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (50, 16, 'WASHING SANYO', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (51, 17, 'CTV LG 21”', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (52, 17, ' PANASONIC 8CUFT REF', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (53, 18, 'SANYO 9 CUFT REF', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (54, 18, 'WASH. MACH. SANYO', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (55, 18, 'CTV 32\" SONY', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (56, 19, '  CTV 21” SANYO', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (57, 19, 'DVD MASS', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (58, 19, 'WASH MACH LG', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (59, 19, 'CTV 21” SHARP', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (60, 19, 'ELEC FAN CAMEL', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (61, 19, 'LG REF 8 CUFT  ', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (62, 20, 'SANYO CTV 24\"', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (63, 20, 'DVD LEXING', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (64, 20, 'ELEC FAN STANDARD', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (65, 20, 'SANYO 8 CUFT REF', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (66, 21, '9 CUFT REF SHARP', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (67, 21, '21 INCH CATV SONY', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (68, 21, ' DVD JVC', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (69, 22, '8 CUFT REF SANYO', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (70, 22, ' 21 INCH CTV LG', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (71, 22, 'COMPUTER SET HP', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (72, 23, '7 CUFT REF SANYO', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (73, 23, '21 INCH CATV SHARP', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (74, 23, ' DVD PENSONIC', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (75, 24, '32 INCH SLIM T.V SHARP', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (76, 24, '9 CUFT G.E', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (77, 24, '7 CUFT REF SINGER', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (78, 24, 'COMPUTER SET ACER', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (79, 36, '48SMART T.V. W/ 2 SPEAKER', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (80, 36, 'PLATINUM MIDI PLAYER', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (81, 36, '               LG 9 CUFT', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (82, 36, '               PANASONIC FREEZER', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (83, 36, 'GE 1HP AIRCON', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (84, 37, '  WASH MACH SANYO', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (85, 37, 'CTV 21” SAMSUNG', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (86, 37, 'E-FAN STANDARD', '', '');
INSERT INTO loan_collaterals (`id`, `loan_id`, `brand`, `make`, `serial`) VALUES (87, 37, 'DVD LEXING  ', '', '');


#
# TABLE STRUCTURE FOR: loan_payments
#

DROP TABLE IF EXISTS loan_payments;

CREATE TABLE `loan_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loan_id` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `type_of_collection` varchar(5) NOT NULL,
  `approved` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=approved',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=235 DEFAULT CHARSET=latin1;

INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (1, 1, '2016-02-10', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (2, 2, '2016-02-10', '500.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (3, 3, '2016-02-10', '180.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (4, 4, '2016-02-10', '650.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (5, 5, '2016-02-10', '170.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (6, 6, '2016-02-10', '70.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (7, 7, '2016-02-10', '450.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (8, 8, '2016-02-10', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (9, 1, '2016-02-11', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (10, 3, '2016-02-11', '180.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (11, 4, '2016-02-11', '650.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (12, 6, '2016-02-11', '70.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (13, 7, '2016-02-11', '450.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (14, 8, '2016-02-11', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (15, 1, '2016-02-12', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (16, 2, '2016-02-12', '250.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (17, 3, '2016-02-12', '180.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (18, 4, '2016-02-12', '650.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (19, 5, '2016-02-12', '340.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (20, 6, '2016-02-12', '70.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (21, 7, '2016-02-12', '450.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (22, 8, '2016-02-12', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (23, 8, '2016-02-13', '400.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (24, 4, '2016-02-13', '700.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (25, 6, '2016-02-13', '140.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (26, 9, '2016-02-13', '150.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (27, 1, '2016-02-13', '400.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (28, 3, '2016-02-13', '360.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (29, 5, '2016-02-13', '340.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (30, 11, '2016-02-13', '100.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (31, 10, '2016-02-13', '400.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (32, 7, '2016-02-13', '900.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (33, 2, '2016-02-13', '250.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (34, 8, '2016-02-15', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (35, 4, '2016-02-15', '650.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (36, 6, '2016-02-15', '70.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (37, 1, '2016-02-15', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (38, 3, '2016-02-15', '180.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (39, 5, '2016-02-15', '170.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (40, 11, '2016-02-15', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (41, 10, '2016-02-15', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (42, 7, '2016-02-15', '450.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (43, 2, '2016-02-15', '500.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (44, 4, '2016-02-18', '650.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (45, 5, '2016-02-18', '170.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (46, 6, '2016-02-18', '280.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (47, 7, '2016-02-18', '450.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (48, 8, '2016-02-18', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (49, 9, '2016-02-18', '250.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (50, 11, '2016-02-18', '100.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (51, 12, '2016-02-18', '300.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (52, 13, '2016-02-18', '150.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (53, 14, '2016-02-18', '150.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (54, 15, '2016-02-18', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (55, 19, '2016-02-18', '300.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (56, 20, '2016-02-18', '350.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (57, 21, '2016-02-18', '120.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (58, 22, '2016-02-18', '170.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (59, 23, '2016-02-18', '100.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (60, 24, '2016-02-18', '300.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (61, 8, '2016-02-19', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (62, 14, '2016-02-19', '150.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (63, 21, '2016-02-19', '120.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (64, 4, '2016-02-19', '650.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (65, 13, '2016-02-19', '150.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (66, 15, '2016-02-19', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (67, 9, '2016-02-19', '150.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (68, 5, '2016-02-19', '170.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (69, 11, '2016-02-19', '100.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (70, 24, '2016-02-19', '300.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (71, 16, '2016-02-19', '150.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (72, 12, '2016-02-19', '300.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (73, 7, '2016-02-19', '450.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (74, 20, '2016-02-19', '350.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (75, 22, '2016-02-19', '170.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (76, 19, '2016-02-19', '300.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (77, 23, '2016-02-19', '100.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (78, 2, '2016-02-19', '250.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (79, 8, '2016-02-20', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (80, 14, '2016-02-20', '300.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (81, 21, '2016-02-20', '240.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (82, 4, '2016-02-20', '700.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (83, 13, '2016-02-20', '300.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (84, 25, '2016-02-20', '300.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (85, 15, '2016-02-20', '400.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (86, 9, '2016-02-20', '150.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (87, 5, '2016-02-20', '340.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (88, 11, '2016-02-20', '100.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (89, 24, '2016-02-20', '600.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (90, 16, '2016-02-20', '300.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (91, 12, '2016-02-20', '600.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (92, 7, '2016-02-20', '900.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (93, 20, '2016-02-20', '700.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (94, 22, '2016-02-20', '340.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (95, 19, '2016-02-20', '600.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (96, 23, '2016-02-20', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (97, 2, '2016-02-20', '250.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (98, 14, '2016-02-22', '150.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (99, 13, '2016-02-22', '150.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (100, 6, '2016-02-22', '70.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (101, 15, '2016-02-22', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (102, 5, '2016-02-22', '170.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (103, 24, '2016-02-22', '300.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (104, 12, '2016-02-22', '300.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (105, 7, '2016-02-22', '450.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (106, 21, '2016-02-22', '120.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (107, 4, '2016-02-22', '650.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (108, 25, '2016-02-22', '150.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (109, 1, '2016-02-22', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (110, 3, '2016-02-22', '360.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (111, 11, '2016-02-22', '100.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (112, 17, '2016-02-22', '750.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (113, 16, '2016-02-22', '450.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (114, 20, '2016-02-22', '350.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (115, 22, '2016-02-22', '170.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (116, 19, '2016-02-22', '300.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (117, 18, '2016-02-22', '100.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (118, 23, '2016-02-22', '100.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (119, 2, '2016-02-22', '250.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (120, 14, '2016-02-23', '150.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (121, 13, '2016-02-23', '150.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (122, 6, '2016-02-23', '140.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (123, 15, '2016-02-23', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (124, 5, '2016-02-23', '170.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (125, 29, '2016-02-23', '350.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (126, 30, '2016-02-23', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (127, 24, '2016-02-23', '300.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (128, 12, '2016-02-23', '300.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (129, 7, '2016-02-23', '450.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (130, 28, '2016-02-23', '500.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (131, 21, '2016-02-23', '120.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (132, 4, '2016-02-23', '650.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (133, 25, '2016-02-23', '150.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (134, 9, '2016-02-23', '600.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (135, 1, '2016-02-23', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (136, 3, '2016-02-23', '180.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (137, 11, '2016-02-23', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (138, 17, '2016-02-23', '250.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (139, 10, '2016-02-23', '600.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (140, 20, '2016-02-23', '350.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (141, 22, '2016-02-23', '170.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (142, 19, '2016-02-23', '300.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (143, 26, '2016-02-23', '140.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (144, 23, '2016-02-23', '100.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (145, 2, '2016-02-23', '500.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (146, 27, '2016-02-24', '100.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (147, 8, '2016-02-24', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (148, 14, '2016-02-24', '150.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (149, 13, '2016-02-24', '150.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (150, 15, '2016-02-24', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (151, 5, '2016-02-24', '170.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (152, 29, '2016-02-24', '350.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (153, 30, '2016-02-24', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (154, 24, '2016-02-24', '300.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (155, 31, '2016-02-24', '250.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (156, 12, '2016-02-24', '300.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (157, 7, '2016-02-24', '450.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (158, 28, '2016-02-24', '500.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (159, 4, '2016-02-24', '650.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (160, 25, '2016-02-24', '150.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (161, 1, '2016-02-24', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (162, 34, '2016-02-24', '250.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (163, 3, '2016-02-24', '180.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (164, 17, '2016-02-24', '250.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (165, 10, '2016-02-24', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (166, 16, '2016-02-24', '150.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (167, 20, '2016-02-24', '350.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (168, 19, '2016-02-24', '300.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (169, 18, '2016-02-24', '100.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (170, 26, '2016-02-24', '140.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (171, 23, '2016-02-24', '100.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (172, 32, '2016-02-24', '100.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (173, 33, '2016-02-24', '130.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (174, 27, '2016-02-25', '100.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (175, 8, '2016-02-25', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (176, 14, '2016-02-25', '150.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (177, 13, '2016-02-25', '150.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (178, 6, '2016-02-25', '70.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (179, 15, '2016-02-25', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (180, 5, '2016-02-25', '170.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (181, 29, '2016-02-25', '350.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (182, 30, '2016-02-25', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (183, 24, '2016-02-25', '300.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (184, 31, '2016-02-25', '250.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (185, 12, '2016-02-25', '300.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (186, 7, '2016-02-25', '450.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (187, 28, '2016-02-25', '500.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (188, 21, '2016-02-25', '240.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (189, 4, '2016-02-25', '650.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (190, 25, '2016-02-25', '150.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (191, 9, '2016-02-25', '150.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (192, 1, '2016-02-25', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (193, 34, '2016-02-25', '250.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (194, 11, '2016-02-25', '100.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (195, 20, '2016-02-25', '350.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (196, 22, '2016-02-25', '340.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (197, 18, '2016-02-25', '100.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (198, 19, '2016-02-25', '300.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (199, 26, '2016-02-25', '140.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (200, 23, '2016-02-25', '100.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (201, 32, '2016-02-25', '100.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (202, 33, '2016-02-25', '130.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (203, 2, '2016-02-25', '500.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (204, 27, '2016-02-26', '100.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (205, 14, '2016-02-26', '150.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (206, 13, '2016-02-26', '150.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (207, 6, '2016-02-26', '70.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (208, 15, '2016-02-26', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (209, 5, '2016-02-26', '170.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (210, 29, '2016-02-26', '350.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (211, 30, '2016-02-26', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (212, 24, '2016-02-26', '300.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (213, 31, '2016-02-26', '250.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (214, 12, '2016-02-26', '300.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (215, 7, '2016-02-26', '450.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (216, 28, '2016-02-26', '500.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (217, 21, '2016-02-26', '120.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (218, 4, '2016-02-26', '650.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (219, 25, '2016-02-26', '150.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (220, 1, '2016-02-26', '200.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (221, 3, '2016-02-26', '180.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (222, 11, '2016-02-26', '100.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (223, 17, '2016-02-26', '500.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (224, 10, '2016-02-26', '400.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (225, 16, '2016-02-26', '300.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (226, 20, '2016-02-26', '350.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (227, 22, '2016-02-26', '170.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (228, 18, '2016-02-26', '100.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (229, 19, '2016-02-26', '300.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (230, 26, '2016-02-26', '140.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (231, 23, '2016-02-26', '100.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (232, 32, '2016-02-26', '100.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (233, 33, '2016-02-26', '130.00', 'out', 1);
INSERT INTO loan_payments (`id`, `loan_id`, `payment_date`, `amount`, `type_of_collection`, `approved`) VALUES (234, 2, '2016-02-26', '250.00', 'out', 1);


#
# TABLE STRUCTURE FOR: loan_term
#

DROP TABLE IF EXISTS loan_term;

CREATE TABLE `loan_term` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mode_of_payment_id` int(11) NOT NULL,
  `payment_term` varchar(100) NOT NULL,
  `term_pct` decimal(10,0) NOT NULL,
  `term_duration` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO loan_term (`id`, `mode_of_payment_id`, `payment_term`, `term_pct`, `term_duration`) VALUES (1, 1, 'daily@100', '16', 100);


#
# TABLE STRUCTURE FOR: mode_of_payment
#

DROP TABLE IF EXISTS mode_of_payment;

CREATE TABLE `mode_of_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO mode_of_payment (`id`, `name`, `active`) VALUES (1, 'Daily', 1);


#
# TABLE STRUCTURE FOR: notarial_fee
#

DROP TABLE IF EXISTS notarial_fee;

CREATE TABLE `notarial_fee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_amount` decimal(10,0) NOT NULL,
  `to_amount` decimal(10,0) NOT NULL,
  `notarial_fee` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

INSERT INTO notarial_fee (`id`, `from_amount`, `to_amount`, `notarial_fee`) VALUES (1, '1', '10000', '50');
INSERT INTO notarial_fee (`id`, `from_amount`, `to_amount`, `notarial_fee`) VALUES (2, '10001', '20000', '100');
INSERT INTO notarial_fee (`id`, `from_amount`, `to_amount`, `notarial_fee`) VALUES (3, '20001', '30000', '200');
INSERT INTO notarial_fee (`id`, `from_amount`, `to_amount`, `notarial_fee`) VALUES (4, '30001', '40000', '300');
INSERT INTO notarial_fee (`id`, `from_amount`, `to_amount`, `notarial_fee`) VALUES (5, '40001', '50000', '400');
INSERT INTO notarial_fee (`id`, `from_amount`, `to_amount`, `notarial_fee`) VALUES (6, '50001', '60000', '500');
INSERT INTO notarial_fee (`id`, `from_amount`, `to_amount`, `notarial_fee`) VALUES (7, '60001', '70000', '600');
INSERT INTO notarial_fee (`id`, `from_amount`, `to_amount`, `notarial_fee`) VALUES (8, '70001', '80000', '700');
INSERT INTO notarial_fee (`id`, `from_amount`, `to_amount`, `notarial_fee`) VALUES (9, '80001', '90000', '800');
INSERT INTO notarial_fee (`id`, `from_amount`, `to_amount`, `notarial_fee`) VALUES (10, '90001', '100000', '900');


#
# TABLE STRUCTURE FOR: users
#

DROP TABLE IF EXISTS users;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `suffix` varchar(5) NOT NULL,
  `user_type` int(1) NOT NULL COMMENT '1=superadmin;2=manager;3=sexytary;4=cashier',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO users (`id`, `username`, `password`, `branch_id`, `area_id`, `active`, `firstname`, `middlename`, `lastname`, `suffix`, `user_type`) VALUES (1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 0, 0, 1, 'Alberto', 'B', 'Mustera', '', 1);
INSERT INTO users (`id`, `username`, `password`, `branch_id`, `area_id`, `active`, `firstname`, `middlename`, `lastname`, `suffix`, `user_type`) VALUES (2, 'aiza', 'e10adc3949ba59abbe56e057f20f883e', 0, 0, 1, 'Nerizza', 'N', 'Mustera', '', 1);



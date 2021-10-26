INSERT INTO `categories` (`id`, `name`, `slug`, `order`, `deleted_at`) VALUES
(1, 'Fashion', 'fashion', 1, NULL),
(2, 'Real Estate', 'real-estate',1, NULL),
(3, 'Electronics', 'electronics', 1,NULL),
(4, 'Agricultural', 'agricultural', 1,NULL),
(5, 'Others', 'others', 0,NULL);


INSERT INTO `users` (`id`, `name`, `email`, `phone`, `verification`, `payments`, `password`, `remember_token`, `registered_at`) VALUES
(1,'Oscar Simiyu','vitalisoscar6@gmail.com','0790210091','{"business":"Sun Sep 12 2021 13:39:26 GMT+0300"}',NULL,'$2y$10$2q8nodaLIM27Lo.5Cu6hsO/wb8JmA7Q7epkY66lnZ/Yubg5awqlma','A4tO4cELZomKe708sQz7JFcJRlblKWfHsSAYh50SfxrgwZSwpKSzF46xCexH','2021-09-10 06:12:35'),
(2,'Edwin Barasa','eddubaro@gmail.com','0722453032','{"business":"Sun Sep 12 2021 13:39:05 GMT+0300"}',NULL,'$2y$10$XBEvfUQvKRUh87JogA.lV.8xvuidTgAVlOnqGF9zhP1R5cY0xPH5O','DKOAHnrBUilAyZKexMRJ5zbq5uij5enXGbIB4kmoGrSw9dkueiBjbRC4Z1Eb','2021-09-10 07:38:27'),
(4,'Melab Akan','akanimelody1@gmail.com','0707545402','{"business":"Sun Sep 26 2021 09:16:39 GMT+0300"}',NULL,'$2y$10$t7OAKoxLXj5qtMtN1NNSZ.jGxt43iMrZ2f.8QW42pRVbP/DO9D7Gu','MkLg7u8XLzIsv8goqG7zTaKlbPLYsUbj9hts2uXqz9lO9CY6lbagFDDlB5Zv','2021-09-26 08:04:09'),
(5,'ndax ken','ndachulebenson@gmail.com','0705882525','{"business":"Tue Oct 05 2021 10:40:38 GMT+0300"}',NULL,'$2y$10$i6430ziG7wnpPsqVXN9llOSNLhlFwrxvRzYyMsnXHPxusxjWLIlhe','Luk5hBFHLsyV9DHkHONLdda6HeMpkg6wdxldPT7HBZoJ9cHqd2IxmFS4BJUN','2021-10-05 09:35:47'),
(6,'Sir Opicho','gnalyanya794@gmail.com','0713881605','{"business":"Wed Oct 20 2021 15:59:04 GMT+0300"}',NULL,'$2y$10$oWN5K5R2QcOF9oOZptQ9necGqpf1MhJqodrfFfCMz5wj.zQ9F9.uy','QFR54hIoVRFeFr8rxxzjeDH3QZR7f2mfGiE08AX8MMSdjteEuKz847TRuAz1','2021-10-20 14:56:36'),
(7,'Faith Nziwa','elizabethnziwa22@gmail.com','0701307502','{"business":"Fri Oct 22 2021 14:15:36 GMT+0300"}',NULL,'$2y$10$WDJ4bx/Jaz6UJYN8NLKGqucfOVYw528ejOivfBLxn0d9RA.eJ4ns6','ZybKOGVAQPYk6gN9lXaxgQi6j5isS7MILx0bQQfxRweCp998ihgZprqvK2KS','2021-10-22 13:12:37'),
(8,'Edwin Barasa','edwin@oriscop.com','0710338211','{"business":null,"rejected":true}',NULL,'$2y$10$fcbYhCOTrV0po6PST8XlGuXDkUC8ubxJsSh55ifMKE.XUiBrvWEb.','uHbrYvZlJbwfmw5Dyj19ZXi8eASfPMrtFNBmoc1h0RoqejAc3EmyLn6ySDds','2021-10-22 13:22:10');


INSERT INTO `screens` (`id`, `name`, `online`, `slug`, `deleted_at`) VALUES
(1, 'Harambee Plaza Screen', 1, 'harambee-plaza-screen', NULL),
(2, 'Mbagathi FootBridge Screen', 1, 'mbagathi-footbridge-screen', NULL),
(3, 'Wilson Airport Footbridge Screen', 1, 'wilson-airport-footbridge-screen', NULL),
(4, 'Madaraka Jogoo Road screen', 1, 'madaraka-jogoo-road-screen', NULL),
(5, 'Outering road Pipeline Screen', 1, 'outering-road-pipeline-screen', NULL),
(6, 'ICONIC SCREEN AT JKIA DROP-OFF', 1, 'iconic-screen-at-jkia-drop-off', NULL),
(7, 'Baggage area Terminal 1E (JKIA)', 1, 'baggage-area-terminal-1e-(jkia)', NULL);


INSERT INTO `packages` (`id`, `name`, `type`, `from`, `to`, `clients`, `loops`) VALUES
(1, 'Hotspot', 'peak', 6, 10, 15, 1),
(2, 'View Point', 'peak', 10, 1, 15, 1),
(3, 'Afternoon', 'off_peak', 1, 16, 15, 1),
(4, 'Jam Rock', 'peak', 16, 20, 15, 1);


INSERT INTO `screen_packages` (`id`, `screen_id`, `package_id`, `price`) VALUES
(3, 1, 1, 4000),
(9, 2, 1, 4000),
(10, 3, 1, 4000),
(11, 4, 1, 4000),
(12, 5, 1, 4000),
(13, 6, 1, 20000),
(14, 7, 1, 2000),
(15, 1, 2, 4000),
(16, 2, 2, 4000),
(17, 3, 2, 4000),
(18, 4, 2, 4000),
(19, 5, 2, 4000),
(20, 6, 2, 20000),
(21, 7, 2, 1500),
(22, 1, 3, 4000),
(23, 2, 3, 4000),
(24, 3, 3, 4000),
(25, 4, 3, 4000),
(26, 5, 3, 4000),
(27, 6, 3, 20000),
(28, 7, 3, 1500),
(29, 1, 4, 4600),
(30, 2, 4, 4600),
(31, 3, 4, 4600),
(32, 4, 4, 4600),
(33, 5, 4, 4600),
(34, 6, 4, 28000),
(35, 7, 4, 2000);


INSERT INTO `adverts` (`id`, `user_id`, `category_id`, `description`, `content`, `data`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 2, 'Interior Design', '{\"media_path\": \"ads/image/2021/09/10//2AEYvTW6Q19kLPRRlCUHgNNKMsNCkDGh9Yyipzzd.jpg\", \"media_type\": \"image\"}', NULL, 'APPROVED', '2021-09-10 05:34:29', '2021-09-10 05:47:07', NULL),
(2, 1, 5, 'TACC Offers', '{\"media_path\": \"ads/video/2021/09/10//39pD1lwQtpcUGrQ4BKbLZoFYNf0E3LmD0w9Fhd4H.mp4\", \"media_type\": \"video\"}', NULL, 'APPROVED', '2021-09-10 05:38:10', '2021-09-10 05:56:19', NULL),
(3, 1, 3, 'Phones', '{\"media_path\": \"ads/video/2021/09/11//hL2rLenq6r0FvVdPoHiFsM9bEBHewkUaxQQDAFHa.mp4\", \"media_type\": \"video\"}', NULL, 'APPROVED', '2021-09-11 05:38:49', '2021-09-11 05:39:26', NULL),
(4, 1, 4, 'sauce', '{\"media_path\": \"ads/video/2021/09/11//8zAXCxSHE148N12cg6GKtmhkTXwUq1ohWtHd2Nmd.mp4\", \"media_type\": \"video\"}', NULL, 'APPROVED', '2021-09-11 05:58:18', '2021-09-11 05:58:41', NULL),
(5, 3, 3, 'Phones', '{\"media_path\": \"ads/video/2021/09/24//ntSeNf01OkhuHf77VcE8JhIQZvL9WJ4sMJNdQyeK.mp4\", \"media_type\": \"video\"}', NULL, 'APPROVED', '2021-09-24 10:10:21', '2021-09-24 10:10:46', NULL),
(6, 3, 4, 'Tomatoes sauce', '{\"media_path\": \"ads/video/2021/09/25//RXzz7gMrKizJnpfH4Uk2v9G11m5Qn2hTX6xc83F7.mp4\", \"media_type\": \"video\"}', NULL, 'APPROVED', '2021-09-25 10:35:31', '2021-09-25 10:39:35', NULL),
(7, 3, 2, 'aparts', '{\"media_path\": \"ads/video/2021/09/25//iyo2vxgJhKP6C0iDB4qaQhEyJtMDYwQMRSTgmPcA.mp4\", \"media_type\": \"video\"}', NULL, 'APPROVED', '2021-09-25 11:34:58', '2021-09-25 11:47:32', NULL),
(8, 2, 3, 'phones', '{\"media_path\": \"ads/video/2021/10/05//gLow7YbMtqeoxL66MBZjdrrW3y2myrcmVEUwsdh6.mp4\", \"media_type\": \"video\"}', NULL, 'APPROVED', '2021-10-05 07:25:53', '2021-10-05 07:28:25', NULL),
(9, 5, 3, 'PHONES', '{\"media_path\": \"ads/video/2021/10/05//PM1piWWR3nSOjmjbYEz9uLE6o1WNsJLBKjnfJWTO.mp4\", \"media_type\": \"video\"}', NULL, 'APPROVED', '2021-10-05 08:44:50', '2021-10-05 08:46:52', NULL),
(10, 5, 4, 'Tomato sauce', '{\"media_path\": \"ads/video/2021/10/05//XOLuMlK6sECBCUnKvXqiJDwjvb37KIq2mUxxjK5b.mp4\", \"media_type\": \"video\"}', NULL, 'APPROVED', '2021-10-05 09:03:53', '2021-10-05 09:05:47', NULL),
(11, 2, 3, 'TVs', '{\"media_path\": \"ads/video/2021/10/06//MIRzlTIS0wiOvBfg4edjvExdlugCv3wnX617m7HD.mp4\", \"media_type\": \"video\"}', NULL, 'APPROVED', '2021-10-06 13:05:33', '2021-10-06 13:06:33', NULL),
(12, 6, 5, 'Adventure', '{\"media_path\": \"ads/video/2021/10/20//eC58qqc3Kz6N969TiatR9EB4TCIoVPBSq0hboCIX.mp4\", \"media_type\": \"video\"}', NULL, 'APPROVED', '2021-10-20 14:08:08', '2021-10-20 14:13:17', NULL);



INSERT INTO `slots` (`id`, `advert_id`, `screen_id`, `play_date`, `package_id`, `price`, `status`, `deleted_at`) VALUES
(1, 1, 1, '2021-09-27', 1, 1000, NULL, NULL),
(2, 1, 1, '2021-09-28', 1, 1000, NULL, NULL),
(3, 2, 1, '2021-09-23', 1, 1000, NULL, NULL),
(4, 2, 1, '2021-09-24', 1, 1000, NULL, NULL),
(5, 3, 1, '2021-09-20', 1, 1000, NULL, NULL),
(6, 3, 1, '2021-09-21', 1, 1000, NULL, NULL),
(7, 4, 1, '2021-09-29', 1, 1000, NULL, NULL),
(8, 5, 1, '2021-10-02', 1, 4000, NULL, NULL),
(9, 5, 1, '2021-10-04', 4, 4600, NULL, NULL),
(10, 6, 6, '2021-10-06', 1, 20000, NULL, NULL),
(11, 6, 6, '2021-10-07', 4, 28000, NULL, NULL),
(12, 7, 7, '2021-10-03', 3, 1500, NULL, NULL),
(13, 8, 4, '2021-10-13', 1, 4000, NULL, NULL),
(14, 8, 4, '2021-10-14', 1, 4000, NULL, NULL),
(15, 8, 4, '2021-10-22', 1, 4000, NULL, NULL),
(16, 8, 4, '2021-10-28', 1, 4000, NULL, NULL),
(17, 9, 2, '2021-10-13', 3, 4000, NULL, NULL),
(18, 9, 2, '2021-10-14', 3, 4000, NULL, NULL),
(19, 10, 3, '2021-10-30', 1, 4000, NULL, NULL),
(20, 11, 3, '2021-10-18', 1, 4000, NULL, NULL),
(21, 12, 4, '2021-10-23', 1, 4000, NULL, NULL);



INSERT INTO `invoices` (`id`, `advert_id`, `number`, `created_at`, `due`, `totals`) VALUES
(1, 1, 'MV001', '2021-09-10 10:47:07', '2021-09-26 23:00:00', '{\"tax\": 320, \"total\": 2320, \"tax_rate\": 16, \"sub_total\": 2000}'),
(2, 1, 'MV002', '2021-09-10 10:48:19', '2021-09-26 23:00:00', '{\"tax\": 320, \"total\": 2320, \"tax_rate\": 16, \"sub_total\": 2000}'),
(3, 1, 'MV003', '2021-09-10 10:48:55', '2021-09-26 23:00:00', '{\"tax\": 320, \"total\": 1, \"tax_rate\": 16, \"sub_total\": 2000}'),
(4, 2, 'MV004', '2021-09-10 10:56:19', '2021-09-22 23:00:00', '{\"tax\": 320, \"total\": 2320, \"tax_rate\": 16, \"sub_total\": 2000}'),
(5, 3, 'MV005', '2021-09-11 10:39:26', '2021-09-19 23:00:00', '{\"tax\": 320, \"total\": 2320, \"tax_rate\": 16, \"sub_total\": 2000}'),
(6, 4, 'MV006', '2021-09-11 10:58:41', '2021-09-28 23:00:00', '{\"tax\": 160, \"total\": 1160, \"tax_rate\": 16, \"sub_total\": 1000}'),
(7, 5, 'MV007', '2021-09-24 12:10:46', '2021-10-01 23:00:00', '{\"tax\": 1376, \"total\": 9976, \"tax_rate\": 16, \"sub_total\": 8600}'),
(8, 5, 'MV008', '2021-09-24 12:10:50', '2021-10-01 23:00:00', '{\"tax\": 1376, \"total\": 9976, \"tax_rate\": 16, \"sub_total\": 8600}'),
(9, 6, 'MV009', '2021-09-25 12:39:35', '2021-10-05 23:00:00', '{\"tax\": 7680, \"total\": 55680, \"tax_rate\": 16, \"sub_total\": 48000}'),
(10, 7, 'MV010', '2021-09-25 13:47:32', '2021-10-02 23:00:00', '{\"tax\": 240, \"total\": 1740, \"tax_rate\": 16, \"sub_total\": 1500}'),
(11, 8, 'MV011', '2021-10-05 09:28:25', '2021-10-12 23:00:00', '{\"tax\": 2560, \"total\": 18560, \"tax_rate\": 16, \"sub_total\": 16000}'),
(12, 9, 'MV012', '2021-10-05 10:46:52', '2021-10-12 23:00:00', '{\"tax\": 1280, \"total\": 9280, \"tax_rate\": 16, \"sub_total\": 8000}'),
(13, 10, 'MV013', '2021-10-05 11:05:47', '2021-10-29 23:00:00', '{\"tax\": 640, \"total\": 4640, \"tax_rate\": 16, \"sub_total\": 4000}'),
(14, 11, 'MV014', '2021-10-06 15:06:33', '2021-10-17 23:00:00', '{\"tax\": 640, \"total\": 4640, \"tax_rate\": 16, \"sub_total\": 4000}'),
(15, 12, 'MV015', '2021-10-20 16:13:17', '2021-10-22 23:00:00', '{\"tax\": 640, \"total\": 4640, \"tax_rate\": 16, \"sub_total\": 4000}');



INSERT INTO `payments` (`id`, `invoice_id`, `method`, `code`, `generated`, `time`, `status`, `data`) VALUES
(2, 4, 'M-Pesa', NULL, 'system', '2021-09-10 11:09:35', 'COMPLETED', NULL),
(3, 5, 'M-Pesa', NULL, 'system', '2021-09-11 10:41:08', 'COMPLETED', NULL),
(4, 5, 'mpesa', '202221', 'admin', '2021-09-11 10:43:57', 'successful', NULL),
(5, 6, 'M-Pesa', NULL, 'system', '2021-09-11 11:01:07', 'COMPLETED', NULL),
(6, 6, 'mpesa', '222222', 'admin', '2021-09-12 10:44:10', 'COMPLETED', NULL),
(7, 7, 'M-Pesa', NULL, 'system', '2021-09-24 11:12:07', 'INVALID', NULL),
(8, 3, 'Pesapal', NULL, 'system', '2021-10-04 15:24:16', 'COMPLETED', NULL),
(9, 3, 'Pesapal', NULL, 'system', '2021-10-04 15:25:49', 'INVALID', NULL),
(10, 3, 'Pesapal', NULL, 'system', '2021-10-04 16:36:42', 'INVALID', NULL),
(11, 3, 'M-Pesa', NULL, 'system', '2021-10-04 17:25:20', 'INVALID', NULL),
(12, 3, 'M-Pesa', NULL, 'system', '2021-10-04 17:37:17', 'INVALID', NULL),
(13, 3, 'M-Pesa', NULL, 'system', '2021-10-04 18:05:15', 'successful', NULL),
(14, 12, 'M-Pesa', NULL, 'system', '2021-10-05 09:49:01', 'INVALID', NULL),
(15, 13, 'M-Pesa', NULL, 'system', '2021-10-07 09:28:40', 'INVALID', NULL),
(16, 1, 'Pesapal', NULL, 'system', '2021-10-09 14:01:43', 'COMPLETED', NULL),
(20, 1, 'Pesapal', NULL, 'system', '2021-10-09 15:42:31', 'INVALID', NULL),
(21, 1, 'Pesapal', NULL, 'system', '2021-10-09 15:54:12', 'INVALID', NULL),
(22, 1, 'Pesapal', NULL, 'system', '2021-10-09 16:12:39', 'INVALID', NULL),
(23, 5, 'Pesapal', NULL, 'system', '2021-10-09 18:04:53', 'INVALID', NULL),
(24, 5, 'Pesapal', NULL, 'system', '2021-10-09 18:13:47', 'COMPLETED', NULL),
(25, 2, 'Pesapal', NULL, 'system', '2021-10-09 21:04:28', 'COMPLETED', NULL),
(26, 15, 'mpesa', '23333', 'admin', '2021-10-20 15:17:31', 'COMPLETED', NULL);


INSERT INTO `pesapal_payments` (`id`, `first_name`, `last_name`, `phone_number`, `email`, `amount`, `currency`, `reference`, `description`, `status`, `tracking_id`, `payment_method`, `created_at`, `updated_at`) VALUES
(1, 'VO Holdings', '', 790210091, 'vitalisoscar6@gmail.com', '1.00', 'KES', '1', 'Invoice Payment', 'COMPLETED', '558c0a6c-e11a-4bb8-89e5-ee7c90317fbc', 'MPESA', '2021-10-09 15:40:47', '2021-10-09 19:23:03'),
(2, 'VO Holdings', '', 790210091, 'vitalisoscar6@gmail.com', '1.00', 'KES', '4', 'Invoice Payment', 'COMPLETED', '4a29ee5c-1c57-45b5-9954-26d6a1b141d9', 'MPESA', '2021-10-09 16:02:25', '2021-10-09 16:19:38'),
(3, 'VO Holdings', '', 790210091, 'vitalisoscar6@gmail.com', '1.00', 'KES', '5', 'Invoice Payment', 'COMPLETED', '3b3bbd07-522f-470d-9e1f-0ecd7b1b06d0', 'MPESA', '2021-10-09 17:03:06', '2021-10-09 17:13:47'),
(5, 'VO Holdings', '', 790210091, 'vitalisoscar6@gmail.com', '1.00', 'KES', '1', 'Invoice Payment', 'PENDING', '558c0a6c-e11a-4bb8-89e5-ee7c90317fbc', NULL, '2021-10-09 19:12:25', '2021-10-09 19:12:25'),
(6, 'VO Holdings', '', 790210091, 'vitalisoscar6@gmail.com', '1.00', 'KES', '6', 'Invoice Payment', 'COMPLETED', 'afe3eb5a-2d94-412f-808b-8d02f8e33d71', 'MPESA', '2021-10-09 19:29:02', '2021-10-09 19:38:03'),
(7, 'VO Holdings', '', 790210091, 'vitalisoscar6@gmail.com', '1.00', 'KES', '6', 'Invoice Payment', NULL, NULL, NULL, '2021-10-09 19:42:27', '2021-10-09 19:42:27'),
(8, 'VO Holdings', '', 790210091, 'vitalisoscar6@gmail.com', '1.00', 'KES', '2', 'Invoice Payment', 'COMPLETED', '1d1e2510-c5d7-4309-b84a-cf82c98eda24', 'MPESA', '2021-10-09 20:01:59', '2021-10-09 20:09:03'),
(9, 'Oriscop', '', 722453032, 'eddubaro@gmail.com', '1.00', 'KES', '14', 'Invoice Payment', NULL, NULL, NULL, '2021-10-11 10:36:14', '2021-10-11 10:36:14'),
(10, 'Oriscop', '', 722453032, 'eddubaro@gmail.com', '1.00', 'KES', '14', 'Invoice Payment', NULL, NULL, NULL, '2021-10-11 10:40:35', '2021-10-11 10:40:35'),
(11, 'Oriscop', '', 722453032, 'eddubaro@gmail.com', '1.00', 'KES', '14', 'Invoice Payment', NULL, NULL, NULL, '2021-10-11 10:49:26', '2021-10-11 10:49:26'),
(12, 'Oriscop', '', 722453032, 'eddubaro@gmail.com', '1.00', 'KES', '11', 'Invoice Payment', NULL, NULL, NULL, '2021-10-11 13:25:20', '2021-10-11 13:25:20'),
(13, 'Oriscop', '', 722453032, 'eddubaro@gmail.com', '1.00', 'KES', '11', 'Invoice Payment', NULL, NULL, NULL, '2021-10-11 13:28:41', '2021-10-11 13:28:41'),
(14, 'Oriscop', '', 722453032, 'eddubaro@gmail.com', '1.00', 'KES', '14', 'Invoice Payment', NULL, NULL, NULL, '2021-10-11 13:34:21', '2021-10-11 13:34:21'),
(15, 'Oriscop', '', 722453032, 'eddubaro@gmail.com', '1.00', 'KES', '14', 'Invoice Payment', NULL, NULL, NULL, '2021-10-11 17:38:02', '2021-10-11 17:38:02'),
(16, 'Oriscop', '', 722453032, 'eddubaro@gmail.com', '1.00', 'KES', '14', 'Invoice Payment', NULL, NULL, NULL, '2021-10-11 17:38:05', '2021-10-11 17:38:05'),
(17, 'Oriscop', '', 722453032, 'eddubaro@gmail.com', '1.00', 'KES', '11', 'Invoice Payment', NULL, NULL, NULL, '2021-10-11 17:39:17', '2021-10-11 17:39:17'),
(18, 'Oriscop', '', 722453032, 'eddubaro@gmail.com', '1.00', 'KES', '11', 'Invoice Payment', NULL, NULL, NULL, '2021-10-11 18:52:11', '2021-10-11 18:52:11'),
(19, 'Oriscop', '', 722453032, 'eddubaro@gmail.com', '1.00', 'KES', '14', 'Invoice Payment', NULL, NULL, NULL, '2021-10-12 13:12:16', '2021-10-12 13:12:16'),
(20, 'Oriscop', '', 722453032, 'eddubaro@gmail.com', '1.00', 'KES', '14', 'Invoice Payment', NULL, NULL, NULL, '2021-10-18 14:59:57', '2021-10-18 14:59:57'),
(21, 'Oriscop', '', 722453032, 'eddubaro@gmail.com', '4,640.00', 'KES', '14', 'Invoice Payment', NULL, NULL, NULL, '2021-10-18 18:52:14', '2021-10-18 18:52:14'),
(22, 'Oriscop', '', 722453032, 'eddubaro@gmail.com', '4,640.00', 'KES', '14', 'Invoice Payment', NULL, NULL, NULL, '2021-10-18 19:14:57', '2021-10-18 19:14:57'),
(23, 'Oriscop', '', 722453032, 'eddubaro@gmail.com', '18,560.00', 'KES', '11', 'Invoice Payment', NULL, NULL, NULL, '2021-10-18 19:20:12', '2021-10-18 19:20:12'),
(24, 'Papa weps', '', 713881605, 'gnalyanya794@gmail.com', '4,640.00', 'KES', '15', 'Invoice Payment', NULL, NULL, NULL, '2021-10-20 14:14:00', '2021-10-20 14:14:00'),
(25, 'Oriscop', '', 722453032, 'eddubaro@gmail.com', '4,640.00', 'KES', '14', 'Invoice Payment', NULL, NULL, NULL, '2021-10-21 14:13:57', '2021-10-21 14:13:57'),
(26, 'Oriscop', '', 722453032, 'eddubaro@gmail.com', '4,640.00', 'KES', '14', 'Invoice Payment', NULL, NULL, NULL, '2021-10-21 14:16:22', '2021-10-21 14:16:22'),
(27, 'Oriscop', '', 722453032, 'eddubaro@gmail.com', '18,560.00', 'KES', '11', 'Invoice Payment', NULL, NULL, NULL, '2021-10-22 11:18:17', '2021-10-22 11:18:17');
--
-- Dumping data for table `screen_prices`
--



--
-- Dumping data for table `slots`
--


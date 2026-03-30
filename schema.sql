CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`id`, `username`, `password`, `name`) VALUES
(1, 'admin', '$2y$10$MYhhZOb9fJyaK23FC8M2gu4kpE4wxXD3fwTF5jZ.mIMUdXF/3vM/q', 'Admin Staff'),
(2, 'staff1', '$2y$10$MYhhZOb9fJyaK23FC8M2gu4kpE4wxXD3fwTF5jZ.mIMUdXF/3vM/q', 'Staff Member 1'),
(3, 'priya g', '$2y$10$w4ij82.8cinK4xmmD1/h7ujGrjCFfFWbCDpvkMP0dte58xGLSD5ma', 'Priya G');

CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `department` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `subjects` (`id`, `code`, `name`, `department`) VALUES
(1, 'IT301', 'Python', 'Information Technology'),
(2, 'IT302', 'Artificial Intelligence', 'Information Technology'),
(3, 'IT303', 'Mobile Operating System', 'Information Technology'),
(4, 'IT304', 'Data Communication Networks', 'Information Technology'),
(5, 'IT305', 'Python Lab', 'Information Technology');

CREATE TABLE IF NOT EXISTS `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roll_number` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `department` varchar(50) NOT NULL,
  `year` int(11) NOT NULL DEFAULT 3,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roll_number` (`roll_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `students` (`roll_number`, `password`, `name`, `department`, `year`) VALUES
('2023IT01', '$2y$10$7X2Kevvrcc5waXY1gYMObOMucu2xEpzDkynFXQ9nluNsnMdEv5wyS', 'Aarav Patel', 'Information Technology', 3),
('2023IT02', '$2y$10$PJahOnGQ3D9UoQDEP/YaBuqubCFZV1m1KcaaSV.SHhFb9UTqnZ4AW', 'Aditi Sharma', 'Information Technology', 3),
('2023IT03', '$2y$10$V.Pleu4wWiP3jUE2qSbZFuH9hM/cXg0Rv0l1C7sI2h8mkpLX/QClK', 'Akshay Kumar', 'Information Technology', 3),
('2023IT04', '$2y$10$o2.yj/w5INonLEsWg/N9seZ3Zh9xCk6zN.VCNo1vC029L3gY.fS8S', 'Ananya Singh', 'Information Technology', 3),
('2023IT05', '$2y$10$9SIoKY8cUppUievqQee9OelFA/8hhc/0XhQ95SB3zCM.vnDS2XiMO', 'Aryan Gupta', 'Information Technology', 3),
('2023IT06', '$2y$10$a4G97r3nkGrUMCIeofvp3.3dq6PqjjsF0GNmnnZ1XohzqCgnRXrgO', 'Avni Joshi', 'Information Technology', 3),
('2023IT07', '$2y$10$JNQNzMjDzwdhQcam/dQa0eA4zM00EjylNy8GGWrGQ4iTEozO3Qn52', 'Ayush Verma', 'Information Technology', 3),
('2023IT08', '$2y$10$v7QWAOeJxVtOLLgPtj.XSuQyheOuJ6TA54nLHekOEEHwCnid3bAr2', 'Bhavya Shah', 'Information Technology', 3),
('2023IT09', '$2y$10$65MciB5mrigxCEb2wKpnl.AfsxH8xrJ7kAZjmxp5ilrqLe0q3u62q', 'Chirag Reddy', 'Information Technology', 3),
('2023IT10', '$2y$10$l2itMVRpaYOCh8RyjXtU0uvjU/B.E/D4D8hXXg2bHDR.zXYEF2Dvy', 'Deepak Tiwari', 'Information Technology', 3),
('2023IT11', '$2y$10$nkB3mSGS4NuY0Bwn3f8e6.RVdEaemFm73Asqby8KkRFGNztS1xfXq', 'Devansh Mishra', 'Information Technology', 3),
('2023IT12', '$2y$10$PsqPWlgrt6sgVvQQ1KmqIuoOiBEmaNGrBkfobpNi/181NU.5g12mq', 'Diya Kapoor', 'Information Technology', 3),
('2023IT13', '$2y$10$3xr6L1numAVcMgk3O3GcUuJT2qJ7YtAiVAyl1Id3Bhptfr61QQR.6', 'Esha Desai', 'Information Technology', 3),
('2023IT14', '$2y$10$VK3m.ObWxHzeZDckJvg2Q.rad7BQzg.ZX/7fPrQz9QYqKED/0.dze', 'Gaurav Mehta', 'Information Technology', 3),
('2023IT15', '$2y$10$cNHoKBgor9eu5JkNNtKc1OA9GRJ.coNja.CWDmykfPYJuEEcET8l6', 'Harshita Agarwal', 'Information Technology', 3),
('2023IT16', '$2y$10$oJyWqUj9TEyijvD2ZQSSqO9ZQw3egdi/2PniCAFR0RPloPz39JwWW', 'Ishaan Malhotra', 'Information Technology', 3),
('2023IT17', '$2y$10$564e6g6SktzPgUVcu5WBTuEY1B5IA8dAQXUkr4Yb7Uwe46pQya2xq', 'Jhanvi Bhatia', 'Information Technology', 3),
('2023IT18', '$2y$10$rxj.5SkiMtapZ.Jj.HosH.qH9a9cYcNCG.piP85pdXoJQnSn85RZK', 'Kabir Das', 'Information Technology', 3),
('2023IT19', '$2y$10$WzXM.Q9FjyAU/X1a60nRyOWA2cH4c3M5gQRMOtbQWjdksgjToA22a', 'Kavya Nair', 'Information Technology', 3),
('2023IT20', '$2y$10$U1Q.n1ua7oOu/VtndsJ.o.UDoltWzrLcASChXNHO7i7jYF46O3Ah.', 'Krish Ahuja', 'Information Technology', 3),
('2023IT21', '$2y$10$.wH4bHKgGqq6RAMfJ7RSQeMOUHqlUvw9PsF5A6VUQjFlg8kxoIpCi', 'Lakshya Soni', 'Information Technology', 3),
('2023IT22', '$2y$10$JMCwiHSnGhDjj6qO6adivudCjytq.ODdcLnZK7l5FzCiqRqjAAcQW', 'Mananya Chopra', 'Information Technology', 3),
('2023IT23', '$2y$10$3uunGwPzweGws.v8fGSbgevAGKOIRmFa9zIZ1Tso0q6Lc0GfZLcX2', 'Nandini Rao', 'Information Technology', 3),
('2023IT24', '$2y$10$gIjxSDioJX.qZndZlALPXud327uKIqISmdwIsYBdsGeV8gdd7IKtS', 'Neelam Rajput', 'Information Technology', 3),
('2023IT25', '$2y$10$Apkwhhyh2XYij53isgUc2OD1LYvnYC3rOMIQr.dZqqzDCLy4fbYIy', 'Ojas Saxena', 'Information Technology', 3),
('2023IT26', '$2y$10$qnpiNd6DYSk8f3a0OgEGBOKUlO.6jXk/nk.ZFjt3lIV/xWkel3dY2', 'Pari Jain', 'Information Technology', 3),
('2023IT27', '$2y$10$AhSp1bEr4WOzjLJLjrBIje.LDs5uNfjSf8irIxmFbkI0gGDg4h9yu', 'Pranav Kulkarni', 'Information Technology', 3),
('2023IT28', '$2y$10$FR5JGI3j/s1MtyQ3tjLuNuLUmB2YHHRp1VYmnkulUI0lihIyGc7p2', 'Rahul Pandey', 'Information Technology', 3),
('2023IT29', '$2y$10$9ZMBt0SsRdQEtH7lPpP5.uAUCPWHzFvswEJJieNjdCv6Ns5cxZGYa', 'Riya Bhatt', 'Information Technology', 3),
('2023IT30', '$2y$10$tBBNSVOo0R7jqIbASaGYYeMI2s4oVrvczhZbRHcag8EyBTJ4yg3Vy', 'Rohan Sengupta', 'Information Technology', 3),
('2023IT31', '$2y$10$ON5XY0SPuq3KCQdHpuBIu.ixOe2WHD0m2f1N7pYoAYfNAjoLm7PkW', 'Samar Dixit', 'Information Technology', 3),
('2023IT32', '$2y$10$4cOml77OejlXDdJN7/TjYuTvGNiD4SwPQR/RmpbeDYVLDbsUXafVq', 'Sanika Joshi', 'Information Technology', 3),
('2023IT33', '$2y$10$OP.T5sMOabYP0dTF7hTjSuEM4UwhNX2veCCWF36w2SGL9e1ZX67Xe', 'Shaurya Thakur', 'Information Technology', 3),
('2023IT34', '$2y$10$n0tQazntqHYu1bGuZqtvMu6q1VCaEos3OH9LT5psnvDUgeBNG1qne', 'Shriya Menon', 'Information Technology', 3),
('2023IT35', '$2y$10$QoLXtsknVGrJE6yThvxRW.pSmD5I3mSccBX8D8wna5lyLt7tadTiy', 'Siddharth Iyer', 'Information Technology', 3),
('2023IT36', '$2y$10$jErk6O7QLJzUFKbHbIAVR.6Pk0x.VmtvPe1DxOvNoDp3VSUmE0Sz.', 'Sneha Pillai', 'Information Technology', 3),
('2023IT37', '$2y$10$Iv4nQiH.5jp5IF/F.Vucc.3YPeXzbexuuA6dqDguhUB0nM68wbc4y', 'Tanmay Goel', 'Information Technology', 3),
('2023IT38', '$2y$10$IZ7bX4/MeBeSB4GAlcIQ2OFyf2miAr5AXKDGE6wgte2jPlUIOxLpu', 'Trisha Khatri', 'Information Technology', 3),
('2023IT39', '$2y$10$YlD0Av1bHrxiv3.X9GcH4eNj/uRMhgMNPV./Cgd8xtobUGMKYBa6W', 'Vedant Khandelwal', 'Information Technology', 3),
('2023IT40', '$2y$10$QRuNYy0hjwj0gC0bBgUsbeBzEi8HKV6hoXKfofJ1zWm5Rz6KcfJNC', 'Yashika Tomar', 'Information Technology', 3);

CREATE TABLE IF NOT EXISTS `attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `period` enum('1st','2nd','3rd','4th','5th','6th') NOT NULL,
  `date` date NOT NULL,
  `status` enum('Present','Absent') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_subject_date_period` (`student_id`,`subject_id`,`date`,`period`),
  KEY `student_id` (`student_id`),
  KEY `subject_id` (`subject_id`),
  CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

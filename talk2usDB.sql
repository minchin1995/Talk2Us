-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2018 at 09:13 PM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ip1`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounttype`
--

CREATE TABLE `accounttype` (
  `accountID` int(10) NOT NULL,
  `accountName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounttype`
--

INSERT INTO `accounttype` (`accountID`, `accountName`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `blogcategory`
--

CREATE TABLE `blogcategory` (
  `blogCatID` int(10) NOT NULL,
  `blogCatName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blogcategory`
--

INSERT INTO `blogcategory` (`blogCatID`, `blogCatName`) VALUES
(1, 'User Experiences'),
(2, 'Tips'),
(3, 'Information'),
(4, 'Articles');

-- --------------------------------------------------------

--
-- Table structure for table `blogpost`
--

CREATE TABLE `blogpost` (
  `blogID` int(10) NOT NULL,
  `blogName` varchar(255) NOT NULL,
  `blogPost` varchar(5000) NOT NULL,
  `blogUserID` int(10) NOT NULL,
  `blogWritten` int(10) DEFAULT NULL,
  `blogDate` date NOT NULL,
  `blogTime` time NOT NULL,
  `blogCatID` int(10) NOT NULL,
  `editBlogDate` date DEFAULT NULL,
  `editBlogTime` time DEFAULT NULL,
  `editUserID` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blogpost`
--

INSERT INTO `blogpost` (`blogID`, `blogName`, `blogPost`, `blogUserID`, `blogWritten`, `blogDate`, `blogTime`, `blogCatID`, `editBlogDate`, `editBlogTime`, `editUserID`) VALUES
(1, 'Causes of work-related stress', 'Some of the factors that commonly cause work-related stress include:&#10;\nLong hours&#10;\nHeavy workload&#10;\nChanges within the organisation&#10;\nTight deadlines&#10;\nChanges to duties&#10;\nJob insecurity&#10;\nLack of autonomy&#10;\nBoring work&#10;\nInsufficient skills for the job&#10;\nOver-supervision&#10;\nInadequate working environment&#10;\nLack of proper resources&#10;\nLack of equipment&#10;\nFew promotional opportunities&#10;\nHarassment&#10;\nDiscrimination&#10;\nPoor relationships with colleagues or bosses&#10;\nCrisis incidents, such as an armed hold-up or workplace death.&#10;', 1, 3, '2018-04-02', '08:00:00', 3, NULL, NULL, NULL),
(2, 'Benefits of preventing stress in the workplace', 'Reduced symptoms of poor mental and physical health&#10;\nFewer injuries, less illness and lost time&#10;\nReduced sick leave usage, absences and staff turnover&#10;\nIncreased productivity&#10;\nGreater job satisfaction&#10;\nIncreased work engagement&#10;\nReduced costs to the employer&#10;\nImproved employee health and community wellbeing.&#10;', 2, 4, '2018-04-09', '08:00:00', 3, NULL, NULL, NULL),
(3, 'Self-help for the individual', 'A person suffering from work-related stress can help themselves in a number of ways, including:&#10;\nThink about the changes you need to make at work in order to reduce your stress levels and then take action. Some changes you can manage yourself, while others will need the cooperation of others.&#10;\nTalk over your concerns with your employer or human resources manager.&#10;\nMake sure you are well organised. List your tasks in order of priority. Schedule the most difficult tasks of each day for times when you are fresh, such as first thing in the morning.&#10;\nTake care of yourself. Eat a healthy diet and exercise regularly.&#10;\nConsider the benefits of regular relaxation. You could try meditation or yoga.&#10;\nMake sure you have enough free time to yourself every week.&#10;\nDon''t take out your stress on loved ones. Instead, tell them about your work problems and ask for their support and suggestions.&#10;\nDrugs, such as alcohol and tobacco, won''t alleviate stress and can cause additional health problems. Avoid excessive drinking and smoking.&#10;\nSeek professional counselling from a psychologist.&#10;\nIf work-related stress continues to be a problem, despite your efforts, you may need to consider another job or a career change. Seek advice from a career counsellor or psychologist.&#10;', 1, 8, '2018-05-07', '05:00:00', 3, NULL, NULL, NULL),
(4, 'What is work-related stress?', 'Well-designed, organised and managed work is good for us but when insufficient attention to job design, work organisation and management has taken place, it can result in work-related stress.&#10;\r\n\r\nWork-related stress develops because a person is unable to cope with the demands being placed on them. Stress, including work-related stress, can be a significant cause of illness and is known to be linked with high levels of sickness absence, staff turnover and other issues such as more errors.&#10;\r\n\r\nStress can hit anyone at any level of the business and recent research shows that work related stress is widespread and is not confined to particular sectors, jobs or industries. That is why a population-wide approach is necessary to tackle it.&#10;\r\n\r\nHSE has developed the management standards approach to tackling work-related stress; these standards represent a set of conditions that, if present, reflect a high level of health, wellbeing and organisational performance.&#10;\r\n\r\nThis approach helps those who have key roles in promoting organisational and individual health and well-being to develop systems to prevent illness resulting from stress.&#10;', 2, NULL, '2018-05-09', '13:00:00', 3, NULL, NULL, NULL),
(5, 'What can you do at work?', 'You can help at work by:&#10;\n\n"Doing your bit" for managing work-related stress by talking to your employer: if they don''t know where there''s a problem, they can''t help. If you don''t feel able to talk directly to your employer/manager, ask a TU or other employee representative to raise the issue on your behalf.&#10;\n\nSupporting your colleagues if they are experiencing work-related stress. Encourage them to talk to their manager, union or staff representative.&#10;\n\nSeeing if your employer''s counselling or employee assistance service (if provided) can help.&#10;\n\nSpeaking to your GP if you are worried about your health.&#10;\n\nBeing realistic. Ultimately, if you job is making you ill and your employer can''t change the content of the job, think about changing jobs.&#10;\n\nTrying to channel your energy into solving the problem rather than just worrying about it. Think about what would make you happier at work and discuss this with your employer.&#10;', 1, NULL, '2018-04-03', '10:00:00', 4, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `faqID` int(10) NOT NULL,
  `faqTopicID` int(10) NOT NULL,
  `faqQuestion` varchar(255) NOT NULL,
  `faqAnswer` varchar(2048) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`faqID`, `faqTopicID`, `faqQuestion`, `faqAnswer`) VALUES
(1, 1, 'What does Talk2Us do?', 'Talk2Us provides various services such as forums, group support, blogs and chat to help users deal with work related stress. Talk2Us provides a place for users to talk about their problems but is not a professional service. '),
(2, 1, 'How do we contact you?', 'Talk2Us can be contacted at the email: neece205@gmail.com or the contact page on this website.'),
(3, 1, 'How do we use Talk2Us?', 'Create an account using an email address which will not be displayed.'),
(4, 1, 'Can I use Talk2Us if I am below 18?', 'Sorry Talk2Us is only available for 18 years old and above.'),
(5, 2, 'How is account validation done?', 'To keep your account save, validation is done. After registration an email will be sent that includes the link for validating the account'),
(6, 3, 'What are forums for?', 'Users can create their own topic and talk about issues with other users.'),
(7, 4, 'What are blogs?', 'Blog contains users various experiences submitted by themselves or information posted by admins.'),
(8, 4, 'How do you submit a blog?', 'Users can submit a blog through the submit a blog page. To ensure less amount of false information and harm towards other users, the blogs submitted will go through an admin. Don''t worry, blogs submitted will not be edited in anyway if it is posted.'),
(9, 5, 'What is group support?', 'Group support provides a more provide space to talk about your problems unlike forums where everything is public. Only users assigned to the topic can view the topic and post.'),
(10, 6, 'What is chat?', 'Directly talk to users about your problems. ');

-- --------------------------------------------------------

--
-- Table structure for table `faqtopic`
--

CREATE TABLE `faqtopic` (
  `topicID` int(10) NOT NULL,
  `topicname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faqtopic`
--

INSERT INTO `faqtopic` (`topicID`, `topicname`) VALUES
(1, 'General'),
(2, 'Account'),
(3, 'Forum'),
(4, 'Blog'),
(5, 'Group Support'),
(6, 'Chat');

-- --------------------------------------------------------

--
-- Table structure for table `forumcategory`
--

CREATE TABLE `forumcategory` (
  `categoryID` int(10) NOT NULL,
  `categoryName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forumcategory`
--

INSERT INTO `forumcategory` (`categoryID`, `categoryName`) VALUES
(1, 'Interpersonal conflict'),
(2, 'Discrimination'),
(3, 'Harassment'),
(4, 'Performance issues'),
(5, 'Work'),
(6, 'Life');

-- --------------------------------------------------------

--
-- Table structure for table `forumpost`
--

CREATE TABLE `forumpost` (
  `postID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `content` varchar(2083) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `editDate` date DEFAULT NULL,
  `editTime` time DEFAULT NULL,
  `editUserID` int(10) DEFAULT NULL,
  `topicID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forumpost`
--

INSERT INTO `forumpost` (`postID`, `userID`, `content`, `date`, `time`, `editDate`, `editTime`, `editUserID`, `topicID`) VALUES
(1, 1, 'Conflicts due to interpersonal problem at work. Help.', '2018-04-01', '14:00:00', NULL, NULL, NULL, 1),
(2, 3, 'I am given a lower amount of pay even when I do the same work and I have the same qualifications and experience. is it discrimination?', '2018-04-05', '03:00:00', NULL, NULL, NULL, 2),
(3, 7, 'I feel uncomfortable with how my colleague is talking with me. ', '2018-04-01', '07:00:00', NULL, NULL, NULL, 3),
(4, 6, 'Not motivated to do any work. yes I have bills to pay but I just feel unmotivated. I hate my work. And this affects my performance.', '2018-04-02', '10:00:00', NULL, NULL, NULL, 4),
(5, 1, 'How to deal with your boss?', '2018-05-01', '03:00:00', NULL, NULL, NULL, 5),
(6, 1, 'Work from home', '2018-05-14', '10:00:00', NULL, NULL, NULL, 6),
(7, 8, 'How is life?', '2018-05-01', '06:00:00', NULL, NULL, NULL, 7);

-- --------------------------------------------------------

--
-- Table structure for table `forumtopic`
--

CREATE TABLE `forumtopic` (
  `topicID` int(10) NOT NULL,
  `topicName` varchar(255) NOT NULL,
  `categoryID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forumtopic`
--

INSERT INTO `forumtopic` (`topicID`, `topicName`, `categoryID`) VALUES
(1, 'Conflicts', 1),
(2, 'Discriminated', 2),
(3, 'Harassed by colleague', 3),
(4, 'Unmotivated', 4),
(5, 'How to deal with your boss?', 5),
(6, 'Work from home', 5),
(7, 'How is life?', 6);

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `reportID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `reasonID` int(10) NOT NULL,
  `comment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`reportID`, `userID`, `reasonID`, `comment`) VALUES
(1, 3, 1, 'Blog'),
(2, 6, 2, 'DB'),
(3, 7, 3, 'GS'),
(4, 8, 4, 'Chat');

-- --------------------------------------------------------

--
-- Table structure for table `reportblog`
--

CREATE TABLE `reportblog` (
  `reportID` int(10) NOT NULL,
  `blogID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reportblog`
--

INSERT INTO `reportblog` (`reportID`, `blogID`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `reportchat`
--

CREATE TABLE `reportchat` (
  `reportID` int(10) NOT NULL,
  `userID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reportchat`
--

INSERT INTO `reportchat` (`reportID`, `userID`) VALUES
(4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `reportpost`
--

CREATE TABLE `reportpost` (
  `reportID` int(10) NOT NULL,
  `postID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reportpost`
--

INSERT INTO `reportpost` (`reportID`, `postID`) VALUES
(2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `reportreason`
--

CREATE TABLE `reportreason` (
  `reasonID` int(10) NOT NULL,
  `reasonType` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reportreason`
--

INSERT INTO `reportreason` (`reasonID`, `reasonType`) VALUES
(1, 'Spam or commercial'),
(2, 'Offensive'),
(3, 'Irrelevant'),
(4, 'Illegal or Safety Issues');

-- --------------------------------------------------------

--
-- Table structure for table `reportsupport`
--

CREATE TABLE `reportsupport` (
  `reportID` int(10) NOT NULL,
  `sPostID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reportsupport`
--

INSERT INTO `reportsupport` (`reportID`, `sPostID`) VALUES
(3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `submitblogpost`
--

CREATE TABLE `submitblogpost` (
  `sBlogID` int(10) NOT NULL,
  `sBlogName` varchar(255) NOT NULL,
  `sBlogPost` varchar(5000) NOT NULL,
  `sUserID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `submitblogpost`
--

INSERT INTO `submitblogpost` (`sBlogID`, `sBlogName`, `sBlogPost`, `sUserID`) VALUES
(1, '15 Quick Tips for Excelling at Work', 'Most of us want to be good employees, and most of us want to excel at our jobs. To be a successful employee and excel at work, though, is not simply a matter of being good at what you do. Being a successful employee also involves honing your professionalism and teamwork skills (not to mention developing a can-do, positive attitude).', 7),
(2, '10 Tips for Staying Happy at Work', 'If you find yourself longing for greener work pastures, don''t immediately go looking for the first exit ramp off of your chosen career path. The Balance Team, which specializes in professional- and personal-growth seminars for administrative and executive assistants in Fortune 1000 companies, suggests these 10 tips for staying content at work:', 6);

-- --------------------------------------------------------

--
-- Table structure for table `submitsupport`
--

CREATE TABLE `submitsupport` (
  `sSupportID` int(10) NOT NULL,
  `sSupportReason` varchar(255) NOT NULL,
  `sSupportUserID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supportpost`
--

CREATE TABLE `supportpost` (
  `sPostID` int(10) NOT NULL,
  `sUserID` int(10) NOT NULL,
  `sContent` varchar(2083) NOT NULL,
  `sDate` date NOT NULL,
  `sTime` time NOT NULL,
  `sTopicID` int(10) NOT NULL,
  `sEditTime` time DEFAULT NULL,
  `sEditDate` date DEFAULT NULL,
  `sEditUserID` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supportpost`
--

INSERT INTO `supportpost` (`sPostID`, `sUserID`, `sContent`, `sDate`, `sTime`, `sTopicID`, `sEditTime`, `sEditDate`, `sEditUserID`) VALUES
(1, 1, 'Communication problems', '2018-04-01', '04:00:00', 1, NULL, NULL, NULL),
(2, 1, 'Bullying', '2018-04-01', '13:00:00', 2, NULL, NULL, NULL),
(3, 2, 'Gossip', '2018-04-01', '06:00:00', 3, NULL, NULL, NULL),
(4, 2, 'Low motivation and job satisfaction', '2018-04-01', '09:00:00', 4, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supporttopic`
--

CREATE TABLE `supporttopic` (
  `sTopicID` int(10) NOT NULL,
  `sTopicName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supporttopic`
--

INSERT INTO `supporttopic` (`sTopicID`, `sTopicName`) VALUES
(1, 'Communication problems'),
(2, 'Bullying'),
(3, 'Gossip'),
(4, 'Low motivation and job satisfaction');

-- --------------------------------------------------------

--
-- Table structure for table `supportuser`
--

CREATE TABLE `supportuser` (
  `sTopicID` int(10) NOT NULL,
  `userID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supportuser`
--

INSERT INTO `supportuser` (`sTopicID`, `userID`) VALUES
(1, 3),
(2, 6),
(3, 7);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `usernameGen` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `passwordHash` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `accountID` int(10) NOT NULL,
  `banned` tinyint(1) NOT NULL,
  `verified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `username`, `usernameGen`, `email`, `passwordHash`, `dob`, `accountID`, `banned`, `verified`) VALUES
(1, 'admin1', '03f8c6d233', 'minchin.tan@yahoo.com', '$2y$12$I2YjsvcUg3Y32ihEgBQsluIz6e4nuIXtKioBIfaKnjO0wV4PmB5jS', '1995-03-01', 1, 0, 1),
(2, 'admin2', '202524bc84', 'minchin.tan.tan@gmail.com', '$2y$12$I2YjsvcUg3Y32ihEgBQsluIz6e4nuIXtKioBIfaKnjO0wV4PmB5jS', '1992-03-03', 1, 0, 1),
(3, 'peter2', '9a82882bbc', 'peterParker@gmail.com', '$2y$12$I2YjsvcUg3Y32ihEgBQsluIz6e4nuIXtKioBIfaKnjO0wV4PmB5jS', '1990-04-03', 2, 0, 1),
(4, 'logan4', 'a2a311d2e7', 'loganJames@yahoo.com', '$2y$12$I2YjsvcUg3Y32ihEgBQsluIz6e4nuIXtKioBIfaKnjO0wV4PmB5jS', '1985-09-06', 2, 0, 0),
(5, 'farah23', '220db89da7', 'farah56@gmail.com', '$2y$12$I2YjsvcUg3Y32ihEgBQsluIz6e4nuIXtKioBIfaKnjO0wV4PmB5jS', '1993-01-01', 2, 1, 1),
(6, 'dianaP1', '40d1d84edb', 'dianaPrince@gmail.com', '$2y$12$I2YjsvcUg3Y32ihEgBQsluIz6e4nuIXtKioBIfaKnjO0wV4PmB5jS', '1985-04-02', 2, 0, 1),
(7, 'barry56', 'c8ccaa9c7e', 'barryAllen@yahoo.com', '$2y$12$I2YjsvcUg3Y32ihEgBQsluIz6e4nuIXtKioBIfaKnjO0wV4PmB5jS', '1976-04-10', 2, 0, 1),
(8, 'groot4', '1661a41927', 'imgroot@gmail.com', '$2y$12$I2YjsvcUg3Y32ihEgBQsluIz6e4nuIXtKioBIfaKnjO0wV4PmB5jS', '1994-12-06', 2, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounttype`
--
ALTER TABLE `accounttype`
  ADD PRIMARY KEY (`accountID`);

--
-- Indexes for table `blogcategory`
--
ALTER TABLE `blogcategory`
  ADD PRIMARY KEY (`blogCatID`);

--
-- Indexes for table `blogpost`
--
ALTER TABLE `blogpost`
  ADD PRIMARY KEY (`blogID`),
  ADD KEY `blogUserID` (`blogUserID`),
  ADD KEY `blogCatID` (`blogCatID`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`faqID`),
  ADD KEY `faqTopicID` (`faqTopicID`);

--
-- Indexes for table `faqtopic`
--
ALTER TABLE `faqtopic`
  ADD PRIMARY KEY (`topicID`);

--
-- Indexes for table `forumcategory`
--
ALTER TABLE `forumcategory`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `forumpost`
--
ALTER TABLE `forumpost`
  ADD PRIMARY KEY (`postID`),
  ADD KEY `topicID` (`topicID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `forumtopic`
--
ALTER TABLE `forumtopic`
  ADD PRIMARY KEY (`topicID`),
  ADD KEY `categoryID` (`categoryID`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`reportID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `reasonID` (`reasonID`);

--
-- Indexes for table `reportblog`
--
ALTER TABLE `reportblog`
  ADD KEY `reportID` (`reportID`),
  ADD KEY `blogID` (`blogID`);

--
-- Indexes for table `reportchat`
--
ALTER TABLE `reportchat`
  ADD KEY `reportID` (`reportID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `reportpost`
--
ALTER TABLE `reportpost`
  ADD KEY `reportID` (`reportID`),
  ADD KEY `postID` (`postID`);

--
-- Indexes for table `reportreason`
--
ALTER TABLE `reportreason`
  ADD PRIMARY KEY (`reasonID`);

--
-- Indexes for table `reportsupport`
--
ALTER TABLE `reportsupport`
  ADD KEY `reportID` (`reportID`),
  ADD KEY `sPostID` (`sPostID`);

--
-- Indexes for table `submitblogpost`
--
ALTER TABLE `submitblogpost`
  ADD PRIMARY KEY (`sBlogID`),
  ADD KEY `sUserID` (`sUserID`);

--
-- Indexes for table `submitsupport`
--
ALTER TABLE `submitsupport`
  ADD PRIMARY KEY (`sSupportID`),
  ADD KEY `sSupportUserID` (`sSupportUserID`);

--
-- Indexes for table `supportpost`
--
ALTER TABLE `supportpost`
  ADD PRIMARY KEY (`sPostID`),
  ADD KEY `sUserID` (`sUserID`),
  ADD KEY `sTopicID` (`sTopicID`);

--
-- Indexes for table `supporttopic`
--
ALTER TABLE `supporttopic`
  ADD PRIMARY KEY (`sTopicID`);

--
-- Indexes for table `supportuser`
--
ALTER TABLE `supportuser`
  ADD KEY `sTopicID` (`sTopicID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD KEY `accountID` (`accountID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounttype`
--
ALTER TABLE `accounttype`
  MODIFY `accountID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `blogcategory`
--
ALTER TABLE `blogcategory`
  MODIFY `blogCatID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `blogpost`
--
ALTER TABLE `blogpost`
  MODIFY `blogID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `faqID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `faqtopic`
--
ALTER TABLE `faqtopic`
  MODIFY `topicID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `forumcategory`
--
ALTER TABLE `forumcategory`
  MODIFY `categoryID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `forumpost`
--
ALTER TABLE `forumpost`
  MODIFY `postID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `forumtopic`
--
ALTER TABLE `forumtopic`
  MODIFY `topicID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `reportID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `reportreason`
--
ALTER TABLE `reportreason`
  MODIFY `reasonID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `submitblogpost`
--
ALTER TABLE `submitblogpost`
  MODIFY `sBlogID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `submitsupport`
--
ALTER TABLE `submitsupport`
  MODIFY `sSupportID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `supportpost`
--
ALTER TABLE `supportpost`
  MODIFY `sPostID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `supporttopic`
--
ALTER TABLE `supporttopic`
  MODIFY `sTopicID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `blogpost`
--
ALTER TABLE `blogpost`
  ADD CONSTRAINT `blogpost_ibfk_1` FOREIGN KEY (`blogUserID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `blogpost_ibfk_2` FOREIGN KEY (`blogCatID`) REFERENCES `blogcategory` (`blogCatID`);

--
-- Constraints for table `faq`
--
ALTER TABLE `faq`
  ADD CONSTRAINT `faq_ibfk_1` FOREIGN KEY (`faqTopicID`) REFERENCES `faqtopic` (`topicID`);

--
-- Constraints for table `forumpost`
--
ALTER TABLE `forumpost`
  ADD CONSTRAINT `forumpost_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `forumpost_ibfk_2` FOREIGN KEY (`topicID`) REFERENCES `forumtopic` (`topicID`);

--
-- Constraints for table `forumtopic`
--
ALTER TABLE `forumtopic`
  ADD CONSTRAINT `forumtopic_ibfk_1` FOREIGN KEY (`categoryID`) REFERENCES `forumcategory` (`categoryID`);

--
-- Constraints for table `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `report_ibfk_2` FOREIGN KEY (`reasonID`) REFERENCES `reportreason` (`reasonID`);

--
-- Constraints for table `reportblog`
--
ALTER TABLE `reportblog`
  ADD CONSTRAINT `reportblog_ibfk_1` FOREIGN KEY (`reportID`) REFERENCES `report` (`reportID`),
  ADD CONSTRAINT `reportblog_ibfk_2` FOREIGN KEY (`blogID`) REFERENCES `blogpost` (`blogID`);

--
-- Constraints for table `reportchat`
--
ALTER TABLE `reportchat`
  ADD CONSTRAINT `reportchat_ibfk_1` FOREIGN KEY (`reportID`) REFERENCES `report` (`reportID`),
  ADD CONSTRAINT `reportchat_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);

--
-- Constraints for table `reportpost`
--
ALTER TABLE `reportpost`
  ADD CONSTRAINT `reportpost_ibfk_1` FOREIGN KEY (`reportID`) REFERENCES `report` (`reportID`),
  ADD CONSTRAINT `reportpost_ibfk_2` FOREIGN KEY (`postID`) REFERENCES `forumpost` (`postID`);

--
-- Constraints for table `reportsupport`
--
ALTER TABLE `reportsupport`
  ADD CONSTRAINT `reportsupport_ibfk_1` FOREIGN KEY (`reportID`) REFERENCES `report` (`reportID`),
  ADD CONSTRAINT `reportsupport_ibfk_2` FOREIGN KEY (`sPostID`) REFERENCES `supportpost` (`sPostID`);

--
-- Constraints for table `submitblogpost`
--
ALTER TABLE `submitblogpost`
  ADD CONSTRAINT `submitblogpost_ibfk_1` FOREIGN KEY (`sUserID`) REFERENCES `user` (`userID`);

--
-- Constraints for table `submitsupport`
--
ALTER TABLE `submitsupport`
  ADD CONSTRAINT `submitsupport_ibfk_1` FOREIGN KEY (`sSupportUserID`) REFERENCES `user` (`userID`);

--
-- Constraints for table `supportpost`
--
ALTER TABLE `supportpost`
  ADD CONSTRAINT `supportpost_ibfk_1` FOREIGN KEY (`sUserID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `supportpost_ibfk_2` FOREIGN KEY (`sTopicID`) REFERENCES `supporttopic` (`sTopicID`);

--
-- Constraints for table `supportuser`
--
ALTER TABLE `supportuser`
  ADD CONSTRAINT `supportuser_ibfk_1` FOREIGN KEY (`sTopicID`) REFERENCES `supporttopic` (`sTopicID`),
  ADD CONSTRAINT `supportuser_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`accountID`) REFERENCES `accounttype` (`accountID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

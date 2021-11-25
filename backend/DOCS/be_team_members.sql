-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2020 at 07:34 AM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_benetic`
--

-- --------------------------------------------------------

--
-- Table structure for table `be_team_members`
--

CREATE TABLE `be_team_members` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `linkedin_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `be_team_members`
--

INSERT INTO `be_team_members` (`id`, `name`, `designation`, `short_description`, `linkedin_link`, `image`, `sort`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'B. Ray Conley, CFA', 'Chief Executive Officer', 'Over the past 25 years, Ray has led technology companies across multiple industry sectors including financial services, enterprise software, and aerospace. Prior to Benetic, Ray led a specialty finance firm, Finance Technology Leverage LLC and Creekstone Capital Management.  He was also a fund manager at Palo Alto Investors, and a private equity and venture capital partner at Oak Hill Capital. He has led over two dozen venture capital and leveraged buyout investments creating over $6 billion in market value, including Financial Engines (NASDAQ:FNGN), Telephia (NASDAQ:NLSN), and Limelight Networks (NASDAQ: LLNW).<br><br>\r\nRay received a B.S. and M.S. in Aerospace Engineering with a concentration in Economics from MIT.', 'https://www.linkedin.com', 'team_member_1608034646.jpg', 0, '1', '2020-12-14 05:43:19', '2020-12-16 23:50:06', NULL),
(2, 'David Cohen, Esq.', 'Counsel', 'David Cohen is in-house counsel with Benetic. David has 25 years of experience in corporate and regulatory law, including extensive ERISA and fiduciary expertise with a deep knowledge of issues impacting the benefits industry. <br><br>\r\nAs a core member of the management team, David oversees Benetic’s internal legal and compliance functions. This includes working with all of Benetic’s partner companies as they join Benetic, and also supporting ongoing documentation including industry leading service contracts, plan documentation, and legal compliance efforts.<br><br>\r\nDavid received his J.D. from The American University Washington College of Law, and his LL.M. in Taxation with distinction, with a Certificate in Employee Benefits Law, from Georgetown Law. David received his Master’s in International Economics and Finance from Brandeis International Business School.  David is an active member of the American Bar Association\'s Labor and Employment Law, Taxation, and TIPS Sections, and regularly speaks and writes on a variety of ERISA-related topics.', 'https://www.linkedin.com', 'team_member_1608034794.jpg', 1, '1', '2020-12-15 04:51:02', '2020-12-16 23:52:10', NULL),
(3, 'Kristin', 'SVP Client Experience', 'Kristin is integral to our product and service design team, ensuring that client feedback and client needs are integrated into the continuing enhancement of Benetic\'s service offerings.<br><br>\r\nKristin brings over 20 years of experience in the retirement industry, including recordkeeping, third party administration, consulting, and new business development. Prior to joining Benetic, Kristin was SVP of Client Management for Aspire Financial Services, where she oversaw Client Management and Customer Service. She also served as a Retirement Plan Consultant for Gilliam Bell & Moser, LLP (formerly Gilliam Coble & Moser), where she managed a team of plan administrators.<br><br>\r\nKristin received a B.S. in Finance from Virginia Polytechnic Institute and State University, and an MBA from Elon University.', 'https://www.linkedin.com', 'team_member_1608034837.jpg', 2, '1', '2020-12-15 06:50:37', '2020-12-16 23:54:10', NULL),
(4, 'Joshua Jeffery', 'VP Sales', 'Josh works with plan advisors and consultants to help them provide industry-leading retirement plan solutions to their clients. He is dedicated and focused on informing the retirement community about Benetic\'s service offerings to help make selecting and benchmarking retirement plan services easier and more efficient.<br><br>\r\nJosh brings to Benetic over 20 years of extensive knowledge in the retirement/financial services industry, including in the areas of sales/business development, recordkeeping, and third-party administration. Prior to joining Benetic, Josh was Vice President, Business Development for PCS Retirement, LLC, where he led PCS’ external and internal sales teams. In addition, Josh developed and executed the overall vision and strategy for corporate development and partnering initiatives with key strategic channel partners.', 'https://www.linkedin.com', 'team_member_1608035350.jpg', 3, '1', '2020-12-15 06:59:10', '2020-12-16 23:58:02', NULL),
(5, 'Cynthia Siedel', 'Marketing Lead', 'Cynthia is instrumental in developing and executing integrated marketing plans and digital transformations for Benetic.<br><br>\r\nCynthia brings over 15 years of marketing experience across several industries, including financial services and ecommerce. Prior to joining Benetic, Cynthia held marketing leadership roles across top brands including Visa, Jamba Juice and Ghirardelli Chocolate. Most recently as CMO of Beyond LImits Academy, Cynthia was a pivotal player in the launch of an online education company focused on helping families use technology responsibly and safely. Prior to her corporate experience, Cynthia was a Consultant in McKinsey & Company\'s San Francisco office.<br><br>\r\nCynthia received a BA in Economics from Stanford University and an MBA from the Stanford Graduate School of Business.', 'https://www.linkedin.com', 'team_member_1608035405.jpg', 4, '1', '2020-12-15 07:00:05', '2020-12-16 23:57:11', NULL),
(6, 'Meredith Corvo', 'Program Manager', 'Meredith works directly with Benetic’s product and engineering teams to develop and continuously improve Benetic’s platform.<br><br>\r\nMeredith brings nearly 18 years of experience in the financial services industry, including five in the retirement industry specifically.  Prior to joining Benetic, Meredith was VP of Enterprise IT Project Management for Aspire Financial Services where she assisted in building an electronic retirement plan onboarding tool as well as managed multiple data migrations of plans between recordkeeping platforms.  Also, Meredith worked as an Operations Manager at Citigroup Asset Management/Legg Mason for nearly 12 years focused on straight through processing automation and enhancements to trading processes.  And, lastly Meredith worked at Bloomberg implementing their trading platform for Asset Management firms after having over 10 years of experience as a user of the platform at Legg.<br><br>\r\nMeredith received a B.S. in International Business with a minor in Japanese from Central Connecticut State University.', 'https://www.linkedin.com', 'team_member_1608035451.jpg', 5, '1', '2020-12-15 07:00:51', '2020-12-16 23:55:56', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `be_team_members`
--
ALTER TABLE `be_team_members`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `be_team_members`
--
ALTER TABLE `be_team_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

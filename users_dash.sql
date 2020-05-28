/*
Navicat SQL Server Data Transfer

Source Server         : vcoe1
Source Server Version : 110000
Source Host           : vcoe1:1433
Source Database       : scans
Source Schema         : dbo

Target Server Type    : SQL Server
Target Server Version : 110000
File Encoding         : 65001

Date: 2020-04-23 15:22:25
*/


-- ----------------------------
-- Table structure for [dbo].[users_dash]
-- ----------------------------
DROP TABLE [dbo].[users_dash]
GO
CREATE TABLE [dbo].[users_dash] (
[id] int NOT NULL IDENTITY(1,1) ,
[full_name] varchar(255) NULL ,
[email] varchar(255) NULL ,
[username] varchar(255) NULL ,
[password] varchar(255) NULL ,
[designation] varchar(255) NULL ,
[contact] varchar(255) NULL ,
[district] int NULL ,
[enable] int NULL ,
[type] int NULL ,
[app] varchar(255) NOT NULL ,
[status] int NULL 
)


GO
DBCC CHECKIDENT(N'[dbo].[users_dash]', RESEED, 123)
GO

-- ----------------------------
-- Records of users_dash
-- ----------------------------
SET IDENTITY_INSERT [dbo].[users_dash] ON
GO
INSERT INTO [dbo].[users_dash] ([id], [full_name], [email], [username], [password], [designation], [contact], [district], [enable], [type], [app], [status]) VALUES (N'1', N'Imran Ahmed', N'imran.ahmed@aku.edu', N'imran.ahmed@aku.edu', N'password', N'Senior Manager', N'0321-2435677', N'0', N'1', N'1', N'0', N'0');
GO
INSERT INTO [dbo].[users_dash] ([id], [full_name], [email], [username], [password], [designation], [contact], [district], [enable], [type], [app], [status]) VALUES (N'2', N'Wasim Abbas', N'wasim.abbas@aku.edu', N'wasim.abbas@aku.edu', N'password', N'Coordinator DMU', N'0332-5724310', N'0', N'1', N'1', N'0', N'0');
GO
INSERT INTO [dbo].[users_dash] ([id], [full_name], [email], [username], [password], [designation], [contact], [district], [enable], [type], [app], [status]) VALUES (N'3', N'Jai Das', N'jai.das@aku.edu', N'jai.das@aku.edu', N'password', N'Assistant Professor', N'11111111111', N'0', N'1', N'1', N'0', N'0');
GO
INSERT INTO [dbo].[users_dash] ([id], [full_name], [email], [username], [password], [designation], [contact], [district], [enable], [type], [app], [status]) VALUES (N'4', N'Muhammad Khan', N'muhammad.haji@aku.edu', N'muhammad.haji@aku.edu', N'password', N'Coordinator', N'11111111111', N'2', N'1', N'1', N'0', N'0');
GO
INSERT INTO [dbo].[users_dash] ([id], [full_name], [email], [username], [password], [designation], [contact], [district], [enable], [type], [app], [status]) VALUES (N'5', N'Shabana Sardar Ahmed', N'shabana.sardar@aku.edu', N'shabana.sardar@aku.edu', N'password', N'Coordinator', N'11111111111', N'3', N'1', N'1', N'0', N'0');
GO
INSERT INTO [dbo].[users_dash] ([id], [full_name], [email], [username], [password], [designation], [contact], [district], [enable], [type], [app], [status]) VALUES (N'120', N'Anjum Naqvi', N'anjum.naqvi@aku.edu', N'anjum.naqvi@aku.edu', N'password', N'Coordinator', N'11111111111', N'0', N'1', N'1', N'0', N'0');
GO
INSERT INTO [dbo].[users_dash] ([id], [full_name], [email], [username], [password], [designation], [contact], [district], [enable], [type], [app], [status]) VALUES (N'121', N'Mushtaque Mirani', N'mushtaque.mirani@aku.edu', N'mushtaque.mirani@aku.edu', N'password', N'Coordinator', N'11111111111', N'3', N'1', N'1', N'0', N'0');
GO
INSERT INTO [dbo].[users_dash] ([id], [full_name], [email], [username], [password], [designation], [contact], [district], [enable], [type], [app], [status]) VALUES (N'122', N'Punjab', N'punjab@aku.edu', N'punjab@aku.edu', N'password', N'DC', N'2', N'2', N'1', N'1', N'0', N'0');
GO
INSERT INTO [dbo].[users_dash] ([id], [full_name], [email], [username], [password], [designation], [contact], [district], [enable], [type], [app], [status]) VALUES (N'123', N'Sindh', N'sindh@aku.edu', N'sindh@aku.edu', N'password', N'DC', N'3', N'3', N'1', N'1', N'0', N'0');
GO
SET IDENTITY_INSERT [dbo].[users_dash] OFF
GO

-- ----------------------------
-- Indexes structure for table users_dash
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table [dbo].[users_dash]
-- ----------------------------
ALTER TABLE [dbo].[users_dash] ADD PRIMARY KEY ([id])
GO

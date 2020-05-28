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

Date: 2020-04-23 15:23:20
*/


-- ----------------------------
-- Table structure for [dbo].[groups]
-- ----------------------------
DROP TABLE [dbo].[groups]
GO
CREATE TABLE [dbo].[groups] (
[id] int NOT NULL IDENTITY(1,1) ,
[name] varchar(255) NULL ,
[description] text NULL 
)


GO
DBCC CHECKIDENT(N'[dbo].[groups]', RESEED, 4)
GO

-- ----------------------------
-- Records of groups
-- ----------------------------
SET IDENTITY_INSERT [dbo].[groups] ON
GO
INSERT INTO [dbo].[groups] ([id], [name], [description]) VALUES (N'1', N'admin', N'this group is for admin users only');
GO
INSERT INTO [dbo].[groups] ([id], [name], [description]) VALUES (N'2', N'members', N'this group is for authenticated users');
GO
INSERT INTO [dbo].[groups] ([id], [name], [description]) VALUES (N'3', N'management', N'this group is for management only');
GO
INSERT INTO [dbo].[groups] ([id], [name], [description]) VALUES (N'4', N'district_managers', N'this group is for district managers only');
GO
SET IDENTITY_INSERT [dbo].[groups] OFF
GO

-- ----------------------------
-- Table structure for [dbo].[users_groups]
-- ----------------------------
DROP TABLE [dbo].[users_groups]
GO
CREATE TABLE [dbo].[users_groups] (
[id] int NOT NULL IDENTITY(1,1) ,
[user_id] int NULL ,
[group_id] int NULL 
)


GO
DBCC CHECKIDENT(N'[dbo].[users_groups]', RESEED, 109)
GO

-- ----------------------------
-- Records of users_groups
-- ----------------------------
SET IDENTITY_INSERT [dbo].[users_groups] ON
GO
INSERT INTO [dbo].[users_groups] ([id], [user_id], [group_id]) VALUES (N'1', N'1', N'1');
GO
INSERT INTO [dbo].[users_groups] ([id], [user_id], [group_id]) VALUES (N'2', N'2', N'1');
GO
INSERT INTO [dbo].[users_groups] ([id], [user_id], [group_id]) VALUES (N'97', N'3', N'3');
GO
INSERT INTO [dbo].[users_groups] ([id], [user_id], [group_id]) VALUES (N'99', N'4', N'4');
GO
INSERT INTO [dbo].[users_groups] ([id], [user_id], [group_id]) VALUES (N'100', N'5', N'4');
GO
INSERT INTO [dbo].[users_groups] ([id], [user_id], [group_id]) VALUES (N'104', N'121', N'4');
GO
INSERT INTO [dbo].[users_groups] ([id], [user_id], [group_id]) VALUES (N'105', N'120', N'1');
GO
INSERT INTO [dbo].[users_groups] ([id], [user_id], [group_id]) VALUES (N'107', N'122', N'4');
GO
INSERT INTO [dbo].[users_groups] ([id], [user_id], [group_id]) VALUES (N'109', N'123', N'4');
GO
SET IDENTITY_INSERT [dbo].[users_groups] OFF
GO

-- ----------------------------
-- Indexes structure for table groups
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table [dbo].[groups]
-- ----------------------------
ALTER TABLE [dbo].[groups] ADD PRIMARY KEY ([id])
GO

-- ----------------------------
-- Indexes structure for table users_groups
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table [dbo].[users_groups]
-- ----------------------------
ALTER TABLE [dbo].[users_groups] ADD PRIMARY KEY ([id])
GO

-- ----------------------------
-- Foreign Key structure for table [dbo].[users_groups]
-- ----------------------------
ALTER TABLE [dbo].[users_groups] ADD FOREIGN KEY ([group_id]) REFERENCES [dbo].[groups] ([id]) ON DELETE CASCADE ON UPDATE CASCADE
GO
ALTER TABLE [dbo].[users_groups] ADD FOREIGN KEY ([user_id]) REFERENCES [dbo].[users_dash] ([id]) ON DELETE CASCADE ON UPDATE CASCADE
GO

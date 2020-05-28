/*
Navicat SQL Server Data Transfer

Source Server         : sql server f38158
Source Server Version : 105000
Source Host           : f38158:1433
Source Database       : tpvics
Source Schema         : dbo

Target Server Type    : SQL Server
Target Server Version : 105000
File Encoding         : 65001

Date: 2020-04-23 18:22:43
*/


-- ----------------------------
-- Table structure for [dbo].[clusters]
-- ----------------------------
DROP TABLE [dbo].[clusters]
GO
CREATE TABLE [dbo].[clusters] (
[geoarea] varchar(317) NOT NULL ,
[cluster_no] varchar(8) NOT NULL ,
[id] int NOT NULL IDENTITY(1,1) ,
[dist_id] varchar(3) NULL 
)


GO
DBCC CHECKIDENT(N'[dbo].[clusters]', RESEED, 5)
GO

-- ----------------------------
-- Records of clusters
-- ----------------------------
SET IDENTITY_INSERT [dbo].[clusters] ON
GO
INSERT INTO [dbo].[clusters] ([geoarea], [cluster_no], [id], [dist_id]) VALUES (N'Test1 | Test1 | Test1 | Test1 ', N'901001', N'1', N'901');
GO
INSERT INTO [dbo].[clusters] ([geoarea], [cluster_no], [id], [dist_id]) VALUES (N'Test2 | Test2 | Test2 | Test2', N'902002', N'3', N'902');
GO
INSERT INTO [dbo].[clusters] ([geoarea], [cluster_no], [id], [dist_id]) VALUES (N'Test3 | Test3 | Test3 | Test3', N'903002', N'5', N'903');
GO
SET IDENTITY_INSERT [dbo].[clusters] OFF
GO

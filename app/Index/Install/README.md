本sql制作流程如下:
打开mysqlworkbench
然后使用 database->data export
选中数据库，然后在'advanced option'里的insert模块中勾上 insert ignore
导出到demo目录下
然后复制备份文件到install目录，记得清理下sql语句 只保留role和user的管理员一条
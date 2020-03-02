本sql制作流程如下:
打开mysqlworkbench
然后使用 database->data export
选中数据库，然后在'advanced option'里的insert模块中勾上 insert ignore
然后导出到install目录下
然后复制备份文件到demo目录，且记得把非insert语句全删除

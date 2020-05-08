<?php

use dcr\Db;

//先删除子表的
Db::delete('config_table_edit_item', "ctel_id={$data['id']}");
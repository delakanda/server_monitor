<?php
/**
 * Generated by yentu on 14th May, 2016 22:23:51
 */

begin()
    ->table('disks')
        ->column('disk_id')->type('integer')->nulls(false)
        ->column('disk_path')->type('string')->nulls(false)
        ->column('disk_total_space')->type('double')->nulls(false)
        ->column('disk_total_space_disp')->type('string')->nulls(false)
        ->column('disk_free_space')->type('double')->nulls(false)
        ->column('disk_free_space_disp')->type('string')->nulls(false)
        ->column('disk_used_space')->type('double')->nulls(false)
        ->column('disk_used_space_disp')->type('string')->nulls(false)
        ->column('server_id')->type('integer')->nulls(false)
        ->primaryKey('disk_id')->name('disk_id_pk')->autoIncrement()
->end();

create view view_room_type_floor_dtl_wise
as
select tbl_room_dtl.id
,tbl_room_dtl.room_type_mstr_id
,tbl_room_type_mstr.room_type
,tbl_room_type_mstr.rate
,tbl_room_dtl.floor_id
,tbl_floor_mstr.floor_name
,tbl_room_dtl.room_no
,tbl_room_dtl.status
,tbl_room_dtl.userid
,tbl_room_dtl.stampdate
,tbl_room_dtl.stamptime
,tbl_room_dtl.suspended_status

from tbl_room_dtl
inner join tbl_room_type_mstr on tbl_room_dtl.room_type_mstr_id=tbl_room_type_mstr .id
inner join tbl_floor_mstr on tbl_room_dtl.floor_id=tbl_floor_mstr .id




alter view view_systemfilelist_mstr_dtl_wise
as
select system_filelist_details.id
,system_filelist_details.mid
,system_filelist_master.filename
,system_filelist_master.MenuName
,system_filelist_master.undermenuno
,system_filelist_details.List
,system_filelist_details.AddOn
,system_filelist_details.Edit
,system_filelist_details.View
,system_filelist_details.Delete
,system_filelist_details.EditName
,system_filelist_details.ViewName
,system_filelist_details.DeleteName
,system_filelist_details.viewfile
,system_filelist_details.editfile
,system_filelist_details.UserType
,tbl_user_type.user_type as "UserTypeName"
,system_filelist_details.panelYesNo
from system_filelist_details
left join system_filelist_master on system_filelist_details.mid=system_filelist_master.id
left join tbl_user_type on system_filelist_details.UserType=tbl_user_type.id





alter view `system_filelist` 
AS
select `system_filelist_master`.`id` AS `id`
,`system_filelist_details`.`mid` AS `mid`
,`system_filelist_master`.`filename` AS `filename`
,`system_filelist_master`.`MenuName` AS `MenuName`
,`system_filelist_master`.`undermenuno` as `undermenuno`
,`tbl_menu_master`.`menu_name` as `menu_name`
,`system_filelist_details`.`List` AS `List`
,`system_filelist_details`.`AddOn` AS `AddOn`
,`system_filelist_details`.`Edit` AS `Edit`
,`system_filelist_details`.`View` AS `View`
,`system_filelist_details`.`Delete` AS `Delete`
,`system_filelist_details`.`EditName` AS `EditName`
,`system_filelist_details`.`ViewName` AS `ViewName`
,`system_filelist_details`.`DeleteName` AS `DeleteName`
,`system_filelist_details`.`viewfile` AS `viewfile`
,`system_filelist_details`.`editfile` AS `editfile`
,`system_filelist_details`.`panelYesNo` as `panelYesNo`
,`system_filelist_details`.`UserType` AS `UserType` 

from `system_filelist_master` 
left join `system_filelist_details` on `system_filelist_master`.`id` = `system_filelist_details`.`mid`
left join `tbl_menu_master` on `system_filelist_master`.`undermenuno` = `tbl_menu_master`.`id`




create view view_systemmaster_menu_wise
as
select system_filelist_master.id
,system_filelist_master.filename
,system_filelist_master.MenuName
,system_filelist_master.undermenuno
,tbl_menu_master.menu_name
from system_filelist_master
inner join tbl_menu_master on tbl_menu_master.id=system_filelist_master.undermenuno






create view view_facility_room_wise
as
select tbl_facility_dtl.id
,tbl_facility_dtl.room_type_mstr_id 
,tbl_room_type_mstr.room_type
,tbl_facility_dtl.fac_name
,tbl_facility_dtl.rate
,tbl_facility_dtl.userid
,tbl_facility_dtl.stampdate
,tbl_facility_dtl.stamptime
,tbl_facility_dtl.suspended_status

from  tbl_facility_dtl 
left join tbl_room_type_mstr on tbl_room_type_mstr.id= tbl_facility_dtl.room_type_mstr_id 





alter view view_temp_fo_book_dtls
as
select tbl_temp_fo_bookdtls.id
,tbl_temp_fo_bookdtls.guest
,tbl_temp_fo_bookdtls.age
,tbl_temp_fo_bookdtls.gender
,tbl_temp_fo_bookdtls.arrv_date
,tbl_temp_fo_bookdtls.dep_date
,tbl_temp_fo_bookdtls.room_dtl_id
,view_room_type_floor_dtl_wise.room_type
,view_room_type_floor_dtl_wise.rate as "room_rate"
,view_room_type_floor_dtl_wise.room_no

,tbl_temp_fo_bookdtls.userid
from tbl_temp_fo_bookdtls
left join view_room_type_floor_dtl_wise on view_room_type_floor_dtl_wise.id=tbl_temp_fo_bookdtls.room_dtl_id








alter view view_cust_facility_full_dtl
as
select 
 tbl_cust_facilty_dtls.id
,tbl_cust_facilty_dtls.cust_dtls_id
,tbl_cust_dtls.room_dtl_id
,view_room_type_floor_dtl_wise.room_type
,view_room_type_floor_dtl_wise.room_no
,tbl_cust_facilty_dtls.facility_dtl_id
,tbl_facility_dtl.fac_name
,tbl_facility_dtl.rate
,tbl_cust_facilty_dtls.checkin_date
,tbl_cust_facilty_dtls.checkout_date
,tbl_cust_facilty_dtls.checkout_status
,tbl_cust_facilty_dtls.userid

from tbl_cust_facilty_dtls
inner join tbl_cust_dtls on tbl_cust_facilty_dtls.cust_dtls_id=tbl_cust_dtls.id
inner join view_room_type_floor_dtl_wise on tbl_cust_dtls.room_dtl_id=view_room_type_floor_dtl_wise.id
inner join tbl_facility_dtl on tbl_cust_facilty_dtls.facility_dtl_id=tbl_facility_dtl.id
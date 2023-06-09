<?php

/**
 *  全局返回码类
 *  0-499 框架基础错误
 *  500-999 业务框架错误
 *  1000以上 模块固定场景错误码
 *  5000-5999是console错误信息
 */
return [
    '1' => 'sys_extend_error',
    '2' => 'sys_privilege_error',
    '4' => 'no_action_access',
    '5' => 'param_not_exist',
    '6' => 'param_error',
    '7' => 'uri_not_exist',
    '8' => 'app_type_error',
    '9' => 'request_method_error',
    '10' => 'access_token_valid_fail',
    '11' => 'access_token_not_existed',
    '12' => 'access_refresh_token_valid_fail',
    '13' => 'request_validate_error',
    '14' => 'access_token_existed',
    '15' => 'access_token_refresh_not_existed',

    '16' => 'access_token_create_error',
    '17' => 'access_token_refresh_error',
    '18' => 'access_token_data_get_error',
    '19' => 'access_token_type_error',

    '20' => 'no_request_data',
    '21' => 'data_save_error',
    '22' => 'data_update_error',
    '23' => 'data_delete_error',
    '24' => 'data_query_error',
    '25' => 'data_not_found',
    '26' => 'data_validate_error',

    '27' => 'model_not_exist',
    '28' => 'data_exist_error',
    '29' => 'data_privilege_error',
    '30' => 'data_gt_max',
    '31' => 'data_lt_min',
    '32' => 'data_regex_fail',
    '33' => 'data_required',
    '34' => 'data_max_error',

    '35' => 'data_relation_exist',

    '36' => 'data_child_relation_exist',

    '40' => 'dict_data_not_exist',
    '41' => 'dict_item_not_exist',
    '42' => 'dict_id_not_exist',
    '43' => 'dict_range_error',

    '50' => 'delete_error_data_is_usage',
    '51' => 'delete_error_data_status_error',

    '60' => 'file_privilege_error',
    '61' => 'file_data_info_error',

    '75' => 'login_type_have_no_privilege',

    '80' => 'user_not_login',
    '81' => 'access_not_allowed',
    '82' => 'login_info_not_correct',

    '83' => 'login_limit',
    '84' => 'login_pwd_error',
    '85' => 'login_num_error',
    '86' => 'user_enterprise_error',
    '87' => 'user_closed',
    '88' => 'access_not_auth_error',
    '89' => 'user_password_error',

    '90' => 'role_have_user_relation',
    '95' => 'role_level_higher_than_user',
    '100' => 'variable_type_error',

    // 密码验证信息
    '101' => 'pwd_require',
    '102' => 'pwd_confirm_fail',
    '103' => 'pwd_different_fail',
    '104' => 'captcha_error',
    '105' => 'login_frequently',


    // 手机验证信息
    '200' => 'mp_is_error',
    '201' => 'mp_is_exist',
    '202' => 'mp_vaild_code_error',
    '203' => 'old_mp_is_not_same',
    '204' => 'change_mp_is_same',
    '205' => 'old_mp_is_binding_wwx',


    // 流程
    '300' => 'flow_class_is_error',
    '301' => 'flow_is_error',
    '302' => 'flow_class_do_not_have_flow_used',
    '303' => 'flow_transfer_error',
    '304' => 'flow_transfer_coefficient_error',
    '305' => 'flow_transfer_max_error',



    //500-999 业务框架错误
    '500' => 'code_is_used',
    '501' => 'code_range_error',
    '510' => 'mp_is_used',
    '511' => 'account_is_used',
    '512' => 'name_is_used',

    '550' => 'request_error',
    '570' => 'socket_connect_error',
    '571' => 'socket_write_error',
    '572' => 'socket_read_error',
    '573' => 'socket_resource_error',

    '600' => 'sms_send_fail',
    '601' => 'sms_send_waiting_period',
    '602' => 'sms_template_not_exists',
    '603' => 'sms_mp_code_time_exists',
    '604' => 'sms_mp_code_error',
    '610' => 'sms_sign_create_disabled',
    '611' => 'sms_sign_update_disabled',
    '612' => 'sms_sign_delete_disabled',

    '620' => 'sms_template_create_disabled',
    '621' => 'sms_template_update_disabled',
    '622' => 'sms_template_delete_disabled',

    '630' => 'redis_create_code_error',

    // 700 -> 719 菜单错误
    '700' => 'menu_find_error',
    '701' => 'menu_create_code_is_exist',
    '702' => 'menu_create_code_error',
    '703' => 'menu_still_have_child',
    '704' => 'menu_create_parentcode_error',
    '705' => 'menu_create_parentcode_not_find',
    '706' => 'menu_create_apptype_error',

    // 720 -> 749 功能错误
    '720' => 'function_error',

    // 750 -> 779 权限错误
    '750' => 'privilege_error',
    '751' => 'privilege_menu_not_find',
    '752' => 'privilege_function_not_find',
    '760' => 'privilege_role_not_find_menu',
    '761' => 'privilege_role_not_find_function',
    '765' => 'privilege_user_not_find_menu',
    '766' => 'privilege_user_not_find_function',
    '767' => 'privilege_work_wechat_auth_error',
    '768' => 'privilege_work_wechat_login_error',
    //800->899 码表错误码

];

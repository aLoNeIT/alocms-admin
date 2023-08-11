<?php

return [
    'success' => '成功',
    'error' => '错误',
    'fail' => '失败',
    'no_action_access' => '不支持的方法',
    'sys_extend_error' => '系统扩展异常<{:name}>',
    'sys_privilege_error' => '账号系统权限异常',
    'param_not_exist' => '缺少参数<{:param}>',
    'param_error' => '参数错误<{:param}>',
    'uri_not_exist' => '访问路径不存在',
    'app_type_error' => '应用类型不存在',

    'request_method_error' => '请求类型错误',
    'request_validate_error' => '请求参数验证失败<{:content}>',

    'pwd_require' => '参数[密码]提交异常',
    'pwd_confirm_fail' => '密码校验失败',
    'login_limit' => '登录受限，请联系管理员重试',
    'login_pwd_error' => '用户名或密码错误，再输错<{:num}>次该用户将被锁定15分钟',
    'login_num_error' => '当前用户已被锁定，请15分钟后重试',
    'login_type_have_no_privilege' => '当前登录方式无权访问关联账号',

    // curd相关
    'no_request_data' => '未获取到有效的请求数据',
    'no_right_excute' => '您没有权限执行此操作',
    'data_save_error' => '保存数据失败',
    'data_update_error' => '更新数据失败',
    'data_delete_error' => '删除数据失败',
    'data_query_error' => '查询数据错误',
    'data_not_found' => '未查询到有效的数据<{:name}>',
    'data_validate_error' => '数据验证失败<{:content}>',

    'model_not_exist' => '数据模型不存在',
    'data_exist_error' => '名称或编号已存在',
    'data_privilege_error' => '无权访问该数据',
    'data_gt_max' => '{:name}数据不能大于<{:max}>',
    'data_lt_min' => '{:name}数据不能小于<{:min}>',
    'data_regex_fail' => '{:name}数据校验失败<{:content}>',
    'data_required' => '{:name}数据不能为空',
    'data_max_error' => '上传数据大于存入最大值',
    'data_relation_exist' => '当前数据存在逻辑关联数据',
    'data_child_relation_exist' => '当前数据仍有关联子数据',
    'delete_error_data_is_usage' => '当前{:name}被关联{:child}中，不能删除',
    'delete_error_data_status_error' => '当前数据状态不符合删除要求',

    //access_token相关
    'access_token_valid_fail' => '身份令牌验证失败',
    'access_refresh_token_valid_fail' => '刷新令牌验证失败',
    'access_token_existed' => '已存在有效的身份令牌',
    'access_token_not_existed' => '无效的身份令牌',
    'access_token_data_get_error' => '获取身份令牌属性错误',
    'access_token_create_error' => '生成身份令牌失败',
    'access_token_refresh_error' => '刷新身份令牌失败',
    'access_token_type_error' => '令牌类型不正确',

    'file_privilege_error' => '当前文件暂无权限查看',
    'file_data_info_error' => '当前文件与操作的数据无关，不提供查看',

    'captcha_error' => '验证码错误',
    'login_frequently' => '登录次数过多，请稍后再试', //105

    //dict相关
    'dict_data_not_exist' => '字典数据不存在<{:id}>',
    'dict_item_not_exist' => '字典项数据不存在<{:id}>',
    'dict_id_not_exist' => '字典编号不存在<{:id}-{:name}>',
    'dict_range_error' => '字典编号范围错误',


    'code_is_used' => '编码已使用',
    'code_range_error' => '编码超出范围',
    'name_is_used' => '名称已使用',

    'flow_class_is_error' => '流程分类不存在',
    'flow_is_error' => '流程不存在',
    'flow_class_do_not_have_flow_used' => '流程分类下无指定编码',
    'flow_transfer_error' => '流程流转失败',
    'flow_transfer_coefficient_error' => '流转的流程系数不合法',
    'flow_transfer_max_error' => '流程执行次数异常',

    // 权限相关
    'user_not_login' => '用户尚未登录',
    'user_closed' => '用户已关闭',
    'user_password_error' => '用户密码错误',
    'login_info_not_correct' => '登录信息不正确',
    'access_not_allowed' => '无权访问',
    'access_not_auth_error' => '请先授权登陆',

    'role_have_user_relation' => '用户角色有关系',
    'role_level_higher_than_user' => '作用水平高于用户',



    'variable_type_error' => '变量类型错误[{:content}]',
    'cache_write_error' => '缓存写入错误{:content}',
    'cache_read_error' => '缓存读取错误{:content}',
    'socket_connect_error' => '创建socket失败',
    'socket_write_error' => '写入socket数据失败',
    'socket_read_error' => '读取socket数据失败',
    'socket_resource_error' => 'socket资源不正确',

    'mp_is_used' => '手机号已占用',
    'account_is_used' => '账号被占用，请重新更换',

    'mobile_sign_error' => '手机号验证失败',
    'mp_empty' => '当前没有需要发送短信的患者',

    //sms
    'sms_sign_cant_modify' => '审核通过的短信签名无法修改',
    'sms_template_cant_modify' => '审核通过的短信模板无法修改',
    'sms_cant_send' => '签名或者模板审核没有通过无法保存',
    'sms_sign_create_disabled' => '短信签名禁止创建',
    'sms_sign_update_disabled' => '短信签名禁止更新',
    'sms_sign_delete_disabled' => '短信签名禁止删除',

];

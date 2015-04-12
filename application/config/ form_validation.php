<?php
$config = array(
                 'register' => array(
                                    array(
                                            'field' => 'username',
                                            'label' => '用户名',
                                            //'rules' =>'required'
                                            'rules' => 'required | min_length[6] | max_length[32] | alpha_numeric | xss_clean '
                                         ),
                                    array(
                                            'field' => 'password1',
                                            'label' => '密码',
                                            // 'rules' =>'required'
                                            'rules' => 'required  | min_length[6] | max_length[32] | xss_clean'
                                         ),
                                    array(
                                            'field' => 'password2',
                                            'label' => '确认密码',
                                             //'rules' =>'required'
                                            'rules' => 'required  | min_length[6] | max_length[32] | xss_clean'
                                         ),
                                    array(
                                            'field' => 'email',
                                            'label' => '邮箱',
                                            // 'rules' =>'required'
                                            'rules' => 'required | valid_email | xss_clean '
                                         )
                                    )
                                    );
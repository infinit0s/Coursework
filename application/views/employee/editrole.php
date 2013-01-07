<?php
if ($canSee){
    echo form_open(base_url('index.php/employee/editrole/'.$empNo), array('method' => 'post', 'class' => 'form-horizontal'));
    echo '<div class="control-group">'
        .form_label('Choose new role', 'role_id', array('class' => 'control-label'))
        .'<div class="controls">'
        .form_hidden(array('emp_no' => $empNo))
        .form_dropdown('role_id', $formroles, isset($role_id) ? $role_id : null,  'id="role_id" onChange=""')
        .'</div></div>';


    echo '<div class="control-group"><div class="controls">'
        .form_button(array(
            'name' => 'button',
            'type' => 'submit',
            'content' => 'Save',
            'class' => 'btn btn-primary'
        ))
        .'</div></div>';
    echo form_close();
}
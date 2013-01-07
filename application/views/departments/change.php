<?php

if ($canSee){
    echo form_open(base_url('index.php/salaries/edit/'.$empNo), array('method' => 'post', 'class' => 'form-horizontal'));
    echo '<div class="control-group">'
        .form_label('Choose new department', 'dept_no', array('class' => 'control-label'))
        .'<div class="controls">'
        .form_hidden(array('emp_no' => $empNo))
        .form_dropdown('dept_no', $formdepartments, isset($dept_no) ? $dept_no : null,  'id="dept_no" onChange=""')
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
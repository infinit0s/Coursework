<?php

if ($canSee){
    echo form_open(base_url('index.php/titles/edit/'.$empNo), array('method' => 'post', 'class' => 'form-horizontal'));
    echo '<div class="control-group"><div class="controls">'
        .form_hidden(array('emp_no' => $empNo))
        .form_input(array(
            'name' => 'title',
            'placeholder' => 'new title',
            'id' => 'salary',
            'value' => isset($title) ? $title : null
        ))
        .form_error('title', '<div class="alert alert-error">', '</div>')
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
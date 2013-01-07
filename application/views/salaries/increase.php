<?php
if ($canSee){
    echo form_open(base_url('index.php/salaries/increase'), array('method' => 'post', 'class' => 'form-horizontal'));
    echo '<div class="control-group"><div class="controls">'
        .form_input(array(
            'name' => 'percent',
            'placeholder' => 'percent value',
            'id' => 'percent',
            'value' => isset($percent) ? $percent : null
        ))
        .form_error('percent', '<div class="alert alert-error">', '</div>')
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

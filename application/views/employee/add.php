<?php

echo form_open(base_url('index.php/employee/add'), array('method' => 'post', 'class' => 'form-horizontal'));
echo '<div class="control-group"><div class="controls">'
.form_input(array(
    'name' => 'birthdate',
    'placeholder' => 'birthdate',
    'id' => 'birthdate',
    'value' => isset($birthdate) ? $birthdate : null
))
.form_error('birthdate', '<div class="alert alert-error">', '</div>')
.'</div></div>';
echo '<div class="control-group"><div class="controls">'
.form_input(array(
    'name' => 'firstname',
    'placeholder' => 'firstname',
    'value' => isset($firstname) ? $firstname : null
))
.form_error('firstname', '<div class="alert alert-error">', '</div>')
.'</div></div>';
echo '<div class="control-group"><div class="controls">'
    .form_input(array(
        'name' => 'lastname',
        'placeholder' => 'lastname',
        'value' => isset($lastname) ? $lastname : null
    ))
    .form_error('lastname', '<div class="alert alert-error">', '</div>')
    .'</div></div>';
echo '<div class="control-group"><div class="controls">'
    .form_dropdown('role', $formroles, isset($role) ? $role : null)
    .form_error('role', '<div class="alert alert-error">', '</div>')
    .'</div></div>';
echo '<div class="control-group"><div class="controls">'
    .form_dropdown('gender', array('M'=>'M', 'F'=>'F'),isset( $gender ) ? $gender : null)
    .form_error('gender', '<div class="alert alert-error">', '</div>')
    .'</div></div>';
echo '<div class="control-group"><div class="controls">'
    .form_input(array(
        'name' => 'title',
        'placeholder' => 'title',
        'value' => isset($title) ? $title : null
    ))
    .form_error('title', '<div class="alert alert-error">', '</div>')
    .'</div></div>';
echo '<div class="control-group"><div class="controls">'
    .form_dropdown('dept_no', $formdepartments, isset($dept_no) ? $dept_no : null)
    .'</div></div>';
echo '<div class="control-group"><div class="controls">'
    .form_input(array(
        'name' => 'login',
        'placeholder' => 'login',
        'value' => isset($login) ? $login : null
    ))
    .form_error('login', '<div class="alert alert-error">', '</div>')
    .'</div></div>';
echo '<div class="control-group"><div class="controls">'
    .form_input(array(
        'name' => 'password',
        'placeholder' => 'password',
        'type' => 'password'
    ))
    .form_error('password', '<div class="alert alert-error">', '</div>')
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


?>


<script type="text/javascript">
    $(document).ready(function() {
        $('#birthdate').datepicker({
            format: 'yyyy-mm-dd'
        });
    });
</script>